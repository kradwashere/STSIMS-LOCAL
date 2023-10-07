<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\Qualifiers\Save;
use App\Http\Traits\Qualifiers\Viewing;

class QualifierController extends Controller
{
    use Save, Viewing; 

    public $link, $api;

    public function __construct()
    {
        $this->link = config('app.api_link');
        $this->api = config('app.api_key');
    }

    public function index(Request $request){
        switch($request->type){
            case 'lists':
                return $this->lists($request);
            break;
            case 'insights':
                return $this->insights($request);
            break;
            default :
            return inertia('Modules/Qualifiers/Index');
        }
    }

    public function store(Request $request){
        $type = $request->type;

        switch($type){
            case 'enroll':
                return $this->enroll($request);
            break;
            case 'endorse':
                return $this->endorse($request);
            break;
            case 'endorsed':
                return $this->endorsed($request);
            break;
            case 'update':
                return $this->update($request);
            break;
        }
    }
}
