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

    public function UnallowedKeywords()
    {

    }

    public function search($keyword)
    {

        $messages = Message::with(['conversation','user.profile'])->where('text','like','%'.$keyword.'%')->orderby('id','DESC')->get();

        return response()->json($messages,200);



    }

}
