<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\ListAgency;
use App\Models\ListCourse;
use App\Models\ListDropdown;
use App\Models\ListStatus;
use App\Models\ListProgram;
use App\Models\ListPrivilege;
use App\Models\LocationRegion;
use App\Models\LocationBarangay;
use App\Models\LocationProvince;
use App\Models\LocationMunicipality;
use App\Models\School;
use App\Models\SchoolCampus;
use App\Models\SchoolCourse;
use App\Models\Scholar;
use App\Models\ScholarEducation;
use App\Models\ScholarProfile;
use App\Models\ScholarAddress;
use Illuminate\Http\Request;

class SyncController extends Controller
{
    public $link, $api;

    public function __construct()
    {
        $this->link = config('app.api_link');
        $this->api = config('app.api_key');
    }
    
    public function addresses($type,$category){
        if($category == 'all'){
            $arrays = ['regions','provinces','municipalities','barangays'];
        }else{
            $arrays = [];
            array_push($arrays,strtolower($category));
        }
        set_time_limit(0);

        foreach($arrays as $array){
            try{
                $url = $this->link.'/api/01101011%2001110010%2001100001%2001100100/location/'.$array;
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '.$this->api
                  ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);
            //    $datas = response()->json(json_decode($response));
                $datas = json_decode($response);
                $addresses = [];
                foreach($datas as $data){
                    switch($array){
                        case 'regions':
                            ($type == 'check') ? $regions[] = (array)$data : $q = LocationRegion::insertOrIgnore((array)$data); 
                        break;
                        case 'provinces':
                            ($type == 'check') ? $provinces[] = (array)$data : $q = LocationProvince::insertOrIgnore((array)$data); 
                        break;
                        case 'municipalities':
                            ($type == 'check') ? $municipalities[] = (array)$data : $q = LocationMunicipality::insertOrIgnore((array)$data); 
                        break;
                        case 'barangays':
                            ($type == 'check') ? $barangays[] = (array)$data : $q = LocationBarangay::insertOrIgnore((array)$data); 
                        break;
                    }
                    
                }
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }

        if($type == 'check'){
            $addresses = [
                'Regions' => [
                    'downloaded' => LocationRegion::count(),
                    'count' => count($regions)
                ],
                'Provinces' => [
                    'downloaded' => LocationProvince::count(),
                    'count' => count($provinces)
                ],
                'Municipalities' => [
                    'downloaded' => LocationMunicipality::count(),
                    'count' => count($municipalities)
                ],
                'Barangays' => [
                    'downloaded' => LocationBarangay::count(),
                    'count' => count($barangays)
                ]
            ];
            return $addresses;
        }
        if($category == 'all') {
            return true;
        }else{
            switch($array){
                case 'regions':
                    return LocationRegion::count();
                break;
                case 'provinces':
                    return LocationProvince::count();
                break;
                case 'municipalities':
                    return LocationMunicipality::count();
                break;
                case 'barangays':
                    return LocationBarangay::count();
                break;
            }
        }
        
    }

