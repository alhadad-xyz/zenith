<x-layout title="Zenith - All Applications">
    <x-slot name="styles">
        <style>
            /* Application index specific styles */
            .container {
                max-width: 1200px;
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

        .sort-controls, .sort-buttons {
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
            background: #2d3e2e;
            transform: translateY(-2px);
            color: white;
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
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 2rem;
            padding: 2em;
        }

        .application-card:hover {
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

        /* Status tags are now handled by common CSS */

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
            
            .sort-label {
                font-size: 0.85rem;
                margin-bottom: 0.5rem;
            }
            
            .sort-buttons {
                display: flex;
                gap: 0.5rem;
                flex-wrap: wrap;
                justify-content: center;
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
    </x-slot>

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
                    <div class="sort-buttons">
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
                <x-application-card :application="$application" />
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
            window.location.href = `/applications/${applicationId}`;
        }

        // Add loading animation to cards and initialize sort arrows
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.application-card');
            
            // Animate cards on load
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s cubic-bezier(0.23, 1, 0.32, 1)';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
            
            // Initialize sort arrows based on current URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const currentSort = urlParams.get('sort') || 'date';
            const currentDirection = urlParams.get('direction') || 'desc';
            
            // Update sort button arrows
            document.querySelectorAll('.sort-btn').forEach(btn => {
                const arrow = btn.querySelector('.sort-arrow');
                if (btn.href.includes(`sort=${currentSort}`)) {
                    if (currentDirection === 'desc') {
                        btn.classList.add('desc');
                        arrow.textContent = '↓';
                    } else {
                        btn.classList.remove('desc');
                        arrow.textContent = '↑';
                    }
                }
            });
            
            // Add smooth transitions for filter buttons
            document.querySelectorAll('.filter-btn, .sort-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    // Add a subtle animation feedback
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 100);
                });
            });
            
            // Add keyboard navigation
            document.addEventListener('keydown', function(e) {
                // Allow quick navigation with number keys
                if (e.altKey) {
                    switch(e.key) {
                        case '1':
                            e.preventDefault();
                            window.location.href = '{{ route("applications.index") }}';
                            break;
                        case '2':
                            e.preventDefault();
                            window.location.href = '{{ route("applications.index", ["filter" => "applied"]) }}';
                            break;
                        case '3':
                            e.preventDefault();
                            window.location.href = '{{ route("applications.index", ["filter" => "interviewing"]) }}';
                            break;
                        case '4':
                            e.preventDefault();
                            window.location.href = '{{ route("applications.index", ["filter" => "offer"]) }}';
                            break;
                        case '5':
                            e.preventDefault();
                            window.location.href = '{{ route("applications.index", ["filter" => "rejected"]) }}';
                            break;
                    }
                }
            });
            
            // Add touch feedback for mobile
            if ('ontouchstart' in window) {
                document.querySelectorAll('.application-card').forEach(card => {
                    card.addEventListener('touchstart', function() {
                        this.style.transform = 'scale(0.98)';
                    });
                    
                    card.addEventListener('touchend', function() {
                        setTimeout(() => {
                            this.style.transform = '';
                        }, 100);
                    });
                });
            }
            
            // Initialize performance observer for smooth scrolling
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }
                    });
                }, {
                    threshold: 0.1,
                    rootMargin: '50px'
                });

                cards.forEach(card => {
                    observer.observe(card);
                });
            }
        });
    </script>

    <x-slot name="scripts">
        <script>
            function showApplicationDetails(applicationId) {
                window.location.href = `/applications/${applicationId}`;
            }
        </script>
    </x-slot>
</x-layout>