<?php

namespace App\Http\Traits\Monitoring;

use App\Models\Scholar;
use App\Models\Enrollee;
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
            $query->where('grade','F')->groupBy('enrollment_id');
        }])
        ->when($request->semester_id, function ($query, $semester) {
            $query->where('semester_id',$semester);
        })
        ->whereHas('scholar',function ($query){
            $query ->whereHas('status',function ($query){
                $query->where('type','ongoing');
            });
        })
        ->having('lists_count', '>', 1)
        ->pluck('scholar_id');

        $scholars = Scholar::with('profile:id,scholar_id,firstname,lastname,middlename')->whereIn('id',$data)->get();
        return MonitoringResource::collection($scholars);
    }

    public static function missed($request){
        $data = Scholar::whereHas('status',function ($query){
            $query->where('type','ongoing');
        })
        ->whereNotIn('id', function ($query) {
            $query->select('id')
                ->from('enrollees');
        })
        ->when($request->semester_id, function ($query, $semester) {
            $query->whereHas('enrollees',function ($query) use ($semester){
                $query->where('school_semester_id',$semester);
            });
        })
        ->pluck('id');

        $scholars = Scholar::with('profile:id,scholar_id,firstname,lastname,middlename')->whereIn('id',$data)->get();
        return MonitoringResource::collection($scholars);
    }

    public static function enrolled($request){
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
}