<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\MessageResource;
use App\Models\Chat;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Support\Facades\DB;
use App\Enums\Chat\MessageTypeEnum;
use App\Http\Resources\ChatResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\StartChatRequest;
use App\Http\Controllers\Api\ApiBaseController;

class ChatController extends ApiBaseController
{
    public function index()
    {
        $chats = auth()->user()->chats()->select('chats.id', 'chats.product_id', 'chats.created_at')
            ->with([
                'otherSideMembers',
                'product' => fn($q) => $q->with(['mainImg', 'city']),
                'latestMessage' => fn($q) => $q->select('id', 'messages.chat_id', 'sender_id', 'message', 'messages.type', 'messages.created_at'),
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
        $chat->load(['product', 'otherSideMembers', 'messages.media']);

        $chat->markMessagesAsRead();

        return $this->respondWithSuccess(null, [
            'chat' => new ChatResource($chat),
        ]);
    }

    public function startChat(StartChatRequest $request)
    {
        $chat = Chat::firstOrCreate([
            'product_id' => $request->input('product_id'),
            'started_by' => Auth::id()
        ])->load(['product', 'otherSideMembers', 'messages']);

        $chat->members()->syncWithoutDetaching([Auth::id(), $chat->product->user_id]);

        return $this->respondWithSuccess(__('main.sent.message'), [
            'chat' => new ChatResource($chat),
        ]);
    }

    public function sendMessage(Chat $chat, MessageRequest $request)
    {
        $sender = Auth::user();

        try {
            DB::beginTransaction();

            $message = $sender->messages()->create([
                'chat_id' => $chat->id,
                'message' => $request->input('message'),
                'type' => $request->type
            ]);

            if ($request->type == MessageTypeEnum::IMAGE->value)
                uploadFiles(files: $request->file('images'), model: $message);

            if ($request->type == MessageTypeEnum::VOICE->value)
                uploadFiles(files: $request->file('voice'), model: $message);

            DB::commit();

            broadcast(new MessageSent($message, $chat))->toOthers();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->respondWithError($e->getMessage());
        }


        return $this->respondWithSuccess(__('main.sent.message'), [
            'message' => new MessageResource($message)
        ]);
    }
}
