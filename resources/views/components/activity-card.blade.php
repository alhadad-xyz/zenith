@props(['activities' => []])

<div class="card recent-activity">
    <div class="stage-header">
        <h3 class="stage-title">Recent Activity</h3>
        <div class="activity-controls">
            <button class="activity-filter" data-filter="all" onclick="filterActivities('all')">All</button>
            <button class="activity-filter" data-filter="today" onclick="filterActivities('today')">Today</button>
            <button class="activity-filter active" data-filter="week" onclick="filterActivities('week')">Week</button>
        </div>
    </div>
    
    <div class="activity-list" id="activityList">
        @forelse($activities as $activity)
            <div class="activity-item" 
                 data-type="{{ $activity['type'] ?? 'default' }}" 
                 data-date="{{ $activity['date'] ?? now()->format('Y-m-d') }}"
                 data-priority="{{ $activity['priority'] ?? 'normal' }}">
                <div class="activity-indicator">
                    <div class="activity-dot {{ $activity['type'] ?? 'default' }}"></div>
                    @if(isset($activity['type']))
                        <div class="activity-icon">
                            @switch($activity['type'])
                                @case('interview')
                                    🎯
                                    @break
                                @case('application')
                                    📝
                                    @break
                                @case('offer')
                                    🎉
                                    @break
                                @case('followup')
                                    📞
                                    @break
                                @case('rejection')
                                    📋
                                    @break
                                @case('task')
                                    ✅
                                    @break
                                @default
                                    📌
                            @endswitch
                        </div>
                    @endif
                </div>
                
                <div class="activity-content">
                    <div class="activity-text">{{ $activity['text'] ?? $activity['description'] ?? 'Activity logged' }}</div>
                    <div class="activity-meta">
                        @if(isset($activity['company']))
                            <span class="activity-company">{{ $activity['company'] }}</span>
                        @endif
                        @if(isset($activity['time']))
                            <span class="activity-time">{{ $activity['time'] }}</span>
                        @else
                            <span class="activity-time">{{ $activity['created_at'] ?? 'Just now' }}</span>
                        @endif
                    </div>
                </div>
                
                @if(isset($activity['priority']) && $activity['priority'] === 'high')
                    <div class="activity-priority">
                        <span class="priority-badge">!</span>
                    </div>
                @endif
            </div>
        @empty
            <div class="empty-activity" id="emptyActivity">
                <div class="empty-icon">📊</div>
                <p class="empty-text">No recent activity</p>
                <small class="empty-subtext">Your application activities will appear here</small>
            </div>
        @endforelse
    </div>
    
    <div class="activity-footer">
        <button class="view-all-btn" onclick="window.location.href='{{ route('applications.index') }}'">
            View All Activities
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m9 18 6-6-6-6"/>
            </svg>
        </button>
    </div>
</div>

<style>
.stage-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.activity-controls {
    display: flex;
    gap: 0.5rem;
}

.activity-filter {
    background: rgba(255, 255, 255, 0.4);
    border: 1px solid rgba(107, 124, 109, 0.3);
    border-radius: 6px;
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    color: #6b7c6d;
    cursor: pointer;
    transition: all 0.2s ease;
}

.activity-filter.active,
.activity-filter:hover {
    background: #ff6b6b;
    border-color: #ff6b6b;
    color: white;
}

.activity-list {
    max-height: 280px;
    overflow-y: auto;
    padding-right: 0.5rem;
}

.activity-list::-webkit-scrollbar {
    width: 4px;
}

.activity-list::-webkit-scrollbar-track {
    background: rgba(107, 124, 109, 0.1);
    border-radius: 2px;
}

.activity-list::-webkit-scrollbar-thumb {
    background: rgba(255, 107, 107, 0.3);
    border-radius: 2px;
}

.activity-list::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 107, 107, 0.5);
}

.activity-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 0.75rem;
    padding: 0.75rem;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 12px;
    transition: all 0.2s ease;
    position: relative;
    cursor: pointer;
}

