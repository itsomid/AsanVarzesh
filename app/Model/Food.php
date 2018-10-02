<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Food
 *
 * @mixin \Eloquent
 */
class Food extends Model
{
    public function category() {
        return $this->hasOne('App\Model\FoodCategory','id','food_category_id');
    }
}
