<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * App\Model\Profiles
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Role[] $coaches
 * @property mixed $location
 * @property mixed $weight
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
            return (string) $program->weight;
        } else {
            return (string) $this->attributes['weight'];
        }

    }

    public function getheightAttribute()
    {
        return (string) $this->attributes['height'];

    }

    public function getavatarAttribute()
    {
        if($this->attributes['avatar'] != null OR $this->attributes['avatar'] != '') {
            return url($this->attributes['avatar']);
        }
        return null;

    }

    public function getphotosAttribute()
    {
        $photos = [];
        if(isset($this->attributes['photos']) OR $this->attributes['photos'] != null) {
            foreach (\GuzzleHttp\json_decode($this->attributes['photos'],1) as $item) {
                array_push($photos,Storage::url($item));
            }
            return $photos;
        }
        return null;

    }

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    public function city()
    {
        return $this->hasOne('App\Model\Cities','id','city_id');
    }

    public function setLocationAttribute($value)
    {
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
