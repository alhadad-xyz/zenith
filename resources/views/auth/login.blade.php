<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Zenith - Authentication</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            height: 100vh;
            overflow: hidden;
            letter-spacing: -0.01em;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        /* Left Half - 3D Animation */
        .animation-half {
            flex: 1;
            position: relative;
            background: linear-gradient(135deg, #f0e5e0 0%, #e8f2e8 50%, #f5f1e8 100%);
            overflow: hidden;
        }

        #canvas-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .animation-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(240, 229, 224, 0.1) 0%, rgba(232, 242, 232, 0.1) 50%, rgba(245, 241, 232, 0.1) 100%);
            pointer-events: none;
        }

        .brand-content {
            position: absolute;
            top: 3rem;
            left: 3rem;
            z-index: 10;
        }

        .brand-logo {
            font-size: 3rem;
            font-weight: 800;
            color: #2d3e2e;
            letter-spacing: -0.03em;
            margin-bottom: 1rem;
            text-shadow: 0 2px 20px rgba(45, 62, 46, 0.1);
        }

        .brand-tagline {
            font-size: 1.2rem;
            color: #6b7c6d;
            font-weight: 500;
            max-width: 300px;
            line-height: 1.5;
        }

        .floating-stats {
            position: absolute;
            bottom: 3rem;
            left: 3rem;
            z-index: 10;
            display: flex;
            gap: 3rem;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 1.5rem;
            min-width: 120px;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .stat-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(45, 62, 46, 0.15);
            background: rgba(255, 255, 255, 0.6);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: #2d3e2e;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6b7c6d;
            font-weight: 600;
            text-align: center;
        }

        /* Right Half - Form */
        .form-half {
            flex: 1;
            background: #ffffff;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 2rem 3rem 3rem 3rem;
            position: relative;
            overflow-y: auto;
            min-height: 0;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            position: relative;
            margin: auto 0;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-toggle-container {
            position: sticky;
            top: 0;
            background: #ffffff;
            z-index: 100;
            padding: 1rem 0;
            margin-bottom: 1rem;
        }

        .form-toggle {
            display: flex;
            background: #f8f9fa;
            border-radius: 16px;
            padding: 6px;
            position: relative;
        }

        .toggle-option {
            flex: 1;
            padding: 1rem 2rem;
            border: none;
            background: transparent;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            color: #6b7c6d;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            z-index: 2;
            position: relative;
        }

        .toggle-option.active {
            color: #2d3e2e;
        }

        .toggle-slider {
            position: absolute;
            top: 6px;
            left: 6px;
            width: calc(50% - 6px);
            height: calc(100% - 12px);
            background: #ffffff;
            border-radius: 12px;
            transition: transform 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 0 4px 16px rgba(45, 62, 46, 0.1);
        }

        .toggle-slider.signup {
            transform: translateX(100%);
        }

        .welcome-text {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2d3e2e;
            margin-bottom: 0.5rem;
            letter-spacing: -0.03em;
        }

        .welcome-subtitle {
            font-size: 1.1rem;
            color: #6b7c6d;
            font-weight: 500;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 1.1rem;
            font-weight: 700;
            color: #2d3e2e;
            margin-bottom: 0.75rem;
            letter-spacing: -0.01em;
        }

        .form-input {
            width: 100%;
            padding: 1.5rem;
            border: 3px solid #f1f3f4;
            border-radius: 16px;
            font-size: 1rem;
            font-weight: 500;
            color: #2d3e2e;
            background: #ffffff;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            font-family: 'Inter', sans-serif;
        }

        .form-input:focus {
            outline: none;
            border-color: #ff6b6b;
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(255, 107, 107, 0.15);
        }

        .form-input::placeholder {
            color: #9aa0a6;
            font-weight: 400;
        }

        .password-group {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6b7c6d;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .password-toggle:hover {
            color: #2d3e2e;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .checkbox {
            width: 18px;
            height: 18px;
            border: 2px solid #e1e5e9;
            border-radius: 4px;
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
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

        .forgot-link {
            color: #6b7c6d;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .forgot-link:hover {
            color: #ff6b6b;
        }

        .primary-button {
            width: 100%;
            padding: 1.5rem;
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 32px rgba(255, 107, 107, 0.3);
            letter-spacing: -0.01em;
        }

        .primary-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 48px rgba(255, 107, 107, 0.4);
            background: linear-gradient(135deg, #ff5252 0%, #ff4444 100%);
        }

        .primary-button:active {
            transform: translateY(-1px);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 2rem 0;
            color: #9aa0a6;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e1e5e9;
        }

        .divider span {
            padding: 0 1rem;
        }

        .google-button {
            width: 100%;
            padding: 1.5rem;
            background: #ffffff;
            color: #2d3e2e;
            border: 3px solid #f1f3f4;
            border-radius: 16px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            font-family: 'Inter', sans-serif;
        }

        .google-button:hover {
            border-color: #ff6b6b;
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(255, 107, 107, 0.1);
        }

        .google-icon {
            width: 20px;
            height: 20px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="%234285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="%2334A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="%23FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="%23EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>') no-repeat center;
            background-size: contain;
        }

        /* Form visibility */
        .login-form,
        .signup-form {
            display: none;
        }

        .login-form.active,
        .signup-form.active {
            display: block;
        }

        .terms-text {
            font-size: 0.85rem;
            color: #6b7c6d;
            margin-top: 1rem;
            text-align: center;
            line-height: 1.5;
        }

        .terms-link {
            color: #ff6b6b;
            text-decoration: none;
            font-weight: 600;
        }

        .terms-link:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .container {
                flex-direction: column;
                height: auto;
                min-height: 100vh;
            }
            
            .animation-half {
                height: 40vh;
                min-height: 300px;
                flex: none;
            }
            
            .form-half {
                flex: 1;
                padding: 1rem 2rem 2rem 2rem;
                min-height: 60vh;
                display: flex;
                align-items: flex-start;
                justify-content: center;
                overflow-y: auto;
            }
            
            .brand-content {
                position: absolute;
                top: 2rem;
                left: 2rem;
                z-index: 10;
            }
            
            .floating-stats {
                position: absolute;
                bottom: 1rem;
                left: 50%;
                transform: translateX(-50%);
                width: 100%;
                justify-content: center;
                padding: 0 2rem;
                gap: 1.5rem;
            }
            
            .brand-logo {
                font-size: 2.5rem;
            }
            
            .brand-tagline {
                font-size: 1rem;
            }
            
            .form-container {
                max-width: 450px;
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            body {
                overflow-y: auto;
            }
            
            .container {
                height: auto;
                min-height: 100vh;
            }
            
            .animation-half {
                height: 35vh;
                min-height: 250px;
            }
            
            .form-half {
                padding: 1rem 1.5rem 1.5rem 1.5rem;
                min-height: 65vh;
                overflow-y: auto;
                align-items: flex-start;
            }
            
            .brand-content {
                top: 1rem;
                left: 1rem;
            }
            
            .brand-logo {
                font-size: 2rem;
                margin-bottom: 0.5rem;
            }
            
            .brand-tagline {
                font-size: 0.9rem;
                max-width: 250px;
            }
            
            .welcome-text {
                font-size: 1.8rem;
            }
            
            .welcome-subtitle {
                font-size: 1rem;
            }
            
            .floating-stats {
                flex-direction: row;
                gap: 1rem;
                bottom: 0.5rem;
                padding: 0 1rem;
            }
            
            .stat-item {
                min-width: auto;
                width: 90px;
                padding: 1rem 0.5rem;
            }
            
            .stat-number {
                font-size: 1.5rem;
            }
            
            .stat-label {
                font-size: 0.7rem;
            }
            
            .form-container {
                max-width: 100%;
            }
            
            .form-group {
                margin-bottom: 1.25rem;
            }
            
            .form-input {
                padding: 1.25rem;
            }
            
            .form-options {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
                text-align: center;
            }
            
            .checkbox-group {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .animation-half {
                height: 30vh;
                min-height: 200px;
            }
            
            .form-half {
                padding: 0.5rem 1rem 1rem 1rem;
                min-height: 70vh;
                overflow-y: auto;
                align-items: flex-start;
            }
            
            .brand-logo {
                font-size: 1.8rem;
            }
            
            .brand-tagline {
                font-size: 0.8rem;
                max-width: 200px;
            }
            
            .welcome-text {
                font-size: 1.6rem;
            }
            
            .floating-stats {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .stat-item {
                width: 80px;
                padding: 0.8rem 0.3rem;
            }
            
            .stat-number {
                font-size: 1.2rem;
            }
            
            .stat-label {
                font-size: 0.6rem;
            }
            
            .form-input {
                padding: 1rem;
                font-size: 0.9rem;
            }
            
            .primary-button {
                padding: 1.25rem;
                font-size: 1rem;
            }
            
            .google-button {
                padding: 1.25rem;
                font-size: 0.9rem;
            }
        }

        /* Loading Animation */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .loading .primary-button {
            background: linear-gradient(135deg, #ccc 0%, #999 100%);
        }

        /* Success Animation */
        @keyframes successPulse {
            0% {
                transform: scale(1);
                box-shadow: 0 8px 32px rgba(255, 107, 107, 0.3);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 16px 48px rgba(255, 107, 107, 0.5);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 8px 32px rgba(255, 107, 107, 0.3);
            }
        }

        .success .primary-button {
            animation: successPulse 0.6s ease-in-out;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
            font-weight: 500;
        }

        .alert-error {
            background-color: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }

        .alert-success {
            background-color: #efe;
            color: #363;
            border: 1px solid #cfc;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Half - 3D Animation -->
        <div class="animation-half">
            <div id="canvas-container"></div>
            <div class="animation-overlay"></div>
            
            <div class="brand-content">
                <div class="brand-logo">Zenith</div>
                <div class="brand-tagline">Your mindful career progression companion</div>
            </div>
            
            <div class="floating-stats">
                <div class="stat-item">
                    <div class="stat-number">97%</div>
                    <div class="stat-label">Success Rate</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">15k+</div>
                    <div class="stat-label">Active Users</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">$180k</div>
                    <div class="stat-label">Avg Salary</div>
                </div>
            </div>
        </div>

        <!-- Right Half - Form -->
        <div class="form-half">
            <div class="form-container">
                <div class="form-toggle-container">
                    <div class="form-toggle">
                        <div class="toggle-slider" id="toggleSlider"></div>
                        <button class="toggle-option active" id="loginToggle" onclick="switchToLogin()">Log In</button>
                        <button class="toggle-option" id="signupToggle" onclick="switchToSignup()">Sign Up</button>
                    </div>
                </div>

                <!-- Login Form -->
                <form class="login-form active" id="loginForm">
                    <div class="form-header">
                        <h1 class="welcome-text">Welcome back</h1>
                        <p class="welcome-subtitle">Continue your career journey</p>
                    </div>

                    <div id="loginAlert"></div>

                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-input" placeholder="your@email.com" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="password-group">
                            <input type="password" name="password" class="form-input" placeholder="••••••••" id="loginPassword" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('loginPassword')">Show</button>
                        </div>
                    </div>

                    <div class="form-options">
                        <div class="checkbox-group">
                            <input type="checkbox" name="remember" class="checkbox" id="rememberMe">
                            <label for="rememberMe">Remember me</label>
                        </div>
                        <a href="#" class="forgot-link">Forgot password?</a>
                    </div>

                    <button type="submit" class="primary-button">
                        Log In
                    </button>

                    <div class="divider">
                        <span>or</span>
                    </div>

                    <button type="button" class="google-button" onclick="signInWithGoogle()">
                        <div class="google-icon"></div>
                        Continue with Google
                    </button>
                </form>

                <!-- Signup Form -->
                <form class="signup-form" id="signupForm">
                    <div class="form-header">
                        <h1 class="welcome-text">Create account</h1>
                        <p class="welcome-subtitle">Start your career transformation</p>
                    </div>

                    <div id="signupAlert"></div>

                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-input" placeholder="John Doe" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-input" placeholder="your@email.com" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="password-group">
                            <input type="password" name="password" class="form-input" placeholder="••••••••" id="signupPassword" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('signupPassword')">Show</button>
                        </div>
                    </div>

                    <div class="form-options">
                        <div class="checkbox-group">
                            <input type="checkbox" class="checkbox" id="agreeTerms" required>
                            <label for="agreeTerms">I agree to the terms</label>
                        </div>
                    </div>

                    <button type="submit" class="primary-button">
                        Create Account
                    </button>

                    <div class="divider">
                        <span>or</span>
                    </div>

                    <button type="button" class="google-button" onclick="signInWithGoogle()">
                        <div class="google-icon"></div>
                        Continue with Google
                    </button>

                    <div class="terms-text">
                        By creating an account, you agree to our 
                        <a href="#" class="terms-link">Terms of Service</a> and 
                        <a href="#" class="terms-link">Privacy Policy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Set up CSRF token for AJAX requests
        window.Laravel = {
            csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        // Three.js 3D Animation
        let scene, camera, renderer, geometry, material, mesh;
        let particles = [];
        const particleCount = 150;

        function initThreeJS() {
            const container = document.getElementById('canvas-container');
            
            scene = new THREE.Scene();
            camera = new THREE.PerspectiveCamera(75, container.clientWidth / container.clientHeight, 0.1, 1000);
            renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
            renderer.setSize(container.clientWidth, container.clientHeight);
            renderer.setClearColor(0x000000, 0);
            container.appendChild(renderer.domElement);

            const particleGeometry = new THREE.BufferGeometry();
            const positions = new Float32Array(particleCount * 3);
            const colors = new Float32Array(particleCount * 3);
            const sizes = new Float32Array(particleCount);

            const colorPalette = [
                new THREE.Color(0xf0e5e0),
                new THREE.Color(0xe8f2e8),
                new THREE.Color(0xf5f1e8),
                new THREE.Color(0xff6b6b),
                new THREE.Color(0x6b7c6d)
            ];

            for (let i = 0; i < particleCount; i++) {
                positions[i * 3] = (Math.random() - 0.5) * 20;
                positions[i * 3 + 1] = (Math.random() - 0.5) * 20;
                positions[i * 3 + 2] = (Math.random() - 0.5) * 20;

                const color = colorPalette[Math.floor(Math.random() * colorPalette.length)];
                colors[i * 3] = color.r;
                colors[i * 3 + 1] = color.g;
                colors[i * 3 + 2] = color.b;

                sizes[i] = Math.random() * 3 + 1;

                particles.push({
                    velocity: new THREE.Vector3(
                        (Math.random() - 0.5) * 0.02,
                        (Math.random() - 0.5) * 0.02,
                        (Math.random() - 0.5) * 0.02
                    ),
                    originalY: positions[i * 3 + 1]
                });
            }

            particleGeometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
            particleGeometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));
            particleGeometry.setAttribute('size', new THREE.BufferAttribute(sizes, 1));

            const particleMaterial = new THREE.ShaderMaterial({
                uniforms: {
                    time: { value: 0 }
                },
                vertexShader: `
                    attribute float size;
                    varying vec3 vColor;
                    uniform float time;
                    
                    void main() {
                        vColor = color;
                        vec4 mvPosition = modelViewMatrix * vec4(position, 1.0);
                        
                        mvPosition.y += sin(time + position.x * 0.1) * 0.5;
                        mvPosition.x += cos(time + position.z * 0.1) * 0.3;
                        
                        gl_PointSize = size * (300.0 / -mvPosition.z);
                        gl_Position = projectionMatrix * mvPosition;
                    }
                `,
                fragmentShader: `
                    varying vec3 vColor;
                    
                    void main() {
                        float distance = length(gl_PointCoord - vec2(0.5));
                        if (distance > 0.5) discard;
                        
                        float alpha = 1.0 - distance * 2.0;
                        gl_FragColor = vec4(vColor, alpha * 0.8);
                    }
                `,
                transparent: true,
                vertexColors: true,
                blending: THREE.AdditiveBlending
            });

            const particleSystem = new THREE.Points(particleGeometry, particleMaterial);
            scene.add(particleSystem);

            camera.position.z = 15;

            function animate() {
                requestAnimationFrame(animate);
                
                particleMaterial.uniforms.time.value += 0.01;
                scene.rotation.y += 0.002;
                scene.rotation.x += 0.001;
                
                renderer.render(scene, camera);
            }
            
            animate();

            window.addEventListener('resize', () => {
                if (container.clientWidth > 0) {
                    camera.aspect = container.clientWidth / container.clientHeight;
                    camera.updateProjectionMatrix();
                    renderer.setSize(container.clientWidth, container.clientHeight);
                }
            });
        }

        // Form switching functionality
        function switchToLogin() {
            document.getElementById('loginToggle').classList.add('active');
            document.getElementById('signupToggle').classList.remove('active');
            document.getElementById('toggleSlider').classList.remove('signup');
            
            document.getElementById('loginForm').classList.add('active');
            document.getElementById('signupForm').classList.remove('active');
        }

        function switchToSignup() {
            document.getElementById('signupToggle').classList.add('active');
            document.getElementById('loginToggle').classList.remove('active');
            document.getElementById('toggleSlider').classList.add('signup');
            
            document.getElementById('signupForm').classList.add('active');
            document.getElementById('loginForm').classList.remove('active');
        }

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = input.nextElementSibling;
            
            if (input.type === 'password') {
                input.type = 'text';
                button.textContent = 'Hide';
            } else {
                input.type = 'password';
                button.textContent = 'Show';
            }
        }

        function showAlert(containerId, message, type = 'error') {
            const container = document.getElementById(containerId);
            container.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
        }

        function clearAlert(containerId) {
            document.getElementById(containerId).innerHTML = '';
        }

        // Form submission handlers
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const button = this.querySelector('.primary-button');
            const form = this;
            
            clearAlert('loginAlert');
            form.classList.add('loading');
            button.textContent = 'Logging in...';
            
            const formData = new FormData(form);
            
            try {
                const response = await fetch('{{ route("login") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': window.Laravel.csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    form.classList.remove('loading');
                    form.classList.add('success');
                    button.textContent = 'Welcome back!';
                    
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Login failed');
                }
            } catch (error) {
                form.classList.remove('loading');
                button.textContent = 'Log In';
                showAlert('loginAlert', error.message);
            }
        });

        document.getElementById('signupForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const button = this.querySelector('.primary-button');
            const form = this;
            
            clearAlert('signupAlert');
            form.classList.add('loading');
            button.textContent = 'Creating Account...';
            
            const formData = new FormData(form);
            
            try {
                const response = await fetch('{{ route("register") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': window.Laravel.csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    form.classList.remove('loading');
                    form.classList.add('success');
                    button.textContent = 'Account Created!';
                    
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Registration failed');
                }
            } catch (error) {
                form.classList.remove('loading');
                button.textContent = 'Create Account';
                showAlert('signupAlert', error.message);
            }
        });

        function signInWithGoogle() {
            console.log('Google Sign-In not implemented yet');
        }

        // Initialize everything when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            initThreeJS();
            
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = '';
                });
            });

            const statNumbers = document.querySelectorAll('.stat-number');
            statNumbers.forEach((stat, index) => {
                const finalValue = stat.textContent;
                stat.textContent = '0';
                
                setTimeout(() => {
                    animateNumber(stat, finalValue);
                }, index * 200);
            });
        });

        function animateNumber(element, finalValue) {
            const isPercentage = finalValue.includes('%');
            const isDollar = finalValue.includes('$');
            const isK = finalValue.includes('k');
            
            let numericValue = parseInt(finalValue.replace(/[^0-9]/g, ''));
            let current = 0;
            const increment = numericValue / 50;
            
            const animation = setInterval(() => {
                current += increment;
                if (current >= numericValue) {
                    current = numericValue;
                    clearInterval(animation);
                }
                
                let displayValue = Math.floor(current);
                if (isDollar) displayValue = '$' + displayValue + 'k';
                else if (isK) displayValue = displayValue + 'k+';
                else if (isPercentage) displayValue = displayValue + '%';
                
                element.textContent = displayValue;
            }, 20);
        }
    </script>
</body>
</html>