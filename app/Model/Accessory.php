<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    //
    protected $appends = ['url_image'];

    public function getUrlImageAttribute()
    {
        return url($this->img);

    }
}
