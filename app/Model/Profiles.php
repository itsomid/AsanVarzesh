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
        'weight',
        'nourlphotos',
        'arm',
        'wrist',
        'abdominal',
        'waist',
        'foot_thighs',
        'ankle',
        'chest',
        'shoulder',
        'forearm',
        'hip',
        'sport_habit',
        'sport_desc',
        'nutrition_desc',
    ];



    public function getweightAttribute()
    {
        $program = Programs::where('user_id',$this->user_id)->orderby('id','DESC')->first();
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
                array_push($photos,url($item));
            }
            return $photos;
        }
        return [];

    }

    public function getNourlphotosAttribute() {
        return $this->attributes['photos'];
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

    public function lastProgram() {
        return $program = Programs::where('user_id',$this->user_id)->orderby('id','DESC')->first();
    }

    public function getArmAttribute() {
        if($this->lastProgram() != null && $this->lastProgram() != '') {
            return (string) $this->lastProgram()->arm;
        } else {
            return (string) 0;
        }
    }

    public function getWristAttribute() {
        if($this->lastProgram() != null && $this->lastProgram() != '') {
            return (string) $this->lastProgram()->wrist;
        } else {
            return (string) 0;
        }
    }

    public function getAbdominalAttribute() {
        if($this->lastProgram() != null && $this->lastProgram() != '') {
            return (string) $this->lastProgram()->abdominal;
        } else {
            return (string) 0;
        }
    }

    public function getWaistAttribute() {
        if($this->lastProgram() != null && $this->lastProgram() != '') {
            return (string) $this->lastProgram()->waist;
        } else {
            return (string) 0;
        }
    }

    public function getFootThighsAttribute() {
        if($this->lastProgram() != null && $this->lastProgram() != '') {
            return (string) $this->lastProgram()->foot_thighs;
        } else {
            return (string) 0;
        }
    }

    public function getAnkleAttribute() {
        if($this->lastProgram() != null && $this->lastProgram() != '') {
            return (string) $this->lastProgram()->foot_thighs;
        } else {
            return (string) 0;
        }
    }

    public function getChestAttribute() {
        if($this->lastProgram() != null && $this->lastProgram() != '') {
            return (string) $this->lastProgram()->foot_thighs;
        } else {
            return (string) 0;
        }
    }

    public function getShoulderAttribute() {
        if($this->lastProgram() != null && $this->lastProgram() != '') {
            return (string) $this->lastProgram()->foot_thighs;
        } else {
            return (string) 0;
        }
    }

    public function getForearmAttribute() {
        if($this->lastProgram() != null && $this->lastProgram() != '') {
            return (string) $this->lastProgram()->foot_thighs;
        } else {
            return (string) 0;
        }
    }

    public function getHipAttribute() {
        if($this->lastProgram() != null && $this->lastProgram() != '') {
            return (string) $this->lastProgram()->foot_thighs;
        } else {
            return (string) 0;
        }
    }

    public function getSportHabitAttribute() {
        if($this->lastProgram() != null && $this->lastProgram() != '') {
            return (string) $this->lastProgram()->sport_habit;
        } else {
            return (string) 0;
        }
    }

    public function getSportDescAttribute() {
        if($this->lastProgram() != null && $this->lastProgram() != '') {
            return (string) $this->lastProgram()->sport_desc;
        } else {
            return (string) 0;
        }
    }

    public function getNutritionDescAttribute() {
        if($this->lastProgram() != null && $this->lastProgram() != '') {
            return (string) $this->lastProgram()->nutrition_desc;
        } else {
            return (string) 0;
        }
    }

}
