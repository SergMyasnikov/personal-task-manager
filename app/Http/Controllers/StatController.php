<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Category;
use App\Models\TimeBlock;

use App\Services\TimeBlockStat;
use App\Services\CategoryService;

class StatController extends Controller
{
    public function index()
    {
        $errors = [];
        if (!CategoryService::checkCategorySum(Auth::id())) {
            $errors []= 'Сумма значений целевого процента по всем категориям пользователя не равняется 100';
        }
        return view('stat.index')->with(TimeBlockStat::getStat(Auth::id()))->withErrors($errors);
    }
}
