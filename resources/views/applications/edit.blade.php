<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Zenith - Edit Application</title>
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
            overflow-x: hidden;
            letter-spacing: -0.01em;
            position: relative;
        }

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

        /* Modal Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(45, 62, 46, 0.1);
            backdrop-filter: blur(12px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            animation: fadeIn 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                backdrop-filter: blur(0px);
            }
            to {
                opacity: 1;
                backdrop-filter: blur(12px);
            }
        }

        /* Modal Container */
        .modal {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 32px;
            width: 100%;
            max-width: 600px;
            min-height: 500px;
            position: relative;
            overflow: hidden;
            box-shadow: 
                0 32px 64px rgba(45, 62, 46, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);
            animation: modalSlideIn 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(40px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Progress Bar */
        .progress-container {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #ff6b6b 0%, #ff5252 100%);
            width: 33.33%;
            transition: width 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 0 0 20px rgba(255, 107, 107, 0.4);
        }

        /* Modal Header */
        .modal-header {
            padding: 3rem 3rem 1rem 3rem;
            text-align: center;
            position: relative;
        }

        .close-button {
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

        .close-button:hover {
            background: rgba(255, 255, 255, 0.8);
            transform: scale(1.05);
            color: #2d3e2e;
        }

        .modal-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2d3e2e;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
        }

        .modal-subtitle {
            font-size: 1.1rem;
            color: #6b7c6d;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .step-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .step-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(107, 124, 109, 0.3);
            transition: all 0.3s ease;
        }

        .step-dot.active {
            background: #ff6b6b;
            transform: scale(1.5);
            box-shadow: 0 0 12px rgba(255, 107, 107, 0.4);
        }

        .step-dot.completed {
            background: #6b7c6d;
        }

        /* Modal Body */
        .modal-body {
            padding: 2rem 3rem;
            min-height: 300px;
            max-height: 60vh;
            overflow-y: auto;
        }

        .step {
            display: none;
            animation: stepFadeIn 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .step.active {
            display: block;
        }

        @keyframes stepFadeIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .step-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2d3e2e;
            letter-spacing: -0.02em;
            margin-bottom: 2rem;
            text-align: center;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 2rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .form-label {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2d3e2e;
            margin-bottom: 0.75rem;
            display: block;
            letter-spacing: -0.01em;
        }

        .form-input, .form-textarea, .form-select {
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

        .form-input:focus, .form-textarea:focus, .form-select:focus {
            outline: none;
            border-color: #ff6b6b;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 0 4px rgba(255, 107, 107, 0.1);
            transform: translateY(-2px);
        }

        .form-input::placeholder, .form-textarea::placeholder {
            color: #6b7c6d;
            font-weight: 400;
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .salary-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .file-upload {
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

        .file-upload:hover {
            border-color: #ff6b6b;
            background: rgba(255, 255, 255, 0.6);
            transform: translateY(-2px);
        }

        .file-upload input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-upload-icon {
            font-size: 2rem;
            color: #6b7c6d;
            margin-bottom: 0.5rem;
        }

        .file-upload-text {
            font-size: 1rem;
            color: #6b7c6d;
            font-weight: 500;
        }

        .file-upload.has-file {
            border-color: #ff6b6b;
            background: rgba(255, 107, 107, 0.1);
        }

        .file-upload.has-file .file-upload-text {
            color: #ff6b6b;
            font-weight: 600;
        }

        /* Modal Footer */
        .modal-footer {
            padding: 2rem 3rem 3rem 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            min-width: 120px;
            text-decoration: none;
            text-align: center;
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

        .btn-secondary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
            color: white;
            box-shadow: 0 8px 32px rgba(255, 107, 107, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 48px rgba(255, 107, 107, 0.4);
            background: linear-gradient(135deg, #ff5252 0%, #ff4444 100%);
        }

        /* Success Animation */
        .success-step {
            text-align: center;
            padding: 3rem 0;
        }

        .success-icon {
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

        @keyframes successPulse {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .success-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3e2e;
            margin-bottom: 1rem;
        }

        .success-description {
            font-size: 1.1rem;
            color: #6b7c6d;
            margin-bottom: 2rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modal {
                margin: 1rem;
                max-width: none;
                border-radius: 24px;
            }

            .modal-header,
            .modal-body,
            .modal-footer {
                padding-left: 2rem;
                padding-right: 2rem;
            }

            .modal-title {
                font-size: 2rem;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .salary-group {
                grid-template-columns: 1fr;
            }

            .modal-footer {
                flex-direction: column;
                gap: 1rem;
            }

            .btn {
                width: 100%;
            }
        }

        /* Custom Scrollbar */
        .modal-body::-webkit-scrollbar {
            width: 4px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: rgba(255, 107, 107, 0.3);
            border-radius: 2px;
        }
    </style>
</head>
<body>
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
                            <div class="form-group">
                                <label class="form-label">Company Name</label>
                                <input type="text" class="form-input" name="company_name" placeholder="e.g. Stripe, Figma, Linear" value="{{ old('company_name', $application->company_name) }}" required>
                                @error('company_name')
                                    <div style="color: #ff6b6b; font-size: 0.9rem; margin-top: 0.5rem;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Job Title</label>
                                <input type="text" class="form-input" name="job_title" placeholder="e.g. Senior Product Designer" value="{{ old('job_title', $application->job_title) }}" required>
                                @error('job_title')
                                    <div style="color: #ff6b6b; font-size: 0.9rem; margin-top: 0.5rem;">{{ $message }}</div>
                                @enderror
                            </div>
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
</body>
</html>