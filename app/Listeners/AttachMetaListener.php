<?php

namespace App\Listeners;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AttachMetaListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Model $model, Request $request)
    {
        if($request->has('meta')){
            
            //$model->createMany($data);
        }
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
    }
}
