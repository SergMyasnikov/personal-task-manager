<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Subcategory;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $models = Category::orderBy('name')->where('user_id', '=', Auth::id())->get();
        return view('categories.index')->with('models', $models);
    }
    
    public function create()
    {
        return view('categories.create');
    }
    
    public function store(CategoryRequest $request) 
    {
        $model = new Category();

        $categoryName = $request->input('name'); 
        $userId = Auth::id();
        
        $isCategoryExists = $model->where('user_id', '=', $userId)
                ->where('name', '=', $categoryName)->exists();
        
        if ($isCategoryExists) {
            return redirect()->route('category-create')->withErrors([
                'Категория с указанным именем уже существует']);            
        }
        
        $model->user_id = $userId;
        $model->name = $categoryName;
        $model->target_percentage = $request->input('target_percentage');
        $model->save();
        
        $subcategory = new Subcategory();
        $subcategory->name = '-';
        $subcategory->category_id = $model->id;
        $subcategory->user_id = $userId;
        $subcategory->is_default = 1;
        $subcategory->save();
        
        return redirect()->route('category-index')
                ->with('success', 'Категория добавлена');
    }
    
    public function show($id) 
    {
        $model = Category::find($id);
        if (!is_null($model) && ($model->user_id == Auth::id())) {
            return view('categories.show')->with('model', $model);
        }
        else {
            abort(404);
        }
    }
    
    public function destroy($id) 
    {
        $model = Category::find($id);
        if (!is_null($model) && ($model->user_id == Auth::id())) {
            if (count($model->timeBlocks) > 0) {
                return redirect()->route('category-show', $id)->withErrors([
                    'Удаление категории невозможно, так как существуют зависимые от нее записи журнала']);
            }
            if (count($model->subcategories) > 1) {
                return redirect()->route('category-show', $id)->withErrors([
                    'Удаление категории невозможно, так как существуют зависимые от нее подкатегории']);
            }
            if (count($model->subcategories[0]->tasks) > 0) {
                return redirect()->route('category-show', $id)->withErrors([
                    'Удаление категории невозможно, так как существуют зависимые от нее задачи']);
            }
            $model->subcategories[0]->delete();
            $model->delete();
            return redirect()->route('category-index')
                    ->with('success', 'Категория удалена');
        }
        else {
            abort(404);
        }
    }
    
    public function edit($id)
    {
        $model = Category::find($id);
        if (!is_null($model) && ($model->user_id == Auth::id())) {
            return view('categories.edit')->with('model', $model);
        }
        else {
            abort(404);
        }
    }

    public function update(CategoryRequest $request, $id) 
    {
        $model = Category::find($id);
        if (!is_null($model) && ($model->user_id == Auth::id())) {
            $model->name = $request->input('name');
            $model->target_percentage = $request->input('target_percentage');
            $model->save();
            return redirect()->route('category-show', $model->id)
                    ->with('success', 'Изменения сохранены');
        }
        else {
            abort(404);
        }
    }
    
}
