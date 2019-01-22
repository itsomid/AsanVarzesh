<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Conversation;
use App\Model\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConversationsController extends Controller
{

    public function index() {

        $conversations = Conversation::with(['user.profile','program.sport','program.user.profile','program.coach.profile','lastMessage'])->orderby('id','DESC')->get();
        return response()->json($conversations,200);

    }

    public function show($id) {

        $conversation = Conversation::with('program.sport','messages.user.profile')->where('id',$id)->first();
        return $conversation;
    }

    public function UnallowedKeywords()
    {

    }

    public function search(Request $request)
    {
        $data = $request->all();
        $messages = Message::with(['conversation','user.profile'])->where('text','like','%'.$data['keyword'].'%')->orderby('id','DESC')->get();

        return response()->json($messages,200);



    }

}
