<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $table = 'career';
    protected $fillable = [
        'name',
        'experience',
        'position',
        'email',
        'contact_no',
        'cvfile',
        'doe',
    ];
}
