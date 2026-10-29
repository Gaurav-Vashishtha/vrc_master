<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IPOContactUs extends Model
{
    protected $table = 'ipo_contactus';

    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'ipo_stage',
        'validation_points',
        'message',
    ];
}
