<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

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
