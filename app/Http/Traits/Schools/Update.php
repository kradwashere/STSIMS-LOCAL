<?php

namespace App\Http\Traits\Schools;

use App\Models\SchoolCourseProspectus;

trait Update { 
    
    public static function updateProspectus($request){
        $data = SchoolCourseProspectus::where('id',$request->id)->first();
        $data->update($request->except('editable'));
        
        return back()->with([
            'data' => $data,
            'message' => 'Prospectus successfully updated. Thanks',
            'type' => 'bxs-check-circle',
            'color' => 'success'
        ]);
    }

    public static function lock($request){
        $data = SchoolCourseProspectus::where('id',$request->id)->update(['is_locked' => $request->is_locked]);
        $data = SchoolCourseProspectus::where('id',$request->id)->first();
        return back()->with([
            'data' => $data,
            'message' => 'Prospectus locked. Thanks',
            'type' => 'bxs-check-circle',
            'color' => 'success'
        ]);
    }

    public static function status($request){
        $data = SchoolCourseProspectus::where('id',$request->id)->update(['is_active' => $request->is_active]);
        $data = SchoolCourseProspectus::where('id',$request->id)->first();

        $update = SchoolCourseProspectus::where('id','!=',$request->id)->where('school_course_id',$data->school_course_id)->update(['is_active' => 0]);

        return back()->with([
            'data' => $data,
            'message' => 'Prospectus status updated. Thanks',
            'type' => 'bxs-check-circle',
            'color' => 'success'
        ]);
    }
}