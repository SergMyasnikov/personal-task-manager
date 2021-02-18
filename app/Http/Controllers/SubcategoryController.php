<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Subcategory;

use App\Services\SubcategoryService;

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
        $model->category_id = $category->id;
        $model->name = $request->input('name');
        $model->save();
        return redirect()->route('category-show', $category->id)
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
        $error = '';
        try {
            SubcategoryService::deleteSubcategory($model);
        }
        catch (\App\Exceptions\DirectlyRemovingDefaultSubcategoryException $e) {
            $error = 'Удаление главной подкатегории не допускается';
        }
        catch (\App\Exceptions\RemovingSubcategoryHasChildTasksException $e) {
            $error = 'Удаление подкатегории невозможно, так как существуют зависимые от нее объекты';
        }
        if ($error != '') {
            return redirect()->route('subcategory-show', $id)->withErrors([$error]);
        }
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
