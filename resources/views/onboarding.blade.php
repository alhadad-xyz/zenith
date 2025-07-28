<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Zenith - Find Your Focus</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --vh: 1vh;
        }

        html, body {
            height: 100%;
            height: calc(var(--vh, 1vh) * 100);
            overflow: hidden;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f1e8 0%, #e8f2e8 50%, #f0e5e0 100%);
            letter-spacing: -0.02em;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .onboarding-container {
            position: relative;
            width: 100vw;
            height: 100vh;
            height: calc(var(--vh, 1vh) * 100);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        /* Background 3D Card Container */
        .card-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .floating-card {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotateX(15deg) rotateY(-10deg);
            width: 600px;
            height: 400px;
            background: linear-gradient(135deg, 
                rgba(240, 229, 224, 0.3) 0%, 
                rgba(232, 242, 232, 0.3) 50%, 
                rgba(245, 241, 232, 0.3) 100%);
            backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 32px;
            animation: floatAndRotate 20s ease-in-out infinite;
            box-shadow: 
                0 50px 100px rgba(45, 62, 46, 0.1),
                0 20px 40px rgba(255, 107, 107, 0.05),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            overflow: hidden;
        }

        .floating-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0.1) 0%, 
                transparent 50%, 
                rgba(255, 107, 107, 0.05) 100%);
            border-radius: 32px;
        }

        .card-content {
            position: relative;
            z-index: 2;
            padding: 3rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .card-logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: #2d3e2e;
            opacity: 0.6;
        }

        .card-status {
            padding: 0.5rem 1rem;
            background: rgba(255, 107, 107, 0.1);
            color: #ff6b6b;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .card-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2d3e2e;
            margin-bottom: 0.5rem;
            opacity: 0.7;
        }

        .card-company {
            font-size: 1rem;
            color: #6b7c6d;
            font-weight: 500;
            margin-bottom: 2rem;
            opacity: 0.6;
        }

        .card-timeline {
            display: flex;
            gap: 1rem;
            margin-top: auto;
        }

        .timeline-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #ff6b6b;
            opacity: 0.4;
        }

        .timeline-dot.active {
            opacity: 0.8;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes floatAndRotate {
            0%, 100% {
                transform: translate(-50%, -50%) rotateX(15deg) rotateY(-10deg) translateY(0px);
            }
            25% {
                transform: translate(-50%, -50%) rotateX(10deg) rotateY(-15deg) translateY(-20px);
            }
            50% {
                transform: translate(-50%, -50%) rotateX(20deg) rotateY(-5deg) translateY(-10px);
            }
            75% {
                transform: translate(-50%, -50%) rotateX(12deg) rotateY(-12deg) translateY(-30px);
            }
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.2); }
        }

        /* Main Content */
        .main-content {
            position: relative;
            z-index: 10;
            text-align: center;
            max-width: 900px;
            padding: 0 2rem;
        }

        /* Kinetic Typography */
        .hero-title {
            font-size: clamp(4rem, 12vw, 8rem);
            font-weight: 900;
            color: #2d3e2e;
            line-height: 0.9;
            margin-bottom: 2rem;
            letter-spacing: -0.04em;
            position: relative;
        }

        .hero-title .word {
            display: inline-block;
            overflow: hidden;
        }

        .hero-title .word .letter {
            display: inline-block;
            transform: translateY(100%);
            animation: letterRise 1.2s cubic-bezier(0.23, 1, 0.32, 1) forwards;
        }

        .hero-title .word:nth-child(1) .letter {
            animation-delay: 0.1s;
        }

        .hero-title .word:nth-child(2) .letter {
            animation-delay: 0.3s;
        }

        .hero-title .word:nth-child(3) .letter {
            animation-delay: 0.5s;
        }

        .hero-title .word .letter:nth-child(1) { animation-delay: inherit; }
        .hero-title .word .letter:nth-child(2) { animation-delay: calc(var(--base-delay, 0.1s) + 0.05s); }
        .hero-title .word .letter:nth-child(3) { animation-delay: calc(var(--base-delay, 0.1s) + 0.1s); }
        .hero-title .word .letter:nth-child(4) { animation-delay: calc(var(--base-delay, 0.1s) + 0.15s); }
        .hero-title .word .letter:nth-child(5) { animation-delay: calc(var(--base-delay, 0.1s) + 0.2s); }
        .hero-title .word .letter:nth-child(6) { animation-delay: calc(var(--base-delay, 0.1s) + 0.25s); }

        @keyframes letterRise {
            0% {
                transform: translateY(100%);
                opacity: 0;
            }
            100% {
                transform: translateY(0%);
                opacity: 1;
            }
        }

        /* Focus effect */
        .hero-title .word:nth-child(3) {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
        }

        .hero-title .word:nth-child(3)::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, transparent 0%, #ff6b6b 50%, transparent 100%);
            border-radius: 2px;
            opacity: 0;
            animation: underlineGlow 2s ease-in-out 1.5s forwards;
        }

        @keyframes underlineGlow {
            0% { opacity: 0; transform: scaleX(0); }
            100% { opacity: 1; transform: scaleX(1); }
        }

        .hero-tagline {
            font-size: clamp(1.2rem, 3vw, 1.8rem);
            color: #6b7c6d;
            font-weight: 500;
            margin-bottom: 4rem;
            line-height: 1.4;
            opacity: 0;
            animation: fadeInUp 1s ease-out 1.8s forwards;
        }

        @keyframes fadeInUp {
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
        .cta-container {
            opacity: 0;
            animation: fadeInUp 1s ease-out 2.2s forwards;
        }

        .cta-button {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
            color: white;
            border: none;
            padding: 1.75rem 3.5rem;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 
                0 20px 60px rgba(255, 107, 107, 0.3),
                0 8px 24px rgba(255, 107, 107, 0.2);
            letter-spacing: -0.01em;
            position: relative;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
        }

        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s;
        }

        .cta-button:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 
                0 32px 80px rgba(255, 107, 107, 0.4),
                0 16px 32px rgba(255, 107, 107, 0.3);
            background: linear-gradient(135deg, #ff5252 0%, #ff4444 100%);
        }

        .cta-button:hover::before {
            left: 100%;
        }

        .cta-button:active {
            transform: translateY(-4px) scale(1.01);
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

        .floating-orb {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: floatSlow 15s ease-in-out infinite;
        }

        .floating-orb:nth-child(1) {
            width: 200px;
            height: 200px;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .floating-orb:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 70%;
            right: 10%;
            animation-delay: -5s;
        }

        .floating-orb:nth-child(3) {
            width: 100px;
            height: 100px;
            top: 30%;
            right: 20%;
            animation-delay: -10s;
        }

        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px) translateX(0px); }
            25% { transform: translateY(-20px) translateX(10px); }
            50% { transform: translateY(-40px) translateX(-5px); }
            75% { transform: translateY(-20px) translateX(-10px); }
        }

        /* Navigation */
        .top-nav {
            position: absolute;
            top: 3rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 20;
            opacity: 0;
            animation: fadeIn 1s ease-out 2.5s forwards;
        }

        .nav-logo {
            font-size: 2rem;
            font-weight: 800;
            color: #2d3e2e;
            text-decoration: none;
            letter-spacing: -0.03em;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        /* Bottom Info */
        .bottom-info {
            position: absolute;
            bottom: 3rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 20;
            opacity: 0;
            animation: fadeIn 1s ease-out 2.8s forwards;
            display: flex;
            gap: 3rem;
            align-items: center;
        }

        .info-stat {
            text-align: center;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 800;
            color: #2d3e2e;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6b7c6d;
            font-weight: 500;
        }

        /* Responsive Design */
        @media (max-width: 1440px) {
            .hero-title {
                font-size: clamp(3.5rem, 10vw, 6rem);
            }
            
            .main-content {
                max-width: 800px;
            }
        }

        @media (max-width: 1024px) {
            .floating-card {
                width: 80vw;
                max-width: 500px;
                height: 320px;
            }
            
            .card-content {
                padding: 2rem;
            }
            
            .hero-title {
                font-size: clamp(3rem, 8vw, 5rem);
                margin-bottom: 1.5rem;
            }
            
            .hero-tagline {
                font-size: clamp(1.1rem, 2.5vw, 1.6rem);
                margin-bottom: 3rem;
            }
            
            .cta-button {
                padding: 1.5rem 3rem;
                font-size: 1.1rem;
            }
            
            .main-content {
                max-width: 700px;
                padding: 0 1.5rem;
            }
        }

        @media (max-width: 768px) {
            html, body {
                overflow-y: auto;
            }
            
            .onboarding-container {
                padding: 1rem;
                min-height: 100vh;
                height: auto;
                justify-content: flex-start;
                padding-top: 6rem;
                padding-bottom: 4rem;
            }
            
            .floating-card {
                width: 85vw;
                max-width: 400px;
                height: 240px;
                transform: translate(-50%, -50%) rotateX(8deg) rotateY(-3deg);
                position: fixed;
                opacity: 0.6;
            }
            
            .card-content {
                padding: 1.5rem;
            }
            
            .card-title {
                font-size: 1.3rem;
            }
            
            .card-company {
                font-size: 0.95rem;
            }
            
            .hero-title {
                font-size: clamp(2.5rem, 12vw, 4rem);
                margin-bottom: 1.5rem;
            }
            
            .hero-tagline {
                font-size: clamp(1rem, 4vw, 1.4rem);
                margin-bottom: 2.5rem;
                line-height: 1.5;
            }
            
            .cta-button {
                padding: 1.25rem 2.5rem;
                font-size: 1rem;
                margin-bottom: 2rem;
            }
            
            .main-content {
                max-width: 90%;
                position: relative;
                z-index: 10;
            }
            
            .top-nav {
                top: 2rem;
                position: fixed;
            }
            
            .nav-logo {
                font-size: 1.8rem;
            }
            
            .bottom-info {
                position: relative;
                bottom: auto;
                transform: none;
                flex-direction: row;
                gap: 2rem;
                margin-top: 2rem;
                justify-content: center;
                flex-wrap: wrap;
            }
            
            .info-stat {
                min-width: 80px;
            }
            
            .stat-number {
                font-size: 1.3rem;
            }
            
            .stat-label {
                font-size: 0.85rem;
            }
            
            .floating-orb {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .onboarding-container {
                padding: 0.5rem;
                padding-top: 5rem;
                padding-bottom: 3rem;
            }
            
            .floating-card {
                width: 90vw;
                max-width: 320px;
                height: 200px;
                opacity: 0.5;
            }
            
            .card-content {
                padding: 1rem;
            }
            
            .card-header {
                margin-bottom: 1rem;
            }
            
            .card-logo {
                font-size: 1.2rem;
            }
            
            .card-status {
                font-size: 0.7rem;
                padding: 0.4rem 0.8rem;
            }
            
            .card-title {
                font-size: 1.1rem;
                margin-bottom: 0.3rem;
            }
            
            .card-company {
                font-size: 0.85rem;
                margin-bottom: 1rem;
            }
            
            .hero-title {
                font-size: clamp(2rem, 15vw, 3.5rem);
                margin-bottom: 1rem;
                line-height: 1;
            }
            
            .hero-tagline {
                font-size: clamp(0.9rem, 5vw, 1.2rem);
                margin-bottom: 2rem;
                padding: 0 1rem;
            }
            
            .cta-button {
                padding: 1rem 2rem;
                width: 90%;
                max-width: 280px;
                font-size: 0.95rem;
            }
            
            .main-content {
                padding: 0 1rem;
            }
            
            .top-nav {
                top: 1.5rem;
                left: 1rem;
                transform: none;
            }
            
            .nav-logo {
                font-size: 1.5rem;
            }
            
            .bottom-info {
                margin-top: 1.5rem;
                gap: 1.5rem;
                flex-direction: column;
                left: 0%;
            }
            
            .info-stat {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            
            .stat-number {
                font-size: 1.2rem;
                margin-bottom: 0;
            }
            
            .stat-label {
                font-size: 0.8rem;
                margin-bottom: 0;
            }
        }

        @media (max-width: 375px) {
            .hero-title {
                font-size: clamp(1.8rem, 16vw, 3rem);
            }
            
            .hero-tagline {
                font-size: clamp(0.85rem, 5.5vw, 1.1rem);
            }
            
            .cta-button {
                padding: 0.9rem 1.8rem;
                font-size: 0.9rem;
            }
            
            .floating-card {
                height: 180px;
                opacity: 0.4;
            }
        }

        /* Landscape mobile */
        @media (max-width: 896px) and (max-height: 414px) and (orientation: landscape) {
            .onboarding-container {
                flex-direction: row;
                align-items: center;
                justify-content: center;
                padding: 1rem 2rem;
            }
            
            .floating-card {
                position: absolute;
                right: 2rem;
                top: 50%;
                left: auto;
                transform: translateY(-50%) rotateX(5deg) rotateY(-5deg);
                width: 300px;
                height: 200px;
                opacity: 0.7;
            }
            
            .main-content {
                max-width: 50%;
                text-align: left;
                margin-right: 2rem;
            }
            
            .hero-title {
                font-size: clamp(2rem, 8vw, 3rem);
                margin-bottom: 1rem;
            }
            
            .hero-tagline {
                font-size: clamp(0.9rem, 2.5vw, 1.2rem);
                margin-bottom: 1.5rem;
            }
            
            .cta-button {
                padding: 1rem 2rem;
                font-size: 0.95rem;
            }
            
            .bottom-info {
                position: absolute;
                bottom: 1rem;
                left: 2rem;
                flex-direction: row;
                gap: 2rem;
                transform: none;
            }
            
            .top-nav {
                top: 1rem;
                left: 2rem;
                transform: none;
            }
        }

        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {
            .floating-card,
            .floating-orb,
            .timeline-dot.active,
            .hero-title .letter,
            .hero-tagline,
            .cta-container,
            .top-nav,
            .bottom-info {
                animation: none;
            }
            
            .hero-title .letter {
                transform: translateY(0);
                opacity: 1;
            }
            
            .hero-tagline,
            .cta-container,
            .top-nav,
            .bottom-info {
                opacity: 1;
            }
        }

        /* High contrast mode */
        @media (prefers-contrast: high) {
            .hero-title {
                color: #000;
            }
            
            .hero-tagline {
                color: #333;
            }
            
            .floating-card {
                border: 2px solid #333;
                background: rgba(255, 255, 255, 0.9);
            }
        }
    </style>
</head>
<body>
    <div class="onboarding-container">
        <!-- Navigation -->
        <nav class="top-nav">
            <a href="#" class="nav-logo">Zenith</a>
        </nav>

        <!-- Floating Background Elements -->
        <div class="floating-elements">
            <div class="floating-orb"></div>
            <div class="floating-orb"></div>
            <div class="floating-orb"></div>
        </div>

        <!-- Background 3D Card -->
        <div class="card-background">
            <div class="floating-card">
                <div class="card-content">
                    <div class="card-header">
                        <div class="card-logo">Zenith</div>
                        <div class="card-status">Active</div>
                    </div>
                    <div class="card-title">Senior Product Designer</div>
                    <div class="card-company">Figma</div>
                    <div class="card-timeline">
                        <div class="timeline-dot active"></div>
                        <div class="timeline-dot"></div>
                        <div class="timeline-dot"></div>
                        <div class="timeline-dot"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="main-content">
            <h1 class="hero-title">
                <span class="word" style="--base-delay: 0.1s;">
                    <span class="letter">F</span><span class="letter">i</span><span class="letter">n</span><span class="letter">d</span>
                </span>
                <span class="word" style="--base-delay: 0.3s;">
                    <span class="letter">Y</span><span class="letter">o</span><span class="letter">u</span><span class="letter">r</span>
                </span>
                <span class="word" style="--base-delay: 0.5s;">
                    <span class="letter">F</span><span class="letter">o</span><span class="letter">c</span><span class="letter">u</span><span class="letter">s</span>
                </span>
            </h1>
            
            <p class="hero-tagline">
                Navigate your job search with calm and clarity
            </p>
            
            <div class="cta-container">
                <button class="cta-button" onclick="beginJourney()">
                    Begin Your Journey
                </button>
            </div>
        </main>

        <!-- Bottom Info -->
        <div class="bottom-info">
            <div class="info-stat">
                <div class="stat-number">97%</div>
                <div class="stat-label">Success Rate</div>
            </div>
            <div class="info-stat">
                <div class="stat-number">15k+</div>
                <div class="stat-label">Active Users</div>
            </div>
            <div class="info-stat">
                <div class="stat-number">$180k</div>
                <div class="stat-label">Avg Salary</div>
            </div>
        </div>
    </div>

    <script>
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Initialize kinetic typography animation
        document.addEventListener('DOMContentLoaded', function() {
            const isTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
            const isMobile = window.innerWidth <= 768;
            
            // Add mousemove/touch parallax effect (only on desktop and large tablets)
            if (!isMobile) {
                document.addEventListener('mousemove', function(e) {
                    const mouseX = (e.clientX / window.innerWidth) * 2 - 1;
                    const mouseY = (e.clientY / window.innerHeight) * 2 - 1;
                    
                    const card = document.querySelector('.floating-card');
                    const orbs = document.querySelectorAll('.floating-orb');
                    
                    // Card parallax
                    const cardX = mouseX * 10;
                    const cardY = mouseY * 10;
                    card.style.transform = `translate(-50%, -50%) rotateX(${15 + mouseY * 5}deg) rotateY(${-10 + mouseX * 5}deg) translateX(${cardX}px) translateY(${cardY}px)`;
                    
                    // Orbs parallax
                    orbs.forEach((orb, index) => {
                        const speed = (index + 1) * 0.5;
                        const x = mouseX * speed * 20;
                        const y = mouseY * speed * 20;
                        orb.style.transform = `translate(${x}px, ${y}px)`;
                    });
                });
            }
            
            // CTA button interactions
            const ctaButton = document.querySelector('.cta-button');
            
            if (!isTouch) {
                ctaButton.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                });
                
                ctaButton.addEventListener('mouseleave', function() {
                    this.style.transform = '';
                });
            }
            
            // Touch interactions for mobile
            if (isTouch) {
                ctaButton.addEventListener('touchstart', function() {
                    this.style.transform = 'translateY(-4px) scale(1.01)';
                });
                
                ctaButton.addEventListener('touchend', function() {
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            }
            
            // Enhanced scroll reveal for mobile
            if (isMobile) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }
                    });
                }, {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                });
                
                const elements = document.querySelectorAll('.hero-tagline, .cta-container, .bottom-info');
                elements.forEach(el => {
                    observer.observe(el);
                });
            }
            
            // Handle orientation changes
            window.addEventListener('orientationchange', function() {
                setTimeout(function() {
                    // Recalculate viewport dimensions after orientation change
                    const vh = window.innerHeight * 0.01;
                    document.documentElement.style.setProperty('--vh', `${vh}px`);
                }, 100);
            });
            
            // Set initial viewport height for mobile browsers
            const vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', `${vh}px`);
        });

        async function beginJourney() {
            const button = event.target;
            
            // Button animation
            button.style.transform = 'translateY(-4px) scale(1.01)';
            button.textContent = 'Starting...';
            button.disabled = true;
            
            try {
                // Check authentication status
                const response = await fetch('/api/auth/check', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const data = await response.json();
                
                // Add loading state
                setTimeout(() => {
                    button.style.background = 'linear-gradient(135deg, #34a853 0%, #2e7d32 100%)';
                    button.textContent = 'Welcome!';
                    
                    // Fade out animation
                    setTimeout(() => {
                        document.body.style.transition = 'opacity 1s ease-out';
                        document.body.style.opacity = '0';
                        
                        setTimeout(() => {
                            if (data.authenticated) {
                                window.location.href = '{{ route("dashboard") }}';
                            } else {
                                window.location.href = '{{ route("auth.page") }}';
                            }
                        }, 1000);
                    }, 800);
                }, 1500);
            } catch (error) {
                console.error('Error checking authentication:', error);
                // Default to login page if there's an error
                setTimeout(() => {
                    window.location.href = '{{ route("auth.page") }}';
                }, 2000);
            }
        }

        // Keyboard accessibility
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && e.target.classList.contains('cta-button')) {
                beginJourney();
            }
        });

        // Preload critical resources
        window.addEventListener('load', function() {
            // Start subtle animations after page load
            setTimeout(() => {
                const card = document.querySelector('.floating-card');
                card.style.animationPlayState = 'running';
            }, 500);
        });
    </script>
</body>
</html>