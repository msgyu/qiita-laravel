<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class likes_count extends Model
{
    public function post()
    {
        return $this->belongsTo('App\Models\post');
    }
}
