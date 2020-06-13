<?php

namespace App;

use App\Meta;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $guarded = [];

    public function meta()
    {
        return $this->morphMany(Meta::class, 'metable');
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
