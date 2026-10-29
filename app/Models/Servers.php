<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servers extends Model
{
    protected $table = 'servers';
    protected $fillable = [
        'server_name',
        'server_url',
        'user_id',
        'username',
        'password',
        'description',
        'logo',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function histories()
    {
        return $this->hasMany(ServerHistory::class, 'server_id')->latest()->take(10);
    }
}
