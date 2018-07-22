<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{

    public function states() {
        return $this->hasMany('App\Model\States','country_id');
    }

}
