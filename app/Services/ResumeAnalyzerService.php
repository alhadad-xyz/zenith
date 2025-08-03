<?php

namespace App\Services;

use App\Models\JobApplication;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ResumeAnalyzerService
{
    private const GEMINI_API_URL = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';
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
    
    public function analyzeResume(JobApplication $application, string $resumeContent): array
    {
        Log::info('Resume analysis started', [
            'provider' => $this->provider,
            'application_id' => $application->id,
            'has_api_key' => !empty($this->apiKey)
        ]);
        
        try {
            switch ($this->provider) {
                case 'gemini':
                    Log::info('Using Gemini API for resume analysis');
                    return $this->analyzeWithGemini($application, $resumeContent);
                case 'openai':
                    Log::info('Using OpenAI API for resume analysis');
                    return $this->analyzeWithOpenAI($application, $resumeContent);
                default:
                    Log::info('Using fallback resume analysis');
                    return $this->analyzeFallback($application, $resumeContent);
            }
        } catch (Exception $e) {
            Log::error('AI resume analysis failed, using fallback', [
                'error' => $e->getMessage(),
                'provider' => $this->provider
            ]);
            return $this->analyzeFallback($application, $resumeContent);
        }
    }
    
    private function analyzeWithGemini(JobApplication $application, string $resumeContent): array
    {
        $prompt = $this->buildAnalysisPrompt($application, $resumeContent);
        
        $url = self::GEMINI_API_URL . '?key=' . $this->apiKey;
        
        $response = Http::timeout(45)
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
                    'temperature' => 0.3,
                    'maxOutputTokens' => 2000,
                    'topP' => 0.8,
                    'topK' => 10
                ]
            ]);
        
        if (!$response->successful()) {
            Log::error('Gemini API request failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            throw new Exception('Gemini API request failed');
        }
        
        $data = $response->json();
        
        if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            throw new Exception('Invalid response format from Gemini API');
        }
        
        return $this->parseAnalysisResponse($data['candidates'][0]['content']['parts'][0]['text']);
    }
    
    private function analyzeWithOpenAI(JobApplication $application, string $resumeContent): array
    {
        $prompt = $this->buildAnalysisPrompt($application, $resumeContent);
        
        $response = Http::timeout(45)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])
            ->post(self::OPENAI_API_URL, [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an expert resume analyst and career advisor. Provide detailed, actionable feedback to help improve resumes for specific job applications.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.3,
                'max_tokens' => 1500
            ]);
        
        if (!$response->successful()) {
            throw new Exception('OpenAI API request failed');
        }
        
        $data = $response->json();
        
        if (!isset($data['choices'][0]['message']['content'])) {
            throw new Exception('Invalid response format from OpenAI API');
        }
        
        return $this->parseAnalysisResponse($data['choices'][0]['message']['content']);
    }
    
    private function buildAnalysisPrompt(JobApplication $application, string $resumeContent): string
    {
        $prompt = "Please analyze this resume against the following job requirements and provide detailed feedback:\n\n";
        
        $prompt .= "=== JOB REQUIREMENTS ===\n";
        $prompt .= "Position: {$application->job_title}\n";
        $prompt .= "Company: {$application->company_name}\n";
        
        if ($application->department) {
            $prompt .= "Department: {$application->department}\n";
        }
        
        if ($application->employment_type) {
            $prompt .= "Employment Type: " . ucfirst($application->employment_type) . "\n";
        }
        
        if ($application->job_description) {
            $prompt .= "Job Description:\n" . substr($application->job_description, 0, 1500) . "\n\n";
        }
        
        $prompt .= "=== RESUME CONTENT ===\n";
        $prompt .= substr($resumeContent, 0, 3000) . "\n\n";
        
        $prompt .= "=== ANALYSIS REQUEST ===\n";
        $prompt .= "Please provide a comprehensive analysis in the following JSON format:\n\n";
        $prompt .= "{\n";
        $prompt .= '  "overall_score": 85,' . "\n";
        $prompt .= '  "match_percentage": 78,' . "\n";
        $prompt .= '  "strengths": [' . "\n";
        $prompt .= '    "Strong technical background in relevant technologies",' . "\n";
        $prompt .= '    "Relevant industry experience",' . "\n";
        $prompt .= '    "Clear career progression"' . "\n";
        $prompt .= '  ],' . "\n";
        $prompt .= '  "weaknesses": [' . "\n";
        $prompt .= '    "Missing specific skill mentioned in job description",' . "\n";
        $prompt .= '    "Limited quantifiable achievements"' . "\n";
        $prompt .= '  ],' . "\n";
        $prompt .= '  "missing_keywords": [' . "\n";
        $prompt .= '    "Python",' . "\n";
        $prompt .= '    "Machine Learning",' . "\n";
        $prompt .= '    "Agile methodology"' . "\n";
        $prompt .= '  ],' . "\n";
        $prompt .= '  "improvement_suggestions": [' . "\n";
        $prompt .= '    {' . "\n";
        $prompt .= '      "category": "Skills",' . "\n";
        $prompt .= '      "priority": "High",' . "\n";
        $prompt .= '      "suggestion": "Add Python programming experience to skills section",' . "\n";
        $prompt .= '      "impact": "Addresses key job requirement"' . "\n";
        $prompt .= '    },' . "\n";
        $prompt .= '    {' . "\n";
        $prompt .= '      "category": "Experience",' . "\n";
        $prompt .= '      "priority": "Medium",' . "\n";
        $prompt .= '      "suggestion": "Quantify achievements with specific metrics",' . "\n";
        $prompt .= '      "impact": "Makes accomplishments more compelling"' . "\n";
        $prompt .= '    }' . "\n";
        $prompt .= '  ],' . "\n";
        $prompt .= '  "ats_optimization": {' . "\n";
        $prompt .= '    "score": 72,' . "\n";
        $prompt .= '    "recommendations": [' . "\n";
        $prompt .= '      "Use more industry-standard keywords",' . "\n";
        $prompt .= '      "Improve formatting for ATS readability"' . "\n";
        $prompt .= '    ]' . "\n";
        $prompt .= '  },' . "\n";
        $prompt .= '  "key_recommendations": [' . "\n";
        $prompt .= '    "Highlight specific achievements that align with job requirements",' . "\n";
        $prompt .= '    "Add missing technical skills mentioned in job description"' . "\n";
        $prompt .= '  ]' . "\n";
        $prompt .= "}\n\n";
        
        $prompt .= "IMPORTANT INSTRUCTIONS:\n";
        $prompt .= "- Provide only valid JSON response, no additional text\n";
        $prompt .= "- Be specific and actionable in your suggestions\n";
        $prompt .= "- Focus on relevance to the specific job posting\n";
        $prompt .= "- Consider both content and ATS optimization\n";
        $prompt .= "- Score should be realistic (60-95 range)\n";
        $prompt .= "- Prioritize suggestions by impact (High/Medium/Low)\n";
        
        return $prompt;
    }
    
    private function parseAnalysisResponse(string $response): array
    {
        try {
            // Clean the response to extract JSON
            $response = trim($response);
            
            // Try to extract JSON from the response
            if (preg_match('/\{.*\}/s', $response, $matches)) {
                $jsonString = $matches[0];
                $decoded = json_decode($jsonString, true);
                
                if (json_last_error() === JSON_ERROR_NONE && $decoded) {
                    return $this->validateAndNormalizeAnalysis($decoded);
                }
            }
            
            throw new Exception('Could not parse JSON from AI response');
            
        } catch (Exception $e) {
            Log::warning('Failed to parse AI analysis response: ' . $e->getMessage());
            return $this->generateFallbackAnalysis();
        }
    }
    
    private function validateAndNormalizeAnalysis(array $analysis): array
    {
        // Ensure all required fields exist with defaults
        return [
            'overall_score' => (int) ($analysis['overall_score'] ?? 75),
            'match_percentage' => (int) ($analysis['match_percentage'] ?? 70),
            'strengths' => array_slice($analysis['strengths'] ?? [], 0, 5),
            'weaknesses' => array_slice($analysis['weaknesses'] ?? [], 0, 5),
            'missing_keywords' => array_slice($analysis['missing_keywords'] ?? [], 0, 10),
            'improvement_suggestions' => array_slice($analysis['improvement_suggestions'] ?? [], 0, 8),
            'ats_optimization' => [
                'score' => (int) ($analysis['ats_optimization']['score'] ?? 70),
                'recommendations' => array_slice($analysis['ats_optimization']['recommendations'] ?? [], 0, 5)
            ],
            'key_recommendations' => array_slice($analysis['key_recommendations'] ?? [], 0, 5),
            'ai_provider' => $this->provider,
            'analysis_date' => now()->toISOString()
        ];
    }
    
    private function analyzeFallback(JobApplication $application, string $resumeContent): array
    {
        Log::info('Using fallback resume analysis');
        
        $analysis = $this->generateFallbackAnalysis();
        
        // Try to extract some basic insights
        $keywords = $this->extractBasicKeywords($resumeContent, $application);
        if (!empty($keywords)) {
            $analysis['missing_keywords'] = array_slice($keywords, 0, 5);
        }
        
        return $analysis;
    }
    
    private function generateFallbackAnalysis(): array
    {
        return [
            'overall_score' => 75,
            'match_percentage' => 70,
            'strengths' => [
                'Professional resume format',
                'Clear work history progression',
                'Relevant educational background'
            ],
            'weaknesses' => [
                'Could benefit from more quantifiable achievements',
                'Consider adding more industry-specific keywords',
                'Skills section could be more detailed'
            ],
            'missing_keywords' => [
                'Leadership',
                'Project Management',
                'Communication Skills'
            ],
            'improvement_suggestions' => [
                [
                    'category' => 'Content',
                    'priority' => 'High',
                    'suggestion' => 'Add quantifiable achievements and metrics to demonstrate impact',
                    'impact' => 'Makes your accomplishments more compelling to employers'
                ],
                [
                    'category' => 'Keywords',
                    'priority' => 'Medium',
                    'suggestion' => 'Include more industry-specific technical terms',
                    'impact' => 'Improves ATS compatibility and relevance scoring'
                ],
                [
                    'category' => 'Format',
                    'priority' => 'Low',
                    'suggestion' => 'Ensure consistent formatting throughout the document',
                    'impact' => 'Enhances professional appearance and readability'
                ]
            ],
            'ats_optimization' => [
                'score' => 72,
                'recommendations' => [
                    'Use standard section headings (Experience, Education, Skills)',
                    'Include relevant keywords naturally throughout the content',
                    'Ensure clean, simple formatting without complex layouts'
                ]
            ],
            'key_recommendations' => [
                'Tailor your resume to match specific job requirements',
                'Add measurable results and achievements',
                'Update skills section with relevant technologies'
            ],
            'ai_provider' => 'fallback',
            'analysis_date' => now()->toISOString()
        ];
    }
    
    private function extractBasicKeywords(string $resumeContent, JobApplication $application): array
    {
        $missingKeywords = [];
        
        if ($application->job_description) {
            // Extract common technical and professional keywords from job description
            $jobWords = str_word_count(strtolower($application->job_description), 1);
            $resumeWords = str_word_count(strtolower($resumeContent), 1);
            
            $commonKeywords = [
                'python', 'javascript', 'java', 'react', 'node', 'sql', 'mongodb',
                'leadership', 'management', 'agile', 'scrum', 'git', 'aws', 'docker',
                'communication', 'teamwork', 'problem solving', 'analytics', 'marketing'
            ];
            
            foreach ($commonKeywords as $keyword) {
                if (in_array($keyword, $jobWords) && !in_array($keyword, $resumeWords)) {
                    $missingKeywords[] = ucfirst($keyword);
                }
            }
        }
        
        return array_unique($missingKeywords);
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