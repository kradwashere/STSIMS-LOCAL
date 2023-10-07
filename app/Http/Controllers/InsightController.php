<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Scholar;
use App\Models\ScholarProfile;
use App\Models\ScholarAddress;
use App\Models\ScholarEducation;
use App\Models\ListAgency;
use App\Models\ListCourse;
use App\Models\ListProgram;
use App\Models\LocationProvince;
use App\Models\LocationMunicipality;
use App\Models\SchoolCampus;
use Illuminate\Http\Request;

class InsightController extends Controller
{
    public function index(Request $request){
        $type = $request->type;

        switch($type){
            case 'lists':
                return $this->home($request);
            break;
            case 'years':
                return $this->years($request);
            break;
            case 'schools':
                return $this->schools($request);
            break;
            case 'courses':
                return $this->courses($request);
            break;
            default : 
            return inertia('Modules/Insights/Index');
        }
    }

    public function home($request){
        // $agency_id = Setting::first()->pluck('agency_id');
        // $agency = ListAgency::with('region')->where('id',$agency_id[0])->first();
        // $region_code = $agency->region_code;

        $array = [
            'first' => $this->first(),
            'courses' => $this->courses($request),
            'schools' => $this->schools($request),
            'gender' => ScholarProfile::select(\DB::raw('count(*) as total'))->whereIn('sex',['Female','Male'])->groupBy('sex')->get(),
            'total' => Scholar::count(),
            'ongoing' => Scholar::whereHas('status',function ($query) {
                $query->where('type','ongoing');
            })->count(),
            'graduated' => Scholar::whereHas('status',function ($query) {
                $query->where('name','Graduated');
            })->count(),
            'locations' => $this->location($request)
        ];

        return $array;
    }

    public function first($code = null){
        return [
            $this->scholars($code),
            $this->qualifiers($code),
            $this->graduates($code)
        ];
    }

    public function second($code = null){
        return [
            $this->scholars($code),
            $this->ongoing($code),
            $this->graduates($code)
        ];
    }

    public function scholars($code){
        $array = [];
        $data = Scholar::select('awarded_year AS x',\DB::raw('count(*) AS y'))
        ->when($code, function ($query, $code) {
            $query->whereHas('addresses',function ($query) use ($code) {
                $query->where('province_code',$code);
            });
        })
        ->orderBy('awarded_year')->groupBy('awarded_year')->get();
        $len = count($data);
        
        $arr = [
            'name' => 'Scholars',
            'data' => $data
        ];
        array_push($array,$arr);

        return $arr = [
            'name' => 'Scholars',
            'icon' => 'bxs-user-circle',
            'color' => 'danger',
            'series' => $array,
            'number' => ($len != 0 && $len != 1) ? $d = $data[$len-1]['y']-$data[$len-2]['y'] : 0,
            'percent' => ($len != 0 && $len != 1) ? round($d/$data[$len-1]['y']*100) : 0,
            'total' => Scholar::when($code, function ($query, $code) {
                $query ->whereHas('addresses',function ($query) use ($code) {
                    $query->where('province_code',$code)->where('is_permanent',1);
                });
            })->count(),
        ];
    }

    public function ongoing($code){
        $array = [];
        $data = Scholar::select('awarded_year AS x',\DB::raw('count(*) AS y'))
        ->when($code, function ($query, $code) {
            $query ->whereHas('addresses',function ($query) use ($code) {
                $query->where('province_code',$code);
            });
        })
        ->whereHas('status',function ($query) {
            $query->where('type','ongoing');
        })
        ->orderBy('awarded_year')->groupBy('awarded_year')->get();
        $len = count($data);
        
        $arr = [
            'name' => 'Ongoing',
            'data' => $data
        ];
        array_push($array,$arr);

        return $arr = [
            'name' => 'Ongoing',
            'icon' => 'bxs-check-circle',
            'color' => 'danger',
            'series' => $array,
            'number' => ($len != 0 && $len != 1) ? $d = $data[$len-1]['y']-$data[$len-2]['y'] : 0,
            'percent' => ($len != 0 && $len != 1) ? round($d/$data[$len-1]['y']*100) : 0,
            'total' => Scholar::when($code, function ($query, $code) {
                    $query ->whereHas('addresses',function ($query) use ($code) {
                        $query->where('province_code',$code)->where('is_permanent',1);
                    });
                })->whereHas('status',function ($query) {
                    $query->where('type','ongoing');
                })->count(),
        ];
    }

