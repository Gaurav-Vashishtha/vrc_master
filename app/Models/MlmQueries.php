<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MlmQueries extends Model
{
    protected $table = 'mlm_queries';
    protected $fillable = [
        'fullname',
        'address',
        'email',
        'contact',
        'contact_time',
    ];
}