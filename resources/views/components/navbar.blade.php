<nav class="navbar">
    <div class="brand">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('zenith-logo.png') }}" alt="Zenith" class="brand-logo" width="120px">
        </a>
    </div>
    <div class="nav-links">
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('applications.index') }}" class="nav-link {{ request()->routeIs('applications.*') ? 'active' : '' }}">Applications</a>
        <a href="{{ route('calendar') }}" class="nav-link {{ request()->routeIs('calendar') ? 'active' : '' }}">Calendar</a>
        <a href="{{ route('analytics') }}" class="nav-link {{ request()->routeIs('analytics') ? 'active' : '' }}">Analytics</a>
    </div>
    <div class="user-menu">
        <span class="user-name">{{ $userGreeting ?? 'Welcome, ' . auth()->user()->name . '!' }}</span>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</nav>