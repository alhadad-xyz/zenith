<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Auth::user()->tasks()
            ->orderBy('completed')
            ->orderBy('priority', 'desc')
            ->orderBy('due_date')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'tasks' => $tasks
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => ['nullable', Rule::in(['low', 'normal', 'high'])],
            'category' => ['nullable', Rule::in(['general', 'application', 'interview', 'followup', 'research'])],
            'due_date' => 'nullable|date',
            'job_application_id' => 'nullable|exists:job_applications,id'
        ]);

        // Ensure the job application belongs to the authenticated user if provided
        if ($validated['job_application_id']) {
            $application = JobApplication::where('id', $validated['job_application_id'])
                ->where('user_id', Auth::id())
                ->first();
            
            if (!$application) {
                return response()->json([
                    'success' => false,
                    'message' => 'Job application not found or access denied'
                ], 404);
            }
        }

        $task = Auth::user()->tasks()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'priority' => $validated['priority'] ?? 'normal',
            'category' => $validated['category'] ?? 'general',
            'due_date' => $validated['due_date'] ? \Carbon\Carbon::parse($validated['due_date']) : null,
            'job_application_id' => $validated['job_application_id'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Task created successfully',
            'task' => $task->load('jobApplication')
        ], 201);
    }

    public function show(Task $task)
    {
        // Ensure the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'task' => $task->load('jobApplication')
        ]);
    }

    public function update(Request $request, Task $task)
    {
        // Ensure the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found'
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'priority' => ['nullable', Rule::in(['low', 'normal', 'high'])],
            'category' => ['nullable', Rule::in(['general', 'application', 'interview', 'followup', 'research'])],
            'due_date' => 'nullable|date',
            'job_application_id' => 'nullable|exists:job_applications,id'
        ]);

        // Ensure the job application belongs to the authenticated user if provided
        if (isset($validated['job_application_id']) && $validated['job_application_id']) {
            $application = JobApplication::where('id', $validated['job_application_id'])
                ->where('user_id', Auth::id())
                ->first();
            
            if (!$application) {
                return response()->json([
                    'success' => false,
                    'message' => 'Job application not found or access denied'
                ], 404);
            }
        }

        $task->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully',
            'task' => $task->load('jobApplication')
        ]);
    }

    public function destroy(Task $task)
    {
        // Ensure the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found'
            ], 404);
        }

        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully'
        ]);
    }

    public function toggle(Task $task)
    {
        // Ensure the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found'
            ], 404);
        }

        if ($task->completed) {
            $task->markPending();
        } else {
            $task->markCompleted();
        }

        return response()->json([
            'success' => true,
            'message' => 'Task status updated successfully',
            'task' => $task->load('jobApplication')
        ]);
    }

    public function todayTasks()
    {
        try {
            $tasks = Auth::user()->tasks()
                ->forToday()
                ->orderBy('completed')
                ->orderBy('priority', 'desc')
                ->orderBy('created_at')
                ->get();

            return response()->json([
                'success' => true,
                'tasks' => $tasks->map(function ($task) {
                    return [
                        'id' => $task->id,
                        'title' => $task->title,
                        'text' => $task->title, // For compatibility with frontend
                        'description' => $task->description,
                        'priority' => $task->priority,
                        'category' => $task->category,
                        'completed' => $task->completed,
                        'completed_at' => $task->completed_at,
                        'due_date' => $task->due_date,
                        'job_application' => $task->jobApplication ? [
                            'id' => $task->jobApplication->id,
                            'company_name' => $task->jobApplication->company_name,
                            'job_title' => $task->jobApplication->job_title,
                        ] : null,
                        'created_at' => $task->created_at,
                        'updated_at' => $task->updated_at,
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tasks table not found. Please run: php artisan migrate',
                'tasks' => [],
                'setup_required' => true
            ], 500);
        }
    }
}