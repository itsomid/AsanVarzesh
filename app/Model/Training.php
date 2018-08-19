<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    //
    protected $casts = [
        'steps' => 'array'
    ];

    public function sport()
    {
        return $this->hasOne('App\Model\Sport','id','sport_id');
    }
}
