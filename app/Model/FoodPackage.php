<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FoodPackage extends Model
{
    protected $table = 'food_package';

    public function package()
    {

        return $this->hasOne('App\Model\Package','id','package_id');

    }
}
