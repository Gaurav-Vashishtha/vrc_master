<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    
    protected $table = 'attendances';
    protected $primaryKey = 'id';
    protected $fillable = [
        'emp_code',
        'check_in',
        'check_out',
        'total_work',
        'updated_by',
        'att_date',
        'att_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'emp_code', 'id');
    }
}
