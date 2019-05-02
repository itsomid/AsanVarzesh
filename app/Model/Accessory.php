<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Accessory
 *
 * @property-read mixed $url_image
 * @mixin \Eloquent
 */
class Accessory extends Model
{
    //
    protected $appends = ['url_image'];

    public function getUrlImageAttribute()
    {
        return url($this->img);

    }
}
