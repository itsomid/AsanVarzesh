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

    protected $appends = [
        'url_image'
    ];

    protected $casts = [
        'nutritional_value' => 'array'
    ];

    public function foods()
    {

        return $this->belongsToMany('App\Model\Food')->withPivot(['unit','size','title']);

    }

    public function getUrlImageAttribute()
    {
        if($this->image == '') {
            return url('images/placeholder.png');
        } else {
            return url($this->image);
        }

    }

    public function getNutritionalValueAttribute() {
        if($this->attributes['nutritional_value'] != null OR $this->attributes['nutritional_value'] != '') {
            $nutritional_value = json_decode($this->attributes['nutritional_value'],1);
            $nutritional_value[0]['size'] = (string) $nutritional_value[0]['size'];
            $nutritional_value[1]['size'] = (string) $nutritional_value[1]['size'];
            $nutritional_value[2]['size'] = (string) $nutritional_value[2]['size'];
            return $nutritional_value;
        } else {
            return '';
        }
        
        return $nutritional_value = json_decode($this->attributes['nutritional_value'],1);
    }



}
