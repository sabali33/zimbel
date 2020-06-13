<?php

namespace App;

use App\Time;
use App\Customer;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = [];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function times()
    {
        return $this->belongsToMany(Time::class, 'schedule_time');
    }
    public function parse_times()
    {
        if( !is_null($this->repeat_frequency) ){
            return call_user_func([$this, "parse_{$this->repeat_frequency}_times"]);
        }
        
    }
    public function parse_daily_times($hours = [])
    {
        if( !$this->hours_of_day ){
            return;
        }
        
        $hours_arr = explode(',', $this->hours_of_day );
        $times = [];
        foreach( (array) $hours_arr  as $hour ){
            $times[] = $hour.':'. $this->start_minute;
        }
        return $times;
    }
    public function parse_weekly_times()
    {
        if( $this->repeat_frequency !== 'weekly' ){
            return;
        }
        $times_of_day = $this->parse_daily_times($this->hours_of_day);
        $days_of_week = explode( ',', $this->days_of_week );
        $times = [];
        foreach( $days_of_week as $day ){
            $times[$day] = $times_of_day;
        }
        return $times;
    }
    public function parse_monthly_times()
    {
        if( $this->repeat_frequency !== 'monthly' ){
            return;
        }
        $times_of_day = $this->parse_daily_times($this->hours_of_day);
        $days_of_month = explode( ',', $this->days_of_month );
        $times = [];
        foreach( $days_of_month as $day ){
            $times[$day] = $times_of_day;
        }
        return $times;
    }
}
