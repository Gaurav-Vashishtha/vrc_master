<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    protected $table = 'notes';
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'priority',
        'reminder_date',
        'status',
        'attachment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
