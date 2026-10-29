<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'emp_code',
        'father_first_name',
        'father_last_name',
        'mother_first_name',
        'mother_last_name',
        'profile_photo',
        'usertype',
        'personal_email',
        'alternate_email',
        'personal_mobile',
        'alternate_mobile',
        'password',
        'status',
        'created_at',
    ];

    protected $table = 'employee_master';

    protected $primaryKey = 'id';
}