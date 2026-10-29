<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IPOContactLanding extends Model
{
    protected $table = 'ipo_contact_landing';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'interest',
        'requirement',
    ];
}
