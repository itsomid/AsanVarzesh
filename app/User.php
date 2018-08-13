<?php

namespace App;

use App\Model\Programs;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable implements JWTSubject
{
    use EntrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $appends = [
        'coachCountUser'
    ];

    protected $casts = [
        'team' => 'array'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function Roles()
    {
        return $this->belongsToMany('App\Model\Role')->withPivot('sport_id');
    }

    public function Coachs()
    {
        return $this->belongsToMany('App\Model\Sport','coach_sport','coach_id','sport_id');
    }

    public function profile() {

        return $this->hasOne('App\Model\Profiles');

    }

    public function programs_as_doctor()
    {
        return $this->hasMany('App\Model\Programs','doctor_id','id');
    }

    public function accessories()
    {
        return $this->belongsToMany('App\Model\Accessory');
    }

    public function getcoachCountUserAttribute()
    {
       return count(Programs::where('coach_id',$this->id)->get());
    }

}
