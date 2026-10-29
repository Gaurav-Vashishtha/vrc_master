<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = [
        'reminder_type',
        'title',
        'description',
        'amount',
        'reminder_date',
        'remind_before_days',
        'repeat_type',
        'status',
        'completed_at',
        'created_by',
    ];

    protected $casts = ['reminder_date' => 'date','completed_at' => 'datetime','amount' => 'decimal:2',];

    public function scopeActiveReminders($query)
    {
     return $query->where('status', 'pending')->whereRaw('DATE_SUB(reminder_date, INTERVAL remind_before_days DAY) <= ?',[now()->toDateString()]);
    }
}