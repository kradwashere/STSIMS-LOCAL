<?php

namespace App\Http\Controllers\Scholar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Release;
use App\Http\Traits\Benefits\Save;
use App\Http\Requests\ReleaseRequest;
use App\Http\Traits\Benefits\BenefitTrait;
use App\Http\Resources\Scholar\Benefits\ReleaseResource;

class FinancialBenefitController extends Controller
{
    use Save, BenefitTrait;

    public function index(Request $request){
        $type = $request->type;
        switch($type){
            case 'lists':
                $month = date_parse($request->month)['month'];
                $year = $request->year;
                
                $data = Release::orderBy('created_at','DESC')
                ->when($month, function ($query, $month) {
                    $query->whereMonth('created_at',$month);
                })
                ->when($year, function ($query, $year) {
                    $query->whereYear('created_at',$year);
                })
                ->when($request->keyword, function ($query, $keyword) {
                    $query->where('batch','LIKE','%'.$keyword.'%');
                })
                ->paginate($request->count)
                ->withQueryString();

                return ReleaseResource::collection($data);
            break;
            default : 
            return inertia('Modules/FinancialBenefits/Index');
        }
    }

    public function store(ReleaseRequest $request){
        $type = $request->type;
        switch($type){
            case 'Completed':
                return $this->completed($request);
            break;
            default : 
                return $this->pending($request);
        }
    }

    public function create(Request $request){
        switch($request->type){
            case 'generate':
                return $this->generate();
            break;
            case 'benefits':
                return $this->benefits($request->info);
            break;
        }
    }

}
