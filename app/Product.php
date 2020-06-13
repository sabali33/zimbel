<?php

namespace App;

use App\Payment;
use Plank\Mediable\Mediable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{   
    use Mediable;
    protected $guarded = [];
    public function features()
    {
        return $this->belongsToMany(Feature::class, 'feature_product');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
}
