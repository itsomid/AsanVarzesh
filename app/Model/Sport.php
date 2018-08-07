<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sport extends Model
{
    protected $appends = [
        'url_image',
        'lowestPrice',
        'highestPrice'
    ];

    public function coachs() {

        return $this->belongsToMany('App\User','coach_sport','sport_id','coach_id');

    }


    public function coach_profile() {

        return $user = $this->belongsToMany('App\User','coach_sport','sport_id','coach_id');

    }


    public function getUrlImageAttribute()
    {
        if($this->image == '') {
            return url('images/placeholder.png');
        } else {
            return $this->image;
        }

    }

    public function gethighestPriceAttribute() {

        $coach_sport = Coach_sport::whereRaw('price = (select max(`price`) from coach_sport)')->first(['price']);
        return $coach_sport->price;

    }

    public function getlowestPriceAttribute() {

        $coach_sport = Coach_sport::whereRaw('price = (select min(`price`) from coach_sport)')->first(['price']);
        return $coach_sport->price;

    }

}
