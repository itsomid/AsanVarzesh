<?php

namespace App\Http\Controllers\Api\User;

use App\Model\Countries;
use App\Model\States;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GeoController extends Controller
{
    //
    public function getAllCountries() {

        $countries = Countries::all();

        return response()->json(
            $countries,
            200
        );

    }

    public function countryItem($country_id) {

        $country = Countries::with('states.cities')->find($country_id);

        return response()->json($country,200);

    }


    public function getStates($country_id) {

        $country = Countries::find($country_id);

        return response()->json($country->states,200);

    }


    public function getCities($state_id) {

        $state = States::find($state_id);
        return $state->cities;

    }
}
