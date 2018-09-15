<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Package
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Food[] $foods
 * @mixin \Eloquent
 */
class Package extends Model
{

    public function foods()
    {

        return $this->belongsToMany('App\Model\Food')->withPivot(['unit','size']);

    }

}
