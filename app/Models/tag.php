<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tag extends Model
{
    public function tags()
    {
        return $this->belongsToMany('App\Models\Post', 'post_tags');
    }
}
