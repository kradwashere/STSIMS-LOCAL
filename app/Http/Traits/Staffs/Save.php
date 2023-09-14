<?php

namespace App\Http\Traits\Staffs;

use App\Models\User;
use App\Models\Setting;
use App\Models\UserProfile;
use App\Models\SchoolCampus;
use App\Models\LocationRegion;
use App\Models\LocationProvince;
use App\Http\Resources\Staff\IndexResource;

trait Save { 
    
    public static function save($request){
        $data = \DB::transaction(function () use ($request){
            $password = rand(1000000000,9999999999);
            $data = User::create(array_merge($request->all(), ['password' => bcrypt($password), 'temp_password' => $password]));
            
            $profile = [
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'middlename' => $request->middlename,
                'suffix' => $request->suffix,
                'gender' => $request->gender,
                'mobile' => $request->mobile,
                'user_id' => $data->id
            ];

            if($request->role == 'PSTO Staff'){
                $province = LocationProvince::where('code',$request->province)->first();
                $province->profile()->create($profile);
            }else if($request->role == 'University Coordinator'){
                $school = SchoolCampus::where('id',$request->school)->first();
                $school->profile()->create($profile);
            }else{
                $setting = Setting::with('agency')->first();
                $province = LocationRegion::where('code',$setting->agency->region_code)->first();
                $province->profile()->create($profile);
            }

            $id = $data->id;

            if($request->img != ''){
                $data = $request->img;
                $img = explode(',', $data);
                $ini =substr($img[0], 11);
                $type = explode(';', $ini);
                if($type[0] == 'png'){
                    $image = str_replace('data:image/png;base64,', '', $data);
                }else{
                    $image = str_replace('data:image/jpeg;base64,', '', $data);
                }
                $image = str_replace(' ', '+', $image);
                $imageName = $request->username.'.'.$type[0];
                
                if(\File::put(public_path('images/avatars'). '/' . $imageName, base64_decode($image))){
                    $data = User::findOrFail($id);
                    $data->avatar = $imageName;
                    $data->save();
                }
            }

            return $data;
        });

        return back()->with([
            'message' => 'Staff created successfully. Thanks',
            'data' => new IndexResource($data),
            'type' => 'bxs-check-circle',
            'color' => 'success'
        ]); 
    }

    public function edit($request){
        $data = User::findOrFail($request->id);
        $data->update($request->except('img','editable'));
        $profile = UserProfile::where('user_id',$request->id)->first();
        $profile->update($request->except('email','role','is_active','img','editable'));
        $id = $data->id;
        if($request->img != ''){
            $data = $request->img;
            $img = explode(',', $data);
            $ini =substr($img[0], 11);
            $type = explode(';', $ini);
            if($type[0] == 'png'){
                $image = str_replace('data:image/png;base64,', '', $data);
            }else{
                $image = str_replace('data:image/jpeg;base64,', '', $data);
            }
            $image = str_replace(' ', '+', $image);
            $imageName = $request->username.'.'.$type[0];
            
            if(\File::put(public_path('images/avatars'). '/' . $imageName, base64_decode($image))){
                $data = User::findOrFail($id);
                $data->avatar = $imageName;
                $data->save();
            }
        }
        $data = User::findOrFail($request->id);
        
        return back()->with([
            'message' => 'User updated successfully. Thanks',
            'data' => new IndexResource($data),
            'type' => 'bxs-check-circle',
            'color' => 'success'
        ]); 
    }

    public function verification($request){
        $data = User::findOrFail($request->id);
        $data->verify();

        return back()->with([
            'message' => 'User verification successfully send. Thanks',
            'data' => new IndexResource($data),
            'type' => 'bxs-check-circle',
            'color' => 'success'
        ]); 
    }
}