<?php

namespace App;

use App\Product;
use Plank\Mediable\Mediable;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use Mediable;
    protected $guarded = [];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'feature_product');
    }
}
