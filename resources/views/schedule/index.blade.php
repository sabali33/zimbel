@extends('layouts.app')

@section('content')
    <div class="admin-dashboard flex content-between">
        <x-nav-admin/>
        <x-admin-bg>
            <x-slot name="title">
                Schedules
            </x-slot>
            
            @if($schedules->count())
                <ul>
                    @foreach($schedules as $schedule)
                    <x-list>
                        <span class="w-12">#{{$schedule->id}}</span>
                        <div class="text-gray-500 ml-4 w-5/6">
                            Customer <b class="text-black">{{$schedule->customer->first_name}}</b> has set a reminder at <b class="text-black">{{'time'}} </b>has been set for schedule <b class="text-black">#{{$schedule->remote_schedule_id}}</b> for {{ $schedule->api_root}}
                        </div>
                    </x-list>
                </ul>
                @endforeach
            @else
            <p><i>No schedules have been shared</i></p>
            @endif
            <div class="pagination mt-10">
                {{
                    $schedules->links()
                }}
            </div>
        </x-admin-bg>
    </div>
@endsection