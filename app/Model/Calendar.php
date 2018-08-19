<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    public function meal()
    {

        return $this->hasOne('App\Model\Meal','id','meal_id');

    }

    public function package()
    {

        return $this->hasOne('App\Model\Package','id','package_id');

    }

}
