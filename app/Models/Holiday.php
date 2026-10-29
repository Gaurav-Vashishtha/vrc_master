<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $table = 'holiday';
    protected $fillable = [
    'holiday_name',
    'from_date',
    'to_date',
    'total_days',
    'status'
 ];
}
  