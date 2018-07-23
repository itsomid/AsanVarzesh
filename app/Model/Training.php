<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    //
    protected $casts = [
        'steps' => 'array'
    ];
}
