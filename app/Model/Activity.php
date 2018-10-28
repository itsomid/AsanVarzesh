<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public function calendar() {

        return $this->hasMany('App\Model\Calendar','id','calendar_id');

    }
}
