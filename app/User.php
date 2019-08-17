<?php

namespace App;

use App\Model\Payment;
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
        'user_turn_over',
        'coach_turn_over',
        'nutrition_turn_over',
        'corrective_turn_over',
        'all_payments'
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

    protected $coach_share = 0.7;
    protected $nutrition_share = 0.1;
    protected $corrective_share = 0.1;

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
        return $this->belongsToMany('App\Model\Sport','coach_sport','coach_id','sport_id')->withPivot('price');
    }

    public function sport()
    {
        return $this->belongsToMany('App\Model\Sport','coach_sport','coach_id','sport_id')->withPivot('price');
    }

    public function profile() {
        return $this->hasOne('App\Model\Profiles','user_id','id');
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

    public function getUserTurnOverAttribute()
    {
        return [];
    }

    public function getCoachTurnOverAttribute()
    {
        $totalPrice = 0;
        $payments = \App\Model\Payment::where('coach_id',$this->id)
            ->where('type','debit')
            ->where('status','success')
            ->get();

        foreach ($payments as $payment) {
            if($payment->status == 'success' && $payment->type == 'debit') {
                $totalPrice += $payment->price * $this->coach_share;
            } else if($payment->status == 'return' && $payment->type == 'credit') {
                $totalPrice -= $payment->price * $this->coach_share;
            }
        }
        return $totalPrice;
    }

    public function getNutritionTurnOverAttribute()
    {
        $totalPrice = 0;
        $payments = \App\Model\Payment::where('nutrition_doctor_id',$this->id)
            ->where('type','debit')
            ->where('status','success')
            ->get();
        foreach ($payments as $payment) {
            $totalPrice += ($payment->price*$this->nutrition_share);
        }
        return $totalPrice;
    }

    public function getCorrectiveTurnOverAttribute()
    {
        $totalPrice = 0;
        $payments = \App\Model\Payment::where('corrective_doctor_id',$this->id)
            ->where('type','debit')
            ->where('status','success')
            ->get();
        foreach ($payments as $payment) {
            $totalPrice += ($payment->price*$this->corrective_share);
        }
        return $totalPrice;
    }

    public function conversations() {
        return $this->belongsToMany('App\Model\Conversation');
    }

    public function conversations_public() {
        return $this->belongsToMany('App\Model\Conversation')->where('type','group');
    }

    public function conversations_private() {
        return $this->belongsToMany('App\Model\Conversation')->where('type','private');
    }

    public function sport_by_coach()
    {
        $coach = auth('api')->user();
        return $this->belongsTo('App\Model\Programs','id','user_id')->where('coach_id',$coach->id);
    }

    public function active_programs()
    {
        return $this->hasMany('App\Model\Programs')->where('status','active');
    }

    public function programs() {
        return $this->hasMany('App\Model\Programs');
    }

    public function programs_by_coach()
    {
        return $this->hasMany('App\Model\Programs','coach_id','id');
    }

    public function programs_by_corrective_doctor()
    {
        return $this->hasMany('App\Model\Programs','corrective_doctor_id','id');
    }

    public function programs_by_nutrition_doctor()
    {
        return $this->hasMany('App\Model\Programs','nutrition_doctor_id','id');
    }

    public function basket()
    {
        return $this->belongsToMany('App\Model\Training','coach_favorite','coach_id','training_id');
    }

    public function PackageBasket()
    {
        return $this->belongsToMany('App\Model\Package','coach_package','coach_id','package_id');
    }

    public function today_training()
    {
        // Todo: After completed Apps query with today_date
        $today_date = Carbon::today();
        return $this->hasMany('App\Model\Calendar','user_id','id')
            ->where('training_id','!=',null)
            ->where('type','training')
            ->orderBy('id','DESC')
            ->where('date',$today_date)
            /*->where('date',$today_date)*/;

    }

    public function today_nutrition()
    {
        // Todo: After completed Apps query with today_date
        $today_date = '2018-10-09 00:00:00';
        return $this->hasMany('App\Model\Calendar','user_id','id')
            ->where('meal_id','!=',null)
            ->where('type','package')
            ->orderBy('id','DESC')
            ->where('day_number',7)
            /*->where('date',$today_date)*/;

    }

    public function nutrition_programs() {
        return $this->hasMany('App\Model\Calendar','user_id','id');
    }

    public function activities()
    {
        return $this->hasMany('App\Model\Activity')->orderBy('id','DESC');
    }

    public function payments()
    {
        return $this->hasMany('App\Model\Payment');
    }

    public function getAllPaymentsAttribute() {
        $payments = Payment::where('user_id',$this->id)
            ->orWhere('coach_id',$this->id)
            ->orWhere('nutrition_doctor_id',$this->id)
            ->orWhere('corrective_doctor_id',$this->id)
            ->orderby('id','DESC')
            ->get();
        return $payments;
    }

    public function payments_by_user()
    {
        return $this->hasMany('App\Model\Payment');
    }

    public function payments_by_coach()
    {
        return $this->hasMany('App\Model\Payment','coach_id','id')
            ->whereIn('status',['success','return'])
            ->where('type','debit');
    }

    public function payments_by_corrective()
    {
        return $this->hasMany('App\Model\Payment','corrective_doctor_id','id');
    }

    public function payments_by_nutrition()
    {
        return $this->hasMany('App\Model\Payment','nutrition_doctor_id','id');
    }

    public function getField() {

        $role_name = $this->roles[0]->name;

        if($role_name == 'coach') {
            return 'coach_id';
        } elseif($role_name == 'nutrition-doctor') {
            return 'nutrition_doctor_id';
        } elseif($role_name == 'corrective-doctor') {
            return 'corrective_doctor_id';
        }

    }


    public function getFieldProgram() {
        $roles = $this->roles;
        foreach ($roles as $role) {
            if($role->name == 'coach') {
                return 'coach_id';
            }
        }
        $role = $roles[0];
        if($role->name == 'nutrition-doctor') {
            return 'nutrition_doctor_id';
        } elseif($role->name == 'corrective-doctor') {
            return 'corrective_doctor_id';
        }

    }
}