.activity-item:hover {
    background: rgba(255, 255, 255, 0.5);
    transform: translateX(4px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.activity-item.hidden {
    display: none;
}

.activity-indicator {
    position: relative;
    margin-right: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.activity-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    animation: pulse 2s ease-in-out infinite;
    position: relative;
    z-index: 1;
}

.activity-dot.default {
    background: #6b7c6d;
}

.activity-dot.interview {
    background: #ff6b6b;
}

.activity-dot.application {
    background: #4CAF50;
}

.activity-dot.offer {
    background: #FFD700;
}

.activity-dot.followup {
    background: #2196F3;
}

.activity-dot.rejection {
    background: #9E9E9E;
}

.activity-dot.task {
    background: #4CAF50;
}

.activity-icon {
    position: absolute;
    top: -8px;
    right: -8px;
    font-size: 0.7rem;
    background: white;
    border-radius: 50%;
    width: 16px;
    height: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

@keyframes pulse {
    0%, 100% { 
        opacity: 1; 
        transform: scale(1);
    }
    50% { 
        opacity: 0.7; 
        transform: scale(1.1);
    }
}

.activity-content {
    flex: 1;
    min-width: 0;
}

.activity-text {
    font-size: 0.9rem;
    color: #2d3e2e;
    font-weight: 500;
    line-height: 1.3;
    margin-bottom: 0.25rem;
}

.activity-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.activity-company {
    font-size: 0.75rem;
    color: #ff6b6b;
    font-weight: 600;
    background: rgba(255, 107, 107, 0.1);
    padding: 0.1rem 0.4rem;
    border-radius: 4px;
}

.activity-time {
    font-size: 0.7rem;
    color: #6b7c6d;
    font-weight: 500;
}

.activity-priority {
    margin-left: 0.5rem;
}

.priority-badge {
    background: #ff4444;
    color: white;
    border-radius: 50%;
    width: 16px;
    height: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: bold;
}

.empty-activity {
    text-align: center;
    padding: 2rem 1rem;
    color: #6b7c6d;
}

.empty-icon {
    font-size: 2rem;
    margin-bottom: 1rem;
    opacity: 0.6;
}

.empty-text {
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.empty-subtext {
    font-size: 0.75rem;
    opacity: 0.7;
    font-style: italic;
}

.activity-footer {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(107, 124, 109, 0.2);
}

.view-all-btn {
    width: 100%;
    background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(255, 107, 107, 0.2));
    border: 1px solid rgba(255, 107, 107, 0.3);
    border-radius: 8px;
    padding: 0.75rem 1rem;
    color: #ff6b6b;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.view-all-btn:hover {
    background: linear-gradient(135deg, rgba(255, 107, 107, 0.2), rgba(255, 107, 107, 0.3));
    border-color: #ff6b6b;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 107, 107, 0.2);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .activity-controls {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .activity-filter {
        text-align: center;
    }
    
    .stage-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }
}
</style>

<script>
function filterActivities(filter) {
    const activities = document.querySelectorAll('.activity-item');
    const filters = document.querySelectorAll('.activity-filter');
    const today = new Date().toISOString().split('T')[0];
    const weekAgo = new Date();
    weekAgo.setDate(weekAgo.getDate() - 7);
    const weekAgoStr = weekAgo.toISOString().split('T')[0];
    
    // Update active filter
    filters.forEach(btn => btn.classList.remove('active'));
    document.querySelector(`[data-filter="${filter}"]`).classList.add('active');
    
    activities.forEach(activity => {
        const activityDate = activity.dataset.date;
        let shouldShow = true;
        
        switch(filter) {
            case 'today':
                shouldShow = activityDate === today;
                break;
            case 'week':
                shouldShow = activityDate >= weekAgoStr;
                break;
            case 'all':
            default:
                shouldShow = true;
                break;
        }
        
        if (shouldShow) {
            activity.classList.remove('hidden');
            activity.style.display = 'flex';
        } else {
            activity.classList.add('hidden');
            activity.style.display = 'none';
        }
    });
    
    // Check if we need to show empty state
    const visibleActivities = document.querySelectorAll('.activity-item:not(.hidden)');
    const emptyState = document.getElementById('emptyActivity');
    
    if (visibleActivities.length === 0 && !emptyState) {
        const activityList = document.getElementById('activityList');
        activityList.innerHTML += `
            <div class="empty-activity" id="emptyActivity">
                <div class="empty-icon">📊</div>
                <p class="empty-text">No activities for ${filter === 'all' ? 'this period' : filter}</p>
                <small class="empty-subtext">Activities will appear here as you progress</small>
            </div>
        `;
    } else if (visibleActivities.length > 0 && emptyState) {
        emptyState.remove();
    }
}

// Auto-refresh activities periodically
setInterval(() => {
    const activities = document.querySelectorAll('.activity-item');
    let currentIndex = 0;
    
    const animateNext = () => {
        if (currentIndex < activities.length) {
            const activity = activities[currentIndex];
            const dot = activity.querySelector('.activity-dot');
            
            if (dot) {
                dot.style.animation = 'pulse 1s ease-in-out';
                setTimeout(() => {
                    dot.style.animation = 'pulse 2s ease-in-out infinite';
                }, 1000);
            }
            
            currentIndex++;
            setTimeout(animateNext, 500);
        }
    };
    
    animateNext();
}, 10000); // Every 10 seconds

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    filterActivities('week'); // Default to week view
});
</script>