<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    protected $appends = [
        'title'
    ];
    public function calendar() {

        return $this->hasMany('App\Model\Calendar','id','calendar_id');

    }

    public function gettitleAttribute(){

        $calendar = Calendar::where('id',$this->calendar_id)->first();
        return $calendar->training->title;
//        if($calendar->training_id != null && $calendar->type == 'training') {
//            return $calendar->training->title;
//        } else {
//            return null;
//        }
    }


}
