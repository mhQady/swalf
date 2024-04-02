<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Chat;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ChatResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StartChatRequest;
use App\Http\Controllers\Api\ApiBaseController;

class ChatController extends ApiBaseController
{
    public function index()
    {
        $chats = auth()->user()->chats()->select('chats.id', 'chats.created_at')
            ->with([
                'latestMessage' => function ($query) {
                    $query->select('id', 'messages.chat_id', 'sender_id', 'message', 'messages.created_at');
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
            ->orderByRaw("latest_messages.latest_message DESC, chats.created_at DESC")
            ->skip(request('chats_skip', 0))->take(10)
            ->get();


        return $this->respondWithSuccess(
            null,
            [
                'chats' => ChatResource::collection($chats),
            ]
        );
    }
    public function show(Chat $chat)
    {
        $chat->load(['product', 'members', 'messages']);

        return $this->respondWithSuccess(null, [
            'chat' => new ChatResource($chat),
        ]);
    }

    public function startChat(StartChatRequest $request)
    {
        $chat = Chat::firstOrCreate([
            'product_id' => $request->input('product_id'),
            'started_by' => Auth::id()
        ])->load(['product', 'members', 'messages']);

        $chat->members()->syncWithoutDetaching([Auth::id(), $chat->product->user_id]);

        return $this->respondWithSuccess(__('main.sent.message'), [
            'chat' => new ChatResource($chat),
        ]);
    }

    public function sendMessage(Chat $chat, Request $request)
    {
        $sender = Auth::user();

        $message = $sender->messages()->create([
            'chat_id' => $chat->id,
            'message' => $request->input('message'),
        ]);

        broadcast(new MessageSent($message, $chat))->toOthers();

        return $this->respondWithSuccess(__('main.sent.message'));
    }
}
