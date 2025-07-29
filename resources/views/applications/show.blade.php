<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Zenith - {{ $application->job_title }} at {{ $application->company_name }}</title>
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
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            padding: 3rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.6);
            color: #6b7c6d;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 2rem;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            backdrop-filter: blur(10px);
        }

        .back-button:hover {
            background: rgba(255, 255, 255, 0.8);
            color: #2d3e2e;
            transform: translateY(-2px);
        }

        .header-main {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 2rem;
        }

        .header-info {
            flex: 1;
        }

        .company-name {
            font-size: 3rem;
            font-weight: 800;
            color: #2d3e2e;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
        }

        .job-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #6b7c6d;
            margin-bottom: 1rem;
        }

        .header-meta {
            display: flex;
            gap: 2rem;
            margin-top: 1.5rem;
        }

        .meta-item {
            display: flex;
            flex-direction: column;
        }

        .meta-label {
            font-size: 0.8rem;
            color: #6b7c6d;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .meta-value {
            font-size: 1rem;
            font-weight: 600;
            color: #2d3e2e;
        }

        .status-badge {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            text-align: center;
            min-width: 180px;
            box-shadow: 0 8px 32px rgba(255, 107, 107, 0.3);
            animation: statusPulse 3s ease-in-out infinite;
        }

        .status-badge.applied {
            background: linear-gradient(135deg, #f0e5e0 0%, #e8ccc0 100%);
            color: #8b4513;
            box-shadow: 0 8px 32px rgba(139, 69, 19, 0.2);
        }

        .status-badge.interviewing {
            background: linear-gradient(135deg, #e8f2e8 0%, #c8e6c9 100%);
            color: #2e7d32;
            box-shadow: 0 8px 32px rgba(46, 125, 50, 0.2);
        }

        .status-badge.offer {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
            color: white;
            box-shadow: 0 8px 32px rgba(255, 107, 107, 0.3);
        }

        .status-badge.rejected {
            background: linear-gradient(135deg, #888 0%, #666 100%);
            color: white;
            box-shadow: 0 8px 32px rgba(136, 136, 136, 0.3);
        }

        .status-badge.withdrawn {
            background: linear-gradient(135deg, #888 0%, #666 100%);
            color: white;
            box-shadow: 0 8px 32px rgba(136, 136, 136, 0.3);
        }

        @keyframes statusPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }

        /* Main Content */
        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        /* Timeline Column */
        .timeline-column {
            position: relative;
        }

        .timeline-header {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2d3e2e;
            margin-bottom: 2rem;
            letter-spacing: -0.02em;
        }

        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 1rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(180deg, #ff6b6b 0%, rgba(255, 107, 107, 0.3) 100%);
        }

        .timeline-event {
            position: relative;
            margin-bottom: 2rem;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 2rem;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            cursor: pointer;
        }

        .timeline-event::before {
            content: '';
            position: absolute;
            left: -2.5rem;
            top: 2rem;
            width: 12px;
            height: 12px;
            background: #ff6b6b;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 0 4px rgba(255, 107, 107, 0.2);
        }

        .timeline-event:hover {
            transform: translateX(8px) translateY(-4px);
            box-shadow: 0 16px 48px rgba(45, 62, 46, 0.15);
            background: rgba(255, 255, 255, 0.6);
        }

        .timeline-event.completed::before {
            background: #6b7c6d;
            box-shadow: 0 0 0 4px rgba(107, 124, 109, 0.2);
        }

        .timeline-event.active::before {
            background: #ff6b6b;
            animation: eventPulse 2s ease-in-out infinite;
        }

        .timeline-event.upcoming::before {
            background: rgba(107, 124, 109, 0.3);
            box-shadow: 0 0 0 4px rgba(107, 124, 109, 0.1);
        }

        @keyframes eventPulse {
            0%, 100% { 
                box-shadow: 0 0 0 4px rgba(255, 107, 107, 0.2);
                transform: scale(1);
            }
            50% { 
                box-shadow: 0 0 0 8px rgba(255, 107, 107, 0.4);
                transform: scale(1.1);
            }
        }

        .event-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .event-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2d3e2e;
            letter-spacing: -0.01em;
        }

        .event-date {
            font-size: 0.9rem;
            color: #6b7c6d;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.6);
            padding: 0.5rem 1rem;
            border-radius: 50px;
        }

        .event-description {
            color: #6b7c6d;
            font-size: 1rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .event-details {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .event-tag {
            background: rgba(255, 255, 255, 0.7);
            color: #2d3e2e;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .event-notes {
            margin-top: 1rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 12px;
            font-size: 0.9rem;
            color: #6b7c6d;
            font-style: italic;
        }

        /* Details Column */
        .details-column {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .detail-card {
            background: rgba(255, 255, 255, 0.4);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 16px;
            padding: 2rem;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .detail-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(45, 62, 46, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .card-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #2d3e2e;
            margin-bottom: 1.5rem;
            letter-spacing: -0.01em;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: 0.8rem;
            color: #6b7c6d;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .detail-value {
            font-size: 1rem;
            font-weight: 600;
            color: #2d3e2e;
        }

        .document-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 12px;
            margin-bottom: 1rem;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .document-item:hover {
            background: rgba(255, 255, 255, 0.7);
            transform: translateY(-2px);
        }

        .document-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #e8f2e8 0%, #c8e6c9 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .document-info {
            flex: 1;
        }

        .document-name {
            font-size: 1rem;
            font-weight: 600;
            color: #2d3e2e;
            margin-bottom: 0.25rem;
        }

        .document-size {
            font-size: 0.8rem;
            color: #6b7c6d;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
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
            flex: 1;
            text-decoration: none;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
            color: white;
            box-shadow: 0 8px 32px rgba(255, 107, 107, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 48px rgba(255, 107, 107, 0.4);
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

        /* Responsive Design */
        @media (max-width: 1024px) {
            .main-content {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .header-main {
                flex-direction: column;
                gap: 2rem;
            }

            .status-badge {
                align-self: flex-start;
            }

            .header-meta {
                flex-wrap: wrap;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .header {
                padding: 2rem;
            }

            .company-name {
                font-size: 2rem;
            }

            .job-title {
                font-size: 1.2rem;
            }

            .timeline {
                padding-left: 1.5rem;
            }

            .timeline-event {
                padding: 1.5rem;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }
        }

        /* Floating Background Elements */
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
            background: radial-gradient(circle, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
            animation: float 25s ease-in-out infinite;
        }

        .floating-circle:nth-child(1) {
            width: 400px;
            height: 400px;
            top: 20%;
            left: 75%;
            animation-delay: 0s;
        }

        .floating-circle:nth-child(2) {
            width: 300px;
            height: 300px;
            top: 60%;
            left: 10%;
            animation-delay: -8s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-30px) rotate(90deg); }
            50% { transform: translateY(-60px) rotate(180deg); }
            75% { transform: translateY(-30px) rotate(270deg); }
        }
    </style>
</head>
<body>
    <div class="floating-elements">
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
    </div>

    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <a href="{{ route('applications.index') }}" class="back-button">
                    ← Back to Applications
                </a>
                
                <div class="header-main">
                    <div class="header-info">
                        <h1 class="company-name">{{ $application->company_name }}</h1>
                        <h2 class="job-title">{{ $application->job_title }}</h2>
                        
                        <div class="header-meta">
                            <div class="meta-item">
                                <span class="meta-label">Applied</span>
                                <span class="meta-value">{{ $application->created_at->format('M j, Y') }}</span>
                            </div>
                            @if($application->location)
                            <div class="meta-item">
                                <span class="meta-label">Location</span>
                                <span class="meta-value">{{ $application->location }}</span>
                            </div>
                            @endif
                            @if($application->salary_min || $application->salary_max)
                            <div class="meta-item">
                                <span class="meta-label">Salary</span>
                                <span class="meta-value">
                                    @if($application->salary_min && $application->salary_max)
                                        {{ $application->salary_min }} - {{ $application->salary_max }}
                                    @elseif($application->salary_min)
                                        From {{ $application->salary_min }}
                                    @else
                                        Up to {{ $application->salary_max }}
                                    @endif
                                </span>
                            </div>
                            @endif
                            @if($application->employment_type)
                            <div class="meta-item">
                                <span class="meta-label">Type</span>
                                <span class="meta-value">{{ ucfirst($application->employment_type) }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="status-badge {{ $application->status }}">
                        {{ ucfirst($application->status) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Timeline Column -->
            <div class="timeline-column">
                <h3 class="timeline-header">Application Timeline</h3>
                
                <div class="timeline">
                    <div class="timeline-event completed">
                        <div class="event-header">
                            <h4 class="event-title">Application Submitted</h4>
                            <span class="event-date">{{ $application->created_at->format('M j') }}</span>
                        </div>
                        <p class="event-description">
                            @if($application->job_url)
                                Applied through <a href="{{ $application->job_url }}" target="_blank" style="color: #2d3e2e; text-decoration: underline;">company portal</a>
                            @else
                                Application submitted successfully
                            @endif
                        </p>
                        <div class="event-details">
                            <span class="event-tag">{{ ucfirst($application->employment_type ?? 'Application') }}</span>
                            @if($application->resume_path)
                                <span class="event-tag">Resume Attached</span>
                            @endif
                            @if($application->cover_letter_path)
                                <span class="event-tag">Cover Letter</span>
                            @endif
                        </div>
                        @if($application->application_notes)
                        <div class="event-notes">
                            {{ $application->application_notes }}
                        </div>
                        @endif
                    </div>

                    @if($application->status === 'interviewing')
                    <div class="timeline-event active">
                        <div class="event-header">
                            <h4 class="event-title">Interview Process</h4>
                            <span class="event-date">In Progress</span>
                        </div>
                        <p class="event-description">
                            Currently in the interview process with {{ $application->company_name }}
                        </p>
                        <div class="event-details">
                            <span class="event-tag">Active</span>
                            <span class="event-tag">Interviewing</span>
                        </div>
                    </div>
                    @endif

                    @if($application->status === 'offer')
                    <div class="timeline-event completed">
                        <div class="event-header">
                            <h4 class="event-title">Offer Received</h4>
                            <span class="event-date">Recent</span>
                        </div>
                        <p class="event-description">
                            Congratulations! You've received an offer from {{ $application->company_name }}
                        </p>
                        <div class="event-details">
                            <span class="event-tag">Offer</span>
                            <span class="event-tag">Success</span>
                        </div>
                    </div>
                    @endif

                    @if(in_array($application->status, ['applied', 'interviewing']))
                    <div class="timeline-event upcoming">
                        <div class="event-header">
                            <h4 class="event-title">Next Steps</h4>
                            <span class="event-date">Pending</span>
                        </div>
                        <p class="event-description">
                            @if($application->status === 'applied')
                                Waiting for response from {{ $application->company_name }}
                            @else
                                Continue with interview process
                            @endif
                        </p>
                        <div class="event-details">
                            <span class="event-tag">Pending</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Details Column -->
            <div class="details-column">
                <!-- Job Details Card -->
                <div class="detail-card">
                    <h3 class="card-title">Job Details</h3>
                    <div class="detail-grid">
                        @if($application->department)
                        <div class="detail-item">
                            <span class="detail-label">Department</span>
                            <span class="detail-value">{{ $application->department }}</span>
                        </div>
                        @endif
                        @if($application->employment_type)
                        <div class="detail-item">
                            <span class="detail-label">Employment Type</span>
                            <span class="detail-value">{{ ucfirst($application->employment_type) }}</span>
                        </div>
                        @endif
                        <div class="detail-item">
                            <span class="detail-label">Status</span>
                            <span class="detail-value">{{ ucfirst($application->status) }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Applied Date</span>
                            <span class="detail-value">{{ $application->created_at->format('M j, Y') }}</span>
                        </div>
                    </div>
                    
                    @if($application->job_description)
                    <div style="margin-top: 1.5rem;">
                        <span class="detail-label">Job Description</span>
                        <div style="margin-top: 0.5rem; padding: 1rem; background: rgba(255, 255, 255, 0.3); border-radius: 12px; line-height: 1.6;">
                            {{ Str::limit($application->job_description, 300) }}
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Documents Card -->
                @if($application->resume_path || $application->cover_letter_path)
                <div class="detail-card">
                    <h3 class="card-title">Attached Documents</h3>
                    
                    @if($application->resume_path)
                    <div class="document-item" onclick="openDocument('{{ Storage::url($application->resume_path) }}')">
                        <div class="document-icon">📄</div>
                        <div class="document-info">
                            <div class="document-name">Resume.pdf</div>
                            <div class="document-size">
                                @php
                                    try {
                                        $size = Storage::size('public/' . $application->resume_path);
                                        echo number_format($size / 1024, 0) . ' KB';
                                    } catch (Exception $e) {
                                        echo 'File size unavailable';
                                    }
                                @endphp
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($application->cover_letter_path)
                    <div class="document-item" onclick="openDocument('{{ Storage::url($application->cover_letter_path) }}')">
                        <div class="document-icon">📝</div>
                        <div class="document-info">
                            <div class="document-name">Cover Letter.pdf</div>
                            <div class="document-size">
                                @php
                                    try {
                                        $size = Storage::size('public/' . $application->cover_letter_path);
                                        echo number_format($size / 1024, 0) . ' KB';
                                    } catch (Exception $e) {
                                        echo 'File size unavailable';
                                    }
                                @endphp
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($application->job_url)
                    <div class="document-item" onclick="openDocument('{{ $application->job_url }}')">
                        <div class="document-icon">🔗</div>
                        <div class="document-info">
                            <div class="document-name">Job Posting</div>
                            <div class="document-size">External Link</div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Actions -->
                <div class="action-buttons">
                    <a href="{{ route('applications.index') }}" class="btn btn-secondary">
                        Back to Applications
                    </a>
                    <button class="btn btn-primary" onclick="updateStatus()">
                        Update Status
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function expandEvent(eventElement) {
            // Toggle expanded state
            const isExpanded = eventElement.classList.contains('expanded');
            
            // Remove expanded class from all events
            document.querySelectorAll('.timeline-event').forEach(event => {
                event.classList.remove('expanded');
            });
            
            if (!isExpanded) {
                eventElement.classList.add('expanded');
                eventElement.style.transform = 'translateX(12px) translateY(-8px) scale(1.02)';
                eventElement.style.boxShadow = '0 24px 64px rgba(45, 62, 46, 0.2)';
            } else {
                eventElement.style.transform = '';
                eventElement.style.boxShadow = '';
            }
        }

        function openDocument(url) {
            window.open(url, '_blank');
            
            // Add visual feedback
            event.currentTarget.style.transform = 'scale(0.98)';
            setTimeout(() => {
                event.currentTarget.style.transform = '';
            }, 150);
        }

        function updateStatus() {
            // Simple status update - could be enhanced with a modal
            const currentStatus = '{{ $application->status }}';
            const statuses = ['applied', 'interviewing', 'offer', 'rejected', 'withdrawn'];
            const currentIndex = statuses.indexOf(currentStatus);
            const nextStatus = statuses[(currentIndex + 1) % statuses.length];
            
            if (confirm(`Update status from "${currentStatus}" to "${nextStatus}"?`)) {
                // Make AJAX request to update status
                fetch(`/applications/{{ $application->id }}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        status: nextStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to update status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating status');
                });
            }
        }

        // Add smooth scrolling and parallax effects
        document.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelectorAll('.floating-circle');
            
            parallax.forEach((element, index) => {
                const speed = (index + 1) * 0.2;
                element.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });

        // Animate elements on load
        document.addEventListener('DOMContentLoaded', function() {
            const timelineEvents = document.querySelectorAll('.timeline-event');
            const detailCards = document.querySelectorAll('.detail-card');
            
            // Stagger timeline animation
            timelineEvents.forEach((event, index) => {
                event.style.opacity = '0';
                event.style.transform = 'translateX(-30px)';
                
                setTimeout(() => {
                    event.style.transition = 'all 0.6s cubic-bezier(0.23, 1, 0.32, 1)';
                    event.style.opacity = '1';
                    event.style.transform = 'translateX(0)';
                }, index * 150);
            });
            
            // Stagger detail cards animation
            detailCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s cubic-bezier(0.23, 1, 0.32, 1)';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, (index * 100) + 300);
            });
        });

        // Status badge click handler
        document.querySelector('.status-badge').addEventListener('click', function() {
            this.style.animation = 'statusPulse 0.6s ease-in-out';
            setTimeout(() => {
                this.style.animation = 'statusPulse 3s ease-in-out infinite';
            }, 600);
        });

        // Timeline event hover effects
        document.querySelectorAll('.timeline-event').forEach(event => {
            event.addEventListener('mouseenter', function() {
                if (this.classList.contains('active')) {
                    this.style.background = 'rgba(255, 107, 107, 0.1)';
                }
            });
            
            event.addEventListener('mouseleave', function() {
                this.style.background = '';
            });
        });

        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'u' && e.ctrlKey) {
                e.preventDefault();
                updateStatus();
            } else if (e.key === 'Escape') {
                window.location.href = '{{ route("applications.index") }}';
            }
        });
    </script>
</body>
</html>