    public function lists($type,$category){
        if($category == 'all'){
            $arrays = ['agencies','dropdowns','programs','privileges','courses','statuses'];
        }else{
            $arrays = [];
            array_push($arrays,strtolower($category));
        }
        set_time_limit(0);

        foreach($arrays as $array){
            try{
                $url = $this->link.'/api/01101011%2001110010%2001100001%2001100100/'.$array;
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '.$this->api
                  ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);
                //$datas = response()->json(json_decode($response));
                $datas = json_decode($response);
                foreach($datas as $data){
                    switch($array){
                        case 'agencies':
                            ($type == 'check') ? $agencies[] = (array)$data : $q = ListAgency::insertOrIgnore((array)$data); 
                        break;
                        case 'dropdowns':
                            ($type == 'check') ? $dropdowns[] = (array)$data : $q = ListDropdown::insertOrIgnore((array)$data); 
                        break;
                        case 'courses':
                            ($type == 'check') ? $courses[] = (array)$data : $q = ListCourse::insertOrIgnore((array)$data); 
                        break;
                        case 'statuses':
                            ($type == 'check') ? $statuses[] = (array)$data : $q = ListStatus::insertOrIgnore((array)$data); 
                        break;
                        case 'programs':
                            ($type == 'check') ? $programs[] = (array)$data : $q = ListProgram::insertOrIgnore((array)$data); 
                        break;
                        case 'privileges':
                            ($type == 'check') ? $privileges[] = (array)$data : $q = ListPrivilege::insertOrIgnore((array)$data); 
                        break;
                    }
                    
                }
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }
        
        if($type == 'check'){
            $addresses = [
                'Dropdowns' => [
                    'data' => ListDropdown::all(),
                    'downloaded' => ListDropdown::count(),
                    'count' => count($dropdowns)
                ],
                'Agencies' => [
                    'data' => ListAgency::all(),
                    'downloaded' => ListAgency::count(),
                    'count' => count($agencies)
                ],
                // 'Courses' => [
                //     'data' => ListCourse::all(),
                //     'downloaded' => ListCourse::count(),
                //     'count' => count($courses)
                // ],
                'Status' => [
                    'data' => ListStatus::all(),
                    'downloaded' => ListStatus::count(),
                    'count' => count($statuses)
                ],
                'Privileges' => [
                    'data' => ListPrivilege::all(),
                    'downloaded' => ListPrivilege::count(),
                    'count' => count($privileges)
                ],
                'Programs' => [
                    'data' => ListProgram::all(),
                    'downloaded' => ListProgram::count(),
                    'count' => count($programs)
                ],
            ];
            return $addresses;
        }else{
            try{
                $url = $this->link.'/api/01101011%2001110010%2001100001%2001100100/settings';
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '.$this->api
                  ),
                ));
    
                $response = curl_exec($curl);
                curl_close($curl);
                $datas = json_decode($response);
                
                
                $information = [
                    'address' => '',
                    'facebook' => '',
                    'telephone' => '',
                    'fax' => '',
                    'mobile' => '',
                ];

                $signatories = [
                    'Approved By' => [
                        'name' => '',
                        'position' => ''
                    ],
                    'Prepared By' => [
                        'name' => '',
                        'position' => ''
                    ],
                    'Certified Correct' => [
                        'name' => '',
                        'position' => ''
                    ],
                    'Reviewed By' => [
                        'name' => '',
                        'position' => ''
                    ],
                    'Verified Correct' => [
                        'name' => '',
                        'position' => ''
                    ],
                ];
                

