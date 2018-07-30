<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Profiles extends Model
{
    //

    protected $casts = [
        'photos' => 'array',
        'maim' => 'array',
        'diseases' => 'array',
        'selected_days_hours' => 'array'
    ];

    public function user() {

        return $this->hasOne('App\User','id','user_id');

    }

    public function setLocationAttribute($value) {
        $this->attributes['location'] = DB::raw("POINT($value[0],$value[1])");
    }

    public function getLocationAttribute($value){

        preg_match_all('/([0-9\.]+)/',$value,$matches);
        return $matches[1];
    }

    public function coachs() {

        return $this->hasMany('App\Model\Role','user_id','role_id');

    }


}
