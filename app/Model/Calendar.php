<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Calendar
 *
 * @property-read \App\Model\Meal $meal
 * @property-read \App\Model\Package $package
 * @property-read \App\Model\Programs $program
 * @property-read \App\Model\Training $training
 * @property-read \App\User $user
 * @mixin \Eloquent
 */
class Calendar extends Model
{
    protected $casts = [
        'attributes' => 'array'
    ];
    public function meal()
    {
        return $this->hasOne('App\Model\Meal','id','meal_id');
    }

//    public function package()
//    {
//        return $this->hasOne('App\Model\Package','id','package_id');
//    }

    public function training()
    {
        return $this->belongsTo('App\Model\Training');
    }

    public function program()
    {
        return $this->belongsTo('App\Model\Programs');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function package()
    {
        return $this->belongsToMany('App\Model\Package','calendar_package');
    }

    public function description()
    {
        return $this->hasOne('App\Model\DescriptionDays','program_id','program_id');
    }

}
