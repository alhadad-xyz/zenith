<x-layout title="Zenith - Job Application Tracker">
    <x-slot name="styles">
        <style>
            /* Dashboard specific styles */
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-template-rows: repeat(8, 120px);
            gap: 1.5rem;
            margin-bottom: 2rem;
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

        /* CTA button styling now handled by common CSS */

        .task-panel {
            grid-column: 1 / 5;
            grid-row: 4 / 6;
            background: linear-gradient(135deg, rgba(232, 242, 232, 0.3) 0%, rgba(255, 255, 255, 0.4) 100%);
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
    </x-slot>

    <div class="container">
        <x-page-header 
            title="Zenith" 
            subtitle="Your mindful career progression companion" 
        />

        <div class="bento-grid">
            <!-- Applied Stage -->
            <x-stat-card
                title="Applied"
                :value="$stats['applied'] ?? 0"
                label="Applications Sent"
                :href="route('applications.index', ['filter' => 'applied'])"
                class="applied"
                id="appliedCount"
            >
                <p class="stage-description">Your applications are working their way through the pipeline</p>
            </x-stat-card>

            <!-- Interviewing Stage -->
            <x-stat-card
                title="Interviewing"
                :value="$stats['interviewing'] ?? 0"
                label="In Progress"
                :href="route('applications.index', ['filter' => 'interviewing'])"
                class="interviewing"
            >
                <p class="stage-description">Conversations are happening—you're making progress</p>
            </x-stat-card>

            <!-- Progress Ring -->
            <div class="card progress-ring" onclick="window.location.href='{{ route('analytics') }}'" style="cursor: pointer;">
                <div class="ring-container">
                    <div class="ring">
                        <div class="ring-content">
                            <div class="ring-percentage">{{ $quickStats['progress_percentage'] }}%</div>
                            <div class="ring-label">Progress</div>
                        </div>
                    </div>
                </div>
                <div class="ai-insight">Click to view detailed analytics</div>
            </div>

            <!-- Today's Focus Panel -->
            <x-today-focus-card 
                :tasks="$todayTasks ?? []"
                class="task-panel"
            />

            <!-- Timeline Panel -->
            <div class="card timeline-panel" onclick="window.location.href='{{ route('calendar') }}'">
                <h3 class="stage-title">Upcoming</h3>
                @if($upcomingEvents->count() > 0)
                    @foreach($upcomingEvents as $event)
                        <div class="timeline-item">
                            <div class="timeline-date">{{ $event['date'] }}</div>
                            <div class="timeline-content">
                                <div class="timeline-title">{{ $event['title'] }}</div>
                                <div class="timeline-company">{{ $event['company'] }}</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="text-align: center; padding: 2rem; color: #6b7c6d; font-style: italic;">
                        No upcoming events.<br>
                        <small>Click to view calendar</small>
                    </div>
                @endif
            </div>

            <!-- Offer Stage -->
            <x-stat-card
                title="Offers"
                :value="$stats['offers'] ?? 0"
                label="Pending Decision"
                :href="route('applications.index', ['filter' => 'offer'])"
                class="offer"
            >
                <p class="stage-description">Congratulations! You have choices to make</p>
            </x-stat-card>

            <!-- Recent Activity -->
            <x-activity-card 
                :activities="$recentActivities ?? []"
                class="recent-activity"
            />

            <!-- Quick Stats -->
            <div class="card quick-stats">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number">{{ $quickStats['response_rate'] }}%</div>
                        <div class="stat-label">Response Rate</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $quickStats['avg_response_days'] }}</div>
                        <div class="stat-label">Days Avg</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $quickStats['avg_offer'] }}</div>
                        <div class="stat-label">Avg Offer</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $quickStats['match_score'] }}</div>
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

    <!-- Add Task Modal -->
    <x-add-task-modal :jobApplications="$jobApplications" />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ring = document.querySelector('.ring');
            let progress = 0;
            const targetProgress = {{ $quickStats['progress_percentage'] }};
            
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
                // Skip hover effects for panels with interactive buttons to prevent interference
                if (card.classList.contains('insights-panel') || 
                    card.classList.contains('task-panel') ||
                    card.classList.contains('recent-activity')) {
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

            // Refresh tasks on page load if refreshTasks function exists
            if (typeof refreshTasks === 'function') {
                refreshTasks();
            }
        });

        // Task Modal Functions (moved here to ensure they're available)
        function openTaskModal() {
            console.log('Opening task modal...');
            const modal = document.getElementById('addTaskModal');
            console.log('Modal element found:', modal);
            
            if (modal) {
                modal.style.display = 'flex';
                
                // Focus on the title input
                setTimeout(() => {
                    const titleInput = document.getElementById('taskTitle');
                    if (titleInput) titleInput.focus();
                }, 100);
                
                // Set default due date to today
                const today = new Date();
                const todayString = today.toISOString().slice(0, 16);
                const dueDateInput = document.getElementById('taskDueDate');
                if (dueDateInput) dueDateInput.value = todayString;
            } else {
                console.error('Task modal not found! Make sure the modal component is included.');
                alert('Task modal not found. Please check the page setup.');
            }
        }

        function closeTaskModal() {
            const modal = document.getElementById('addTaskModal');
            if (modal) {
                modal.style.display = 'none';
                
                // Reset form
                const form = document.getElementById('addTaskForm');
                if (form) form.reset();
                clearTaskErrors();
            }
        }

        function clearTaskErrors() {
            document.querySelectorAll('.task-form-error').forEach(error => {
                error.textContent = '';
            });
            document.querySelectorAll('.task-form-input, .task-form-textarea, .task-form-select').forEach(input => {
                input.style.borderColor = 'rgba(107, 124, 109, 0.2)';
            });
        }

        function saveTask() {
            const form = document.getElementById('addTaskForm');
            const saveBtn = document.getElementById('saveTaskBtn');
            
            if (!form || !saveBtn) {
                console.error('Form or save button not found');
                return;
            }
            
            const btnText = saveBtn.querySelector('.task-btn-text');
            const btnLoading = saveBtn.querySelector('.task-btn-loading');
            
            // Clear previous errors
            clearTaskErrors();
            
            // Show loading state
            if (btnText) btnText.style.display = 'none';
            if (btnLoading) btnLoading.style.display = 'flex';
            saveBtn.disabled = true;
            
            const formData = new FormData(form);
            
            fetch('/tasks', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeTaskModal();
                    
                    // Refresh the tasks list
                    if (typeof refreshTasks === 'function') {
                        refreshTasks();
                    }
                    
                    // Show success message
                    showTaskNotification('Task added successfully!', 'success');
                } else {
                    // Show validation errors
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            showTaskFieldError(field, data.errors[field][0]);
                        });
                    } else {
                        showTaskNotification(data.message || 'Failed to add task', 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showTaskNotification('An error occurred while saving the task', 'error');
            })
            .finally(() => {
                // Reset button state
                if (btnText) btnText.style.display = 'flex';
                if (btnLoading) btnLoading.style.display = 'none';
                saveBtn.disabled = false;
            });
        }

        function showTaskFieldError(field, message) {
            const errorElement = document.getElementById(field + 'Error');
            const inputElement = document.getElementById('task' + field.charAt(0).toUpperCase() + field.slice(1));
            
            if (errorElement) {
                errorElement.textContent = message;
            }
            
            if (inputElement) {
                inputElement.style.borderColor = '#ff4444';
            }
        }

        function showTaskNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `task-notification task-notification-${type}`;
            notification.textContent = message;
            
            // Add styles if not already added
            if (!document.querySelector('#taskNotificationStyles')) {
                const styles = document.createElement('style');
                styles.id = 'taskNotificationStyles';
                styles.textContent = `
                    .task-notification {
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        padding: 1rem 1.5rem;
                        border-radius: 8px;
                        color: white;
                        font-weight: 500;
                        z-index: 1001;
                        animation: slideInRight 0.3s ease-out;
                    }
                    .task-notification-success { background: #4CAF50; }
                    .task-notification-error { background: #ff4444; }
                    .task-notification-info { background: #2196F3; }
                    @keyframes slideInRight {
                        from { transform: translateX(100%); opacity: 0; }
                        to { transform: translateX(0); opacity: 1; }
                    }
                `;
                document.head.appendChild(styles);
            }
            
            document.body.appendChild(notification);
            
            // Remove notification after 3 seconds
            setTimeout(() => {
                notification.style.animation = 'slideInRight 0.3s ease-out reverse';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        function setQuickTask(category) {
            const titleInput = document.getElementById('taskTitle');
            const categorySelect = document.getElementById('taskCategory');
            const prioritySelect = document.getElementById('taskPriority');
            
            if (categorySelect) categorySelect.value = category;
            
            const quickTasks = {
                'followup': {
                    title: 'Follow up on application status',
                    priority: 'high'
                },
                'research': {
                    title: 'Research company culture and values',
                    priority: 'normal'
                },
                'interview': {
                    title: 'Prepare for upcoming interview',
                    priority: 'high'
                },
                'application': {
                    title: 'Update application materials',
                    priority: 'normal'
                }
            };
            
            if (quickTasks[category]) {
                if (titleInput && !titleInput.value.trim()) {
                    titleInput.value = quickTasks[category].title;
                }
                if (prioritySelect) prioritySelect.value = quickTasks[category].priority;
            }
            
            if (titleInput) titleInput.focus();
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeTaskModal();
            }
        });

        // Close modal on overlay click
        document.addEventListener('click', function(e) {
            if (e.target.id === 'addTaskModal') {
                closeTaskModal();
            }
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
    <div id="applicationModal" class="modal-overlay" style="display: none;">
        <div class="modal">
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
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Interview Date (Optional)</label>
                                <input type="datetime-local" class="form-input" name="interview_date">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Application Deadline (Optional)</label>
                                <input type="datetime-local" class="form-input" name="application_deadline">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Interview Type (Optional)</label>
                                <select class="form-select" name="interview_type">
                                    <option value="">Select type</option>
                                    <option value="phone">Phone Screen</option>
                                    <option value="video">Video Call</option>
                                    <option value="in-person">In-Person</option>
                                    <option value="technical">Technical</option>
                                    <option value="final">Final Round</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Follow-up Date (Optional)</label>
                                <input type="datetime-local" class="form-input" name="follow_up_date">
                            </div>
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

    <x-slot name="scripts">
        <script>
            // Dashboard specific JavaScript can go here
            function addNewApplication() {
                const appliedCard = document.getElementById('appliedCount');
                const appliedMetric = appliedCard.querySelector('.stage-metric');
                const currentCount = parseInt(appliedCard.querySelector('.stage-count').textContent);
                
                appliedCard.querySelector('.stage-count').style.transform = 'scale(1.2)';
                appliedCard.querySelector('.stage-count').style.background = '#ff6b6b';
                appliedCard.querySelector('.stage-count').style.color = 'white';
                
                setTimeout(() => {
                    appliedCard.querySelector('.stage-count').textContent = currentCount + 1;
                    appliedCard.querySelector('.stage-count').style.transform = 'scale(1)';
                    appliedCard.querySelector('.stage-count').style.background = 'rgba(255, 255, 255, 0.8)';
                    appliedCard.querySelector('.stage-count').style.color = '#2d3e2e';
                    
                    if (appliedMetric) appliedMetric.textContent = currentCount + 1;
                }, 300);
            }

            function openApplicationModal() {
                console.log('Opening application modal...');
                const modal = document.getElementById('applicationModal');
                if (modal) {
                    modal.style.display = 'flex';
                    currentStep = 1;
                    updateProgressBar();
                    updateStepIndicators();
                    updateButtons();
                } else {
                    console.error('Modal not found!');
                }
            }
        </script>
    </x-slot>
</x-layout>