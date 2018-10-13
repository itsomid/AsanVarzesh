<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Programs
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Calendar[] $calendar
 * @property-read \App\User $coach
 * @property-read \App\User $corrective_dr
 * @property-read \App\User $nutrition_dr
 * @property-read \App\Model\Sport $sport
 * @property-read \App\User $user
 * @mixin \Eloquent
 */
class Programs extends Model
{
    //
    protected $casts = [
        'items' => 'array',
        'configuration' => 'array',
        'time_of_exercises' => 'array'
    ];

    protected $appends = [
        'militaryservices',
        'budget',
        'appetite'
    ];

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    public function coach()
    {
        return $this->hasOne('App\User','id','coach_id');
    }

    public function nutrition_doctor()
    {
        return $this->hasOne('App\User','id','nutrition_doctor_id');
    }

    public function corrective_doctor()
    {
        return $this->hasOne('App\User','id','corrective_doctor_id');
    }

    public function sport()
    {
        return $this->hasOne('App\Model\Sport','id','sport_id');
    }

    public function calendar()
    {
        return $this->hasMany('App\Model\Calendar','program_id','id');
    }

    public function conversations()
    {
        return $this->belongsTo('App\Model\Conversation','program_id','id');
    }

    public function subscription()
    {
        return $this->hasOne('App\Model\Subscription','program_id','id');
    }

    public function getmilitaryservicesAttribute()
    {
        $profile = Profiles::where('id',$this->user_id)->first(['military_services']);
        return $profile->military_services;
    }

    public function getbudgetAttribute()
    {
        $profile = Profiles::where('id',$this->user_id)->first(['budget']);
        return $profile->budget;
    }

    public function getappetiteAttribute()
    {
        $profile = Profiles::where('id',$this->user_id)->first(['appetite']);
        return $profile->appetite;
    }
}
