<?php

namespace App\Http\Traits\Benefits;

use App\Models\Release;
use App\Models\Scholar;
use App\Models\ScholarBenefit;
use App\Http\Resources\NameResource;
use App\Http\Resources\Scholar\Benefits\ListResource;

trait BenefitTrait { 
    
    public function generate(){
        $date = now();
        $pending = ScholarBenefit::where('status_id',11)->where('month','<=',$date)->groupBy('scholar_id')->pluck('scholar_id');
        $scholars = Scholar::with('profile')->whereIn('id',$pending)->get();
        $month = date('Y').'-'.date('m').'-01';
        $data = [
            'pending' => $pending,
            'scholars' => NameResource::collection($scholars),
            'month' => date('F', mktime(0, 0, 0, date("m"), 10)),
            'count' => Release::whereYear('created_at', '=', date("Y"))->whereMonth('created_at', '=', date("m"))->count(),
            'ongoing' => Scholar::whereHas('status', function ($query) {
                $query->where('type','Ongoing');
            })->count(),
            'received' => ScholarBenefit::where('month',$month)->where('benefit_id',1)->where('status_id',13)->count()
        ];
        return $data;
    }

    public function benefits($info){
        $scholars = (!empty(json_decode($info))) ? json_decode($info) : NULL;
        $month = now();

        $data = Scholar::with('profile','program')->with('benefits.benefit')
        ->with('enrollments.semester.semester')
        ->withWhereHas('benefits', function ($query) use ($month) {
            $query->where('status_id',11)->where('month','<=',$month);
        })
       
        ->whereIn('id',$scholars)
        ->get();

        return ListResource::collection($data);
    }
}