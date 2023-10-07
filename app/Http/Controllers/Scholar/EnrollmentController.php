<?php

namespace App\Http\Controllers\Scholar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScholarEnrollmentList;
use App\Http\Resources\DefaultResource;
use App\Http\Requests\EnrollmentRequest;
use App\Http\Traits\Enrollment\GradeTrait;
use App\Http\Traits\Enrollment\EnrollmentTrait;

class EnrollmentController extends Controller
{
    use EnrollmentTrait, GradeTrait; 

    public function index(Request $request){
        $type = $request->type;
        switch($type){
            case 'search':
                return $this->search($request);
            break;
            default : 
            return inertia('Modules/Enrollments/Index');
        }
    }

    public function store(EnrollmentRequest $request){
        switch($request->type){
            case 'enrollment': 
                return $this->enrollment($request);
            break;
            case 'grade': 
                return $this->grade($request);
            break;
            case 'lock': 
                return $this->lock($request);
            break;
        }
    }

    public function show($id){
        $data = ScholarEnrollmentList::where('enrollment_id',$id)->get();
        return DefaultResource::collection($data);
    }

    public function update(Request $request){
        switch($request->type){
            case 'switch': 
                return $this->switch($request);
            break;
        }
    }

}
