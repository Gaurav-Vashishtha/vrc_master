<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteHistory extends Model
{
    protected $table = 'website_histories';

    protected $fillable = [
        'website_id',
        'user_id',
        'status',
        'message',
    ];

    public function website()
    {
        return $this->belongsTo(Websites::class, 'website_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}