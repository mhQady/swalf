<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\MessageResource;
use App\Models\Chat;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChatResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiBaseController;

class ChatController extends ApiBaseController
{
    public function index()
    {
        // $chats = $this->ticket->messages()->with('file')->latest()->skip(count($this->ticketMessages))->take(10)->get()->sortBy('created_at');

        $chats = auth()->user()->chats()->select('chats.id', 'chats.created_at')
            ->with([
                'latestMessage' => function ($query) {
                    $query->select('id','messages.chat_id','sender_id','message', 'messages.created_at'); // Get the latest message
                }
            ])
            ->leftJoinSub(
                Message::select('chat_id', DB::raw('MAX(created_at) as latest_message'))
                    ->groupBy('chat_id'),
                    'latest_messages',
                'latest_messages.chat_id',
                '=',
                'chats.id'
            )
            ->orderByRaw("latest_messages.latest_message DESC, chats.created_at DESC") // Custom order
            ->get();


        return $this->respondWithSuccess(null,
        [
            'chats' => ChatResource::collection($chats),
        ]
    );
    }
    public function show(Chat $chat)
    {

        $messages = $chat->messages()->latest()->skip(request('skip', 0))->take(10)->get();

        return $this->respondWithSuccess(
            null,
            [
                'messages' => MessageResource::collection($messages),
            ]
        );
    }

    public function sendMessage(Chat $chat, Request $request)
    {
        $sender = Auth::user();

        // $sender->chats()->attach($chat->id);

        $message = $sender->messages()->create([
            'message' => $request->input('message'),
            'chat_id' => $chat->id
        ]);

        broadcast(new MessageSent( $message, $sender))->toOthers();

        return $this->respondWithSuccess(__('main.sent.message'));
    }
}
