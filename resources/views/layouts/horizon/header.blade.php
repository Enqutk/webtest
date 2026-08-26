@php
    $current = request()->route()?->getName();
@endphp

<header class="hz-header">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand hz-brand" href="{{ route('home') }}">
                Veritas <span>Afrika</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#hzMainNav" aria-controls="hzMainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="hzMainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center hz-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ $current === 'home' ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $current === 'about' ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ str_starts_with((string) $current, 'services.') ? 'active' : '' }}" href="{{ route('services.index') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ str_starts_with((string) $current, 'portfolio.') ? 'active' : '' }}" href="{{ route('portfolio.index') }}">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $current === 'contact' ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                    </li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a class="btn-hz" href="{{ route('contact') }}">Get in touch</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
