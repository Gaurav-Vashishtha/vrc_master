<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class chatbot_messages extends Model
{
    protected $table = 'chatbot_messages';
    protected $fillable = [
        'chatbot_session_id',
        'role',
        'content',
        'external_id',
        'created_at',
        'updated_at',
    ];
}
