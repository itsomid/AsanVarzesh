<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Model\Profiles
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Role[] $coaches
 * @property mixed $location
 * @property-read mixed $weight
 * @property-read \App\User $user
 * @mixin \Eloquent
 */
class Profiles extends Model
{
    //

    protected $casts = [
        'photos' => 'array',
        'maim' => 'array',
        'selected_days_hours' => 'array'
    ];
    protected $appends = [
        'weight'
    ];

    public function getweightAttribute()
    {
        $program = Programs::where('user_id',$this->id)->orderby('id','DESC')->first();
        if($program != null) {
            return $program->weight;
        }

    }

    public function user() {
        return $this->hasOne('App\User','id','user_id');
    }

    public function city() {
        return $this->hasOne('App\Model\Cities','id','city_id');
    }

    public function setLocationAttribute($value) {
        $this->attributes['location'] = DB::raw("POINT($value[0],$value[1])");
    }

    public function getLocationAttribute($value){

        preg_match_all('/([0-9\.]+)/',$value,$matches);
        return $matches[1];
    }

    public function coaches() {
        return $this->hasMany('App\Model\Role','user_id','role_id');
    }

    public function sports()
    {
        return $this->belongsToMany('App\Model\Sport');
    }


}
