<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\TimeBlock;

use App\Services\CategoryService;

use App\Http\Requests\TimeBlockRequest;

class TimeBlockController extends Controller
{
    
    public function index()
    {
        $models = TimeBlock::forUser(Auth::id())->orderBy('block_date', 'desc')
                ->paginate(env('PAGINATION_PAGE_SIZE_FOR_TIME_BLOCKS', 20));
        
        $isCategoryExists = CategoryService::checkCategoryExists(Auth::id());
        
        return view('time-blocks.index')->with([
            'models' => $models,
            'isCategoryExists' => $isCategoryExists]);
    }

    
    public function create()
    {
        $categories = Category::forUser(Auth::id())->orderBy('name')->get();
        return view('time-blocks.create')->with('categories', $categories);
    }
    
    public function store(TimeBlockRequest $request) 
    {
        $categoryId = $request->input('category_id');
        $category = Category::forUser(Auth::id())->findOrFail($categoryId);
        $model = new TimeBlock();
        $model->user_id = Auth::id();
        $model->category_id = $categoryId;
        $model->description = $request->input('description');
        $model->block_date = $request->input('block_date');
        $model->block_length = $request->input('block_length');
        $model->save();
        return redirect()->route('time-block-index')
                ->with('success', 'Запись добавлена');
    }
    
    public function show($id) 
    {
        $model = TimeBlock::forUser(Auth::id())->findOrFail($id);
        return view('time-blocks.show')->with('model', $model);
    }

    public function destroy($id) 
    {
        $model = TimeBlock::forUser(Auth::id())->findOrFail($id);
        $model->delete();
        return redirect()->route('time-block-index')
                ->with('success', 'Задача удалена');
    }
    
    
    public function edit($id)
    {
        $categories = Category::forUser(Auth::id())->orderBy('name')->get();
        $model = TimeBlock::forUser(Auth::id())->findOrFail($id);
        return view('time-blocks.edit')->with([
            'model' => $model,
            'categories' => $categories
        ]);
    }

    public function update(TimeBlockRequest $request, $id) 
    {
        $categoryId = $request->input('category_id');
        $category = Category::forUser(Auth::id())->findOrFail($categoryId);
        $model = TimeBlock::forUser(Auth::id())->findOrFail($id);
        $model->category_id = $category->id;
        $model->description = $request->input('description');
        $model->block_date = $request->input('block_date');
        $model->block_length = $request->input('block_length');
        $model->save();
        return redirect()->route('time-block-show', $model->id)
                ->with('success', 'Изменения сохранены');
    }
}
