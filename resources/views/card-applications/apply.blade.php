<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Design Your Kimem NFC Smart Card & Website | Live Customizer</title>
    <meta name="description" content="Customize your luxury NFC smart business card and personalized digital profile website with real-time interactive preview.">

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
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .phone-frame {
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.8), 0 0 0 10px #1e293b, 0 0 0 12px #334155;
            border-radius: 40px;
        }
        /* Custom image shapes */
        .shape-squircle { border-radius: 28%; }
        .shape-shield { clip-path: polygon(0% 0%, 100% 0%, 100% 75%, 50% 100%, 0% 75%); }
        .shape-arch { border-radius: 100px 100px 16px 16px; }
        .shape-circle { border-radius: 9999px; }
        .shape-star { clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%); }
    </style>
</head>
<body class="h-full bg-[#070b14] text-slate-100 antialiased selection:bg-gold-500 selection:text-slate-950"
      x-data="{
          activeStep: 1,
          previewMode: 'website', // 'website' | 'card'
          type: 'individual',
          name: 'Enku Taddesse',
          role_title: 'Software Engineer & Project Lead',
          company_name: 'Dire Dawa University',
          tagline: 'Building clean, robust tools that solve real problems',
          bio: 'Passionate about engineering clean architectures, open-source tooling, and meaningful digital experiences.',
          card_edition: 'midnight_navy',
          bg_color: '#0b0f19',
          accent_color: '#eab308',
          font_display: 'Outfit',
          font_body: 'Outfit',
          image_shape: 'squircle',
          email: 'enkukokob@gmail.com',
          phone: '+251 931 727 965',
          telegram: '@enku_t',
          whatsapp: '+251931727965',
          linkedin: 'https://linkedin.com/in/enku',
          github: 'https://github.com/Enqutk',
          website: 'https://enkutadesse.bio',
          photoPreview: null,
          highlight1: 'Intern Project Manager at Teter Trending PLC (2026)',
          highlight2: 'Core Lead at DDU ICT Club Innovation Team',
          highlight3: '12+ Production Web & Mobile Platforms Built',

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
          handlePhoto(e) {
              const file = e.target.files[0];
              if (file) {
                  const reader = new FileReader();
                  reader.onload = (ev) => {
                      this.photoPreview = ev.target.result;
                  };
                  reader.readAsDataURL(file);
              }
          }
      }">

    <!-- Top Navigation Header -->
    <header class="sticky top-0 z-50 border-b border-slate-800/80 bg-slate-950/80 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-gold-600 to-amber-300 flex items-center justify-center font-bold text-slate-950 text-base shadow-lg shadow-gold-500/20 group-hover:scale-105 transition">
                    K
                </div>
                <div>
                    <span class="font-bold text-base tracking-wide text-white font-cinzel">KIMEM</span>
                    <span class="text-[10px] block font-mono text-gold-400 font-medium uppercase tracking-widest -mt-1">Smart NFC Studio</span>
                </div>
            </a>

            <div class="flex items-center gap-4">
                <a href="{{ route('card.apply.track') }}" class="text-xs text-slate-400 hover:text-white transition flex items-center gap-1.5 py-1.5 px-3 rounded-lg hover:bg-slate-900 border border-transparent hover:border-slate-800">
                    <i class="bi bi-search text-gold-400"></i> Track Existing Quote
                </a>
                <a href="/" class="text-xs text-slate-400 hover:text-white transition py-1.5 px-3">
                    ← Back to Kimem Cards
                </a>
            </div>
        </div>
    </header>

    <!-- Main Workspace -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">

            <!-- LEFT: Interactive Multi-Step Builder Form (7 Cols) -->
            <div class="lg:col-span-7 space-y-6">
                
                <!-- Hero Intro Banner -->
                <div class="p-6 rounded-3xl bg-gradient-to-br from-slate-900 via-slate-900/90 to-slate-950 border border-slate-800/80 shadow-2xl relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-gold-500/10 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gold-500/10 border border-gold-500/20 text-gold-400 text-xs font-semibold uppercase tracking-wider mb-3">
                        <i class="bi bi-lightning-charge-fill"></i> Instant Customizer & Live Outcome Preview
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight font-cinzel">
                        Design Your Custom NFC Smart Card & Website
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-400 mt-2 leading-relaxed">
                        Customize your profile, Google typography, card finish, and brand colors. See your **instant live preview** update in real time, then submit for admin quote approval and 1-click activation.
                    </p>
                </div>

                <!-- Form Step Navigation Tabs -->
                <div class="grid grid-cols-4 gap-2 bg-slate-900/80 p-1.5 rounded-2xl border border-slate-800/80">
                    <button type="button" @click="activeStep = 1"
                            :class="activeStep === 1 ? 'bg-gold-500 text-slate-950 font-bold shadow-lg shadow-gold-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'"
                            class="py-2.5 px-3 rounded-xl text-xs flex flex-col sm:flex-row items-center justify-center gap-1.5 transition">
                        <i class="bi bi-person-badge"></i> <span>1. Identity</span>
                    </button>
                    <button type="button" @click="activeStep = 2"
                            :class="activeStep === 2 ? 'bg-gold-500 text-slate-950 font-bold shadow-lg shadow-gold-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'"
                            class="py-2.5 px-3 rounded-xl text-xs flex flex-col sm:flex-row items-center justify-center gap-1.5 transition">
                        <i class="bi bi-credit-card-2-front"></i> <span>2. Card & Quote</span>
                    </button>
                    <button type="button" @click="activeStep = 3"
                            :class="activeStep === 3 ? 'bg-gold-500 text-slate-950 font-bold shadow-lg shadow-gold-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'"
                            class="py-2.5 px-3 rounded-xl text-xs flex flex-col sm:flex-row items-center justify-center gap-1.5 transition">
                        <i class="bi bi-palette"></i> <span>3. Styling</span>
                    </button>
                    <button type="button" @click="activeStep = 4"
                            :class="activeStep === 4 ? 'bg-gold-500 text-slate-950 font-bold shadow-lg shadow-gold-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'"
                            class="py-2.5 px-3 rounded-xl text-xs flex flex-col sm:flex-row items-center justify-center gap-1.5 transition">
                        <i class="bi bi-send-check"></i> <span>4. Review</span>
                    </button>
                </div>

                <!-- Form Container -->
                <form action="{{ route('card.apply.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- STEP 1: Identity & Profile Details -->
                    <div x-show="activeStep === 1" class="glass-card rounded-3xl p-6 sm:p-8 space-y-6">
                        <div class="border-b border-slate-800/80 pb-4">
                            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                <i class="bi bi-person-fill text-gold-400"></i> Profile Type & Identity
                            </h2>
                            <p class="text-xs text-slate-400 mt-0.5">Tell us who this card & website is for.</p>
                        </div>

                        <!-- Profile Type Switcher -->
                        <div class="grid grid-cols-2 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="individual" x-model="type" class="sr-only">
                                <div :class="type === 'individual' ? 'border-gold-500 bg-gold-500/10 text-white' : 'border-slate-800 bg-slate-900/50 text-slate-400'"
                                     class="p-4 rounded-2xl border flex items-center gap-3 transition">
                                    <div class="w-8 h-8 rounded-xl bg-slate-800 flex items-center justify-center text-gold-400">
                                        <i class="bi bi-person-bounding-box text-base"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-white">Individual Professional</div>
                                        <div class="text-[10px] text-slate-400">Executive, Engineer, Consultant</div>
                                    </div>
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="business" x-model="type" class="sr-only">
                                <div :class="type === 'business' ? 'border-gold-500 bg-gold-500/10 text-white' : 'border-slate-800 bg-slate-900/50 text-slate-400'"
                                     class="p-4 rounded-2xl border flex items-center gap-3 transition">
                                    <div class="w-8 h-8 rounded-xl bg-slate-800 flex items-center justify-center text-gold-400">
                                        <i class="bi bi-building text-base"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-white">Company / Business</div>
                                        <div class="text-[10px] text-slate-400">Firm, Agency, Organization</div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Name & Role -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-300">Full Name / Brand Name *</label>
                                <input type="text" name="name" x-model="name" required placeholder="e.g. Enku Taddesse"
                                       class="w-full px-4 py-3 bg-slate-900/90 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-500 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition">
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-300">Role / Professional Title *</label>
                                <input type="text" name="role_title" x-model="role_title" required placeholder="e.g. Software Engineer & Project Lead"
                                       class="w-full px-4 py-3 bg-slate-900/90 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-500 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition">
                            </div>
                        </div>

                        <!-- Company / University & Tagline -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-300">Company / University / Institution</label>
                                <input type="text" name="company_name" x-model="company_name" placeholder="e.g. Dire Dawa University"
                                       class="w-full px-4 py-3 bg-slate-900/90 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-500 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition">
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-300">Hero Tagline</label>
                                <input type="text" name="tagline" x-model="tagline" placeholder="e.g. Building clean, robust tools"
                                       class="w-full px-4 py-3 bg-slate-900/90 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-500 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition">
                            </div>
                        </div>

                        <!-- Bio / Story -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-300">About Story / Summary</label>
                            <textarea name="bio" x-model="bio" rows="3" placeholder="Brief story or background about your experience and focus..."
                                      class="w-full px-4 py-3 bg-slate-900/90 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-500 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition"></textarea>
                        </div>

                        <!-- Headshot Photo Upload with instant preview -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-300">Profile Photo / Headshot</label>
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-900/60 border border-dashed border-slate-700">
                                <div class="w-14 h-14 rounded-2xl bg-slate-800 overflow-hidden flex items-center justify-center text-slate-500 shrink-0 border border-slate-700">
                                    <template x-if="photoPreview">
                                        <img :src="photoPreview" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!photoPreview">
                                        <i class="bi bi-camera text-xl text-slate-400"></i>
                                    </template>
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="photo" @change="handlePhoto" accept="image/*" class="block w-full text-xs text-slate-400 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-gold-500 file:text-slate-950 hover:file:bg-gold-400 cursor-pointer">
                                    <p class="text-[10px] text-slate-500 mt-1">PNG, JPG, WEBP up to 5MB. Real-time preview updates immediately.</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="button" @click="activeStep = 2" class="px-6 py-3 bg-gold-500 hover:bg-gold-400 text-slate-950 font-bold text-xs rounded-xl transition flex items-center gap-2 shadow-lg shadow-gold-500/20">
                                Next: Choose Card Edition & Quote <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 2: Physical NFC Card Edition & Quote Selection -->
                    <div x-show="activeStep === 2" class="glass-card rounded-3xl p-6 sm:p-8 space-y-6" x-cloak>
                        <div class="border-b border-slate-800/80 pb-4">
                            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                <i class="bi bi-credit-card-2-front-fill text-gold-400"></i> Physical NFC Card Package & Quote
                            </h2>
                            <p class="text-xs text-slate-400 mt-0.5">Select the physical finish for your contactless NFC luxury card.</p>
                        </div>

                        <!-- Card Edition Cards -->
                        <div class="space-y-3">
                            @foreach ($editions as $key => $edition)
                                <label class="block cursor-pointer">
                                    <input type="radio" name="card_edition" value="{{ $key }}" x-model="card_edition" class="sr-only">
                                    <div :class="card_edition === '{{ $key }}' ? 'border-gold-500 bg-gold-500/10 shadow-lg shadow-gold-500/10' : 'border-slate-800 bg-slate-900/50 hover:border-slate-700'"
                                         class="p-5 rounded-2xl border transition flex items-center justify-between gap-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-8 rounded-lg bg-gradient-to-br {{ $edition['bg_class'] }} border border-white/20 flex items-center justify-center shrink-0 shadow-md">
                                                <i class="bi bi-wifi text-gold-400 text-xs rotate-90"></i>
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-sm font-bold text-white">{{ $edition['name'] }}</span>
                                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-slate-800 text-gold-400 border border-gold-500/20">{{ $edition['badge'] }}</span>
                                                </div>
                                                <div class="text-xs text-slate-400 mt-0.5">{{ $edition['subtitle'] }}</div>
                                            </div>
                                        </div>
                                        <div class="text-right shrink-0">
                                            <div class="text-base font-extrabold text-gold-400 font-cinzel">{{ $edition['price'] }}</div>
                                            <div class="text-[10px] text-slate-500">Includes live website & NFC card</div>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <!-- Quote Summary Card -->
                        <div class="p-5 rounded-2xl bg-gradient-to-br from-slate-900 via-slate-900 to-slate-950 border border-slate-800 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Quote Estimate</span>
                                <div class="text-lg font-bold text-white" x-text="editionName"></div>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-extrabold text-gold-400 font-cinzel" x-text="quotePrice"></div>
                                <span class="text-[10px] text-emerald-400 flex items-center justify-end gap-1"><i class="bi bi-check-circle-fill"></i> Zero Hosting Setup Fee</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4">
                            <button type="button" @click="activeStep = 1" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-slate-300 font-medium text-xs rounded-xl transition">
                                ← Back
                            </button>
                            <button type="button" @click="activeStep = 3" class="px-6 py-3 bg-gold-500 hover:bg-gold-400 text-slate-950 font-bold text-xs rounded-xl transition flex items-center gap-2 shadow-lg shadow-gold-500/20">
                                Next: Aesthetic & Styling <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 3: Aesthetic, Colors, Typography & Shapes -->
                    <div x-show="activeStep === 3" class="glass-card rounded-3xl p-6 sm:p-8 space-y-6" x-cloak>
                        <div class="border-b border-slate-800/80 pb-4">
                            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                <i class="bi bi-palette-fill text-gold-400"></i> Colors, Google Fonts & Photo Shape
                            </h2>
                            <p class="text-xs text-slate-400 mt-0.5">Customize the visual styling of your dedicated digital website.</p>
                        </div>

                        <!-- Color Themes Quick Presets -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-300">Quick Palette Presets</label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                <button type="button" @click="bg_color = '#0b0f19'; accent_color = '#eab308'" class="p-2.5 rounded-xl border border-slate-800 bg-slate-900/60 hover:border-gold-500 flex items-center gap-2 text-left transition">
                                    <div class="w-4 h-4 rounded-full bg-[#eab308] shrink-0"></div>
                                    <span class="text-[11px] text-white">Gold & Obsidian</span>
                                </button>
                                <button type="button" @click="bg_color = '#090d16'; accent_color = '#6366f1'" class="p-2.5 rounded-xl border border-slate-800 bg-slate-900/60 hover:border-indigo-500 flex items-center gap-2 text-left transition">
                                    <div class="w-4 h-4 rounded-full bg-[#6366f1] shrink-0"></div>
                                    <span class="text-[11px] text-white">Indigo & Navy</span>
                                </button>
                                <button type="button" @click="bg_color = '#050a0e'; accent_color = '#10b981'" class="p-2.5 rounded-xl border border-slate-800 bg-slate-900/60 hover:border-emerald-500 flex items-center gap-2 text-left transition">
                                    <div class="w-4 h-4 rounded-full bg-[#10b981] shrink-0"></div>
                                    <span class="text-[11px] text-white">Emerald Slate</span>
                                </button>
                                <button type="button" @click="bg_color = '#0f0a14'; accent_color = '#f43f5e'" class="p-2.5 rounded-xl border border-slate-800 bg-slate-900/60 hover:border-rose-500 flex items-center gap-2 text-left transition">
                                    <div class="w-4 h-4 rounded-full bg-[#f43f5e] shrink-0"></div>
                                    <span class="text-[11px] text-white">Rose Burgundy</span>
                                </button>
                            </div>
                        </div>

                        <!-- Custom Colors & Fonts Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-300">Accent Brand Color</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" name="accent_color" x-model="accent_color" class="w-10 h-10 rounded-xl bg-transparent border-0 cursor-pointer">
                                    <input type="text" x-model="accent_color" class="flex-1 px-3 py-2 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white">
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-300">Display Heading Font</label>
                                <select name="font_display" x-model="font_display" class="w-full px-3 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white">
                                    <option value="Outfit">Outfit (Modern Sans)</option>
                                    <option value="Cinzel">Cinzel (Luxury Serif)</option>
                                    <option value="Fraunces">Fraunces (Warm Serif)</option>
                                    <option value="Plus Jakarta Sans">Plus Jakarta Sans (Geometric)</option>
                                    <option value="Inter">Inter (Clean Tech)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Image Shape Selector -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-300">Hero Headshot Frame Shape</label>
                            <div class="grid grid-cols-5 gap-2">
                                @foreach (['squircle' => 'Squircle', 'shield' => 'Shield', 'arch' => 'Arch', 'circle' => 'Round', 'star' => 'Star'] as $shapeKey => $shapeLabel)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="image_shape" value="{{ $shapeKey }}" x-model="image_shape" class="sr-only">
                                        <div :class="image_shape === '{{ $shapeKey }}' ? 'border-gold-500 bg-gold-500/10 text-white' : 'border-slate-800 bg-slate-900/50 text-slate-400'"
                                             class="p-3 rounded-2xl border text-center transition hover:border-slate-700">
                                            <div class="w-8 h-8 mx-auto mb-1 bg-slate-700 shape-{{ $shapeKey }}"></div>
                                            <div class="text-[10px] font-bold">{{ $shapeLabel }}</div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Key Achievements / Highlights -->
                        <div class="space-y-3 pt-2">
                            <label class="block text-xs font-bold text-slate-300">Top 3 Key Highlights / Achievements / Projects</label>
                            <input type="text" name="highlights[]" x-model="highlight1" placeholder="Achievement 1 (e.g. 10+ Years Experience)" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white">
                            <input type="text" name="highlights[]" x-model="highlight2" placeholder="Achievement 2 (e.g. Series A Lead Architect)" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white">
                            <input type="text" name="highlights[]" x-model="highlight3" placeholder="Achievement 3 (e.g. Fortune 500 Board Advisor)" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white">
                        </div>

                        <div class="flex items-center justify-between pt-4">
                            <button type="button" @click="activeStep = 2" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-slate-300 font-medium text-xs rounded-xl transition">
                                ← Back
                            </button>
                            <button type="button" @click="activeStep = 4" class="px-6 py-3 bg-gold-500 hover:bg-gold-400 text-slate-950 font-bold text-xs rounded-xl transition flex items-center gap-2 shadow-lg shadow-gold-500/20">
                                Next: Review & Contacts <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 4: Direct Contacts & Submission -->
                    <div x-show="activeStep === 4" class="glass-card rounded-3xl p-6 sm:p-8 space-y-6" x-cloak>
                        <div class="border-b border-slate-800/80 pb-4">
                            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                <i class="bi bi-telephone-fill text-gold-400"></i> Contact Channels & Submit Application
                            </h2>
                            <p class="text-xs text-slate-400 mt-0.5">Enter your primary contact details to receive your quote & activation link.</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-300">Email Address *</label>
                                <input type="email" name="email" x-model="email" required placeholder="you@domain.com"
                                       class="w-full px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white focus:border-gold-500">
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-300">Phone / WhatsApp Number *</label>
                                <input type="text" name="phone" x-model="phone" required placeholder="+251 9... / +1 212..."
                                       class="w-full px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white focus:border-gold-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="space-y-1">
                                <label class="block text-[11px] font-medium text-slate-400">Telegram Username</label>
                                <input type="text" name="telegram" x-model="telegram" placeholder="@username" class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white">
                            </div>
                            <div class="space-y-1">
                                <label class="block text-[11px] font-medium text-slate-400">LinkedIn Profile URL</label>
                                <input type="text" name="linkedin" x-model="linkedin" placeholder="linkedin.com/in/..." class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white">
                            </div>
                            <div class="space-y-1">
                                <label class="block text-[11px] font-medium text-slate-400">GitHub Profile URL</label>
                                <input type="text" name="github" x-model="github" placeholder="github.com/..." class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white">
                            </div>
                        </div>

                        <!-- Final Quote Summary Banner -->
                        <div class="p-6 rounded-2xl bg-gradient-to-br from-gold-500/10 via-slate-900 to-slate-950 border border-gold-500/30 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-white">Selected Card Package</span>
                                <span class="text-xs font-extrabold text-gold-400" x-text="editionName"></span>
                            </div>
                            <div class="flex items-center justify-between border-t border-slate-800 pt-3">
                                <span class="text-xs text-slate-400">Total Approved Quote</span>
                                <span class="text-xl font-extrabold text-gold-400 font-cinzel" x-text="quotePrice"></span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4">
                            <button type="button" @click="activeStep = 3" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-slate-300 font-medium text-xs rounded-xl transition">
                                ← Back
                            </button>
                            <button type="submit" class="px-8 py-3.5 bg-gradient-to-r from-gold-500 to-amber-400 hover:from-gold-400 hover:to-amber-300 text-slate-950 font-extrabold text-sm rounded-xl transition shadow-xl shadow-gold-500/25 flex items-center gap-2">
                                <i class="bi bi-check2-circle text-base"></i> Submit Card Application & Request Activation
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- RIGHT: Real-Time Interactive Live Outcome Preview Device (5 Cols) -->
            <div class="lg:col-span-5 lg:sticky lg:top-24 space-y-4">
                
                <!-- Live Preview Switcher & Status Bar -->
                <div class="flex items-center justify-between bg-slate-900/90 p-2 rounded-2xl border border-slate-800/80">
                    <div class="flex items-center gap-2 px-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-[11px] font-bold text-slate-300 uppercase tracking-wider">Live Preview</span>
                    </div>

                    <div class="flex gap-1">
                        <button type="button" @click="previewMode = 'website'"
                                :class="previewMode === 'website' ? 'bg-gold-500 text-slate-950 font-bold' : 'text-slate-400 hover:text-white'"
                                class="px-3 py-1.5 rounded-xl text-xs transition flex items-center gap-1.5">
                            <i class="bi bi-phone"></i> Website
                        </button>
                        <button type="button" @click="previewMode = 'card'"
                                :class="previewMode === 'card' ? 'bg-gold-500 text-slate-950 font-bold' : 'text-slate-400 hover:text-white'"
                                class="px-3 py-1.5 rounded-xl text-xs transition flex items-center gap-1.5">
                            <i class="bi bi-credit-card"></i> NFC Card
                        </button>
                    </div>
                </div>

                <!-- PREVIEW 1: Interactive Mobile Website Phone Frame -->
                <div x-show="previewMode === 'website'" class="phone-frame bg-[#0b0f19] border border-slate-800 overflow-hidden text-slate-100 max-w-[340px] mx-auto transition-all"
                     :style="{ backgroundColor: bg_color, fontFamily: font_body }">
                    
                    <!-- Phone Notch Bar -->
                    <div class="h-6 bg-slate-950/80 flex items-center justify-center relative">
                        <div class="w-20 h-3.5 bg-slate-900 rounded-full"></div>
                    </div>

                    <!-- Phone Website Header -->
                    <div class="px-4 py-3 border-b border-white/10 flex items-center justify-between bg-black/20 backdrop-blur-md">
                        <div class="flex items-center gap-2">
                            <div class="w-5 h-5 rounded-md flex items-center justify-center font-bold text-[10px] text-slate-950"
                                 :style="{ backgroundColor: accent_color }">K</div>
                            <span class="text-xs font-bold tracking-tight" :style="{ fontFamily: font_display }" x-text="name"></span>
                        </div>
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-white/10 text-slate-300 font-mono">/card/...</span>
                    </div>

                    <!-- Phone Scrollable Body Content -->
                    <div class="p-4 space-y-4 max-h-[460px] overflow-y-auto text-xs">
                        
                        <!-- Hero Section Preview -->
                        <div class="text-center space-y-2.5 pt-2">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider bg-white/10"
                                  :style="{ color: accent_color, borderColor: accent_color }" x-text="role_title"></span>

                            <!-- Headshot Image Shape -->
                            <div class="w-20 h-20 mx-auto overflow-hidden bg-slate-800 border-2 shadow-xl transition-all"
                                 :class="'shape-' + image_shape"
                                 :style="{ borderColor: accent_color }">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!photoPreview">
                                    <div class="w-full h-full flex items-center justify-center text-slate-500 font-bold text-lg" x-text="name.charAt(0)"></div>
                                </template>
                            </div>

                            <h3 class="text-sm font-bold text-white tracking-tight leading-snug"
                                :style="{ fontFamily: font_display }" x-text="tagline"></h3>

                            <p class="text-[10px] text-slate-400 line-clamp-2" x-text="bio"></p>

                            <!-- CTA Button -->
                            <div class="pt-1">
                                <div class="px-3 py-1.5 rounded-xl font-bold text-[10px] text-slate-950 inline-block shadow-md transition"
                                     :style="{ backgroundColor: accent_color }">
                                    Connect with <span x-text="name.split(' ')[0]"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Achievements / Highlights Badges -->
                        <div class="space-y-1.5 bg-white/5 p-3 rounded-2xl border border-white/5">
                            <div class="text-[10px] font-bold text-slate-300 flex items-center gap-1">
                                <i class="bi bi-star-fill text-[9px]" :style="{ color: accent_color }"></i> Highlights
                            </div>
                            <div class="space-y-1 text-[9px] text-slate-400">
                                <template x-if="highlight1">
                                    <div class="flex items-center gap-1.5"><span class="w-1 h-1 rounded-full bg-slate-400"></span><span x-text="highlight1"></span></div>
                                </template>
                                <template x-if="highlight2">
                                    <div class="flex items-center gap-1.5"><span class="w-1 h-1 rounded-full bg-slate-400"></span><span x-text="highlight2"></span></div>
                                </template>
                                <template x-if="highlight3">
                                    <div class="flex items-center gap-1.5"><span class="w-1 h-1 rounded-full bg-slate-400"></span><span x-text="highlight3"></span></div>
                                </template>
                            </div>
                        </div>

                        <!-- Direct Contact Buttons Preview -->
                        <div class="grid grid-cols-2 gap-1.5 text-center">
                            <div class="p-2 rounded-xl bg-white/5 border border-white/5 text-[9px] text-slate-300">
                                <i class="bi bi-envelope text-slate-400 block mb-0.5"></i>
                                <span class="truncate block" x-text="email || 'Email'"></span>
                            </div>
                            <div class="p-2 rounded-xl bg-white/5 border border-white/5 text-[9px] text-slate-300">
                                <i class="bi bi-telephone text-slate-400 block mb-0.5"></i>
                                <span class="truncate block" x-text="phone || 'Phone'"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Phone Bottom Home Bar -->
                    <div class="h-5 bg-slate-950/80 flex items-center justify-center">
                        <div class="w-24 h-1 bg-slate-700 rounded-full"></div>
                    </div>
                </div>

                <!-- PREVIEW 2: Interactive Physical 3D NFC Card Mockup -->
                <div x-show="previewMode === 'card'" class="space-y-4 max-w-[340px] mx-auto" x-cloak>
                    <div :class="{
                            'bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 border-indigo-500/30': card_edition === 'midnight_navy',
                            'bg-gradient-to-br from-amber-950 via-yellow-900 to-stone-900 border-amber-500/40': card_edition === 'brushed_gold',
                            'bg-gradient-to-br from-zinc-950 via-neutral-900 to-black border-zinc-700/50': card_edition === 'executive_black'
                         }"
                         class="aspect-[1.586/1] rounded-3xl p-6 border shadow-2xl relative flex flex-col justify-between overflow-hidden">
                        
                        <!-- Card Shimmer & Holographic Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/5 to-white/15 pointer-events-none"></div>

                        <!-- Top Card Header: Chip & NFC Contactless Symbol -->
                        <div class="flex items-center justify-between relative z-10">
                            <!-- Metallic NFC Gold Chip -->
                            <div class="w-10 h-8 rounded-lg bg-gradient-to-br from-yellow-300 via-amber-400 to-amber-600 border border-yellow-200/60 shadow-inner flex items-center justify-center">
                                <div class="w-6 h-5 border border-amber-700/40 rounded grid grid-cols-2 gap-0.5"></div>
                            </div>

                            <!-- NFC Wave Icon -->
                            <i class="bi bi-wifi text-xl text-white/80 rotate-90"></i>
                        </div>

                        <!-- Card Center / Bottom: Embossed User Details -->
                        <div class="space-y-1 relative z-10">
                            <div class="text-[9px] font-mono tracking-widest text-slate-400 uppercase">KIMEM TOUCHLESS ID</div>
                            <div class="text-base font-extrabold text-white tracking-wide font-cinzel truncate" x-text="name"></div>
                            <div class="text-[10px] font-medium text-gold-400 tracking-tight truncate" x-text="role_title"></div>
                        </div>

                        <!-- Card Bottom Bar: QR Code & Brand Stamp -->
                        <div class="flex items-center justify-between border-t border-white/10 pt-2 relative z-10">
                            <span class="text-[10px] font-bold tracking-widest font-cinzel text-white/70">KIMEM CARDS</span>
                            <div class="w-6 h-6 rounded bg-white/90 p-0.5 flex items-center justify-center">
                                <i class="bi bi-qr-code text-slate-950 text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 rounded-2xl bg-slate-900/60 border border-slate-800 text-center">
                        <span class="text-[10px] text-slate-400 block font-medium">Physical NFC Dimensions: 85.6mm × 53.98mm (ISO/IEC 7810 ID-1)</span>
                    </div>
                </div>

                <!-- Live Dynamic Outcome Summary -->
                <div class="p-4 rounded-2xl bg-slate-900/50 border border-slate-800/80 space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-400">Target Digital URL:</span>
                        <span class="font-mono text-gold-400 font-bold" x-text="'/card/' + name.toLowerCase().replace(/[^a-z0-9]/g, '-')"></span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-400">Estimated Price Quote:</span>
                        <span class="font-bold text-white" x-text="quotePrice"></span>
                    </div>
                </div>

            </div>

        </div>
    </main>

</body>
</html>
