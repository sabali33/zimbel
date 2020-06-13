<?php

namespace App;

use App\User;
use App\License;
use App\Payment;
use App\Schedule;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    public function licenses()
    {
        return $this->hasMany(License::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
