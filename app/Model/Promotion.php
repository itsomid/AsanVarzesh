<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    public function apply($user_id,$code,$price,$coach_id,$sport_id) {
        $total_price = $price;


        // Condition on MAX_USE_COUNT
        if($this->max_use_count == 1) {

            $payment = Payment::where('promotion_id',$this->id)->where('user_id',$user_id)->where('status','success')->first();
            if($payment != null) {
                return false;
            }

        } elseif($this->max_use_count > 1) {

            $payment = Payment::where('promotion_id',$this->id)->get();

            if(count($payment) >= $this->max_use_count) {
                return false;
            }

        }

        // Condition on DATES
        if(!is_null($this->start) && !is_null($this->end)) {

            $today = Carbon::today();
            if($this->start > $today || $this->end < $today) {
                return false;
            }

        }

        // Condition on COACH
        if(!is_null($this->coach_id)) {

            if($this->coach_id != $coach_id) {
                return false;
            }

        }


        // Condition on SPORT
        if(!is_null($this->sport_id)) {

            if($this->sport_id != $sport_id) {
                return false;
            }

        }


        // Calculate on PERCENT
        $total_price = $total_price - ($price * $this->percent);

        // Calculate on VALUE
        $total_price = $total_price - $this->discount_value;

        return $total_price;

    }
}
