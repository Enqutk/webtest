<!DOCTYPE html>
<html lang="en" class="h-full bg-[#070b14] text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Design Your Kimem NFC Smart Card & Profile | Mobile Studio</title>
    <meta name="description" content="Customize your luxury NFC smart business card and personalized digital profile website with real-time mobile outcome preview, hero picture, portfolio showcase, and full color palette controls.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Fraunces:opsz,wght@9..144,400;600;700&family=Inter:wght@400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: {
                            400: '#e5c07b',
                            500: '#c5a059',
                            600: '#9e7d3b',
                        }
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                        cinzel: ['Cinzel', 'serif'],
                        fraunces: ['Fraunces', 'serif'],
                        outfit: ['Outfit', 'sans-serif'],
                        inter: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .glass-card {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .phone-frame {
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.8), 0 0 0 8px #1e293b, 0 0 0 10px #334155;
            border-radius: 36px;
        }
        .shape-squircle { border-radius: 28%; }
        .shape-shield { clip-path: polygon(0% 0%, 100% 0%, 100% 75%, 50% 100%, 0% 75%); }
        .shape-arch { border-radius: 100px 100px 16px 16px; }
        .shape-circle { border-radius: 9999px; }
        .shape-star { clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%); }
    </style>
</head>
<body class="min-h-full bg-[#070b14] text-slate-100 antialiased selection:bg-gold-500 selection:text-slate-950 pb-24 lg:pb-12"
      x-data="{
          activeStep: 1,
          previewMode: 'website',
          showMobilePreviewModal: false,
          colorTab: 'palettes', // 'palettes' | 'granular'
          type: 'individual',
          name: '{{ $invitation->client_name ?? 'Alexander Sterling' }}',
          role_title: '{{ $invitation->initial_role ?? 'Senior Partner & Strategic Advisor' }}',
          company_name: '{{ $invitation ? '' : 'Global Advisory Syndicate' }}',
          tagline: 'Architecting high-growth ventures and strategic leadership',
          bio: 'Passionate about engineering clean architectures, strategic growth, and high-impact digital solutions.',
          card_edition: '{{ $invitation->card_edition ?? 'midnight_navy' }}',
          
          // Complete Minor & Major Color System
          bg_color: '#070b14',
          surface_color: '#0f172a',
          accent_color: '#c5a059',
          accent_dark: '#9e7d3b',
          text_color: '#ffffff',
          muted_color: '#94a3b8',
          line_color: '#1e293b',

          font_display: 'Cinzel',
          font_body: 'Outfit',
          image_shape: 'squircle',
          email: '{{ $invitation->client_email ?? '' }}',
          phone: '{{ $invitation->client_phone ?? '' }}',
          telegram: '',
          whatsapp: '',
          linkedin: '',
          github: '',
          website: '',
          photoPreview: null,
          heroPreview: null,
          
          highlight1: '15+ Years Strategic Advisory Leadership',
          highlight2: 'Multi-Industry Investment & Board Experience',
          highlight3: 'Official NFC Touchless Verified Profile',

          // Portfolio Projects Showcase
          proj1_title: 'FinTech Sovereign Cloud Platform',
          proj1_tag: 'Cloud Architecture',
          proj1_desc: 'High-availability cross-border payment clearing ecosystem.',
          proj1_url: 'https://github.com',

          proj2_title: 'Enterprise AI Strategy & Pipeline',
          proj2_tag: 'AI Advisory',
          proj2_desc: 'Automated intelligence pipelines for regional financial funds.',
          proj2_url: '',

          proj3_title: 'Executive Syndicate & Family Office',
          proj3_tag: 'Venture Capital',
          proj3_desc: 'Co-managed $450M syndicated multi-asset investment portfolio.',
          proj3_url: '',

          get quotePrice() {
              if (this.card_edition === 'brushed_gold') return '2,450 ETB';
              if (this.card_edition === 'executive_black') return '2,150 ETB';
              return '1,850 ETB';
          },
          get editionName() {
              if (this.card_edition === 'brushed_gold') return 'Brushed Gold Luxe Edition';
              if (this.card_edition === 'executive_black') return 'Executive Stealth Black';
              return 'Midnight Obsidian Navy';
          },
          setPalette(bg, surface, accent, accentDark, text, muted, line) {
              this.bg_color = bg;
              this.surface_color = surface;
              this.accent_color = accent;
              this.accent_dark = accentDark;
              this.text_color = text;
              this.muted_color = muted;
              this.line_color = line;
          },
          handlePhoto(e) {
              const file = e.target.files[0];
              if (file) {
                  const reader = new FileReader();
                  reader.onload = (ev) => {
                      this.photoPreview = ev.target.result;
                  };
                  reader.readAsDataURL(file);
              }
          },
          handleHero(e) {
              const file = e.target.files[0];
              if (file) {
                  const reader = new FileReader();
                  reader.onload = (ev) => {
                      this.heroPreview = ev.target.result;
                  };
                  reader.readAsDataURL(file);
              }
          }
      }">

    <!-- Top Header -->
    <header class="sticky top-0 z-40 border-b border-slate-800/80 bg-slate-950/90 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14 sm:h-16 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-gold-600 to-amber-300 flex items-center justify-center font-bold text-slate-950 text-sm shadow-md shadow-gold-500/20">
                    K
                </div>
                <div>
                    <span class="font-bold text-sm tracking-wide text-white font-cinzel">KIMEM</span>
                    <span class="text-[9px] block font-mono text-gold-400 font-medium uppercase tracking-widest -mt-1">Smart NFC Studio</span>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" @click="showMobilePreviewModal = true" class="lg:hidden px-3 py-1.5 rounded-xl bg-gold-500 text-slate-950 font-bold text-xs flex items-center gap-1.5 shadow-lg shadow-gold-500/20">
                    <i class="bi bi-eye-fill"></i> Live Preview
                </button>
                <a href="{{ route('card.apply.track') }}" class="hidden sm:flex text-xs text-slate-400 hover:text-white transition items-center gap-1.5 py-1.5 px-3 rounded-lg hover:bg-slate-900">
                    <i class="bi bi-search text-gold-400"></i> Track
                </a>
            </div>
        </div>
    </header>

    <!-- Main Workspace -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- LEFT: Mobile Form Customizer (7 Cols) -->
            <div class="lg:col-span-7 space-y-5">
                
                <!-- VIP Invitation Welcome Banner -->
                @if(isset($invitation) && $invitation)
                    <div class="p-5 sm:p-6 rounded-3xl bg-gradient-to-r from-amber-500/20 via-slate-900 to-slate-900 border border-amber-500/40 shadow-xl space-y-2 relative overflow-hidden">
                        <div class="flex items-center gap-2 text-gold-400 text-xs font-bold uppercase tracking-wider">
                            <i class="bi bi-envelope-check-fill"></i> Private Invitation Active
                        </div>
                        <h1 class="text-xl sm:text-2xl font-bold text-white font-cinzel">
                            Welcome, {{ $invitation->client_name }}!
                        </h1>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            You've been invited by Kimem Cards to customize your contactless NFC smart card, hero cover picture, portfolio showcases, and custom color palette.
                        </p>
                    </div>
                @else
                    <div class="p-5 sm:p-6 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl space-y-2">
                        <span class="inline-block px-2.5 py-1 rounded-full bg-gold-500/10 border border-gold-500/20 text-gold-400 text-[10px] font-bold uppercase tracking-wider">
                            <i class="bi bi-palette"></i> Full Palette & Outcome Studio
                        </span>
                        <h1 class="text-xl sm:text-2xl font-bold text-white font-cinzel">
                            Design Your NFC Smart Card, Colors & Portfolio
                        </h1>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Personalize your digital profile, fine-tune major and minor colors, upload your hero cover picture, and add your showcase projects.
                        </p>
                    </div>
                @endif

                <!-- Stepper Progress Navigation -->
                <div class="grid grid-cols-4 gap-1.5 bg-slate-900/90 p-1 rounded-2xl border border-slate-800">
                    <button type="button" @click="activeStep = 1"
                            :class="activeStep === 1 ? 'bg-gold-500 text-slate-950 font-bold shadow-md shadow-gold-500/20' : 'text-slate-400 hover:text-white'"
                            class="py-2.5 px-2 rounded-xl text-[11px] flex flex-col sm:flex-row items-center justify-center gap-1 transition">
                        <i class="bi bi-person-fill text-xs"></i> <span>1. Identity</span>
                    </button>
                    <button type="button" @click="activeStep = 2"
                            :class="activeStep === 2 ? 'bg-gold-500 text-slate-950 font-bold shadow-md shadow-gold-500/20' : 'text-slate-400 hover:text-white'"
                            class="py-2.5 px-2 rounded-xl text-[11px] flex flex-col sm:flex-row items-center justify-center gap-1 transition">
                        <i class="bi bi-credit-card-2-front-fill text-xs"></i> <span>2. Card</span>
                    </button>
                    <button type="button" @click="activeStep = 3"
                            :class="activeStep === 3 ? 'bg-gold-500 text-slate-950 font-bold shadow-md shadow-gold-500/20' : 'text-slate-400 hover:text-white'"
                            class="py-2.5 px-2 rounded-xl text-[11px] flex flex-col sm:flex-row items-center justify-center gap-1 transition">
                        <i class="bi bi-palette-fill text-xs"></i> <span>3. Colors & Style</span>
                    </button>
                    <button type="button" @click="activeStep = 4"
                            :class="activeStep === 4 ? 'bg-gold-500 text-slate-950 font-bold shadow-md shadow-gold-500/20' : 'text-slate-400 hover:text-white'"
                            class="py-2.5 px-2 rounded-xl text-[11px] flex flex-col sm:flex-row items-center justify-center gap-1 transition">
                        <i class="bi bi-check2-circle text-xs"></i> <span>4. Submit</span>
                    </button>
                </div>

                <!-- Form Container -->
                <form action="{{ route('card.apply.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    @if(isset($invitation) && $invitation)
                        <input type="hidden" name="invitation_token" value="{{ $invitation->token }}">
                    @endif

                    <!-- Hidden inputs for full color persistence -->
                    <input type="hidden" name="bg_color" :value="bg_color">
                    <input type="hidden" name="surface_color" :value="surface_color">
                    <input type="hidden" name="accent_color" :value="accent_color">
                    <input type="hidden" name="accent_dark" :value="accent_dark">
                    <input type="hidden" name="text_color" :value="text_color">
                    <input type="hidden" name="muted_color" :value="muted_color">
                    <input type="hidden" name="line_color" :value="line_color">

                    <!-- STEP 1: Profile, Identity, Headshot & Hero Picture -->
                    <div x-show="activeStep === 1" class="glass-card rounded-3xl p-5 sm:p-7 space-y-5">
                        <div class="border-b border-slate-800 pb-3">
                            <h2 class="text-base font-bold text-white flex items-center gap-2">
                                <i class="bi bi-person-bounding-box text-gold-400"></i> Identity, Avatar & Hero Picture
                            </h2>
                            <p class="text-[11px] text-slate-400">Your profile credentials and hero banner graphics.</p>
                        </div>

                        <!-- Profile Type -->
                        <div class="grid grid-cols-2 gap-2.5">
                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="individual" x-model="type" class="sr-only">
                                <div :class="type === 'individual' ? 'border-gold-500 bg-gold-500/10 text-white' : 'border-slate-800 bg-slate-900/50 text-slate-400'"
                                     class="p-3 rounded-2xl border text-center transition">
                                    <i class="bi bi-person text-lg text-gold-400 block mb-1"></i>
                                    <div class="text-xs font-bold text-white">Individual</div>
                                    <div class="text-[9px] text-slate-400">Professional Profile</div>
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="business" x-model="type" class="sr-only">
                                <div :class="type === 'business' ? 'border-gold-500 bg-gold-500/10 text-white' : 'border-slate-800 bg-slate-900/50 text-slate-400'"
                                     class="p-3 rounded-2xl border text-center transition">
                                    <i class="bi bi-building text-lg text-gold-400 block mb-1"></i>
                                    <div class="text-xs font-bold text-white">Business / Org</div>
                                    <div class="text-[9px] text-slate-400">Company & Services</div>
                                </div>
                            </label>
                        </div>

                        <!-- Name & Role -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-300">Your Full Name *</label>
                                <input type="text" name="name" x-model="name" required placeholder="e.g. Enku Taddesse"
                                       class="w-full px-3.5 py-3 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white focus:border-gold-500">
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-300">Role / Professional Title *</label>
                                <input type="text" name="role_title" x-model="role_title" required placeholder="e.g. Software Engineer & Project Lead"
                                       class="w-full px-3.5 py-3 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white focus:border-gold-500">
                            </div>
                        </div>

                        <!-- Company & Hero Tagline -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-300">Company / University</label>
                                <input type="text" name="company_name" x-model="company_name" placeholder="e.g. Dire Dawa University"
                                       class="w-full px-3.5 py-3 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white focus:border-gold-500">
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-300">Hero Tagline</label>
                                <input type="text" name="tagline" x-model="tagline" placeholder="e.g. Building clean, robust tools"
                                       class="w-full px-3.5 py-3 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white focus:border-gold-500">
                            </div>
                        </div>

                        <!-- Story / Bio -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-300">About Story / Bio</label>
                            <textarea name="bio" x-model="bio" rows="3" placeholder="Brief story about your focus, experience, or track record..."
                                      class="w-full px-3.5 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white focus:border-gold-500"></textarea>
                        </div>

                        <!-- PICTURE UPLOADS: Headshot Avatar + Hero Cover Banner Picture -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-1">
                            <div class="space-y-1.5 p-3.5 rounded-2xl bg-slate-900/70 border border-slate-800">
                                <label class="block text-xs font-bold text-slate-300 flex items-center gap-1.5">
                                    <i class="bi bi-person-circle text-gold-400"></i> Profile Photo / Headshot
                                </label>
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-slate-800 overflow-hidden flex items-center justify-center text-slate-500 shrink-0 border border-slate-700">
                                        <template x-if="photoPreview"><img :src="photoPreview" class="w-full h-full object-cover"></template>
                                        <template x-if="!photoPreview"><i class="bi bi-camera-fill text-lg text-slate-400"></i></template>
                                    </div>
                                    <input type="file" name="photo" @change="handlePhoto" accept="image/*" class="block w-full text-[11px] text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-gold-500 file:text-slate-950 hover:file:bg-gold-400 cursor-pointer">
                                </div>
                            </div>

                            <div class="space-y-1.5 p-3.5 rounded-2xl bg-slate-900/70 border border-slate-800">
                                <label class="block text-xs font-bold text-slate-300 flex items-center gap-1.5">
                                    <i class="bi bi-image text-gold-400"></i> Hero Cover / Banner Picture
                                </label>
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-slate-800 overflow-hidden flex items-center justify-center text-slate-500 shrink-0 border border-slate-700">
                                        <template x-if="heroPreview"><img :src="heroPreview" class="w-full h-full object-cover"></template>
                                        <template x-if="!heroPreview"><i class="bi bi-card-image text-lg text-slate-400"></i></template>
                                    </div>
                                    <input type="file" name="hero_image" @change="handleHero" accept="image/*" class="block w-full text-[11px] text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-gold-500 file:text-slate-950 hover:file:bg-gold-400 cursor-pointer">
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-3">
                            <button type="button" @click="activeStep = 2" class="w-full sm:w-auto px-6 py-3 bg-gold-500 hover:bg-gold-400 text-slate-950 font-bold text-xs rounded-xl transition flex items-center justify-center gap-2 shadow-lg shadow-gold-500/20">
                                Next: Choose Card Edition <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 2: Physical NFC Card Package & Quote -->
                    <div x-show="activeStep === 2" class="glass-card rounded-3xl p-5 sm:p-7 space-y-5" x-cloak>
                        <div class="border-b border-slate-800 pb-3">
                            <h2 class="text-base font-bold text-white flex items-center gap-2">
                                <i class="bi bi-credit-card-2-front-fill text-gold-400"></i> Physical NFC Card Package & Quote
                            </h2>
                            <p class="text-[11px] text-slate-400">Choose your physical luxury card finish.</p>
                        </div>

                        <div class="space-y-2.5">
                            @foreach ($editions as $key => $edition)
                                <label class="block cursor-pointer">
                                    <input type="radio" name="card_edition" value="{{ $key }}" x-model="card_edition" class="sr-only">
                                    <div :class="card_edition === '{{ $key }}' ? 'border-gold-500 bg-gold-500/10 shadow-md shadow-gold-500/10' : 'border-slate-800 bg-slate-900/50'"
                                         class="p-4 rounded-2xl border transition flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-7 rounded-lg bg-gradient-to-br {{ $edition['bg_class'] }} border border-white/20 flex items-center justify-center shrink-0">
                                                <i class="bi bi-wifi text-gold-400 text-[10px] rotate-90"></i>
                                            </div>
                                            <div>
                                                <div class="text-xs font-bold text-white">{{ $edition['name'] }}</div>
                                                <div class="text-[10px] text-slate-400">{{ $edition['subtitle'] }}</div>
                                            </div>
                                        </div>
                                        <div class="text-right shrink-0">
                                            <div class="text-sm font-extrabold text-gold-400 font-cinzel">{{ $edition['price'] }}</div>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <!-- Quote Total Banner -->
                        <div class="p-4 rounded-2xl bg-slate-950 border border-slate-800 flex items-center justify-between">
                            <div>
                                <span class="text-[9px] uppercase font-bold text-slate-400">Quote Estimate</span>
                                <div class="text-xs font-bold text-white truncate" x-text="editionName"></div>
                            </div>
                            <div class="text-right">
                                <div class="text-xl font-extrabold text-gold-400 font-cinzel" x-text="quotePrice"></div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-3 gap-2">
                            <button type="button" @click="activeStep = 1" class="px-4 py-2.5 bg-slate-900 text-slate-300 text-xs rounded-xl">← Back</button>
                            <button type="button" @click="activeStep = 3" class="px-6 py-2.5 bg-gold-500 text-slate-950 font-bold text-xs rounded-xl flex items-center gap-1.5 shadow-lg shadow-gold-500/20">
                                Next: Colors, Portfolio & Styling <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 3: Complete Colors & Minor Accents, Portfolio & Fonts -->
                    <div x-show="activeStep === 3" class="glass-card rounded-3xl p-5 sm:p-7 space-y-6" x-cloak>
                        <div class="border-b border-slate-800 pb-3">
                            <h2 class="text-base font-bold text-white flex items-center gap-2">
                                <i class="bi bi-palette2 text-gold-400"></i> Colors, Minor Accents & Portfolio
                            </h2>
                            <p class="text-[11px] text-slate-400">Customize all major and minor color layers, typography, and projects.</p>
                        </div>

                        <!-- 🎨 COLOR CONTROLS: Presets vs Granular Customization -->
                        <div class="space-y-4 p-4 rounded-2xl bg-slate-950/70 border border-slate-800/90">
                            <div class="flex items-center justify-between border-b border-slate-800 pb-2.5">
                                <label class="text-xs font-bold text-white flex items-center gap-1.5">
                                    <i class="bi bi-palette-fill text-gold-400"></i> Color Theme & Minor Tints
                                </label>
                                <div class="flex bg-slate-900 p-0.5 rounded-lg border border-slate-800 text-[10px]">
                                    <button type="button" @click="colorTab = 'palettes'" :class="colorTab === 'palettes' ? 'bg-gold-500 text-slate-950 font-bold' : 'text-slate-400'" class="px-2 py-0.5 rounded">Presets</button>
                                    <button type="button" @click="colorTab = 'granular'" :class="colorTab === 'granular' ? 'bg-gold-500 text-slate-950 font-bold' : 'text-slate-400'" class="px-2 py-0.5 rounded">Custom Colors</button>
                                </div>
                            </div>

                            <!-- Preset Palettes -->
                            <div x-show="colorTab === 'palettes'" class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                <button type="button" @click="setPalette('#070b14', '#0f172a', '#e5c07b', '#9e7d3b', '#ffffff', '#94a3b8', '#1e293b')"
                                        :class="accent_color === '#e5c07b' ? 'border-gold-500 bg-gold-500/10' : 'border-slate-800 bg-slate-900/60'"
                                        class="p-2.5 rounded-xl border text-left flex items-center gap-2.5 transition">
                                    <div class="w-4 h-4 rounded-full bg-[#e5c07b] border border-white/20 shrink-0"></div>
                                    <div>
                                        <div class="text-[11px] font-bold text-white">Gold & Obsidian</div>
                                        <div class="text-[9px] text-slate-400">Deep Navy & Gold</div>
                                    </div>
                                </button>

                                <button type="button" @click="setPalette('#0c0a06', '#1c1810', '#c5a059', '#e6ca85', '#fffdf7', '#bda780', '#2e2718')"
                                        :class="accent_color === '#c5a059' ? 'border-amber-500 bg-amber-500/10' : 'border-slate-800 bg-slate-900/60'"
                                        class="p-2.5 rounded-xl border text-left flex items-center gap-2.5 transition">
                                    <div class="w-4 h-4 rounded-full bg-[#c5a059] border border-white/20 shrink-0"></div>
                                    <div>
                                        <div class="text-[11px] font-bold text-white">Brushed Gold Luxe</div>
                                        <div class="text-[9px] text-slate-400">Warm 24K Metallic</div>
                                    </div>
                                </button>

                                <button type="button" @click="setPalette('#070b19', '#0f172e', '#6366f1', '#4f46e5', '#ffffff', '#94a3b8', '#1e293b')"
                                        :class="accent_color === '#6366f1' ? 'border-indigo-500 bg-indigo-500/10' : 'border-slate-800 bg-slate-900/60'"
                                        class="p-2.5 rounded-xl border text-left flex items-center gap-2.5 transition">
                                    <div class="w-4 h-4 rounded-full bg-[#6366f1] border border-white/20 shrink-0"></div>
                                    <div>
                                        <div class="text-[11px] font-bold text-white">Indigo & Navy</div>
                                        <div class="text-[9px] text-slate-400">Electric Royal Tint</div>
                                    </div>
                                </button>

                                <button type="button" @click="setPalette('#050d0a', '#0b1a14', '#10b981', '#059669', '#f0fdf4', '#86efac', '#133827')"
                                        :class="accent_color === '#10b981' ? 'border-emerald-500 bg-emerald-500/10' : 'border-slate-800 bg-slate-900/60'"
                                        class="p-2.5 rounded-xl border text-left flex items-center gap-2.5 transition">
                                    <div class="w-4 h-4 rounded-full bg-[#10b981] border border-white/20 shrink-0"></div>
                                    <div>
                                        <div class="text-[11px] font-bold text-white">Emerald Stealth</div>
                                        <div class="text-[9px] text-slate-400">Jade & Obsidian</div>
                                    </div>
                                </button>

                                <button type="button" @click="setPalette('#09090b', '#18181b', '#a1a1aa', '#71717a', '#fafafa', '#a1a1aa', '#27272a')"
                                        :class="accent_color === '#a1a1aa' ? 'border-zinc-500 bg-zinc-500/10' : 'border-slate-800 bg-slate-900/60'"
                                        class="p-2.5 rounded-xl border text-left flex items-center gap-2.5 transition">
                                    <div class="w-4 h-4 rounded-full bg-[#a1a1aa] border border-white/20 shrink-0"></div>
                                    <div>
                                        <div class="text-[11px] font-bold text-white">Dark Titanium</div>
                                        <div class="text-[9px] text-slate-400">Minimalist Mono</div>
                                    </div>
                                </button>

                                <button type="button" @click="setPalette('#0d070b', '#1a0f16', '#f43f5e', '#e11d48', '#fff1f2', '#fda4af', '#2d1522')"
                                        :class="accent_color === '#f43f5e' ? 'border-rose-500 bg-rose-500/10' : 'border-slate-800 bg-slate-900/60'"
                                        class="p-2.5 rounded-xl border text-left flex items-center gap-2.5 transition">
                                    <div class="w-4 h-4 rounded-full bg-[#f43f5e] border border-white/20 shrink-0"></div>
                                    <div>
                                        <div class="text-[11px] font-bold text-white">Rose Velvet</div>
                                        <div class="text-[9px] text-slate-400">Burgundy Accent</div>
                                    </div>
                                </button>
                            </div>

                            <!-- Granular Custom Colors Pickers -->
                            <div x-show="colorTab === 'granular'" class="space-y-3" x-cloak>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <!-- Primary Accent -->
                                    <div class="p-2.5 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-between">
                                        <div>
                                            <div class="text-xs font-bold text-white">Primary Accent Color</div>
                                            <div class="text-[9px] text-slate-400">Buttons, glows & active badges</div>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <input type="color" x-model="accent_color" class="w-7 h-7 rounded bg-transparent border-0 cursor-pointer">
                                            <input type="text" x-model="accent_color" class="w-20 px-2 py-1 bg-slate-950 border border-slate-800 rounded text-[10px] font-mono text-white">
                                        </div>
                                    </div>

                                    <!-- Minor / Dark Accent -->
                                    <div class="p-2.5 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-between">
                                        <div>
                                            <div class="text-xs font-bold text-white">Minor / Secondary Accent</div>
                                            <div class="text-[9px] text-slate-400">Subtle hover rings & icon highlights</div>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <input type="color" x-model="accent_dark" class="w-7 h-7 rounded bg-transparent border-0 cursor-pointer">
                                            <input type="text" x-model="accent_dark" class="w-20 px-2 py-1 bg-slate-950 border border-slate-800 rounded text-[10px] font-mono text-white">
                                        </div>
                                    </div>

                                    <!-- Background Color -->
                                    <div class="p-2.5 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-between">
                                        <div>
                                            <div class="text-xs font-bold text-white">Canvas Background</div>
                                            <div class="text-[9px] text-slate-400">Main page backdrop color</div>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <input type="color" x-model="bg_color" class="w-7 h-7 rounded bg-transparent border-0 cursor-pointer">
                                            <input type="text" x-model="bg_color" class="w-20 px-2 py-1 bg-slate-950 border border-slate-800 rounded text-[10px] font-mono text-white">
                                        </div>
                                    </div>

                                    <!-- Card Surface Color -->
                                    <div class="p-2.5 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-between">
                                        <div>
                                            <div class="text-xs font-bold text-white">Card & Surface Background</div>
                                            <div class="text-[9px] text-slate-400">Project boxes & container cards</div>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <input type="color" x-model="surface_color" class="w-7 h-7 rounded bg-transparent border-0 cursor-pointer">
                                            <input type="text" x-model="surface_color" class="w-20 px-2 py-1 bg-slate-950 border border-slate-800 rounded text-[10px] font-mono text-white">
                                        </div>
                                    </div>

                                    <!-- Text / Heading Ink -->
                                    <div class="p-2.5 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-between">
                                        <div>
                                            <div class="text-xs font-bold text-white">Headings & Primary Text</div>
                                            <div class="text-[9px] text-slate-400">Main titles & names</div>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <input type="color" x-model="text_color" class="w-7 h-7 rounded bg-transparent border-0 cursor-pointer">
                                            <input type="text" x-model="text_color" class="w-20 px-2 py-1 bg-slate-950 border border-slate-800 rounded text-[10px] font-mono text-white">
                                        </div>
                                    </div>

                                    <!-- Muted Subtext -->
                                    <div class="p-2.5 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-between">
                                        <div>
                                            <div class="text-xs font-bold text-white">Muted / Subtitle Text</div>
                                            <div class="text-[9px] text-slate-400">Descriptions & secondary labels</div>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <input type="color" x-model="muted_color" class="w-7 h-7 rounded bg-transparent border-0 cursor-pointer">
                                            <input type="text" x-model="muted_color" class="w-20 px-2 py-1 bg-slate-950 border border-slate-800 rounded text-[10px] font-mono text-white">
                                        </div>
                                    </div>

                                    <!-- Border / Line -->
                                    <div class="p-2.5 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-between sm:col-span-2">
                                        <div>
                                            <div class="text-xs font-bold text-white">Border & Divider Lines</div>
                                            <div class="text-[9px] text-slate-400">Card outlines & section dividers</div>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <input type="color" x-model="line_color" class="w-7 h-7 rounded bg-transparent border-0 cursor-pointer">
                                            <input type="text" x-model="line_color" class="w-20 px-2 py-1 bg-slate-950 border border-slate-800 rounded text-[10px] font-mono text-white">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 📁 PORTFOLIO PROJECTS SECTION -->
                        <div class="space-y-3 pt-2">
                            <label class="block text-xs font-bold text-slate-200 flex items-center gap-1.5">
                                <i class="bi bi-briefcase-fill text-gold-400"></i> Featured Portfolio Projects
                            </label>

                            <!-- Project 1 -->
                            <div class="p-4 rounded-2xl bg-slate-900/80 border border-slate-800 space-y-2.5">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-bold text-gold-400 font-mono">PROJECT 01</span>
                                    <input type="text" name="portfolio[0][tag]" x-model="proj1_tag" placeholder="Tag (e.g. Architecture)" class="w-36 px-2 py-1 bg-slate-950 border border-slate-800 rounded-lg text-[10px] text-slate-300">
                                </div>
                                <input type="text" name="portfolio[0][title]" x-model="proj1_title" placeholder="Project Name / System Title *" class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white">
                                <input type="text" name="portfolio[0][description]" x-model="proj1_desc" placeholder="Short description of achievements or architecture..." class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-xl text-xs text-slate-300">
                                <input type="text" name="portfolio[0][url]" x-model="proj1_url" placeholder="Project Link / Demo URL (Optional)" class="w-full px-3 py-1.5 bg-slate-950 border border-slate-800 rounded-xl text-[11px] text-slate-400">
                            </div>

                            <!-- Project 2 -->
                            <div class="p-4 rounded-2xl bg-slate-900/80 border border-slate-800 space-y-2.5">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-bold text-gold-400 font-mono">PROJECT 02</span>
                                    <input type="text" name="portfolio[1][tag]" x-model="proj2_tag" placeholder="Tag (e.g. AI / Lead)" class="w-36 px-2 py-1 bg-slate-950 border border-slate-800 rounded-lg text-[10px] text-slate-300">
                                </div>
                                <input type="text" name="portfolio[1][title]" x-model="proj2_title" placeholder="Project Name / System Title *" class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white">
                                <input type="text" name="portfolio[1][description]" x-model="proj2_desc" placeholder="Short description of achievements or architecture..." class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-xl text-xs text-slate-300">
                                <input type="text" name="portfolio[1][url]" x-model="proj2_url" placeholder="Project Link / Demo URL (Optional)" class="w-full px-3 py-1.5 bg-slate-950 border border-slate-800 rounded-xl text-[11px] text-slate-400">
                            </div>

                            <!-- Project 3 -->
                            <div class="p-4 rounded-2xl bg-slate-900/80 border border-slate-800 space-y-2.5">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-bold text-gold-400 font-mono">PROJECT 03</span>
                                    <input type="text" name="portfolio[2][tag]" x-model="proj3_tag" placeholder="Tag (e.g. Venture)" class="w-36 px-2 py-1 bg-slate-950 border border-slate-800 rounded-lg text-[10px] text-slate-300">
                                </div>
                                <input type="text" name="portfolio[2][title]" x-model="proj3_title" placeholder="Project Name / System Title *" class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white">
                                <input type="text" name="portfolio[2][description]" x-model="proj3_desc" placeholder="Short description of achievements or architecture..." class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-xl text-xs text-slate-300">
                                <input type="text" name="portfolio[2][url]" x-model="proj3_url" placeholder="Project Link / Demo URL (Optional)" class="w-full px-3 py-1.5 bg-slate-950 border border-slate-800 rounded-xl text-[11px] text-slate-400">
                            </div>
                        </div>

                        <!-- Typography & Shape Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-2 border-t border-slate-800">
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-300">Display Heading Font</label>
                                <select name="font_display" x-model="font_display" class="w-full px-3 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white">
                                    <option value="Outfit">Outfit (Modern Sans)</option>
                                    <option value="Cinzel">Cinzel (Luxury Serif)</option>
                                    <option value="Fraunces">Fraunces (Warm Serif)</option>
                                    <option value="Plus Jakarta Sans">Plus Jakarta Sans (Geometric)</option>
                                    <option value="Inter">Inter (Clean Tech)</option>
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-300">Body Typography</label>
                                <select name="font_body" x-model="font_body" class="w-full px-3 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white">
                                    <option value="Outfit">Outfit (Clean Sans)</option>
                                    <option value="Inter">Inter (High Legibility)</option>
                                    <option value="Plus Jakarta Sans">Plus Jakarta Sans</option>
                                    <option value="Poppins">Poppins (Friendly)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Photo Frame Shape -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-300">Photo Frame Shape</label>
                            <div class="grid grid-cols-5 gap-1.5">
                                @foreach (['squircle' => 'Squircle', 'shield' => 'Shield', 'arch' => 'Arch', 'circle' => 'Round', 'star' => 'Star'] as $shapeKey => $shapeLabel)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="image_shape" value="{{ $shapeKey }}" x-model="image_shape" class="sr-only">
                                        <div :class="image_shape === '{{ $shapeKey }}' ? 'border-gold-500 bg-gold-500/10 text-white' : 'border-slate-800 bg-slate-900/50 text-slate-400'"
                                             class="p-2 rounded-xl border text-center transition">
                                            <div class="w-6 h-6 mx-auto mb-1 bg-slate-700 shape-{{ $shapeKey }}"></div>
                                            <div class="text-[9px] font-bold">{{ $shapeLabel }}</div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-3 gap-2">
                            <button type="button" @click="activeStep = 2" class="px-4 py-2.5 bg-slate-900 text-slate-300 text-xs rounded-xl">← Back</button>
                            <button type="button" @click="activeStep = 4" class="px-6 py-2.5 bg-gold-500 text-slate-950 font-bold text-xs rounded-xl flex items-center gap-1.5 shadow-lg shadow-gold-500/20">
                                Next: Contacts <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 4: Direct Contacts & Submission -->
                    <div x-show="activeStep === 4" class="glass-card rounded-3xl p-5 sm:p-7 space-y-5" x-cloak>
                        <div class="border-b border-slate-800 pb-3">
                            <h2 class="text-base font-bold text-white flex items-center gap-2">
                                <i class="bi bi-send-check-fill text-gold-400"></i> Contact Channels & Submit
                            </h2>
                            <p class="text-[11px] text-slate-400">Add your direct links and submit your quote request.</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-300">Email Address *</label>
                                <input type="email" name="email" x-model="email" required placeholder="you@example.com"
                                       class="w-full px-3.5 py-3 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white focus:border-gold-500">
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-300">Phone / WhatsApp Number *</label>
                                <input type="text" name="phone" x-model="phone" required placeholder="+251 9... / +1 212..."
                                       class="w-full px-3.5 py-3 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white focus:border-gold-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                            <div class="space-y-1">
                                <label class="block text-[10px] text-slate-400">Telegram</label>
                                <input type="text" name="telegram" x-model="telegram" placeholder="@username" class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white">
                            </div>
                            <div class="space-y-1">
                                <label class="block text-[10px] text-slate-400">LinkedIn</label>
                                <input type="text" name="linkedin" x-model="linkedin" placeholder="linkedin.com/in/..." class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white">
                            </div>
                            <div class="space-y-1">
                                <label class="block text-[10px] text-slate-400">GitHub</label>
                                <input type="text" name="github" x-model="github" placeholder="github.com/..." class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white">
                            </div>
                        </div>

                        <!-- Final Quote Summary -->
                        <div class="p-4 rounded-2xl bg-gradient-to-br from-gold-500/10 to-slate-950 border border-gold-500/30 flex items-center justify-between">
                            <div>
                                <span class="text-[9px] uppercase font-bold text-slate-400">Card Package Selected</span>
                                <div class="text-xs font-bold text-white truncate" x-text="editionName"></div>
                            </div>
                            <div class="text-right">
                                <div class="text-xl font-extrabold text-gold-400 font-cinzel" x-text="quotePrice"></div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-3 gap-2">
                            <button type="button" @click="activeStep = 3" class="px-4 py-2.5 bg-slate-900 text-slate-300 text-xs rounded-xl">← Back</button>
                            <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-gold-500 to-amber-400 text-slate-950 font-extrabold text-xs rounded-xl shadow-xl shadow-gold-500/25 flex items-center justify-center gap-1.5">
                                <i class="bi bi-check2-circle text-base"></i> Submit Quote & Request Card
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- RIGHT: Desktop Sticky Live Outcome Preview (5 Cols) -->
            <div class="hidden lg:block lg:col-span-5 lg:sticky lg:top-20 space-y-4">
                
                <!-- Preview Mode Switcher -->
                <div class="flex items-center justify-between bg-slate-900/90 p-2 rounded-2xl border border-slate-800/80">
                    <div class="flex items-center gap-2 px-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-[10px] font-bold text-slate-300 uppercase tracking-wider">Live Outcome</span>
                    </div>

                    <div class="flex gap-1">
                        <button type="button" @click="previewMode = 'website'"
                                :class="previewMode === 'website' ? 'bg-gold-500 text-slate-950 font-bold' : 'text-slate-400 hover:text-white'"
                                class="px-3 py-1 rounded-xl text-xs transition">
                            <i class="bi bi-phone"></i> Website
                        </button>
                        <button type="button" @click="previewMode = 'card'"
                                :class="previewMode === 'card' ? 'bg-gold-500 text-slate-950 font-bold' : 'text-slate-400 hover:text-white'"
                                class="px-3 py-1 rounded-xl text-xs transition">
                            <i class="bi bi-credit-card"></i> NFC Card
                        </button>
                    </div>
                </div>

                <!-- Desktop Phone Frame Mockup with FULL Minor & Major Color Layers -->
                <div x-show="previewMode === 'website'" class="phone-frame border overflow-hidden max-w-[320px] mx-auto"
                     :style="{ backgroundColor: bg_color, borderColor: line_color, fontFamily: font_body, color: text_color }">
                    
                    <!-- Dynamic Hero Cover Picture Banner -->
                    <div class="relative h-28 w-full bg-slate-950 overflow-hidden">
                        <template x-if="heroPreview">
                            <img :src="heroPreview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!heroPreview">
                            <div class="w-full h-full flex items-center justify-center" :style="{ backgroundColor: surface_color }">
                                <i class="bi bi-image text-slate-700 text-2xl"></i>
                            </div>
                        </template>
                        <div class="absolute inset-0" :style="{ background: 'linear-gradient(to top, ' + bg_color + ', transparent)' }"></div>
                    </div>

                    <!-- Profile Info & Avatar -->
                    <div class="px-4 pb-4 -mt-10 relative space-y-3 max-h-[460px] overflow-y-auto text-center">
                        <div class="w-16 h-16 mx-auto overflow-hidden border-2 shadow-2xl relative z-10"
                             :class="'shape-' + image_shape" :style="{ borderColor: accent_color, backgroundColor: surface_color }">
                            <template x-if="photoPreview"><img :src="photoPreview" class="w-full h-full object-cover"></template>
                            <template x-if="!photoPreview"><div class="w-full h-full flex items-center justify-center text-slate-500 font-bold text-sm" x-text="name.charAt(0)"></div></template>
                        </div>

                        <div>
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[8px] font-bold uppercase tracking-wider border"
                                  :style="{ color: accent_color, borderColor: accent_dark + '40', backgroundColor: accent_dark + '20' }" x-text="role_title"></span>
                            <h3 class="text-xs font-bold mt-1.5" :style="{ fontFamily: font_display, color: text_color }" x-text="name"></h3>
                            <p class="text-[9px] mt-0.5 line-clamp-2" :style="{ color: muted_color }" x-text="tagline"></p>
                        </div>

                        <!-- Portfolio Projects Showcase Inside Phone with Surface & Line Colors -->
                        <div class="space-y-1.5 text-left pt-1">
                            <div class="flex items-center justify-between text-[9px] font-bold uppercase" :style="{ color: muted_color }">
                                <span>Portfolio Highlights</span>
                                <span :style="{ color: accent_color }">Verified</span>
                            </div>

                            <template x-if="proj1_title">
                                <div class="p-2.5 rounded-xl border space-y-0.5 transition"
                                     :style="{ backgroundColor: surface_color, borderColor: line_color }">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[9px] font-bold truncate" :style="{ color: text_color }" x-text="proj1_title"></span>
                                        <span class="text-[7px] px-1.5 py-0.5 rounded font-bold font-mono shrink-0"
                                              :style="{ backgroundColor: accent_dark + '30', color: accent_color }" x-text="proj1_tag"></span>
                                    </div>
                                    <p class="text-[8px] line-clamp-1" :style="{ color: muted_color }" x-text="proj1_desc"></p>
                                </div>
                            </template>

                            <template x-if="proj2_title">
                                <div class="p-2.5 rounded-xl border space-y-0.5 transition"
                                     :style="{ backgroundColor: surface_color, borderColor: line_color }">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[9px] font-bold truncate" :style="{ color: text_color }" x-text="proj2_title"></span>
                                        <span class="text-[7px] px-1.5 py-0.5 rounded font-bold font-mono shrink-0"
                                              :style="{ backgroundColor: accent_dark + '30', color: accent_color }" x-text="proj2_tag"></span>
                                    </div>
                                    <p class="text-[8px] line-clamp-1" :style="{ color: muted_color }" x-text="proj2_desc"></p>
                                </div>
                            </template>
                        </div>

                        <!-- Interactive Action CTA Button -->
                        <div class="px-3 py-2 rounded-xl font-bold text-[9px] text-slate-950 inline-block w-full shadow-lg"
                             :style="{ backgroundColor: accent_color }">
                            Connect with <span x-text="name.split(' ')[0]"></span>
                        </div>
                    </div>
                </div>

                <!-- Desktop 3D NFC Card Mockup -->
                <div x-show="previewMode === 'card'" class="max-w-[320px] mx-auto space-y-3" x-cloak>
                    <div :class="{
                            'bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 border-indigo-500/30': card_edition === 'midnight_navy',
                            'bg-gradient-to-br from-amber-950 via-yellow-900 to-stone-900 border-amber-500/40': card_edition === 'brushed_gold',
                            'bg-gradient-to-br from-zinc-950 via-neutral-900 to-black border-zinc-700/50': card_edition === 'executive_black'
                         }"
                         class="aspect-[1.586/1] rounded-2xl p-5 border shadow-2xl relative flex flex-col justify-between overflow-hidden">
                        
                        <div class="flex items-center justify-between relative z-10">
                            <div class="w-8 h-6 rounded bg-gradient-to-br from-yellow-300 to-amber-500 shadow-inner"></div>
                            <i class="bi bi-wifi text-lg text-white/80 rotate-90"></i>
                        </div>

                        <div class="space-y-0.5 relative z-10">
                            <div class="text-[8px] font-mono tracking-widest text-slate-400">KIMEM TOUCHLESS ID</div>
                            <div class="text-sm font-extrabold text-white tracking-wide font-cinzel truncate" x-text="name"></div>
                            <div class="text-[9px] font-medium text-gold-400 truncate" x-text="role_title"></div>
                        </div>

                        <div class="flex items-center justify-between border-t border-white/10 pt-1.5 relative z-10">
                            <span class="text-[9px] font-bold font-cinzel text-white/70">KIMEM CARDS</span>
                            <i class="bi bi-qr-code text-white text-xs"></i>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>

    <!-- MOBILE FLOATING PREVIEW MODAL / DRAWER -->
    <div x-show="showMobilePreviewModal" class="fixed inset-0 z-50 lg:hidden flex flex-col justify-end bg-black/80 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0" x-cloak>
        
        <div class="bg-slate-900 rounded-t-3xl border-t border-slate-800 p-5 space-y-4 max-h-[85vh] overflow-y-auto"
             @click.away="showMobilePreviewModal = false">
            
            <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span class="text-xs font-bold text-white uppercase tracking-wider">Live Outcome Preview</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="flex bg-slate-950 p-1 rounded-xl border border-slate-800">
                        <button type="button" @click="previewMode = 'website'" :class="previewMode === 'website' ? 'bg-gold-500 text-slate-950 font-bold' : 'text-slate-400'" class="px-2.5 py-1 rounded-lg text-[10px]">Website</button>
                        <button type="button" @click="previewMode = 'card'" :class="previewMode === 'card' ? 'bg-gold-500 text-slate-950 font-bold' : 'text-slate-400'" class="px-2.5 py-1 rounded-lg text-[10px]">NFC Card</button>
                    </div>
                    <button type="button" @click="showMobilePreviewModal = false" class="w-8 h-8 rounded-full bg-slate-800 text-slate-300 flex items-center justify-center text-sm">✕</button>
                </div>
            </div>

            <!-- Mobile Phone Simulator Inside Modal with Full Color Bindings -->
            <div x-show="previewMode === 'website'" class="phone-frame border overflow-hidden max-w-[280px] mx-auto"
                 :style="{ backgroundColor: bg_color, borderColor: line_color, fontFamily: font_body, color: text_color }">
                
                <div class="relative h-24 w-full bg-slate-950 overflow-hidden">
                    <template x-if="heroPreview"><img :src="heroPreview" class="w-full h-full object-cover"></template>
                    <template x-if="!heroPreview"><div class="w-full h-full flex items-center justify-center" :style="{ backgroundColor: surface_color }"><i class="bi bi-image text-slate-700"></i></div></template>
                    <div class="absolute inset-0" :style="{ background: 'linear-gradient(to top, ' + bg_color + ', transparent)' }"></div>
                </div>

                <div class="px-3 pb-3 -mt-8 relative space-y-2.5 text-center">
                    <div class="w-14 h-14 mx-auto overflow-hidden border-2 shadow-lg relative z-10"
                         :class="'shape-' + image_shape" :style="{ borderColor: accent_color, backgroundColor: surface_color }">
                        <template x-if="photoPreview"><img :src="photoPreview" class="w-full h-full object-cover"></template>
                        <template x-if="!photoPreview"><div class="w-full h-full flex items-center justify-center text-slate-500 font-bold text-xs" x-text="name.charAt(0)"></div></template>
                    </div>

                    <h3 class="text-xs font-bold" :style="{ fontFamily: font_display, color: text_color }" x-text="name"></h3>
                    <p class="text-[9px] line-clamp-1" :style="{ color: muted_color }" x-text="tagline"></p>

                    <!-- Portfolio Items in Mobile -->
                    <div class="space-y-1 text-left">
                        <template x-if="proj1_title">
                            <div class="p-1.5 rounded-lg border flex items-center justify-between"
                                 :style="{ backgroundColor: surface_color, borderColor: line_color }">
                                <span class="text-[8px] font-bold truncate" :style="{ color: text_color }" x-text="proj1_title"></span>
                                <span class="text-[7px] font-mono px-1 py-0.2 rounded" :style="{ backgroundColor: accent_dark + '30', color: accent_color }" x-text="proj1_tag"></span>
                            </div>
                        </template>
                        <template x-if="proj2_title">
                            <div class="p-1.5 rounded-lg border flex items-center justify-between"
                                 :style="{ backgroundColor: surface_color, borderColor: line_color }">
                                <span class="text-[8px] font-bold truncate" :style="{ color: text_color }" x-text="proj2_title"></span>
                                <span class="text-[7px] font-mono px-1 py-0.2 rounded" :style="{ backgroundColor: accent_dark + '30', color: accent_color }" x-text="proj2_tag"></span>
                            </div>
                        </template>
                    </div>

                    <div class="px-3 py-1 rounded-xl font-bold text-[8px] text-slate-950 inline-block w-full"
                         :style="{ backgroundColor: accent_color }">
                        Connect with <span x-text="name.split(' ')[0]"></span>
                    </div>
                </div>
            </div>

            <!-- Mobile 3D NFC Card Inside Modal -->
            <div x-show="previewMode === 'card'" class="max-w-[280px] mx-auto" x-cloak>
                <div :class="{
                        'bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 border-indigo-500/30': card_edition === 'midnight_navy',
                        'bg-gradient-to-br from-amber-950 via-yellow-900 to-stone-900 border-amber-500/40': card_edition === 'brushed_gold',
                        'bg-gradient-to-br from-zinc-950 via-neutral-900 to-black border-zinc-700/50': card_edition === 'executive_black'
                     }"
                     class="aspect-[1.586/1] rounded-2xl p-4 border shadow-2xl relative flex flex-col justify-between overflow-hidden">
                    <div class="flex items-center justify-between">
                        <div class="w-7 h-5 rounded bg-gradient-to-br from-yellow-300 to-amber-500"></div>
                        <i class="bi bi-wifi text-base text-white/80 rotate-90"></i>
                    </div>
                    <div>
                        <div class="text-[8px] font-mono tracking-widest text-slate-400">KIMEM TOUCHLESS ID</div>
                        <div class="text-xs font-extrabold text-white font-cinzel truncate" x-text="name"></div>
                        <div class="text-[9px] font-medium text-gold-400 truncate" x-text="role_title"></div>
                    </div>
                    <div class="flex items-center justify-between border-t border-white/10 pt-1">
                        <span class="text-[8px] font-bold font-cinzel text-white/70">KIMEM CARDS</span>
                        <i class="bi bi-qr-code text-white text-xs"></i>
                    </div>
                </div>
            </div>

            <button type="button" @click="showMobilePreviewModal = false" class="w-full py-2.5 rounded-xl bg-slate-800 text-white font-bold text-xs">
                Continue Customizing
            </button>
        </div>
    </div>

    <!-- Mobile Bottom Floating Action Bar -->
    <div class="fixed bottom-0 inset-x-0 z-30 lg:hidden p-3 bg-slate-950/95 border-t border-slate-800/80 backdrop-blur-xl flex items-center justify-between gap-2">
        <button type="button" @click="showMobilePreviewModal = true" class="flex-1 py-2.5 px-3 rounded-xl bg-slate-900 border border-slate-800 text-xs font-bold text-white flex items-center justify-center gap-1.5">
            <i class="bi bi-phone text-gold-400"></i> View Live Outcome
        </button>
        <button type="button" @click="activeStep < 4 ? activeStep++ : document.querySelector('form').requestSubmit()" class="flex-1 py-2.5 px-3 rounded-xl bg-gold-500 text-slate-950 font-extrabold text-xs flex items-center justify-center gap-1 shadow-md shadow-gold-500/20">
            <span x-text="activeStep === 4 ? 'Submit Request' : 'Next Step →'"></span>
        </button>
    </div>

</body>
</html>
