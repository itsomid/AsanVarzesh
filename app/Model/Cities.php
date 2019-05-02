<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Cities
 *
 * @mixin \Eloquent
 */
class Cities extends Model
{
    //
    public function state() {
        return $this->hasOne('App\Model\States','id','state_id');
    }
}
