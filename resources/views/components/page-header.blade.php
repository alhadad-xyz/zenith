@props(['title', 'subtitle' => null])

<header class="header">
    <h1 class="logo">{{ $title }}</h1>
    @if($subtitle)
        <p class="subtitle">{{ $subtitle }}</p>
    @endif
    {{ $slot }}
</header>

<style>
    .header {
        margin-bottom: 3rem;
        text-align: center;
    }

    .logo {
        font-size: 2.5rem;
        font-weight: 800;
        color: #2d3e2e;
        letter-spacing: -0.02em;
        margin-bottom: 0.5rem;
    }

    .subtitle {
        font-size: 1.1rem;
        color: #6b7c6d;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .logo {
            font-size: 2rem;
        }
        
        .subtitle {
            font-size: 1rem;
        }
        
        .header {
            margin-bottom: 2rem;
        }
    }
</style>