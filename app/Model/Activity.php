<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $casts = [
        'activities' => 'array'
    ];
}
