<?php

namespace App\Http\Traits\Scholars;

use App\Models\Scholar;
use App\Models\ScholarAddress;
use App\Models\ScholarEducation;
use App\Models\ScholarProfile;
use App\Http\Resources\Scholar\SearchResource;
use App\Http\Resources\Scholar\IndexResource;

trait Viewing { 
    
    public static function lists($request){
        $info = (!empty(json_decode($request->info))) ? json_decode($request->info) : NULL;
        $filter = (!empty(json_decode($request->subfilters))) ? json_decode($request->subfilters) : NULL;
        $keyword = $info->keyword;

        $data = IndexResource::collection(
            Scholar::
            with('addresses.region','addresses.province','addresses.municipality','addresses.barangay')
            ->with('profile')
            ->with('program:id,name','subprogram:id,name','category:id,name','status:id,name,type,color,others')
            ->with('education.school.school','education.course','education.level')
            ->whereHas('profile',function ($query) use ($keyword) {
                $query->when($keyword, function ($query, $keyword) {
                    $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', '%'.$keyword.'%')
                    ->where(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', '%'.$keyword.'%')
                    ->orWhere('spas_id','LIKE','%'.$keyword.'%');
                });
            })
            ->whereHas('addresses',function ($query) use ($filter) {
                if(!empty($filter)){
                    (property_exists($filter, 'region')) ? $query->where('region_code',$filter->region)->where('is_permanent',1) : '';
                    (property_exists($filter, 'province')) ? $query->where('province_code',$filter->province)->where('is_permanent',1) : '';
                    (property_exists($filter, 'municipality')) ? $query->where('municipality_code',$filter->municipality)->where('is_permanent',1) : '';
                    (property_exists($filter, 'barangay')) ? $query->where('barangay_code',$filter->barangay)->where('is_permanent',1) : '';
                }
            })
            ->whereHas('education',function ($query) use ($filter) {
                if(!empty($filter)){
                    (property_exists($filter, 'school')) ? $query->where('school_id',$filter->school) : '';
                    (property_exists($filter, 'course')) ? $query->where('course_id',$filter->course) : '';
                }
            })
            ->where(function ($query) use ($info,$filter) {
                ($info->program == null) ? '' : $query->where('program_id',$info->program);
                // ($filter != null) ? ($filter->subprogram == null) ? '' : $query->where('subprogram_id',$filter->subprogram) : '';
                ($info->category == null) ? '' : $query->where('category_id',$info->category);
                ($info->status == null) ? '' : $query->where('status_id',$info->status);
                ($info->year == null) ? '' : $query->where('awarded_year',$info->year);
                ($info->type == null) ? '' : $query->where('is_undergrad',$info->type);
             })
            ->orderBy('awarded_year',$info->sort)
            ->paginate($info->counts)
            ->withQueryString()
        );

        return $data;
    }

    public function statistics($request){
        return [
            'statuses' => $this->statuses($request),
            'types' => $this->types($request),
            'active' => [],
            'sync' => $this->sync(),
        ];
    } 

    public static function statuses($request){
        $array = [
            Scholar::whereHas('status',function ($query) {
                $query->where('type','ongoing');
            })->count(),
            Scholar::whereHas('status',function ($query) {
                $query->where('name','Graduated');
            })->count(),
            Scholar::count()
        ];
        return $array;
    }

    public static function types($request){
        $array = [
            Scholar::where('is_undergrad',1)->count(),
            Scholar::where('is_undergrad',0)->count(),
        ];
        return $array;
    }

    public static function sync(){
        $scholar = Scholar::where('is_synced',0)->count();
        $profile = ScholarProfile::where('is_synced',0)->count();
        $address = ScholarAddress::where('is_synced',0)->count();
        $education = ScholarEducation::where('is_synced',0)->count();
        $total = $scholar + $profile + $address + $education;
        return $total;
    }

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