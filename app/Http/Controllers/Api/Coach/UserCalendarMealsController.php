<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\FoodPackage;
use App\Model\Programs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserCalendarMealsController extends Controller
{
    public function showMeals($program_id) {

        $program = Programs::with('subscription')->find($program_id);
        $meals_default = $program->configuration['nutrition'];

        $meals = [];
        foreach ($meals_default as $item)
        {
            $meals_day = [];

            $meals_day['day_number'] = $item['day_number'];
            $meals_day['meals'] = [];

            foreach ($item['meals'] as $meal) {

                $food_package = FoodPackage::with('package.foods')->where('id',$meal['food_package_id'])->first();

                array_push($meals_day['meals'],$food_package);

            }

            array_push($meals,$meals_day);
        }

        return $meals;

    }

    public function updateMeals(Request $request)
    {



        $data = $request->all();
        $program = Programs::find($data['program_id']);
        $data['nutrition'];
        if($program->meals_confirmation == false) {

            $program->configuration = ['trainings' => $program->configuration['trainings'], 'nutrition' => $data['nutrition']];
            $program->meals_confirmation = true;
            $program->save();

            if($program->trainings_confirmation == true && $program->meals_confirmation == true) {
                $program->status = 'accept';
                $program->save();

                // Todo: Create Meals Calendar

            }

            return response()->json([
                'status' => 200,
                'message' => 'برنامه غذایی تائید شد'
            ]);

        }








    }
}
