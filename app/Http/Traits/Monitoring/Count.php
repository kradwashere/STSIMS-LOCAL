<?php

namespace App\Http\Traits\Monitoring;

use App\Models\Scholar;
use App\Models\Release;
use App\Models\Enrollee;
use App\Models\ListAgency;
use App\Models\ListStatus;
use App\Models\SchoolCampus;
use App\Models\SchoolSemester;
use App\Models\ScholarBenefit;
use App\Models\ScholarEnrollment;
use App\Http\Resources\MonitoringResource;

trait Count { 
    
    public static function grades($request){
        $data = ScholarEnrollment::whereHas('lists',function ($query){
            $query->where('grade',NULL);
        })
        ->when($request->semester_id, function ($query, $semester) {
            $query->where('semester_id',$semester);
        })
        ->whereHas('semester',function ($query){
            $query->where('is_active',0);
        })
        ->whereHas('scholar',function ($query){
            $query ->whereHas('status',function ($query){
                $query->where('type','ongoing');
            });
        })
        ->pluck('scholar_id');

        $scholars = Scholar::with('profile:id,scholar_id,firstname,lastname,middlename')->whereIn('id',$data)->get();
        return MonitoringResource::collection($scholars);
    }

    public static function benefits($request){
        $date = date('Y-m-d');
        $data = ScholarBenefit::whereIn('status_id',[11,12])->where('month','<=',$date)
        ->when($request->semester_id, function ($query, $semester) {
            $query->where('school_semester_id',$semester);
        })
        ->groupBy('scholar_id')->pluck('scholar_id');

        $scholars = Scholar::with('profile:id,scholar_id,firstname,lastname,middlename')->whereIn('id',$data)->get();
        return MonitoringResource::collection($scholars);
    }

    public static function termination($request){
        $data = ScholarEnrollment::withCount([
        'lists' => function ($query) {
            $query->where('is_failed',1)->groupBy('enrollment_id');
        }])
        ->when($request->semester_id, function ($query, $semester) {
            $query->where('semester_id',$semester);
        })
        ->whereHas('scholar',function ($query){
            $query ->whereHas('status',function ($query){
                $query->where('type','ongoing');
            });
            $query->whereHas('enrollees',function ($query){
                $query->where('is_checked',0);
            });
        })
        ->having('lists_count', '>', 1)
        ->pluck('scholar_id');

        $scholars = Scholar::with('profile:id,scholar_id,firstname,lastname,middlename')->whereIn('id',$data)->get();
        return MonitoringResource::collection($scholars);
    }


    public function enrolled($request){
        $data = Enrollee::whereHas('semester',function ($query){
            $query->where('is_active',1);
        })
        ->when($request->semester_id, function ($query, $semester) {
            $query->whereHas('semester',function ($query) use ($semester){
                $query->where('id',$semester);
            });
        })
        ->count();
        return $data;
    }

    public static function missed($request){
        $data = Scholar::whereHas('status',function ($query){
            $query->where('type','ongoing');
        })
        ->whereNotIn('id', function ($query) {
            $query->select('scholar_id')
                ->from('enrollees');
        })
        ->whereHas('education',function ($query){
            $query->whereHas('school',function ($query){
                $query->whereHas('semesters',function ($query){
                    $query->where('is_active',0);
                });
            });
        })
        ->pluck('id');

        $scholars = Scholar::with('profile:id,scholar_id,firstname,lastname,middlename')->whereIn('id',$data)->get();
        return MonitoringResource::collection($scholars);
    }

    public static function unenrolled($request){
        $data = Scholar::whereHas('status',function ($query){
            $query->where('type','ongoing');
        })
        ->whereNotIn('id', function ($query) {
            $query->select('scholar_id')
                ->from('enrollees');
        })
        ->whereHas('education',function ($query){
            $query->whereHas('school',function ($query){
                $query->whereHas('semesters',function ($query){
                    $query->where('is_active',1);
                });
            });
        })
        ->pluck('id');

        $scholars = Scholar::with('profile:id,scholar_id,firstname,lastname,middlename')->whereIn('id',$data)->get();
        return MonitoringResource::collection($scholars);
    }

    public static function scholars($request){
        $data = Scholar::whereHas('status',function ($query){
            $query->where('type','Ongoing');
        })
        ->when($request->semester_id, function ($query, $semester) {
            $query->whereHas('enrollees',function ($query) use ($semester){
                $query->whereHas('semester',function ($query) use ($semester){
                    $query->where('id',$semester);
                });
            });
        })
        ->count();
        return $data;
    }

    public function semesters($request){
        $data = SchoolSemester::where('year',$request->semester_year)->where('is_active',1)->pluck('school_id');
        return $data;
    }

    public function schools(){
        $agency_id = config('app.agency');
        $region = ListAgency::select('region_code')->where('id',$agency_id)->first();
        $region = $region->region_code;

        $data = SchoolCampus::query()->whereHas('municipality',function ($query) use ($region){
            $query->whereHas('province',function ($query) use ($region){
                $query->whereHas('region',function ($query) use ($region){
                    $query->where('code',$region);
                });
            });
        })->count();
        return $data;
    }

    public function statuses(){
        $statuses = ListStatus::select('id','name','color','type')->where('type','ongoing')->withCount('status')->orderBy('status_count', 'desc')->get();
        $substatuses = ListStatus::select('id','name','color','type')->where('is_active',1)->where('type','Status')->withCount('status')->get();
    
        return [
            'statuses' => $statuses,
            'substatuses' => $substatuses
        ];
    }

    public function checking($request){
        $enrollees = Enrollee::whereHas('semester',function ($query){
            $query->where('is_active',1);
        })->where('is_completed',0)->count();
        
        $scholar = $this->enrolled($request);

        return [
            [
                'name' => 'Completed Grades',
                'completed' => Enrollee::whereHas('semester',function ($query){
                    $query->where('is_active',1);
                })->where('is_grades_completed',1)->count(),
                'count' => $scholar
            ],
            [
                'name' => 'Released Benefits',
                'completed' => Enrollee::whereHas('semester',function ($query){
                    $query->where('is_active',1);
                })->where('is_benefits_released',1)->count(),
                'count' => $scholar
            ],
            [
                'name' => 'Completed Enrollees',
                'completed' => Enrollee::whereHas('semester',function ($query){
                    $query->where('is_active',1);
                })->where('is_completed',1)->count(),
                'count' => $scholar
            ]
        ];
    }

    public function released(){
        $data = Release::where('is_checked',0)->count();
        return $data;
    }

    
}