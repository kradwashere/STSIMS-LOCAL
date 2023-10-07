<?php

namespace App\Http\Controllers;

use App\Models\SchoolCourse;
use App\Models\SchoolCampus;
use App\Models\SchoolSemester;
use App\Models\LocationRegion;
use App\Models\LocationProvince;
use App\Models\LocationMunicipality;
use App\Models\LocationBarangay;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\School\Search\IndexResource;

class ListController extends Controller
{
    public function regions()
    {
        $data = LocationRegion::orderBy('id','ASC')->get();
        return DefaultResource::collection($data);
    }

    public function provinces($id = null)
    {
        $data = LocationProvince::where('region_code',$id)->orderBy('name','ASC')->get();
        return DefaultResource::collection($data);
    }

    public function municipalities($id = null)
    {
        $data = LocationMunicipality::where('province_code',$id)->orderBy('name','ASC')->get();
        return DefaultResource::collection($data);
    }

    public function barangays($id = null)
    {
        $data = LocationBarangay::where('municipality_code',$id)->orderBy('name','ASC')->get();
        return DefaultResource::collection($data);
    }

    public function schools(Request $request){

        $keyword = $request->input('word');
        $data = SchoolCampus::with('school')->with('courses.course')
        ->whereHas('school',function ($query) use ($keyword) {
            $query->where('name', 'LIKE', '%'.$keyword.'%');
        })
        ->orWhere(function ($query) use ($keyword) {
            $query->where('campus',$keyword);
        })->get()->take(10);

        return IndexResource::collection($data);
    }

    public function subcourses($school,$course){
        $data = SchoolCourse::where('school_id',$school)->where('course_id',$course)->get();
        return $data;
    }

    public function semesteryear($id,$year){
        $data = SchoolSemester::with('semester')->where('school_id',$id)->whereYear('start_at', '>=' ,$year)->orderBy('id','DESC')->get();
        return $data;
    }
}
