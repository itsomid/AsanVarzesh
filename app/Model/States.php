<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    //
    public function cities() {

        return $this->hasMany('App\Model\Cities','state_id');

    }
}
