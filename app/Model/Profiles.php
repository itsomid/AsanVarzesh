<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    //

    protected $casts = [
        'photos' => 'array'
    ];

    public function user() {

        return $this->hasOne('App\User','id','user_id');

    }

    public function coachs() {

        return $this->hasMany('App\Model\Role','user_id','role_id');

    }


}
