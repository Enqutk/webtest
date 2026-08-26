@php
    $current = request()->route()?->getName() ?? '';
    $links = [
        ['label' => 'Home', 'route' => 'home', 'active' => $current === 'home'],
        ['label' => 'About', 'route' => 'about', 'active' => $current === 'about'],
        ['label' => 'Services', 'route' => 'services.index', 'active' => str_starts_with($current, 'services.')],
        ['label' => 'Portfolio', 'route' => 'portfolio.index', 'active' => str_starts_with($current, 'portfolio.')],
        ['label' => 'Contact', 'route' => 'contact', 'active' => $current === 'contact'],
    ];
@endphp

<header class="hz-header" data-hz-header>
    <nav class="navbar navbar-expand-lg hz-navbar" aria-label="Primary">
        <div class="container hz-navbar-inner">
            <a class="navbar-brand hz-brand" href="{{ route('home') }}">
                Veritas <span>Afrika</span>
            </a>

            <button
                class="hz-toggler d-lg-none"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#hzMainNav"
                aria-controls="hzMainNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div class="collapse navbar-collapse hz-nav-collapse" id="hzMainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center hz-nav">
                    @foreach ($links as $link)
                        <li class="nav-item">
                            <a
                                class="nav-link {{ $link['active'] ? 'active' : '' }}"
                                href="{{ route($link['route']) }}"
                                @if($link['active']) aria-current="page" @endif
                            >
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                    <li class="nav-item hz-nav-cta">
                        <a class="btn-hz btn-hz-sm" href="{{ route('contact') }}">Get in touch</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
