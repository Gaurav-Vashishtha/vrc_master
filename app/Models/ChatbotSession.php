<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatbotSession extends Model
{
    protected $table = "chatbot_sessions";

    protected $fillable = [
        'thread_id',
        'client',
        'ip_address',
        'user_agent',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(ChatbotMessage::class);
    }
}
