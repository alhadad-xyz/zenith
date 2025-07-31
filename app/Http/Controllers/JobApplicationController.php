<?php

namespace App\Http\Controllers;

use App\Models\ApplicationEvent;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'employment_type' => 'nullable|in:full-time,part-time,contract,internship',
            'job_url' => 'nullable|url',
            'location' => 'nullable|string|max:255',
            'salary_min' => 'nullable|string|max:50',
            'salary_max' => 'nullable|string|max:50',
            'job_description' => 'nullable|string',
            'application_notes' => 'nullable|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'cover_letter' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = $request->except(['resume', 'cover_letter']);
        $data['user_id'] = Auth::id();

        // Handle file uploads
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
            $data['resume_path'] = $resumePath;
        }

        if ($request->hasFile('cover_letter')) {
            $coverLetterPath = $request->file('cover_letter')->store('cover_letters', 'public');
            $data['cover_letter_path'] = $coverLetterPath;
        }

        $application = JobApplication::create($data);

        // Create application submitted event
        $application->events()->create([
            'type' => 'application_submitted',
            'title' => 'Application Submitted',
            'description' => "Applied to {$application->job_title} position at {$application->company_name}",
            'event_date' => now()->toDateString(),
            'priority' => 'normal',
        ]);

        return response()->json([
            'success' => true,
            'data' => $application,
            'message' => 'Application added successfully!'
        ]);
    }

    public function index(Request $request)
    {
        $query = Auth::user()->jobApplications();
        
        // Apply status filter if provided
        if ($request->has('filter') && $request->filter) {
            $query->where('status', $request->filter);
        }
        
        // Apply sorting
        $sortField = $request->get('sort', 'date');
        $sortDirection = $request->get('direction', 'desc');
        
        switch ($sortField) {
            case 'company':
                $query->orderBy('company_name', $sortDirection);
                break;
            case 'status':
                $query->orderBy('status', $sortDirection);
                break;
            case 'date':
            default:
                $query->orderBy('created_at', $sortDirection);
                break;
        }
        
        $applications = $query->get();
        
        // Calculate statistics
        $userApplications = Auth::user()->jobApplications();
        $stats = [
            'total' => $userApplications->count(),
            'active' => $userApplications->whereIn('status', ['applied', 'interviewing'])->count(),
            'offers' => $userApplications->where('status', 'offer')->count(),
        ];
        
        // If this is an API request, return JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $applications,
                'stats' => $stats
            ]);
        }
        
        // Otherwise return the view
        return view('applications.index', compact('applications', 'stats'));
    }

    public function show(Request $request, JobApplication $application)
    {
        // Check if the application belongs to the authenticated user
        if ($application->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this application.');
        }
        
        // Load events ordered by date
        $application->load(['events' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }]);
        
        // If this is an API request, return JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $application
            ]);
        }
        
        // Otherwise return the view
        return view('applications.show', compact('application'));
    }

    public function edit(JobApplication $application)
    {
        // Check if the application belongs to the authenticated user
        if ($application->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this application.');
        }
        
        return view('applications.edit', compact('application'));
    }

    public function update(Request $request, JobApplication $application)
    {
        // Check if the application belongs to the authenticated user
        if ($application->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this application.');
        }

        // Check if this is a status update only (for existing functionality)
        if ($request->has('status') && count($request->all()) == 1) {
            $request->validate([
                'status' => 'required|in:applied,interviewing,offer,rejected,withdrawn',
            ]);

            $oldStatus = $application->status;
            $newStatus = $request->input('status');
            
            $application->update($request->all());

            // Create event for status change
            if ($oldStatus !== $newStatus) {
                $this->createStatusChangeEvent($application, $oldStatus, $newStatus);
            }

            return response()->json([
                'success' => true,
                'data' => $application,
                'message' => 'Application status updated successfully!'
            ]);
        }

        // Full application update validation
        $request->validate([
            'company_name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'employment_type' => 'nullable|in:full-time,part-time,contract,internship',
            'job_url' => 'nullable|url',
            'location' => 'nullable|string|max:255',
            'salary_min' => 'nullable|string|max:50',
            'salary_max' => 'nullable|string|max:50',
            'job_description' => 'nullable|string',
            'application_notes' => 'nullable|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'cover_letter' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = $request->except(['resume', 'cover_letter']);

        // Handle file uploads
        if ($request->hasFile('resume')) {
            // Delete old resume if it exists
            if ($application->resume_path) {
                Storage::disk('public')->delete($application->resume_path);
            }
            $resumePath = $request->file('resume')->store('resumes', 'public');
            $data['resume_path'] = $resumePath;
        }

        if ($request->hasFile('cover_letter')) {
            // Delete old cover letter if it exists
            if ($application->cover_letter_path) {
                Storage::disk('public')->delete($application->cover_letter_path);
            }
            $coverLetterPath = $request->file('cover_letter')->store('cover_letters', 'public');
            $data['cover_letter_path'] = $coverLetterPath;
        }

        $application->update($data);

        // If this is an API request, return JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $application,
                'message' => 'Application updated successfully!'
            ]);
        }

        // Otherwise redirect back with success message
        return redirect()->route('applications.show', $application)
                        ->with('success', 'Application updated successfully!');
    }

    public function destroy(JobApplication $application)
    {
        // Check if the application belongs to the authenticated user
        if ($application->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this application.');
        }

        // Delete associated files
        if ($application->resume_path) {
            Storage::disk('public')->delete($application->resume_path);
        }
        if ($application->cover_letter_path) {
            Storage::disk('public')->delete($application->cover_letter_path);
        }

        $application->delete();

        return response()->json([
            'success' => true,
            'message' => 'Application deleted successfully!'
        ]);
    }

    public function storeEvent(Request $request, JobApplication $application)
    {
        // Check if the application belongs to the authenticated user
        if ($application->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this application.');
        }

        // Debug logging
        \Log::info('Event creation request received', [
            'type' => $request->type,
            'application_id' => $application->id,
            'request_data' => $request->all()
        ]);

        $request->validate([
            'type' => 'required|in:interview,note,followup,rejected',
            'title' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'time' => 'nullable|string',
            'interview_type' => 'nullable|string|max:100',
            'content' => 'nullable|string',
            'notes' => 'nullable|string',
            'action' => 'nullable|string|max:255',
            'due_date' => 'nullable|date',
            'priority' => 'nullable|in:high,medium,low',
            'details' => 'nullable|string',
            'reminder' => 'nullable|boolean',
            // Rejected event specific fields
            'reason' => 'nullable|string|max:255',
            'rejection_date' => 'nullable|date',
            'feedback' => 'nullable|string',
            'reapply_future' => 'nullable|boolean',
        ]);

        // Prepare event data based on type
        $eventData = [
            'job_application_id' => $application->id,
            'type' => $request->type,
            'title' => $request->filled('title') ? $request->title : $this->getDefaultTitle($request->type),
        ];

        // Add type-specific data
        switch ($request->type) {
            case 'interview':
                $eventData = array_merge($eventData, [
                    'description' => $request->interview_type ? ucfirst($request->interview_type) . ' interview scheduled' : 'Interview scheduled',
                    'event_date' => $request->date,
                    'event_time' => $request->time,
                    'interview_type' => $request->interview_type,
                    'notes' => $request->notes,
                    'reminder' => $request->boolean('reminder'),
                ]);
                break;

            case 'note':
                $eventData = array_merge($eventData, [
                    'description' => \Str::limit($request->content, 100),
                    'content' => $request->content,
                    'event_date' => now()->toDateString(),
                ]);
                break;

            case 'followup':
                $eventData = array_merge($eventData, [
                    'description' => ucfirst($request->priority ?? 'medium') . ' priority follow-up task',
                    'action' => $request->action,
                    'due_date' => $request->due_date,
                    'priority' => $request->priority,
                    'details' => $request->details,
                    'reminder' => $request->boolean('reminder'),
                ]);
                break;

            case 'rejected':
                $eventData = array_merge($eventData, [
                    'title' => 'Application Rejected',
                    'description' => $request->reason ? str_replace('_', ' ', ucfirst($request->reason)) : 'Application was rejected',
                    'event_date' => $request->rejection_date ?? now()->toDateString(),
                    'reason' => $request->reason,
                    'feedback' => $request->feedback,
                    'notes' => $request->notes,
                    'reapply_future' => $request->boolean('reapply_future'),
                ]);
                
                // Update application status to rejected
                $application->update(['status' => 'rejected']);
                break;
        }

        // Create the event
        try {
            $event = ApplicationEvent::create($eventData);
            
            \Log::info('Event created successfully', [
                'event_id' => $event->id,
                'event_data' => $eventData
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to create event', [
                'error' => $e->getMessage(),
                'event_data' => $eventData
            ]);
            throw $e;
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Event added to timeline successfully!',
            'data' => [
                'id' => $event->id,
                'type' => $event->type,
                'title' => $event->title,
                'description' => $event->description,
                'application_id' => $application->id,
                'application_status' => $application->fresh()->status,
                'created_at' => $event->created_at,
            ]
        ]);
    }

    private function createStatusChangeEvent(JobApplication $application, $oldStatus, $newStatus)
    {
        $eventTypes = [
            'applied' => 'application_submitted',
            'interviewing' => 'interview_scheduled',
            'offer' => 'offer_received',
            'rejected' => 'rejection_received',
            'withdrawn' => 'application_withdrawn',
        ];

        $eventTitles = [
            'applied' => 'Application Status Updated',
            'interviewing' => 'Interview Stage',
            'offer' => 'Offer Received',
            'rejected' => 'Application Rejected',
            'withdrawn' => 'Application Withdrawn',
        ];

        $eventDescriptions = [
            'applied' => 'Application status changed to applied',
            'interviewing' => 'Application moved to interview stage',
            'offer' => 'Offer received from ' . $application->company_name,
            'rejected' => 'Application was rejected',
            'withdrawn' => 'Application was withdrawn',
        ];

        $application->events()->create([
            'type' => $eventTypes[$newStatus] ?? 'status_change',
            'title' => $eventTitles[$newStatus] ?? 'Status Updated',
            'description' => $eventDescriptions[$newStatus] ?? "Status changed from {$oldStatus} to {$newStatus}",
            'event_date' => now()->toDateString(),
            'priority' => $newStatus === 'offer' ? 'high' : 'normal',
        ]);
    }

    private function getDefaultTitle(string $type): string
    {
        return match ($type) {
            'interview' => 'Interview Scheduled',
            'note' => 'Note Added',
            'followup' => 'Follow-up Action',
            'rejected' => 'Application Rejected',
            default => 'Timeline Event',
        };
    }
}
