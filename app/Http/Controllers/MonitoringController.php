<?php

namespace App\Http\Controllers;

use App\Models\Scholar;
use Illuminate\Http\Request;
use App\Http\Traits\Monitoring\Save;
use App\Http\Traits\Monitoring\Count;
use App\Http\Traits\Monitoring\Viewing;

class MonitoringController extends Controller
{
    use Count, Viewing, Save; 

    public function index(Request $request){
        $type = $request->type;

        switch($type){
            case 'counts':
                $array = [
                    'grades' => $this->grades($request),
                    'benefits' => $this->benefits($request),
                    'termination' => $this->termination($request),
                    'missed' => $this->missed($request),
                    'unenrolled' => $this->unenrolled($request),
                    'enrolled' => $this->enrolled($request),
                    'scholars' => $this->scholars($request),
                    'semesters' => $this->semesters($request),
                    'schools' => $this->schools(),
                    'graduating' => [],
                    'total' => Scholar::count()
                ];
                return $array;
            break;
            case 'index':
                $array = [
                    'statuses' => $this->statuses(),
                    'checking' => $this->checking($request),
                    'released' => $this->released(),
                ];
                return $array;
            break;
            case 'lists':
                return $this->lists($request);
            break;
            case 'monitoring':
                return $this->monitoring($request);
            break;
            default : 
            return inertia('Modules/Monitoring/Index');
        }
    }

    public function store(Request $request){
        switch($request->type){
            case 'checked':
                return $this->checked($request);
            break;
            case 'termination':
                return $this->terminate($request);
            break;
        }
    }
}
