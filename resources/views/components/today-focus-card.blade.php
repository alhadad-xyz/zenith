@props(['tasks' => []])

<div class="card task-panel">
    <div class="stage-header">
        <h3 class="stage-title">Today's Focus</h3>
        <button class="add-task-btn" onclick="console.log('Add task button clicked'); openTaskModal();" id="addTaskBtn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add Task
        </button>
    </div>
    
    <div class="task-list" id="taskList">
        @forelse($tasks as $index => $task)
            <div class="task-item" data-task-id="{{ $task['id'] ?? $index }}">
                <div class="task-checkbox {{ $task['completed'] ?? false ? 'checked' : '' }}" 
                     onclick="toggleTask({{ $task['id'] ?? $index }})"></div>
                <span class="task-text {{ $task['completed'] ?? false ? 'completed' : '' }}">
                    {{ $task['text'] ?? $task['title'] ?? 'Untitled Task' }}
                </span>
                <div class="task-actions">
                    @if(isset($task['priority']) && $task['priority'] === 'high')
                        <span class="priority-indicator high">!</span>
                    @endif
                    <button class="task-delete" onclick="deleteTask({{ $task['id'] ?? $index }})">×</button>
                </div>
            </div>
        @empty
            <div class="empty-state" id="emptyState">
                <div class="empty-icon">📋</div>
                <p class="empty-text">No tasks for today</p>
            </div>
        @endforelse
    </div>
    
    <div class="task-progress">
        <div class="progress-bar">
            <div class="progress-fill" id="taskProgress"></div>
        </div>
        <span class="progress-text" id="progressText">0 of 0 completed</span>
    </div>
</div>

<style>
.add-task-btn {
    background: rgba(255, 255, 255, 0.6);
    border: 1px solid rgba(107, 124, 109, 0.3);
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    font-size: 0.8rem;
    color: #2d3e2e;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
    position: relative;
    z-index: 10;
    pointer-events: auto;
}

.add-task-btn:hover {
    background: rgba(255, 255, 255, 0.8);
    border-color: #ff6b6b;
    color: #ff6b6b;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(255, 107, 107, 0.2);
}

.stage-header {
    position: relative;
    z-index: 5;
    pointer-events: auto;
}

.task-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.75rem;
    padding: 0.75rem;
    background: rgba(255, 255, 255, 0.4);
    border-radius: 12px;
    transition: all 0.2s ease;
    position: relative;
    group: cursor-pointer;
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
    position: relative;
}

.task-checkbox.checked {
    background: #ff6b6b;
    border-color: #ff6b6b;
}

.task-checkbox.checked::after {
    content: '✓';
    position: absolute;
    top: -2px;
    left: 2px;
    color: white;
    font-size: 12px;
    font-weight: bold;
}

.task-text {
    flex: 1;
    font-size: 0.9rem;
    color: #2d3e2e;
    font-weight: 500;
    transition: all 0.2s ease;
}

.task-text.completed {
    text-decoration: line-through;
    opacity: 0.6;
}

