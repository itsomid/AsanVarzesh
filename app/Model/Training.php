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

    protected $appends = [
        'image_path',
        'audio_short_path',
        'audio_full_path',
        'attachment_path',
    ];

//    public function sports() {
//        return $this->belongsToMany('App\Model\Sport');
//    }

    public function sport()
    {
        return $this->hasOne('App\Model\Sport','id','sport_id');
    }

    public function accessories()
    {
        return $this->belongsToMany('App\Model\Accessory');
    }

    public function getImageAttribute()
    {
        if($this->attributes['image'] != null OR $this->attributes['image'] != '') {
            return url($this->attributes['image']);
        }
        return '';

    }

    public function getImagePathAttribute()
    {
        if($this->attributes['image'] != null OR $this->attributes['image'] != '') {
            return $this->attributes['image'];
        }
        return '';

    }

    public function getAttachmentAttribute()
    {
        if($this->attributes['attachment'] != null OR $this->attributes['attachment'] != '') {
            return url($this->attributes['attachment']);
        }
        return '';

    }

    public function getAttachmentPathAttribute()
    {
        if($this->attributes['attachment'] != null OR $this->attributes['attachment'] != '') {
            return $this->attributes['attachment'];
        }
        return '';

    }

    public function getAudioShortAttribute()
    {
        if($this->attributes['audio_short'] != null OR $this->attributes['audio_short'] != '') {
            return url($this->attributes['audio_short']);
        }
        return '';

    }

    public function getAudioShortPathAttribute()
    {
        if($this->attributes['audio_short'] != null OR $this->attributes['audio_short'] != '') {
            return $this->attributes['audio_short'];
        }
        return '';

    }

    public function getAudioFullAttribute()
    {
        if($this->attributes['audio_full'] != null OR $this->attributes['audio_full'] != '') {
            return url($this->attributes['audio_full']);
        }
        return '';

    }

    public function getAudioFullPathAttribute()
    {
        if($this->attributes['audio_full'] != null OR $this->attributes['audio_full'] != '') {
            return $this->attributes['audio_full'];
        }
        return '';
    }


}
