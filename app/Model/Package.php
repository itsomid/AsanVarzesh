<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{

    public function foods()
    {

        return $this->belongsToMany('App\Model\Food');

    }

}
