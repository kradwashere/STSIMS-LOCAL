<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        // $information = [
        //     'address' => 'Pettit Barracks, Barangay Zone IV, Zamboanga City',
        //     'facebook' => 'https://www.facebook.com/DOSTRegion9',
        //     'telephone' => '(062) 991-1024',
        //     'fax' => '(062) 992-1114',
        //     'mobile' => '',
        // ];

        // $signatories = [
        //     [
        //         'role' => 'Approved By',
        //         'position' => '',
        //         'name' => '',
        //         'avatar' =>  '',
        //         'date' =>  ''
        //     ],
        //     [
        //         'role' => 'Prepared By',
        //         'position' => '',
        //         'name' => '',
        //         'avatar' =>  '',
        //         'date' =>  ''
        //     ],
        //     [
        //         'role' => 'Certified Correct',
        //         'position' => '',
        //         'name' => '',
        //         'avatar' =>  '',
        //         'date' =>  ''
        //     ],
        //     [
        //         'role' => 'Reviewed By',
        //         'position' => '',
        //         'name' => '',
        //         'avatar' =>  '',
        //         'date' =>  ''
        //     ],
        //     [
        //         'role' => 'Verified Correct',
        //         'position' => '',
        //         'name' => '',
        //         'avatar' =>  '',
        //         'date' =>  ''
        //     ],
        // ];
        
        // $data = Setting::first();

        // $data->information = json_encode($information);
        // $data->signatories = json_encode($signatories);
        // $data->save();
        return inertia('Modules/Home/Index');
    }

    public function update(Request $request){

        $validatedData = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:9|confirmed',
            'password_confirmation' => 'same:password',
        ]);

        $id = ($request->id) ? $request->id : \Auth::user()->id;

        User::find($id)->update(['password'=> \Hash::make($request->input('password'))]);

        return back()->with([
            'message' => 'Password Changed',
            'data' => 'wew',
            'type' => 'bxs-check-circle'
        ]); 
        
    }
}
