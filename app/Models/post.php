<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    protected $fillable = [
        'title', 'body'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'post_tags');
    }
}
