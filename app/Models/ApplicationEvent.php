<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationEvent extends Model
{
    protected $fillable = [
        'job_application_id',
        'type',
        'title',
        'description',
        'event_date',
        'event_time',
        'interview_type',
        'content',
        'notes',
        'action',
        'due_date',
        'priority',
        'details',
        'reminder',
        'reason',
        'feedback',
        'reapply_future',
        'metadata',
    ];

    protected $casts = [
        'event_date' => 'date',
        'due_date' => 'date',
        'reminder' => 'boolean',
        'reapply_future' => 'boolean',
        'metadata' => 'array',
    ];

    public function jobApplication(): BelongsTo
    {
        return $this->belongsTo(JobApplication::class);
    }
}