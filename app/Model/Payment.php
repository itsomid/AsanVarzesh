<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Payment
 *
 * @mixin \Eloquent
 */
class Payment extends Model
{

    public static function tax() {
        return 0.09;
    }

    public static function calTax($price) {
        return ceil($price * self::tax());
    }

    public static function insurance() {
        return 100000;
        // TODO: MUST RIAL
    }

    public function program()
    {
        return $this->hasOne('App\Model\Programs','id','program_id');
    }

    public function coach()
    {
        return $this->hasOne('App\User','id','coach_id');
    }

    public function corrective()
    {
        return $this->hasOne('App\User','id','coach_id');
    }

    public function nutrition()
    {
        return $this->hasOne('App\User','id','coach_id');
    }



    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    public function subscription()
    {
        return $this->hasOne('App\Model\Subscription','id','program_id');
    }

    public static function calculatePrice($price,$promotion) {
        return round(  ( $price + ($price * self::tax()) + self::insurance() ) - $promotion );
    }



}
