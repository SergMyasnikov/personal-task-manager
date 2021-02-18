<?php

namespace App\Services;

use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;

class SubcategoryService {
    public static function deleteSubcategory(Subcategory $model) 
    {
        if ($model->is_default == 1) {
            throw new \App\Exceptions\DirectlyRemovingDefaultSubcategoryException();
        }
        if ((count($model->tasks) > 0)) {
            throw new \App\Exceptions\RemovingSubcategoryHasChildTasksException();
        }
        $model->delete();
    }
    
}
