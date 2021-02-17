<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Task;
use App\Http\Requests\TaskRequest;


class TaskController extends Controller
{
    public function index()
    {
        $categories = Category::forUser(Auth::id())->orderBy('name')->get();
        
        $models = Task::forUser(Auth::id())->orderBy('priority', 'desc')
                ->paginate(env('PAGINATION_PAGE_SIZE_FOR_TASKS', 20));

        return view('tasks.index', [
            'models' => $models,
            'categories' => $categories
        ]);
    }

    public function create(Request $request)
    {
        $category_id = intval($request->input('category_id', 0));
        $category = Category::forUser(Auth::id())->findOrFail($category_id);
        return view('tasks.create')->with('category', $category);
    }
    
    public function store(TaskRequest $request) 
    {
        $subcategoryId = $request->input('subcategory_id');
        $subcategory = Subcategory::forUser(Auth::id())->findOrFail($subcategoryId);
        $model = new Task();
        $model->user_id = Auth::id();
        $model->subcategory_id = $subcategoryId;
        $model->description = $request->input('description');
        $model->priority = $request->input('priority');
        $model->comment = $request->input('comment') ?? '';
        $model->save();
        return redirect()->route('task-index')
                ->with('success', 'Задача добавлена');
    }
    
    public function show($id) 
    {
        $model = Task::forUser(Auth::id())->findOrFail($id);
        return view('tasks.show')->with('model', $model);
    }

    public function destroy($id) 
    {
        $model = Task::forUser(Auth::id())->findOrFail($id);
        $model->delete();
        return redirect()->route('task-index')
                ->with('success', 'Задача удалена');
    }

    public function edit($id)
    {
        $model = Task::forUser(Auth::id())->findOrFail($id);
        return view('tasks.edit')->with('model',$model);
    }

    public function update(TaskRequest $request, $id) 
    {
        $subcategoryId = $request->input('subcategory_id');
        $subcategory = Subcategory::forUser(Auth::id())->findOrFail($subcategoryId);
        $model = Task::forUser(Auth::id())->findOrFail($id);
        $model->subcategory_id = $subcategory->id;
        $model->description = $request->input('description');
        $model->priority = $request->input('priority');
        $model->comment = $request->input('comment') ?? '';
        $model->save();
        return redirect()->route('task-show', $model->id)
                ->with('success', 'Изменения сохранены');
    }
}
