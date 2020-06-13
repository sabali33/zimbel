<?php

namespace App;

use App\Product;
use App\Customer;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];
    public function customer()
    {
        return $this->belongsTo( Customer::class );
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
