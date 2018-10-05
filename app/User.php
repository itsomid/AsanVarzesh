<?php

namespace App;

use App\Model\Programs;
use Carbon\Carbon;
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
        'coachCountUser',
        'turn_over'
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

    public function Coaches()
    {
        return $this->belongsToMany('App\Model\Sport','coach_sport','coach_id','sport_id');
    }

    public function sports()
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

    public function getTurnOverAttribute()
    {
        return 26000;
    }

    public function conversations() {

        return $this->belongsToMany('App\Model\Conversation');

    }

    public function has_conversation_with_user()
    {
        return $this->belongsToMany('App\Model\Conversation')->wherePivotIn('user_id', [1]);
    }

    public function sport_by_coach()
    {
        $coach = auth('api')->user();
        return $this->belongsTo('App\Model\Programs','id','user_id')->where('coach_id',$coach->id);
    }

    public function active_programs()
    {
        return $this->hasMany('App\Model\Programs')->where('status','pending')->orwhere('status','active')->orWhere('status','accept');
    }

    public function programs() {
        return $this->hasMany('App\Model\Programs');
    }

    public function basket()
    {
        return $this->belongsToMany('App\Model\Training','coach_favorite','coach_id','training_id');
    }

    public function today_training()
    {

        //$today_date = Carbon::today()->format('y-m-d').' 00:00:00';
        $today_date = '2018-10-09 00:00:00';
        return $this->hasMany('App\Model\Calendar','user_id','id')
            ->where('training_id','!=',null)
            ->where('type','training')
            ->orderBy('id','DESC')
            ->where('day_number',7)
            /*->where('date',$today_date)*/;

    }

    public function activities()
    {
        return $this->hasMany('App\Model\Activity')->orderBy('id','DESC');
    }

    public function payments()
    {
        return $this->hasMany('App\Model\Payment');
    }


}
