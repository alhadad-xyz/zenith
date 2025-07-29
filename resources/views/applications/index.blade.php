<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Zenith - All Applications</title>
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
            letter-spacing: -0.01em;
            color: #2d3e2e;
            line-height: 1.5;
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
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .nav-link {
            color: #6b7c6d;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: #2d3e2e;
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
            text-decoration: none;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 48px rgba(255, 107, 107, 0.4);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Header */
        .page-header {
            margin-bottom: 3rem;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
        }

        .header-content {
            flex: 1;
        }

        .page-title {
            font-size: 3rem;
            font-weight: 800;
            color: #2d3e2e;
            margin-bottom: 0.5rem;
            letter-spacing: -0.03em;
        }

        .page-subtitle {
            font-size: 1.2rem;
            color: #6b7c6d;
            font-weight: 500;
        }

        .header-stats {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: #2d3e2e;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6b7c6d;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Controls */
        .controls-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .filter-controls {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .filter-group {
            display: flex;
            gap: 0.5rem;
        }

        .filter-btn {
            padding: 0.75rem 1.5rem;
            border: 2px solid rgba(45, 62, 46, 0.1);
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.6);
            color: #6b7c6d;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            font-family: 'Inter', sans-serif;
            backdrop-filter: blur(10px);
            text-decoration: none;
        }

        .filter-btn:hover {
            border-color: rgba(45, 62, 46, 0.2);
            background: rgba(255, 255, 255, 0.8);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(45, 62, 46, 0.1);
        }

        .filter-btn.active {
            border-color: #2d3e2e;
            background: #2d3e2e;
            color: white;
            transform: translateY(-2px);
        }

        .sort-controls {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .sort-label {
            font-size: 0.9rem;
            color: #6b7c6d;
            font-weight: 600;
        }

        .sort-btn {
            padding: 0.75rem 1.25rem;
            border: 2px solid rgba(45, 62, 46, 0.1);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.6);
            color: #6b7c6d;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            font-family: 'Inter', sans-serif;
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .sort-btn:hover,
        .sort-btn.active {
            border-color: #2d3e2e;
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
            color: #2d3e2e;
        }

        .sort-arrow {
            font-size: 0.8rem;
            transition: transform 0.2s ease;
        }

        .sort-btn.desc .sort-arrow {
            transform: rotate(180deg);
        }

        /* Applications List */
        .applications-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .application-card {
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 20px;
            padding: 2rem;
            display: flex;
            align-items: center;
            gap: 2rem;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            cursor: pointer;
            backdrop-filter: blur(20px);
            position: relative;
            overflow: hidden;
        }

        .application-card::before {
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

        .application-card:hover::before {
            opacity: 1;
        }

        .application-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 48px rgba(45, 62, 46, 0.15);
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.8);
        }

        /* Company Logo */
        .company-logo {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 800;
            color: white;
            flex-shrink: 0;
            position: relative;
            z-index: 2;
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
        }

        /* Application Info */
        .application-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            position: relative;
            z-index: 2;
        }

        .position-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #2d3e2e;
            margin-bottom: 0.25rem;
            letter-spacing: -0.01em;
        }

        .company-name {
            font-size: 1rem;
            color: #6b7c6d;
            font-weight: 600;
        }

        .application-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .meta-item {
            font-size: 0.9rem;
            color: #6b7c6d;
            font-weight: 500;
        }

        .meta-separator {
            width: 4px;
            height: 4px;
            background: #6b7c6d;
            border-radius: 50%;
            opacity: 0.4;
        }

        /* Status Tags */
        .status-section {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 0.75rem;
            position: relative;
            z-index: 2;
        }

        .status-tag {
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border: 2px solid transparent;
            transition: all 0.2s ease;
        }

        .status-tag.applied {
            background: rgba(240, 229, 224, 0.8);
            color: #8b4513;
            border-color: rgba(139, 69, 19, 0.2);
        }

        .status-tag.interviewing {
            background: rgba(232, 242, 232, 0.8);
            color: #2e7d32;
            border-color: rgba(46, 125, 50, 0.2);
        }

        .status-tag.offer {
            background: rgba(255, 107, 107, 0.1);
            color: #ff6b6b;
            border-color: rgba(255, 107, 107, 0.2);
        }

        .status-tag.rejected {
            background: rgba(128, 128, 128, 0.1);
            color: #666;
            border-color: rgba(128, 128, 128, 0.2);
        }

        .status-tag.withdrawn {
            background: rgba(128, 128, 128, 0.1);
            color: #666;
            border-color: rgba(128, 128, 128, 0.2);
        }

        .application-date {
            font-size: 0.85rem;
            color: #6b7c6d;
            font-weight: 600;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6b7c6d;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .empty-state p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .container {
                padding: 1.5rem;
            }
            
            .page-title {
                font-size: 2.5rem;
            }
            
            .controls-section {
                flex-direction: column;
                gap: 1.5rem;
                align-items: stretch;
            }
            
            .filter-controls {
                justify-content: center;
                flex-wrap: wrap;
            }
            
            .sort-controls {
                justify-content: center;
                flex-wrap: wrap;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 1rem;
                margin: 0;
                border-radius: 0;
                flex-wrap: wrap;
                gap: 1rem;
            }
            
            .brand {
                font-size: 1.5rem;
            }
            
            .nav-links {
                order: 3;
                width: 100%;
                justify-content: center;
                gap: 1rem;
            }
            
            .container {
                padding: 1rem;
            }
            
            .header-top {
                flex-direction: column;
                gap: 2rem;
                text-align: center;
            }
            
            .header-stats {
                justify-content: center;
                flex-wrap: wrap;
                gap: 1rem;
            }
            
            .stat-item {
                min-width: 80px;
            }
            
            .stat-number {
                font-size: 1.5rem;
            }
            
            .application-card {
                padding: 1.5rem;
                gap: 1.5rem;
                flex-direction: column;
                text-align: center;
            }
            
            .company-logo {
                width: 56px;
                height: 56px;
                font-size: 1.3rem;
                align-self: center;
            }
            
            .status-section {
                align-items: center;
            }
            
            .application-meta {
                justify-content: center;
                flex-wrap: wrap;
            }
            
            .filter-controls {
                gap: 0.5rem;
            }
            
            .filter-btn {
                padding: 0.6rem 1rem;
                font-size: 0.85rem;
                flex: 1;
                text-align: center;
                min-width: 80px;
            }
            
            .filter-group {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
                gap: 0.5rem;
                width: 100%;
            }
            
            .sort-controls {
                flex-direction: column;
                gap: 1rem;
                align-items: center;
            }
            
            .sort-btn {
                padding: 0.6rem 1rem;
                font-size: 0.85rem;
                min-width: 120px;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .navbar {
                padding: 0.8rem;
            }
            
            .brand {
                font-size: 1.3rem;
            }
            
            .nav-links {
                gap: 0.5rem;
            }
            
            .nav-link {
                font-size: 0.9rem;
                padding: 0.5rem;
            }
            
            .user-menu {
                gap: 0.5rem;
            }
            
            .user-name {
                font-size: 0.85rem;
            }
            
            .logout-btn {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }
            
            .page-title {
                font-size: 2rem;
            }
            
            .page-subtitle {
                font-size: 1rem;
            }
            
            .application-card {
                padding: 1rem;
                gap: 1rem;
            }
            
            .position-title {
                font-size: 1.2rem;
            }
            
            .company-name {
                font-size: 0.9rem;
            }
            
            .company-logo {
                width: 48px;
                height: 48px;
                font-size: 1.1rem;
            }
            
            .filter-btn {
                padding: 0.5rem 0.8rem;
                font-size: 0.8rem;
                min-width: 70px;
            }
            
            .filter-group {
                grid-template-columns: repeat(auto-fit, minmax(70px, 1fr));
            }
            
            .sort-btn {
                padding: 0.5rem 0.8rem;
                font-size: 0.8rem;
                min-width: 100px;
            }
            
            .stat-number {
                font-size: 1.3rem;
            }
            
            .stat-label {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="brand">Zenith</div>
        <div class="nav-links">
            <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
            <a href="{{ route('applications.index') }}" class="nav-link active">Applications</a>
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
        <!-- Page Header -->
        <header class="page-header">
            <div class="header-top">
                <div class="header-content">
                    <h1 class="page-title">All Applications</h1>
                    <p class="page-subtitle">Track and manage your job application journey</p>
                </div>
                <div class="header-stats">
                    <div class="stat-item">
                        <div class="stat-number">{{ $stats['total'] }}</div>
                        <div class="stat-label">Total</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $stats['active'] }}</div>  
                        <div class="stat-label">Active</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $stats['offers'] }}</div>
                        <div class="stat-label">Offers</div>
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <div class="controls-section">
                <div class="filter-controls">
                    <div class="filter-group">
                        <a href="{{ route('applications.index') }}" class="filter-btn {{ request('filter') == null ? 'active' : '' }}">All</a>
                        <a href="{{ route('applications.index', ['filter' => 'applied']) }}" class="filter-btn {{ request('filter') == 'applied' ? 'active' : '' }}">Applied</a>
                        <a href="{{ route('applications.index', ['filter' => 'interviewing']) }}" class="filter-btn {{ request('filter') == 'interviewing' ? 'active' : '' }}">Interviewing</a>
                        <a href="{{ route('applications.index', ['filter' => 'offer']) }}" class="filter-btn {{ request('filter') == 'offer' ? 'active' : '' }}">Offers</a>
                        <a href="{{ route('applications.index', ['filter' => 'rejected']) }}" class="filter-btn {{ request('filter') == 'rejected' ? 'active' : '' }}">Rejected</a>
                    </div>
                </div>
                <div class="sort-controls">
                    <span class="sort-label">Sort by:</span>
                    <a href="{{ route('applications.index', array_merge(request()->all(), ['sort' => 'date', 'direction' => request('sort') == 'date' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                       class="sort-btn {{ request('sort') == 'date' || (!request('sort')) ? 'active' : '' }} {{ request('direction') == 'desc' || (!request('direction')) ? 'desc' : '' }}">
                        Date <span class="sort-arrow">↑</span>
                    </a>
                    <a href="{{ route('applications.index', array_merge(request()->all(), ['sort' => 'company', 'direction' => request('sort') == 'company' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                       class="sort-btn {{ request('sort') == 'company' ? 'active' : '' }} {{ request('direction') == 'desc' ? 'desc' : '' }}">
                        Company <span class="sort-arrow">↑</span>
                    </a>
                    <a href="{{ route('applications.index', array_merge(request()->all(), ['sort' => 'status', 'direction' => request('sort') == 'status' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                       class="sort-btn {{ request('sort') == 'status' ? 'active' : '' }} {{ request('direction') == 'desc' ? 'desc' : '' }}">
                        Status <span class="sort-arrow">↑</span>
                    </a>
                </div>
            </div>
            
            <!-- Results Count -->
            <div style="text-align: center; margin-bottom: 1rem; color: #6b7c6d; font-size: 0.9rem; font-weight: 500;">
                Showing {{ $applications->count() }} application{{ $applications->count() != 1 ? 's' : '' }}
                @if(request('filter'))
                    for <strong>{{ ucfirst(request('filter')) }}</strong>
                @endif
            </div>
        </header>

        <!-- Applications List -->
        <main class="applications-list" id="applicationsList">
            @forelse($applications as $application)
                <div class="application-card" onclick="showApplicationDetails({{ $application->id }})">
                    <div class="company-logo">
                        {{ strtoupper(substr($application->company_name, 0, 2)) }}
                    </div>
                    <div class="application-info">
                        <h3 class="position-title">{{ $application->job_title }}</h3>
                        <div class="company-name">{{ $application->company_name }}</div>
                        <div class="application-meta">
                            @if($application->location)
                                <span class="meta-item">{{ $application->location }}</span>
                                <div class="meta-separator"></div>
                            @endif
                            @if($application->employment_type)
                                <span class="meta-item">{{ ucfirst($application->employment_type) }}</span>
                                @if($application->salary_min || $application->salary_max)
                                    <div class="meta-separator"></div>
                                @endif
                            @endif
                            @if($application->salary_min || $application->salary_max)
                                <span class="meta-item">
                                    @if($application->salary_min && $application->salary_max)
                                        {{ $application->salary_min }} - {{ $application->salary_max }}
                                    @elseif($application->salary_min)
                                        From {{ $application->salary_min }}
                                    @else
                                        Up to {{ $application->salary_max }}
                                    @endif
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="status-section">
                        <div class="status-tag {{ $application->status }}">{{ ucfirst($application->status) }}</div>
                        <div class="application-date">{{ $application->created_at->format('M j, Y') }}</div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <h3>No applications found</h3>
                    <p>You haven't added any applications yet, or no applications match your current filter.</p>
                    <a href="{{ route('dashboard') }}" class="filter-btn">Add Your First Application</a>
                </div>
            @endforelse
        </main>
    </div>

    <script>
        function showApplicationDetails(applicationId) {
            // For now, just log the ID. Later can implement modal or detail page
            console.log('Application details for ID:', applicationId);
            // You could redirect to a detail page or open a modal here
            // window.location.href = `/applications/${applicationId}`;
        }

        // Add loading animation to cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.application-card');
            
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s cubic-bezier(0.23, 1, 0.32, 1)';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>