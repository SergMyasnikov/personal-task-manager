<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Subcategory;
use App\Http\Requests\SubcategoryRequest;


class SubcategoryController extends Controller
{

    public function create($categoryId)
    {
        $category = Category::forUser(Auth::id())->findOrFail($categoryId);
        return view('subcategories.create')->with('category', $category);
    }

    public function store(SubcategoryRequest $request, $categoryId) 
    {
        $category = Category::forUser(Auth::id())->findOrFail($categoryId);
        $model = new Subcategory();
        $model->user_id = Auth::id();
        $model->category_id = $categoryId;
        $model->name = $request->input('name');
        $model->save();
        return redirect()->route('category-show', $categoryId)
                ->with('success', 'Подкатегория добавлена');
    }
    
    public function show($id) 
    {
        $model = Subcategory::forUser(Auth::id())->findOrFail($id);
        return view('subcategories.show')->with('model', $model);
    }
    
    public function destroy($id) 
    {
        $model = Subcategory::forUser(Auth::id())->findOrFail($id);
        if ($model->is_default == 1) {
            return redirect()->route('subcategory-show', $id)->withErrors([
                'Удаление главной подкатегории не допускается']);
        }
        if ((count($model->tasks) > 0)) {
            return redirect()->route('subcategory-show', $id)->withErrors([
                'Удаление подкатегории невозможно, так как существуют зависимые от нее объекты']);
        }
        $model->delete();
        return redirect()->route('category-show', $model->category_id)
                ->with('success', 'Подкатегория удалена');
    }
    
    public function edit($id)
    {
        $model = Subcategory::forUser(Auth::id())->findOrFail($id);
        return view('subcategories.edit')->with('model', $model);
    }

    public function update(SubcategoryRequest $request, $id) 
    {
        $model = Subcategory::forUser(Auth::id())->findOrFail($id);
        $model->name = $request->input('name');
        $model->save();
        return redirect()->route('subcategory-show', $model->id)
                ->with('success', 'Изменения сохранены');
    }
}
