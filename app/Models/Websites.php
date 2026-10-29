<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Websites extends Model
{
    protected $table = 'websites';
    protected $fillable = [
        'website_name',
        'website_url',
        'user_id',
        'description',
        'logo',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function histories()
    {
        return $this->hasMany(WebsiteHistory::class, 'website_id');
    }
}
