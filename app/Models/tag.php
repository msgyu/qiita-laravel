<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tag extends Model
{
    protected $fillable = [
        'name'
    ];

    public function tags()
    {
        return $this->belongsToMany('App\Models\Post', 'post_tags');
    }
}
