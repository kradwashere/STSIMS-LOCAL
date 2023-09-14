<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\Monitoring\Count;

class MonitoringController extends Controller
{
    use Count; 

    public function index(Request $request){
        $type = $request->type;

        switch($type){
            case 'counts':
                $array = [
                    'grades' => $this->grades($request),
                    'benefits' => $this->benefits($request),
                    'termination' => $this->termination($request),
                    'missed' => $this->missed($request),
                    'enrolled' => $this->enrolled($request),
                    'scholars' => $this->scholars($request)
                ];
                return $array;
            break;
            default : 
            // return inertia('Modules/Monitoring/Index');
            return '';
        }
    }
}
