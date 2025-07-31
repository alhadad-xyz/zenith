<style>
    .form-group {
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

    .form-error {
        color: #ff6b6b;
        font-size: 0.9rem;
        font-weight: 500;
        margin-top: 0.5rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .form-input, .form-textarea, .form-select {
            padding: 1rem 1.2rem;
        }
        
        .form-label {
            font-size: 1rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
    }
</style>