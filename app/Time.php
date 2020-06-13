<?php

namespace App;

use App\Schedule;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $guarded = [];
    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'schedule_time');
    }
    public function create_or_find($schedule)
    {
        if( !$schedule ){
            return;
        }
        $data = $schedule->parse_times();
        $repeat_frequency = $schedule->repeat_frequency;
        
        $parse_data = $this->parse_data($data, $repeat_frequency);
        $times = [];
        foreach( $parse_data as $time_arr ){
            $time = Time::where([
                ['repeat_frequency', '=', $time_arr['repeat_frequency']],
                ['repeat_frequency_unit', '=', ($time_arr['repeat_frequency_unit']?? null)],
                ['time', '=', $time_arr['time']]
            ])->get();
            if($time->count()){
                $times[] = $time->first()->id;
            }else{
                $time = Time::create($time_arr);
                $times[] = $time->id;
            }
        }
        return $times;
    }
    public function parse_data($data, $repeat_frequency){
        if( !$data ){
            return;
        }
        $parse_data = [];
        if($repeat_frequency === 'daily'){
            foreach( $data as $time ){
                $parse_data[] = [
                    'repeat_frequency' => $repeat_frequency,
                    'time' => $time,
                    'repeat_frequency_unit' => null,
                ];
            }
        }
        return $parse_data;

        foreach( $data as $day => $times ){
            foreach($times as $time){
                $parse_data[] = [
                    'repeat_frequency' => $repeat_frequency,
                    'time' => $time,
                    'repeat_frequency_unit' => $repeat_frequency,
                ];
            }
        }
        return $parse_data;
    }
}
