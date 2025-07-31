@props(['application'])

<!-- Edit Application Modal -->
<div class="modal-overlay" id="editApplicationModalOverlay" style="display: none;">
    <div class="edit-application-modal">
        <!-- Progress Bar -->
        <div class="progress-container">
            <div class="progress-bar" id="editProgressBar"></div>
        </div>

        <!-- Modal Header -->
        <div class="modal-header">
            <h2 class="modal-title">Edit Application</h2>
            <p class="modal-subtitle">Update your application details</p>
            <button class="close-button" onclick="closeEditApplicationModal()" aria-label="Close modal">×</button>
            <div class="step-indicator">
                <div class="step-dot active" id="editDot1"></div>
                <div class="step-dot" id="editDot2"></div>
                <div class="step-dot" id="editDot3"></div>
            </div>
        </div>

        <form method="POST" action="{{ route('applications.update', $application) }}" enctype="multipart/form-data" id="editApplicationModalForm">
            @csrf
            @method('PUT')
            
            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Step 1: Company & Role -->
                <div class="step active" id="editStep1">
                    <h3 class="step-title">Company & Role</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Company Name *</label>
                            <input type="text" class="form-input" name="company_name" 
                                placeholder="e.g. Stripe, Figma, Linear" 
                                value="{{ $application->company_name }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Job Title *</label>
                            <input type="text" class="form-input" name="job_title" 
                                placeholder="e.g. Senior Product Designer" 
                                value="{{ $application->job_title }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Department</label>
                            <select class="form-select" name="department">
                                <option value="">Select department</option>
                                <option value="design" {{ $application->department === 'design' ? 'selected' : '' }}>Design</option>
                                <option value="engineering" {{ $application->department === 'engineering' ? 'selected' : '' }}>Engineering</option>
                                <option value="product" {{ $application->department === 'product' ? 'selected' : '' }}>Product</option>
                                <option value="marketing" {{ $application->department === 'marketing' ? 'selected' : '' }}>Marketing</option>
                                <option value="sales" {{ $application->department === 'sales' ? 'selected' : '' }}>Sales</option>
                                <option value="other" {{ $application->department === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Employment Type</label>
                            <select class="form-select" name="employment_type">
                                <option value="">Select type</option>
                                <option value="full-time" {{ $application->employment_type === 'full-time' ? 'selected' : '' }}>Full-time</option>
                                <option value="part-time" {{ $application->employment_type === 'part-time' ? 'selected' : '' }}>Part-time</option>
                                <option value="contract" {{ $application->employment_type === 'contract' ? 'selected' : '' }}>Contract</option>
                                <option value="internship" {{ $application->employment_type === 'internship' ? 'selected' : '' }}>Internship</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Job Details & URL -->
                <div class="step" id="editStep2">
                    <h3 class="step-title">Job Details & URL</h3>
                    <div class="form-group">
                        <label class="form-label">Job Posting URL</label>
                        <input type="url" class="form-input" name="job_url" 
                            placeholder="https://jobs.company.com/role" 
                            value="{{ $application->job_url }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Location</label>
                        <input type="text" class="form-input" name="location" 
                            placeholder="San Francisco, CA or Remote" 
                            value="{{ $application->location }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Salary Range (Optional)</label>
                        <div class="salary-group">
                            <input type="text" class="form-input" name="salary_min" 
                                placeholder="$120,000" value="{{ $application->salary_min }}">
                            <input type="text" class="form-input" name="salary_max" 
                                placeholder="$180,000" value="{{ $application->salary_max }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Job Description</label>
                        <textarea class="form-textarea" name="job_description" 
                            placeholder="Paste the job description here...">{{ $application->job_description }}</textarea>
                    </div>
                </div>

                <!-- Step 3: Resume & Notes -->
                <div class="step" id="editStep3">
                    <h3 class="step-title">Resume & Notes</h3>
                    <div class="form-group">
                        <label class="form-label">Resume</label>
                        <label class="file-upload {{ $application->resume_path ? 'has-file' : '' }}" id="editResumeUpload">
                            <input type="file" accept=".pdf,.doc,.docx" name="resume" id="editResumeFile">
                            <div class="file-upload-icon">📄</div>
                            <div class="file-upload-text">
                                @if($application->resume_path)
                                    {{ basename($application->resume_path) }}
                                @else
                                    Choose resume file or drag & drop
                                @endif
                            </div>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cover Letter (Optional)</label>
                        <label class="file-upload {{ $application->cover_letter_path ? 'has-file' : '' }}" id="editCoverLetterUpload">
                            <input type="file" accept=".pdf,.doc,.docx" name="cover_letter" id="editCoverLetterFile">
                            <div class="file-upload-icon">📝</div>
                            <div class="file-upload-text">
                                @if($application->cover_letter_path)
                                    {{ basename($application->cover_letter_path) }}
                                @else
                                    Choose cover letter or drag & drop
                                @endif
                            </div>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Application Notes</label>
                        <textarea class="form-textarea" name="application_notes" 
                            placeholder="Add any notes about this application, referrals, or next steps...">{{ $application->application_notes }}</textarea>
                    </div>
                </div>

                <!-- Success Step -->
                <div class="step" id="editSuccessStep">
                    <div class="success-step">
                        <div class="success-icon">✓</div>
                        <h3 class="success-title">Application Updated!</h3>
                        <p class="success-description">Your application has been successfully updated with the new information.</p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" id="editPrevBtn" onclick="editPreviousStep()" disabled>Previous</button>
                <button type="button" class="btn btn-primary" id="editNextBtn" onclick="editNextStep()">Next</button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Edit Application Modal Styles */
    .edit-application-modal {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(40px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 32px;
        width: 100%;
        max-width: 600px;
        min-height: 500px;
        position: relative;
        overflow: hidden;
        box-shadow: 
            0 32px 80px rgba(45, 62, 46, 0.15),
            0 0 0 1px rgba(255, 255, 255, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.4);
        animation: modalSlideIn 0.5s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .edit-application-modal .progress-container {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: rgba(255, 255, 255, 0.3);
        overflow: hidden;
    }

    .edit-application-modal .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #ff6b6b 0%, #ff5252 100%);
        width: 33.33%;
        transition: width 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        box-shadow: 0 0 20px rgba(255, 107, 107, 0.4);
    }

    .edit-application-modal .modal-header {
        padding: 3rem 3rem 1rem 3rem;
        text-align: center;
        position: relative;
    }

    .edit-application-modal .close-button {
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

    .edit-application-modal .close-button:hover {
        background: rgba(255, 255, 255, 0.8);
        transform: scale(1.05);
        color: #2d3e2e;
    }

    .edit-application-modal .modal-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #2d3e2e;
        letter-spacing: -0.03em;
        margin-bottom: 0.5rem;
    }

    .edit-application-modal .modal-subtitle {
        font-size: 1.1rem;
        color: #6b7c6d;
        font-weight: 500;
        margin-bottom: 1rem;
    }

    .edit-application-modal .step-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .edit-application-modal .step-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(107, 124, 109, 0.3);
        transition: all 0.3s ease;
    }

    .edit-application-modal .step-dot.active {
        background: #ff6b6b;
        transform: scale(1.5);
        box-shadow: 0 0 12px rgba(255, 107, 107, 0.4);
    }

    .edit-application-modal .step-dot.completed {
        background: #6b7c6d;
    }

    .edit-application-modal .modal-body {
        padding: 2rem 3rem;
        min-height: 300px;
        max-height: 60vh;
        overflow-y: auto;
    }

    .edit-application-modal .step {
        display: none;
        animation: stepFadeIn 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .edit-application-modal .step.active {
        display: block;
    }

    .edit-application-modal .step-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2d3e2e;
        letter-spacing: -0.02em;
        margin-bottom: 2rem;
        text-align: center;
    }

    .edit-application-modal .form-group {
        margin-bottom: 2rem;
    }

    .edit-application-modal .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .edit-application-modal .form-label {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2d3e2e;
        margin-bottom: 0.75rem;
        display: block;
        letter-spacing: -0.01em;
    }

    .edit-application-modal .form-input, 
    .edit-application-modal .form-textarea, 
    .edit-application-modal .form-select {
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

    .edit-application-modal .form-input:focus, 
    .edit-application-modal .form-textarea:focus, 
    .edit-application-modal .form-select:focus {
        outline: none;
        border-color: #ff6b6b;
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 0 0 4px rgba(255, 107, 107, 0.1);
        transform: translateY(-2px);
    }

    .edit-application-modal .form-input::placeholder, 
    .edit-application-modal .form-textarea::placeholder {
        color: #6b7c6d;
        font-weight: 400;
    }

    .edit-application-modal .form-textarea {
        min-height: 120px;
        resize: vertical;
    }

    .edit-application-modal .salary-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .edit-application-modal .file-upload {
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

    .edit-application-modal .file-upload:hover {
        border-color: #ff6b6b;
        background: rgba(255, 255, 255, 0.6);
        transform: translateY(-2px);
    }

    .edit-application-modal .file-upload input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .edit-application-modal .file-upload-icon {
        font-size: 2rem;
        color: #6b7c6d;
        margin-bottom: 0.5rem;
    }

    .edit-application-modal .file-upload-text {
        font-size: 1rem;
        color: #6b7c6d;
        font-weight: 500;
    }

    .edit-application-modal .file-upload.has-file {
        border-color: #ff6b6b;
        background: rgba(255, 107, 107, 0.1);
    }

    .edit-application-modal .file-upload.has-file .file-upload-text {
        color: #ff6b6b;
        font-weight: 600;
    }

    .edit-application-modal .modal-footer {
        padding: 2rem 3rem 3rem 3rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .edit-application-modal .success-step {
        text-align: center;
        padding: 3rem 0;
    }

    .edit-application-modal .success-icon {
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

    .edit-application-modal .success-title {
        font-size: 2rem;
        font-weight: 700;
        color: #2d3e2e;
        margin-bottom: 1rem;
    }

    .edit-application-modal .success-description {
        font-size: 1.1rem;
        color: #6b7c6d;
        margin-bottom: 2rem;
    }

    @media (max-width: 768px) {
        .edit-application-modal {
            margin: 1rem;
            max-width: none;
            border-radius: 24px;
        }

        .edit-application-modal .modal-header,
        .edit-application-modal .modal-body,
        .edit-application-modal .modal-footer {
            padding-left: 2rem;
            padding-right: 2rem;
        }

        .edit-application-modal .modal-title {
            font-size: 2rem;
        }

        .edit-application-modal .form-row {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .edit-application-modal .salary-group {
            grid-template-columns: 1fr;
        }

        .edit-application-modal .modal-footer {
            flex-direction: column;
            gap: 1rem;
        }

        .edit-application-modal .btn {
            width: 100%;
        }
    }
</style>

<script>
    let editCurrentStep = 1;
    const editTotalSteps = 3;

    function showEditApplicationModal() {
        const modal = document.getElementById('editApplicationModalOverlay');
        modal.style.display = 'flex';
        
        // Auto-focus first input
        setTimeout(() => {
            const firstInput = document.querySelector('#editApplicationModalOverlay .form-input');
            if (firstInput) firstInput.focus();
        }, 500);
    }

    function closeEditApplicationModal() {
        const modal = document.getElementById('editApplicationModalOverlay');
        modal.style.animation = 'overlayFadeOut 0.3s cubic-bezier(0.23, 1, 0.32, 1) forwards';
        
        setTimeout(() => {
            modal.style.display = 'none';
            modal.style.animation = '';
            resetEditApplicationForm();
        }, 300);
    }

    function resetEditApplicationForm() {
        editCurrentStep = 1;
        updateEditProgressBar();
        updateEditStepIndicators();
        updateEditButtons();
    }

    function updateEditProgressBar() {
        const progressBar = document.getElementById('editProgressBar');
        const percentage = (editCurrentStep / editTotalSteps) * 100;
        progressBar.style.width = percentage + '%';
    }

    function updateEditStepIndicators() {
        for (let i = 1; i <= editTotalSteps; i++) {
            const dot = document.getElementById(`editDot${i}`);
            const step = document.getElementById(`editStep${i}`);
            
            if (i < editCurrentStep) {
                dot.className = 'step-dot completed';
                step.classList.remove('active');
            } else if (i === editCurrentStep) {
                dot.className = 'step-dot active';
                step.classList.add('active');
            } else {
                dot.className = 'step-dot';
                step.classList.remove('active');
            }
        }
    }

    function updateEditButtons() {
        const prevBtn = document.getElementById('editPrevBtn');
        const nextBtn = document.getElementById('editNextBtn');

        prevBtn.disabled = editCurrentStep === 1;
        
        if (editCurrentStep === editTotalSteps) {
            nextBtn.textContent = 'Update Application';
            nextBtn.classList.add('btn-save');
        } else {
            nextBtn.textContent = 'Next';
            nextBtn.classList.remove('btn-save');
        }
    }

    function editNextStep() {
        if (editCurrentStep < editTotalSteps) {
            editCurrentStep++;
            updateEditProgressBar();
            updateEditStepIndicators();
            updateEditButtons();
        } else {
            // Submit the form
            document.getElementById('editApplicationModalForm').submit();
        }
    }

    function editPreviousStep() {
        if (editCurrentStep > 1) {
            editCurrentStep--;
            updateEditProgressBar();
            updateEditStepIndicators();
            updateEditButtons();
        }
    }

    // File upload handling for edit modal
    function setupEditFileUpload(inputId, uploadId) {
        const fileInput = document.getElementById(inputId);
        const uploadArea = document.getElementById(uploadId);
        
        if (!fileInput || !uploadArea) return;
        
        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const fileName = e.target.files[0].name;
                uploadArea.classList.add('has-file');
                uploadArea.querySelector('.file-upload-text').textContent = fileName;
            } else {
                uploadArea.classList.remove('has-file');
                uploadArea.querySelector('.file-upload-text').textContent = 'Choose file or drag & drop';
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

    // Initialize edit modal when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize edit modal functionality
        updateEditProgressBar();
        updateEditStepIndicators();
        updateEditButtons();

        // Initialize file uploads for edit modal
        setupEditFileUpload('editResumeFile', 'editResumeUpload');
        setupEditFileUpload('editCoverLetterFile', 'editCoverLetterUpload');

        // Input animations for edit modal
        document.querySelectorAll('#editApplicationModalOverlay .form-input, #editApplicationModalOverlay .form-textarea, #editApplicationModalOverlay .form-select').forEach(input => {
            input.addEventListener('focus', function() {
                this.style.transform = 'translateY(-2px)';
            });

            input.addEventListener('blur', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Keyboard navigation for edit modal
        document.addEventListener('keydown', function(e) {
            const editModal = document.getElementById('editApplicationModalOverlay');
            
            if (editModal && editModal.style.display === 'flex') {
                if (e.key === 'Escape') {
                    closeEditApplicationModal();
                } else if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) {
                    e.preventDefault();
                    editNextStep();
                }
            }
        });
    });
</script>