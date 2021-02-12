<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Category;
use App\Models\TimeBlock;
use App\Services\TimeBlockStat;

class StatController extends Controller
{
    public function index()
    {
        return view('stat.index')->with(TimeBlockStat::getStat(Auth::id()));
    }
}
