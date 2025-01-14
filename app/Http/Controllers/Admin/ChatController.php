<?php

namespace App\Http\Controllers\Admin;

use App\Events\ChatEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {

        $userId = auth()->user()->id;
        //Select all users who sent admin the message
       /* $chatUsers = User::where('id', '!=', $userId)
            ->whereHas('chats', function ($query) use ($userId) {
                $query->where(function ($subQuery) use ($userId) {
                    $subQuery->where('sender_id', $userId)
                        ->orWhere('receiver_id', $userId);
                });
            })
            ->orderByDesc('created_at')
            ->distinct()
            ->get();*/
        $senders = Chat::select('sender_id')
            ->where('receiver_id', $userId)
            ->where('sender_id', '!=', $userId)
            ->selectRaw('MAX(created_at) as latest_message_sent')
            ->groupBy('sender_id')
            ->orderByDesc('latest_message_sent')
            ->get();


        return view('admin.chat.index', ['senders' => $senders]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => ['required', 'max:1000'],
            'receiver_id' => ['required', 'integer']
        ]);

        $chat = new Chat();
        $chat->sender_id = auth()->user()->id;
        $chat->receiver_id = $request->receiver_id;
        $chat->message = $request->message;
        $chat->save();

        $avatar = auth()->user()->avatar;
        $sender_id = auth()->user()->id;
        broadcast(new ChatEvent($request->message, $avatar, $request->receiver_id, $sender_id))->toOthers();

        return response(['status from Backend' => 'success', 'msg_temp_id'=>$request->msg_temp_id]);
    }

    function getConversation(string $senderId)
    {
        $receiverId = auth()->user()->id;

        Chat::where('sender_id', $senderId)->where('receiver_id', $receiverId)->where('seen', 0)->update(['seen' => 1]);

        $messages = Chat::whereIn('sender_id', [$senderId, $receiverId])
            ->whereIn('receiver_id', [$senderId, $receiverId])
            ->with(['sender'])
            ->orderBy('created_at', 'asc')
            ->get();


        return response($messages);
    }
}
