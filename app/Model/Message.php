<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Message
 *
 * @property-read \App\User $user
 * @mixin \Eloquent
 */
class Message extends Model
{
    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }
}
