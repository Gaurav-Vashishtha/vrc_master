<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkReports extends Model
{
    protected $table = 'workreports';
    protected $fillable = [
        'user_id',
        'report_date',
        'working_hours',
        'project_id',
        'project_name',
        'project_issue',
        'issue_status',
        'pending_issue',
        'pending_reason',
        'fixed_issue',
        'before_image',
        'after_image',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}

