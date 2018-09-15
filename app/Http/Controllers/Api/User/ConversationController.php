<?php

namespace App\Http\Controllers\Api\User;

use App\Model\Conversation;
use App\Model\Message;
use App\Model\Programs;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConversationController extends Controller
{

    public function index() {

        $coach = auth('api')->user();

        return $coach = User::with([
                                'conversations.program.sport',
                                'conversations.user.profile',
                                'conversations.user.Roles',
                                'conversations.lastMessage'
                            ])
                            ->where('id',$coach->id)
                            ->first();



    }

    public function createConversation(Request $request) {

        $data = $request->all();
        $coach = auth('api')->user();
        $user = User::where('id',$data['user_id'])->first();

        $check_exist_conversation = $this->checkExistConversation($coach->conversations,$user->conversations);

        if(is_array($check_exist_conversation)) {

            return response()->json(
                [
                    'message' => 'مکالمه بین این دو کاربر قبلا ساخته شده است',
                    'status' => 301,
                    'conversation_id' => $check_exist_conversation['conversation_id']
                ],301
            );
        } else {

            // Must Create
            $conversation = new Conversation();
            $conversation->started_by = $coach->id;
            $conversation->program_id = null;
            $conversation->title = 'گفتگو';
            $conversation->read_status = [$coach->id => false,$user->id => false];
            $conversation->type = 'private';
            $conversation->save();
            $conversation->user()->sync([$coach->id,$user->id]);

            return response()->json(
                [
                    'message' => 'مکالمه ساخته شد.',
                    'status' => 200,
                    'conversation_id' => $conversation->id
                ],
                200
            );

        }



    }

    public function showMessages($conversation_id) {

        $conversation = Conversation::with('messages.user.profile')->find($conversation_id);

//        $response_json = [
//            [
//                "id" => 2,
//                "conversation_id" => 1,
//                "user_id" => 10,
//                "text" => "متن پیغام",
//                "attachment" => "",
//                "type" => "text",
//                'user' => [
//                    "id" => 10,
//                    "profile" => [
//                        "id" => 10,
//                        "user_id" => 10,
//                        "first_name" => "ناز",
//                        "last_name" => "باستانی",
//                        "avatar" => "http://cdn.isna.ir/d/2016/06/20/3/57306107.jpg",
//                    ]
//                ]
//            ],
//            [
//                "id" => 2,
//                "conversation_id" => 1,
//                "user_id" => 10,
//                "text" => "متن پیغام",
//                "attachment" => "",
//                "type" => "text",
//                'user' => [
//                    "id" => 10,
//                    "profile" => [
//                        "id" => 10,
//                        "user_id" => 12,
//                        "first_name" => "ناز",
//                        "last_name" => "باستانی",
//                        "avatar" => "http://cdn.isna.ir/d/2016/06/20/3/57306107.jpg",
//                    ]
//                ]
//            ]
//        ];

        return $conversation;

    }

    public function sendMessage(Request $request) {

        $user = auth('api')->user();
        $data = $request->all();

        $url_file = '';
        if(!is_null($request->attachment)) {
            $ext = $request->attachment->getClientOriginalExtension();
            $path = $request->attachment->storeAs('/', md5(time()).'.'.$ext, 'file_message');
            $url_file = 'storage/accessories/'.$path;

        }


        $message = new Message();
        $message->conversation_id = $data['conversation_id'];
        $message->text = $data['text'];
        $message->user_id = $user->id;
        $message->attachment = $url_file;
        $message->type = $data['type'];
        $message->save();

        return [
            'message' => 'message recieved',
            'status' => 200
        ];

    }

    public function SendingMessagePermission($user_id,$program_id) {

        $program = Programs::where($program_id)
                            ->orWhere('user_id',$user_id)
                            ->orWhere('coach_id',$user_id)
                            ->orWhere('nutrition_id',$user_id)
                            ->orWhere('corrective_id',$user_id)
                            ->first();

        if($program != '' OR $program != null) {
            return true;
        } else {
            return false;
        }

    }

    protected function checkExistConversation($coach_conv,$user_conv) {

        $coach_conversations_array = [];
        foreach ($coach_conv as $coach_conversation) {
            if($coach_conversation['type'] == 'private') {
                array_push($coach_conversations_array,$coach_conversation->id);
            }
        }

        $user_conversations_array = [];
        foreach ($user_conv as $user_conversation) {
            if($coach_conversation['type'] == 'private') {
                array_push($user_conversations_array, $user_conversation->id);
            }
        }

        //Compare

        foreach ($coach_conversations_array as $item) {
            if(in_array($item,$user_conversations_array)) {
                return [
                    'status' => true,
                    'conversation_id' => $item
                ];
            }
        }

        return false;
    }

    public function readConversation(Request $request)
    {

        $user = auth('api')->user();
        $data = $request->all();

        $conversation = Conversation::find($data['conversation_id']);
        $read_status = $conversation->read_status;
        $read_status[$user->id] = true;
        $conversation->read_status = $read_status;
        $conversation->save();

        return response()->json([
            'status' => 200
        ],200);

    }

}
