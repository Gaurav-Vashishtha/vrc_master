<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatbotMessage extends Model
{
    protected $table = "chatbot_messages";

    protected $fillable = [
        'chatbot_session_id',
        'role',
        'content',
        'external_id',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(ChatbotSession::class, 'chatbot_session_id');
    }
}
