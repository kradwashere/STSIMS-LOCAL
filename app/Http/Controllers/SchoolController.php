<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\Schools\Save;
use App\Http\Traits\Schools\Update;
use App\Http\Traits\Schools\Viewing;
use App\Http\Traits\Schools\Truncate;
use App\Http\Requests\SchoolProfileRequest;

class SchoolController extends Controller
{
    use Viewing, Save, Update, Truncate;

    public function index(Request $request){
        switch($request->type){
            case 'lists':
                return $this->lists($request);
            break;
            case 'sidebar':
                return [
                    'statistics' => $this->statistics($request),
                    'active' => $this->active($request)
                ];
            break;
            case 'counts':
                return $this->counts($request->id);
            break;
            case 'semesters':
                return $this->semesters($request);
            break;
            case 'activesemester':
                return $this->activesemester($request);
            break;
            case 'courses':
                return $this->courses($request);
            break;
            case 'topcourses':
                return $this->topcourses($request);
            break;
            case 'listschools':
                return $this->listschools($request);
            break;
            case 'listcourses':
                return $this->listcourses($request);
            break;
            default :
            return inertia('Modules/Schools/Index');
        }
    }

    public function show($id){
        $data = $this->view($id);

        return inertia('Modules/Schools/Profile/Index',[
            'school' => $data
        ]);
    }

    public function store(SchoolProfileRequest $request){
        switch($request->type){
            case 'truncate':
                return $this->truncate($request);
            break;
            case 'semester': 
                return $this->semester($request);
            break;
            case 'prospectus': 
                return $this->prospectus($request);
            break;
            case 'grading':
                return $this->grading($request);
            break;
        }
    }

    public function update(Request $request){
        switch($request->type){
            case 'prospectus': 
                return $this->updateProspectus($request);
            break;
            case 'lock': 
                return $this->lock($request);
            break;
            case 'status': 
                return $this->status($request);
            break;
        }
    }
     
}
