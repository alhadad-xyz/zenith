<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Zenith - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
            color: #2d3e2e;
        }

        .navbar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            font-size: 1.5rem;
            font-weight: 800;
            color: #2d3e2e;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-name {
            font-weight: 600;
        }

        .logout-btn {
            padding: 0.5rem 1rem;
            background: #ff6b6b;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.2s ease;
        }

        .logout-btn:hover {
            background: #ff5252;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .welcome-section {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            text-align: center;
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: #2d3e2e;
        }

        .welcome-text {
            font-size: 1.2rem;
            color: #6b7c6d;
            margin-bottom: 2rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #ff6b6b, #ff5252);
            border-radius: 12px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .feature-description {
            color: #6b7c6d;
            line-height: 1.6;
        }
    </style>
</head>
<body>
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
        <div class="welcome-section">
            <h1 class="welcome-title">Welcome to Zenith Dashboard</h1>
            <p class="welcome-text">Your journey to career success starts here. Explore our features and take control of your professional growth.</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3 class="feature-title">Analytics</h3>
                <p class="feature-description">Track your progress with detailed analytics and insights into your career development journey.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🎯</div>
                <h3 class="feature-title">Goal Setting</h3>
                <p class="feature-description">Set and achieve meaningful career goals with our structured approach to professional growth.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📚</div>
                <h3 class="feature-title">Learning Resources</h3>
                <p class="feature-description">Access curated learning materials and resources to enhance your skills and knowledge.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🤝</div>
                <h3 class="feature-title">Networking</h3>
                <p class="feature-description">Connect with like-minded professionals and expand your network for career opportunities.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">💼</div>
                <h3 class="feature-title">Job Opportunities</h3>
                <p class="feature-description">Discover tailored job opportunities that match your skills and career aspirations.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📈</div>
                <h3 class="feature-title">Performance Tracking</h3>
                <p class="feature-description">Monitor your career performance and get actionable insights for continuous improvement.</p>
            </div>
        </div>
    </div>
</body>
</html>