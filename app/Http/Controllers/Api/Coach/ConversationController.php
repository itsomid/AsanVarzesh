<?php

namespace App\Http\Controllers\Api\Coach;

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
        if($coach->hasRole('coach')) {

            $program_ids = Programs::where('coach_id',$coach->id)->pluck('id');
            return $user = User::with(
                ['conversations_public' => function($q) use ($program_ids) {
                    $q->whereIn('conversations.program_id', $program_ids)
                        ->with([
                            'program.sport',
                            'user.profile.city',
                            'user.Roles',
                            'lastMessage'
                        ]);
                }])->where('id',$coach->id)->first();

        } else {

            return $user = User::with([
                'conversations_public.program.sport',
                'conversations_public.user.profile.city',
                'conversations_public.user.Roles',
                'conversations_public.lastMessage'
            ])->where('id',$coach->id)
            ->first();
        }


    }

    public function createConversation(Request $request) {

        $data = $request->all();
        $coach = auth('api')->user();
        $user = User::where('id',$data['user_id'])->first();

        $check_exist_conversation = $this->checkExistConversation($coach->conversations_private,$user->conversations_private);

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

        $coach = auth('api')->user();

        $conversation = Conversation::with(['messages.user.profile','messages.user.Roles','user'])->find($conversation_id)->toArray();
        //return $conversation;

        if($conversation['type'] == 'group') {
            $private_conversation = $coach->conversations()->with(['user.profile','user.roles'])->where('program_id',$conversation['program_id'])->where('type','private')->get();;
            $conversation['private_conversations'] = $private_conversation;
        }


        return $conversation;
    }

    public function sendMessage(Request $request) {

        $user = auth('api')->user();
        $data = $request->all();

        $url_file = '';
        if(!is_null($request->attachment)) {
            $ext = $request->attachment->getClientOriginalExtension();
            $path = $request->attachment->storeAs('/', md5(time()).'.'.$ext, 'file_message');
            $url_file = 'storage/file_message/'.$path;
        }

        $conversation = Conversation::where('id',$data['conversation_id'])->first();


        $message = new Message();
        $read_status = $conversation['read_status'];
        $read_status[$user->id] = true;
        $message->conversation_id = $data['conversation_id'];
        $message->text = $data['text'];
        $message->user_id = $user->id;
        $message->attachment = $url_file;
        $message->type = $data['type'];
        $message->read_status = $read_status;
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

    public function readMessage(Request $request) {


        $coach = auth('api')->user();
        $data = $request->all();

        $message = Message::find($data['message_id']);
        $read_status = $message->read_status;
        $read_status[$coach->id] = true;
        $message->read_status = $read_status;
        $message->save();

        return response()->json([
            'status' => 200
        ],200);

    }

}
