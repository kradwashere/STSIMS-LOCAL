<?php

namespace App\Http\Controllers\Scholar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Scholars\Api;
use App\Http\Traits\Scholars\Truncate;
use App\Http\Traits\Scholars\Viewing;
use App\Http\Traits\Scholars\Updating;

class IndexController extends Controller
{
    use Api, Truncate, Viewing, Updating; 

    public function index(Request $request){
        $type = $request->type;
        switch($type){
            case 'lists':
               return $this->lists($request);
            break;
            case 'statistics':
                return $this->statistics($request);
            break;
            case 'search':
                return $this->search($request);
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
            case 'update':
                return $this->updating($request);
            break;
            case 'course':
                return $this->course($request);
            break;
        }
    }

}
