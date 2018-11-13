<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\Calendar;
use App\Model\FoodPackage;
use App\Model\Package;
use App\Model\Programs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserCalendarMealsController extends Controller
{
    public function showMeals($program_id) {

//        $program = Programs::with('subscription')->find($program_id);
//        $meals_default = $program->configuration['nutrition'];
//
//        $meals = [];
//        foreach ($meals_default as $item)
//        {
//            $meals_day = [];
//
//            $meals_day['day_number'] = $item['day_number'];
//            $meals_day['meals'] = [];
//
//            foreach ($item['meals'] as $meal) {
//
//                $food_package = Package::with('foods')->whereIn('id',$meal['familiar'])->get();
//                array_push($meals_day['meals'],$food_package);
//
//            }
//
//            array_push($meals,$meals_day);
//        }
//
//        return $meals;

        $calendar_nutrition = Calendar::with('package.foods','meal')
            ->where('type','package')
            ->where('program_id',$program_id)
            ->orderby('id','DESC')
            ->get()
            ->groupBy('date')->toArray();


        $calendar_nutrition_arr = [];
        foreach ($calendar_nutrition as $nutrition) {
            array_push($calendar_nutrition_arr,$nutrition);
        }

        return response()->json([
            //'trainings' => $calendar_trainings_arr,
            'nutrition' => $calendar_nutrition_arr
        ],200);

    }

    public function updateMeals(Request $request)
    {



        $data = $request->all();
        $program = Programs::find($data['program_id']);
        if($program != null /*&& $program->meals_confirmation == false && $program->status == 'accept'*/) {

            //$program->configuration = ['trainings' => $program->configuration['trainings'], 'nutrition' => $data['nutrition']];
            $program->meals_confirmation = true;
            $program->save();

            if($program->trainings_confirmation == true && $program->meals_confirmation == true) {

                $program->status = 'accept';
                $program->save();

            }

            return response()->json([
                'status' => 200,
                'message' => 'برنامه غذایی تائید شد'
            ]);

        } else {
            return response()->json([
                'status' => 200,
                'message' => 'رکوردی وجود ندارد'
            ]);
        }

    }

    public function createItem(Request $request) {
        $data = $request->all();

        $calendar = new Calendar();
        foreach ($data['items'] as $item) {
            $program = Programs::find($item['program_id']);
            $calendar->day_number = $item['day_number'];
            $calendar->program_id = $item['program_id'];
            $calendar->meal_id = $item['meal_id'];
            $calendar->type = 'package';
            $calendar->user_id = $program->user_id;
            $calendar->save();
            $calendar->package()->sync($item['package']);
        }

        return response()->json([
            'message' => 'آیتم جدید اضافه شد'
        ],200);

    }

    public function updateItem(Request $request) {
        $data = $request->all();
        foreach ($data['items'] as $item) {
            $calendar = Calendar::where('id',$item['calendar_id'])->first();
            $calendar->meal_id = $item['meal_id'];
            $calendar->package()->sync($item['package']);
            $calendar->save();
        }


        return response()->json([
            'message' => 'آیتم مورد نظر تغییر کرد'
        ],200);

    }
}
