<?php

namespace App\Http\Traits\Scholars;

use App\Models\Scholar;
use App\Models\ScholarProfile;
use App\Models\ScholarAddress;
use App\Models\ScholarEducation;

trait Api { 

    public $link, $api;

    public function __construct()
    {
        $this->link = config('app.api_link');
        $this->api = config('app.api_key');
    }

    public function api($request){
        $subtype = $request->subtype;
        switch($subtype){
            case 'scholars':
                return $this->api_scholars();
            break;
            case 'sync':
                return $this->api_sync();
            break;
        }
    }
    
    public function api_scholars(){
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
                    unset($arr['id']);
                    $count = Scholar::where('spas_id',$spas_id)->count();
                    if($count == 0){
                        $address = $sub['address'];
                        unset($address->id);
                        $education = $sub['education'];
                        unset($education->id);
                        $profile = $sub['profile'];
                        unset($profile->id);
                

                        // dd($address,$education,$profile);
                        \DB::beginTransaction();
                        $q = Scholar::insertOrIgnore($arr);
                        Scholar::where('spas_id',$spas_id)->where('subprogram_id',26)->update(['is_undergrad' => 0]);
                        $isko =  Scholar::select('id')->where('spas_id',$spas_id)->first();

                        if($q){
                            $address->scholar_id = $isko->id;
                            $education->scholar_id = $isko->id;
                            $profile->scholar_id = $isko->id;
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

    public function api_sync(){
        
        $scholars = Scholar::where('is_synced',0)->get();
        $profiles = ScholarProfile::with('scholar:id,spas_id')->where('is_synced',0)->get();
        $addresses = ScholarAddress::with('scholar:id,spas_id')->where('is_synced',0)->get();
        $educations = ScholarEducation::with('scholar:id,spas_id')->where('is_synced',0)->get();

        $postData = array(
            'scholars' => $scholars,
            'addresses' => $addresses,
            'educations' => $educations,
            'profiles' => $profiles,
            'type' => 'sync'
        );

        try{
            $url = $this->link.'/api/01101011%2001110010%2001100001%2001100100/scholars';
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
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$this->api,
                'Content-Type: application/json',
              ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $datas = json_decode($response);

            $synced = $datas->success;
            foreach($synced as $s){
                $spas_id = $s->spas_id;
                switch($s->type){
                    case 'address':
                        $check = ScholarAddress::whereHas('scholar',function ($query) use ($spas_id) {
                            $query->where('spas_id',$spas_id);
                        })->update(['is_synced' => 1]);
                    break;
                    case 'profile':
                        ScholarProfile::whereHas('scholar',function ($query) use ($spas_id) {
                            $query->where('spas_id',$spas_id);
                        })->update(['is_synced' => 1]);
                    break;
                    case 'education':
                        ScholarEducation::whereHas('scholar',function ($query) use ($spas_id) {
                            $query->where('spas_id',$spas_id);
                        })->update(['is_synced' => 1]);
                    break;
                    case 'scholar':
                        Scholar::where('spas_id',$spas_id)->update(['is_synced' => 1]);
                    break;
                }
            }

            return back()->with([
                'message' => 'Scholars synced successfully. Thanks',
                'data' =>  count($synced),
                'type' => 'bxs-check-circle'
            ]); 

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

}