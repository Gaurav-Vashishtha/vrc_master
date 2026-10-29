<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contactus';
    protected $fillable = [
        'fullname',
        'address',
        'email',
        'contact',
        'budget',
        'requirement',
        'message',
        'status',
        'thread_id',
    ];
}
