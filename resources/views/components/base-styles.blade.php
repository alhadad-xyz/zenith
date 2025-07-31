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
        margin: 0;
        padding: 0;
        color: #2d3e2e;
        line-height: 1.5;
    }

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
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: float 20s ease-in-out infinite;
    }

    .floating-circle:nth-child(1) {
        width: 300px;
        height: 300px;
        top: 10%;
        left: 80%;
        animation-delay: 0s;
    }

    .floating-circle:nth-child(2) {
        width: 200px;
        height: 200px;
        top: 60%;
        left: 5%;
        animation-delay: -10s;
    }

    .floating-circle:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 30%;
        left: 20%;
        animation-delay: -5s;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        25% { transform: translateY(-20px) rotate(90deg); }
        50% { transform: translateY(-40px) rotate(180deg); }
        75% { transform: translateY(-20px) rotate(270deg); }
    }

    .container {
        max-width: 1600px;
        margin: 0 auto;
        padding: 2rem;
        position: relative;
    }

    .card {
        backdrop-filter: blur(20px);
        background: rgba(255, 255, 255, 0.25);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 24px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        cursor: pointer;
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .card:hover::before {
        opacity: 1;
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 32px 64px rgba(45, 62, 46, 0.15);
        border-color: rgba(255, 255, 255, 0.5);
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
        text-decoration: none;
        display: inline-block;
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
        background: linear-gradient(135deg, #ff5252 0%, #ff4444 100%);
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
</style>