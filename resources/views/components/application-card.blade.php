@props(['application'])

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