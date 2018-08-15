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

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    public function coach()
    {
        return $this->hasOne('App\User','id','coach_id');
    }

    public function sport()
    {

        return $this->hasOne('App\Model\Sport','id','sport_id');

    }
}
