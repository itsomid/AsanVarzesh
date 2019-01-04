<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Conversation
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Message[] $messages
 * @mixin \Eloquent
 */
class Conversation extends Model
{
    protected $casts = [
        'read_status' => 'array'
    ];

    protected $appends = [
        'unreadMessages'
    ];

    public function user()
    {
        return $this->belongsToMany('App\User');
    }

    public function program()
    {
        //if($this->type == 'group') {
            return $this->hasOne('App\Model\Programs','id','program_id');
        //}
    }


    public function messages()
    {

        return $this->hasMany('App\Model\Message')->orderBy('id','DESC');

    }

    public function lastMessage()
    {
        return $this->hasOne('App\Model\Message')->orderBy('id','DESC');
    }


    public function getunreadMessagesAttribute() {

        $user = auth('api')->user();
        $count = 0;
        $messages = $this->messages;
        foreach ($messages as $message) {
            $message;
            if($message->read_status[$user->id] == false) {
                ++$count;
            }

        }

        return $count;

    }
}
