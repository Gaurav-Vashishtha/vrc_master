<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class chatbot_sessions extends Model
{
    protected $table = 'chatbot_sessions';
    protected $fillable = [
        'thread_id',
        'client',
        'ip_address',
        'user_agent',
        'created_at',
        'updated_at',
        'is_pinned',
    ];

    public function messages()
    {
        return $this->hasMany(chatbot_messages::class, 'chatbot_session_id')->orderBy('created_at', 'asc');
    }
}
