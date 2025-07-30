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
        $stats = [
            'total' => $userApplications->count(),
            'applied' => $userApplications->where('status', 'applied')->count(),
            'interviewing' => $userApplications->where('status', 'interviewing')->count(),
            'offers' => $userApplications->where('status', 'offer')->count(),
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
        
        return view('dashboard', compact('stats', 'upcomingEvents'));
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
}