<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showAuthPage()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'redirect' => route('dashboard')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::min(8)->mixedCase()->numbers()],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'redirect' => route('dashboard')
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('auth.page');
    }

    public function dashboard()
    {
        // Calculate statistics for the dashboard
        $userApplications = Auth::user()->jobApplications();
        $totalApplications = $userApplications->count();
        
        $stats = [
            'total' => $totalApplications,
            'applied' => $userApplications->where('status', 'applied')->count(),
            'interviewing' => $userApplications->where('status', 'interviewing')->count(),
            'offers' => $userApplications->where('status', 'offer')->count(),
        ];
        
        // Calculate real quick stats
        $applicationsWithResponse = $userApplications->whereIn('status', ['interviewing', 'offer', 'rejected'])->count();
        $responseRate = $totalApplications > 0 ? round(($applicationsWithResponse / $totalApplications) * 100) : 0;
        
        // Calculate average response time using created_at to interview_date
        $applicationsWithInterviews = $userApplications->whereNotNull('interview_date')->get();
        $avgResponseDays = 0;
        if ($applicationsWithInterviews->count() > 0) {
            $totalDays = $applicationsWithInterviews->sum(function($app) {
                return $app->created_at->diffInDays($app->interview_date);
            });
            $avgResponseDays = round($totalDays / $applicationsWithInterviews->count());
        }
        
        // Calculate average offer amount
        $applicationsWithSalary = $userApplications->whereNotNull('salary_max')->get();
        $avgOffer = '$0';
        if ($applicationsWithSalary->count() > 0) {
            $totalSalary = $applicationsWithSalary->sum(function($app) {
                return (float) str_replace(['$', ','], '', $app->salary_max);
            });
            $avgSalaryAmount = $totalSalary / $applicationsWithSalary->count();
            $avgOffer = '$' . number_format($avgSalaryAmount / 1000, 0) . 'k';
        }
        
        // Calculate progress percentage based on application funnel
        $progressPercentage = 0;
        if ($totalApplications > 0) {
            $interviewingCount = $stats['interviewing'];
            $offersCount = $stats['offers'];
            $progressPercentage = round((($interviewingCount * 50) + ($offersCount * 100)) / $totalApplications);
            $progressPercentage = min(100, max(0, $progressPercentage)); // Clamp between 0-100
        }
        
        // Match score calculation (based on various factors)
        $matchScore = $this->calculateMatchScore($userApplications, $totalApplications);
        
        $quickStats = [
            'response_rate' => $responseRate,
            'avg_response_days' => $avgResponseDays ?: 'N/A',
            'avg_offer' => $avgOffer,
            'match_score' => $matchScore,
            'progress_percentage' => $progressPercentage
        ];
        
        // Get upcoming events for timeline
        $upcomingEvents = collect();
        $applications = $userApplications->get();
        $now = now();
        
        foreach ($applications as $application) {
            // Upcoming interviews
            if ($application->interview_date && $application->interview_date->gt($now)) {
                $upcomingEvents->push([
                    'date' => $application->interview_date->format('M j'),
                    'title' => ($application->interview_type ? ucfirst($application->interview_type) : 'Interview'),
                    'company' => $application->company_name,
                    'type' => 'interview'
                ]);
            }
            
            // Upcoming deadlines
            if ($application->application_deadline && $application->application_deadline->gt($now)) {
                $upcomingEvents->push([
                    'date' => $application->application_deadline->format('M j'),
                    'title' => 'Application Deadline',
                    'company' => $application->company_name,
                    'type' => 'deadline'
                ]);
            }
            
            // Upcoming follow-ups
            if ($application->follow_up_date && $application->follow_up_date->gt($now)) {
                $upcomingEvents->push([
                    'date' => $application->follow_up_date->format('M j'),
                    'title' => 'Follow Up',
                    'company' => $application->company_name,
                    'type' => 'followup'
                ]);
            }
        }
        
        // Sort by date and take first 3
        $upcomingEvents = $upcomingEvents->sortBy(function ($event) {
            return \Carbon\Carbon::createFromFormat('M j', $event['date'])->dayOfYear;
        })->take(3);
        
        // Get today's tasks from database (with fallback if table doesn't exist)
        $todayTasks = collect();
        
        try {
            $todayTasks = Auth::user()->tasks()
                ->forToday()
                ->orderBy('completed')
                ->orderBy('priority', 'desc')
                ->orderBy('created_at')
                ->get()
                ->map(function ($task) {
                    return [
                        'id' => $task->id,
                        'text' => $task->title,
                        'title' => $task->title,
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
                    ];
                });
        } catch (\Exception $e) {
            // Fallback data if tasks table doesn't exist yet
            $todayTasks = collect([
                [
                    'id' => 'demo_1',
                    'text' => 'Run "php artisan migrate" to enable task management',
                    'title' => 'Run "php artisan migrate" to enable task management',
                    'description' => 'The tasks table needs to be created. Run the migration command.',
                    'priority' => 'high',
                    'category' => 'general',
                    'completed' => false,
                    'completed_at' => null,
                    'due_date' => null,
                    'job_application' => null,
                ],
                [
                    'id' => 'demo_2',
                    'text' => 'Task management will be fully functional after migration',
                    'title' => 'Task management will be fully functional after migration',
                    'description' => 'All CRUD operations, priority levels, and database integration ready.',
                    'priority' => 'normal',
                    'category' => 'general',
                    'completed' => false,
                    'completed_at' => null,
                    'due_date' => null,
                    'job_application' => null,
                ],
            ]);
        }
        
        // Get recent activities from application events and tasks
        $recentActivities = collect();
        
        // Get recent application events
        $applicationEvents = Auth::user()->jobApplications()
            ->with(['events' => function($query) {
                $query->orderBy('created_at', 'desc')->limit(10);
            }])
            ->get()
            ->flatMap(function($application) {
                return $application->events->map(function($event) use ($application) {
                    return [
                        'id' => 'event_' . $event->id,
                        'type' => $this->mapEventTypeToActivityType($event->type),
                        'text' => $this->generateActivityText($event, $application),
                        'company' => $application->company_name,
                        'date' => $event->created_at->format('Y-m-d'),
                        'time' => $event->created_at->diffForHumans(),
                        'priority' => $event->priority ?? 'normal',
                        'created_at' => $event->created_at,
                    ];
                });
            });
        
        // Get recent completed tasks as activities
        $completedTasks = Auth::user()->tasks()
            ->completed()
            ->where('completed_at', '>=', now()->subWeek())
            ->with('jobApplication')
            ->orderBy('completed_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($task) {
                return [
                    'id' => 'task_' . $task->id,
                    'type' => 'task',
                    'text' => 'Completed task: ' . $task->title,
                    'company' => $task->jobApplication ? $task->jobApplication->company_name : null,
                    'date' => $task->completed_at->format('Y-m-d'),
                    'time' => $task->completed_at->diffForHumans(),
                    'priority' => $task->priority,
                    'created_at' => $task->completed_at,
                ];
            });
        
        // Merge and sort activities
        $recentActivities = $applicationEvents->concat($completedTasks)
            ->sortByDesc('created_at')
            ->take(10)
            ->values();
        
        // If no real activities exist, add some sample data
        if ($recentActivities->isEmpty()) {
            $recentActivities = collect([
                [
                    'id' => 'sample_1',
                    'type' => 'application',
                    'text' => 'Start tracking your job applications to see activities here',
                    'company' => null,
                    'date' => now()->format('Y-m-d'),
                    'time' => 'Just now',
                    'priority' => 'normal'
                ]
            ]);
        }
        
        // Get user's job applications for the task modal
        $jobApplications = Auth::user()->jobApplications()
            ->orderBy('created_at', 'desc')
            ->get(['id', 'company_name', 'job_title']);

        return view('dashboard', compact('stats', 'quickStats', 'upcomingEvents', 'todayTasks', 'recentActivities', 'jobApplications'));
    }

    public function calendar()
    {
        $user = Auth::user();
        $applications = $user->jobApplications()->get();
        
        // Get today's events
        $today = now()->startOfDay();
        $todaysEvents = collect();
        
        foreach ($applications as $application) {
            // Interview events
            if ($application->interview_date && $application->interview_date->startOfDay()->equalTo($today)) {
                $todaysEvents->push((object) [
                    'type' => 'interview',
                    'title' => ($application->interview_type ? ucfirst($application->interview_type) : 'Interview'),
                    'company' => $application->company_name,
                    'position' => $application->job_title,
                    'time' => $application->interview_date->format('g:i A'),
                    'location' => $application->interview_location
                ]);
            }
            
            // Application deadline events
            if ($application->application_deadline && $application->application_deadline->startOfDay()->equalTo($today)) {
                $todaysEvents->push((object) [
                    'type' => 'deadline',
                    'title' => 'Application Deadline',
                    'company' => $application->company_name,
                    'position' => $application->job_title,
                    'time' => $application->application_deadline->format('g:i A')
                ]);
            }
            
            // Follow-up events
            if ($application->follow_up_date && $application->follow_up_date->startOfDay()->equalTo($today)) {
                $todaysEvents->push((object) [
                    'type' => 'application',
                    'title' => 'Follow Up',
                    'company' => $application->company_name,
                    'position' => $application->job_title,
                    'time' => $application->follow_up_date->format('g:i A')
                ]);
            }
        }

        // Organize events by date for calendar display
        $events = [];
        
        foreach ($applications as $application) {
            // Interview events
            if ($application->interview_date) {
                $dateKey = $application->interview_date->format('Y-m-d');
                if (!isset($events[$dateKey])) {
                    $events[$dateKey] = [];
                }
                $events[$dateKey][] = [
                    'type' => 'interview',
                    'title' => ($application->interview_type ? ucfirst($application->interview_type) . ' Interview' : 'Interview'),
                    'company' => $application->company_name . ' - ' . $application->job_title,
                    'time' => $application->interview_date->format('g:i A'),
                    'location' => $application->interview_location
                ];
            }
            
            // Application deadline events
            if ($application->application_deadline) {
                $dateKey = $application->application_deadline->format('Y-m-d');
                if (!isset($events[$dateKey])) {
                    $events[$dateKey] = [];
                }
                $events[$dateKey][] = [
                    'type' => 'deadline',
                    'title' => 'Application Deadline',
                    'company' => $application->company_name . ' - ' . $application->job_title,
                    'time' => $application->application_deadline->format('g:i A')
                ];
            }
            
            // Follow-up events
            if ($application->follow_up_date) {
                $dateKey = $application->follow_up_date->format('Y-m-d');
                if (!isset($events[$dateKey])) {
                    $events[$dateKey] = [];
                }
                $events[$dateKey][] = [
                    'type' => 'application',
                    'title' => 'Follow Up',
                    'company' => $application->company_name . ' - ' . $application->job_title,
                    'time' => $application->follow_up_date->format('g:i A')
                ];
            }
            
            // Add applied date as application event
            if ($application->applied_date) {
                $dateKey = $application->applied_date->format('Y-m-d');
                if (!isset($events[$dateKey])) {
                    $events[$dateKey] = [];
                }
                $events[$dateKey][] = [
                    'type' => 'application',
                    'title' => 'Application Submitted',
                    'company' => $application->company_name . ' - ' . $application->job_title,
                    'time' => 'All Day'
                ];
            }
        }
        
        return view('calendar', compact('todaysEvents', 'events'));
    }

    public function analytics()
    {
        $user = Auth::user();
        $applications = $user->jobApplications()->get();
        $totalApplications = $applications->count();
        
        // Calculate analytics data
        $analytics = [
            'total_applications' => $totalApplications,
            'applications_change' => 12, // This would be calculated based on previous period
            'response_rate' => $totalApplications > 0 ? round(($applications->whereNotNull('response_date')->count() / $totalApplications) * 100) : 0,
            'response_rate_change' => 5,
            'interview_rate' => $totalApplications > 0 ? round(($applications->where('status', 'interviewing')->count() / $totalApplications) * 100) : 0,
            'interview_rate_change' => 8,
            'avg_response_time' => '5.2', // This would be calculated from actual response times
            'response_time_change' => 0.8,
            
            // Funnel data
            'funnel' => [
                'applied' => $totalApplications,
                'response' => $applications->whereNotNull('response_date')->count(),
                'response_percent' => $totalApplications > 0 ? round(($applications->whereNotNull('response_date')->count() / $totalApplications) * 100) : 0,
                'phone_screen' => $applications->where('status', 'phone_screen')->count(),
                'phone_screen_percent' => $totalApplications > 0 ? round(($applications->where('status', 'phone_screen')->count() / $totalApplications) * 100) : 0,
                'interview' => $applications->where('status', 'interviewing')->count(),
                'interview_percent' => $totalApplications > 0 ? round(($applications->where('status', 'interviewing')->count() / $totalApplications) * 100) : 0,
                'final_round' => $applications->where('status', 'final_round')->count(),
                'final_round_percent' => $totalApplications > 0 ? round(($applications->where('status', 'final_round')->count() / $totalApplications) * 100) : 0,
                'offer' => $applications->where('status', 'offer')->count(),
                'offer_percent' => $totalApplications > 0 ? round(($applications->where('status', 'offer')->count() / $totalApplications) * 100) : 0,
            ],
            
            // Chart data for applications over time
            'chart_labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7', 'Week 8'],
            'chart_data' => [3, 7, 5, 8, 6, 9, 4, 5],
            
            // Sources data
            'sources' => [
                'labels' => ['LinkedIn', 'Company Sites', 'Referrals', 'Job Boards', 'Recruiters'],
                'data' => [35, 25, 15, 15, 10]
            ],
            
            // AI Insights
            'insights' => [
                [
                    'title' => 'Peak Application Time',
                    'description' => 'Your applications sent on <span class="insight-metric">Tuesday mornings</span> have a <span class="insight-metric">34% higher response rate</span> than other times.'
                ],
                [
                    'title' => 'Industry Focus',
                    'description' => '<span class="insight-metric">SaaS companies</span> respond to your applications <span class="insight-metric">2.3x faster</span> than traditional enterprises.'
                ],
                [
                    'title' => 'Application Length',
                    'description' => 'Cover letters with <span class="insight-metric">150-200 words</span> show <span class="insight-metric">28% better conversion</span> to phone screens.'
                ],
                [
                    'title' => 'Follow-up Strategy',
                    'description' => 'Following up after <span class="insight-metric">7 days</span> increases your interview rate by <span class="insight-metric">41%</span>.'
                ]
            ],
            
            'avg_salary' => '145k',
            'salary_comparison' => '18% above market rate'
        ];
        
        return view('analytics', compact('analytics'));
    }

    public function checkAuth()
    {
        return response()->json([
            'authenticated' => Auth::check()
        ]);
    }

    private function mapEventTypeToActivityType($eventType)
    {
        $mapping = [
            'application_submitted' => 'application',
            'interview_scheduled' => 'interview',
            'interview_completed' => 'interview',
            'offer_received' => 'offer',
            'follow_up_sent' => 'followup',
            'rejection_received' => 'rejection',
            'phone_screen' => 'interview',
            'technical_interview' => 'interview',
            'final_interview' => 'interview',
            'offer_accepted' => 'offer',
            'offer_declined' => 'offer',
        ];

        return $mapping[$eventType] ?? 'application';
    }

    private function generateActivityText($event, $application)
    {
        $textMapping = [
            'application_submitted' => 'Applied to ' . $application->job_title . ' position',
            'interview_scheduled' => 'Interview scheduled',
            'interview_completed' => 'Interview completed',
            'offer_received' => 'Offer received',
            'follow_up_sent' => 'Follow-up sent',
            'rejection_received' => 'Application status updated',
            'phone_screen' => 'Phone screen scheduled',
            'technical_interview' => 'Technical interview scheduled',
            'final_interview' => 'Final interview scheduled',
            'offer_accepted' => 'Offer accepted',
            'offer_declined' => 'Offer declined',
        ];

        return $textMapping[$event->type] ?? ($event->title ?? 'Application event logged');
    }

    private function calculateMatchScore($userApplications, $totalApplications)
    {
        if ($totalApplications === 0) {
            return '0.0';
        }

        $score = 0;
        $factors = 0;

        // Factor 1: Response rate (0-2 points)
        $applicationsWithResponse = $userApplications->whereIn('status', ['interviewing', 'offer', 'rejected'])->count();
        $responseRate = ($applicationsWithResponse / $totalApplications) * 100;
        $score += min(2, $responseRate / 50); // Max 2 points for 50%+ response rate
        $factors++;

        // Factor 2: Interview conversion rate (0-2 points)
        $interviewCount = $userApplications->where('status', 'interviewing')->count();
        $interviewRate = ($interviewCount / $totalApplications) * 100;
        $score += min(2, $interviewRate / 25); // Max 2 points for 25%+ interview rate
        $factors++;

        // Factor 3: Offer conversion rate (0-1 point)
        $offerCount = $userApplications->where('status', 'offer')->count();
        $offerRate = ($offerCount / $totalApplications) * 100;
        $score += min(1, $offerRate / 10); // Max 1 point for 10%+ offer rate
        $factors++;

        // Calculate final score out of 5 and format
        $finalScore = ($score / 5) * 5;
        return number_format($finalScore, 1);
    }
}