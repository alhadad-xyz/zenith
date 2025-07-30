<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'job_title',
        'department',
        'employment_type',
        'job_url',
        'location',
        'salary_min',
        'salary_max',
        'job_description',
        'resume_path',
        'cover_letter_path',
        'application_notes',
        'status',
        'applied_date',
        'interview_date',
        'application_deadline',
        'follow_up_date',
        'interview_notes',
        'interview_type',
        'interview_location',
    ];

    protected $casts = [
        'applied_date' => 'date',
        'interview_date' => 'datetime',
        'application_deadline' => 'datetime',
        'follow_up_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
