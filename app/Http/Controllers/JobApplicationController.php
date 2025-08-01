<?php

namespace App\Http\Controllers;

use App\Models\ApplicationEvent;
use App\Models\JobApplication;
use App\Services\DocumentTextExtractor;
use App\Services\CoverLetterAIService;
use App\Services\ResumeAnalyzerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        switch ($type) {
            case 'interview':
                return 'Interview Scheduled';
            case 'note':
                return 'Note Added';
            case 'followup':
                return 'Follow-up Action';
            case 'rejected':
                return 'Application Rejected';
            default:
                return 'Timeline Event';
        }
    }

    public function extractResumeText(JobApplication $application)
    {
        try {
            // Check if the application belongs to the authenticated user
            if ($application->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to this application.'
                ], 403);
            }

            if (!$application->resume_path) {
                return response()->json([
                    'success' => false,
                    'message' => 'No resume attached to this application.'
                ]);
            }

            $extractor = new DocumentTextExtractor();
            
            if (!$extractor->isSupported($application->resume_path)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resume file type not supported for text extraction.',
                    'supported_types' => ['PDF', 'DOC', 'DOCX', 'TXT']
                ]);
            }

            $resumeText = $extractor->extractText($application->resume_path);
            
            if (empty(trim($resumeText))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Could not extract text from the resume file. The file might be an image-based PDF or corrupted.'
                ]);
            }

            return response()->json([
                'success' => true,
                'resume_text' => $resumeText,
                'preview' => $extractor->getTextPreview($resumeText),
                'message' => 'Resume text extracted successfully!'
            ]);

        } catch (\Exception $e) {
            \Log::error('Resume text extraction failed: ' . $e->getMessage(), [
                'application_id' => $application->id,
                'resume_path' => $application->resume_path,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to extract text from resume. Please try pasting your resume content manually.'
            ], 500);
        }
    }

    public function generateCoverLetter(Request $request, JobApplication $application)
    {
        \Log::info('Cover letter generation request received', [
            'application_id' => $application->id,
            'user_id' => Auth::id()
        ]);

        // Check if the application belongs to the authenticated user
        if ($application->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access to this application.'
            ], 403);
        }

        try {
            // Get input data
            $resumeContent = $request->input('resume_content', '');
            $additionalInfo = $request->input('additional_info', '') ?? '';
            $useAttachedResume = $request->boolean('use_attached_resume', false);

            \Log::info('Input validation', [
                'has_resume_content' => !empty($resumeContent),
                'has_additional_info' => !empty($additionalInfo),
                'use_attached_resume' => $useAttachedResume
            ]);

            // Handle resume extraction if needed
            if ($useAttachedResume && $application->resume_path) {
                try {
                    $extractor = new DocumentTextExtractor();
                    if ($extractor->isSupported($application->resume_path)) {
                        $extractedText = $extractor->extractText($application->resume_path);
                        if (!empty(trim($extractedText))) {
                            $resumeContent = $extractedText;
                            \Log::info('Resume text extracted successfully', [
                                'length' => strlen($extractedText)
                            ]);
                        }
                    }
                } catch (\Exception $e) {
                    $useAttachedResume = false;
                    \Log::warning('Resume extraction failed: ' . $e->getMessage());
                }
            }

            // Validate resume content
            if (empty(trim($resumeContent))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resume content is required to generate a cover letter.'
                ]);
            }

            // Generate cover letter using AI service
            \Log::info('Starting AI cover letter generation');
            $aiService = new CoverLetterAIService();
            $coverLetter = $aiService->generateCoverLetter($application, $resumeContent, $additionalInfo);

            \Log::info('Cover letter generation completed', [
                'provider' => $aiService->getProvider(),
                'ai_available' => $aiService->isAIAvailable(),
                'cover_letter_length' => strlen($coverLetter)
            ]);

            return response()->json([
                'success' => true,
                'cover_letter' => $coverLetter,
                'used_attached_resume' => $useAttachedResume,
                'ai_provider' => $aiService->getProvider(),
                'ai_available' => $aiService->isAIAvailable(),
                'message' => $aiService->isAIAvailable() 
                    ? 'AI-powered cover letter generated successfully!' 
                    : 'Cover letter generated successfully!'
            ]);

        } catch (\Exception $e) {
            \Log::error('Cover letter generation failed: ' . $e->getMessage(), [
                'application_id' => $application->id,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while generating the cover letter: ' . $e->getMessage()
            ], 500);
        }
    }

    private function generateCoverLetterContent(JobApplication $application, string $resumeContent, string $additionalInfo): string
    {
        try {
            $date = now()->format('F j, Y');
            
            $coverLetter = "{$date}\n\nDear Hiring Manager,\n\n";
            $coverLetter .= "I am writing to express my strong interest in the {$application->job_title} position at {$application->company_name}";

            if ($application->location) {
                $coverLetter .= " in {$application->location}";
            }

            $coverLetter .= ". Having thoroughly reviewed the job requirements, I am confident that my background and skills make me an ideal candidate for this role.\n\n";

            // Extract key skills from resume content
            $keySkills = $this->extractKeySkills($resumeContent);
            
            if (!empty($keySkills)) {
                $coverLetter .= "My experience includes:\n";
                foreach (array_slice($keySkills, 0, 3) as $skill) {
                    $cleanSkill = trim(strip_tags($skill));
                    if (!empty($cleanSkill)) {
                        $coverLetter .= "• {$cleanSkill}\n";
                    }
                }
                $coverLetter .= "\n";
            }

            if (!empty($application->job_description)) {
                $coverLetter .= "I am particularly drawn to this opportunity because ";
                $coverLetter .= $this->generateInterestStatement($application->job_description);
                $coverLetter .= "\n\n";
            }

            if (!empty(trim($additionalInfo))) {
                $coverLetter .= trim($additionalInfo) . "\n\n";
            }

            $coverLetter .= "I would welcome the opportunity to discuss how my background and enthusiasm can contribute to {$application->company_name}'s continued success. Thank you for considering my application. I look forward to hearing from you soon.\n\nSincerely,\n[Your Name]";

            return $coverLetter;
        } catch (\Exception $e) {
            \Log::error('Cover letter content generation failed: ' . $e->getMessage());
            
            // Return a basic cover letter as fallback
            $date = now()->format('F j, Y');
            return "{$date}\n\nDear Hiring Manager,\n\nI am writing to express my strong interest in the {$application->job_title} position at {$application->company_name}. Based on my background and experience, I believe I would be a valuable addition to your team.\n\nI would welcome the opportunity to discuss how I can contribute to your organization's success. Thank you for considering my application.\n\nSincerely,\n[Your Name]";
        }
    }

    private function extractKeySkills(string $resumeContent): array
    {
        try {
            $skills = [];
            
            // Common skill patterns to look for
            $skillPatterns = [
                '/experience (?:with|in) ([^,.]+)/i',
                '/proficient (?:with|in) ([^,.]+)/i',
                '/skilled (?:with|in) ([^,.]+)/i',
                '/expertise (?:with|in) ([^,.]+)/i',
                '/background (?:with|in) ([^,.]+)/i',
            ];

            foreach ($skillPatterns as $pattern) {
                $result = preg_match_all($pattern, $resumeContent, $matches);
                if ($result !== false && !empty($matches[1])) {
                    $skills = array_merge($skills, $matches[1]);
                }
            }

            // Clean up and limit skills
            $skills = array_map('trim', $skills);
            $skills = array_unique($skills);
            $skills = array_filter($skills, function($skill) {
                return is_string($skill) && strlen($skill) > 3 && strlen($skill) < 100;
            });

            return array_values($skills);
        } catch (\Exception $e) {
            \Log::warning('Skill extraction failed: ' . $e->getMessage());
            return [];
        }
    }

    private function generateInterestStatement(string $jobDescription): string
    {
        try {
            $statements = [
                "it aligns perfectly with my career goals and technical expertise",
                "of the innovative work environment and growth opportunities",
                "I am excited about contributing to your team's success",
                "the role offers the perfect blend of challenge and opportunity",
                "it represents an excellent opportunity to apply my skills in a dynamic environment"
            ];

            $randomIndex = array_rand($statements);
            return $statements[$randomIndex] . ".";
        } catch (\Exception $e) {
            \Log::warning('Interest statement generation failed: ' . $e->getMessage());
            return "it aligns well with my career goals and experience.";
        }
    }

    public function analyzeResume(JobApplication $application)
    {
        try {
            // Check if the application belongs to the authenticated user
            if ($application->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to this application.'
                ], 403);
            }

            if (!$application->resume_path) {
                return response()->json([
                    'success' => false,
                    'message' => 'No resume attached to this application.'
                ]);
            }

            // Extract resume text
            $extractor = new DocumentTextExtractor();
            
            if (!$extractor->isSupported($application->resume_path)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resume file type not supported for analysis.',
                    'supported_types' => ['PDF', 'DOC', 'DOCX', 'TXT']
                ]);
            }

            $resumeText = $extractor->extractText($application->resume_path);
            
            if (empty(trim($resumeText))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Could not extract text from the resume file for analysis.'
                ]);
            }

            // Analyze resume using AI service
            Log::info('Starting AI resume analysis', [
                'application_id' => $application->id,
                'resume_length' => strlen($resumeText)
            ]);

            $analyzer = new ResumeAnalyzerService();
            $analysis = $analyzer->analyzeResume($application, $resumeText);

            Log::info('Resume analysis completed', [
                'application_id' => $application->id,
                'provider' => $analyzer->getProvider(),
                'overall_score' => $analysis['overall_score']
            ]);

            return response()->json([
                'success' => true,
                'analysis' => $analysis,
                'resume_preview' => $extractor->getTextPreview($resumeText),
                'ai_provider' => $analyzer->getProvider(),
                'ai_available' => $analyzer->isAIAvailable(),
                'message' => $analyzer->isAIAvailable() 
                    ? 'AI-powered resume analysis completed successfully!' 
                    : 'Resume analysis completed successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Resume analysis failed: ' . $e->getMessage(), [
                'application_id' => $application->id,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while analyzing the resume: ' . $e->getMessage()
            ], 500);
        }
    }
}
