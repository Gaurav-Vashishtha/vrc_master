<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckIpMaster extends Model
{
    protected $table = 'check_ip_masters';

    protected $fillable = [

        'days',
        'ip_address'
    ];

     protected $casts = [
        'days' => 'array'
    ];
}
