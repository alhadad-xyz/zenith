<x-layout title="Zenith - {{ $application->job_title }} at {{ $application->company_name }}">
    <x-slot name="styles">
        <style>
            /* Application detail specific styles */
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

        /* Add Event Modal Styles */
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
            animation: overlayFadeIn 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        }

        @keyframes overlayFadeIn {
            from {
                opacity: 0;
                backdrop-filter: blur(0px);
            }
            to {
                opacity: 1;
                backdrop-filter: blur(12px);
            }
        }

        @keyframes overlayFadeOut {
            from {
                opacity: 1;
                backdrop-filter: blur(12px);
            }
            to {
                opacity: 0;
                backdrop-filter: blur(0px);
            }
        }

        .add-event-modal {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 32px;
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 
                0 32px 80px rgba(45, 62, 46, 0.15),
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

        .add-event-modal::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0.1) 0%, 
                rgba(255, 107, 107, 0.02) 50%, 
                rgba(255, 255, 255, 0.05) 100%);
            border-radius: 32px;
            pointer-events: none;
        }

        .add-event-modal .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            position: relative;
            z-index: 2;
        }

        .add-event-modal .modal-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2d3e2e;
            letter-spacing: -0.02em;
        }

        .add-event-modal .close-button {
            width: 40px;
            height: 40px;
            border: none;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            color: #6b7c6d;
            font-size: 1.1rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }

        .add-event-modal .close-button:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: scale(1.05);
            color: #2d3e2e;
        }

        .event-type-selector {
            margin-bottom: 2rem;
            position: relative;
            z-index: 2;
        }

        .selector-label {
            font-size: 1rem;
            font-weight: 600;
            color: #2d3e2e;
            margin-bottom: 1rem;
            letter-spacing: -0.01em;
        }

        .type-buttons {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .type-button {
            padding: 0.75rem 1.5rem;
            border: 2px solid rgba(255, 255, 255, 0.6);
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.7);
            color: #6b7c6d;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            font-family: 'Inter', sans-serif;
            backdrop-filter: blur(10px);
            flex: 1;
            text-align: center;
            min-width: 100px;
        }

        .type-button:hover {
            border-color: rgba(255, 107, 107, 0.4);
            background: rgba(255, 255, 255, 0.8);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(45, 62, 46, 0.1);
        }

        .type-button.active {
            border-color: #ff6b6b;
            background: rgba(255, 107, 107, 0.1);
            color: #ff6b6b;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(255, 107, 107, 0.2);
        }

        .form-container {
            position: relative;
            z-index: 2;
            min-height: 300px;
            flex: 1;
            overflow-y: auto;
            padding-right: 10px;
            margin-right: -10px;
        }

        .form-content {
            display: none;
            animation: formSlideIn 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .form-content.active {
            display: block;
        }

        @keyframes formSlideIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-row {
            display: flex;
            gap: 1rem;
        }

        .form-label {
            display: block;
            font-size: 1rem;
            font-weight: 600;
            color: #2d3e2e;
            margin-bottom: 0.75rem;
            letter-spacing: -0.01em;
        }

        .form-input,
        .form-textarea,
        .form-select {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid rgba(255, 255, 255, 0.6);
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            font-size: 1rem;
            font-weight: 500;
            color: #2d3e2e;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            font-family: 'Inter', sans-serif;
        }

        .form-input:focus,
        .form-textarea:focus,
        .form-select:focus {
            outline: none;
            border-color: #ff6b6b;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 0 4px rgba(255, 107, 107, 0.1);
            transform: translateY(-2px);
        }

        .form-input::placeholder,
        .form-textarea::placeholder {
            color: #9aa0a6;
            font-weight: 400;
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-textarea.large {
            min-height: 200px;
        }

        .datetime-row {
            display: flex;
            gap: 1rem;
        }

        .datetime-group {
            flex: 1;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .checkbox {
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.6);
            border-radius: 4px;
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        .checkbox:checked {
            background: #ff6b6b;
            border-color: #ff6b6b;
        }

        .checkbox:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .checkbox-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: #6b7c6d;
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            position: relative;
            z-index: 2;
            flex-shrink: 0;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-cancel {
            background: rgba(255, 255, 255, 0.7);
            color: #6b7c6d;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.6);
        }

        .btn-cancel:hover {
            background: rgba(255, 255, 255, 0.9);
            color: #2d3e2e;
            transform: translateY(-2px);
        }

        .quick-actions {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .quick-btn {
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            color: #6b7c6d;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .quick-btn:hover {
            background: rgba(255, 255, 255, 0.8);
            color: #2d3e2e;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* Custom Scrollbar for Form Container */
        .form-container::-webkit-scrollbar {
            width: 4px;
        }

        .form-container::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
        }

        .form-container::-webkit-scrollbar-thumb {
            background: rgba(255, 107, 107, 0.3);
            border-radius: 2px;
        }

        .form-container::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 107, 107, 0.5);
        }

        /* Mobile Responsive for Add Event Modal */
        @media (max-width: 768px) {
            .add-event-modal {
                max-height: 95vh;
                margin: 1rem;
                padding: 2rem;
                border-radius: 24px;
            }

            .form-container {
                padding-right: 5px;
                margin-right: -5px;
            }

            .modal-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }

        /* Resume Analysis Styles */
        .analysis-section {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .score-card {
            background: rgba(255, 255, 255, 0.5);
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .score-label {
            font-size: 0.8rem;
            color: #6b7c6d;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .score-value {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3e2e;
            line-height: 1;
        }

        .analysis-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .analysis-list li {
            background: rgba(255, 255, 255, 0.4);
            border-radius: 8px;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border-left: 3px solid transparent;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .strengths-list li {
            border-left-color: #34a853;
            background: rgba(52, 168, 83, 0.1);
        }

        .weaknesses-list li {
            border-left-color: #ff6b6b;
            background: rgba(255, 107, 107, 0.1);
        }

        .recommendations-list li {
            border-left-color: #9c27b0;
            background: rgba(156, 39, 176, 0.1);
        }

        .keywords-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .keyword-tag {
            background: rgba(255, 167, 38, 0.1);
            color: #f57f17;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            border: 1px solid rgba(255, 167, 38, 0.3);
        }

        .suggestions-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .suggestion-card {
            background: rgba(255, 255, 255, 0.4);
            border-radius: 12px;
            padding: 1rem;
            border-left: 3px solid #4285f4;
        }

        .suggestion-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .suggestion-category {
            font-size: 0.8rem;
            font-weight: 600;
            color: #4285f4;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .suggestion-priority {
            padding: 0.2rem 0.6rem;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .suggestion-priority.high {
            background: rgba(255, 107, 107, 0.2);
            color: #ff6b6b;
        }

        .suggestion-priority.medium {
            background: rgba(255, 167, 38, 0.2);
            color: #ffa726;
        }

        .suggestion-priority.low {
            background: rgba(107, 124, 109, 0.2);
            color: #6b7c6d;
        }

        .suggestion-text {
            font-size: 0.9rem;
            color: #2d3e2e;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .suggestion-impact {
            font-size: 0.8rem;
            color: #6b7c6d;
            font-style: italic;
        }
        </style>
    </x-slot>
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

                    @foreach($application->events as $event)
                    @php
                        $eventClass = 'completed'; // Default
                        if ($event->type === 'rejected') {
                            $eventClass = 'completed';
                        } elseif ($event->type === 'interview') {
                            if ($event->event_date && \Carbon\Carbon::parse($event->event_date)->isFuture()) {
                                $eventClass = 'upcoming';
                            } elseif ($event->event_date && \Carbon\Carbon::parse($event->event_date)->isToday()) {
                                $eventClass = 'active';
                            } else {
                                $eventClass = 'completed';
                            }
                        } elseif ($event->type === 'followup') {
                            if ($event->due_date && \Carbon\Carbon::parse($event->due_date)->isFuture()) {
                                $eventClass = 'upcoming';
                            } else {
                                $eventClass = 'completed';
                            }
                        }
                    @endphp
                    <div class="timeline-event {{ $eventClass }}" onclick="expandEvent(this)">
                        <div class="event-header">
                            <h4 class="event-title">{{ $event->title }}</h4>
                            <span class="event-date">
                                @if($event->event_date)
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('M j') }}
                                @else
                                    {{ $event->created_at->format('M j') }}
                                @endif
                            </span>
                        </div>
                        <p class="event-description">
                            {{ $event->description ?? 'No description available' }}
                        </p>
                        <div class="event-details">
                            @php
                                $tags = [];
                                switch($event->type) {
                                    case 'interview':
                                        $tags[] = ucfirst($event->interview_type ?? 'Interview');
                                        if ($event->reminder) $tags[] = 'Reminder Set';
                                        break;
                                    case 'note':
                                        $tags[] = 'Note';
                                        $tags[] = 'Personal';
                                        break;
                                    case 'followup':
                                        $tags[] = 'Follow-up';
                                        if ($event->priority) $tags[] = ucfirst($event->priority);
                                        break;
                                    case 'rejected':
                                        $tags[] = 'Rejected';
                                        if ($event->reapply_future) $tags[] = 'Reapply Future';
                                        break;
                                }
                            @endphp
                            @foreach($tags as $tag)
                                <span class="event-tag">{{ $tag }}</span>
                            @endforeach
                            @if($event->event_time)
                                <span class="event-tag">{{ $event->event_time }}</span>
                            @endif
                        </div>
                        @if($event->notes || $event->feedback || $event->content)
                        <div class="event-notes">
                            {{ $event->notes ?? $event->feedback ?? $event->content }}
                        </div>
                        @endif
                    </div>
                    @endforeach

                    @if($application->events->count() === 0)
                    <!-- Show placeholder if no events exist -->
                    <div class="timeline-event upcoming">
                        <div class="event-header">
                            <h4 class="event-title">Ready to Track Progress</h4>
                            <span class="event-date">Start</span>
                        </div>
                        <p class="event-description">
                            Use the "Add Event" button to track interviews, notes, follow-ups, and application updates.
                        </p>
                        <div class="event-details">
                            <span class="event-tag">Getting Started</span>
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
                                        $size = \Illuminate\Support\Facades\Storage::disk('public')->size($application->resume_path);
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
                                        $size = \Illuminate\Support\Facades\Storage::disk('public')->size($application->cover_letter_path);
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
                    <button class="btn btn-secondary" onclick="showEditApplicationModal()">
                        Edit Application
                    </button>
                    @if($application->resume_path)
                    <button class="btn btn-secondary" onclick="showGenerateCoverLetterModal()">
                        Generate Cover Letter
                    </button>
                    <button class="btn btn-secondary" onclick="showResumeAnalysisModal()">
                        Analyze Resume
                    </button>
                    @endif
                    <button class="btn btn-primary" onclick="addEvent()">
                        Add Event
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Application Modal -->
    <x-edit-application-modal :application="$application" />

    <!-- Add Event Modal -->
    <div class="modal-overlay" id="addEventModalOverlay" style="display: none;">
        <div class="add-event-modal">
            <!-- Header -->
            <div class="modal-header">
                <h2 class="modal-title">Add to Timeline</h2>
                <button class="close-button" onclick="closeAddEventModal()" aria-label="Close modal">×</button>
            </div>

            <!-- Event Type Selector -->
            <div class="event-type-selector">
                <label class="selector-label">Event Type</label>
                <div class="type-buttons">
                    <button class="type-button active" data-type="interview" onclick="selectEventType('interview')">
                        Interview
                    </button>
                    <button class="type-button" data-type="note" onclick="selectEventType('note')">
                        Note
                    </button>
                    <button class="type-button" data-type="followup" onclick="selectEventType('followup')">
                        Follow-up
                    </button>
                    <button class="type-button" data-type="rejected" onclick="selectEventType('rejected')">
                        Rejected
                    </button>
                </div>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <!-- Interview Form -->
                <form class="form-content active" id="interviewForm">
                    <div class="form-group">
                        <label class="form-label">Interview Title</label>
                        <input type="text" class="form-input" name="title" placeholder="e.g., Technical Interview with Engineering Team" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="datetime-group">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-input" name="date" required>
                        </div>
                        <div class="datetime-group">
                            <label class="form-label">Time</label>
                            <input type="time" class="form-input" name="time" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Interview Type</label>
                        <select class="form-select" name="interview_type" required>
                            <option value="">Select interview type</option>
                            <option value="phone">Phone Screen</option>
                            <option value="video">Video Interview</option>
                            <option value="onsite">On-site Interview</option>
                            <option value="technical">Technical Interview</option>
                            <option value="final">Final Round</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Notes (Optional)</label>
                        <textarea class="form-textarea" name="notes" placeholder="Add any preparation notes or details about the interview..."></textarea>
                        
                        <div class="checkbox-group">
                            <input type="checkbox" class="checkbox" name="reminder" id="interviewReminder">
                            <label for="interviewReminder" class="checkbox-label">Set reminder 1 hour before</label>
                        </div>
                    </div>
                </form>

                <!-- Note Form -->
                <form class="form-content" id="noteForm">
                    <div class="form-group">
                        <label class="form-label">Note Title</label>
                        <input type="text" class="form-input" name="title" placeholder="e.g., Research on company culture" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Note Content</label>
                        <textarea class="form-textarea large" name="content" placeholder="Write your note here... This could be research findings, interview feedback, company insights, or any other relevant information." required></textarea>
                    </div>
                    
                    <div class="quick-actions">
                        <button type="button" class="quick-btn" onclick="insertQuickText('📞 Called HR department')">📞 Call</button>
                        <button type="button" class="quick-btn" onclick="insertQuickText('✉️ Sent follow-up email')">✉️ Email</button>
                        <button type="button" class="quick-btn" onclick="insertQuickText('🔍 Researched company')">🔍 Research</button>
                    </div>
                </form>

                <!-- Follow-up Form -->
                <form class="form-content" id="followupForm">
                    <div class="form-group">
                        <label class="form-label">Follow-up Action</label>
                        <select class="form-select" name="action" required>
                            <option value="">Select follow-up type</option>
                            <option value="email">Send Thank You Email</option>
                            <option value="status">Check Application Status</option>
                            <option value="portfolio">Submit Additional Portfolio</option>
                            <option value="references">Provide References</option>
                            <option value="salary">Discuss Salary Expectations</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div class="form-row">
                        <div class="datetime-group">
                            <label class="form-label">Due Date</label>
                            <input type="date" class="form-input" name="due_date" required>
                        </div>
                        <div class="datetime-group">
                            <label class="form-label">Priority</label>
                            <select class="form-select" name="priority" required>
                                <option value="">Select priority</option>
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Details</label>
                        <textarea class="form-textarea" name="details" placeholder="Describe what needs to be done and any specific requirements..." required></textarea>
                        
                        <div class="checkbox-group">
                            <input type="checkbox" class="checkbox" name="reminder" id="followupReminder">
                            <label for="followupReminder" class="checkbox-label">Set reminder for due date</label>
                        </div>
                    </div>
                </form>

                <!-- Rejected Form -->
                <form class="form-content" id="rejectedForm">
                    <div class="form-group">
                        <label class="form-label">Rejection Reason</label>
                        <select class="form-select" name="reason" required>
                            <option value="">Select reason</option>
                            <option value="position_filled">Position was filled</option>
                            <option value="qualifications">Not qualified for the role</option>
                            <option value="experience">Insufficient experience</option>
                            <option value="cultural_fit">Not a cultural fit</option>
                            <option value="salary_expectations">Salary expectations mismatch</option>
                            <option value="location">Location requirements</option>
                            <option value="other">Other reason</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Date Rejected</label>
                        <input type="date" class="form-input" name="rejection_date" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Feedback Received (Optional)</label>
                        <textarea class="form-textarea" name="feedback" placeholder="Any feedback or details provided by the company about the rejection..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Notes & Lessons Learned (Optional)</label>
                        <textarea class="form-textarea" name="notes" placeholder="What did you learn from this experience? Any areas for improvement..."></textarea>
                        
                        <div class="checkbox-group">
                            <input type="checkbox" class="checkbox" name="reapply_future" id="reapplyFuture">
                            <label for="reapplyFuture" class="checkbox-label">Open to reapplying in the future</label>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Actions -->
            <div class="modal-actions">
                <button class="btn btn-cancel" onclick="closeAddEventModal()">
                    Cancel
                </button>
                <button class="btn btn-primary" onclick="saveEvent()" id="saveButton">
                    Add to Timeline
                </button>
            </div>
        </div>
    </div>

    <!-- Generate Cover Letter Modal -->
    <div class="modal-overlay" id="generateCoverLetterModalOverlay" style="display: none;">
        <div class="add-event-modal" style="max-width: 700px;">
            <!-- Header -->
            <div class="modal-header">
                <h2 class="modal-title">🤖 Generate AI Cover Letter</h2>
                <button class="close-button" onclick="closeGenerateCoverLetterModal()" aria-label="Close modal">×</button>
            </div>

            <!-- Form Container -->
            <div class="form-container" style="max-height: 60vh;">
                <form id="generateCoverLetterForm">
                    <div class="form-group">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                            <label class="form-label" style="margin: 0;">Resume Content</label>
                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; color: #6b7c6d; cursor: pointer;">
                                    <input type="checkbox" id="useAttachedResume" checked style="margin: 0;">
                                    Use attached resume
                                </label>
                                <button type="button" id="extractResumeBtn" class="btn" 
                                        style="padding: 0.4rem 0.8rem; font-size: 0.8rem; background: rgba(255, 255, 255, 0.7);"
                                        onclick="extractResumeText()">
                                    📄 Extract Text
                                </button>
                            </div>
                        </div>
                        <textarea class="form-textarea large" name="resume_content" id="resumeContent" 
                                placeholder="Extracting text from attached resume..." 
                                style="min-height: 200px;"></textarea>
                        <div style="margin-top: 0.5rem;">
                            <small id="resumeHint" style="color: #6b7c6d; font-size: 0.8rem;">
                                🤖 Automatically extracting text from your attached resume file...
                            </small>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Additional Information (Optional)</label>
                        <textarea class="form-textarea" name="additional_info" id="additionalInfo" 
                                placeholder="Add any specific details you want to highlight for this position..." 
                                style="min-height: 100px;"></textarea>
                        <div style="margin-top: 0.5rem;">
                            <small style="color: #6b7c6d; font-size: 0.8rem;">
                                Examples: Why you're interested in this company, specific achievements, or personal motivation for this role.
                            </small>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Generated Cover Letter Display -->
            <div id="generatedCoverLetterSection" style="display: none; margin-top: 2rem;">
                <div style="border-top: 1px solid rgba(255, 255, 255, 0.2); padding-top: 2rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <h3 style="font-size: 1.2rem; font-weight: 600; color: #2d3e2e; margin: 0;">Generated Cover Letter</h3>
                        <button type="button" class="btn" style="padding: 0.5rem 1rem; font-size: 0.9rem;" onclick="copyCoverLetter()">
                            📋 Copy
                        </button>
                    </div>
                    <div style="background: rgba(255, 255, 255, 0.3); border-radius: 12px; padding: 1.5rem; max-height: 300px; overflow-y: auto;">
                        <pre id="coverLetterContent" style="white-space: pre-wrap; font-family: 'Inter', sans-serif; font-size: 0.9rem; line-height: 1.6; color: #2d3e2e; margin: 0;"></pre>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="modal-actions">
                <button class="btn btn-cancel" onclick="closeGenerateCoverLetterModal()">
                    Close
                </button>
                <button class="btn btn-primary" onclick="generateCoverLetter()" id="generateButton">
                    🤖 Generate Cover Letter
                </button>
            </div>
        </div>
    </div>

    <!-- Resume Analysis Modal -->
    <div class="modal-overlay" id="resumeAnalysisModalOverlay" style="display: none;">
        <div class="add-event-modal" style="max-width: 900px;">
            <!-- Header -->
            <div class="modal-header">
                <h2 class="modal-title">🔍 AI Resume Analysis</h2>
                <button class="close-button" onclick="closeResumeAnalysisModal()" aria-label="Close modal">×</button>
            </div>

            <!-- Analysis Results Container -->
            <div class="form-container" style="max-height: 70vh;">
                <!-- Loading State -->
                <div id="analysisLoading" style="text-align: center; padding: 2rem;">
                    <div style="font-size: 2rem; margin-bottom: 1rem;">🤖</div>
                    <h3 style="color: #2d3e2e; margin-bottom: 0.5rem;">Analyzing Your Resume...</h3>
                    <p style="color: #6b7c6d;">This may take a moment while our AI reviews your resume against the job requirements.</p>
                </div>

                <!-- Analysis Results -->
                <div id="analysisResults" style="display: none;">
                    <!-- Overall Score Section -->
                    <div class="analysis-section" style="margin-bottom: 2rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <h3 style="color: #2d3e2e; margin: 0;">Overall Assessment</h3>
                            <div id="aiProviderBadge" style="background: rgba(255, 107, 107, 0.1); color: #ff6b6b; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;"></div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                            <div class="score-card">
                                <div class="score-label">Overall Score</div>
                                <div class="score-value" id="overallScore">--</div>
                            </div>
                            <div class="score-card">
                                <div class="score-label">Job Match</div>
                                <div class="score-value" id="matchPercentage">--%</div>
                            </div>
                        </div>
                        <div class="score-card" style="margin-bottom: 1rem;">
                            <div class="score-label">ATS Optimization Score</div>
                            <div class="score-value" id="atsScore">--</div>
                        </div>
                    </div>

                    <!-- Strengths Section -->
                    <div class="analysis-section" style="margin-bottom: 2rem;">
                        <h4 style="color: #2d3e2e; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;"><span style="color: #34a853;">✅</span> Key Strengths</h4>
                        <ul id="strengthsList" class="analysis-list strengths-list"></ul>
                    </div>

                    <!-- Areas for Improvement -->
                    <div class="analysis-section" style="margin-bottom: 2rem;">
                        <h4 style="color: #2d3e2e; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;"><span style="color: #ff6b6b;">⚠️</span> Areas for Improvement</h4>
                        <ul id="weaknessesList" class="analysis-list weaknesses-list"></ul>
                    </div>

                    <!-- Missing Keywords -->
                    <div class="analysis-section" style="margin-bottom: 2rem;">
                        <h4 style="color: #2d3e2e; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;"><span style="color: #ffa726;">🔑</span> Missing Keywords</h4>
                        <div id="keywordsList" class="keywords-container"></div>
                    </div>

                    <!-- Improvement Suggestions -->
                    <div class="analysis-section" style="margin-bottom: 2rem;">
                        <h4 style="color: #2d3e2e; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;"><span style="color: #4285f4;">💡</span> Improvement Suggestions</h4>
                        <div id="suggestionsList" class="suggestions-container"></div>
                    </div>

                    <!-- Key Recommendations -->
                    <div class="analysis-section">
                        <h4 style="color: #2d3e2e; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;"><span style="color: #9c27b0;">🎯</span> Key Recommendations</h4>
                        <ul id="recommendationsList" class="analysis-list recommendations-list"></ul>
                    </div>
                </div>

                <!-- Error State -->
                <div id="analysisError" style="display: none; text-align: center; padding: 2rem;">
                    <div style="font-size: 2rem; margin-bottom: 1rem;">❌</div>
                    <h3 style="color: #ea4335; margin-bottom: 0.5rem;">Analysis Failed</h3>
                    <p id="errorMessage" style="color: #6b7c6d;"></p>
                </div>
            </div>

            <!-- Actions -->
            <div class="modal-actions">
                <button class="btn btn-cancel" onclick="closeResumeAnalysisModal()">
                    Close
                </button>
                <button class="btn btn-primary" onclick="analyzeResume()" id="analyzeButton">
                    Analyze Resume
                </button>
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

        // Add Event Modal Functionality
        let currentEventType = 'interview';

        function addEvent() {
            console.log('Opening add event modal...');
            showAddEventModal();
        }

        function showAddEventModal() {
            const modal = document.getElementById('addEventModalOverlay');
            modal.style.display = 'flex';
            
            // Set default date to today
            const today = new Date().toISOString().split('T')[0];
            document.querySelectorAll('#addEventModalOverlay input[type="date"]').forEach(input => {
                if (!input.value) input.value = today;
            });
            
            // Set default time to next hour
            const nextHour = new Date();
            nextHour.setHours(nextHour.getHours() + 1, 0, 0, 0);
            const timeString = nextHour.toTimeString().slice(0, 5);
            document.querySelectorAll('#addEventModalOverlay input[type="time"]').forEach(input => {
                if (!input.value) input.value = timeString;
            });
            
            // Auto-focus first input
            setTimeout(() => {
                const firstInput = document.querySelector('#addEventModalOverlay .form-content.active .form-input');
                if (firstInput) firstInput.focus();
            }, 500);
        }

        function closeAddEventModal() {
            const modal = document.getElementById('addEventModalOverlay');
            modal.style.animation = 'overlayFadeOut 0.3s cubic-bezier(0.23, 1, 0.32, 1) forwards';
            
            setTimeout(() => {
                modal.style.display = 'none';
                modal.style.animation = '';
                resetAddEventForm();
            }, 300);
        }

        function resetAddEventForm() {
            // Reset to interview form
            currentEventType = 'interview';
            document.querySelectorAll('.type-button').forEach(btn => {
                btn.classList.remove('active');
            });
            document.querySelector('[data-type="interview"]').classList.add('active');
            
            // Reset forms
            document.querySelectorAll('.form-content').forEach(form => {
                form.classList.remove('active');
                form.reset();
            });
            document.getElementById('interviewForm').classList.add('active');
            
            // Reset button text
            document.getElementById('saveButton').textContent = 'Add Interview';
        }

        function selectEventType(type) {
            currentEventType = type;
            
            // Update active button
            document.querySelectorAll('.type-button').forEach(btn => {
                btn.classList.remove('active');
            });
            document.querySelector(`[data-type="${type}"]`).classList.add('active');
            
            // Hide all forms
            document.querySelectorAll('.form-content').forEach(form => {
                form.classList.remove('active');
            });
            
            // Show selected form
            const formMap = {
                'interview': 'interviewForm',
                'note': 'noteForm',
                'followup': 'followupForm',
                'rejected': 'rejectedForm'
            };
            
            document.getElementById(formMap[type]).classList.add('active');
            
            // Update button text
            const saveButton = document.getElementById('saveButton');
            const buttonTextMap = {
                'interview': 'Add Interview',
                'note': 'Add Note',
                'followup': 'Add Follow-up',
                'rejected': 'Add Rejection'
            };
            saveButton.textContent = buttonTextMap[type];
            
            // Focus first input
            setTimeout(() => {
                const activeForm = document.querySelector('.form-content.active');
                const firstInput = activeForm.querySelector('.form-input, .form-textarea');
                if (firstInput) firstInput.focus();
            }, 100);
        }

        function insertQuickText(text) {
            const textarea = document.querySelector('#noteForm .form-textarea');
            const currentValue = textarea.value;
            const newValue = currentValue ? `${currentValue}\n\n${text}` : text;
            textarea.value = newValue;
            textarea.focus();
            
            // Position cursor at end
            textarea.setSelectionRange(textarea.value.length, textarea.value.length);
        }

        function saveEvent() {
            const activeForm = document.querySelector('.form-content.active');
            const formData = new FormData(activeForm);
            const saveButton = document.getElementById('saveButton');
            
            // Basic validation
            const requiredFields = activeForm.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = '#ea4335';
                    field.focus();
                    
                    setTimeout(() => {
                        field.style.borderColor = '';
                    }, 2000);
                }
            });
            
            if (!isValid) {
                // Shake animation for invalid form
                activeForm.style.animation = 'shake 0.5s ease-in-out';
                setTimeout(() => {
                    activeForm.style.animation = '';
                }, 500);
                return;
            }
            
            // Add loading state
            activeForm.classList.add('loading');
            saveButton.textContent = 'Adding...';
            
            // Prepare data for backend
            const eventData = {
                type: currentEventType,
                application_id: {{ $application->id }},
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };
            
            // Add form data to eventData
            for (let [key, value] of formData.entries()) {
                eventData[key] = value;
            }
            
            // Make AJAX request to save event
            fetch('/applications/{{ $application->id }}/events', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': eventData._token
                },
                body: JSON.stringify(eventData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add event to timeline visually
                    addEventToTimeline(currentEventType, eventData);
                    
                    // If this was a rejected event, update the status badge and refresh the page
                    if (currentEventType === 'rejected' && data.data.application_status) {
                        // Update the status badge immediately
                        const statusBadge = document.querySelector('.status-badge');
                        if (statusBadge) {
                            statusBadge.textContent = 'Rejected';
                            statusBadge.className = 'status-badge rejected';
                        }
                        
                        // Success animation
                        saveButton.textContent = 'Application Rejected!';
                        saveButton.style.background = 'linear-gradient(135deg, #34a853 0%, #2e7d32 100%)';
                        
                        setTimeout(() => {
                            closeAddEventModal();
                            // Refresh the page to show updated status throughout
                            window.location.reload();
                        }, 1200);
                    } else {
                        // Success animation for other event types
                        saveButton.textContent = 'Added!';
                        saveButton.style.background = 'linear-gradient(135deg, #34a853 0%, #2e7d32 100%)';
                        
                        setTimeout(() => {
                            closeAddEventModal();
                        }, 800);
                    }
                } else {
                    // Handle error
                    activeForm.classList.remove('loading');
                    saveButton.textContent = 'Error - Try Again';
                    saveButton.style.background = 'linear-gradient(135deg, #ea4335 0%, #d32f2f 100%)';
                    
                    setTimeout(() => {
                        saveButton.textContent = buttonTextMap[currentEventType] || 'Add to Timeline';
                        saveButton.style.background = '';
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Fallback: still add to timeline visually
                addEventToTimeline(currentEventType, eventData);
                
                // For rejected events, still update the UI even if there was an error
                if (currentEventType === 'rejected') {
                    // Update the status badge
                    const statusBadge = document.querySelector('.status-badge');
                    if (statusBadge) {
                        statusBadge.textContent = 'Rejected';
                        statusBadge.className = 'status-badge rejected';
                    }
                    
                    saveButton.textContent = 'Application Rejected!';
                    saveButton.style.background = 'linear-gradient(135deg, #34a853 0%, #2e7d32 100%)';
                    
                    setTimeout(() => {
                        closeAddEventModal();
                        window.location.reload();
                    }, 1200);
                } else {
                    // Success animation for other event types
                    saveButton.textContent = 'Added!';
                    saveButton.style.background = 'linear-gradient(135deg, #34a853 0%, #2e7d32 100%)';
                    
                    setTimeout(() => {
                        closeAddEventModal();
                    }, 800);
                }
            });
        }

        function addEventToTimeline(eventType, formData) {
            const timeline = document.querySelector('.timeline');
            const eventData = extractEventData(eventType, formData);
            
            // Create new timeline event
            const newEvent = document.createElement('div');
            newEvent.className = 'timeline-event upcoming';
            newEvent.onclick = function() { expandEvent(this); };
            
            newEvent.innerHTML = `
                <div class="event-header">
                    <h4 class="event-title">${eventData.title}</h4>
                    <span class="event-date">${eventData.date}</span>
                </div>
                <p class="event-description">
                    ${eventData.description}
                </p>
                <div class="event-details">
                    ${eventData.tags.map(tag => `<span class="event-tag">${tag}</span>`).join('')}
                </div>
                ${eventData.notes ? `<div class="event-notes">${eventData.notes}</div>` : ''}
            `;
            
            // Add to timeline (insert before existing upcoming events or at the end)
            const upcomingEvents = timeline.querySelectorAll('.timeline-event.upcoming');
            if (upcomingEvents.length > 0) {
                timeline.insertBefore(newEvent, upcomingEvents[0]);
            } else {
                timeline.appendChild(newEvent);
            }
            
            // Animate the new event
            newEvent.style.opacity = '0';
            newEvent.style.transform = 'translateX(-30px)';
            
            setTimeout(() => {
                newEvent.style.transition = 'all 0.6s cubic-bezier(0.23, 1, 0.32, 1)';
                newEvent.style.opacity = '1';
                newEvent.style.transform = 'translateX(0)';
            }, 100);
        }

        function extractEventData(eventType, formData) {
            const data = {
                title: '',
                description: '',
                date: '',
                tags: [],
                notes: ''
            };
            
            if (eventType === 'interview') {
                const title = formData.title || 'New Interview';
                const interviewType = formData.interview_type || 'Interview';
                const dateInput = formData.date;
                const timeInput = formData.time;
                const notes = formData.notes || '';
                
                data.title = title;
                data.description = `${interviewType.charAt(0).toUpperCase() + interviewType.slice(1)} scheduled`;
                data.date = formatEventDate(dateInput);
                data.tags = [interviewType.charAt(0).toUpperCase() + interviewType.slice(1), timeInput ? `${timeInput}` : 'Scheduled'];
                data.notes = notes;
            } else if (eventType === 'note') {
                const title = formData.title || 'New Note';
                const content = formData.content || '';
                
                data.title = title;
                data.description = content.substring(0, 100) + (content.length > 100 ? '...' : '');
                data.date = formatEventDate(new Date().toISOString().split('T')[0]);
                data.tags = ['Note', 'Personal'];
                data.notes = content.length > 100 ? content : '';
            } else if (eventType === 'followup') {
                const action = formData.action || 'Follow-up Action';
                const dueDate = formData.due_date;
                const priority = formData.priority || 'medium';
                const details = formData.details || '';
                
                data.title = action.charAt(0).toUpperCase() + action.slice(1);
                data.description = `${priority.charAt(0).toUpperCase() + priority.slice(1)} priority follow-up task`;
                data.date = formatEventDate(dueDate);
                data.tags = ['Follow-up', priority.charAt(0).toUpperCase() + priority.slice(1)];
                data.notes = details;
            } else if (eventType === 'rejected') {
                const reason = formData.reason || 'Application Rejected';
                const rejectionDate = formData.rejection_date;
                const feedback = formData.feedback || '';
                const notes = formData.notes || '';
                const reapply = formData.reapply_future ? 'Reapply Future' : '';
                
                data.title = 'Application Rejected';
                data.description = reason.replace('_', ' ').charAt(0).toUpperCase() + reason.replace('_', ' ').slice(1);
                data.date = formatEventDate(rejectionDate);
                data.tags = ['Rejected', reapply].filter(tag => tag);
                data.notes = feedback || notes;
            }
            
            return data;
        }

        function formatEventDate(dateString) {
            if (!dateString) return 'TBD';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
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

        // Cover Letter Generation Modal Functions
        function showGenerateCoverLetterModal() {
            const modal = document.getElementById('generateCoverLetterModalOverlay');
            modal.style.display = 'flex';
            
            // Reset form
            document.getElementById('generateCoverLetterForm').reset();
            document.getElementById('generatedCoverLetterSection').style.display = 'none';
            document.getElementById('generateButton').textContent = '🤖 Generate Cover Letter';
            document.getElementById('generateButton').style.background = '';
            
            // Check the "Use attached resume" checkbox by default
            document.getElementById('useAttachedResume').checked = true;
            
            // Add event listener for the checkbox
            document.getElementById('useAttachedResume').addEventListener('change', function() {
                if (this.checked) {
                    extractResumeText();
                } else {
                    const resumeTextarea = document.getElementById('resumeContent');
                    const resumeHint = document.getElementById('resumeHint');
                    resumeTextarea.placeholder = 'Paste your resume content here or key skills and experiences...';
                    resumeTextarea.readOnly = false;
                    resumeTextarea.value = '';
                    resumeHint.innerHTML = '💡 Tip: Copy and paste the text content of your resume, or highlight your key skills and experiences relevant to this position.';
                    setTimeout(() => resumeTextarea.focus(), 100);
                }
            });
            
            // Automatically extract resume text when modal opens
            setTimeout(() => {
                extractResumeText();
            }, 300);
        }

        function closeGenerateCoverLetterModal() {
            const modal = document.getElementById('generateCoverLetterModalOverlay');
            modal.style.animation = 'overlayFadeOut 0.3s cubic-bezier(0.23, 1, 0.32, 1) forwards';
            
            setTimeout(() => {
                modal.style.display = 'none';
                modal.style.animation = '';
            }, 300);
        }

        function extractResumeText() {
            const extractButton = document.getElementById('extractResumeBtn');
            const resumeTextarea = document.getElementById('resumeContent');
            const resumeHint = document.getElementById('resumeHint');
            const useAttachedCheckbox = document.getElementById('useAttachedResume');
            
            if (!useAttachedCheckbox.checked) {
                resumeTextarea.placeholder = 'Paste your resume content here or key skills and experiences...';
                resumeTextarea.readOnly = false;
                resumeHint.innerHTML = '💡 Tip: Copy and paste the text content of your resume, or highlight your key skills and experiences relevant to this position.';
                resumeTextarea.focus();
                return;
            }
            
            // Show loading state
            extractButton.textContent = '⏳ Extracting...';
            extractButton.disabled = true;
            resumeTextarea.placeholder = 'Extracting text from attached resume...';
            resumeTextarea.value = '';
            resumeTextarea.readOnly = true;
            resumeHint.innerHTML = '🤖 Processing your resume file...';
            
            // Make AJAX request to extract resume text
            fetch('/applications/{{ $application->id }}/extract-resume-text', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    resumeTextarea.value = data.resume_text;
                    resumeTextarea.readOnly = false;
                    resumeHint.innerHTML = `✅ Text extracted successfully! Preview: "${data.preview}"`;
                    extractButton.textContent = '✅ Extracted';
                    extractButton.style.background = 'linear-gradient(135deg, #34a853 0%, #2e7d32 100%)';
                    extractButton.style.color = 'white';
                } else {
                    resumeTextarea.placeholder = 'Failed to extract text. Please paste your resume content manually.';
                    resumeTextarea.readOnly = false;
                    resumeHint.innerHTML = `❌ ${data.message} Please paste your resume content manually.`;
                    extractButton.textContent = '❌ Failed';
                    extractButton.style.background = 'linear-gradient(135deg, #ea4335 0%, #d32f2f 100%)';
                    extractButton.style.color = 'white';
                    useAttachedCheckbox.checked = false;
                }
                
                setTimeout(() => {
                    extractButton.textContent = '📄 Extract Text';
                    extractButton.style.background = '';
                    extractButton.style.color = '';
                    extractButton.disabled = false;
                }, 2000);
            })
            .catch(error => {
                console.error('Error:', error);
                resumeTextarea.placeholder = 'Error occurred. Please paste your resume content manually.';
                resumeTextarea.readOnly = false;
                resumeHint.innerHTML = '❌ Network error. Please paste your resume content manually.';
                extractButton.textContent = '❌ Error';
                extractButton.style.background = 'linear-gradient(135deg, #ea4335 0%, #d32f2f 100%)';
                extractButton.style.color = 'white';
                useAttachedCheckbox.checked = false;
                
                setTimeout(() => {
                    extractButton.textContent = '📄 Extract Text';
                    extractButton.style.background = '';
                    extractButton.style.color = '';
                    extractButton.disabled = false;
                }, 2000);
            });
        }

        function generateCoverLetter() {
            const form = document.getElementById('generateCoverLetterForm');
            const formData = new FormData(form);
            const generateButton = document.getElementById('generateButton');
            const resumeContent = document.getElementById('resumeContent').value.trim();
            const useAttachedResume = document.getElementById('useAttachedResume').checked;
            
            // Validate required fields only if not using attached resume or if extraction failed
            if (!resumeContent && (!useAttachedResume || document.getElementById('resumeContent').readOnly)) {
                document.getElementById('resumeContent').style.borderColor = '#ea4335';
                document.getElementById('resumeContent').focus();
                
                setTimeout(() => {
                    document.getElementById('resumeContent').style.borderColor = '';
                }, 2000);
                return;
            }
            
            // Add loading state
            generateButton.textContent = '🤖 Generating...';
            generateButton.disabled = true;
            
            // Prepare data for backend
            const coverLetterData = {
                resume_content: resumeContent,
                additional_info: document.getElementById('additionalInfo').value.trim(),
                use_attached_resume: useAttachedResume,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };
            
            // Make AJAX request to generate cover letter
            fetch('/applications/{{ $application->id }}/generate-cover-letter', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': coverLetterData._token
                },
                body: JSON.stringify(coverLetterData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Display the generated cover letter
                    document.getElementById('coverLetterContent').textContent = data.cover_letter;
                    document.getElementById('generatedCoverLetterSection').style.display = 'block';
                    
                    // Success state
                    let successText = '✅ Generated!';
                    if (data.used_attached_resume) {
                        successText = '✅ Generated from Resume!';
                    }
                    if (data.ai_available && data.ai_provider && data.ai_provider !== 'fallback') {
                        successText = `🤖 Generated with ${data.ai_provider.toUpperCase()}!`;
                    }
                    generateButton.textContent = successText;
                    generateButton.style.background = 'linear-gradient(135deg, #34a853 0%, #2e7d32 100%)';
                    
                    // Scroll to show the generated content
                    document.getElementById('generatedCoverLetterSection').scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'start' 
                    });
                    
                    setTimeout(() => {
                        generateButton.textContent = '🔄 Regenerate';
                        generateButton.style.background = '';
                        generateButton.disabled = false;
                    }, 2000);
                } else {
                    // Handle error
                    generateButton.textContent = 'Error - Try Again';
                    generateButton.style.background = 'linear-gradient(135deg, #ea4335 0%, #d32f2f 100%)';
                    
                    setTimeout(() => {
                        generateButton.textContent = '🤖 Generate Cover Letter';
                        generateButton.style.background = '';
                        generateButton.disabled = false;
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                generateButton.textContent = 'Error - Try Again';
                generateButton.style.background = 'linear-gradient(135deg, #ea4335 0%, #d32f2f 100%)';
                
                setTimeout(() => {
                    generateButton.textContent = '🤖 Generate Cover Letter';
                    generateButton.style.background = '';
                    generateButton.disabled = false;
                }, 3000);
            });
        }

        function copyCoverLetter() {
            const coverLetterText = document.getElementById('coverLetterContent').textContent;
            
            if (navigator.clipboard && window.isSecureContext) {
                // Use the Clipboard API
                navigator.clipboard.writeText(coverLetterText).then(() => {
                    showCopyFeedback();
                }).catch(() => {
                    fallbackCopyTextToClipboard(coverLetterText);
                });
            } else {
                // Fallback for older browsers
                fallbackCopyTextToClipboard(coverLetterText);
            }
        }

        function fallbackCopyTextToClipboard(text) {
            const textArea = document.createElement("textarea");
            textArea.value = text;
            textArea.style.top = "0";
            textArea.style.left = "0";
            textArea.style.position = "fixed";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            
            try {
                document.execCommand('copy');
                showCopyFeedback();
            } catch (err) {
                console.error('Fallback: Oops, unable to copy', err);
            }
            
            document.body.removeChild(textArea);
        }

        function showCopyFeedback() {
            const copyButton = document.querySelector('button[onclick="copyCoverLetter()"]');
            const originalText = copyButton.textContent;
            
            copyButton.textContent = '✅ Copied!';
            copyButton.style.background = 'linear-gradient(135deg, #34a853 0%, #2e7d32 100%)';
            copyButton.style.color = 'white';
            
            setTimeout(() => {
                copyButton.textContent = originalText;
                copyButton.style.background = '';
                copyButton.style.color = '';
            }, 2000);
        }

        // Resume Analysis Modal Functions
        function showResumeAnalysisModal() {
            const modal = document.getElementById('resumeAnalysisModalOverlay');
            modal.style.display = 'flex';
            
            // Reset modal state
            document.getElementById('analysisLoading').style.display = 'block';
            document.getElementById('analysisResults').style.display = 'none';
            document.getElementById('analysisError').style.display = 'none';
            document.getElementById('analyzeButton').textContent = '🔍 Analyze Resume';
            document.getElementById('analyzeButton').style.background = '';
            
            // Auto-start analysis
            setTimeout(() => {
                analyzeResume();
            }, 500);
        }

        function closeResumeAnalysisModal() {
            const modal = document.getElementById('resumeAnalysisModalOverlay');
            modal.style.animation = 'overlayFadeOut 0.3s cubic-bezier(0.23, 1, 0.32, 1) forwards';
            
            setTimeout(() => {
                modal.style.display = 'none';
                modal.style.animation = '';
            }, 300);
        }

        function analyzeResume() {
            const analyzeButton = document.getElementById('analyzeButton');
            
            // Show loading state
            document.getElementById('analysisLoading').style.display = 'block';
            document.getElementById('analysisResults').style.display = 'none';
            document.getElementById('analysisError').style.display = 'none';
            analyzeButton.textContent = '🤖 Analyzing...';
            analyzeButton.disabled = true;
            
            // Make AJAX request to analyze resume
            fetch('/applications/{{ $application->id }}/analyze-resume', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayAnalysisResults(data.analysis, data.ai_provider, data.ai_available);
                    
                    // Success state
                    analyzeButton.textContent = data.ai_available 
                        ? `🤖 Analyzed with ${data.ai_provider.toUpperCase()}!`
                        : '✅ Analysis Complete!';
                    analyzeButton.style.background = 'linear-gradient(135deg, #34a853 0%, #2e7d32 100%)';
                    
                    setTimeout(() => {
                        analyzeButton.textContent = '🔄 Re-analyze';
                        analyzeButton.style.background = '';
                        analyzeButton.disabled = false;
                    }, 2000);
                } else {
                    // Show error
                    document.getElementById('analysisLoading').style.display = 'none';
                    document.getElementById('analysisError').style.display = 'block';
                    document.getElementById('errorMessage').textContent = data.message;
                    
                    analyzeButton.textContent = 'Error - Try Again';
                    analyzeButton.style.background = 'linear-gradient(135deg, #ea4335 0%, #d32f2f 100%)';
                    
                    setTimeout(() => {
                        analyzeButton.textContent = '🔍 Analyze Resume';
                        analyzeButton.style.background = '';
                        analyzeButton.disabled = false;
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Show error
                document.getElementById('analysisLoading').style.display = 'none';
                document.getElementById('analysisError').style.display = 'block';
                document.getElementById('errorMessage').textContent = 'Network error occurred. Please try again.';
                
                analyzeButton.textContent = 'Error - Try Again';
                analyzeButton.style.background = 'linear-gradient(135deg, #ea4335 0%, #d32f2f 100%)';
                
                setTimeout(() => {
                    analyzeButton.textContent = '🔍 Analyze Resume';
                    analyzeButton.style.background = '';
                    analyzeButton.disabled = false;
                }, 3000);
            });
        }

        function displayAnalysisResults(analysis, aiProvider, aiAvailable) {
            // Hide loading, show results
            document.getElementById('analysisLoading').style.display = 'none';
            document.getElementById('analysisResults').style.display = 'block';
            
            // Update AI provider badge
            const providerBadge = document.getElementById('aiProviderBadge');
            if (aiAvailable && aiProvider !== 'fallback') {
                providerBadge.textContent = `Powered by ${aiProvider.toUpperCase()}`;
                providerBadge.style.background = 'rgba(52, 168, 83, 0.1)';
                providerBadge.style.color = '#34a853';
            } else {
                providerBadge.textContent = 'Basic Analysis';
                providerBadge.style.background = 'rgba(107, 124, 109, 0.1)';
                providerBadge.style.color = '#6b7c6d';
            }
            
            // Update scores
            document.getElementById('overallScore').textContent = analysis.overall_score || '--';
            document.getElementById('matchPercentage').textContent = (analysis.match_percentage || '--') + '%';
            document.getElementById('atsScore').textContent = analysis.ats_optimization?.score || '--';
            
            // Update strengths
            const strengthsList = document.getElementById('strengthsList');
            strengthsList.innerHTML = '';
            if (analysis.strengths && analysis.strengths.length > 0) {
                analysis.strengths.forEach(strength => {
                    const li = document.createElement('li');
                    li.textContent = strength;
                    strengthsList.appendChild(li);
                });
            } else {
                const li = document.createElement('li');
                li.textContent = 'No specific strengths identified.';
                li.style.opacity = '0.7';
                strengthsList.appendChild(li);
            }
            
            // Update weaknesses
            const weaknessesList = document.getElementById('weaknessesList');
            weaknessesList.innerHTML = '';
            if (analysis.weaknesses && analysis.weaknesses.length > 0) {
                analysis.weaknesses.forEach(weakness => {
                    const li = document.createElement('li');
                    li.textContent = weakness;
                    weaknessesList.appendChild(li);
                });
            } else {
                const li = document.createElement('li');
                li.textContent = 'No specific areas for improvement identified.';
                li.style.opacity = '0.7';
                weaknessesList.appendChild(li);
            }
            
            // Update missing keywords
            const keywordsList = document.getElementById('keywordsList');
            keywordsList.innerHTML = '';
            if (analysis.missing_keywords && analysis.missing_keywords.length > 0) {
                analysis.missing_keywords.forEach(keyword => {
                    const span = document.createElement('span');
                    span.className = 'keyword-tag';
                    span.textContent = keyword;
                    keywordsList.appendChild(span);
                });
            } else {
                const span = document.createElement('span');
                span.style.color = '#6b7c6d';
                span.style.fontStyle = 'italic';
                span.textContent = 'No missing keywords identified.';
                keywordsList.appendChild(span);
            }
            
            // Update improvement suggestions
            const suggestionsList = document.getElementById('suggestionsList');
            suggestionsList.innerHTML = '';
            if (analysis.improvement_suggestions && analysis.improvement_suggestions.length > 0) {
                analysis.improvement_suggestions.forEach(suggestion => {
                    const card = document.createElement('div');
                    card.className = 'suggestion-card';
                    
                    card.innerHTML = `
                        <div class="suggestion-header">
                            <span class="suggestion-category">${suggestion.category || 'General'}</span>
                            <span class="suggestion-priority ${(suggestion.priority || 'medium').toLowerCase()}">${suggestion.priority || 'Medium'}</span>
                        </div>
                        <div class="suggestion-text">${suggestion.suggestion || ''}</div>
                        <div class="suggestion-impact">${suggestion.impact || ''}</div>
                    `;
                    
                    suggestionsList.appendChild(card);
                });
            } else {
                const card = document.createElement('div');
                card.style.color = '#6b7c6d';
                card.style.fontStyle = 'italic';
                card.textContent = 'No specific suggestions available.';
                suggestionsList.appendChild(card);
            }
            
            // Update key recommendations
            const recommendationsList = document.getElementById('recommendationsList');
            recommendationsList.innerHTML = '';
            if (analysis.key_recommendations && analysis.key_recommendations.length > 0) {
                analysis.key_recommendations.forEach(recommendation => {
                    const li = document.createElement('li');
                    li.textContent = recommendation;
                    recommendationsList.appendChild(li);
                });
            } else {
                const li = document.createElement('li');
                li.textContent = 'No specific recommendations available.';
                li.style.opacity = '0.7';
                recommendationsList.appendChild(li);
            }
            
            // Scroll to top of results
            document.getElementById('analysisResults').scrollTop = 0;
        }

        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            const addEventModal = document.getElementById('addEventModalOverlay');
            const coverLetterModal = document.getElementById('generateCoverLetterModalOverlay');
            const resumeAnalysisModal = document.getElementById('resumeAnalysisModalOverlay');
            
            if (addEventModal && addEventModal.style.display === 'flex') {
                // Add Event Modal is open
                if (e.key === 'Escape') {
                    closeAddEventModal();
                } else if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) {
                    e.preventDefault();
                    saveEvent();
                } else if (e.key === '1' && e.altKey) {
                    e.preventDefault();
                    selectEventType('interview');
                } else if (e.key === '2' && e.altKey) {
                    e.preventDefault();
                    selectEventType('note');
                } else if (e.key === '3' && e.altKey) {
                    e.preventDefault();
                    selectEventType('followup');
                }
            } else if (coverLetterModal && coverLetterModal.style.display === 'flex') {
                // Cover Letter Modal is open
                if (e.key === 'Escape') {
                    closeGenerateCoverLetterModal();
                } else if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) {
                    e.preventDefault();
                    generateCoverLetter();
                }
            } else if (resumeAnalysisModal && resumeAnalysisModal.style.display === 'flex') {
                // Resume Analysis Modal is open
                if (e.key === 'Escape') {
                    closeResumeAnalysisModal();
                } else if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) {
                    e.preventDefault();
                    analyzeResume();
                }
            } else {
                // No modal is open
                if (e.key === 'a' && e.ctrlKey) {
                    e.preventDefault();
                    addEvent();
                } else if (e.key === 'c' && e.ctrlKey && e.shiftKey) {
                    e.preventDefault();
                    @if($application->resume_path)
                    showGenerateCoverLetterModal();
                    @endif
                } else if (e.key === 'r' && e.ctrlKey && e.shiftKey) {
                    e.preventDefault();
                    @if($application->resume_path)
                    showResumeAnalysisModal();
                    @endif
                } else if (e.key === 'Escape') {
                    window.location.href = '{{ route("applications.index") }}';
                }
            }
        });
    </script>

    <x-slot name="scripts">
        <script>
            // Application detail specific JavaScript
        </script>
    </x-slot>
</x-layout>