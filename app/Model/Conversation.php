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
    //

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
}
