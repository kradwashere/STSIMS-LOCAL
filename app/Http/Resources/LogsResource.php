<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Jenssegers\Agent\Agent;

class LogsResource extends JsonResource
{
    public function toArray($request)
    {
        $agent = new Agent();
        $agent->setUserAgent($this->user_agent);

        if($agent->isDesktop()){
            $type = 'computer';
        }else if($agent->isMobile()){
            $type = 'smartphone';
        }else if($agent->isTablet()){
            $type = 'tablet';
        }

        return [
            'ip' => ($this->ip_address == '::1') ? '127.0.0.1' : $this->ip_address,
            'device' => $agent->device(),
            'platform' => $agent->platform(),
            'browser' =>  $agent->browser(),
            'is_desktop' => $agent->isDesktop(),
            'attempt' => ($this->login_successful) ? 'text-success' : 'text-danger',
            'name' => $this->user->profile->firstname.' '. $this->user->profile->lastname,
            'avatar' =>  $this->user->avatar,
            'login_at' => ($this->login_at != null) ? date('M d, Y g:i a', strtotime($this->login_at)) : 'n/a',
            'logout_at' => ($this->logout_at != null) ? date('M d, Y g:i a', strtotime($this->logout_at)) : 'n/a',
            'type' => $type,
            'location' => json_decode($this->location)
        ];
    }
}
