<?php

namespace App;

use App\Product;
use App\Customer;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $guarded = [];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function is_valid(){
        $now = new \DateTime();
        $expiry_date = new \DateTime($this->expiry_date);
        return $expiry_date->getTimestamp() > $now->getTimestamp();
    }
}
