<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimeBlockController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('task-index');
    }
    else {
        return view('about');
    }    
})->name('home');

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
});

Route::middleware(['auth:sanctum', 'verified'])
        ->get('/categories', CategoryController::class . '@index')
        ->name('category-index');
Route::middleware(['auth:sanctum', 'verified'])
        ->get('/categories/create', CategoryController::class . '@create')
        ->name('category-create');
Route::middleware(['auth:sanctum', 'verified'])
        ->post('/categories/store', CategoryController::class . '@store')
        ->name('category-store');
Route::middleware(['auth:sanctum', 'verified'])
        ->get('/categories/show/{id}', CategoryController::class . '@show')
        ->name('category-show');
Route::middleware(['auth:sanctum', 'verified'])
        ->get('/categories/edit/{id}', CategoryController::class . '@edit')
        ->name('category-edit');
Route::middleware(['auth:sanctum', 'verified'])
        ->post('/categories/update/{id}', CategoryController::class . '@update')
        ->name('category-update');
Route::middleware(['auth:sanctum', 'verified'])
        ->post('/categories/destroy/{id}', CategoryController::class . '@destroy')
        ->name('category-destroy');

// Subcategories

Route::middleware(['auth:sanctum', 'verified'])
        ->get('/subcategories/create/{categoryId}', SubcategoryController::class . '@create')
        ->name('subcategory-create');
Route::middleware(['auth:sanctum', 'verified'])
        ->post('/subcategories/store/{categoryId}', SubcategoryController::class . '@store')
        ->name('subcategory-store');
Route::middleware(['auth:sanctum', 'verified'])
        ->get('/subcategories/show/{id}', SubcategoryController::class . '@show')
        ->name('subcategory-show');
Route::middleware(['auth:sanctum', 'verified'])
        ->get('/subcategories/edit/{id}', SubcategoryController::class . '@edit')
        ->name('subcategory-edit');
Route::middleware(['auth:sanctum', 'verified'])
        ->post('/subcategories/update/{id}', SubcategoryController::class . '@update')
        ->name('subcategory-update');
Route::middleware(['auth:sanctum', 'verified'])
        ->post('/subcategories/destroy/{id}', SubcategoryController::class . '@destroy')
        ->name('subcategory-destroy');

// Tasks

Route::middleware(['auth:sanctum', 'verified'])
        ->get('/tasks', TaskController::class . '@index')
        ->name('task-index');
Route::middleware(['auth:sanctum', 'verified'])
        ->get('/tasks/create', TaskController::class . '@create')
        ->name('task-create');
Route::middleware(['auth:sanctum', 'verified'])
        ->post('/tasks/store', TaskController::class . '@store')
        ->name('task-store');
Route::middleware(['auth:sanctum', 'verified'])
        ->get('/tasks/show/{id}', TaskController::class . '@show')
        ->name('task-show');
Route::middleware(['auth:sanctum', 'verified'])
        ->get('/tasks/edit/{id}', TaskController::class . '@edit')
        ->name('task-edit');
Route::middleware(['auth:sanctum', 'verified'])
        ->post('/tasks/update/{id}', TaskController::class . '@update')
        ->name('task-update');
Route::middleware(['auth:sanctum', 'verified'])
        ->post('/tasks/destroy/{id}', TaskController::class . '@destroy')
        ->name('task-destroy');

// Time Blocks

Route::middleware(['auth:sanctum', 'verified'])
        ->get('/time-blocks', TimeBlockController::class . '@index')
        ->name('time-block-index');
Route::middleware(['auth:sanctum', 'verified'])
        ->get('/time-blocks/create', TimeBlockController::class . '@create')
        ->name('time-block-create');
Route::middleware(['auth:sanctum', 'verified'])
        ->post('/time-blocks/store', TimeBlockController::class . '@store')
        ->name('time-block-store');
Route::middleware(['auth:sanctum', 'verified'])
        ->get('/time-blocks/show/{id}', TimeBlockController::class . '@show')
        ->name('time-block-show');
Route::middleware(['auth:sanctum', 'verified'])
        ->get('/time-blocks/edit/{id}', TimeBlockController::class . '@edit')
        ->name('time-block-edit');
Route::middleware(['auth:sanctum', 'verified'])
        ->post('/time-blocks/update/{id}', TimeBlockController::class . '@update')
        ->name('time-block-update');
Route::middleware(['auth:sanctum', 'verified'])
        ->post('/time-blocks/destroy/{id}', TimeBlockController::class . '@destroy')
        ->name('time-block-destroy');

// Settings

Route::middleware(['auth:sanctum', 'verified'])
        ->get('/settings', SettingsController::class . '@edit')
        ->name('settings-edit');
Route::middleware(['auth:sanctum', 'verified'])
        ->post('/settings/update', SettingsController::class . '@update')
        ->name('settings-update');

// Stat

Route::middleware(['auth:sanctum', 'verified'])
        ->get('/stat', StatController::class . '@index')
        ->name('stat-index');