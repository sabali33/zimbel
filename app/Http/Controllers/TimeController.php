<?php

namespace App\Http\Controllers;

use App\Time;
use Illuminate\Http\Request;

class TimeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $times = Time::with(['schedules'])->paginate(10);
        return view('time.index', compact('times'));
    }
}
