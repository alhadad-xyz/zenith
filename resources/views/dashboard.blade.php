<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Zenith - Job Application Tracker</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
            position: relative;
        }

        .header {
            margin-bottom: 3rem;
            text-align: center;
        }

        .logo {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2d3e2e;
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            font-size: 1.1rem;
            color: #6b7c6d;
            font-weight: 500;
        }

        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-template-rows: repeat(8, 120px);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .card {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            cursor: pointer;
        }

        .card::before {
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

        .card:hover::before {
            opacity: 1;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 32px 64px rgba(45, 62, 46, 0.15);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .progress-ring {
            grid-column: 5 / 9;
            grid-row: 2 / 6;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(240, 229, 224, 0.4) 0%, rgba(232, 242, 232, 0.4) 100%);
        }

        .ring-container {
            position: relative;
            width: 180px;
            height: 180px;
            margin-bottom: 1.5rem;
        }

        .ring {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            position: relative;
            background: conic-gradient(from 0deg, #ff6b6b 0deg, #ff6b6b 252deg, rgba(255, 255, 255, 0.2) 252deg);
            animation: glow 3s ease-in-out infinite alternate;
        }

        .ring::before {
            content: '';
            position: absolute;
            top: 8px;
            left: 8px;
            right: 8px;
            bottom: 8px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            backdrop-filter: blur(10px);
        }

        .ring-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 10;
        }

        .ring-percentage {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2d3e2e;
            line-height: 1;
        }

        .ring-label {
            font-size: 0.9rem;
            color: #6b7c6d;
            font-weight: 500;
            margin-top: 0.25rem;
        }

        @keyframes glow {
            from { filter: drop-shadow(0 0 20px rgba(255, 107, 107, 0.3)); }
            to { filter: drop-shadow(0 0 40px rgba(255, 107, 107, 0.6)); }
        }

        .ai-insight {
            font-size: 1rem;
            color: #2d3e2e;
            text-align: center;
            font-weight: 500;
            opacity: 0.8;
        }

        .stage-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .applied {
            grid-column: 1 / 5;
            grid-row: 1 / 4;
            background: linear-gradient(135deg, rgba(240, 229, 224, 0.3) 0%, rgba(240, 229, 224, 0.6) 100%);
        }

        .interviewing {
            grid-column: 9 / 13;
            grid-row: 1 / 4;
            background: linear-gradient(135deg, rgba(232, 242, 232, 0.3) 0%, rgba(232, 242, 232, 0.6) 100%);
        }

        .offer {
            grid-column: 1 / 5;
            grid-row: 6 / 8;
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.1) 0%, rgba(255, 107, 107, 0.2) 100%);
        }

        .stage-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .stage-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3e2e;
            letter-spacing: -0.02em;
            margin-bottom: 1em;
        }

        .stage-count {
            background: rgba(255, 255, 255, 0.8);
            color: #2d3e2e;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .stage-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .stage-description {
            color: #6b7c6d;
            font-size: 1rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .stage-metric {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3e2e;
            margin-bottom: 0.25rem;
        }

        .stage-label {
            font-size: 0.85rem;
            color: #6b7c6d;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 600;
        }

        .quick-stats {
            grid-column: 9 / 13;
            grid-row: 6 / 8;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0.6) 100%);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            height: 100%;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2d3e2e;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.75rem;
            color: #6b7c6d;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 600;
        }

        .recent-activity {
            grid-column: 5 / 9;
            grid-row: 6 / 8;
            background: linear-gradient(135deg, rgba(240, 229, 224, 0.2) 0%, rgba(232, 242, 232, 0.2) 100%);
        }

        .activity-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
            padding: 0.5rem;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .activity-item:hover {
            background: rgba(255, 255, 255, 0.5);
            transform: translateX(4px);
        }

        .activity-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #ff6b6b;
            margin-right: 0.75rem;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .activity-text {
            font-size: 0.9rem;
            color: #2d3e2e;
            font-weight: 500;
        }

        .insights-panel {
            grid-column: 1 / 13;
            grid-row: 8 / 9;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.4) 100%);
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: default !important;
            pointer-events: auto;
        }

        .insights-panel:hover {
            transform: none !important;
        }

        .insight-text {
            font-size: 1.1rem;
            color: #2d3e2e;
            font-weight: 600;
            flex: 1;
        }

        .cta-button {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 0 8px 32px rgba(255, 107, 107, 0.3);
            letter-spacing: -0.01em;
            position: relative;
            z-index: 10;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 48px rgba(255, 107, 107, 0.4);
            background: linear-gradient(135deg, #ff5252 0%, #ff4444 100%);
        }

        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: float 20s ease-in-out infinite;
        }

        .floating-circle:nth-child(1) {
            width: 300px;
            height: 300px;
            top: 10%;
            left: 80%;
            animation-delay: 0s;
        }

        .floating-circle:nth-child(2) {
            width: 200px;
            height: 200px;
            top: 60%;
            left: 5%;
            animation-delay: -10s;
        }

        .floating-circle:nth-child(3) {
            width: 150px;
            height: 150px;
            top: 30%;
            left: 20%;
            animation-delay: -5s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-20px) rotate(90deg); }
            50% { transform: translateY(-40px) rotate(180deg); }
            75% { transform: translateY(-20px) rotate(270deg); }
        }

        .task-panel {
            grid-column: 1 / 5;
            grid-row: 4 / 6;
            background: linear-gradient(135deg, rgba(232, 242, 232, 0.3) 0%, rgba(255, 255, 255, 0.4) 100%);
        }

        .task-list {
            margin-top: 1rem;
        }

        .task-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .task-item:hover {
            background: rgba(255, 255, 255, 0.6);
            transform: translateY(-2px);
        }

        .task-checkbox {
            width: 16px;
            height: 16px;
            border: 2px solid #6b7c6d;
            border-radius: 4px;
            margin-right: 0.75rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .task-checkbox.checked {
            background: #ff6b6b;
            border-color: #ff6b6b;
        }

        .task-text {
            font-size: 0.9rem;
            color: #2d3e2e;
            font-weight: 500;
        }

        .timeline-panel {
            grid-column: 9 / 13;
            grid-row: 4 / 6;
            background: linear-gradient(135deg, rgba(240, 229, 224, 0.3) 0%, rgba(255, 255, 255, 0.4) 100%);
        }

        .timeline-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            position: relative;
        }

        .timeline-date {
            font-size: 0.8rem;
            color: #6b7c6d;
            font-weight: 600;
            min-width: 60px;
        }

        .timeline-content {
            margin-left: 1rem;
            padding-left: 1rem;
            border-left: 2px solid rgba(255, 107, 107, 0.3);
        }

        .timeline-title {
            font-size: 0.9rem;
            color: #2d3e2e;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .timeline-company {
            font-size: 0.8rem;
            color: #6b7c6d;
        }

        @media (max-width: 1400px) {
            .container {
                padding: 1.5rem;
            }
            
            .bento-grid {
                grid-template-columns: repeat(10, 1fr);
                gap: 1.2rem;
            }
            
            .progress-ring {
                grid-column: 4 / 8;
                grid-row: 2 / 5;
            }
            
            .applied {
                grid-column: 1 / 4;
                grid-row: 1 / 3;
            }
            
            .interviewing {
                grid-column: 8 / 11;
                grid-row: 1 / 3;
            }
            
            .task-panel {
                grid-column: 1 / 4;
                grid-row: 3 / 5;
            }
            
            .timeline-panel {
                grid-column: 8 / 11;
                grid-row: 3 / 5;
            }
        }

        @media (max-width: 1200px) {
            .navbar {
                padding: 1.2rem 1.5rem;
                margin: 0 0.5rem;
            }
            
            .brand {
                font-size: 1.8rem;
            }
            
            .container {
                padding: 1rem;
            }
            
            .bento-grid {
                grid-template-columns: repeat(8, 1fr);
                grid-template-rows: repeat(10, 100px);
                gap: 1rem;
            }
            
            .progress-ring {
                grid-column: 3 / 7;
                grid-row: 2 / 5;
            }
            
            .applied {
                grid-column: 1 / 5;
                grid-row: 1 / 3;
            }
            
            .interviewing {
                grid-column: 5 / 9;
                grid-row: 1 / 3;
            }
            
            .task-panel {
                grid-column: 1 / 3;
                grid-row: 5 / 8;
            }
            
            .timeline-panel {
                grid-column: 7 / 9;
                grid-row: 5 / 8;
            }
            
            .offer {
                grid-column: 1 / 4;
                grid-row: 8 / 10;
            }
            
            .recent-activity {
                grid-column: 3 / 7;
                grid-row: 5 / 7;
            }
            
            .quick-stats {
                grid-column: 5 / 9;
                grid-row: 8 / 10;
            }
            
            .insights-panel {
                grid-column: 1 / 9;
                grid-row: 10 / 11;
            }
        }

        @media (max-width: 968px) {
            .navbar {
                padding: 1rem;
                margin: 0;
                border-radius: 0;
            }
            
            .user-menu {
                gap: 1rem;
            }
            
            .user-name {
                font-size: 0.85rem;
            }
            
            .logout-btn {
                padding: 0.6rem 1.2rem;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 0.8rem 1rem;
            }
            
            .brand {
                font-size: 1.5rem;
            }
            
            .container {
                padding: 0.5rem;
            }
            
            .header {
                margin-bottom: 2rem;
            }
            
            .logo {
                font-size: 2rem;
            }
            
            .subtitle {
                font-size: 1rem;
            }
            
            .bento-grid {
                grid-template-columns: 1fr;
                grid-template-rows: auto;
                gap: 1rem;
            }
            
            .card {
                padding: 1.5rem;
            }
            
            .progress-ring,
            .applied,
            .interviewing,
            .offer,
            .quick-stats,
            .recent-activity,
            .task-panel,
            .timeline-panel,
            .insights-panel {
                grid-column: 1;
                grid-row: auto;
                min-height: 200px;
            }
            
            .progress-ring {
                min-height: 300px;
            }
            
            .ring-container {
                width: 150px;
                height: 150px;
            }
            
            .ring-percentage {
                font-size: 2rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
            
            .insights-panel {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
            }
            
            .cta-button {
                width: 100%;
                padding: 1.2rem;
            }
        }

        @media (max-width: 480px) {
            .navbar {
                padding: 0.6rem 0.8rem;
            }
            
            .brand {
                font-size: 1.3rem;
            }
            
            .logout-btn {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }
            
            .card {
                padding: 1rem;
            }
            
            .stage-title {
                font-size: 1.2rem;
            }
            
            .stage-metric {
                font-size: 1.5rem;
            }
            
            .ring-container {
                width: 120px;
                height: 120px;
            }
            
            .ring-percentage {
                font-size: 1.6rem;
            }
            
            .stat-number {
                font-size: 1.4rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="floating-elements">
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
    </div>

    <nav class="navbar">
        <div class="brand">Zenith</div>
        <div class="user-menu">
            <span class="user-name">Welcome, {{ auth()->user()->name }}!</span>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <header class="header">
            <h1 class="logo">Zenith</h1>
            <p class="subtitle">Your mindful career progression companion</p>
        </header>

        <div class="bento-grid">
            <!-- Applied Stage -->
            <div class="card stage-card applied" onclick="window.location.href='{{ route('applications.index', ['filter' => 'applied']) }}'">
                <div class="stage-header">
                    <h2 class="stage-title">Applied</h2>
                    <span class="stage-count" id="appliedCount">{{ $stats['applied'] ?? 0 }}</span>
                </div>
                <div class="stage-content">
                    <div class="stage-metric" id="appliedMetric">{{ $stats['applied'] ?? 0 }}</div>
                    <div class="stage-label">Applications Sent</div>
                    <p class="stage-description">Your applications are working their way through the pipeline</p>
                </div>
            </div>

            <!-- Interviewing Stage -->
            <div class="card stage-card interviewing" onclick="window.location.href='{{ route('applications.index', ['filter' => 'interviewing']) }}'">
                <div class="stage-header">
                    <h2 class="stage-title">Interviewing</h2>
                    <span class="stage-count">{{ $stats['interviewing'] ?? 0 }}</span>
                </div>
                <div class="stage-content">
                    <div class="stage-metric">{{ $stats['interviewing'] ?? 0 }}</div>
                    <div class="stage-label">In Progress</div>
                    <p class="stage-description">Conversations are happening—you're making progress</p>
                </div>
            </div>

            <!-- Progress Ring -->
            <div class="card progress-ring">
                <div class="ring-container">
                    <div class="ring">
                        <div class="ring-content">
                            <div class="ring-percentage">70%</div>
                            <div class="ring-label">Progress</div>
                        </div>
                    </div>
                </div>
                <div class="ai-insight">AI suggests focusing on follow-ups this week</div>
            </div>

            <!-- Task Panel -->
            <div class="card task-panel">
                <h3 class="stage-title">Today's Focus</h3>
                <div class="task-list">
                    <div class="task-item">
                        <div class="task-checkbox"></div>
                        <span class="task-text">Follow up with Stripe</span>
                    </div>
                    <div class="task-item">
                        <div class="task-checkbox checked"></div>
                        <span class="task-text">Prepare for Meta interview</span>
                    </div>
                    <div class="task-item">
                        <div class="task-checkbox"></div>
                        <span class="task-text">Update portfolio</span>
                    </div>
                </div>
            </div>

            <!-- Timeline Panel -->
            <div class="card timeline-panel">
                <h3 class="stage-title">Upcoming</h3>
                <div class="timeline-item">
                    <div class="timeline-date">Jul 22</div>
                    <div class="timeline-content">
                        <div class="timeline-title">Technical Interview</div>
                        <div class="timeline-company">Figma</div>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-date">Jul 24</div>
                    <div class="timeline-content">
                        <div class="timeline-title">Final Round</div>
                        <div class="timeline-company">Notion</div>
                    </div>
                </div>
            </div>

            <!-- Offer Stage -->
            <div class="card stage-card offer" onclick="window.location.href='{{ route('applications.index', ['filter' => 'offer']) }}'">
                <div class="stage-header">
                    <h2 class="stage-title">Offers</h2>
                    <span class="stage-count">{{ $stats['offers'] ?? 0 }}</span>
                </div>
                <div class="stage-content">
                    <div class="stage-metric">{{ $stats['offers'] ?? 0 }}</div>
                    <div class="stage-label">Pending Decision</div>
                    <p class="stage-description">Congratulations! You have choices to make</p>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card recent-activity">
                <h3 class="stage-title">Activity</h3>
                <div class="activity-item">
                    <div class="activity-dot"></div>
                    <span class="activity-text">Interview scheduled with Airbnb</span>
                </div>
                <div class="activity-item">
                    <div class="activity-dot"></div>
                    <span class="activity-text">Application viewed by Linear</span>
                </div>
                <div class="activity-item">
                    <div class="activity-dot"></div>
                    <span class="activity-text">Offer received from Vercel</span>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card quick-stats">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number">89%</div>
                        <div class="stat-label">Response Rate</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">12</div>
                        <div class="stat-label">Days Avg</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">$145k</div>
                        <div class="stat-label">Avg Offer</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">4.8</div>
                        <div class="stat-label">Match Score</div>
                    </div>
                </div>
            </div>

            <!-- Insights Panel -->
            <div class="card insights-panel">
                <div class="insight-text">
                    Your application velocity is 23% above average. Consider expanding your search to include Series B startups.
                </div>
                <button class="cta-button" onclick="event.stopPropagation(); openApplicationModal();" id="addApplicationBtn">Add Application</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ring = document.querySelector('.ring');
            let progress = 0;
            const targetProgress = 70;
            
            const animateProgress = () => {
                if (progress < targetProgress) {
                    progress += 1;
                    const degrees = (progress / 100) * 360;
                    ring.style.background = `conic-gradient(from 0deg, #ff6b6b 0deg, #ff6b6b ${degrees}deg, rgba(255, 255, 255, 0.2) ${degrees}deg)`;
                    requestAnimationFrame(animateProgress);
                }
            };
            
            setTimeout(animateProgress, 500);

            const checkboxes = document.querySelectorAll('.task-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('click', function() {
                    this.classList.toggle('checked');
                });
            });

            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                // Skip hover effects for insights-panel to prevent button interference
                if (card.classList.contains('insights-panel')) {
                    return;
                }
                
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            const activityItems = document.querySelectorAll('.activity-item');
            let currentIndex = 0;
            
            setInterval(() => {
                activityItems.forEach((item, index) => {
                    const dot = item.querySelector('.activity-dot');
                    if (index === currentIndex) {
                        dot.style.animation = 'pulse 1s ease-in-out infinite';
                        dot.style.background = '#ff6b6b';
                    } else {
                        dot.style.animation = 'none';
                        dot.style.background = 'rgba(107, 124, 109, 0.3)';
                    }
                });
                currentIndex = (currentIndex + 1) % activityItems.length;
            }, 3000);

            const floatingElements = document.querySelectorAll('.floating-circle');
            document.addEventListener('mousemove', (e) => {
                const x = e.clientX / window.innerWidth;
                const y = e.clientY / window.innerHeight;
                
                floatingElements.forEach((element, index) => {
                    const speed = (index + 1) * 0.5;
                    const xPos = (x - 0.5) * speed * 20;
                    const yPos = (y - 0.5) * speed * 20;
                    element.style.transform = `translate(${xPos}px, ${yPos}px)`;
                });
            });
        });

        function addNewApplication() {
            const appliedCard = document.getElementById('appliedCount');
            const appliedMetric = document.getElementById('appliedMetric');
            const currentCount = parseInt(appliedCard.textContent);
            
            appliedCard.style.transform = 'scale(1.2)';
            appliedCard.style.background = '#ff6b6b';
            appliedCard.style.color = 'white';
            
            setTimeout(() => {
                appliedCard.textContent = currentCount + 1;
                appliedCard.style.transform = 'scale(1)';
                appliedCard.style.background = 'rgba(255, 255, 255, 0.8)';
                appliedCard.style.color = '#2d3e2e';
                
                appliedMetric.textContent = currentCount + 1;
            }, 300);
        }

        function openApplicationModal() {
            console.log('Opening application modal...');
            const modal = document.getElementById('applicationModal');
            console.log('Modal element:', modal);
            if (modal) {
                modal.style.display = 'flex';
                console.log('Modal display set to flex');
                // Initialize modal state when opening
                currentStep = 1;
                updateProgressBar();
                updateStepIndicators();
                updateButtons();
            } else {
                console.error('Modal not found!');
            }
        }
    </script>

    <!-- Application Modal -->
    <div id="applicationModal" class="application-modal-overlay" style="display: none;">
        <div class="application-modal">
            <!-- Progress Bar -->
            <div class="progress-container">
                <div class="progress-bar" id="progressBar"></div>
            </div>

            <!-- Modal Header -->
            <div class="modal-header">
                <button class="close-button" onclick="closeApplicationModal()">×</button>
                <h2 class="modal-title">New Application</h2>
                <p class="modal-subtitle">Let's add another opportunity to your journey</p>
                <div class="step-indicator">
                    <div class="step-dot active" id="dot1"></div>
                    <div class="step-dot" id="dot2"></div>
                    <div class="step-dot" id="dot3"></div>
                </div>
            </div>

            <!-- Modal Body -->
            <form id="applicationForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Step 1: Company & Role -->
                    <div class="step active" id="step1">
                        <h3 class="step-title">Company & Role</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Company Name</label>
                                <input type="text" class="form-input" placeholder="e.g. Stripe, Figma, Linear" name="company_name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Job Title</label>
                                <input type="text" class="form-input" placeholder="e.g. Senior Product Designer" name="job_title" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Department</label>
                                <select class="form-select" name="department">
                                    <option value="">Select department</option>
                                    <option value="design">Design</option>
                                    <option value="engineering">Engineering</option>
                                    <option value="product">Product</option>
                                    <option value="marketing">Marketing</option>
                                    <option value="sales">Sales</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Employment Type</label>
                                <select class="form-select" name="employment_type">
                                    <option value="">Select type</option>
                                    <option value="full-time">Full-time</option>
                                    <option value="part-time">Part-time</option>
                                    <option value="contract">Contract</option>
                                    <option value="internship">Internship</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Job Details & URL -->
                    <div class="step" id="step2">
                        <h3 class="step-title">Job Details & URL</h3>
                        <div class="form-group">
                            <label class="form-label">Job Posting URL</label>
                            <input type="url" class="form-input" placeholder="https://jobs.company.com/role" name="job_url">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Location</label>
                            <input type="text" class="form-input" placeholder="San Francisco, CA or Remote" name="location">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Salary Range (Optional)</label>
                            <div class="salary-group">
                                <input type="text" class="form-input" placeholder="$120,000" name="salary_min">
                                <input type="text" class="form-input" placeholder="$180,000" name="salary_max">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Job Description</label>
                            <textarea class="form-textarea" placeholder="Paste the job description here..." name="job_description"></textarea>
                        </div>
                    </div>

                    <!-- Step 3: Resume & Notes -->
                    <div class="step" id="step3">
                        <h3 class="step-title">Resume & Notes</h3>
                        <div class="form-group">
                            <label class="form-label">Resume</label>
                            <label class="file-upload" id="resumeUpload">
                                <input type="file" accept=".pdf,.doc,.docx" name="resume" id="resumeFile">
                                <div class="file-upload-icon">📄</div>
                                <div class="file-upload-text">Choose resume file or drag & drop</div>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Cover Letter (Optional)</label>
                            <label class="file-upload" id="coverLetterUpload">
                                <input type="file" accept=".pdf,.doc,.docx" name="cover_letter" id="coverLetterFile">
                                <div class="file-upload-icon">📝</div>
                                <div class="file-upload-text">Choose cover letter or drag & drop</div>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Application Notes</label>
                            <textarea class="form-textarea" placeholder="Add any notes about this application, referrals, or next steps..." name="application_notes"></textarea>
                        </div>
                    </div>

                    <!-- Success Step -->
                    <div class="step" id="successStep">
                        <div class="success-step">
                            <div class="success-icon">✓</div>
                            <h3 class="success-title">Application Added!</h3>
                            <p class="success-description">Your application has been successfully added to your tracker. We'll keep you updated on its progress.</p>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="prevBtn" onclick="previousStep()" disabled>Previous</button>
                    <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextStep()">Next</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Application Modal Styles */
        .application-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(45, 62, 46, 0.1);
            backdrop-filter: blur(12px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            animation: fadeIn 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                backdrop-filter: blur(0px);
            }
            to {
                opacity: 1;
                backdrop-filter: blur(12px);
            }
        }

        .application-modal {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 32px;
            width: 100%;
            max-width: 600px;
            max-height: 90vh;
            min-height: 500px;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 
                0 32px 64px rgba(45, 62, 46, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);
            animation: modalSlideIn 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(40px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .progress-container {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #ff6b6b 0%, #ff5252 100%);
            width: 33.33%;
            transition: width 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 0 0 20px rgba(255, 107, 107, 0.4);
        }

        .modal-header {
            padding: 3rem 3rem 1rem 3rem;
            text-align: center;
            position: relative;
            flex-shrink: 0;
        }

        .close-button {
            position: absolute;
            top: 2rem;
            right: 2rem;
            width: 44px;
            height: 44px;
            border: none;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            color: #6b7c6d;
            font-size: 1.2rem;
            backdrop-filter: blur(10px);
        }

        .close-button:hover {
            background: rgba(255, 255, 255, 0.8);
            transform: scale(1.05);
            color: #2d3e2e;
        }

        .modal-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2d3e2e;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
        }

        .modal-subtitle {
            font-size: 1.1rem;
            color: #6b7c6d;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .step-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .step-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(107, 124, 109, 0.3);
            transition: all 0.3s ease;
        }

        .step-dot.active {
            background: #ff6b6b;
            transform: scale(1.5);
            box-shadow: 0 0 12px rgba(255, 107, 107, 0.4);
        }

        .step-dot.completed {
            background: #6b7c6d;
        }

        .modal-body {
            padding: 2rem 3rem;
            min-height: 300px;
            flex: 1;
            overflow-y: auto;
            max-height: calc(90vh - 300px);
        }

        .step {
            display: none;
            animation: stepFadeIn 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .step.active {
            display: block;
        }

        @keyframes stepFadeIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .step-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2d3e2e;
            letter-spacing: -0.02em;
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .form-label {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2d3e2e;
            margin-bottom: 0.75rem;
            display: block;
            letter-spacing: -0.01em;
        }

        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: 1.25rem 1.5rem;
            border: 2px solid rgba(255, 255, 255, 0.6);
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            font-size: 1rem;
            font-weight: 500;
            color: #2d3e2e;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            font-family: 'Inter', sans-serif;
        }

        .form-input:focus, .form-textarea:focus, .form-select:focus {
            outline: none;
            border-color: #ff6b6b;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 0 4px rgba(255, 107, 107, 0.1);
            transform: translateY(-2px);
        }

        .form-input::placeholder, .form-textarea::placeholder {
            color: #6b7c6d;
            font-weight: 400;
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .salary-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .file-upload {
            position: relative;
            display: block;
            width: 100%;
            padding: 2rem;
            border: 2px dashed rgba(107, 124, 109, 0.3);
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.4);
            text-align: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .file-upload:hover {
            border-color: #ff6b6b;
            background: rgba(255, 255, 255, 0.6);
            transform: translateY(-2px);
        }

        .file-upload input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-upload-icon {
            font-size: 2rem;
            color: #6b7c6d;
            margin-bottom: 0.5rem;
        }

        .file-upload-text {
            font-size: 1rem;
            color: #6b7c6d;
            font-weight: 500;
        }

        .file-upload.has-file {
            border-color: #ff6b6b;
            background: rgba(255, 107, 107, 0.1);
        }

        .file-upload.has-file .file-upload-text {
            color: #ff6b6b;
            font-weight: 600;
        }

        .modal-footer {
            padding: 2rem 3rem 3rem 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
        }

        .btn {
            padding: 1rem 2rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            border: none;
            font-family: 'Inter', sans-serif;
            letter-spacing: -0.01em;
            min-width: 120px;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.6);
            color: #6b7c6d;
            backdrop-filter: blur(10px);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.8);
            color: #2d3e2e;
            transform: translateY(-2px);
        }

        .btn-secondary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
            color: white;
            box-shadow: 0 8px 32px rgba(255, 107, 107, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 48px rgba(255, 107, 107, 0.4);
            background: linear-gradient(135deg, #ff5252 0%, #ff4444 100%);
        }

        .success-step {
            text-align: center;
            padding: 3rem 0;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            color: white;
            font-size: 2rem;
            animation: successPulse 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        }

        @keyframes successPulse {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .success-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3e2e;
            margin-bottom: 1rem;
        }

        .success-description {
            font-size: 1.1rem;
            color: #6b7c6d;
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .application-modal {
                margin: 1rem;
                max-width: none;
                border-radius: 24px;
            }

            .modal-header,
            .modal-body,
            .modal-footer {
                padding-left: 2rem;
                padding-right: 2rem;
            }

            .modal-title {
                font-size: 2rem;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .salary-group {
                grid-template-columns: 1fr;
            }

            .modal-footer {
                flex-direction: column;
                gap: 1rem;
            }

            .btn {
                width: 100%;
            }
        }

        /* Custom Scrollbar */
        .modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: rgba(255, 107, 107, 0.4);
            border-radius: 3px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 107, 107, 0.6);
        }
    </style>

    <script>
        let currentStep = 1;
        const totalSteps = 3;

        function updateProgressBar() {
            const progressBar = document.getElementById('progressBar');
            const percentage = (currentStep / totalSteps) * 100;
            progressBar.style.width = percentage + '%';
        }

        function updateStepIndicators() {
            for (let i = 1; i <= totalSteps; i++) {
                const dot = document.getElementById(`dot${i}`);
                const step = document.getElementById(`step${i}`);
                
                if (i < currentStep) {
                    dot.className = 'step-dot completed';
                    step.classList.remove('active');
                } else if (i === currentStep) {
                    dot.className = 'step-dot active';
                    step.classList.add('active');
                } else {
                    dot.className = 'step-dot';
                    step.classList.remove('active');
                }
            }
        }

        function updateButtons() {
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            prevBtn.disabled = currentStep === 1;
            
            if (currentStep === totalSteps) {
                nextBtn.textContent = 'Save Application';
                nextBtn.classList.add('btn-save');
            } else {
                nextBtn.textContent = 'Next';
                nextBtn.classList.remove('btn-save');
            }
        }

        function nextStep() {
            if (currentStep < totalSteps) {
                currentStep++;
                updateProgressBar();
                updateStepIndicators();
                updateButtons();
            } else {
                saveApplication();
            }
        }

        function previousStep() {
            if (currentStep > 1) {
                currentStep--;
                updateProgressBar();
                updateStepIndicators();
                updateButtons();
            }
        }

        function saveApplication() {
            const form = document.getElementById('applicationForm');
            const formData = new FormData(form);

            // Show loading state
            const nextBtn = document.getElementById('nextBtn');
            nextBtn.textContent = 'Saving...';
            nextBtn.disabled = true;

            fetch('{{ route("applications.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success step
                    document.querySelectorAll('.step').forEach(step => {
                        step.classList.remove('active');
                    });
                    document.getElementById('successStep').classList.add('active');
                    
                    // Hide footer
                    document.querySelector('.modal-footer').style.display = 'none';
                    
                    // Update progress to 100%
                    document.getElementById('progressBar').style.width = '100%';
                    
                    // Update dashboard statistics
                    addNewApplication();
                    
                    // Auto close after 2 seconds
                    setTimeout(() => {
                        closeApplicationModal();
                    }, 2000);
                } else {
                    alert('Error saving application. Please try again.');
                    nextBtn.textContent = 'Save Application';
                    nextBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving application. Please try again.');
                nextBtn.textContent = 'Save Application';
                nextBtn.disabled = false;
            });
        }

        function closeApplicationModal() {
            const modal = document.getElementById('applicationModal');
            modal.style.display = 'none';
            
            // Reset modal state
            currentStep = 1;
            updateProgressBar();
            updateStepIndicators();
            updateButtons();
            
            // Reset form
            document.getElementById('applicationForm').reset();
            
            // Show footer again
            document.querySelector('.modal-footer').style.display = 'flex';
            
            // Reset file uploads
            document.querySelectorAll('.file-upload').forEach(upload => {
                upload.classList.remove('has-file');
                upload.querySelector('.file-upload-text').textContent = upload.id === 'resumeUpload' ? 'Choose resume file or drag & drop' : 'Choose cover letter or drag & drop';
            });
        }

        // File upload handling
        function setupFileUpload(inputId, uploadId) {
            const fileInput = document.getElementById(inputId);
            const uploadArea = document.getElementById(uploadId);
            
            fileInput.addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    const fileName = e.target.files[0].name;
                    uploadArea.classList.add('has-file');
                    uploadArea.querySelector('.file-upload-text').textContent = fileName;
                } else {
                    uploadArea.classList.remove('has-file');
                    uploadArea.querySelector('.file-upload-text').textContent = uploadId === 'resumeUpload' ? 'Choose resume file or drag & drop' : 'Choose cover letter or drag & drop';
                }
            });

            // Drag and drop functionality
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadArea.style.borderColor = '#ff6b6b';
                uploadArea.style.background = 'rgba(255, 107, 107, 0.1)';
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                uploadArea.style.borderColor = 'rgba(107, 124, 109, 0.3)';
                uploadArea.style.background = 'rgba(255, 255, 255, 0.4)';
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    const event = new Event('change', { bubbles: true });
                    fileInput.dispatchEvent(event);
                }
                uploadArea.style.borderColor = 'rgba(107, 124, 109, 0.3)';
                uploadArea.style.background = 'rgba(255, 255, 255, 0.4)';
            });
        }

        // Initialize file uploads
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, setting up modal...');
            
            // Check if modal exists
            const modal = document.getElementById('applicationModal');
            console.log('Modal found:', modal);
            
            // Add event listener to button as backup
            const addBtn = document.getElementById('addApplicationBtn');
            console.log('Add button found:', addBtn);
            
            if (addBtn) {
                addBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation(); // Prevent card from capturing the event
                    console.log('Button clicked via event listener');
                    openApplicationModal();
                });
            }
            
            if (modal) {
                setupFileUpload('resumeFile', 'resumeUpload');
                setupFileUpload('coverLetterFile', 'coverLetterUpload');
                
                // Initialize modal state
                updateProgressBar();
                updateStepIndicators();
                updateButtons();
                
                console.log('Modal setup complete');
            } else {
                console.error('Modal not found during initialization');
            }
        });

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('applicationModal');
            if (modal.style.display === 'flex') {
                if (e.key === 'Enter' && e.ctrlKey) {
                    nextStep();
                } else if (e.key === 'Escape') {
                    closeApplicationModal();
                }
            }
        });
    </script>
</body>
</html>