    public function qualifiers($code){
        $array = [];
        $data = [];
        $len = count($data);

        $arr = [
            'name' => 'Qualifiers',
            'data' => $data
        ];
        array_push($array,$arr);
        
        return $arr = [
            'name' => 'Qualifiers',
            'icon' => 'bx-notepad',
            'color' => 'primary',
            'series' => $array,
            'number' =>  ($len != 0 && $len != 1) ? $d = $data[$len-1]['y']-$data[$len-2]['y'] : 0,
            'percent' => ($len != 0 && $len != 1) ? round($d/$data[$len-1]['y']*100) : 0,
            'total' => 0,
        ];
    }

    public function graduates($code){
        $array = [];
        $data = ScholarEducation::select('graduated_year AS x',\DB::raw('count(*) AS y'))
        ->when($code, function ($query, $code) {
            $query ->whereHas('scholar',function ($query) use ($code) {
                $query ->whereHas('addresses',function ($query) use ($code) {
                    $query->where('province_code',$code)->where('is_permanent',1);
                });
            });
        })
        ->whereNotNull('graduated_year')
        ->orderBy('graduated_year')->groupBy('graduated_year')->get();
        $len = count($data);

        $arr = [
            'name' => 'Graduated',
            'data' => $data
        ];
        array_push($array,$arr);
        
        return $arr = [
            'name' => 'Graduates',
            'icon' => 'bxs-graduation',
            'color' => 'success',
            'series' => $array,
            'number' =>  ($len != 0 && $len != 1) ? $d = $data[$len-1]['y']-$data[$len-2]['y'] : 0,
            'percent' => ($len != 0 && $len != 1) ? round($d/$data[$len-1]['y']*100) : 0,
            'total' => ScholarEducation::when($code, function ($query, $code) {
                $query ->whereHas('scholar',function ($query) use ($code) {
                    $query ->whereHas('addresses',function ($query) use ($code) {
                        $query->where('province_code',$code)->where('is_permanent',1);
                    });
                });
            })->whereNotNull('graduated_year')->count(),
        ];
    }

    public function schools($request){
        $sort = $request->sort;
        $data = SchoolCampus::with('school')->withCount('scholars')->orderBy('scholars_count', $sort)->take(5)->get();
        return $data;
    }

    public function courses($request){
        $sort = $request->sort;
        $data = ListCourse::withCount('scholars')->orderBy('scholars_count', $sort)->take(5)->get();
        return $data;
    }

    public function location($request){
        $provinces = ScholarAddress::when($request->region_code, function ($query, $region_code) {
            $query->where('region_code',$region_code);
        })->groupBy('province_code')->pluck('province_code');
        $provinces = LocationProvince::withCount('scholars')->whereIn('code',$provinces)->orderBy('scholars_count','DESC')->get();
        $programs = ListProgram::where('is_sub',1)->get();

        $array = []; $sums = []; $total = [];
        
        foreach($provinces as $key=>$province){
            $code = $province->code;
            $count = [];
            foreach($programs as $key2=>$program){
                $data = Scholar::whereHas('addresses',function ($query) use ($code) {
                    $query->where('province_code',$code)->where('is_permanent',1);
                })
                ->where('program_id',$program->id)->count();
                array_push($count,$data);    
                $sums[$key2][$key] = $data;
            }

            $array[] = [
                'province' => $province->name,
                'code' => $province->code,
                'region_code' => $province->region_code,
                'count' => $count,
                'is_chartered' => $province->is_chartered,
                'total' => array_sum($count)
            ];
        }

        foreach($programs as $key2=>$program){
            $total[] = array_sum($sums[$key2]); 
        }

        $total2 = [
            'province' => 'Total',
            'count' => $total,
            'total' => array_sum($total)
        ];
        
        $all = [
            'provinces' => $array,
            'totals' => $total2,
            'programs' => $programs
        ];

        return $all;
    }

