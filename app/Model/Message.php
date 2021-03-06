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

    protected $casts = [
        'read_status' => 'array'
    ];

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    public function conversation()
    {
        return $this->hasOne('App\Model\Conversation','id','conversation_id');
    }

    public function getattachmentAttribute()
    {
        if($this->attributes['attachment'] != null OR $this->attributes['attachment'] != '') {
            return url($this->attributes['attachment']);
        }
        return null;

    }
}
