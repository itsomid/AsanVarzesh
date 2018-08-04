<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Programs extends Model
{
    //
    protected $casts = [
        'items' => 'array',
        'configuration' => 'array'
    ];
}
