<?php

namespace App\Console;

use App\Feature;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
        $times = Time::all();
        $times->each( function( $time ) use( $schedule ){
            $translated_funcs = [
                'monthly' => 'monthlyOn',
                'weekly'  => 'weeklyOn',
                'daily'  => 'dailyAt'
            ];
            $func = $translated_funcs[$time->repeat_frequency];
            $translated_day = $time->repeat_frequency;
            $day = $time->repeat_frequency_unit;
            if( $time->repeat_frequency === 'weekly' ){
                $translated_days = [
                    'monday' => 1,
                    'tuesday' => 2,
                    'wednesday' => 3,
                    'thursday' => 4,
                    'friday'  => 5,
                    'saturday'  => 6,
                    'sunday'  => 7
                ];
                $day = $translated_days[$time->repeat_frequency_unit];
            }
            if( $repeat_frequency === 'daily' ){
                $schedule->call(function()use($time){
                    $time->schedules->each(function($schedule){
                        MakeRequest::dispatch($schedule);
                    });
                })->$func($time->time);
                return;
            }
            $schedule->call(function() use($time){
                $time->schedules->each(function($schedule){
                    MakeRequest::dispatch($schedule);
                });
            })->$func($day, $time->time );
        });
        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
