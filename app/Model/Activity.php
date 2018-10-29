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

        return 'عنوان تمرین';
    }


}
