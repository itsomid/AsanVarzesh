<?php

namespace App\Http\Middleware;

use App\Model\Subscription;
use Carbon\Carbon;
use Closure;

class checkSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth('api')->user();

        $today = Carbon::today();

        $subscription = Subscription::where('user_id',$user->id)->orderby('id','DESC')->first();
        //dd($subscription->to .' '. $today);
        if(strtotime($subscription->to) < strtotime($today)) {

            return response()->json([
                'status' => 401,
                'message' => 'شما مجاز به استفاده از برنامه نیستید'
            ],401);
        }

        return $next($request);
    }
}
