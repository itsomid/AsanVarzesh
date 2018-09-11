<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\FoodPackage
 *
 * @property-read \App\Model\Package $package
 * @mixin \Eloquent
 */
class FoodPackage extends Model
{
    protected $table = 'food_package';

    public function package()
    {

        return $this->hasOne('App\Model\Package','id','package_id');

    }
}
