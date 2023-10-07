<?php

namespace App\Http\Controllers\Scholar;

use App\Models\Scholar;
use App\Models\ScholarBenefit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\Scholar\Info\SearchResource;
use App\Http\Resources\Scholar\Benefits\ReimbursementResource;
use App\Http\Requests\ReimbursementRequest;

class ReimbursementController extends Controller
{
    public function index(Request $request){
        $keyword = $request->keyword;
        if($keyword != ''){
            $data = Scholar::with('profile','status','program')
            ->with('enrollments:semester_id,scholar_id','enrollments.semester.semester')
            ->when($request->keyword, function ($query, $keyword) {
                $query->whereHas('profile',function ($query) use ($keyword) {
                    $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', '%'.$keyword.'%')
                    ->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', '%'.$keyword.'%')
                    ->orWhere('spas_id','LIKE','%'.$keyword.'%');
                });
            })
            ->take(5)->get();
            return SearchResource::collection($data);
        }
    }

    public function store(ReimbursementRequest $request){
        $data = \DB::transaction(function () use ($request){
            $attachments = [
                $this->upload($request)
            ];
            $data = ScholarBenefit::create(array_merge($request->all(),[
                'attachment' => json_encode($attachments),
                'release_type' => 'Full', 
                'month' => now(), 
                'status_id' => 11,
                'amount' => trim(str_replace(',','',$request->amount),'₱ ')
            ]));
            return new ReimbursementResource($data);
        });
        
        return back()->with([
            'message' => 'Reimbursement successful. Thanks',
            'data' =>  $data,
            'type' => 'bxs-check-circle'
        ]); 
    }

    public function upload($request){
        if($request->hasFile('files'))
        {   
            $code = $request->scholar_id;
            $files = $request->file('files');   
            foreach ($files as $key=>$file) {
                if($key == 0){
                    $file_name = 'reimbursement_'.date("y-m-dhis").'.'.$file->getClientOriginalExtension();
                }else{
                    $file_name = 'reimbursement_'.date("y-m-dhis").'.'.$file->getClientOriginalExtension();
                }
              
                $file_path = $file->storeAs('/reimbursements', $file_name, 'public');
            }
            return $attachment = [
                'name' => $file_name,
                'file' => $file_path,
                'added_by' => \Auth::user()->id,
                'created_at' => date('M d, Y g:i a', strtotime(now()))
            ];
        }
    }
}
