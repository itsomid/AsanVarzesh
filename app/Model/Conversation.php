<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    //

    public function messages()
    {

        return $this->hasMany('App\Model\Message')->orderBy('id','DESC');

    }
}
