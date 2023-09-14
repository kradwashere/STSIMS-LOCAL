<?php

namespace App\Http\Controllers\Scholar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Scholars\Api;
use App\Http\Traits\Scholars\Truncate;
use App\Http\Traits\Scholars\Viewing;

class IndexController extends Controller
{
    use Api, Truncate, Viewing; 

    public function index(Request $request){
        $type = $request->type;
        switch($type){
            case 'lists':
               return $this->lists($request);
            break;
            case 'statistics':
                return $this->statistics($request);
            break;
            default : 
            return inertia('Modules/Scholars/Index');
        }
    }

    public function store(Request $request){
        $type = $request->type;
        switch($type){
            case 'truncate':
               return $this->truncate($request);
            break;
            case 'api':
                return $this->api($request);
             break;
        }
    }
}