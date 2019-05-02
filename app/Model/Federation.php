<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Federation
 *
 * @property-read mixed $coach_count
 * @property-read mixed $sport_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Sport[] $sports
 * @mixin \Eloquent
 */
class Federation extends Model
{
    //
    protected $appends = [
        'sportCount',
        'coachCount'
    ];
    public function sports()
    {
        return $this->hasMany('App\Model\Sport');
    }

    public function getsportCountAttribute()
    {
        return $this->hasMany('App\Model\Sport')->count();
    }

    public function getcoachCountAttribute()
    {
        $sports = $this->hasMany('App\Model\Sport')->with('coaches')->get();
        $count = 0;
        foreach ($sports as $sport) {
            $coachs = $sport->coaches;
            $count += count($sport->coaches);
        }

        return $count;


    }


}
