<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Events\MessageSent;
use App\Http\Resources\ChatResource;

class ChatsController extends Controller
{
    public function fetchMessages()
    {
        $message = ChatResource::collection(Message::with('user')->orderBy('updated_at', 'asc')->get());
        return response()->json($message);
    }

    public function sendMessage(Request $request)
    {
        $user = auth()->user();

        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);

        broadcast(new MessageSent($user, $message))->toOthers();

        return ['status' => 'Message Sent!'];
    }
}
