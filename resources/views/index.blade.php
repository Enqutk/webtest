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
        <section id="how" class="section-shell rs-container reveal">
            <p id="processEyebrow" class="section-eyebrow">The Process</p>
            <h2 id="processTitle" class="section-title">Effortless. <span>By Design.</span></h2>
            <div class="process-grid">
                <article class="process-card reveal">
                    <div id="stepNum0" class="step-num">01</div>
                    <h3 id="stepTitle0" class="step-title">Choose Your Card</h3>
                    <p id="stepDesc0" class="step-desc">Select Navy or Gold, then we align the final profile structure with your brand.</p>
                </article>
                <article class="process-card reveal">
                    <div id="stepNum1" class="step-num">02</div>
                    <h3 id="stepTitle1" class="step-title">We Register You</h3>
                    <p id="stepDesc1" class="step-desc">We configure your profile and encode your NFC card with your endpoint.</p>
                </article>
                <article class="process-card reveal">
                    <div id="stepNum2" class="step-num">03</div>
                    <h3 id="stepTitle2" class="step-title">Tap & Connect</h3>
                    <p id="stepDesc2" class="step-desc">Recipients tap once and get your optimized digital profile instantly.</p>
                </article>
            </div>
        </section>

        <!-- Collection Section -->
        <section id="collection" class="section-shell rs-container reveal">
            <p id="colEyebrow" class="section-eyebrow">The Collection</p>
            <h2 id="colTitle" class="section-title">Two Editions. <span>One Standard.</span></h2>
            <div class="collection-grid">
                <article class="collection-card reveal">
                    <div class="collection-thumb-wrapper">
                        <img src="{{ asset('images/image.webp') }}" alt="Navy card edition" class="collection-thumb">
                    </div>
                    <h3 id="colLabel0" class="collection-label">Navy Edition</h3>
                    <p id="colDesc0" class="collection-desc">Deep navy matte with geometric line work and premium foil treatment.</p>
                </article>
                <article class="collection-card reveal">
                    <div class="collection-thumb-wrapper">
                        <img src="{{ asset('images/back.webp') }}" alt="Gold card edition" class="collection-thumb">
                    </div>
                    <h3 id="colLabel1" class="collection-label">Gold Edition</h3>
                    <p id="colDesc1" class="collection-desc">Metallic gold profile with debossed patterning and high-luxury contrast.</p>
                </article>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="section-shell rs-container reveal">
            <p id="featEyebrow" class="section-eyebrow">Why Kimem</p>
            <h2 id="featTitle" class="section-title">Built Around <span>Your Identity.</span></h2>
            <div id="featuresGrid" class="features-grid">
                <!-- Injected dynamically based on localization -->
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="pricing" class="section-shell rs-container reveal">
            <p id="priceEyebrow" class="section-eyebrow">Pricing</p>
            <h2 id="priceTitle" class="section-title">Simple. <span>Transparent.</span></h2>
            <div id="pricingGrid" class="pricing-grid">
                <!-- Injected dynamically based on localization -->
            </div>
        </section>

        <!-- ROI Calculator Section -->
        <section id="roi" class="section-shell rs-container reveal roi-section">
            <p id="roiEyebrow" class="section-eyebrow">ROI Calculator</p>
            <h2 id="roiTitle" class="section-title">Measure <span>Your Savings.</span></h2>

            <div class="roi-grid">
                <article class="roi-card">
                    <label class="roi-label">
                        <span id="roiEmpLabel">Employees</span>
                        <strong id="roiEmpVal">50</strong>
                    </label>
                    <input id="roiEmployees" type="range" min="1" max="500" step="1" value="50">

                    <label id="roiPrintLabel" class="roi-label">Annual print cost per employee (USD)</label>
                    <input id="roiPrintCost" type="number" min="0" step="1" value="194">

                    <label id="roiKimemLabel" class="roi-label">Kimem card price per employee (USD)</label>
                    <input id="roiKimemPrice" type="number" min="0" step="1" value="79">
                </article>

                <article class="roi-card roi-results">
                    <p id="roiPaperText">Annual paper cost</p>
                    <strong id="resPaperCost">$9,700</strong>

                    <p id="roiKimemText">Annual Kimem cost (one-time purchase)</p>
                    <strong id="resKimemCost">$3,950</strong>

                    <p id="roiSavingsText">Savings per year</p>
                    <strong id="resSavings" class="savings">$7,725</strong>

                    <p id="roiTreesText">Trees saved</p>
                    <strong id="resTrees">2.00</strong>
                    <small id="roiTreesHint">Approximate value</small>

                    <a id="roiCta" href="#pricing" class="roi-cta">Start saving - Order your cards</a>
                </article>
            </div>
        </section>

        <!-- Testimonial Section -->
        <section class="section-shell rs-container testimonial-section reveal">
            <p id="testEyebrow" class="section-eyebrow">Words from Our Clients</p>
            <div class="quote-box">
                <p id="testQuoteText" class="quote-text">"It made our introduction feel premium before we even started the conversation."</p>
                <p id="testQuoteAuthor" class="quote-author">Yohannes A.</p>
                <p id="testQuoteRole" class="quote-role">Founder, Addis Fintech Group</p>
            </div>
            <div id="testDots" class="quote-dots"></div>
        </section>

        <!-- Footer Section -->
        <footer class="footer rs-container">
            <div class="footer-brand">
                <span class="nav-logo">Kimem Cards</span>
                <p id="footerDesc">NFC luxury business cards for professionals who care about unforgettable first impressions.</p>
            </div>
            <p id="footerCopy" class="footer-bottom">© 2026 Kimem Cards. All rights reserved.</p>
        </footer>
    </main>

    <!-- Kimem Landing Interactive Logic -->
    <script src="{{ asset('js/kimem-landing.js') }}"></script>
</body>
</html>
