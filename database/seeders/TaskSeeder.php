<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;
use App\Models\JobApplication;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first user or create one
        $user = User::first();
        
        if (!$user) {
            $user = User::create([
                'name' => 'Demo User',
                'email' => 'demo@zenith.app',
                'password' => bcrypt('password'),
            ]);
        }

        // Get some job applications to link tasks to
        $applications = $user->jobApplications()->limit(3)->get();

        // Create sample tasks
        $sampleTasks = [
            [
                'title' => 'Follow up with Stripe engineering team',
                'description' => 'Send email to check on application status and next steps',
                'priority' => 'high',
                'category' => 'followup',
                'completed' => false,
                'due_date' => now()->addDays(1),
                'job_application_id' => $applications->first()?->id,
            ],
            [
                'title' => 'Prepare for Meta technical interview',
                'description' => 'Review system design concepts and practice coding problems',
                'priority' => 'high',
                'category' => 'interview',
                'completed' => true,
                'completed_at' => now()->subHours(2),
                'due_date' => now(),
                'job_application_id' => $applications->skip(1)->first()?->id,
            ],
            [
                'title' => 'Update portfolio with latest project',
                'description' => 'Add the new React dashboard project to portfolio website',
                'priority' => 'normal',
                'category' => 'general',
                'completed' => false,
                'due_date' => now()->addDays(3),
            ],
            [
                'title' => 'Research OpenAI company culture',
                'description' => 'Read about company values, recent news, and team structure',
                'priority' => 'normal',
                'category' => 'research',
                'completed' => false,
                'due_date' => now(),
                'job_application_id' => $applications->last()?->id,
            ],
            [
                'title' => 'Practice behavioral interview questions',
                'description' => 'Prepare STAR method responses for common behavioral questions',
                'priority' => 'normal',
                'category' => 'interview',
                'completed' => false,
                'due_date' => now()->addDays(2),
            ],
            [
                'title' => 'Send thank you email to Linear recruiter',
                'description' => 'Follow up after the initial screening call',
                'priority' => 'high',
                'category' => 'followup',
                'completed' => true,
                'completed_at' => now()->subDays(1),
                'due_date' => now()->subDays(1),
            ],
        ];

        foreach ($sampleTasks as $taskData) {
            Task::create(array_merge($taskData, ['user_id' => $user->id]));
        }

        $this->command->info('Created ' . count($sampleTasks) . ' sample tasks for user: ' . $user->email);
    }
}