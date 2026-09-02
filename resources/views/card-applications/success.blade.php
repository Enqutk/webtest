<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Received | Kimem Smart NFC Studio</title>
    <!-- Fonts -->
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
    
    <!-- Top Header -->
    <header class="border-b border-slate-800/80 bg-slate-950/80 backdrop-blur-xl">
        <div class="max-w-4xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-gold-600 to-amber-300 flex items-center justify-center font-bold text-slate-950 text-sm">K</div>
                <span class="font-bold text-sm tracking-wide font-cinzel text-white">KIMEM CARDS</span>
            </a>
            <a href="/" class="text-xs text-slate-400 hover:text-white transition">← Home</a>
        </div>
    </header>

    <!-- Content Card -->
    <main class="max-w-xl mx-auto px-4 py-12 w-full">
        <div class="p-8 sm:p-10 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl space-y-6 text-center">
            
            <div class="w-16 h-16 mx-auto rounded-3xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center text-3xl shadow-lg shadow-emerald-500/10 animate-bounce">
                <i class="bi bi-check-lg"></i>
            </div>

            <div>
                <span class="text-[10px] font-bold text-gold-400 tracking-widest uppercase bg-gold-500/10 px-3 py-1 rounded-full border border-gold-500/20">Quote Request Submitted</span>
                <h1 class="text-2xl font-bold text-white mt-3 font-cinzel">We Have Received Your Application!</h1>
                <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                    Thank you, <strong class="text-white">{{ $application->name }}</strong>. Your custom card design and digital website request has been registered and is pending admin approval.
                </p>
            </div>

            <!-- Application Reference Badge -->
            <div class="p-4 rounded-2xl bg-slate-950 border border-slate-800 flex items-center justify-between text-left">
                <div>
                    <span class="text-[10px] uppercase font-bold text-slate-500 block">Your Tracking Code</span>
                    <span class="font-mono text-base font-extrabold text-gold-400">{{ $application->reference_code }}</span>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $application->getBadgeClass() }}">
                    {{ ucfirst($application->status) }}
                </span>
            </div>

            <!-- Summary Breakdown -->
            <div class="p-4 rounded-2xl bg-slate-950/60 border border-slate-800/80 text-xs space-y-2 text-left">
                <div class="flex justify-between py-1 border-b border-slate-800/60">
                    <span class="text-slate-400">Card Package:</span>
                    <span class="font-bold text-white">{{ $application->getCardEditionTitle() }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-800/60">
                    <span class="text-slate-400">Approved Quote:</span>
                    <span class="font-bold text-gold-400 font-cinzel">{{ $application->quote_amount }}</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-slate-400">Target URL upon Approval:</span>
                    <span class="font-mono text-slate-300">/card/{{ $application->slug }}</span>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="text-left bg-gold-500/5 p-4 rounded-2xl border border-gold-500/15 space-y-1.5 text-xs text-slate-300">
                <div class="font-bold text-gold-400 flex items-center gap-1.5"><i class="bi bi-info-circle-fill"></i> What happens next?</div>
                <p class="text-[11px] text-slate-400">1. Our administrator will review your quote and activate your account.</p>
                <p class="text-[11px] text-slate-400">2. You will receive an onboarding notification with your live site credentials.</p>
                <p class="text-[11px] text-slate-400">3. Your physical NFC luxury card will be programmed and dispatched.</p>
            </div>

            <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('card.apply.track', ['code' => $application->reference_code]) }}" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-bold text-white transition">
                    <i class="bi bi-clock-history"></i> Check Live Status
                </a>
                <a href="/" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-gold-500 hover:bg-gold-400 text-xs font-bold text-slate-950 transition shadow-lg shadow-gold-500/20">
                    Return to Home
                </a>
            </div>

        </div>
    </main>

    <footer class="py-6 text-center text-xs text-slate-500 border-t border-slate-900">
        &copy; {{ date('Y') }} Kimem Smart Cards & Technology. All rights reserved.
    </footer>
</body>
</html>
