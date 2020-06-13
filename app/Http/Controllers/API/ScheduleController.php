<?php

namespace App\Http\Controllers\API;

use App\Time;
use App\License;
use App\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = Schedule::paginate(10);
        return json_encode($schedules);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $data = $this->validate_data($request);
        }catch(\Exception $e){
            return json_encode([
                'error' => true,
                'error_code' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
        }
        DB::beginTransaction();

        $schedule = Schedule::create($data);
        //schedule
        $times = $schedule->parse_times();
        
        $time = new Time();
        try{
            $times = $time->create_or_find( $schedule );
            $schedule->times()->sync($times);
        }catch( \Exception $e){
           DB::rollBack();
        }
        
        
        
        DB::commit();
        return json_encode($schedule);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        return json_encode($schedule);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        $data = $this->validate_data($request, true);
        $updated = $schedule->update($data);
        //make a schedule
        return $updated;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
       return $schedule->delete();
    }
    public function validate_data($request, $update=false)
    {
        $data = $request->validate([
            'remote_schedule_id' => 'numeric',
            'api_root' => 'string',
            'start_time' => 'string',
            'repeat_frequency' => 'string',
            'selected_date' => 'string',
            'days_of_week' => 'string|nullable',
            'hours_of_day' => 'string|nullable',
            'days_of_month' => 'string|nullable',
            'api_key'       => 'string',
            'start_minute'  => 'numeric'
        ]);
        $license = License::where('license_key', '=', $data['api_key'])->get()->first();
        if(!$license){
            throw new \Exception('License key could not be found', 406);
        }
        $schedule = Schedule::where([
            ['remote_schedule_id', '=', $data['remote_schedule_id']],
            ['customer_id', '=', $license->customer->id ]
        ])->get()->first();

        if( !$license ){
            throw new \Exception(
                'Invalid license',
                401,
            );
        }
        
        if(!$license->is_valid()){
            throw new \Exception("License key has expired", 403);
        }
        if($schedule && $schedule->count() && !$update){
            throw new \Exception('Schedule already in cloud', 405);
        }
        $data['customer_id'] = $license->customer->id;
        return $data;
    }
}
