<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Training
 *
 * @property-read mixed $image
 * @property-read \App\Model\Sport $sport
 * @mixin \Eloquent
 */
class Training extends Model
{
    //
    protected $casts = [
        'steps' => 'array'
    ];

    protected $appends = [
        'image'
    ];

    public function sport()
    {
        return $this->hasOne('App\Model\Sport','id','sport_id');
    }

    public function accessories()
    {
        return $this->belongsToMany('App\Model\Accessory');
    }

    public function getImageAttribute() {
        return url('/images/placeholder.png');
    }


}
