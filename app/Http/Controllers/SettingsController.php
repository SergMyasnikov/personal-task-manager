<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Http\Requests\SettingsRequest;

class SettingsController extends Controller
{
    public function edit()
    {
        $model = User::find(Auth::id());
        return view('settings.edit')->with(['model' => $model]);
    }
    
    public function update(SettingsRequest $request) 
    {
        $model = User::find(Auth::id());
        $model->stat_period_length = $request->input('stat_period_length');
        if (is_null($request->input('is_use_start_date'))) {
            $model->stat_period_start_date = null;
        }
        else {
            $model->stat_period_start_date = 
                    $request->input('stat_period_start_date');
        }
        $model->save();
        return redirect()->route('settings-edit')
                ->with('success', 'Изменения сохранены');
    }
}
