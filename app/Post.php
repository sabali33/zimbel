<?php

namespace App;

use App\Meta;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    public function meta()
    {
        return $this->morphMany(Meta::class, 'metable');
    }
}
