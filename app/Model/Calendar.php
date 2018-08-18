<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    public function meal()
    {

        return $this->hasOne('App\Model\Meal','id','meal_id');

    }

    public function food_package()
    {
        return $this->hasOne('App\Model\FoodPackage','id','food_package_id');
    }
}
