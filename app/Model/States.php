<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\States
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Cities[] $cities
 * @mixin \Eloquent
 */
class States extends Model
{
    //
    public function cities() {

        return $this->hasMany('App\Model\Cities','state_id');

    }
}