    public function years(Request $request){
        $provinces = ScholarAddress::where('is_permanent',1)->groupBy('province_code')->pluck('province_code');
        $programs = ListProgram::where('is_sub',1)->get();
        $current_year = $request->year; $years = []; 
        $province = ($request->province) ? $request->province : null;
        $pro = ($request->program) ? $request->program : null;


        $prog = []; 
        foreach($programs as $program){
            $data = []; $year = $current_year - 20;
            for($year; $year <= $current_year; $year++){
                $years[] = $year;
                $data[] = ListProgram::where('id',$program->id)->withCount([
                'scholar', 
                'scholar as scholar_count' => function ($query) use ($year,$province,$pro){
                    $query->where('awarded_year', $year)
                    ->whereHas('addresses',function ($query) use ($province,$pro) {
                        ($province != null) ? $query->where('province_code', $province)->where('is_permanent',1) : '';
                    });
                    ($pro != null) ? $query->where('program_id', $pro) : '';
                }])->pluck('scholar_count')->first();
            }
            $arr[] = [
                'name' => $program->name,
                'data' => $data  
            ];
            
        }

        return $y =[
            'categories' => $years,
            'programs' => $programs,
            'provinces' => LocationProvince::whereIn('code',$provinces)->get(),
            'lists' => $arr
        ];
    }

    public function chartered($code){
        $programs = ListProgram::where('is_sub',1)->get();
        $municipalities = LocationMunicipality::where('is_chartered',1)->where('province_code',$code)->get();
        $arr3 = [];
        foreach($municipalities as $municipality){
            $districts = ScholarAddress::select('district', \DB::raw('count(*) as total'))
            ->where('municipality_code',$municipality->code)
            ->groupBy('district')->get();
           
            $array2 = [];
            foreach($districts as $district){
                $dis = $district->district;
                $array = [];
                foreach($programs as $program){
                    $data = Scholar::whereHas('addresses',function ($query) use ($municipality,$dis) {
                        $query->where('municipality_code',$municipality->code)->where('district',$dis)->where('is_permanent',1);
                    })
                    ->where('program_id',$program->id)->count();

                    $array[] = [
                        'program' => $program->name,
                        'count' => $data
                    ];
                }
                $array2[] = [
                    'district' => ($district->district != null) ? $district->district : 'not set',
                    'counts' => $array,
                    'total' => $district->total
                ];
            }

            $arr3[] =[
                'municipality' => $municipality->name,
                'data' => $array2
            ];

        }
        return $arr3;
    }

    public function edit($code){
        $programs = ListProgram::where('is_sub',1)->get();
        $province = LocationProvince::withCount('scholars')->with('region')->where('code',$code)->first();

        $districts = ScholarAddress::select('district', \DB::raw('count(*) as total'))
        ->whereHas('municipality',function ($query) {
            $query->where('is_chartered',0);
        })
        ->where('province_code',$code)->groupBy('district')->get();
        
        $array2 = [];
        foreach($districts as $district){
            $dis = $district->district;
            $array = [];
            foreach($programs as $program){
                $data = Scholar::whereHas('addresses',function ($query) use ($code,$dis) {
                    $query->where('province_code',$code)->where('district',$dis)->where('is_permanent',1);
                })
                ->where('program_id',$program->id)->count();

                $array[] = [
                    'program' => $program->name,
                    'count' => $data
                ];
            }
            $array2[] = [
                'district' => $district->district,
                'counts' => $array,
                'total' => $district->total
            ];
        }

        return [
            'first' => $this->second($code),
            'province' => $province,
            'districts' => $array2,
            'programs' => $programs,
            'categories' => $this->years2($code),
            'chartered' => $this->chartered($code)
            // 'count' => $count,
            // 'code' => $code
        ];
    }

    public function years2($code){
        $programs = ListProgram::where('is_sub',1)->get();
        $current_year =  date('Y'); $years = [];
        $province = $code;

        $prog = []; 
        foreach($programs as $program){
            $data = []; $year = $current_year - 20;
            for($year; $year <= $current_year; $year++){
                $years[] = $year;
                $data[] = ListProgram::where('id',$program->id)->withCount([
                'scholar', 
                'scholar as scholar_count' => function ($query) use ($year,$province){
                    $query->where('awarded_year', $year)
                        ->whereHas('addresses',function ($query) use ($province) {
                            ($province != null) ? $query->where('province_code', $province)->where('is_permanent',1) : '';
                        });
                }])->pluck('scholar_count')->first();
            }
            $arr[] = [
                'name' => $program->name,
                'data' => $data  
            ];
            
        }

        return $y =[
            'categories' => $years,
            'programs' => $programs,
            'lists' => $arr
        ];
    }
}
