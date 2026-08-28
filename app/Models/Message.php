<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    public const SENDER_USER = 'user';
    public const SENDER_BOT = 'bot';

    protected $fillable = [
        'conversation_id',
        'sender',
        'message',
        'intent',
    ];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }
}
