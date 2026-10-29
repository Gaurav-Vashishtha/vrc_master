<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $table = 'leaves';
        protected $fillable = [
        'user_id',
        'leave_type',
        'leave_reason',
        'from_date',
        'to_date',
        'total_days',
        'status',
        'withdrawal_status',
        'withdrawal_reason',
        'withdrawal_admin_reason',
        'withdrawal_requested_at',
        'withdrawal_action_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $casts = [
        'from_date' => 'date',
        'to_date' => 'date',
        'withdrawal_requested_at' => 'datetime',
        'withdrawal_action_at' => 'datetime',
    ];
}
  