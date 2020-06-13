<?php

namespace App\Jobs;

use App\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Services\RemoteRequestProcessor;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MakeRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $schedule;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(RemoteRequestProcessor $remote_request, Time $time)
    {
        $remote_request->post($this->schedule, $time->time);

    }
}
