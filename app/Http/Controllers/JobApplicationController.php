<?php

namespace App\Http\Controllers;

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

            $application->update($request->all());

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
}
