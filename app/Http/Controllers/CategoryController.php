<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Category;
use App\Models\Subcategory;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;

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
        $categoryName = $request->input('name');
        $target_percentage = $request->input('target_percentage');
        $userId = Auth::id();
        
        try {
            CategoryService::createCategory($userId, $categoryName, $target_percentage);        
        }
        catch (\App\Exceptions\CategoryNameAlreadyExistsException $e) {
            return redirect()->route('category-create')->withErrors(
                ['Категория с указанным именем уже существует']);            
        }

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
        $model = Category::findOrFail($id);
        if ($model->user_id != Auth::id()) {
            abort(404);
        }
        
        $error = '';
        try {
            CategoryService::deleteCategory($model);
        }
        catch (\App\Exceptions\RemovingCategoryHasChildSubcategoriesException $e) {
            $error = 'Удаление категории невозможно, так как существуют зависимые от нее подкатегории';
        }
        catch (\App\Exceptions\RemovingCategoryHasChildTasksException $e) {
            $error = 'Удаление категории невозможно, так как существуют зависимые от нее задачи';
        }
        catch (\App\Exceptions\RemovingCategoryHasChildTimeBlocksException $e) {
            $error = 'Удаление категории невозможно, так как существуют зависимые от нее записи журнала';
        }
        
        if ($error != '') {
            return redirect()->route('category-show', $id)->withErrors([$error]);
        }
        
        return redirect()->route('category-index')
                ->with('success', 'Категория удалена');
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
