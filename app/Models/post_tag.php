<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class post_tag extends Model
{
    protected $fillable = [
        'post_id', 'tag_id'
    ];
}
