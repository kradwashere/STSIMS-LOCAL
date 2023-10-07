<?php

namespace App\Http\Traits\Enrollment;

use App\Models\Scholar;
use App\Http\Resources\Qualifier\IndexResource;

trait Viewing { 

    public static function search($request){
        $keyword = $request->keyword;
        $data = Scholar::with('profile')
        ->with('program:id,name','subprogram:id,name','category:id,name','status:id,name,type,color,others')
        ->with('education.school.school','education.school.semesters','education.school.gradings','education.course','education.level')
        ->with('enrollments')
        ->whereHas('status',function ($query){
            $query->where('type','Ongoing');
        })
        ->when($request->keyword, function ($query, $keyword) {
            $query->whereHas('profile',function ($query) use ($keyword) {
                $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', '%'.$keyword.'%')
                ->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', '%'.$keyword.'%')
                ->orWhere('spas_id','LIKE','%'.$keyword.'%');
            });
        })->take(5)->get();
        return SearchResource::collection($data);
    }

}