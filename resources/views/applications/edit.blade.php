<x-layout title="Zenith - Edit Application">
    <x-slot name="styles">
        <style>
            /* Edit application specific styles */
        /* Dashboard Background (Blurred) */
        .dashboard-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #f5f1e8 0%, #e8f2e8 50%, #f0e5e0 100%);
            filter: blur(8px);
            opacity: 0.7;
            z-index: 1;
        }

        .dashboard-content {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding: 2rem;
            filter: blur(4px);
            opacity: 0.3;
            z-index: 2;
            pointer-events: none;
        }

        .mock-card {
            background: rgba(255, 255, 255, 0.4);
            border-radius: 24px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .mock-card.large {
            height: 200px;
            width: 300px;
            float: left;
            margin-right: 1.5rem;
        }

        .mock-card.medium {
            height: 150px;
            width: 250px;
            float: right;
            margin-left: 1.5rem;
        }

        .mock-card.small {
            height: 100px;
            clear: both;
            margin-top: 2rem;
        }

        /* Edit page specific modal adjustments */
        .modal-body {
            max-height: 60vh;
        }
        </style>
    </x-slot>
    <!-- Dashboard Background -->
    <div class="dashboard-background"></div>
    <div class="dashboard-content">
        <div class="mock-card large"></div>
        <div class="mock-card medium"></div>
        <div class="mock-card small"></div>
        <div class="mock-card medium"></div>
        <div class="mock-card large"></div>
    </div>

    <!-- Modal -->
    <div class="modal-overlay">
        <div class="modal">
            <!-- Progress Bar -->
            <div class="progress-container">
                <div class="progress-bar" id="progressBar"></div>
            </div>

            <!-- Modal Header -->
            <div class="modal-header">
                <a href="{{ route('applications.show', $application) }}" class="close-button">×</a>
                <h2 class="modal-title">Edit Application</h2>
                <p class="modal-subtitle">Update your application details</p>
                <div class="step-indicator">
                    <div class="step-dot active" id="dot1"></div>
                    <div class="step-dot" id="dot2"></div>
                    <div class="step-dot" id="dot3"></div>
                </div>
            </div>

            <form method="POST" action="{{ route('applications.update', $application) }}" enctype="multipart/form-data" id="editApplicationForm">
                @csrf
                @method('PUT')
                
                <!-- Modal Body -->
                <div class="modal-body">
                    <!-- Step 1: Company & Role -->
                    <div class="step active" id="step1">
                        <h3 class="step-title">Company & Role</h3>
                        <div class="form-row">
                            <x-form-group label="Company Name" required :error="$errors->first('company_name')">
                                <x-form-input name="company_name" 
                                    placeholder="e.g. Stripe, Figma, Linear" 
                                    :value="$application->company_name" 
                                    required />
                            </x-form-group>
                            
                            <x-form-group label="Job Title" required :error="$errors->first('job_title')">
                                <x-form-input name="job_title" 
                                    placeholder="e.g. Senior Product Designer" 
                                    :value="$application->job_title" 
                                    required />
                            </x-form-group>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Department</label>
                                <select class="form-select" name="department">
                                    <option value="">Select department</option>
                                    <option value="design" {{ old('department', $application->department) === 'design' ? 'selected' : '' }}>Design</option>
                                    <option value="engineering" {{ old('department', $application->department) === 'engineering' ? 'selected' : '' }}>Engineering</option>
                                    <option value="product" {{ old('department', $application->department) === 'product' ? 'selected' : '' }}>Product</option>
                                    <option value="marketing" {{ old('department', $application->department) === 'marketing' ? 'selected' : '' }}>Marketing</option>
                                    <option value="sales" {{ old('department', $application->department) === 'sales' ? 'selected' : '' }}>Sales</option>
                                    <option value="other" {{ old('department', $application->department) === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Employment Type</label>
                                <select class="form-select" name="employment_type">
                                    <option value="">Select type</option>
                                    <option value="full-time" {{ old('employment_type', $application->employment_type) === 'full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="part-time" {{ old('employment_type', $application->employment_type) === 'part-time' ? 'selected' : '' }}>Part-time</option>
                                    <option value="contract" {{ old('employment_type', $application->employment_type) === 'contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="internship" {{ old('employment_type', $application->employment_type) === 'internship' ? 'selected' : '' }}>Internship</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Job Details & URL -->
                    <div class="step" id="step2">
                        <h3 class="step-title">Job Details & URL</h3>
                        <div class="form-group">
                            <label class="form-label">Job Posting URL</label>
                            <input type="url" class="form-input" name="job_url" placeholder="https://jobs.company.com/role" value="{{ old('job_url', $application->job_url) }}">
                            @error('job_url')
                                <div style="color: #ff6b6b; font-size: 0.9rem; margin-top: 0.5rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Location</label>
                            <input type="text" class="form-input" name="location" placeholder="San Francisco, CA or Remote" value="{{ old('location', $application->location) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Salary Range (Optional)</label>
                            <div class="salary-group">
                                <input type="text" class="form-input" name="salary_min" placeholder="$120,000" value="{{ old('salary_min', $application->salary_min) }}">
                                <input type="text" class="form-input" name="salary_max" placeholder="$180,000" value="{{ old('salary_max', $application->salary_max) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Job Description</label>
                            <textarea class="form-textarea" name="job_description" placeholder="Paste the job description here...">{{ old('job_description', $application->job_description) }}</textarea>
                        </div>
                    </div>

                    <!-- Step 3: Resume & Notes -->
                    <div class="step" id="step3">
                        <h3 class="step-title">Resume & Notes</h3>
                        <div class="form-group">
                            <label class="form-label">Resume</label>
                            <label class="file-upload {{ $application->resume_path ? 'has-file' : '' }}" id="resumeUpload">
                                <input type="file" accept=".pdf,.doc,.docx" name="resume" id="resumeFile">
                                <div class="file-upload-icon">📄</div>
                                <div class="file-upload-text">
                                    @if($application->resume_path)
                                        {{ basename($application->resume_path) }}
                                    @else
                                        Choose resume file or drag & drop
                                    @endif
                                </div>
                            </label>
                            @error('resume')
                                <div style="color: #ff6b6b; font-size: 0.9rem; margin-top: 0.5rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Cover Letter (Optional)</label>
                            <label class="file-upload {{ $application->cover_letter_path ? 'has-file' : '' }}" id="coverLetterUpload">
                                <input type="file" accept=".pdf,.doc,.docx" name="cover_letter" id="coverLetterFile">
                                <div class="file-upload-icon">📝</div>
                                <div class="file-upload-text">
                                    @if($application->cover_letter_path)
                                        {{ basename($application->cover_letter_path) }}
                                    @else
                                        Choose cover letter or drag & drop
                                    @endif
                                </div>
                            </label>
                            @error('cover_letter')
                                <div style="color: #ff6b6b; font-size: 0.9rem; margin-top: 0.5rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Application Notes</label>
                            <textarea class="form-textarea" name="application_notes" placeholder="Add any notes about this application, referrals, or next steps...">{{ old('application_notes', $application->application_notes) }}</textarea>
                        </div>
                    </div>

                    <!-- Success Step -->
                    <div class="step" id="successStep">
                        <div class="success-step">
                            <div class="success-icon">✓</div>
                            <h3 class="success-title">Application Updated!</h3>
                            <p class="success-description">Your application has been successfully updated with the new information.</p>
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
                nextBtn.textContent = 'Update Application';
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
                // Submit the form
                document.getElementById('editApplicationForm').submit();
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

        // Initialize file uploads
        setupFileUpload('resumeFile', 'resumeUpload');
        setupFileUpload('coverLetterFile', 'coverLetterUpload');

        // Input animations and validation
        document.querySelectorAll('.form-input, .form-textarea, .form-select').forEach(input => {
            input.addEventListener('focus', function() {
                this.style.transform = 'translateY(-2px)';
            });

            input.addEventListener('blur', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && e.ctrlKey) {
                nextStep();
            } else if (e.key === 'Escape') {
                window.location.href = '{{ route("applications.show", $application) }}';
            }
        });

        // Initialize
        updateProgressBar();
        updateStepIndicators();
        updateButtons();

        // Show success message if redirected back after successful update
        @if(session('success'))
            // Show success step
            document.querySelectorAll('.step').forEach(step => {
                step.classList.remove('active');
            });
            document.getElementById('successStep').classList.add('active');
            document.querySelector('.modal-footer').style.display = 'none';
            document.getElementById('progressBar').style.width = '100%';
            
            // Redirect after 2 seconds
            setTimeout(() => {
                window.location.href = '{{ route("applications.show", $application) }}';
            }, 2000);
        @endif
    </script>

    <x-slot name="scripts">
        <script>
            // Edit application specific JavaScript
        </script>
    </x-slot>
</x-layout>