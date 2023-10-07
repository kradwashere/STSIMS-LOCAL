<?php

namespace App\Http\Traits\Schools;

use Hashids\Hashids;
use App\Models\Scholar;
use App\Models\Setting;
use App\Models\ListCourse;
use App\Models\SchoolCourse;
use App\Models\SchoolCampus;
use App\Models\SchoolSemester;
use App\Models\ScholarEnrollment;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\School\ListResource;
use App\Http\Resources\School\IndexResource;
use App\Http\Resources\School\CoursesResource;
use App\Http\Resources\School\SemesterResource;

trait Viewing { 
    
    public static function lists($request){
        $data = ListResource::collection(
            SchoolCampus::query()
            ->with('school.class','term:id,name','grading:id,name')
            ->with('region:region,code','province:name,code','municipality:name,code')
            ->when($request->region, function ($query, $region) {
                $query->where('region_code',$region);
            })
            ->when($request->province, function ($query, $province) {
                $query->where('province_code',$province);
            })
            ->when($request->municipality, function ($query, $municipality) {
                $query->where('municipality_code',$municipality);
            })
            ->when($request->keyword, function ($query, $keyword) {
                $query->whereHas('school',function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%'.$keyword.'%');
                })->orWhere(function ($query) use ($keyword) {
                    $query->where('campus', 'LIKE', '%'.$keyword.'%');
                });
            })
            ->whereHas('school',function ($query) {
                $query->orderBy('name','ASC');
            })
            ->paginate($request->counts)
            ->withQueryString()
        );
        return $data;
    }

    public static function view($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);
        
        $data = new IndexResource(
            SchoolCampus::with('school')
            ->with('gradings')
            ->with('school.class','term:id,name','grading:id,name')
            ->with('semesters.semester','courses.course')
            ->with('region:region,code','province:name,code','municipality:name,code')
            ->where('id',$id[0])->first()
        );

        return $data;
    }

    public static function active(){
        $data = SchoolSemester::where('is_active',1)->pluck('school_id');
        return $data;
    }

    public function statistics($request){
        $setting = Setting::with('agency')->first();
        $region = $setting->agency->region_code;

        $array = [
            SchoolCampus::where('region_code',$region)->where('assigned_region',$region)->count(),
            SchoolCampus::where('region_code','!=',$region)->where('assigned_region',$region)->count(),
            SchoolCampus::count(),
        ];
        return $array;
    }

    public static function counts($id){
        $total = Scholar::whereHas('education',function ($query) use ($id) {
            $query->where('school_id',$id);
        })->count();

        $graduating = Scholar::whereHas('education',function ($query) use ($id) {
            $query->where('school_id',$id);
        })->whereHas('status',function ($query) use ($id) {
            $query->where('name','Graduated');
        })
        ->count();

        $ongoing = Scholar::whereHas('education',function ($query) use ($id) {
            $query->where('school_id',$id);
        })->whereHas('status',function ($query) use ($id) {
            $query->where('type','Ongoing');
        })->count();

        $array = [
            ['counts' => $total, 'name' => 'Total Scholars', 'icon' => 'ri-group-2-line', 'color' => 'success'],
            ['counts' => $graduating,'name' => 'Total Graduates', 'icon' => 'bx bxs-graduation', 'color' => 'info'],
            ['counts' => $ongoing,'name' => 'Ongoing Scholars', 'icon' => 'ri-account-circle-line', 'color' => 'primary']
        ];

        return $array;
    }

    public static function semesters($request){
        $id = $request->id;
        $keyword = $request->keyword;
        $counts = $request->counts;

        $data = SemesterResource::collection(
            SchoolSemester::query()
            ->with('semester')
            ->where('school_id',$id)
            ->orderBy('created_at','DESC')
            ->paginate($counts)
            ->withQueryString()
        );

        return $data;
    }

    public static function activesemester($request){
        $id = $request->id;
        $data = SchoolSemester::where('school_id',$id)->where('is_active',1)->first();

        if($data){
            $semester = new SemesterResource($data);
        }else{
            $semester = null;
        }

        return [
            'active' => $semester,
            'counts' => ScholarEnrollment::where('semester_id',$id)->count()
        ];
    }

    public static function courses($request){
        $id = $request->id;
        $counts = $request->counts;

        $data = CoursesResource::collection(
            SchoolCourse::query()
            ->when($request->keyword, function ($query, $keyword) {
                $query->whereHas('course',function ($query) use ($keyword) {
                    $query->where('name','LIKE', '%'.$keyword.'%');
                });
            })
            ->with('course','prospectuses')
            ->where('school_id',$id)
            ->orderBy('created_at','DESC')
            ->paginate($counts)
            ->withQueryString()
        );

        return $data;
    }

    public function topcourses($request){
        $id = $request->id;
        $data = ListCourse::withCount('scholars')
        ->whereHas('lists',function ($query) use ($id) {
            $query->where('school_id',$id);
        })
        ->orderBy('scholars_count', 'desc')->get();
        return $data;
    }

    public function listschools($request){
        $data = SchoolCampus::with('school')->withCount([
        'scholars' => function ($query) use ($request){
            $query->when($request->scholar, function ($query, $scholar) {
                $query->whereHas('scholar',function ($query) use ($scholar) {
                    $query->whereHas('status',function ($query) use ($scholar) {
                        ($scholar == 'ongoing') ? $query->where('type','Ongoing') : $query->where('name','Graduated');
                    });
                });
            });
        }])
        ->when($request->sort, function ($query, $sort) {
            $query->orderBy('scholars_count', $sort);
        })
        ->when($request->scholar, function ($query, $scholar) {
            $query->whereHas('scholars',function ($query) use ($scholar) {
                $query->whereHas('scholar',function ($query) use ($scholar) {
                    $query->whereHas('status',function ($query) use ($scholar) {
                        ($scholar == 'ongoing') ? $query->where('type','Ongoing') : $query->where('name','Graduated');
                    });
                });
            });
        })
        ->paginate(10);
        return DefaultResource::collection($data);
    }

    public function listcourses($request){
        $data = ListCourse::withCount([
        'scholars' => function ($query) use ($request){
            $query->when($request->scholar, function ($query, $scholar) {
                $query->whereHas('scholar',function ($query) use ($scholar) {
                    $query->whereHas('status',function ($query) use ($scholar) {
                        ($scholar == 'ongoing') ? $query->where('type','Ongoing') : $query->where('name','Graduated');
                    });
                });
            });
        }])
        ->when($request->scholar, function ($query, $scholar) {
            $query->whereHas('scholars',function ($query) use ($scholar) {
                $query->whereHas('scholar',function ($query) use ($scholar) {
                    $query->whereHas('status',function ($query) use ($scholar) {
                        ($scholar == 'ongoing') ? $query->where('type','Ongoing') : $query->where('name','Graduated');
                    });
                });
            });
        })
        ->orderBy('scholars_count', $request->sort)
        ->paginate(10);
        return DefaultResource::collection($data);
    }
}