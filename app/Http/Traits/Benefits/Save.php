<?php

namespace App\Http\Traits\Benefits;

use Hashids\Hashids;
use App\Models\Release;
use App\Models\ScholarBenefit;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\Scholar\Benefits\ReleaseResource;

trait Save { 
    
    public function completed($request){
        $data = \DB::transaction(function () use ($request){
            $attachments = $this->upload($request);
            $benefit = ScholarBenefit::where('release_id',$request->id)->update(['status_id' => 13]);
            $data = Release::where('id',$request->id)->update(['status_id' => 13, 'attachment' => json_encode($attachments)]);
            $data = Release::where('id',$request->id)->first();
            return new ReleaseResource($data);
        });
        
        return back()->with([
            'message' => 'Mark as completed. Thanks',
            'data' =>  $data,
            'type' => 'bxs-check-circle'
        ]); 
    }

    public static function pending($request){
        $data = \DB::transaction(function () use ($request){
            $attachment = [];
            $count = Release::whereYear('created_at',now())->count();
            $data = Release::create(
                array_merge($request->all(),[
                    'attachment' => json_encode($attachment),
                    'added_by' => \Auth::user()->id,
                    'batch' => str_pad(($count+1), 5, '0', STR_PAD_LEFT),
                    'status_id' => 11
                ])
            );
            foreach($request->lists as $list){
                foreach($list['benefits'] as $benefit){
                    $benefit = ScholarBenefit::where('id',$benefit['id'])->first();
                    $benefit->status_id = 12;
                    $benefit->release_id = $data->id;
                    $benefit->save();
                }
            }
            return $data;
        });

        return back()->with([
            'message' => 'Released was successfull. Thanks',
            'data' =>  $data,
            'type' => 'bxs-check-circle'
        ]); 
    }

    public function upload($request){
        if($request->hasFile('attachment'))
        {   
            $id = $request->batch;
            $year = date('Y');
            $files = $request->file('attachment');   
            foreach ($files as $key=>$file) {
                if($key == 0){
                    $file_name = 'release_'.$id.'_'.$year.'.'.$file->getClientOriginalExtension();
                }else{
                    $file_name = 'release_'.$id.'_'.$year.'-'.$key.'.'.$file->getClientOriginalExtension();
                }
                $file_path = $file->storeAs('benefits', $file_name, 'public');
                
                $attachment[] = [
                    'name' => $file_name,
                    'file' => $file_path,
                    'added_by' => \Auth::user()->id,
                    'created_at' => date('M d, Y g:i a', strtotime(now()))
                ];
            }
            return $attachment;
        }
    }
}