<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerHistory extends Model
{
    protected $table = 'server_histories';

    protected $fillable = [
        'server_id',
        'user_id',
        'status',
        'message',
    ];

    public function server()
    {
        return $this->belongsTo(Servers::class, 'server_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}