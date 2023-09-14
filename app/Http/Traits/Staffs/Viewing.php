<?php

namespace App\Http\Traits\Staffs;

use App\Models\Log;
use App\Models\User;
use App\Http\Resources\LogsResource;
use App\Http\Resources\Staff\IndexResource;

trait Viewing { 
    
    public static function lists($request){
        $data = IndexResource::collection(
            User::query()
            ->with('profile')
            ->when($request->keyword, function ($query, $keyword) {
                $query->whereHas('profile',function ($query) use ($keyword) {
                    $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', "%{$keyword}%")
                    ->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', "%{$keyword}%");
                })->orWhere(function ($query) use ($keyword) {
                    $query->where('username', 'LIKE', "%{$keyword}%")->whereNotIn('role',['Scholar','Administrator']);
                });
            })
            ->when($request->role, function ($query, $role) {
                $query->where('role',$role);
            })
            ->whereNotIn('role',['Scholar','Administrator'])
            ->paginate($request->counts)
            ->loadMorph('profile.profileable', [ 
                SchoolCampus::class => ['school'],
            ])
        );

        return $data;
    }

    public function logs($request){
        $data = Log::lists();
        return LogsResource::collection($data);
    }
    
}