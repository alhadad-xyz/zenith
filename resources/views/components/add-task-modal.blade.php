@props(['jobApplications' => []])

<div id="addTaskModal" class="task-modal-overlay" style="display: none;">
    <div class="task-modal">
        <div class="task-modal-header">
            <h3 class="task-modal-title">Add New Task</h3>
            <button class="task-modal-close" onclick="closeTaskModal()">×</button>
        </div>
        
        <form id="addTaskForm" class="task-modal-body">
            @csrf
            <div class="task-form-group">
                <label class="task-form-label" for="taskTitle">Task Title *</label>
                <input 
                    type="text" 
                    id="taskTitle" 
                    name="title" 
                    class="task-form-input" 
                    placeholder="e.g., Follow up with Stripe engineering team"
                    maxlength="255"
                    required
                >
                <div class="task-form-error" id="titleError"></div>
            </div>

            <div class="task-form-group">
                <label class="task-form-label" for="taskDescription">Description</label>
                <textarea 
                    id="taskDescription" 
                    name="description" 
                    class="task-form-textarea" 
                    placeholder="Add any additional details about this task..."
                    rows="3"
                ></textarea>
            </div>

            <div class="task-form-row">
                <div class="task-form-column">
                    <label class="task-form-label" for="taskPriority">Priority</label>
                    <select id="taskPriority" name="priority" class="task-form-select">
                        <option value="normal" selected>Normal</option>
                        <option value="high">High</option>
                        <option value="low">Low</option>
                    </select>
                </div>

                <div class="task-form-column">
                    <label class="task-form-label" for="taskCategory">Category</label>
                    <select id="taskCategory" name="category" class="task-form-select">
                        <option value="general" selected>General</option>
                        <option value="application">Application</option>
                        <option value="interview">Interview</option>
                        <option value="followup">Follow-up</option>
                        <option value="research">Research</option>
                    </select>
                </div>
            </div>

            <div class="task-form-row">
                <div class="task-form-column">
                    <label class="task-form-label" for="taskDueDate">Due Date</label>
                    <input 
                        type="datetime-local" 
                        id="taskDueDate" 
                        name="due_date" 
                        class="task-form-input"
                    >
                </div>

                <div class="task-form-column">
                    <label class="task-form-label" for="taskJobApplication">Related Application</label>
                    <select id="taskJobApplication" name="job_application_id" class="task-form-select">
                        <option value="">None</option>
                        @foreach($jobApplications as $application)
                            <option value="{{ $application->id }}">
                                {{ $application->company_name }} - {{ $application->job_title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="task-quick-actions">
                <h4 class="task-quick-title">Quick Actions</h4>
                <div class="task-quick-buttons">
                    <button type="button" class="task-quick-btn" onclick="setQuickTask('followup')">
                        📞 Follow-up Call
                    </button>
                    <button type="button" class="task-quick-btn" onclick="setQuickTask('research')">
                        🔍 Company Research
                    </button>
                    <button type="button" class="task-quick-btn" onclick="setQuickTask('interview')">
                        🎯 Interview Prep
                    </button>
                    <button type="button" class="task-quick-btn" onclick="setQuickTask('application')">
                        📝 Update Application
                    </button>
                </div>
            </div>
        </form>

        <div class="task-modal-footer">
            <button type="button" class="task-btn-secondary" onclick="closeTaskModal()">Cancel</button>
            <button type="button" class="task-btn-primary" onclick="saveTask()" id="saveTaskBtn">
                <span class="task-btn-text">Add Task</span>
                <span class="task-btn-loading" style="display: none;">
                    <svg class="task-spinner" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.25"/>
                        <path d="M12 2 A10 10 0 0 1 22 12" stroke="currentColor" stroke-width="4" fill="none" stroke-linecap="round"/>
                    </svg>
                    Saving...
                </span>
            </button>
        </div>
    </div>
</div>

<style>
.task-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    padding: 1rem;
}

.task-modal {
    background: white;
    border-radius: 16px;
    width: 100%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    animation: taskModalSlideIn 0.3s ease-out;
}

@keyframes taskModalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.task-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem 2rem 1rem 2rem;
    border-bottom: 1px solid rgba(107, 124, 109, 0.1);
}

.task-modal-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #2d3e2e;
    margin: 0;
}

.task-modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #6b7c6d;
    cursor: pointer;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.task-modal-close:hover {
    background: rgba(107, 124, 109, 0.1);
    color: #2d3e2e;
}

.task-modal-body {
    padding: 1.5rem 2rem;
}

.task-form-group {
    margin-bottom: 1.5rem;
}

.task-form-label {
    display: block;
    font-size: 0.9rem;
    font-weight: 600;
    color: #2d3e2e;
    margin-bottom: 0.5rem;
}

.task-form-input,
.task-form-textarea,
.task-form-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid rgba(107, 124, 109, 0.2);
    border-radius: 8px;
    font-size: 0.9rem;
    color: #2d3e2e;
    transition: all 0.2s ease;
    background: white;
}

.task-form-input:focus,
.task-form-textarea:focus,
.task-form-select:focus {
    outline: none;
    border-color: #ff6b6b;
    box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1);
}

.task-form-textarea {
    resize: vertical;
    min-height: 80px;
    font-family: inherit;
}

.task-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.task-form-column:not(:last-child) {
    margin-right: 0;
}

.task-form-error {
    color: #ff4444;
    font-size: 0.8rem;
    margin-top: 0.25rem;
    min-height: 1rem;
}

.task-quick-actions {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(107, 124, 109, 0.1);
}

.task-quick-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: #2d3e2e;
    margin-bottom: 1rem;
}

.task-quick-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
}

.task-quick-btn {
    background: rgba(255, 107, 107, 0.1);
    border: 1px solid rgba(255, 107, 107, 0.2);
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 0.85rem;
    color: #ff6b6b;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: left;
    font-weight: 500;
}

.task-quick-btn:hover {
    background: rgba(255, 107, 107, 0.15);
    border-color: rgba(255, 107, 107, 0.3);
    transform: translateY(-1px);
}

.task-modal-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 1rem;
    padding: 1rem 2rem 1.5rem 2rem;
    border-top: 1px solid rgba(107, 124, 109, 0.1);
}

.task-btn-secondary,
.task-btn-primary {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
    position: relative;
    min-width: 100px;
}

.task-btn-secondary {
    background: rgba(107, 124, 109, 0.1);
    color: #6b7c6d;
    border: 1px solid rgba(107, 124, 109, 0.2);
}

.task-btn-secondary:hover {
    background: rgba(107, 124, 109, 0.15);
}

.task-btn-primary {
    background: linear-gradient(135deg, #ff6b6b, #ff8e8e);
    color: white;
    box-shadow: 0 2px 8px rgba(255, 107, 107, 0.2);
}

.task-btn-primary:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
}

.task-btn-primary:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.task-btn-loading,
.task-btn-text {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.task-spinner {
    width: 16px;
    height: 16px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@media (max-width: 768px) {
    .task-modal {
        margin: 1rem;
        max-width: none;
    }
    
    .task-modal-header,
    .task-modal-body,
    .task-modal-footer {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }
    
    .task-form-row {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .task-quick-buttons {
        grid-template-columns: 1fr;
    }
    
    .task-modal-footer {
        flex-direction: column-reverse;
        gap: 0.75rem;
    }
    
    .task-btn-secondary,
    .task-btn-primary {
        width: 100%;
    }
}
</style>

<!-- Modal functions are now handled in the dashboard script -->