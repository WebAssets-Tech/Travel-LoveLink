/**
 * ============================================================================
 * LOVE LINK - AWARD-WINNING GSAP 3.12.5 + SCROLLTRIGGER + LENIS 1.1.13 ENGINE
 * 
 * Distinct, High-End Motion System:
 * 1. Lenis Quartic Smooth Scrolling with 1:1 GSAP Ticker Sync
 * 2. True Left-Right Split Orchestration (About Us, Cabs, Destinations, Reasons, Contact)
 * 3. Cinematic Curtain Image Reveals (Clip-path unmasking + counter-scale zoom)
 * 4. Silky Fade-In / Fade-Out Tab Transitions & Fluid Cross-Fades
 * 5. Masked Headline Splits with Power4.out Easing
 * 6. Atmospheric Optical Blur Dissolves on Luxury Hotels
 * 7. Animated Stats Counters & Magnetic Micro-Interactions
 * ============================================================================
 */

(function () {
    'use strict';

    function initAwardWinningAnimations() {
        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined' || typeof Lenis === 'undefined') {
            return;
        }

        gsap.registerPlugin(ScrollTrigger);

        // ====================================================================
        // 1. Lenis Smooth Scroll Tuning (Continuous Lerp for Judder-Free Motion)
        // ====================================================================
        const lenis = new Lenis({
            lerp: 0.1,
            orientation: 'vertical',
            gestureOrientation: 'vertical',
            smoothWheel: true,
            wheelMultiplier: 0.95,
            touchMultiplier: 1.5,
            infinite: false,
        });
        window.lenis = lenis;

        // 1:1 hardware frame sync with GSAP Ticker
        lenis.on('scroll', ScrollTrigger.update);
        gsap.ticker.add((time) => {
            lenis.raf(time * 1000);
        });
        // GSAP recommended setting for Lenis: disable lag smoothing to prevent stutter/drift
        gsap.ticker.lagSmoothing(0);

        // Crucial: Swipers MUST NOT have data-lenis-prevent attribute.
        // Horizontal carousels scroll on X; vertical wheel events must freely pass to Lenis
        // so scrolling over slider sections is seamless and judder-free.
        document.querySelectorAll('.swiper, .swiper-wrapper, .swiper-slide').forEach(function (el) {
            el.removeAttribute('data-lenis-prevent');
        });

        // ====================================================================
        // 2. Responsive matchMedia (Accessibility & Motion Sensitivity Aware)
        // ====================================================================
        const mm = gsap.matchMedia();

        mm.add('(prefers-reduced-motion: no-preference)', function () {

            // ================================================================
            // 3. Top Gradient Progress Bar & Smart Autohiding Glass Navbar
            // ================================================================
            let progressBar = document.querySelector('.scroll-progress-bar');
            if (!progressBar) {
                progressBar = document.createElement('div');
                progressBar.className = 'scroll-progress-bar';
                document.body.appendChild(progressBar);
            }

            gsap.to(progressBar, {
                scaleX: 1,
                ease: 'none',
                scrollTrigger: {
                    trigger: document.body,
                    start: 'top top',
                    end: 'bottom bottom',
                    scrub: true,
                }
            });

            const header = document.querySelector('.th-header') || document.querySelector('header');
            let lastScrollY = window.scrollY || 0;
            let isNavHidden = false;
            let scrollDeltaAccumulator = 0;

            lenis.on('scroll', function (e) {
                if (!header) return;
                const scrollY = Math.max(0, e.scroll);

                if (scrollY > 50) {
                    header.classList.add('nav-scrolled');
                } else {
                    header.classList.remove('nav-scrolled');
                }

                const diff = scrollY - lastScrollY;

                // Accumulate sustained direction to prevent mouse-wheel notch bounce shivering
                if (diff > 0) {
                    scrollDeltaAccumulator = (scrollDeltaAccumulator > 0) ? scrollDeltaAccumulator + diff : diff;
                } else if (diff < 0) {
                    scrollDeltaAccumulator = (scrollDeltaAccumulator < 0) ? scrollDeltaAccumulator + diff : diff;
                }

                // Hide only on sustained downward scroll past threshold
                if (scrollY > 200 && scrollDeltaAccumulator > 30 && !isNavHidden) {
                    header.classList.add('nav-hidden');
                    isNavHidden = true;
                    scrollDeltaAccumulator = 0;
                } else if ((scrollDeltaAccumulator < -25 || scrollY <= 200) && isNavHidden) {
                    header.classList.remove('nav-hidden');
                    isNavHidden = false;
                    scrollDeltaAccumulator = 0;
                }

                lastScrollY = scrollY;
            });

            // ================================================================
            // 20. Animated Number Counters (All viewports)
            // ================================================================
            const counters = document.querySelectorAll('.kz-about-stat-card h3, .kz-about-exp-badge span, .anim-counter');
            counters.forEach(function (counter) {
                const text = counter.innerText.trim();
                const num = parseFloat(text.replace(/[^0-9.]/g, ''));
                if (isNaN(num)) return;

                const suffix = text.replace(/[0-9.]/g, '');
                const obj = { val: 0 };

                gsap.to(obj, {
                    val: num,
                    duration: 1.6,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: counter,
                        start: 'top 95%',
                        once: true,
                    },
                    onUpdate: function () {
                        const formatted = (num % 1 === 0) ? Math.floor(obj.val).toLocaleString() : obj.val.toFixed(1);
                        counter.textContent = formatted + suffix;
                    }
                });
            });

        }); // end all-viewports reduced-motion matchMedia

        // Desktop-only scroll-reveal & opacity animations (>= 992px)
        // Mobile (< 992px) keeps all sections immediately visible with zero opacity: 0 lockouts
        mm.add('(min-width: 992px) and (prefers-reduced-motion: no-preference)', function () {

            // ================================================================
            // 4. Hero Section: Cinematic Ingress Timeline on Page Load
            // ================================================================
            const heroWrapper = document.querySelector('.th-hero-wrapper');
            if (heroWrapper) {
                const heroTl = gsap.timeline({ defaults: { ease: 'power3.out' } });

                const marquee = document.querySelector('.kt-top-marquee');
                const heroSlider = document.querySelector('.hero-slider-1');
                const heroActiveImg = document.querySelector('.hero-slider-1 .swiper-slide-active img') || document.querySelector('.hero-slider-1 img');
                if (marquee) {
                    heroTl.fromTo(marquee,
                        { opacity: 0, y: -20 },
                        { opacity: 1, y: 0, duration: 0.65 }
                    );
                }

                if (heroSlider) {
                    heroTl.fromTo(heroSlider,
                        { opacity: 0, scale: 0.95, y: 25 },
                        { opacity: 1, scale: 1, y: 0, duration: 0.9 },
                        '-=0.35'
                    );
                }

                if (heroActiveImg) {
                    heroTl.fromTo(heroActiveImg,
                        { scale: 1.15 },
                        { scale: 1.0, duration: 1.1 },
                        '-=0.85'
                    );
                }
            }

            // ================================================================
            // 5. BIDIRECTIONAL SECTION & CARD ANIMATION ENGINE (FLICKER-FREE)
            // ================================================================
            /**
             * Orchestrates synchronized bidirectional motion:
             * - Section Headers & Titles: Gracefully glide down from TOP side (y: -38px -> 0px, opacity: 0 -> 1)
             * - Destination Cards, Package Cards, Category Cards, Cab Cards, Hotel Cards, etc.:
             *   Cascade upwards with a staggered lift and scale:
             *   (y: 46px -> 0px, scale: 0.94 -> 1, opacity: 0 -> 1, stagger: 0.07s, ease: 'power3.out')
             * - Ancillary content (buttons, pagination dots): Smoothly fade in
             * - Bidirectional: Reverses on scroll-past, re-plays when scrolling back!
             * - 100% FLICKER-FREE: Uses outer section boundaries and GPU composite layers (force3D: true)
             */
            function setupBidirectionalSection({
                trigger,
                header,
                cards,
                content,
                headerFrom = { opacity: 0, y: -38 },
                cardsFrom = { opacity: 0, y: 46, scale: 0.94 },
                contentFrom = { opacity: 0, y: 25 },
                stagger = 0.07,
                cardDuration = 0.75
            }) {
                const secEl = typeof trigger === 'string' ? document.querySelector(trigger) : trigger;
                if (!secEl) return null;

                const tl = gsap.timeline({
                    scrollTrigger: {
                        trigger: secEl,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse'
                    }
                });

                // 1. Header: Smooth Glide from Top Side
                if (header) {
                    const headerEl = typeof header === 'string' ? secEl.querySelector(header) : header;
                    if (headerEl) {
                        tl.fromTo(headerEl,
                            { opacity: 0, y: headerFrom.y !== undefined ? headerFrom.y : -38, force3D: true },
                            { opacity: 1, y: 0, duration: 0.7, ease: 'power2.out', force3D: true },
                            0
                        );
                    }
                }

                // 2. Cards: Staggered Cascading Lift and Scale (Destination cards, package cards, etc.)
                if (cards) {
                    const cardEls = typeof cards === 'string'
                        ? secEl.querySelectorAll(cards)
                        : (cards.length !== undefined ? cards : [cards]);
                    if (cardEls && cardEls.length > 0) {
                        // Cap total stagger duration so large sets don't take forever
                        const actualStagger = Math.min(stagger, 0.55 / Math.max(cardEls.length, 1));
                        tl.fromTo(cardEls,
                            {
                                opacity: 0,
                                y: cardsFrom.y !== undefined ? cardsFrom.y : 46,
                                scale: cardsFrom.scale !== undefined ? cardsFrom.scale : 0.94,
                                force3D: true
                            },
                            {
                                opacity: 1,
                                y: 0,
                                scale: 1,
                                duration: cardDuration,
                                stagger: actualStagger,
                                ease: 'power3.out',
                                force3D: true
                            },
                            0.08
                        );
                    }
                }

                // 3. Ancillary Content (Pagination dots, navigation buttons, view-all CTAs)
                if (content) {
                    const contentEls = typeof content === 'string'
                        ? secEl.querySelectorAll(content)
                        : (content.length !== undefined ? content : [content]);
                    if (contentEls && contentEls.length > 0) {
                        tl.fromTo(contentEls,
                            {
                                opacity: 0,
                                y: contentFrom.y !== undefined ? contentFrom.y : 25,
                                x: contentFrom.x !== undefined ? contentFrom.x : 0,
                                force3D: true
                            },
                            {
                                opacity: 1,
                                y: 0,
                                x: 0,
                                duration: 0.6,
                                ease: 'power2.out',
                                force3D: true
                            },
                            0.2
                        );
                    }
                }

                return tl;
            }

            // ── Hero Section: Subtle Dissolve Out on Downward Scroll ──
            const heroWrapperEl = document.querySelector('.th-hero-wrapper');
            if (heroWrapperEl) {
                gsap.to(heroWrapperEl, {
                    opacity: 0.15,
                    y: -40,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: heroWrapperEl,
                        start: 'top top',
                        end: 'bottom 25%',
                        scrub: 0.5
                    }
                });
            }

            // ================================================================
            // 6. DESTINATIONS: Header from Top + Destination State Cards Cascading Lift
            // ================================================================
            setupBidirectionalSection({
                trigger: '.dst-section',
                header: '.dst-section .row.align-items-center',
                cards: '.dst-section .dst-card',
                content: '.dst-section .dst-carousel-wrap',
                headerFrom: { opacity: 0, y: -35 },
                cardsFrom: { opacity: 0, y: 42, scale: 0.94 },
                stagger: 0.05
            });

            // ================================================================
            // 7. ABOUT US: Synchronized Split Ingress + Stat Cards Cascading Lift
            // ================================================================
            const aboutSec = document.querySelector('.kz-about-section');
            if (aboutSec) {
                const aboutTl = gsap.timeline({
                    scrollTrigger: {
                        trigger: aboutSec,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse'
                    }
                });

                const aboutLeft = aboutSec.querySelector('.kz-about-img-card');
                const aboutRight = aboutSec.querySelector('.kz-about-info-wrap');
                const aboutStatCards = aboutSec.querySelectorAll('.kz-about-stat-card');

                if (aboutLeft) {
                    aboutTl.fromTo(aboutLeft,
                        { opacity: 0, x: -45, force3D: true },
                        { opacity: 1, x: 0, duration: 0.8, ease: 'power2.out', force3D: true },
                        0
                    );
                }

                if (aboutRight) {
                    aboutTl.fromTo(aboutRight,
                        { opacity: 0, x: 45, force3D: true },
                        { opacity: 1, x: 0, duration: 0.8, ease: 'power2.out', force3D: true },
                        0
                    );
                }

                if (aboutStatCards.length > 0) {
                    aboutTl.fromTo(aboutStatCards,
                        { opacity: 0, y: 35, scale: 0.94, force3D: true },
                        { opacity: 1, y: 0, scale: 1, duration: 0.7, stagger: 0.08, ease: 'power3.out', force3D: true },
                        0.15
                    );
                }
            }

            // ================================================================
            // 8. TOUR CATEGORIES: Header from Top + Category Cards Cascading Lift
            // ================================================================
            setupBidirectionalSection({
                trigger: '.kz-cat-section',
                header: '.kz-cat-header',
                cards: '.kz-cat-section .kz-cat-card',
                content: '.kz-cat-section .kz-cat-pagination, .kz-cat-section .kz-cat-nav-wrap',
                headerFrom: { opacity: 0, y: -38 },
                cardsFrom: { opacity: 0, y: 46, scale: 0.94 },
                stagger: 0.07
            });

            // ================================================================
            // 9. AVAILABLE CABS & FLEET: Header from Top + Cab Cards Cascading Lift
            // ================================================================
            setupBidirectionalSection({
                trigger: '.kz-cabs-section',
                header: '.kz-cabs-header',
                cards: '.kz-cabs-section .kz-cab-box',
                content: '.kz-cabs-section .kz-blog-viewall-btn, .kz-cabs-section .swiper-pagination',
                headerFrom: { opacity: 0, y: -38 },
                cardsFrom: { opacity: 0, y: 46, scale: 0.94 },
                stagger: 0.07
            });

            // ================================================================
            // 10. POPULAR DESTINATIONS & PACKAGES: Header from Top + Package Cards Cascading Lift
            // ================================================================
            setupBidirectionalSection({
                trigger: '.kz-dest-section',
                header: '.kz-dest-header',
                cards: '.kz-dest-section .kz-glass-card',
                content: '.kz-dest-section .kz-dest-pagination, .kz-dest-section .kz-dest-nav-wrap',
                headerFrom: { opacity: 0, y: -38 },
                cardsFrom: { opacity: 0, y: 48, scale: 0.94 },
                stagger: 0.08
            });

            // ================================================================
            // 11. HOTELS & LUXURY RESORTS: Header from Top + Hotel Cards Cascading Lift
            // ================================================================
            setupBidirectionalSection({
                trigger: '.kz-hotels-section',
                header: '.kz-hotels-header',
                cards: '.kz-hotels-section .kz-hotel-home-card',
                content: '.kz-hotels-section .kz-blog-viewall-btn, .kz-hotels-section .kz-hotels-pagination',
                headerFrom: { opacity: 0, y: -38 },
                cardsFrom: { opacity: 0, y: 46, scale: 0.94 },
                stagger: 0.07
            });

            // ================================================================
            // 12. WHY CHOOSE US (REASONS): Header from Top + Reason Cards Cascading Lift
            // ================================================================
            setupBidirectionalSection({
                trigger: '.kz-reasons-section',
                header: '.kz-reasons-header',
                cards: '.kz-reasons-section .kz-reason-card',
                headerFrom: { opacity: 0, y: -38 },
                cardsFrom: { opacity: 0, y: 44, scale: 0.94 },
                stagger: 0.07
            });

            // ================================================================
            // 13. SPITI PROMO BANNER: Smooth Lift & Scale
            // ================================================================
            setupBidirectionalSection({
                trigger: '.kz-spiti-section',
                cards: '.kz-spiti-section .kz-spiti-banner-card',
                cardsFrom: { opacity: 0, y: 35, scale: 0.96 }
            });

            // ================================================================
            // 14. STATS COUNTER GRID: Stat Boxes Cascading Lift
            // ================================================================
            setupBidirectionalSection({
                trigger: '.kz-counter-section',
                cards: '.kz-counter-section .kz-count-box',
                cardsFrom: { opacity: 0, y: 40, scale: 0.94 },
                stagger: 0.08
            });

            // ================================================================
            // 15. BRAND PARTNERS MARQUEE: Fade In/Out
            // ================================================================
            setupBidirectionalSection({
                trigger: '.kz-brand-marquee-section',
                content: '.kz-brand-marquee-section .kz-brand-marquee-viewport',
                contentFrom: { opacity: 0, y: 25 }
            });

            // ================================================================
            // 16. BLOG & TRAVEL STORIES: Header from Top + Blog Cards Cascading Lift
            // ================================================================
            setupBidirectionalSection({
                trigger: '.kz-blog-section',
                header: '.kz-blog-header',
                cards: '.kz-blog-section .kz-blog-card',
                content: '.kz-blog-section .kz-blog-viewall-btn',
                headerFrom: { opacity: 0, y: -38 },
                cardsFrom: { opacity: 0, y: 46, scale: 0.94 },
                stagger: 0.07
            });

            // ================================================================
            // 17. TRAVEL GALLERY: Header from Top + Gallery Cards Cascading Lift
            // ================================================================
            setupBidirectionalSection({
                trigger: '.kz-gallery-section',
                header: '.kz-gallery-header',
                cards: '.kz-gallery-section .kz-gallery-card',
                content: '.kz-gallery-section .kz-gallery-pagination, .kz-gallery-section .kz-gallery-nav-wrap',
                headerFrom: { opacity: 0, y: -38 },
                cardsFrom: { opacity: 0, y: 46, scale: 0.94 },
                stagger: 0.07
            });

            // ================================================================
            // 18. REVIEWS & TESTIMONIALS: Header from Top + Review Cards Cascading Lift
            // ================================================================
            setupBidirectionalSection({
                trigger: '.kz-reviews-section',
                header: '.kz-reviews-header',
                cards: '.kz-reviews-section #reviewsCarousel .swiper-slide, .kz-reviews-section .kz-review-card',
                content: '.kz-reviews-section .swiper-pagination, .kz-reviews-section .swiper-button-prev, .kz-reviews-section .swiper-button-next',
                headerFrom: { opacity: 0, y: -38 },
                cardsFrom: { opacity: 0, y: 46, scale: 0.94 },
                stagger: 0.08
            });

            // ================================================================
            // 19. FAQ & CONTACT FORM: Synchronized Split Ingress
            // ================================================================
            const faqSec = document.querySelector('.kz-faq-contact-section, .kz-contact-section, .kz-faq-section');
            if (faqSec) {
                const faqTl = gsap.timeline({
                    scrollTrigger: {
                        trigger: faqSec,
                        start: 'top 85%',
                        end: 'bottom 15%',
                        toggleActions: 'play reverse play reverse'
                    }
                });

                const faqBox = faqSec.querySelector('.kz-faq-box, .kz-faq-list-wrap');
                const faqCards = faqSec.querySelectorAll('.kz-faq-card, .kz-faq-item');
                const contactCard = faqSec.querySelector('.kz-contact-card');

                if (faqBox) {
                    faqTl.fromTo(faqBox,
                        { opacity: 0, x: -40, force3D: true },
                        { opacity: 1, x: 0, duration: 0.8, ease: 'power2.out', force3D: true },
                        0
                    );
                }

                if (faqCards.length > 0) {
                    faqTl.fromTo(faqCards,
                        { opacity: 0, y: 25, force3D: true },
                        { opacity: 1, y: 0, duration: 0.6, stagger: 0.06, ease: 'power2.out', force3D: true },
                        0.15
                    );
                }

                if (contactCard) {
                    faqTl.fromTo(contactCard,
                        { opacity: 0, x: 40, force3D: true },
                        { opacity: 1, x: 0, duration: 0.8, ease: 'power2.out', force3D: true },
                        0
                    );
                }
            }

            // ================================================================
            // 21. Subtle Magnetic Micro-Interactions on CTA Buttons
            // ================================================================
            const magneticBtns = document.querySelectorAll(
                '.kt-s-btn, .kz-about-btn-cta, .kz-cab-btn, .kz-glass-btn, ' +
                '.kz-hotel-detail-btn, .kz-blog-viewall-btn, .kz-contact-submit-btn, .btn-magnetic'
            );

            magneticBtns.forEach(function (btn) {
                btn.addEventListener('mousemove', function (e) {
                    const rect = btn.getBoundingClientRect();
                    const x = e.clientX - rect.left - rect.width / 2;
                    const y = e.clientY - rect.top - rect.height / 2;
                    gsap.to(btn, { x: x * 0.22, y: y * 0.22, duration: 0.25, ease: 'power2.out' });
                });

                btn.addEventListener('mouseleave', function () {
                    gsap.to(btn, { x: 0, y: 0, duration: 0.45, ease: 'elastic.out(1, 0.4)', clearProps: 'transform' });
                });
            });

        }); // end desktop matchMedia

        // Refresh ScrollTrigger when images finish loading
        window.addEventListener('load', function () {
            ScrollTrigger.refresh();
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAwardWinningAnimations);
    } else {
        initAwardWinningAnimations();
    }

})();
