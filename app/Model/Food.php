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
    protected $casts = [
        'nutritional_value' => 'array'
    ];

    protected $appends = [
        'url_image'
    ];

    public function category() {
        return $this->hasOne('App\Model\FoodCategory','id','food_category_id');
    }

    public function getUrlImageAttribute()
    {
        if($this->image == '') {
            return url('images/placeholder.png');
        } else {
            return url($this->image);
        }

    }
}
