<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(){

        $userId = auth()->user()->id;
        //Select user who sent admin the message
         $chatUsers = User::where('id', '!=', $userId)
            ->whereHas('chats', function( $query) use ( $userId) {
                $query->where(function($subQuery) use ($userId){
                    $subQuery->where('sender_id', $userId)
                        ->orWhere('receiver_id', $userId);
                });
            })
            ->orderByDesc('created_at')
            ->distinct()
            ->get();


        return view('admin.chat.index',['chatUsers'=>$chatUsers]);
    }

    public function sendMessage(Request $request){
        $request->validate([
            'message' => ['required', 'max:1000'],
            'receiver_id' => ['required', 'integer']
        ]);

        $chat = new Chat();
        $chat->sender_id = auth()->user()->id;
        $chat->receiver_id = $request->receiver_id;
        $chat->message = $request->message;
        $chat->save();


        return response(['status' => 'success']);
    }

}
