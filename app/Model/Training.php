<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Training
 *
 * @property-read \App\Model\Sport $sport
 * @mixin \Eloquent
 */
class Training extends Model
{
    //
    protected $casts = [
        'steps' => 'array',
        'attribute' => 'array'
    ];

//    protected $appends = [
//        'image'
//    ];

    public function sport()
    {
        return $this->hasOne('App\Model\Sport','id','sport_id');
    }

    public function accessories()
    {
        return $this->belongsToMany('App\Model\Accessory');
    }

//    public function getImageAttribute() {
//        return null;
//    }

    public function getimageAttribute()
    {
        if($this->attributes['image'] != null OR $this->attributes['image'] != '') {
            return url($this->attributes['image']);
        }
        return null;

    }

    public function getattachmentAttribute()
    {
        if($this->attributes['attachment'] != null OR $this->attributes['attachment'] != '') {
            return url($this->attributes['attachment']);
        }
        return null;

    }

    public function getAudioShortAttribute()
    {
        if($this->attributes['audio_short'] != null OR $this->attributes['audio_short'] != '') {
            return url($this->attributes['audio_short']);
        }
        return null;

    }

    public function getAudioFullAttribute()
    {
        if($this->attributes['audio_full'] != null OR $this->attributes['audio_full'] != '') {
            return url($this->attributes['audio_full']);
        }
        return null;

    }

}
