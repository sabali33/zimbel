<?php
namespace App\Services;

use App\Schedule;
use Illuminate\Support\Facades\Http;
    


    class RemoteRequestProcessor 
    {
        public $schedule;

        public function __construct(Schedule $schedule)
        {
            $this->schedule = $schedule;
            $this->url = sprintf('%swp-json/saas-share/v1/remind', $schedule->api_root);
        }
        public function post($schedule=null, $time)
        {
            $schedule = $schedule ? $schedule : $this->schedule;
            $response = Http::post($this->url, [ 
                'schedule_id' => $schedule->id,
                'time' => $time 
                ] );
            if($response->successful()){
                //log
                return $response;
            }
            //return $response;
        }
    }