<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kimem Cards | Luxury NFC Business Cards</title>
    <meta name="description" content="NFC-enabled luxury cards crafted for professionals who understand that a first impression is a lasting statement.">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/fevicon.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Kimem Landing Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/kimem-landing.css') }}">
</head>
<body class="kimem-landing-body">
    <main class="landing">
        <!-- Floating Suit Background -->
        <div id="suitBg" class="suit-bg" aria-hidden="true"></div>

        <!-- Sticky Top Navigation -->
        <nav id="topNav" class="top-nav">
            <a href="#" class="nav-logo">
                <span>Kimem Cards</span>
            </a>
            <ul class="nav-links">
                <li><a href="#how" data-loc-nav="0">How it Works</a></li>
                <li><a href="#collection" data-loc-nav="1">Collection</a></li>
                <li><a href="#features" data-loc-nav="2">Features</a></li>
                <li><a href="#pricing" data-loc-nav="3">Pricing</a></li>
            </ul>
            <div class="nav-actions">
                <button id="btnLocaleEn" type="button" class="nav-locale-btn">EN</button>
                <button id="btnLocaleAm" type="button" class="nav-locale-btn">አማ</button>
                <a id="navCta" href="#pricing" class="nav-cta">Order Now</a>
            </div>
        </nav>

        <!-- Hero Section -->
        <section id="heroSection" class="hero-section rs-container rs-section">
            <div class="hero-grid-lines">
                <div style="position:absolute; inset-inline:0; top:18%; height:1px; background:linear-gradient(to right, transparent, rgba(197,160,89,0.5), transparent);"></div>
                <div style="position:absolute; inset-inline:0; top:60%; height:1px; background:linear-gradient(to right, transparent, rgba(166,128,60,0.4), transparent);"></div>
                <div style="position:absolute; inset-block:0; left:48%; width:1px; background:linear-gradient(to bottom, transparent, rgba(197,160,89,0.45), transparent);"></div>
            </div>

            <div class="rs-hero-grid">
                <div>
                    <p id="heroEyebrow" class="hero-eyebrow">The Future of First Impressions</p>
                    <h1 class="hero-title">
                        <span id="heroTitleContainer" class="headline-words">
                            <span class="headline-word"><span>O</span><span>N</span><span>E</span></span>
                            <span class="headline-word"><span>T</span><span>A</span><span>P</span><span>.</span></span>
                            <span class="headline-word"><span>I</span><span>N</span><span>F</span><span>I</span><span>N</span><span>I</span><span>T</span><span>E</span></span>
                            <span class="headline-word"><span>P</span><span>R</span><span>E</span><span>S</span><span>E</span><span>N</span><span>C</span><span>E</span><span>.</span></span>
                        </span>
                    </h1>
                    <p id="heroSubtitle" class="hero-subtitle">
                        NFC-enabled luxury cards crafted for professionals who understand that a first impression is a lasting statement.
                    </p>
                    <div class="hero-ctas">
                        <a id="heroCtaPrimary" href="#collection" class="cta-button group">
                            <span style="position:relative; z-index:10;">Explore the Collection</span>
                            <span class="cta-button__sheen"></span>
                        </a>
                        <a id="heroCtaSecondary" href="#how" class="btn-ghost">
                            How it Works
                        </a>
                    </div>
                </div>

                <div>
                    <div id="cardStage" class="card-stage" role="button" tabindex="0" aria-label="Rotate card showcase">
                        <div id="cardScene" class="card-scene">
                            <div class="card-grid-backdrop"></div>
                            <div class="card-corner card-corner--tl"></div>
                            <div class="card-corner card-corner--tr"></div>
                            <div class="card-corner card-corner--bl"></div>
                            <div class="card-corner card-corner--br"></div>

                            <!-- Back Card -->
                            <article id="cardBack" class="card card--back">
                                <div class="card__frame">
                                    <img src="{{ asset('images/back.webp') }}" alt="KIMEM CARDS back sticker" class="card__sticker card__sticker--back">
                                </div>
                            </article>

                            <!-- Front Card with 3D thickness and interactive flip -->
                            <article id="cardFront" class="card card--front">
                                <div class="card__frame card__frame--3d">
                                    <div id="card3dShell" class="card-3d-shell">
                                        <div class="card-face card-face--front">
                                            <img src="{{ asset('images/image.webp') }}" alt="KIMEM CARDS front sticker" class="card__sticker card__sticker--front">
                                        </div>
                                        <div class="card-face card-face--back">
                                            <img src="{{ asset('images/back.webp') }}" alt="KIMEM CARDS back sticker" class="card__sticker card__sticker--back">
                                        </div>
                                        <span class="card-edge card-edge--top"></span>
                                        <span class="card-edge card-edge--bottom"></span>
                                        <span class="card-edge card-edge--left"></span>
                                        <span class="card-edge card-edge--right"></span>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Process Section -->
        <section id="how" class="process-section rs-container rs-section">
            <div class="section-heading">
                <p id="processEyebrow" class="section-eyebrow">The Process</p>
                <h2 id="processTitle" class="section-title">Effortless. <span>By Design.</span></h2>
            </div>
            <div class="process-grid">
                <div class="process-step">
                    <span class="step-num">01</span>
                    <h3 id="step1Title" class="step-title">Choose Your Card</h3>
                    <p id="step1Desc" class="step-desc">Select Navy or Gold, then we align the final profile structure with your brand.</p>
                </div>
                <div class="process-step">
                    <span class="step-num">02</span>
                    <h3 id="step2Title" class="step-title">We Register You</h3>
                    <p id="step2Desc" class="step-desc">We configure your profile and encode your NFC card with your endpoint.</p>
                </div>
                <div class="process-step">
                    <span class="step-num">03</span>
                    <h3 id="step3Title" class="step-title">Tap & Connect</h3>
                    <p id="step3Desc" class="step-desc">Recipients tap once and get your optimized digital profile instantly.</p>
                </div>
            </div>
        </section>

        <!-- Collection Section -->
        <section id="collection" class="collection-section rs-container rs-section">
            <div class="section-heading">
                <p id="collectionEyebrow" class="section-eyebrow">Exclusive Release</p>
                <h2 id="collectionTitle" class="section-title">The Collection</h2>
            </div>
            <div class="collection-grid">
                <article class="collection-card">
                    <div class="collection-card-img">
                        <img src="{{ asset('images/image.webp') }}" alt="The Midnight Navy NFC Card">
                    </div>
                    <div class="collection-card-content">
                        <span class="collection-badge">SIGNATURE EDITION</span>
                        <h3 id="navyTitle" class="collection-card-title">The Midnight Navy</h3>
                        <p id="navyDesc" class="collection-card-desc">Deep matte navy finish with precision-cut brushed metallic gold accents.</p>
                        <div class="collection-card-footer">
                            <span id="navyPrice" class="collection-price">ETB 1,850</span>
                            <a href="#pricing" class="btn-card-order">Select</a>
                        </div>
                    </div>
                </article>

                <article class="collection-card">
                    <div class="collection-card-img">
                        <img src="{{ asset('images/back.webp') }}" alt="The Brushed Gold NFC Card">
                    </div>
                    <div class="collection-card-content">
                        <span class="collection-badge">PREMIUM EDITION</span>
                        <h3 id="goldTitle" class="collection-card-title">The Brushed Gold</h3>
                        <p id="goldDesc" class="collection-card-desc">Warm reflective metallic texture engineered for striking presence.</p>
                        <div class="collection-card-footer">
                            <span id="goldPrice" class="collection-price">ETB 2,450</span>
                            <a href="#pricing" class="btn-card-order">Select</a>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="features-section rs-container rs-section">
            <div class="section-heading">
                <p id="featuresEyebrow" class="section-eyebrow">Engineered For Performance</p>
                <h2 id="featuresTitle" class="section-title">Everything You Need</h2>
            </div>
            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-phone"></i></div>
                    <h3 id="feat1Title" class="feature-title">Universal Compatibility</h3>
                    <p id="feat1Desc" class="feature-desc">Works seamlessly with iOS and Android devices without any extra application.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-arrow-repeat"></i></div>
                    <h3 id="feat2Title" class="feature-title">Dynamic Profile Updates</h3>
                    <p id="feat2Desc" class="feature-desc">Update contact details, social links, and portfolio without reprinting cards.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                    <h3 id="feat3Title" class="feature-title">Enterprise Security</h3>
                    <p id="feat3Desc" class="feature-desc">Protected infrastructure ensuring your digital identity remains safe.</p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="landing-footer rs-container">
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Kimem Cards. Crafted for lasting presence.</p>
            </div>
        </footer>
    </main>

    <script src="{{ asset('js/kimem-landing.js') }}"></script>
</body>
</html>
