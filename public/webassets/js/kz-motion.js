/**
 * =========================================================================
 * LOVE LINK LUXURY TRAVEL - AWWWARDS-CALIBER GSAP & LENIS MOTION SYSTEM
 * =========================================================================
 * Stack: Laravel 11 Blade + Vanilla JS + Swiper + Bootstrap 5
 * Feel:  Calm, Weighted, Luxurious, Silky Smooth (60 FPS)
 * 
 * Architecture:
 * 1. Global Reusable Motion Config (tune feel in one spot)
 * 2. Lenis + GSAP Ticker Synchronization (zero-jank, lagSmoothing: 0)
 * 3. Scoped gsap.context() & gsap.matchMedia() (Desktop, Mobile, Reduced-Motion)
 * 4. SplitText Line Mask Typography Reveals (overflow: hidden masks)
 * 5. Outer-Container-Only Swiper Reveals (never touches .swiper-slide transforms)
 * 6. High-Performance ScrollTrigger.batch() for Card Grids
 * 7. Cinematic Intro Timeline on Load
 * =========================================================================
 */

(function (window, document) {
    'use strict';

    // ─────────────────────────────────────────────────────────────────────────
    // 1. REUSABLE CONFIGURATION OBJECT
    // ─────────────────────────────────────────────────────────────────────────
    window.KZ_MOTION_CONFIG = {
        // Durations (in seconds)
        duration: {
            hero: 1.35,       // Cinematic hero elements
            reveal: 1.15,     // Section headings and showcase wrappers
            card: 0.95,       // Card grids (Reasons, Blogs, FAQs)
            fast: 0.65,       // Eyebrows, pills, badges
        },
        // Deceleration Curves (Awwwards standard: weighted, soothing, confident)
        easing: {
            entrance: 'power3.out', // Signature luxury deceleration curve
            crisp: 'expo.out',       // Ultra-clean settling tail
            cinematic: 'power4.out', // Sweeping headline reveals
        },
        // Movement Distances (in pixels - subtle and grounded)
        distance: {
            heading: 30,     // Headings vertical travel
            card: 28,        // Card vertical travel
            wrapper: 36,     // Full section container rise
        },
        // Stagger Intervals (in seconds)
        stagger: {
            fast: 0.07,
            cards: 0.09,
            headings: 0.12,
        },
        // Lenis Smooth Scroll Configuration
        lenis: {
            duration: 1.2,
            easing: function (t) {
                // Exponential decay (smooth deceleration curve)
                return Math.min(1, 1.001 - Math.pow(2, -10 * t));
            },
            orientation: 'vertical',
            gestureOrientation: 'vertical',
            smoothWheel: true,
            wheelMultiplier: 0.95,
            touchMultiplier: 1.25,
        },
        // Diagnostics Flag: set to true to display ScrollTrigger visual start/end markers
        debug: false,
    };

    // Prevent execution if GSAP or ScrollTrigger are missing
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
        console.warn('[KZ Motion] GSAP or ScrollTrigger not loaded. Animations safely bypassed.');
        return;
    }

    gsap.registerPlugin(ScrollTrigger);

    // ─────────────────────────────────────────────────────────────────────────
    // 2. LENIS SMOOTH SCROLL INTEGRATION & GSAP TICKER SYNC
    // ─────────────────────────────────────────────────────────────────────────
    let lenis = null;

    function initLenisSmoothScroll() {
        if (typeof Lenis === 'undefined') return;

        // Skip Lenis if user prefers reduced motion
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            return;
        }

        try {
            lenis = new Lenis({
                duration: window.KZ_MOTION_CONFIG.lenis.duration,
                easing: window.KZ_MOTION_CONFIG.lenis.easing,
                orientation: 'vertical',
                gestureOrientation: 'vertical',
                smoothWheel: window.KZ_MOTION_CONFIG.lenis.smoothWheel,
                wheelMultiplier: window.KZ_MOTION_CONFIG.lenis.wheelMultiplier,
                touchMultiplier: window.KZ_MOTION_CONFIG.lenis.touchMultiplier,
            });

            // 1. Sync Lenis scroll updates directly into ScrollTrigger
            lenis.on('scroll', ScrollTrigger.update);

            // 2. Drive Lenis via GSAP's high-precision internal ticker
            gsap.ticker.add((time) => {
                lenis.raf(time * 1000);
            });

            // 3. Disable GSAP lagSmoothing so scroll and triggers never desync
            gsap.ticker.lagSmoothing(0);

            // Expose globally for anchor navigation
            window.kzLenis = lenis;
        } catch (err) {
            console.warn('[KZ Motion] Lenis init failed:', err);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 3. SPLITTEXT / SPLITTYPE HEADING MASK UTILITY
    // ─────────────────────────────────────────────────────────────────────────
    /**
     * Splits heading text into lines wrapped in overflow:hidden masks.
     * Inner line elements slide up from yPercent: 110 to 0.
     */
    function splitAndRevealLines(headingEl, triggerEl, delay) {
        if (!headingEl) return;

        var cfg = window.KZ_MOTION_CONFIG;

        if (typeof SplitType !== 'undefined') {
            try {
                // Split text by lines
                var split = new SplitType(headingEl, { types: 'lines', lineClass: 'kz-split-mask' });

                // Wrap each line in an inner element for overflow-hidden mask reveal
                split.lines.forEach(function (line) {
                    var inner = document.createElement('span');
                    inner.className = 'kz-split-inner';
                    inner.style.display = 'inline-block';
                    inner.style.willChange = 'transform';
                    inner.innerHTML = line.innerHTML;
                    line.innerHTML = '';
                    line.appendChild(inner);
                });

                gsap.from(headingEl.querySelectorAll('.kz-split-inner'), {
                    scrollTrigger: {
                        trigger: triggerEl || headingEl,
                        start: 'top 88%',
                        once: true,
                        markers: cfg.debug,
                    },
                    yPercent: 110,
                    opacity: 0,
                    duration: cfg.duration.reveal,
                    stagger: cfg.stagger.headings,
                    ease: cfg.easing.entrance,
                    delay: delay || 0,
                    clearProps: 'transform,opacity',
                });
                return;
            } catch (e) {
                // Fall through to bulletproof fallback
            }
        }

        // Bulletproof Fallback (if SplitType is not present or throws)
        gsap.from(headingEl, {
            scrollTrigger: {
                trigger: triggerEl || headingEl,
                start: 'top 88%',
                once: true,
                markers: cfg.debug,
            },
            y: cfg.distance.heading,
            opacity: 0,
            duration: cfg.duration.reveal,
            ease: cfg.easing.entrance,
            delay: delay || 0,
            clearProps: 'transform,opacity',
        });
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 4. MASTER MOTION ARCHITECTURE (MATCHMEDIA + CONTEXT)
    // ─────────────────────────────────────────────────────────────────────────
    function initMasterMotion() {
        var cfg = window.KZ_MOTION_CONFIG;

        // Use gsap.context() for clean scoping and leak-free cleanup
        var ctx = gsap.context(function () {
            var mm = gsap.matchMedia();

            // =================================================================
            // A. DESKTOP EXPERIENCE (min-width: 992px)
            // =================================================================
            mm.add('(min-width: 992px)', function () {
                // 1. CINEMATIC HERO INTRO TIMELINE (Runs on page ready)
                var heroSection = document.querySelector('.hero-1, #heroSlide1');
                if (heroSection) {
                    var heroTl = gsap.timeline({
                        defaults: { ease: cfg.easing.entrance },
                        delay: 0.15,
                    });

                    var heroSub = heroSection.querySelector('.hero-subtitle, .sub-title');
                    var heroTitle = heroSection.querySelector('.hero-title');
                    var heroText = heroSection.querySelector('.hero-text');
                    var heroBtn = heroSection.querySelector('.btn-group, .hero-btn, .th-btn');
                    var bookingBar = document.querySelector('.booking-sec, .booking-form, .hero-form-tab-wrap');

                    if (heroSub) {
                        heroTl.from(heroSub, {
                            y: 16,
                            opacity: 0,
                            duration: cfg.duration.fast,
                            clearProps: 'all',
                        });
                    }

                    if (heroTitle) {
                        heroTl.from(heroTitle, {
                            y: cfg.distance.heading,
                            opacity: 0,
                            duration: cfg.duration.hero,
                            clearProps: 'all',
                        }, heroSub ? '-=0.5' : 0);
                    }

                    if (heroText) {
                        heroTl.from(heroText, {
                            y: 18,
                            opacity: 0,
                            duration: 0.9,
                            clearProps: 'all',
                        }, '-=0.7');
                    }

                    if (heroBtn) {
                        heroTl.from(heroBtn, {
                            y: 16,
                            opacity: 0,
                            duration: 0.8,
                            clearProps: 'all',
                        }, '-=0.6');
                    }

                    if (bookingBar) {
                        heroTl.from(bookingBar, {
                            y: 28,
                            opacity: 0,
                            duration: 1.05,
                            ease: cfg.easing.entrance,
                            clearProps: 'all',
                        }, '-=0.6');
                    }
                }

                // 2. SECTION HEADINGS: CHOREOGRAPHED LINE MASK REVEALS
                var sectionHeaders = [
                    '.kz-cat-header',
                    '.kz-cabs-header',
                    '.kz-dest-header',
                    '.kz-hotels-header',
                    '.kz-reasons-header',
                    '.kz-blog-header',
                    '.kz-faq-header',
                    '.kz-gallery-header',
                    '.kz-reviews-header',
                ];

                sectionHeaders.forEach(function (headerSel) {
                    var header = document.querySelector(headerSel);
                    if (!header) return;

                    var eyebrow = header.querySelector('[class*="eyebrow"]') || header.children[0];
                    var heading = header.querySelector('h2, [class*="heading"], [class*="title"]') || header.children[1];
                    var subtitle = header.querySelector('p, [class*="subtitle"]') || header.children[2];

                    var headerTl = gsap.timeline({
                        scrollTrigger: {
                            trigger: header,
                            start: 'top 88%',
                            once: true,
                            markers: cfg.debug,
                        },
                    });

                    if (eyebrow) {
                        headerTl.from(eyebrow, {
                            y: 14,
                            opacity: 0,
                            duration: cfg.duration.fast,
                            ease: cfg.easing.entrance,
                            clearProps: 'all',
                        });
                    }

                    if (heading) {
                        // Split line reveal on heading
                        splitAndRevealLines(heading, header, eyebrow ? 0.05 : 0);
                    }

                    if (subtitle) {
                        headerTl.from(subtitle, {
                            y: 16,
                            opacity: 0,
                            duration: 0.85,
                            ease: cfg.easing.entrance,
                            clearProps: 'all',
                        }, '-=0.55');
                    }
                });

                // 3. ABOUT US SECTION: SPLIT EDITORIAL FLOW
                var aboutSec = document.querySelector('.kz-about-section');
                if (aboutSec) {
                    var aboutImg = aboutSec.querySelector('.kz-about-img-card');
                    var aboutContent = aboutSec.querySelector('.kz-about-info-wrap');
                    var aboutBadge = aboutSec.querySelector('.kz-about-exp-badge');
                    var aboutStats = aboutSec.querySelectorAll('.kz-about-stat-card');

                    if (aboutImg) {
                        gsap.from(aboutImg, {
                            scrollTrigger: {
                                trigger: aboutSec,
                                start: 'top 85%',
                                once: true,
                                markers: cfg.debug,
                            },
                            x: -36,
                            opacity: 0,
                            scale: 0.98,
                            duration: 1.15,
                            ease: cfg.easing.entrance,
                            clearProps: 'all',
                        });
                    }

                    if (aboutBadge) {
                        gsap.from(aboutBadge, {
                            scrollTrigger: {
                                trigger: aboutSec,
                                start: 'top 85%',
                                once: true,
                            },
                            scale: 0.88,
                            opacity: 0,
                            duration: 0.9,
                            delay: 0.2,
                            ease: cfg.easing.entrance,
                            clearProps: 'all',
                        });
                    }

                    if (aboutContent) {
                        var textItems = Array.from(aboutContent.children).filter(function (child) {
                            return !child.classList.contains('kz-about-stat-row');
                        });

                        gsap.from(textItems, {
                            scrollTrigger: {
                                trigger: aboutSec,
                                start: 'top 85%',
                                once: true,
                            },
                            y: 22,
                            opacity: 0,
                            duration: 0.95,
                            stagger: 0.1,
                            ease: cfg.easing.entrance,
                            clearProps: 'all',
                        });
                    }

                    if (aboutStats.length > 0) {
                        gsap.from(aboutStats, {
                            scrollTrigger: {
                                trigger: '.kz-about-stat-row',
                                start: 'top 88%',
                                once: true,
                            },
                            y: 20,
                            opacity: 0,
                            duration: 0.85,
                            stagger: 0.08,
                            ease: cfg.easing.entrance,
                            clearProps: 'all',
                        });
                    }
                }

                // 4. INTERACTIVE SWIPERS: CONTAINER REVEAL ONLY
                // Rule: NEVER animate .swiper-slide transforms! Animate only the outer wrapper!
                var swiperContainers = [
                    '#kzCategorySwiper',
                    '#kzCabsSwiper',
                    '#kzDestSwiper',
                    '.kz-hotels-slider-wrap',
                    '.kz-gallery-slider-wrap',
                ];

                swiperContainers.forEach(function (sel) {
                    var container = document.querySelector(sel);
                    if (!container) return;

                    gsap.from(container, {
                        scrollTrigger: {
                            trigger: container,
                            start: 'top 86%',
                            once: true,
                            markers: cfg.debug,
                        },
                        y: cfg.distance.wrapper,
                        opacity: 0,
                        duration: cfg.duration.reveal,
                        ease: cfg.easing.entrance,
                        force3D: true,
                        clearProps: 'transform,opacity',
                    });
                });

                // 5. CARD GRIDS: HIGH-EFFICIENCY SCROLLTRIGGER.BATCH()
                // A. Why Choose Us (Reasons Cards)
                ScrollTrigger.batch('.kz-reasons-section .kz-reason-card', {
                    start: 'top 86%',
                    once: true,
                    onEnter: function (batch) {
                        gsap.from(batch, {
                            y: cfg.distance.card,
                            opacity: 0,
                            duration: cfg.duration.card,
                            stagger: cfg.stagger.cards,
                            ease: cfg.easing.entrance,
                            force3D: true,
                            clearProps: 'all',
                        });
                    },
                });

                // B. Travel Blog Cards
                ScrollTrigger.batch('.kz-blog-section .kz-blog-card', {
                    start: 'top 86%',
                    once: true,
                    onEnter: function (batch) {
                        gsap.from(batch, {
                            y: cfg.distance.card,
                            opacity: 0,
                            duration: cfg.duration.card,
                            stagger: cfg.stagger.cards,
                            ease: cfg.easing.entrance,
                            force3D: true,
                            clearProps: 'all',
                        });
                    },
                });

                // C. FAQ Accordions
                ScrollTrigger.batch('.kz-faq-list-wrap .kz-faq-card', {
                    start: 'top 88%',
                    once: true,
                    onEnter: function (batch) {
                        gsap.from(batch, {
                            y: 18,
                            opacity: 0,
                            duration: 0.8,
                            stagger: 0.07,
                            ease: cfg.easing.entrance,
                            force3D: true,
                            clearProps: 'all',
                        });
                    },
                });

                // 6. SPECIAL SHOWCASE BANNERS
                // Spiti Valley Banner
                var spitiBanner = document.querySelector('.kz-spiti-banner-card');
                if (spitiBanner) {
                    gsap.from(spitiBanner, {
                        scrollTrigger: {
                            trigger: spitiBanner,
                            start: 'top 85%',
                            once: true,
                        },
                        y: 30,
                        opacity: 0,
                        scale: 0.985,
                        duration: 1.05,
                        ease: cfg.easing.entrance,
                        clearProps: 'all',
                    });
                }

                // Fast Inquiry / Contact Banner
                var contactBanner = document.querySelector('.kz-contact-card');
                if (contactBanner) {
                    gsap.from(contactBanner, {
                        scrollTrigger: {
                            trigger: contactBanner,
                            start: 'top 86%',
                            once: true,
                        },
                        y: 28,
                        opacity: 0,
                        duration: 0.95,
                        ease: cfg.easing.entrance,
                        clearProps: 'all',
                    });
                }
            });

            // =================================================================
            // B. MOBILE & TABLET EXPERIENCE (max-width: 991px)
            // =================================================================
            mm.add('(max-width: 991px)', function () {
                // Reduced travel distances, no heavy transforms, instant touch responsiveness
                var mobileContainers = document.querySelectorAll(
                    '.kz-cat-header, .kz-cabs-header, .kz-dest-header, .kz-hotels-header, .kz-reasons-header, .kz-blog-header, .kz-faq-header, .kz-gallery-header, .kz-about-img-card, .kz-about-info-wrap, .kz-spiti-banner-card, .kz-contact-card'
                );

                mobileContainers.forEach(function (el) {
                    gsap.from(el, {
                        scrollTrigger: {
                            trigger: el,
                            start: 'top 90%',
                            once: true,
                        },
                        y: 18,
                        opacity: 0,
                        duration: 0.85,
                        ease: cfg.easing.entrance,
                        clearProps: 'all',
                    });
                });

                // Mobile Swipers: simple fade entrance
                var mobileSwipers = document.querySelectorAll(
                    '#kzCategorySwiper, #kzCabsSwiper, #kzDestSwiper, .kz-hotels-slider-wrap, .kz-gallery-slider-wrap'
                );
                mobileSwipers.forEach(function (sw) {
                    gsap.from(sw, {
                        scrollTrigger: {
                            trigger: sw,
                            start: 'top 92%',
                            once: true,
                        },
                        opacity: 0,
                        duration: 0.75,
                        ease: 'power2.out',
                        clearProps: 'all',
                    });
                });
            });

            // =================================================================
            // C. ACCESSIBILITY: REDUCED MOTION (prefers-reduced-motion)
            // =================================================================
            mm.add('(prefers-reduced-motion: reduce)', function () {
                // Pure opacity fades only; zero translational movement
                var allMotionTargets = document.querySelectorAll(
                    '.kz-cat-header, .kz-cabs-header, .kz-dest-header, .kz-hotels-header, .kz-reasons-header, .kz-blog-header, .kz-faq-header, .kz-gallery-header, .kz-about-img-card, .kz-about-info-wrap, .kz-spiti-banner-card, .kz-contact-card, .kz-reason-card, .kz-blog-card'
                );

                allMotionTargets.forEach(function (el) {
                    gsap.from(el, {
                        scrollTrigger: {
                            trigger: el,
                            start: 'top 90%',
                            once: true,
                        },
                        opacity: 0,
                        duration: 0.6,
                        clearProps: 'all',
                    });
                });
            });
        });

        // ─────────────────────────────────────────────────────────────────────
        // 5. ASSET READY REFRESH (document.fonts.ready & window.load)
        // ─────────────────────────────────────────────────────────────────────
        if (document.fonts) {
            document.fonts.ready.then(function () {
                ScrollTrigger.refresh();
            });
        }

        window.addEventListener('load', function () {
            ScrollTrigger.refresh();
        });

        // Store context on window for debugging / cleanup
        window.kzMotionContext = ctx;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 6. INITIALIZATION LIFECYCLE
    // ─────────────────────────────────────────────────────────────────────────
    function init() {
        initLenisSmoothScroll();
        initMasterMotion();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})(window, document);