                $data = new Setting;
                $data->year = date('Y');
                $data->information = json_encode($information);
                $data->signatories = json_encode($signatories);
                $data->agency_id = $datas;
                $data->save();
    
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }

        if($category == 'all') {
            return true;
        }else{
            switch($array){
                case 'agencies':
                    return ListAgency::count();
                break;
                case 'dropdowns':
                    return ListDropdown::count();
                break;
                case 'courses':
                    return ListCourse::count();
                break;
                case 'expenses':
                    return ListExpense::count();
                break;
                case 'programs':
                    return ListProgram::count();
                break;
                case 'privileges':
                    return ListPrivilege::count();
                break;
            }
        }
    }

    public function schools($type,$category,$agency_id = null){
        // if($category == 'local' || $category == 'all'){
        //     $agency_id = config('app.agency');
        //     $agency = ListAgency::where('id',$agency_id)->first();
        //     $region_code = $agency->region_code;
        // }else{ //custom region
        //     $agency_id = $agency_id;
        //     $agency = ListAgency::where('id',$agency_id)->first();
        //     $region_code = $agency->region_code;
        // }

        try{
            $url = $this->link.'/api/01101011%2001110010%2001100001%2001100100/schools';
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$this->api
              ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $datas = json_decode($response);
            if($type == 'check'){
                $s[] = (array)$datas->data;
            }else{
                $lists= $datas;
                foreach($lists as $data){
                    $arr = (array)$data;
                    $campuses = array_splice($arr,9);
                    $q = School::insertOrIgnore($arr);
                    foreach($data->campuses as $campus)
                    {   
                        $lst1 = (array)$campus;
                        $lst = array_pop($lst1);
                        $q = SchoolCampus::insertOrIgnore($lst1);
                        foreach($lst as $course){
                            $q = SchoolCourse::insertOrIgnore((array)$course);
                        }
                    } 
                }
            } 

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        if($type == 'check'){
            $agency_id = config('app.agency');
            $agency = ListAgency::where('id',$agency_id)->first();
            $region = $agency->region_code;

            $schools = [
                'overall' => [
                    'all' => $datas->schools,
                    'campuses' => $datas->campuses,
                    'downloaded_schools' => School::count(),
                    'downloaded_campuses' => SchoolCampus::count(),
                ],
                'regional' => [
                    'all' => $datas->region_schools,
                    'campuses' => $datas->region_campuses,
                    'downloaded_schools' => School::whereHas('campuses',function ($query) use ($region) {
                        $query->whereHas('municipality',function ($query) use ($region) {
                            $query->whereHas('province',function ($query) use ($region) {
                                $query->whereHas('region',function ($query) use ($region) {
                                    $query->where('region_code',$region);
                                });
                            });
                        });
                    })->count(),
                    'downloaded_campuses' => SchoolCampus::whereHas('municipality',function ($query) use ($region) {
                        $query->whereHas('province',function ($query) use ($region) {
                            $query->whereHas('region',function ($query) use ($region) {
                                $query->where('region_code',$region);
                            });
                        });
                    })->count(),
                    'other_schools' => School::whereHas('campuses',function ($query) use ($region) {
                        $query->whereHas('municipality',function ($query) use ($region) {
                            $query->whereHas('province',function ($query) use ($region) {
                                $query->whereHas('region',function ($query) use ($region) {
                                    $query->where('region_code','!=',$region);
                                });
                            });
                        });
                    })->count(),
                    'other_campuses' => SchoolCampus::whereHas('municipality',function ($query) use ($region) {
                        $query->whereHas('province',function ($query) use ($region) {
                            $query->whereHas('region',function ($query) use ($region) {
                                $query->where('region_code','!=',$region);
                            });
                        });
                    })->count(),
                ]
            ];
            return $schools;
        }else{
            return true;
        }
    }

    public function allSchools(){
        $url = $this->link.'/api/01101011%2001110010%2001100001%2001100100/schools/all';
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$this->api
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $datas = json_decode($response);
        return $datas;
    }

    public function schoolcount(){
        $url = $this->link.'/api/01101011%2001110010%2001100001%2001100100/schools/count';
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $datas = $response;
        return $datas;
    }

    public function scholars(){
        try{
            $url = $this->link.'/api/01101011%2001110010%2001100001%2001100100/scholars/kradworkz';
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$this->api
              ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $datas = json_decode($response);
            
            $result = \DB::transaction(function () use ($datas){
                $users = array();
                $success = array();
                $failed = array();
                $duplicate = array();
                
                $lists= $datas;
                
                foreach($lists as $data){
                    $arr = (array)$data;
                    $sub = array_splice($arr,11);
                    $spas_id = $arr['spas_id'];
                    $count = Scholar::where('spas_id',$spas_id)->count();
                    if($count == 0){
                        $address = $sub['addresses'][0];
                        $education = $sub['education'];
                        $profile = $sub['profile'];

                        // dd($address,$education,$profile);
                        \DB::beginTransaction();
                        $q = Scholar::insertOrIgnore($arr);
                        Scholar::where('spas_id',$spas_id)->where('subprogram_id',26)->update(['is_undergrad' => 0]);
                        if($q){
                            $a = ScholarAddress::insertOrIgnore((array)$address);
                            if($a){
                                $b = ScholarProfile::insertOrIgnore((array)$profile);
                                if($b){
                                    $c = ScholarEducation::insertOrIgnore((array)$education);
                                    if($c){
                                        array_push($success,$spas_id);
                                        \DB::commit();
                                    }else{
                                        array_push($failed,$spas_id);
                                        \DB::rollback();
                                    }
                                }else{
                                    array_push($failed,$spas_id);
                                    \DB::rollback();
                                }
                            }else{
                                array_push($failed,$spas_id);
                                \DB::rollback();
                            }
                        }else{
                            array_push($failed,$spas_id);
                            \DB::rollback();
                        }
                    }else{
                        array_push($duplicate,$spas_id);
                    }
                }

                $result = [
                    'success' => $success,
                    'failed' => $failed,
                    'duplicate' => $duplicate,
                ];
                return $result;
            });


        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        return $result;
    }

    

}
