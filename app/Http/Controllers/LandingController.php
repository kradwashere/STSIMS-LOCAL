<?php

namespace App\Http\Controllers;

use App\Models\ListCourse;
use App\Models\SchoolCampus;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\Schools\PublicResource;
use App\Http\Resources\Schools\PublicCourse2Resource;

class LandingController extends Controller
{

    public function schools(Request $request){
        $type = $request->type;
        switch($type){
            case 'schools':
                return $this->searchschools($request);
            break;
            case 'courses':
                return $this->searchcourses($request);
            break;
            case 'listcourses':
                return $this->listcourses($request);
            break;
            default: 
                return inertia('Landing/Schools');
        }
    }

    public function courses(){
        return inertia('Landing/Courses');
    }

    public function searchschools($request){
        $keyword = $request->keyword;
        $data = SchoolCampus::with('school','region','province','municipality')
        ->whereHas('school',function ($query) use ($keyword) {
            $query->where('name', 'LIKE', '%'.$keyword.'%');
        })
        ->orWhere(function ($query) use ($keyword) {
            $query->where('campus',$keyword);
        })->get()->take(10);

        return PublicResource::collection($data);
    }

    public function searchcourses($request){
        $keyword = $request->keyword;
        $data = ListCourse::with('lists.school.school','lists.school.region','lists.school.province','lists.school.municipality')->where('name', 'LIKE', '%'.$keyword.'%')->where('is_active',1)->get();

        return PublicCourse2Resource::collection($data);
    }

    public function listcourses($request){
        $data = ListCourse::with('lists.school.school','lists.school.region','lists.school.province','lists.school.municipality')->where('is_active',1)->get();
        return PublicCourse2Resource::collection($data);
    }
}
