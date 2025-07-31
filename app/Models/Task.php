<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'priority',
        'completed',
        'completed_at',
        'due_date',
        'category',
        'job_application_id', // Optional: link to specific application
    ];

    protected $casts = [
        'completed' => 'boolean',
        'completed_at' => 'datetime',
        'due_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobApplication(): BelongsTo
    {
        return $this->belongsTo(JobApplication::class);
    }

    // Scope for today's tasks
    public function scopeForToday($query)
    {
        $today = today()->format('Y-m-d');
        
        return $query->where(function ($q) use ($today) {
            $q->whereRaw('DATE(due_date) = ?', [$today])
              ->orWhere(function ($subQ) use ($today) {
                  $subQ->whereNull('due_date')
                       ->whereRaw('DATE(created_at) = ?', [$today]);
              });
        });
    }

    // Scope for completed tasks
    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    // Scope for pending tasks
    public function scopePending($query)
    {
        return $query->where('completed', false);
    }

    // Mark task as completed
    public function markCompleted()
    {
        $this->update([
            'completed' => true,
            'completed_at' => now(),
        ]);
    }

    // Mark task as pending
    public function markPending()
    {
        $this->update([
            'completed' => false,
            'completed_at' => null,
        ]);
    }
}