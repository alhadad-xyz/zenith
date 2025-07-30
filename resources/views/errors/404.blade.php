<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zenith - Page Not Found</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f1e8 0%, #e8f2e8 50%, #f0e5e0 100%);
            letter-spacing: -0.01em;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            color: #2d3e2e;
        }

        /* Animated Background Texture */
        .background-texture {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            overflow: hidden;
        }

        .texture-layer {
            position: absolute;
            width: 120%;
            height: 120%;
            top: -10%;
            left: -10%;
            opacity: 0.03;
            animation: textureFloat 60s ease-in-out infinite;
        }

        .texture-layer:nth-child(1) {
            background: radial-gradient(ellipse at 20% 30%, rgba(240, 229, 224, 0.15) 0%, transparent 50%),
                        radial-gradient(ellipse at 80% 70%, rgba(232, 242, 232, 0.12) 0%, transparent 50%),
                        radial-gradient(ellipse at 40% 80%, rgba(245, 241, 232, 0.1) 0%, transparent 50%);
            animation-delay: 0s;
            animation-duration: 45s;
        }

        .texture-layer:nth-child(2) {
            background: radial-gradient(ellipse at 60% 20%, rgba(107, 124, 109, 0.08) 0%, transparent 40%),
                        radial-gradient(ellipse at 30% 90%, rgba(139, 69, 19, 0.06) 0%, transparent 40%);
            animation-delay: -15s;
            animation-duration: 50s;
        }

        .texture-layer:nth-child(3) {
            background: radial-gradient(ellipse at 90% 40%, rgba(255, 107, 107, 0.05) 0%, transparent 30%),
                        radial-gradient(ellipse at 10% 60%, rgba(240, 229, 224, 0.08) 0%, transparent 35%);
            animation-delay: -30s;
            animation-duration: 55s;
        }

        @keyframes textureFloat {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg) scale(1);
            }
            25% {
                transform: translate(-2%, -1%) rotate(1deg) scale(1.02);
            }
            50% {
                transform: translate(1%, -2%) rotate(-0.5deg) scale(0.98);
            }
            75% {
                transform: translate(-1%, 1%) rotate(0.8deg) scale(1.01);
            }
        }

        /* Floating Elements */
        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 2;
        }

        .floating-shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            animation: floatGently 20s ease-in-out infinite;
        }

        .floating-shape:nth-child(1) {
            width: 300px;
            height: 300px;
            top: 10%;
            left: 80%;
            background: radial-gradient(circle, rgba(240, 229, 224, 0.04) 0%, transparent 70%);
            animation-delay: 0s;
            animation-duration: 25s;
        }

        .floating-shape:nth-child(2) {
            width: 200px;
            height: 200px;
            top: 70%;
            left: 5%;
            background: radial-gradient(circle, rgba(232, 242, 232, 0.03) 0%, transparent 70%);
            animation-delay: -8s;
            animation-duration: 30s;
        }

        .floating-shape:nth-child(3) {
            width: 150px;
            height: 150px;
            top: 20%;
            left: 15%;
            background: radial-gradient(circle, rgba(255, 107, 107, 0.02) 0%, transparent 70%);
            animation-delay: -16s;
            animation-duration: 22s;
        }

        .floating-shape:nth-child(4) {
            width: 250px;
            height: 250px;
            top: 60%;
            right: 20%;
            background: radial-gradient(circle, rgba(107, 124, 109, 0.025) 0%, transparent 70%);
            animation-delay: -12s;
            animation-duration: 28s;
        }

        @keyframes floatGently {
            0%, 100% {
                transform: translateY(0px) translateX(0px) scale(1);
                opacity: 0.3;
            }
            25% {
                transform: translateY(-20px) translateX(10px) scale(1.05);
                opacity: 0.2;
            }
            50% {
                transform: translateY(-40px) translateX(-5px) scale(0.95);
                opacity: 0.4;
            }
            75% {
                transform: translateY(-20px) translateX(-10px) scale(1.02);
                opacity: 0.25;
            }
        }

        /* Main Content */
        .error-container {
            text-align: center;
            position: relative;
            z-index: 10;
            max-width: 800px;
            padding: 2rem;
        }

        /* 404 Typography */
        .error-code {
            font-size: clamp(8rem, 20vw, 16rem);
            font-weight: 900;
            line-height: 0.8;
            margin-bottom: 2rem;
            position: relative;
            background: transparent;
            color: transparent;
            -webkit-text-stroke: 3px #2d3e2e;
            text-stroke: 3px #2d3e2e;
            letter-spacing: -0.05em;
            animation: codeAppear 1.5s cubic-bezier(0.23, 1, 0.32, 1) forwards;
            opacity: 0;
        }

        @keyframes codeAppear {
            0% {
                opacity: 0;
                transform: translateY(40px) scale(0.9);
                -webkit-text-stroke: 1px #2d3e2e;
            }
            50% {
                -webkit-text-stroke: 5px #2d3e2e;
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
                -webkit-text-stroke: 3px #2d3e2e;
            }
        }

        /* Subtle glow effect */
        .error-code::before {
            content: '404';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.08) 0%, rgba(107, 124, 109, 0.03) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            z-index: -1;
            animation: glowPulse 3s ease-in-out infinite;
        }

        @keyframes glowPulse {
            0%, 100% {
                opacity: 0.2;
                filter: blur(2px);
            }
            50% {
                opacity: 0.4;
                filter: blur(1px);
            }
        }

        /* Message */
        .error-message {
            font-size: clamp(1.5rem, 4vw, 2.5rem);
            font-weight: 500;
            color: #6b7c6d;
            margin-bottom: 3rem;
            line-height: 1.3;
            opacity: 0;
            animation: messageSlideIn 1s cubic-bezier(0.23, 1, 0.32, 1) 0.5s forwards;
        }

        @keyframes messageSlideIn {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* CTA Button */
        .return-button {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
            color: white;
            border: none;
            padding: 1.5rem 3rem;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 
                0 20px 60px rgba(255, 107, 107, 0.3),
                0 8px 24px rgba(255, 107, 107, 0.2);
            letter-spacing: -0.01em;
            font-family: 'Inter', sans-serif;
            position: relative;
            overflow: hidden;
            opacity: 0;
            animation: buttonRise 1s cubic-bezier(0.23, 1, 0.32, 1) 1s forwards;
            text-decoration: none;
            display: inline-block;
        }

        @keyframes buttonRise {
            0% {
                opacity: 0;
                transform: translateY(40px) scale(0.9);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .return-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s;
        }

        .return-button:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 
                0 32px 80px rgba(255, 107, 107, 0.4),
                0 16px 48px rgba(255, 107, 107, 0.3);
            background: linear-gradient(135deg, #ff5252 0%, #ff4444 100%);
        }

        .return-button:hover::before {
            left: 100%;
        }

        .return-button:active {
            transform: translateY(-4px) scale(1.02);
        }

        /* Zenith Logo */
        .zenith-logo {
            position: absolute;
            top: 3rem;
            left: 3rem;
            font-size: 2rem;
            font-weight: 800;
            color: #2d3e2e;
            letter-spacing: -0.03em;
            opacity: 0;
            animation: logoFadeIn 1s ease-out 1.5s forwards;
            z-index: 20;
        }

        @keyframes logoFadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .error-container {
                padding: 1rem;
            }
            
            .error-code {
                -webkit-text-stroke: 2px #2d3e2e;
                margin-bottom: 1.5rem;
            }
            
            .error-message {
                margin-bottom: 2rem;
            }
            
            .return-button {
                padding: 1.25rem 2.5rem;
                font-size: 1rem;
                width: 100%;
                max-width: 300px;
            }
            
            .zenith-logo {
                top: 2rem;
                left: 2rem;
                font-size: 1.5rem;
            }
            
            .floating-shape {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .error-container {
                padding: 0.5rem;
            }
            
            .error-code {
                -webkit-text-stroke: 1.5px #2d3e2e;
            }
            
            .zenith-logo {
                top: 1.5rem;
                left: 1.5rem;
                font-size: 1.25rem;
            }
        }

        /* High contrast mode */
        @media (prefers-contrast: high) {
            .error-code {
                -webkit-text-stroke: 4px #000;
                color: transparent;
            }
            
            .error-message {
                color: #333;
            }
            
            .return-button {
                background: #ff0000;
                box-shadow: none;
            }
        }

        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {
            .texture-layer,
            .floating-shape,
            .error-code,
            .error-message,
            .return-button,
            .zenith-logo {
                animation: none;
            }
            
            .error-code,
            .error-message,
            .return-button,
            .zenith-logo {
                opacity: 1;
                transform: none;
            }
            
            .return-button:hover {
                transform: none;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            body {
                background: linear-gradient(135deg, #2a241f 0%, #1f2b1f 50%, #241f1e 100%);
            }
            
            .error-code {
                -webkit-text-stroke: 3px #e8ccc0;
            }
            
            .error-message {
                color: #a8b5a9;
            }
            
            .zenith-logo {
                color: #e8ccc0;
            }
            
            .texture-layer:nth-child(1) {
                background: radial-gradient(ellipse at 20% 30%, rgba(139, 69, 19, 0.1) 0%, transparent 50%),
                            radial-gradient(ellipse at 80% 70%, rgba(107, 124, 109, 0.08) 0%, transparent 50%),
                            radial-gradient(ellipse at 40% 80%, rgba(240, 229, 224, 0.05) 0%, transparent 50%);
            }
        }

        /* Parallax effect on mouse move */
        .parallax-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .parallax-element {
            position: absolute;
            transition: transform 0.1s ease-out;
        }
    </style>
</head>
<body>
    <!-- Zenith Logo -->
    <div class="zenith-logo">Zenith</div>

    <!-- Animated Background -->
    <div class="background-texture">
        <div class="texture-layer"></div>
        <div class="texture-layer"></div>
        <div class="texture-layer"></div>
    </div>

    <!-- Floating Elements -->
    <div class="floating-elements">
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
    </div>

    <!-- Main Content -->
    <div class="error-container">
        <div class="error-code">404</div>
        <div class="error-message">Looks like you've discovered a new path.</div>
        <a href="{{ route('dashboard') }}" class="return-button">
            Return to Dashboard
        </a>
    </div>

    <script>
        // Parallax mouse movement effect
        document.addEventListener('mousemove', function(e) {
            const mouseX = (e.clientX / window.innerWidth) * 2 - 1;
            const mouseY = (e.clientY / window.innerHeight) * 2 - 1;
            
            // Apply subtle parallax to floating elements
            const floatingShapes = document.querySelectorAll('.floating-shape');
            floatingShapes.forEach((shape, index) => {
                const speed = (index + 1) * 0.3;
                const x = mouseX * speed * 20;
                const y = mouseY * speed * 20;
                shape.style.transform = `translate(${x}px, ${y}px)`;
            });
            
            // Apply parallax to texture layers
            const textureLayers = document.querySelectorAll('.texture-layer');
            textureLayers.forEach((layer, index) => {
                const speed = (index + 1) * 0.1;
                const x = mouseX * speed * 10;
                const y = mouseY * speed * 10;
                layer.style.transform = `translate(${x}px, ${y}px)`;
            });
            
            // Subtle parallax on main content
            const errorContainer = document.querySelector('.error-container');
            const containerX = mouseX * 5;
            const containerY = mouseY * 5;
            errorContainer.style.transform = `translate(${containerX}px, ${containerY}px)`;
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                window.location.href = '{{ route("dashboard") }}';
            } else if (e.key === 'Escape') {
                window.location.href = '{{ route("dashboard") }}';
            }
        });

        // Auto-focus the button for accessibility
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                document.querySelector('.return-button').focus();
            }, 1500);
        });

        // Add subtle animation on page visibility change
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'visible') {
                // Restart animations when page becomes visible
                const animatedElements = document.querySelectorAll('.texture-layer, .floating-shape');
                animatedElements.forEach(element => {
                    element.style.animationPlayState = 'running';
                });
            }
        });

        // Performance optimization: pause animations when not in view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const animatedElements = entry.target.querySelectorAll('.texture-layer, .floating-shape');
                animatedElements.forEach(element => {
                    element.style.animationPlayState = entry.isIntersecting ? 'running' : 'paused';
                });
            });
        });

        observer.observe(document.body);

        // Add touch support for mobile
        if ('ontouchstart' in window) {
            document.querySelector('.return-button').addEventListener('touchstart', function() {
                this.style.transform = 'translateY(-4px) scale(1.02)';
            });
            
            document.querySelector('.return-button').addEventListener('touchend', function() {
                setTimeout(() => {
                    this.style.transform = '';
                }, 100);
            });
        }

        // Easter egg: Konami code
        let konamiCode = '';
        const konamiSequence = 'ArrowUpArrowUpArrowDownArrowDownArrowLeftArrowRightArrowLeftArrowRightKeyBKeyA';
        
        document.addEventListener('keydown', function(e) {
            konamiCode += e.code;
            if (konamiCode.length > konamiSequence.length) {
                konamiCode = konamiCode.slice(-konamiSequence.length);
            }
            
            if (konamiCode === konamiSequence) {
                // Fun animation
                const errorCode = document.querySelector('.error-code');
                errorCode.style.animation = 'none';
                errorCode.style.background = 'linear-gradient(45deg, #ff6b6b, #6b7c6d, #d2691e)';
                errorCode.style.backgroundSize = '200% 200%';
                errorCode.style.animation = 'rainbow 2s ease infinite';
                
                const style = document.createElement('style');
                style.textContent = `
                    @keyframes rainbow {
                        0% { background-position: 0% 50%; }
                        50% { background-position: 100% 50%; }
                        100% { background-position: 0% 50%; }
                    }
                `;
                document.head.appendChild(style);
                
                konamiCode = '';
            }
        });
    </script>
</body>
</html>