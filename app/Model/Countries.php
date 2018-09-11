<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Countries
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\States[] $states
 * @mixin \Eloquent
 */
class Countries extends Model
{

    public function states() {
        return $this->hasMany('App\Model\States','country_id');
    }

}
