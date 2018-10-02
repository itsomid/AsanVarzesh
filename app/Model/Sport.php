<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Model\Sport
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $coach_profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $coaches
 * @property-read mixed $url_image
 * @property-read mixed $highest_price
 * @property-read mixed $lowest_price
 * @mixin \Eloquent
 */
class Sport extends Model
{
    protected $appends = [
        'url_image',
        'lowestPrice',
        'highestPrice'
    ];

    public function coaches()
    {
        return $this->belongsToMany('App\User','coach_sport','sport_id','coach_id')->withPivot('price');
    }

    public function coach_profile()
    {
        return $user = $this->belongsToMany('App\User','coach_sport','sport_id','coach_id');
    }

    public function federation()
    {
        return $user = $this->hasOne('App\Model\Federation','id','federation_id');
    }

    public function getUrlImageAttribute()
    {
        if($this->image == '') {
            return url('images/placeholder.png');
        } else {
            return $this->image;
        }

    }

    public function gethighestPriceAttribute()
    {
        $coach_sport = Coach_sport::whereRaw('price = (select max(`price`) from coach_sport)')->first(['price']);
        return $coach_sport->price;
    }

    public function getlowestPriceAttribute()
    {
        $coach_sport = Coach_sport::whereRaw('price = (select min(`price`) from coach_sport)')->first(['price']);
        return $coach_sport->price;
    }

    public function trainings() {

        return $this->hasMany('App\Model\Training');

    }




}
