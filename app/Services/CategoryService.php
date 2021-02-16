<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;

class CategoryService {
    public static function createCategory($userId, $categoryName, $target_percentage) 
    {
        $isCategoryExists = Category::where('user_id', '=', $userId)
                ->where('name', '=', $categoryName)->exists();
        
        if ($isCategoryExists) {
            throw new \App\Exceptions\CategoryNameAlreadyExistsException();
        }
        
        DB::transaction(function() use ($userId, $categoryName, $target_percentage) 
        {
            $model = new Category();
            $model->user_id = $userId;
            $model->name = $categoryName;
            $model->target_percentage = $target_percentage;
            $model->save();
            $subcategory = new Subcategory();
            $subcategory->name = '-';
            $subcategory->category_id = $model->id;
            $subcategory->user_id = $userId;
            $subcategory->is_default = 1;
            $subcategory->save();
        });        
    }
    
    public static function deleteCategory(Category $model)
    {
        if (count($model->timeBlocks) > 0) {
            throw new \App\Exceptions\RemovingCategoryHasChildTimeBlocksException();
        }
        if (count($model->subcategories) > 1) {
            throw new \App\Exceptions\RemovingCategoryHasChildSubcategoriesException();
        }
        if (count($model->subcategories[0]->tasks) > 0) {
            throw new \App\Exceptions\RemovingCategoryHasChildTasksException();
        }
        DB::transaction(function() use ($model) {
            $model->subcategories[0]->delete();
            $model->delete();
        });
    }
}
