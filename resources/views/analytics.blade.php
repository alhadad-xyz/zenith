<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Zenith - Analytics Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f1e8 0%, #e8f2e8 50%, #f0e5e0 100%);
            min-height: 100vh;
            overflow-x: hidden;
            letter-spacing: -0.01em;
            color: #2d3e2e;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 0 0 24px 24px;
            padding: 1.5rem 2rem;
            box-shadow: 0 8px 40px rgba(45, 62, 46, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            margin: 0 1rem;
        }

        .navbar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            border-radius: 0 0 24px 24px;
            opacity: 0.6;
        }

        .brand {
            font-size: 2rem;
            font-weight: 800;
            color: #2d3e2e;
            letter-spacing: -0.02em;
            position: relative;
            z-index: 2;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            position: relative;
            z-index: 2;
        }

        .nav-link {
            text-decoration: none;
            color: #6b7c6d;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover, .nav-link.active {
            color: #2d3e2e;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #ff6b6b, #ff5252);
            border-radius: 1px;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            position: relative;
            z-index: 2;
        }

        .user-name {
            font-weight: 600;
            color: #2d3e2e;
            font-size: 0.95rem;
        }

        .logout-btn {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
            color: white;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 0 8px 32px rgba(255, 107, 107, 0.3);
            letter-spacing: -0.01em;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 48px rgba(255, 107, 107, 0.4);
            background: linear-gradient(135deg, #ff5252 0%, #ff4444 100%);
        }

        .container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Header */
        .header {
            margin-bottom: 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            padding: 2rem 3rem;
        }

        .header-content {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .header-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2d3e2e;
            letter-spacing: -0.03em;
        }

        .header-subtitle {
            font-size: 1.1rem;
            color: #6b7c6d;
            font-weight: 500;
        }

        .header-controls {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .time-selector {
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: #2d3e2e;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            backdrop-filter: blur(10px);
        }

        .time-selector:hover,
        .time-selector.active {
            background: rgba(255, 107, 107, 0.9);
            color: white;
            transform: translateY(-2px);
        }

        /* Bento Grid */
        .analytics-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-template-rows: repeat(8, 120px);
            gap: 1.5rem;
        }

        .analytics-card {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 24px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            display: flex;
            flex-direction: column;
        }

        .analytics-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .analytics-card:hover::before {
            opacity: 1;
        }

        .analytics-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 32px 64px rgba(45, 62, 46, 0.15);
            border-color: rgba(255, 255, 255, 0.6);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 2;
        }

        .card-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #2d3e2e;
            letter-spacing: -0.02em;
        }

        .card-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2d3e2e;
            line-height: 1;
        }

        .card-change {
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            margin-top: 0.5rem;
        }

        .card-change.positive {
            background: rgba(46, 125, 50, 0.1);
            color: #2e7d32;
        }

        .card-change.negative {
            background: rgba(255, 107, 107, 0.1);
            color: #ff6b6b;
        }

        .chart-container {
            flex: 1;
            position: relative;
            min-height: 0;
        }

        /* Individual Card Layouts */
        .total-applications {
            grid-column: 1 / 4;
            grid-row: 1 / 3;
            background: linear-gradient(135deg, rgba(240, 229, 224, 0.4) 0%, rgba(240, 229, 224, 0.6) 100%);
        }

        .response-rate {
            grid-column: 4 / 7;
            grid-row: 1 / 3;
            background: linear-gradient(135deg, rgba(232, 242, 232, 0.4) 0%, rgba(232, 242, 232, 0.6) 100%);
        }

        .interview-rate {
            grid-column: 7 / 10;
            grid-row: 1 / 3;
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.1) 0%, rgba(255, 107, 107, 0.2) 100%);
        }

        .avg-time {
            grid-column: 10 / 13;
            grid-row: 1 / 3;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0.6) 100%);
        }

        .applications-chart {
            grid-column: 1 / 8;
            grid-row: 3 / 6;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0.5) 100%);
        }

        .funnel-chart {
            grid-column: 8 / 13;
            grid-row: 3 / 6;
            background: linear-gradient(135deg, rgba(240, 229, 224, 0.3) 0%, rgba(240, 229, 224, 0.5) 100%);
        }

        .sources-chart {
            grid-column: 1 / 6;
            grid-row: 6 / 9;
            background: linear-gradient(135deg, rgba(232, 242, 232, 0.3) 0%, rgba(232, 242, 232, 0.5) 100%);
        }

        .ai-insights {
            grid-column: 6 / 13;
            grid-row: 6 / 9;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0.45) 100%);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        /* AI Insights Styling */
        .ai-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .ai-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
            animation: aiPulse 3s ease-in-out infinite;
        }

        @keyframes aiPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(255, 107, 107, 0.4); }
            50% { box-shadow: 0 0 0 8px rgba(255, 107, 107, 0); }
        }

        .ai-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #2d3e2e;
        }

        .ai-content {
            flex: 1;
            overflow-y: auto;
        }

        .insight-item {
            margin-bottom: 1.5rem;
            padding: 1.25rem;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 16px;
            border-left: 4px solid #ff6b6b;
            transition: all 0.3s ease;
        }

        .insight-item:hover {
            background: rgba(255, 255, 255, 0.6);
            transform: translateX(4px);
        }

        .insight-title {
            font-size: 1rem;
            font-weight: 700;
            color: #2d3e2e;
            margin-bottom: 0.5rem;
        }

        .insight-text {
            font-size: 0.95rem;
            color: #6b7c6d;
            line-height: 1.5;
        }

        .insight-metric {
            font-weight: 600;
            color: #ff6b6b;
        }

        /* Chart Specific Styles */
        .funnel-stage {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .funnel-stage:hover {
            background: rgba(255, 255, 255, 0.6);
            transform: translateX(4px);
        }

        .funnel-bar {
            height: 8px;
            background: linear-gradient(90deg, #ff6b6b 0%, #ff5252 100%);
            border-radius: 4px;
            margin: 0 1rem;
            flex: 1;
            position: relative;
            overflow: hidden;
        }

        .funnel-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: rgba(255, 255, 255, 0.3);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { width: 0%; }
            50% { width: 100%; }
            100% { width: 0%; }
        }

        .funnel-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #2d3e2e;
            min-width: 100px;
        }

        .funnel-value {
            font-size: 0.9rem;
            font-weight: 700;
            color: #6b7c6d;
            min-width: 60px;
            text-align: right;
        }

        /* Responsive Design */
        @media (max-width: 1400px) {
            .analytics-grid {
                grid-template-columns: repeat(8, 1fr);
            }
            
            .total-applications { grid-column: 1 / 3; grid-row: 1 / 3; }
            .response-rate { grid-column: 3 / 5; grid-row: 1 / 3; }
            .interview-rate { grid-column: 5 / 7; grid-row: 1 / 3; }
            .avg-time { grid-column: 7 / 9; grid-row: 1 / 3; }
            .applications-chart { grid-column: 1 / 5; grid-row: 3 / 6; }
            .funnel-chart { grid-column: 5 / 9; grid-row: 3 / 6; }
            .sources-chart { grid-column: 1 / 4; grid-row: 6 / 9; }
            .ai-insights { grid-column: 4 / 9; grid-row: 6 / 9; }
        }

        @media (max-width: 1024px) {
            .analytics-grid {
                grid-template-columns: repeat(4, 1fr);
                grid-template-rows: repeat(16, 100px);
                gap: 1rem;
            }
            
            .total-applications { grid-column: 1 / 2; grid-row: 1 / 3; }
            .response-rate { grid-column: 2 / 3; grid-row: 1 / 3; }
            .interview-rate { grid-column: 3 / 4; grid-row: 1 / 3; }
            .avg-time { grid-column: 4 / 5; grid-row: 1 / 3; }
            .applications-chart { grid-column: 1 / 5; grid-row: 3 / 7; }
            .funnel-chart { grid-column: 1 / 5; grid-row: 7 / 11; }
            .sources-chart { grid-column: 1 / 3; grid-row: 11 / 15; }
            .ai-insights { grid-column: 3 / 5; grid-row: 11 / 15; }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
            }
            
            .analytics-grid {
                grid-template-columns: 1fr;
                grid-template-rows: repeat(24, 80px);
            }
            
            .total-applications, .response-rate, .interview-rate, .avg-time {
                grid-column: 1;
                grid-row: span 2;
            }
            
            .applications-chart, .funnel-chart, .sources-chart, .ai-insights {
                grid-column: 1;
                grid-row: span 4;
            }

            .navbar {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }

            .nav-links {
                gap: 1rem;
            }
        }

        /* Custom Scrollbar */
        .ai-content::-webkit-scrollbar {
            width: 4px;
        }

        .ai-content::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .ai-content::-webkit-scrollbar-thumb {
            background: rgba(255, 107, 107, 0.3);
            border-radius: 2px;
        }

        /* Loading Animation */
        .loading-shimmer {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.3) 50%, rgba(255, 255, 255, 0.1) 100%);
            background-size: 200% 100%;
            animation: shimmerLoad 2s infinite;
        }

        @keyframes shimmerLoad {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="brand">Zenith</div>
        <div class="nav-links">
            <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
            <a href="{{ route('applications.index') }}" class="nav-link">Applications</a>
            <a href="{{ route('calendar') }}" class="nav-link">Calendar</a>
            <a href="{{ route('analytics') }}" class="nav-link active">Analytics</a>
        </div>
        <div class="user-menu">
            <span class="user-name">{{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <h1 class="header-title">Analytics Dashboard</h1>
                <p class="header-subtitle">Insights into your job search performance and trends</p>
            </div>
            <div class="header-controls">
                <button class="time-selector active" onclick="setTimeRange('7d')">7 Days</button>
                <button class="time-selector" onclick="setTimeRange('30d')">30 Days</button>
                <button class="time-selector" onclick="setTimeRange('90d')">90 Days</button>
                <button class="time-selector" onclick="setTimeRange('1y')">1 Year</button>
            </div>
        </header>

        <!-- Analytics Grid -->
        <div class="analytics-grid">
            <!-- Key Metrics -->
            <div class="analytics-card total-applications">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Total Applications</h3>
                        <div class="card-value">{{ $analytics['total_applications'] ?? 47 }}</div>
                        <div class="card-change {{ ($analytics['applications_change'] ?? 12) >= 0 ? 'positive' : 'negative' }}">
                            {{ ($analytics['applications_change'] ?? 12) >= 0 ? '+' : '' }}{{ $analytics['applications_change'] ?? 12 }}% this month
                        </div>
                    </div>
                </div>
            </div>

            <div class="analytics-card response-rate">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Response Rate</h3>
                        <div class="card-value">{{ $analytics['response_rate'] ?? 68 }}%</div>
                        <div class="card-change {{ ($analytics['response_rate_change'] ?? 5) >= 0 ? 'positive' : 'negative' }}">
                            {{ ($analytics['response_rate_change'] ?? 5) >= 0 ? '+' : '' }}{{ $analytics['response_rate_change'] ?? 5 }}% this month
                        </div>
                    </div>
                </div>
            </div>

            <div class="analytics-card interview-rate">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Interview Rate</h3>
                        <div class="card-value">{{ $analytics['interview_rate'] ?? 23 }}%</div>
                        <div class="card-change {{ ($analytics['interview_rate_change'] ?? 8) >= 0 ? 'positive' : 'negative' }}">
                            {{ ($analytics['interview_rate_change'] ?? 8) >= 0 ? '+' : '' }}{{ $analytics['interview_rate_change'] ?? 8 }}% this month
                        </div>
                    </div>
                </div>
            </div>

            <div class="analytics-card avg-time">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Avg Response Time</h3>
                        <div class="card-value">{{ $analytics['avg_response_time'] ?? '5.2' }}d</div>
                        <div class="card-change {{ ($analytics['response_time_change'] ?? 0.8) <= 0 ? 'positive' : 'negative' }}">
                            {{ ($analytics['response_time_change'] ?? 0.8) >= 0 ? '+' : '' }}{{ $analytics['response_time_change'] ?? 0.8 }}d this month
                        </div>
                    </div>
                </div>
            </div>

            <!-- Applications Over Time Chart -->
            <div class="analytics-card applications-chart">
                <div class="card-header">
                    <h3 class="card-title">Applications Per Week</h3>
                </div>
                <div class="chart-container">
                    <canvas id="applicationsChart"></canvas>
                </div>
            </div>

            <!-- Conversion Funnel -->
            <div class="analytics-card funnel-chart">
                <div class="card-header">
                    <h3 class="card-title">Conversion Funnel</h3>
                </div>
                <div class="chart-container">
                    <div class="funnel-stage">
                        <span class="funnel-label">Applied</span>
                        <div class="funnel-bar" style="width: 100%;"></div>
                        <span class="funnel-value">{{ $analytics['funnel']['applied'] ?? 47 }}</span>
                    </div>
                    <div class="funnel-stage">
                        <span class="funnel-label">Response</span>
                        <div class="funnel-bar" style="width: {{ $analytics['funnel']['response_percent'] ?? 68 }}%;"></div>
                        <span class="funnel-value">{{ $analytics['funnel']['response'] ?? 32 }}</span>
                    </div>
                    <div class="funnel-stage">
                        <span class="funnel-label">Phone Screen</span>
                        <div class="funnel-bar" style="width: {{ $analytics['funnel']['phone_screen_percent'] ?? 45 }}%;"></div>
                        <span class="funnel-value">{{ $analytics['funnel']['phone_screen'] ?? 21 }}</span>
                    </div>
                    <div class="funnel-stage">
                        <span class="funnel-label">Interview</span>
                        <div class="funnel-bar" style="width: {{ $analytics['funnel']['interview_percent'] ?? 23 }}%;"></div>
                        <span class="funnel-value">{{ $analytics['funnel']['interview'] ?? 11 }}</span>
                    </div>
                    <div class="funnel-stage">
                        <span class="funnel-label">Final Round</span>
                        <div class="funnel-bar" style="width: {{ $analytics['funnel']['final_round_percent'] ?? 15 }}%;"></div>
                        <span class="funnel-value">{{ $analytics['funnel']['final_round'] ?? 7 }}</span>
                    </div>
                    <div class="funnel-stage">
                        <span class="funnel-label">Offer</span>
                        <div class="funnel-bar" style="width: {{ $analytics['funnel']['offer_percent'] ?? 6 }}%;"></div>
                        <span class="funnel-value">{{ $analytics['funnel']['offer'] ?? 3 }}</span>
                    </div>
                </div>
            </div>

            <!-- Application Sources Chart -->
            <div class="analytics-card sources-chart">
                <div class="card-header">
                    <h3 class="card-title">Application Sources</h3>
                </div>
                <div class="chart-container">
                    <canvas id="sourcesChart"></canvas>
                </div>
            </div>

            <!-- AI Insights -->
            <div class="analytics-card ai-insights">
                <div class="ai-header">
                    <div class="ai-icon">AI</div>
                    <h3 class="ai-title">AI Insights</h3>
                </div>
                <div class="ai-content">
                    @if(isset($analytics['insights']) && count($analytics['insights']) > 0)
                        @foreach($analytics['insights'] as $insight)
                        <div class="insight-item">
                            <div class="insight-title">{{ $insight['title'] }}</div>
                            <div class="insight-text">{!! $insight['description'] !!}</div>
                        </div>
                        @endforeach
                    @else
                    <div class="insight-item">
                        <div class="insight-title">Peak Application Time</div>
                        <div class="insight-text">
                            Your applications sent on <span class="insight-metric">Tuesday mornings</span> have a 
                            <span class="insight-metric">34% higher response rate</span> than other times.
                        </div>
                    </div>
                    
                    <div class="insight-item">
                        <div class="insight-title">Industry Focus</div>
                        <div class="insight-text">
                            <span class="insight-metric">SaaS companies</span> respond to your applications 
                            <span class="insight-metric">2.3x faster</span> than traditional enterprises.
                        </div>
                    </div>
                    
                    <div class="insight-item">
                        <div class="insight-title">Application Length</div>
                        <div class="insight-text">
                            Cover letters with <span class="insight-metric">150-200 words</span> show 
                            <span class="insight-metric">28% better conversion</span> to phone screens.
                        </div>
                    </div>
                    
                    <div class="insight-item">
                        <div class="insight-title">Follow-up Strategy</div>
                        <div class="insight-text">
                            Following up after <span class="insight-metric">7 days</span> increases your 
                            interview rate by <span class="insight-metric">41%</span>.
                        </div>
                    </div>
                    
                    <div class="insight-item">
                        <div class="insight-title">Salary Negotiation</div>
                        <div class="insight-text">
                            Your current offer average is <span class="insight-metric">${{ $analytics['avg_salary'] ?? '145k' }}</span>, which is 
                            <span class="insight-metric">{{ $analytics['salary_comparison'] ?? '18% above market rate' }}</span> for your experience level.
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Chart.js default configuration
        Chart.defaults.font.family = 'Inter';
        Chart.defaults.font.size = 12;
        Chart.defaults.color = '#6b7c6d';

        // Applications Per Week Line Chart
        const applicationsCtx = document.getElementById('applicationsChart').getContext('2d');
        const applicationsChart = new Chart(applicationsCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($analytics['chart_labels'] ?? ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7', 'Week 8']) !!},
                datasets: [{
                    label: 'Applications',
                    data: {!! json_encode($analytics['chart_data'] ?? [3, 7, 5, 8, 6, 9, 4, 5]) !!},
                    borderColor: '#ff6b6b',
                    backgroundColor: 'rgba(255, 107, 107, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ff6b6b',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            font: {
                                weight: 600
                            }
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(107, 124, 109, 0.1)',
                            borderDash: [5, 5]
                        },
                        border: {
                            display: false
                        },
                        beginAtZero: true,
                        ticks: {
                            font: {
                                weight: 600
                            }
                        }
                    }
                },
                elements: {
                    point: {
                        hoverBackgroundColor: '#ff5252'
                    }
                }
            }
        });

        // Application Sources Donut Chart
        const sourcesCtx = document.getElementById('sourcesChart').getContext('2d');
        const sourcesChart = new Chart(sourcesCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($analytics['sources']['labels'] ?? ['LinkedIn', 'Company Sites', 'Referrals', 'Job Boards', 'Recruiters']) !!},
                datasets: [{
                    data: {!! json_encode($analytics['sources']['data'] ?? [35, 25, 15, 15, 10]) !!},
                    backgroundColor: [
                        '#ff6b6b',
                        '#f0e5e0',
                        '#e8f2e8',
                        '#6b7c6d',
                        '#2d3e2e'
                    ],
                    borderWidth: 0,
                    cutout: '70%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 15,
                            font: {
                                size: 11,
                                weight: 600
                            }
                        }
                    }
                }
            }
        });

        // Time range selector
        function setTimeRange(range) {
            // Remove active class from all buttons
            document.querySelectorAll('.time-selector').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Add active class to clicked button
            event.target.classList.add('active');
            
            // Update charts with new data (simulate)
            updateChartsData(range);
        }

        function updateChartsData(range) {
            // Simulate data updates based on time range
            const newData = {
                '7d': [2, 3, 1, 4, 2, 3, 2],
                '30d': [3, 7, 5, 8, 6, 9, 4, 5],
                '90d': [8, 12, 15, 11, 18, 14, 16, 19, 13, 17, 21, 15],
                '1y': [25, 32, 28, 35, 30, 38, 33, 41, 37, 44, 39, 47]
            };
            
            // Update applications chart
            applicationsChart.data.datasets[0].data = newData[range] || newData['30d'];
            applicationsChart.update('active');
            
            // Add loading animation
            document.querySelectorAll('.analytics-card').forEach(card => {
                card.classList.add('loading-shimmer');
                setTimeout(() => {
                    card.classList.remove('loading-shimmer');
                }, 800);
            });
        }

        // Initialize animations on load
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.analytics-card');
            
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s cubic-bezier(0.23, 1, 0.32, 1)';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });

        // Refresh data periodically
        setInterval(() => {
            // Simulate real-time updates
            const insights = document.querySelectorAll('.insight-item');
            if (insights.length > 0) {
                const randomInsight = insights[Math.floor(Math.random() * insights.length)];
                randomInsight.style.background = 'rgba(255, 107, 107, 0.1)';
                setTimeout(() => {
                    randomInsight.style.background = 'rgba(255, 255, 255, 0.4)';
                }, 1000);
            }
        }, 10000);
    </script>
</body>
</html>