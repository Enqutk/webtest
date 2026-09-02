<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Card Application | Kimem Smart NFC</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { gold: { 400: '#e5c07b', 500: '#c5a059', 600: '#9e7d3b' } },
                    fontFamily: { sans: ['Outfit', 'sans-serif'], cinzel: ['Cinzel', 'serif'] }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="min-h-full bg-[#070b14] flex flex-col justify-between antialiased">
    
    <header class="border-b border-slate-800/80 bg-slate-950/80 backdrop-blur-xl">
        <div class="max-w-4xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-gold-600 to-amber-300 flex items-center justify-center font-bold text-slate-950 text-sm">K</div>
                <span class="font-bold text-sm tracking-wide font-cinzel text-white">KIMEM CARDS</span>
            </a>
            <a href="{{ route('card.apply') }}" class="text-xs text-gold-400 hover:text-gold-300 transition">+ New Application</a>
        </div>
    </header>

    <main class="max-w-lg mx-auto px-4 py-12 w-full">
        <div class="p-8 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl space-y-6">
            
            <div class="text-center space-y-2">
                <h1 class="text-xl font-bold text-white font-cinzel">Track Application Status</h1>
                <p class="text-xs text-slate-400">Enter your KIMEM tracking code below.</p>
            </div>

            <form action="{{ route('card.apply.track') }}" method="GET" class="flex gap-2">
                <input type="text" name="code" value="{{ $code }}" required placeholder="e.g. KIMEM-26-A1B2"
                       class="flex-1 px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white uppercase tracking-wider font-mono focus:border-gold-500">
                <button type="submit" class="px-5 py-2.5 bg-gold-500 hover:bg-gold-400 text-slate-950 font-bold text-xs rounded-xl transition">
                    Track
                </button>
            </form>

            @if($code && !$application)
                <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs text-center">
                    No application found for reference code <strong>{{ $code }}</strong>.
                </div>
            @endif

            @if($application)
                <div class="p-5 rounded-2xl bg-slate-950 border border-slate-800 space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                        <div>
                            <div class="text-sm font-bold text-white">{{ $application->name }}</div>
                            <div class="text-[10px] text-slate-400">{{ $application->role_title }}</div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $application->getBadgeClass() }}">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div class="p-2 rounded-xl bg-slate-900/50">
                            <span class="text-[10px] text-slate-500 block">Package</span>
                            <span class="text-white font-medium">{{ $application->getCardEditionTitle() }}</span>
                        </div>
                        <div class="p-2 rounded-xl bg-slate-900/50">
                            <span class="text-[10px] text-slate-500 block">Quote</span>
                            <span class="text-gold-400 font-bold">{{ $application->quote_amount }}</span>
                        </div>
                    </div>

                    @if($application->status === 'approved' && $application->organization)
                        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-center space-y-2">
                            <div class="text-xs font-bold text-emerald-400">🎉 Your Digital Website is Live!</div>
                            <a href="{{ route('card.home', ['slug' => $application->organization->slug]) }}" target="_blank"
                               class="inline-block px-4 py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs rounded-lg transition">
                                Open /card/{{ $application->organization->slug }} →
                            </a>
                        </div>
                    @else
                        <div class="p-3 rounded-xl bg-amber-500/10 border border-amber-500/20 text-[11px] text-amber-300 text-center">
                            ⏳ Application under administrative review.
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </main>

    <footer class="py-6 text-center text-xs text-slate-500 border-t border-slate-900">
        &copy; {{ date('Y') }} Kimem Smart Cards & Technology. All rights reserved.
    </footer>
</body>
</html>
