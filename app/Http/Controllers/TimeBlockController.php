<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\TimeBlock;
use App\Http\Requests\TimeBlockRequest;

class TimeBlockController extends Controller
{
    
    public function index()
    {
        $models = TimeBlock::orderBy('block_date', 'desc')->where('user_id', '=', Auth::id())
                ->paginate(env('PAGINATION_PAGE_SIZE_FOR_TIME_BLOCKS', 20));
        return view('time-blocks.index')->with('models', $models);
    }

    
    public function create()
    {
        $categories = Category::orderBy('name')->where('user_id', '=', Auth::id())->get();
        return view('time-blocks.create')->with('categories', $categories);
    }
    
    public function store(TimeBlockRequest $request) 
    {
        $categoryId = $request->input('category_id');
        $category = Category::find($categoryId);
        if (is_null($category) || ($category->user_id != Auth::id())) {
            abort(404);
        }
        
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
        $model = TimeBlock::find($id);
        if (!is_null($model) && ($model->user_id == Auth::id())) {
            return view('time-blocks.show')->with('model', $model);
        }
        else {
            abort(404);
        }
    }

    public function destroy($id) 
    {
        $model = TimeBlock::find($id);
        if (!is_null($model) && ($model->user_id == Auth::id())) {
            $model->delete();
            return redirect()->route('time-block-index')
                    ->with('success', 'Задача удалена');
        }
        else {
            abort(404);
        }
    }
    
    
    public function edit($id)
    {
        $categories = Category::orderBy('name')->where('user_id', '=', Auth::id())->get();
        $model = TimeBlock::find($id);
        if (is_null($model) || ($model->user_id != Auth::id())) {
            abort(404);
        }
        return view('time-blocks.edit')->with([
            'model' => $model,
            'categories' => $categories
        ]);
    }

    public function update(TimeBlockRequest $request, $id) 
    {
        $categoryId = $request->input('category_id');
        $category = Category::find($categoryId);
        if (is_null($category) || ($category->user_id != Auth::id())) {
            abort(404);
        }
        $model = TimeBlock::find($id);
        if (!is_null($model) && ($model->user_id == Auth::id())) {
            $model->category_id = $categoryId;
            $model->description = $request->input('description');
            $model->block_date = $request->input('block_date');
            $model->block_length = $request->input('block_length');
            $model->save();
            return redirect()->route('time-block-show', $model->id)
                    ->with('success', 'Изменения сохранены');
        }
        else {
            abort(404);
        }
    }
}
