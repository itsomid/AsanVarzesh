<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Validator;


class ProfileController extends Controller
{
    //
    public function getProfile(Request $request)
    {
        $user = response()->json(auth('api')->user());
        return $user;
    }

    public function setAvatar(Request $request) {
        $data = $request->all();
        $user = auth('api')->user();

        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image'
        ]);

        if (!$validator->fails()) {
            $ext = $request->avatar->getClientOriginalExtension();
            $path = $request->avatar->storeAs('/', $user->id.'.'.$ext, 'avatars');

            return response()->json([
                'avatar_url' => url('storage/avatars/'.$path),
                'status' => 200
            ],200);

        } else {
            return response()->json([
                'msg' => 'your image format is not valid',
                'status' => 400
            ],400 );
        }

    }
}
