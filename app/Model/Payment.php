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
    public function program()
    {
        return $this->hasOne('App\Model\Programs','id','program_id');
    }

    public function coach()
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

}