.task-actions {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.task-item:hover .task-actions {
    opacity: 1;
}

.priority-indicator {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: bold;
    color: white;
}

.priority-indicator.high {
    background: #ff4444;
}

.task-delete {
    background: none;
    border: none;
    color: #6b7c6d;
    cursor: pointer;
    font-size: 16px;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.task-delete:hover {
    background: #ff6b6b;
    color: white;
}

.empty-state {
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
    margin-bottom: 1rem;
    font-style: italic;
}

.empty-cta {
    background: linear-gradient(135deg, #ff6b6b, #ff8e8e);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.empty-cta:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
}

.task-progress {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(107, 124, 109, 0.2);
}

.progress-bar {
    width: 100%;
    height: 6px;
    background: rgba(107, 124, 109, 0.2);
    border-radius: 3px;
    margin-bottom: 0.5rem;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #ff6b6b, #ff8e8e);
    border-radius: 3px;
    transition: width 0.3s ease;
    width: 0%;
}

.progress-text {
    font-size: 0.75rem;
    color: #6b7c6d;
    font-weight: 500;
}
</style>

<script>
function toggleTask(taskId) {
    const taskItem = document.querySelector(`[data-task-id="${taskId}"]`);
    const checkbox = taskItem.querySelector('.task-checkbox');
    const text = taskItem.querySelector('.task-text');
    
    // Optimistically update UI
    checkbox.classList.toggle('checked');
    text.classList.toggle('completed');
    updateTaskProgress();
    
    // Save to database
    fetch(`/tasks/${taskId}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            // Revert UI changes if API call failed
            checkbox.classList.toggle('checked');
            text.classList.toggle('completed');
            updateTaskProgress();
            showNotification(data.message || 'Failed to update task', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Revert UI changes
        checkbox.classList.toggle('checked');
        text.classList.toggle('completed');
        updateTaskProgress();
        showNotification('An error occurred while updating the task', 'error');
    });
}

function deleteTask(taskId) {
    if (!confirm('Are you sure you want to delete this task?')) {
        return;
    }
    
    const taskItem = document.querySelector(`[data-task-id="${taskId}"]`);
    
    // Animate out
    taskItem.style.transform = 'translateX(-100%)';
    taskItem.style.opacity = '0';
    
    // Delete from database
    fetch(`/tasks/${taskId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            setTimeout(() => {
                taskItem.remove();
                updateTaskProgress();
                checkEmptyState();
                showNotification('Task deleted successfully', 'success');
            }, 300);
        } else {
            // Revert animation
            taskItem.style.transform = 'translateX(0)';
            taskItem.style.opacity = '1';
            showNotification(data.message || 'Failed to delete task', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Revert animation
        taskItem.style.transform = 'translateX(0)';
        taskItem.style.opacity = '1';
        showNotification('An error occurred while deleting the task', 'error');
    });
}

function refreshTasks() {
    fetch('/tasks/today', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const taskList = document.getElementById('taskList');
        
        if (data.setup_required) {
            // Show setup message if table doesn't exist
            taskList.innerHTML = `
                <div class="empty-state" id="emptyState">
                    <div class="empty-icon">⚙️</div>
                    <p class="empty-text">Database setup required</p>
                    <small class="empty-subtext">Run: php artisan migrate</small>
                    <button class="empty-cta" onclick="showSetupInstructions()">Setup Instructions</button>
                </div>
            `;
            return;
        }
        
        if (data.success) {
            if (data.tasks.length === 0) {
                taskList.innerHTML = `
                    <div class="empty-state" id="emptyState">
                        <div class="empty-icon">📋</div>
                        <p class="empty-text">No tasks for today</p>
                    </div>
                `;
            } else {
                taskList.innerHTML = '';
                data.tasks.forEach(task => {
                    const taskItem = document.createElement('div');
                    taskItem.className = 'task-item';
                    taskItem.setAttribute('data-task-id', task.id);
                    
                    taskItem.innerHTML = `
                        <div class="task-checkbox ${task.completed ? 'checked' : ''}" onclick="toggleTask('${task.id}')"></div>
                        <span class="task-text ${task.completed ? 'completed' : ''}">${task.title}</span>
                        <div class="task-actions">
                            ${task.priority === 'high' ? '<span class="priority-indicator high">!</span>' : ''}
                            <button class="task-delete" onclick="deleteTask('${task.id}')">×</button>
                        </div>
                    `;
                    
                    taskList.appendChild(taskItem);
                });
            }
            
            updateTaskProgress();
        } else {
            console.error('Error loading tasks:', data.message);
        }
    })
    .catch(error => {
        console.error('Error refreshing tasks:', error);
    });
}

function showSetupInstructions() {
    alert(`Database Setup Required

To enable task management, run one of these commands:

Option 1 (Recommended):
php artisan migrate

Option 2 (Alternative):
php run_migration.php

This will:
✅ Create the tasks table
✅ Set up all relationships
✅ Add sample data for testing

After running the migration, refresh this page to see the enhanced task management features!`);
}

function updateTaskProgress() {
    const tasks = document.querySelectorAll('.task-item');
    const completedTasks = document.querySelectorAll('.task-checkbox.checked');
    const total = tasks.length;
    const completed = completedTasks.length;
    
    const progressFill = document.getElementById('taskProgress');
    const progressText = document.getElementById('progressText');
    
    if (progressFill && progressText) {
        const percentage = total > 0 ? (completed / total) * 100 : 0;
        progressFill.style.width = percentage + '%';
        progressText.textContent = `${completed} of ${total} completed`;
    }
}

function checkEmptyState() {
    const taskList = document.getElementById('taskList');
    const tasks = taskList.querySelectorAll('.task-item');
    
    if (tasks.length === 0) {
        taskList.innerHTML = `
            <div class="empty-state" id="emptyState">
                <div class="empty-icon">📋</div>
                <p class="empty-text">No tasks for today</p>
            </div>
        `;
    }
}

// Initialize progress on page load
document.addEventListener('DOMContentLoaded', function() {
    updateTaskProgress();
});
</script>