<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    //
    public function coachs() {

        return $this->belongsToMany('App\User','coach_sport','sport_id','coach_id');

    }

    public function coach_profile() {

        $user = $this->belongsToMany('App\User','coach_sport','sport_id','coach_id');
        return $user;

    }
}
