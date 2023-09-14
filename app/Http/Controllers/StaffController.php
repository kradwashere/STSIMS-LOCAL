<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StaffRequest;
use App\Http\Traits\Staffs\Save;
use App\Http\Traits\Staffs\Viewing;

class StaffController extends Controller
{
    use Viewing, Save;

    public function index(Request $request){
       switch($request->type){
            case 'lists':
                return $this->lists($request);
            break;
            case 'logs':
                return $this->logs($request);
            break;
            default :
            return inertia('Modules/Staffs/Index');
       }
    }

    public function store(StaffRequest $request){
        return $this->save($request);
    }

    public function update(Request $request){
        switch($request->type){
            case 'verification':
                return $this->verification($request);
            break;
            default: 
                return $this->edit($request);
        }
    }
}
