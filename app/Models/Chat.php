<?php

namespace App\Models;

use App\Events\ChatOpened;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['product_id', 'started_by'];

    public static function booted()
    {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->latest()->skip(request('messages_skip', 0))->take(10);
    }
    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'chat_member', 'chat_id', 'user_id');
    }

    # Only used for API
    public function otherSideMembers()
    {
        return $this->members()->where('user_id', '!=', auth()->id());
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function startedBy()
    {
        return $this->belongsTo(User::class, 'started_by');
    }

    protected function unreadMessagesCount(): Attribute
    {
        return new Attribute(
            get: function ($value) {

                $id = auth()->id();

                return $this->messages()
                    ->where('sender_id', '!=', $id)
                    ->whereJsonDoesntContain('read_by', $id)
                    ->count();
            }
        );
    }
    public function markMessagesAsRead()
    {
        $id = auth()->id();

        $updated = $this->messages()
            ->where('sender_id', '!=', $id)
            ->whereJsonDoesntContain('read_by', $id)
            ->update([
                'read_by' => DB::raw('JSON_ARRAY_INSERT(read_by, CONCAT("$[",JSON_LENGTH(read_by),"]"),' . $id . ')'),
            ]);

        if ($updated)
            broadcast(new ChatOpened($this))->toOthers();
    }

}
