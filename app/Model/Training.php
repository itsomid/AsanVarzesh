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

    public function getAttributeAttribute()
    {
        $attrib = \GuzzleHttp\json_decode($this->attributes['attribute'],true);

        return [
            'set' => ($attrib['set'] == 0 OR $attrib['set'] == '')  ? null : (string) $attrib['set'],
            'time' => ($attrib['time'] == 0 OR $attrib['time'] == '')  ? null : (string) $attrib['time'],
            'speed' => ($attrib['speed'] == 0 OR $attrib['speed'] == '')  ? null : (string) $attrib['speed'],
            'energy' => ($attrib['energy'] == 0 OR $attrib['energy'] == '')  ? null : (string) $attrib['energy'],
            'distance' => ($attrib['distance'] == 0 OR $attrib['distance'] == '')  ? null : (string) $attrib['distance'],
            'each_set' => ($attrib['each_set'] == 0 OR $attrib['each_set'] == '')  ? null : (string) $attrib['each_set'],
            'unit_speed' => ($attrib['unit_speed'] == 0 OR $attrib['unit_speed'] == '')  ? null : (string) $attrib['unit_speed'],
            'time_each_set' => ($attrib['time_each_set'] == 0 OR $attrib['time_each_set'] == '')  ? null : (string) $attrib['time_each_set'],
        ];

    }




}
