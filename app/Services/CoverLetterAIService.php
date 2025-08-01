<?php

namespace App\Services;

use App\Models\JobApplication;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CoverLetterAIService
{
    private const GEMINI_API_URL = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent';
    private const OPENAI_API_URL = 'https://api.openai.com/v1/chat/completions';
    
    private string $provider;
    private string $apiKey;
    
    public function __construct()
    {
        // Try to use available API keys in order of preference
        if (!empty(config('services.gemini.api_key'))) {
            $this->provider = 'gemini';
            $this->apiKey = config('services.gemini.api_key');
        } elseif (!empty(config('services.openai.api_key'))) {
            $this->provider = 'openai';
            $this->apiKey = config('services.openai.api_key');
        } else {
            $this->provider = 'fallback';
            $this->apiKey = '';
        }
    }
    
    public function generateCoverLetter(JobApplication $application, string $resumeContent, ?string $additionalInfo = ''): string
    {
        // Ensure additionalInfo is a string
        $additionalInfo = $additionalInfo ?? '';
        
        \Log::info('Cover letter generation started', [
            'provider' => $this->provider,
            'application_id' => $application->id,
            'has_api_key' => !empty($this->apiKey)
        ]);
        
        try {
            switch ($this->provider) {
                case 'gemini':
                    \Log::info('Using Gemini API for cover letter generation');
                    return $this->generateWithGemini($application, $resumeContent, $additionalInfo);
                case 'openai':
                    \Log::info('Using OpenAI API for cover letter generation');
                    return $this->generateWithOpenAI($application, $resumeContent, $additionalInfo);
                default:
                    \Log::info('Using fallback cover letter generation');
                    return $this->generateFallbackCoverLetter($application, $resumeContent, $additionalInfo);
            }
        } catch (Exception $e) {
            \Log::error('AI cover letter generation failed, using fallback', [
                'error' => $e->getMessage(),
                'provider' => $this->provider
            ]);
            return $this->generateFallbackCoverLetter($application, $resumeContent, $additionalInfo);
        }
    }
    
    private function generateWithGemini(JobApplication $application, string $resumeContent, ?string $additionalInfo): string
    {
        $prompt = $this->buildPrompt($application, $resumeContent, $additionalInfo);
        
        $url = self::GEMINI_API_URL . '?key=' . $this->apiKey;
        
        $response = Http::timeout(30)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 1000,
                    'topP' => 0.8,
                    'topK' => 10
                ]
            ]);
        
        if (!$response->successful()) {
            \Log::error('Gemini API request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'headers' => $response->headers()
            ]);
            throw new Exception('Gemini API request failed (HTTP ' . $response->status() . '): ' . $response->body());
        }
        
        $data = $response->json();
        
        \Log::info('Gemini API response received', [
            'has_candidates' => isset($data['candidates']),
            'response_keys' => array_keys($data ?? [])
        ]);
        
        if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            \Log::error('Invalid Gemini API response format', ['response' => $data]);
            throw new Exception('Invalid response format from Gemini API: ' . json_encode($data));
        }
        
        return trim($data['candidates'][0]['content']['parts'][0]['text']);
    }
    
    private function generateWithOpenAI(JobApplication $application, string $resumeContent, ?string $additionalInfo): string
    {
        $prompt = $this->buildPrompt($application, $resumeContent, $additionalInfo);
        
        $response = Http::timeout(30)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])
            ->post(self::OPENAI_API_URL, [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a professional career coach and expert cover letter writer. Write compelling, personalized cover letters that highlight relevant experience and show genuine interest in the position.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 800
            ]);
            
        if (!$response->successful()) {
            throw new Exception('OpenAI API request failed: ' . $response->body());
        }
        
        $data = $response->json();
        
        if (!isset($data['choices'][0]['message']['content'])) {
            throw new Exception('Invalid response format from OpenAI API');
        }
        
        return trim($data['choices'][0]['message']['content']);
    }
    
    private function buildPrompt(JobApplication $application, string $resumeContent, ?string $additionalInfo): string
    {
        $prompt = "Write a professional cover letter for the following job application:\n\n";
        
        $prompt .= "JOB DETAILS:\n";
        $prompt .= "Position: {$application->job_title}\n";
        $prompt .= "Company: {$application->company_name}\n";
        
        if ($application->location) {
            $prompt .= "Location: {$application->location}\n";
        }
        
        if ($application->department) {
            $prompt .= "Department: {$application->department}\n";
        }
        
        if ($application->employment_type) {
            $prompt .= "Employment Type: " . ucfirst($application->employment_type) . "\n";
        }
        
        if ($application->job_description) {
            $prompt .= "Job Description: " . substr($application->job_description, 0, 1000) . "\n";
        }
        
        $prompt .= "\nAPPLICANT'S RESUME/BACKGROUND:\n";
        $prompt .= substr($resumeContent, 0, 2000) . "\n";
        
        if (!empty(trim($additionalInfo ?? ''))) {
            $prompt .= "\nADDITIONAL INFORMATION:\n";
            $prompt .= trim($additionalInfo) . "\n";
        }
        
        $prompt .= "\nINSTRUCTIONS:\n";
        $prompt .= "- Write a compelling cover letter that highlights relevant experience from the resume\n";
        $prompt .= "- Show genuine interest in the specific role and company\n";
        $prompt .= "- Keep it professional but personable\n";
        $prompt .= "- Length should be 3-4 paragraphs\n";
        $prompt .= "- Include today's date: " . now()->format('F j, Y') . "\n";
        $prompt .= "- Start with 'Dear Hiring Manager,' or similar\n";
        $prompt .= "- End with 'Sincerely,' and leave [Your Name] as a placeholder\n";
        $prompt .= "- Do not include any header information like addresses\n";
        $prompt .= "- Focus on value proposition and specific qualifications\n";
        
        return $prompt;
    }
    
    private function generateFallbackCoverLetter(JobApplication $application, string $resumeContent, ?string $additionalInfo): string
    {
        $date = now()->format('F j, Y');
        
        $coverLetter = "{$date}\n\nDear Hiring Manager,\n\n";
        
        $coverLetter .= "I am writing to express my strong interest in the {$application->job_title} position at {$application->company_name}";
        
        if ($application->location) {
            $coverLetter .= " in {$application->location}";
        }
        
        $coverLetter .= ". After reviewing the job requirements and considering my background, I am confident that my skills and experience make me an excellent candidate for this role.\n\n";
        
        // Try to extract a few key points from resume
        $keyPoints = $this->extractKeyExperience($resumeContent);
        if (!empty($keyPoints)) {
            $coverLetter .= "My relevant experience includes:\n";
            foreach ($keyPoints as $point) {
                $coverLetter .= "• {$point}\n";
            }
            $coverLetter .= "\n";
        }
        
        if (!empty(trim($additionalInfo ?? ''))) {
            $coverLetter .= trim($additionalInfo) . "\n\n";
        }
        
        $coverLetter .= "I am excited about the opportunity to contribute to {$application->company_name}'s success and would welcome the chance to discuss how my background aligns with your needs. Thank you for considering my application.\n\n";
        
        $coverLetter .= "Sincerely,\n[Your Name]";
        
        return $coverLetter;
    }
    
    private function extractKeyExperience(string $resumeContent): array
    {
        $points = [];
        $lines = explode("\n", $resumeContent);
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || strlen($line) < 20) continue;
            
            // Look for lines that might contain experience
            if (preg_match('/\b(experience|developed|managed|led|created|built|implemented|designed|worked)\b/i', $line)) {
                $points[] = $line;
                if (count($points) >= 3) break; // Limit to 3 points
            }
        }
        
        return $points;
    }
    
    public function isAIAvailable(): bool
    {
        return $this->provider !== 'fallback';
    }
    
    public function getProvider(): string
    {
        return $this->provider;
    }
}