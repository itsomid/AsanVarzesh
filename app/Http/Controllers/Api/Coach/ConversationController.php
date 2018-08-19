<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConversationController extends Controller
{
    public function index() {

        $user = auth('api')->user();

        $response_json = [
            [
                "id" => 1,
                "title" => "گروه محمد ریاحی"
            ],
            [
                "id" => 2,
                "title" => "گروه احمد نیازی"
            ]
        ];

        return $response_json;

    }

    public function showMessages($conversation_id) {

        $conversation = Conversation::with('messages.user.profile')->find($conversation_id);

        $response_json = [
            [
                "id" => 2,
                "conversation_id" => 1,
                "user_id" => 10,
                "text" => "متن پیغام",
                "attachment" => "",
                "type" => "text",
                'user' => [
                    "id" => 10,
                    "profile" => [
                        "id" => 10,
                        "user_id" => 10,
                        "first_name" => "ناز",
                        "last_name" => "باستانی",
                        "avatar" => "http://cdn.isna.ir/d/2016/06/20/3/57306107.jpg",
                    ]
                ]
            ],
            [
                "id" => 2,
                "conversation_id" => 1,
                "user_id" => 10,
                "text" => "متن پیغام",
                "attachment" => "",
                "type" => "text",
                'user' => [
                    "id" => 10,
                    "profile" => [
                        "id" => 10,
                        "user_id" => 12,
                        "first_name" => "ناز",
                        "last_name" => "باستانی",
                        "avatar" => "http://cdn.isna.ir/d/2016/06/20/3/57306107.jpg",
                    ]
                ]
            ]
        ];

        return $response_json;

    }

    public function sendMessage($conversation_id) {

        return [
            'message' => 'message recieved',
            'status' => 200
        ];

    }
}
