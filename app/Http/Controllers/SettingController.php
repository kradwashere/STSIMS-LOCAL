<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\SchoolSemester;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        return inertia('Modules/Settings/Index');
    }

    public function update(Request $request){
        $data = \DB::transaction(function () use ($request){
            $data = Setting::first();
            $data->update($request->all());

            if($data){
                SchoolSemester::query()->update(['is_active' => 0]);
            }
            return $data;
        });
        
        return back()->with([
            'message' => 'System configuration updated successfully',
            'data' => $data,
            'type' => 'bxs-check-circle'
        ]);
    }
}
