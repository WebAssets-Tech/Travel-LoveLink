/**
 * Love Link Tours & Travels - Optimized Frontend Interactions
 */

/* ========================================================
   1. Header & Navigation (Preloader & Menus)
   ======================================================== */
// Self-executing Preloader Loading Experience (Bespoke Luxury Progress Engine)
(function () {
    var loader = document.getElementById('preloader') || document.querySelector('.kaw-preloader');
    if (!loader) return;

    var fill = document.getElementById('kawPreloaderFill');
    var numEl = document.getElementById('kawPreloaderNum');
    var statusEl = document.getElementById('kawPreloaderStatus');

    var currentProgress = 0;
    var targetProgress = 18;
    var isLoaded = false;
    var animationFrameId = null;

    var stageStatuses = [
        { threshold: 30, text: 'Curating Luxury Itineraries' },
        { threshold: 65, text: 'Polishing Kashmir Horizons' },
        { threshold: 92, text: 'Finalizing Experience' },
        { threshold: 100, text: 'Experience Ready' }
    ];

    function updateStatusText(pct) {
        if (!statusEl) return;
        for (var i = 0; i < stageStatuses.length; i++) {
            if (pct <= stageStatuses[i].threshold) {
                if (statusEl.textContent !== stageStatuses[i].text) {
                    statusEl.textContent = stageStatuses[i].text;
                }
                break;
            }
        }
    }

    function renderProgress() {
        // Silky asymptotic approach toward current target
        currentProgress += (targetProgress - currentProgress) * 0.12;

        var displayVal = Math.floor(currentProgress);
        if (displayVal > 100) displayVal = 100;

        if (fill) fill.style.width = currentProgress.toFixed(1) + '%';
        if (numEl) numEl.textContent = (displayVal < 10 ? '0' : '') + displayVal;
        updateStatusText(displayVal);

        if (isLoaded && currentProgress >= 99.5) {
            // Completed!
            if (fill) fill.style.width = '100%';
            if (numEl) numEl.textContent = '100';
            updateStatusText(100);

            setTimeout(function () {
                loader.classList.add('kaw-loaded');
                setTimeout(function () {
                    if (loader && loader.parentNode) {
                        loader.style.display = 'none';
                    }
                }, 580);
            }, 180);
            return;
        }

        animationFrameId = requestAnimationFrame(renderProgress);
    }

    animationFrameId = requestAnimationFrame(renderProgress);

    // Staged progression checkpoints
    setTimeout(function () { if (!isLoaded) targetProgress = 46; }, 120);
    setTimeout(function () { if (!isLoaded) targetProgress = 76; }, 320);

    if (document.readyState === 'complete') {
        finishLoading();
    } else {
        window.addEventListener('load', finishLoading);
        // Fallback safeguard to guarantee dismiss even on slow networks
        setTimeout(finishLoading, 2200);
    }

    function finishLoading() {
        if (isLoaded) return;
        isLoaded = true;
        targetProgress = 100;
    }
})();

// ── Global Swiper Desktop Drag Optimization ──
// Prevents native browser ghost image/link drag from blocking Swiper pointer events
document.addEventListener('dragstart', function (e) {
    if (e.target && e.target.closest && e.target.closest('.swiper')) {
        e.preventDefault();
        return false;
    }
}, false);

function disableNativeDragInSwipers() {
    var items = document.querySelectorAll('.swiper img, .swiper a, .dst-card-img, .kz-cat-img, .kz-glass-img, .kz-hotel-media img, .kz-gallery-img');
    for (var i = 0; i < items.length; i++) {
        items[i].setAttribute('draggable', 'false');
    }
}
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', disableNativeDragInSwipers);
} else {
    disableNativeDragInSwipers();
}

document.addEventListener('DOMContentLoaded', function () {

    /* ---- Customer Service Dropdown ---- */
    var csBtn = document.getElementById('kawCsBtn');
    var csDrop = document.getElementById('kawCsDrop');

    if (csBtn && csDrop) {
        function openCS() {
            var rect = csBtn.getBoundingClientRect();
            var dropW = csDrop.offsetWidth || 290;
            var margin = 12;
            var viewportW = window.innerWidth;

            var top = rect.bottom + 8;
            var left = rect.right - dropW;

            if (left < margin) left = margin;
            if (left + dropW > viewportW - margin) left = viewportW - dropW - margin;

            csDrop.style.top = top + 'px';
            csDrop.style.left = left + 'px';
            csDrop.style.right = 'auto';

            csDrop.classList.add('is-open');
            csBtn.classList.add('is-active');
        }

        function closeCS() {
            if (csDrop && csDrop.classList.contains('is-open')) {
                csDrop.classList.remove('is-open');
                if (csBtn) csBtn.classList.remove('is-active');
            }
        }

        csBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            if (csDrop.classList.contains('is-open')) {
                closeCS();
            } else {
                closePanel();
                openCS();
            }
        });

        document.addEventListener('click', closeCS);
        window.addEventListener('scroll', closeCS, true);
        window.addEventListener('resize', closeCS);
    }

    /* ---- More Icons Dropdown ---- */
    var moreBtn = document.getElementById('kawFiMoreBtn');
    var panel = document.getElementById('kawFiPanel');
    var backdrop = document.getElementById('kawFiBackdrop');
    var moreLabel = document.getElementById('kawFiMoreLabel');

    function openPanel() {
        if (!panel) return;
        panel.classList.add('is-visible');
        if (backdrop) backdrop.classList.add('is-active');
        if (moreBtn) moreBtn.classList.add('is-expanded');
        if (moreBtn) moreBtn.setAttribute('aria-expanded', 'true');
        if (moreLabel) moreLabel.textContent = 'Less';
    }

    function closePanel() {
        if (!panel) return;
        panel.classList.remove('is-visible');
        if (backdrop) backdrop.classList.remove('is-active');
        if (moreBtn) moreBtn.classList.remove('is-expanded');
        if (moreBtn) moreBtn.setAttribute('aria-expanded', 'false');
        if (moreLabel) moreLabel.textContent = 'More';
    }

    if (moreBtn && panel) {
        moreBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            if (panel.classList.contains('is-visible')) {
                closePanel();
            } else {
                if (typeof closeCS === 'function') closeCS();
                openPanel();
            }
        });
    }

    if (backdrop) {
        backdrop.addEventListener('click', function () {
            closePanel();
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closePanel();
            if (typeof closeCS === 'function') closeCS();
        }
    });
});

/* ========================================================
   2. Global Booking Modal (Mail & WhatsApp)
   ======================================================== */
document.addEventListener('DOMContentLoaded', function () {

    // Tab switching (Packages > Cabs > Hotels)
    var tabs = document.querySelectorAll('#globalContactModal .gb-tab');
    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            tabs.forEach(function (t) { t.classList.remove('active'); t.setAttribute('aria-selected', 'false'); });
            document.querySelectorAll('#globalContactModal .gb-panel').forEach(function (p) { p.classList.remove('active'); });
            tab.classList.add('active');
            tab.setAttribute('aria-selected', 'true');
            var targetPanel = document.getElementById(tab.dataset.target);
            if (targetPanel) {
                targetPanel.classList.add('active');
                var panelBody = targetPanel.querySelector('.modal-body');
                if (panelBody) panelBody.scrollTop = 0;
            }
        });
    });

    var modalEl = document.getElementById('globalContactModal');

    if (modalEl) {
        modalEl.addEventListener('show.bs.modal', function () {
            if (window.lenis && typeof window.lenis.stop === 'function') {
                window.lenis.stop();
            }
        });

        modalEl.addEventListener('hidden.bs.modal', function () {
            if (window.lenis && typeof window.lenis.start === 'function') {
                window.lenis.start();
            }
        });
    }

    // Reopen modal only if Laravel returns validation errors
    if (modalEl && modalEl.getAttribute('data-has-errors') === '1') {
        if (modalEl && typeof bootstrap !== 'undefined') {
            var modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modalInstance.show();
        }
    }

    var alertBox = document.getElementById('gc-form-alert');
    var forms = document.querySelectorAll('#globalContactModal .gb-panel');
    var defaultWaPhone = (modalEl && modalEl.getAttribute('data-default-wa')) || '917006338617';

    // 1. AJAX submit for "Book via Mail" (standard form submit)
    forms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var submitBtn = form.querySelector('button[type="submit"]');
            var originalLabel = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Sending...';

            fetch(form.action, { method: 'POST', body: new FormData(form) })
                .then(function (res) {
                    return res.json().catch(function () { return null; }).then(function (data) {
                        if (!res.ok) throw { status: res.status, data: data };
                        return data;
                    });
                })
                .then(function (data) {
                    alertBox.style.display = 'block';
                    alertBox.className = 'alert alert-success gb-alert mx-4 mt-3 mb-0';
                    alertBox.innerText = (data && data.message) || 'Booking request sent successfully via Mail.';
                    form.reset();
                    setTimeout(function () {
                        var modal = bootstrap.Modal.getInstance(modalEl);
                        if (modal) modal.hide();
                        alertBox.style.display = 'none';
                    }, 1500);
                })
                .catch(function (err) {
                    console.error(err);
                    var message = 'Something went wrong. Please try again.';
                    if (err && err.data && err.data.errors) {
                        var messages = [];
                        for (var key in err.data.errors) {
                            if (Object.prototype.hasOwnProperty.call(err.data.errors, key)) {
                                messages.push(err.data.errors[key].join(' '));
                            }
                        }
                        if (messages.length) message = messages.join(' ');
                    } else if (err && err.data && err.data.message) {
                        message = err.data.message;
                    }
                    alertBox.style.display = 'block';
                    alertBox.className = 'alert alert-danger gb-alert mx-4 mt-3 mb-0';
                    alertBox.innerText = message;
                })
                .finally(function () {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalLabel;
                });
        });
    });

    // 2. Click handler for "Book via WhatsApp"
    var waButtons = document.querySelectorAll('#globalContactModal .gb-btn-whatsapp');
    waButtons.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var form = btn.closest('form');
            if (!form) return;

            // Dynamic WhatsApp number from button attribute or default setting
            var targetWaPhone = btn.getAttribute('data-whatsapp') || defaultWaPhone || '917006338617';

            // Form validation
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            var bType = form.querySelector('input[name="booking_type"]') ? form.querySelector('input[name="booking_type"]').value : '';
            var waMessage = '';

            if (bType === 'package') {
                var pName = form.querySelector('#pkg-name')?.value || '';
                var pPhone = form.querySelector('#pkg-phone')?.value || '';
                var pDest = form.querySelector('#pkg-destination')?.value || '';
                var pTourEl = form.querySelector('#pkg-tour');
                var pTour = pTourEl ? (pTourEl.options[pTourEl.selectedIndex]?.text || pTourEl.value) : '';
                var pArrival = form.querySelector('#pkg-arrival')?.value || '';
                var pPersons = form.querySelector('#pkg-persons')?.value || '';
                var pRooms = form.querySelector('#pkg-rooms')?.value || '';
                var pHotelCatEl = form.querySelector('#pkg-hotel-cat');
                var pHotelCat = pHotelCatEl ? (pHotelCatEl.options[pHotelCatEl.selectedIndex]?.text || pHotelCatEl.value) : '';
                var pPickup = form.querySelector('#pkg-pickup')?.value || '';
                var pDrop = form.querySelector('#pkg-drop')?.value || '';

                waMessage = "🌟 *NEW TOUR PACKAGE BOOKING INQUIRY* 🌟\n" +
                    "--------------------------------\n" +
                    "👤 *Name:* " + pName + "\n" +
                    "📱 *Customer Phone:* " + pPhone + "\n" +
                    "📍 *Destination:* " + pDest + "\n" +
                    "🏷 *Tour:* " + pTour + "\n" +
                    "📅 *Arrival Date:* " + pArrival + "\n" +
                    "👥 *Persons:* " + pPersons + "\n" +
                    "🛏 *Rooms:* " + pRooms + "\n" +
                    "🏨 *Hotel Category:* " + pHotelCat + "\n" +
                    "🚗 *Pick-up:* " + pPickup + "\n" +
                    "🚗 *Drop:* " + pDrop + "\n" +
                    "--------------------------------\n" +
                    "Please confirm availability & share best package quotation.";
            } else if (bType === 'cab') {
                var cName = form.querySelector('#cab-name')?.value || '';
                var cPhone = form.querySelector('#cab-phone')?.value || '';
                var cFrom = form.querySelector('#cab-from')?.value || '';
                var cTo = form.querySelector('#cab-to')?.value || '';
                var cArrival = form.querySelector('#cab-arrival')?.value || '';
                var cVehicleEl = form.querySelector('#cab-vehicle');
                var cVehicle = cVehicleEl ? (cVehicleEl.options[cVehicleEl.selectedIndex]?.text || cVehicleEl.value) : '';
                var cMsg = form.querySelector('#cab-message')?.value || '';

                waMessage = "🚗 *NEW CAB BOOKING INQUIRY* 🚗\n" +
                    "--------------------------------\n" +
                    "👤 *Name:* " + cName + "\n" +
                    "📱 *Customer Phone:* " + cPhone + "\n" +
                    "📍 *From (Pickup):* " + cFrom + "\n" +
                    "📍 *To (Drop):* " + cTo + "\n" +
                    "📅 *Travel Date:* " + cArrival + "\n" +
                    "🚘 *Vehicle:* " + cVehicle + "\n" +
                    (cMsg ? ("📝 *Notes:* " + cMsg + "\n") : "") +
                    "--------------------------------\n" +
                    "Please confirm cab availability & share quotation.";
            } else if (bType === 'hotel') {
                var hName = form.querySelector('#hotel-name')?.value || '';
                var hPhone = form.querySelector('#hotel-phone')?.value || '';
                var hLocEl = form.querySelector('#hotel-location');
                var hLoc = hLocEl ? (hLocEl.options[hLocEl.selectedIndex]?.text || hLocEl.value) : '';
                var hCatEl = form.querySelector('#hotel-category');
                var hCat = hCatEl ? (hCatEl.options[hCatEl.selectedIndex]?.text || hCatEl.value) : '';
                var hCheckin = form.querySelector('#hotel-checkin')?.value || '';
                var hCheckout = form.querySelector('#hotel-checkout')?.value || '';
                var hRooms = form.querySelector('#hotel-rooms')?.value || '1';
                var hAdults = form.querySelector('#hotel-adults')?.value || '2';
                var hKids = form.querySelector('#hotel-kids')?.value || '0';
                var hMsg = form.querySelector('#hotel-message')?.value || '';

                waMessage = "🏨 *NEW HOTEL BOOKING INQUIRY* 🏨\n" +
                    "--------------------------------\n" +
                    "👤 *Name:* " + hName + "\n" +
                    "📱 *Customer Phone:* " + hPhone + "\n" +
                    "📍 *Location:* " + hLoc + "\n" +
                    "⭐ *Hotel Category:* " + hCat + "\n" +
                    "📅 *Check-in Date:* " + hCheckin + "\n" +
                    "📅 *Check-out Date:* " + hCheckout + "\n" +
                    "🛏 *Rooms:* " + hRooms + " | 👥 *Adults:* " + hAdults + " | 👶 *Kids:* " + hKids + "\n" +
                    (hMsg ? ("📝 *Notes:* " + hMsg + "\n") : "") +
                    "--------------------------------\n" +
                    "Please share available hotels and best room rates.";
            }

            // Save lead asynchronously in background
            try {
                var formData = new FormData(form);
                formData.append('channel', 'whatsapp');
                fetch(form.action, { method: 'POST', body: formData }).catch(function (err) {
                    console.warn('WhatsApp lead background save:', err);
                });
            } catch (err) {
                console.warn(err);
            }

            // Open WhatsApp with dynamic number and prefilled details
            var waUrl = "https://wa.me/" + targetWaPhone + "?text=" + encodeURIComponent(waMessage);
            window.open(waUrl, '_blank');

            alertBox.style.display = 'block';
            alertBox.className = 'alert alert-success gb-alert mx-4 mt-3 mb-0';
            alertBox.innerText = 'Connecting to WhatsApp with your booking details...';
            form.reset();

            setTimeout(function () {
                var modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
                alertBox.style.display = 'none';
            }, 1500);
        });
    });

});

/* ========================================================
   3. Footer Interactions & Mobile Accordion
   ======================================================== */
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Swiper !== 'undefined') {
        const kawSwiper = new Swiper('#kawDomesticSwiper', {
            loop: true,
            centeredSlides: false,
            grabCursor: true,
            speed: 850,
            watchSlidesProgress: true,
            resistance: true,
            resistanceRatio: 0.85,
            simulateTouch: true,
            touchReleaseOnEdges: true,
            preventClicks: true,
            preventClicksPropagation: false,
            mousewheel: false,
            breakpoints: {
                0: { slidesPerView: 1.2, spaceBetween: 16 },
                576: { slidesPerView: 2.2, spaceBetween: 20 },
                992: { slidesPerView: 3.2, spaceBetween: 24 },
                1200: { slidesPerView: 3.8, spaceBetween: 28 }
            }
        });

        var prevBtn = document.getElementById('kawDomesticPrev');
        var nextBtn = document.getElementById('kawDomesticNext');
        if (prevBtn) prevBtn.addEventListener('click', function () { kawSwiper.slidePrev(); });
        if (nextBtn) nextBtn.addEventListener('click', function () { kawSwiper.slideNext(); });
    }
});

// Footer accordion toggle (mobile only)
document.querySelectorAll('[data-accordion-toggle]').forEach(function (header) {
    header.addEventListener('click', function (e) {
        if (window.innerWidth >= 768) return;
        var col = this.closest('.footer-accordion-col');
        if (!col) return;
        var isOpen = col.classList.contains('active') || col.classList.contains('is-open');

        if (col.classList.contains('kz-col-concierge')) {
            // 24/7 Support toggles itself directly without affecting others
            if (isOpen) {
                col.classList.remove('active', 'is-open');
            } else {
                col.classList.add('active', 'is-open');
            }
        } else {
            // For other columns (Quick Links, Destinations), close other non-concierge columns while keeping 24/7 Support open
            document.querySelectorAll('.footer-accordion-col:not(.kz-col-concierge)').forEach(function (c) {
                if (c !== col) {
                    c.classList.remove('active', 'is-open');
                }
            });

            if (isOpen) {
                col.classList.remove('active', 'is-open');
            } else {
                col.classList.add('active', 'is-open');
            }
        }
    });
});

// Other Offices dropdown toggle (both desktop & mobile)
document.querySelectorAll('[data-offices-toggle]').forEach(function (toggle) {
    toggle.addEventListener('click', function () {
        var wrapper = this.closest('.footer-other-offices');
        if (!wrapper) return;
        wrapper.classList.toggle('active');
    });
});

/* ========================================================
   4. Home Page Components & GSAP Scroll Motion Engine
   ======================================================== */
(function () {
    // ── 2. HERO SLIDER LUXURY CROSSFADE & KEN BURNS ──
    (function initHeroSliderDynamics() {
        var heroEl = document.querySelector('#heroSlide1');
        if (!heroEl) return;

        function setupHeroSwiper() {
            if (typeof Swiper === 'undefined') {
                setTimeout(setupHeroSwiper, 80);
                return;
            }

            var swiper = heroEl.swiper;
            if (swiper) {
                swiper.destroy(true, true);
                swiper = null;
            }

            swiper = new Swiper(heroEl, {
                slidesPerView: 1,
                spaceBetween: 0,
                speed: 1100,
                effect: 'creative',
                creativeEffect: {
                    prev: {
                        translate: ['-20%', 0, -1],
                        scale: 0.96,
                        opacity: 0.3
                    },
                    next: {
                        translate: ['100%', 0, 0],
                        scale: 1,
                        opacity: 1
                    }
                },
                loop: true,
                grabCursor: true,
                simulateTouch: true,
                touchReleaseOnEdges: true,
                preventClicks: true,
                preventClicksPropagation: false,
                mousewheel: false,
                watchSlidesProgress: true,
                autoplay: {
                    delay: 5500,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true
                },
                navigation: {
                    nextEl: '.th-swiper-custom .slider-next, [data-slider-next="#heroSlide1"]',
                    prevEl: '.th-swiper-custom .slider-prev, [data-slider-prev="#heroSlide1"]'
                }
            });

            var prevBtn = heroEl.parentElement.querySelector('.slider-prev') || heroEl.querySelector('.slider-prev');
            var nextBtn = heroEl.parentElement.querySelector('.slider-next') || heroEl.querySelector('.slider-next');

            if (prevBtn && !prevBtn._boundSlide) {
                prevBtn._boundSlide = true;
                prevBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (swiper) swiper.slidePrev();
                });
            }
            if (nextBtn && !nextBtn._boundSlide) {
                nextBtn._boundSlide = true;
                nextBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (swiper) swiper.slideNext();
                });
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', setupHeroSwiper);
        } else {
            setupHeroSwiper();
        }
    })();

    // ── 3. STATIC STATS NUMBERS (NO SCROLL ANIMATION) ──
    function initStatsCounters() {
        var statsSection = document.querySelector('.kz-about-stat-row') || document.querySelector('.kaw-about-stats');
        if (!statsSection) return;

        var statConfigs = [
            { fallbackText: '50,000+' },
            { fallbackText: '2500+' },
            { fallbackText: '4.9' }
        ];

        var statBoxes = statsSection.querySelectorAll('.kz-about-stat-card, .kaw-about-stat-box');
        statBoxes.forEach(function (box, index) {
            var cfg = statConfigs[index];
            if (!cfg) return;
            var targetSpan = box.querySelector('h3');
            if (targetSpan) {
                targetSpan.textContent = cfg.fallbackText;
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initStatsCounters);
    } else {
        initStatsCounters();
    }
    // ── 4. GENERALIZED 3-DOT PAGINATION CONTROLLER ──
    /**
     * Generalizes dot navigation to exactly 3 dots across all sliders:
     * [Start] [Middle] [End]
     * Replaces cluttered rows of 10-25 dots with a clean, luxury 3-indicator control.
     */
    function bindThreeDotPagination(swiper, paginationSelector) {
        var container = typeof paginationSelector === 'string'
            ? document.querySelector(paginationSelector)
            : paginationSelector;
        if (!container || !swiper) return;

        container.innerHTML =
            '<span class="swiper-pagination-bullet swiper-pagination-bullet-active" data-dot="0" role="button" tabindex="0" aria-label="First slide page"></span>' +
            '<span class="swiper-pagination-bullet" data-dot="1" role="button" tabindex="0" aria-label="Middle slide page"></span>' +
            '<span class="swiper-pagination-bullet" data-dot="2" role="button" tabindex="0" aria-label="Last slide page"></span>';

        var bullets = container.querySelectorAll('.swiper-pagination-bullet');

        function updateDots() {
            if (!swiper || !swiper.slides) return;
            var activeDot = 1;
            if (swiper.isBeginning) {
                activeDot = 0;
            } else if (swiper.isEnd) {
                activeDot = 2;
            } else {
                activeDot = 1;
            }

            bullets.forEach(function (b, idx) {
                if (idx === activeDot) {
                    b.classList.add('swiper-pagination-bullet-active');
                } else {
                    b.classList.remove('swiper-pagination-bullet-active');
                }
            });
        }

        bullets.forEach(function (b, idx) {
            b.addEventListener('click', function (e) {
                e.preventDefault();
                var total = swiper.slides.length;
                if (idx === 0) {
                    swiper.slideTo(0, 600);
                } else if (idx === 1) {
                    var midIndex = Math.floor(total / 2);
                    swiper.slideTo(midIndex, 600);
                } else if (idx === 2) {
                    swiper.slideTo(total - 1, 600);
                }
            });

            b.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    b.click();
                }
            });
        });

        swiper.on('slideChange', updateDots);
        swiper.on('transitionEnd', updateDots);
        swiper.on('resize', updateDots);
        setTimeout(updateDots, 100);
    }
    function initHomepageSwipers() {
        if (typeof Swiper === 'undefined') return;

        var commonSwiperOptions = {
            simulateTouch: true,
            touchReleaseOnEdges: true,
            preventClicks: true,
            preventClicksPropagation: false,
            mousewheel: false
        };

        // A. Tour Categories
        var catEl = document.querySelector('#kzCategorySwiper');
        if (catEl && !catEl.swiper) {
            var catSwiper = new Swiper('#kzCategorySwiper', Object.assign({
                loop: false,
                grabCursor: true,
                speed: 850,
                watchSlidesProgress: true,
                resistance: true,
                resistanceRatio: 0.85,
                autoplay: {
                    delay: 4500,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                breakpoints: {
                    0: { slidesPerView: 1, spaceBetween: 16 },
                    576: { slidesPerView: 2, spaceBetween: 20 },
                    992: { slidesPerView: 3, spaceBetween: 24 },
                    1200: { slidesPerView: 4, spaceBetween: 26 }
                }
            }, commonSwiperOptions));
            bindThreeDotPagination(catSwiper, '.kz-cat-pagination');
        }

        // B. Cabs Fleet
        var cabsEl = document.querySelector('#kzCabsSwiper');
        if (cabsEl && !cabsEl.swiper) {
            var cabsSwiper = new Swiper('#kzCabsSwiper', Object.assign({
                loop: false,
                grabCursor: true,
                speed: 850,
                watchSlidesProgress: true,
                resistance: true,
                resistanceRatio: 0.85,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                breakpoints: {
                    0: { slidesPerView: 1, spaceBetween: 14 },
                    576: { slidesPerView: 2, spaceBetween: 18 },
                    992: { slidesPerView: 3, spaceBetween: 22 },
                    1200: { slidesPerView: 4, spaceBetween: 22 }
                }
            }, commonSwiperOptions));
            bindThreeDotPagination(cabsSwiper, '.kz-cabs-pagination');
        }

        // C. Popular Destinations
        var destEl = document.querySelector('#kzDestSwiper');
        if (destEl && !destEl.swiper) {
            var destSwiper = new Swiper('#kzDestSwiper', Object.assign({
                loop: false,
                grabCursor: true,
                speed: 850,
                watchSlidesProgress: true,
                resistance: true,
                resistanceRatio: 0.85,
                autoplay: {
                    delay: 4500,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                breakpoints: {
                    0: { slidesPerView: 1, spaceBetween: 16 },
                    576: { slidesPerView: 2, spaceBetween: 20 },
                    992: { slidesPerView: 3, spaceBetween: 24 },
                    1200: { slidesPerView: 4, spaceBetween: 24 }
                }
            }, commonSwiperOptions));
            bindThreeDotPagination(destSwiper, '.kz-dest-pagination');
        }

        // D. Handpicked Hotels & Luxury Resorts
        var hotelsEl = document.querySelector('#kzHotelsSwiper');
        if (hotelsEl && !hotelsEl.swiper) {
            var hotelsSwiper = new Swiper('#kzHotelsSwiper', Object.assign({
                slidesPerView: 1,
                spaceBetween: 16,
                loop: false,
                grabCursor: true,
                speed: 850,
                watchSlidesProgress: true,
                resistance: true,
                resistanceRatio: 0.85,
                observer: true,
                observeParents: true,
                resizeObserver: true,
                autoplay: {
                    delay: 4800,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                navigation: {
                    nextEl: '#kzHotelsNext',
                    prevEl: '#kzHotelsPrev',
                },
                breakpoints: {
                    0: { slidesPerView: 1, spaceBetween: 14 },
                    576: { slidesPerView: 2, spaceBetween: 18 },
                    992: { slidesPerView: 3, spaceBetween: 22 },
                    1200: { slidesPerView: 4, spaceBetween: 24 }
                }
            }, commonSwiperOptions));
            bindThreeDotPagination(hotelsSwiper, '.kz-hotels-pagination');
        }

        // D2. Heritage & Luxury Houseboats
        var houseboatsEl = document.querySelector('#kzHouseboatsSwiper');
        if (houseboatsEl && !houseboatsEl.swiper) {
            var houseboatsSwiper = new Swiper('#kzHouseboatsSwiper', Object.assign({
                slidesPerView: 1,
                spaceBetween: 16,
                loop: false,
                grabCursor: true,
                speed: 850,
                watchSlidesProgress: true,
                resistance: true,
                resistanceRatio: 0.85,
                observer: true,
                observeParents: true,
                resizeObserver: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                navigation: {
                    nextEl: '#kzHouseboatsNext',
                    prevEl: '#kzHouseboatsPrev',
                },
                breakpoints: {
                    0: { slidesPerView: 1, spaceBetween: 14 },
                    576: { slidesPerView: 2, spaceBetween: 18 },
                    992: { slidesPerView: 3, spaceBetween: 22 },
                    1200: { slidesPerView: 4, spaceBetween: 24 }
                }
            }, commonSwiperOptions));
            bindThreeDotPagination(houseboatsSwiper, '.kz-houseboats-pagination');
        }

        // E. Recent Gallery Swiper (with Premium Arrows & Root Tokens)
        var galleryEl = document.querySelector('#kzGallerySwiper');
        if (galleryEl && !galleryEl.swiper) {
            var gallerySwiper = new Swiper('#kzGallerySwiper', Object.assign({
                slidesPerView: 1.3,
                spaceBetween: 14,
                loop: false,
                grabCursor: true,
                speed: 850,
                watchSlidesProgress: true,
                resistance: true,
                resistanceRatio: 0.85,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true
                },
                navigation: {
                    nextEl: '#kzGalleryNext',
                    prevEl: '#kzGalleryPrev'
                },
                breakpoints: {
                    0: { slidesPerView: 1.3, spaceBetween: 14 },
                    480: { slidesPerView: 2.2, spaceBetween: 16 },
                    768: { slidesPerView: 3.2, spaceBetween: 20 },
                    992: { slidesPerView: 4.2, spaceBetween: 22 },
                    1200: { slidesPerView: 5, spaceBetween: 24 }
                }
            }, commonSwiperOptions));
            bindThreeDotPagination(gallerySwiper, '.kz-gallery-pagination');
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHomepageSwipers);
    } else {
        initHomepageSwipers();
    }

    // ── 5. GALLERY LIGHTBOX CONTROLLER (NATIVE / MODAL FALLBACK) ──
    document.addEventListener('DOMContentLoaded', function () {
        // If jQuery Magnific Popup is available in the theme, initialize it
        if (window.jQuery && typeof window.jQuery.fn.magnificPopup === 'function') {
            window.jQuery('.kz-gallery-slider-wrap .popup-image').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>'
                },
                zoom: {
                    enabled: true,
                    duration: 300
                }
            });
            return;
        }

        // Standalone Lightbox Modal Fallback (Works with Zero Dependencies)
        var modal = document.querySelector('#kzGalleryLightbox');
        if (!modal) return;

        var modalImg = document.querySelector('#kzLightboxImg');
        var modalCaption = document.querySelector('#kzLightboxCaption');
        var closeBtn = document.querySelector('#kzLightboxClose');
        var prevBtn = document.querySelector('#kzLightboxPrev');
        var nextBtn = document.querySelector('#kzLightboxNext');

        var links = Array.from(document.querySelectorAll('.kz-gallery-slider-wrap .kz-gallery-zoom-btn'));
        var currentIndex = 0;

        function showLightbox(index) {
            if (index < 0) index = links.length - 1;
            if (index >= links.length) index = 0;
            currentIndex = index;

            var link = links[currentIndex];
            modalImg.src = link.getAttribute('href');
            modalCaption.textContent = link.getAttribute('data-title') || '';
            modal.classList.add('kz-active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            modal.classList.remove('kz-active');
            document.body.style.overflow = '';
        }

        links.forEach(function (link, idx) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                showLightbox(idx);
            });
        });

        if (closeBtn) closeBtn.addEventListener('click', closeLightbox);
        if (prevBtn) prevBtn.addEventListener('click', function () { showLightbox(currentIndex - 1); });
        if (nextBtn) nextBtn.addEventListener('click', function () { showLightbox(currentIndex + 1); });

        modal.addEventListener('click', function (e) {
            if (e.target === modal) closeLightbox();
        });

        window.addEventListener('keydown', function (e) {
            if (!modal.classList.contains('kz-active')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') showLightbox(currentIndex - 1);
            if (e.key === 'ArrowRight') showLightbox(currentIndex + 1);
        });
    });

    // ── 6. REVIEWS VIDEO CAROUSEL ──
    document.addEventListener('DOMContentLoaded', function () {
        var myCarousel = document.querySelector('#reviewsCarousel');
        if (myCarousel && typeof bootstrap !== 'undefined') {
            new bootstrap.Carousel(myCarousel, {
                interval: 5000,
                wrap: true
            });
            myCarousel.addEventListener('slide.bs.carousel', function () {
                var iframes = myCarousel.querySelectorAll('iframe');
                iframes.forEach(function (iframe) {
                    var src = iframe.src;
                    iframe.src = src;
                });
            });
        }
    });

    // ── 7. DESTINATION COUNTRY & STATE SWIPERS (WITH LUXURY TRANSITION) ──
    document.addEventListener('DOMContentLoaded', function () {
        const stateSwipers = {};

        function initStateSwiper(countryId) {
            const swiperEl = document.querySelector('#stateSwiper' + countryId);
            if (!swiperEl || typeof Swiper === 'undefined') return null;

            if (stateSwipers[countryId]) {
                stateSwipers[countryId].update();
                stateSwipers[countryId].updateSize();
                stateSwipers[countryId].updateSlides();
                return stateSwipers[countryId];
            }

            stateSwipers[countryId] = new Swiper(swiperEl, {
                slidesPerView: 2.2,
                spaceBetween: 14,
                speed: 850,
                watchSlidesProgress: true,
                resistance: true,
                resistanceRatio: 0.85,
                grabCursor: true,
                simulateTouch: true,
                touchReleaseOnEdges: true,
                preventClicks: true,
                preventClicksPropagation: false,
                mousewheel: false,
                observer: true,
                observeParents: true,
                resizeObserver: true,
                navigation: {
                    nextEl: '#stateNext' + countryId,
                    prevEl: '#statePrev' + countryId,
                },
                breakpoints: {
                    0: { slidesPerView: 2, spaceBetween: 12 },
                    576: { slidesPerView: 3, spaceBetween: 16 },
                    992: { slidesPerView: 4, spaceBetween: 20 },
                    1200: { slidesPerView: 5, spaceBetween: 24 }
                },
                on: {
                    init: function () {
                        this.update();
                    }
                }
            });

            swiperEl.querySelectorAll('img').forEach(function (img) {
                if (!img.complete) {
                    img.onload = function () {
                        if (stateSwipers[countryId]) {
                            stateSwipers[countryId].update();
                        }
                    };
                }
            });

            return stateSwipers[countryId];
        }

        // Only initialize active visible pane on DOM ready
        const initialActivePane = document.querySelector('#countryTabContent .tab-pane.show.active, #countryTabContent .tab-pane.active');
        if (initialActivePane) {
            const initialId = initialActivePane.id.replace('country-pane-', '');
            if (initialId) initStateSwiper(initialId);
        }

        // Clean, soothing aesthetic tab switching with silk cascade wave
        const tabBtns = document.querySelectorAll('.dst-country-tab-btn');
        let isSwitchingTab = false;

        // Fluid Water Transfer indicator animation for country tabs
        function positionToggleGlider(activeBtn, immediate) {
            const group = document.getElementById('countryTab') || document.querySelector('.dst-toggle-group');
            if (!group) return;
            let glider = group.querySelector('.dst-toggle-glider');
            if (!glider) {
                glider = document.createElement('span');
                glider.className = 'dst-toggle-glider';
                glider.setAttribute('aria-hidden', 'true');
                group.insertBefore(glider, group.firstChild);
            }
            const btn = activeBtn || group.querySelector('.dst-country-tab-btn.active') || group.querySelector('.dst-country-tab-btn');
            if (!btn) return;

            const groupRect = group.getBoundingClientRect();
            const btnRect = btn.getBoundingClientRect();
            const targetLeft = Math.round(btnRect.left - groupRect.left);
            const targetWidth = Math.round(btnRect.width);

            if (immediate || typeof gsap === 'undefined') {
                if (typeof gsap !== 'undefined') gsap.killTweensOf(glider);
                glider.style.setProperty('transition', 'none', 'important');
                glider.style.setProperty('left', targetLeft + 'px', 'important');
                glider.style.setProperty('width', targetWidth + 'px', 'important');
                glider.style.setProperty('transform', 'none', 'important');
                glider._currLeft = targetLeft;
                glider._currWidth = targetWidth;
                return;
            }

            const currentLeft = glider._currLeft !== undefined ? glider._currLeft : (parseInt(glider.style.left) || targetLeft);
            const currentWidth = glider._currWidth !== undefined ? glider._currWidth : (parseInt(glider.style.width) || targetWidth);

            if (Math.abs(currentLeft - targetLeft) < 2) {
                glider.style.setProperty('left', targetLeft + 'px', 'important');
                glider.style.setProperty('width', targetWidth + 'px', 'important');
                glider._currLeft = targetLeft;
                glider._currWidth = targetWidth;
                return;
            }

            glider._currLeft = targetLeft;
            glider._currWidth = targetWidth;

            gsap.killTweensOf(glider);
            glider.style.removeProperty('transition');

            gsap.to(glider, {
                left: targetLeft,
                width: targetWidth,
                duration: 0.34,
                ease: "power3.out",
                overwrite: "auto",
                onComplete: function () {
                    glider.style.setProperty('left', targetLeft + 'px', 'important');
                    glider.style.setProperty('width', targetWidth + 'px', 'important');
                    glider.style.setProperty('transform', 'none', 'important');
                }
            });
        }

        positionToggleGlider(null, true);
        if (document.fonts) {
            document.fonts.ready.then(function () {
                positionToggleGlider(null, true);
            });
        }
        window.addEventListener('load', function () {
            positionToggleGlider(null, true);
        });
        window.addEventListener('resize', function () {
            positionToggleGlider(null, true);
        });
        setTimeout(function () {
            positionToggleGlider(null, true);
        }, 150);

        function switchCountryTab(targetBtn) {
            if (!targetBtn) return;
            const targetCountryId = targetBtn.getAttribute('data-country-id') ||
                (targetBtn.getAttribute('data-bs-target') ? targetBtn.getAttribute('data-bs-target').replace('#country-pane-', '') : '');
            if (!targetCountryId) return;

            const targetPane = document.querySelector('#country-pane-' + targetCountryId);
            if (!targetPane) return;

            const currentPane = document.querySelector('#countryTabContent .tab-pane.show.active, #countryTabContent .tab-pane.active');
            if (currentPane === targetPane) return;

            // Kill any pending tweens on destination cards to avoid race conditions
            if (typeof gsap !== 'undefined') {
                gsap.killTweensOf('.dst-card');
            }

            // 1. Update button states & reposition glider smoothly
            tabBtns.forEach(function (btn) {
                btn.classList.remove('active');
                btn.setAttribute('aria-selected', 'false');
            });
            targetBtn.classList.add('active');
            targetBtn.setAttribute('aria-selected', 'true');
            positionToggleGlider(targetBtn, false);

            // 2. Hide other panes and pre-hide new cards before revealing pane (prevents 1-frame flash)
            const newCards = targetPane.querySelectorAll('.dst-card');
            if (typeof gsap !== 'undefined' && newCards.length > 0) {
                gsap.set(newCards, { opacity: 0, y: 16 });
            }

            const allPanes = document.querySelectorAll('#countryTabContent .tab-pane');
            allPanes.forEach(function (pane) {
                pane.classList.remove('show', 'active');
                pane.style.display = 'none';
            });

            targetPane.classList.remove('fade');
            targetPane.style.display = 'block';
            targetPane.classList.add('show', 'active');
            targetPane.offsetHeight; // Force reflow so Swiper measures correct container width

            // 3. Update Swiper instance
            const swiper = initStateSwiper(targetCountryId);
            if (swiper) {
                swiper.update();
                swiper.updateSize();
                swiper.updateSlides();
                swiper.slideTo(0, 0);
            }

            // 4. Clean fade-up reveal on destination cards (no elastic scale jitter)
            if (typeof gsap !== 'undefined' && newCards.length > 0) {
                gsap.to(newCards, {
                    opacity: 1,
                    y: 0,
                    duration: 0.35,
                    stagger: 0.04,
                    ease: 'power2.out',
                    clearProps: 'transform,opacity'
                });
            }
        }

tabBtns.forEach(function (btn) {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        switchCountryTab(this);
    });

    // Secondary listener for Bootstrap tab events
    btn.addEventListener('shown.bs.tab', function (e) {
        const cId = this.getAttribute('data-country-id') ||
            (this.getAttribute('data-bs-target') ? this.getAttribute('data-bs-target').replace('#country-pane-', '') : '');
        if (cId && stateSwipers[cId]) {
            stateSwipers[cId].update();
            stateSwipers[cId].updateSize();
            stateSwipers[cId].updateSlides();
        }
    });
});

window.addEventListener('resize', function () {
    Object.values(stateSwipers).forEach(function (swiper) {
        if (swiper) swiper.update();
    });
});
    });

}) ();

/* ========================================================
   5. Tour Details Page (Gallery & Booking)
   ======================================================== */
/**
 * ============================================================
 * TOUR GALLERY SLIDER & BOOKING FORM JAVASCRIPT
 * Ensures flawless swiper control, smooth animation,
 * and dual booking actions (Mail & WhatsApp)
 * ============================================================
 */

(function () {
    'use strict';

    function initTourGallerySlider() {
        const sliderEl = document.querySelector('#tourGallerySlider');
        const prevBtn = document.querySelector('.tour-gallery-prev, [data-slider-prev="#tourGallerySlider"]');
        const nextBtn = document.querySelector('.tour-gallery-next, [data-slider-next="#tourGallerySlider"]');

        if (!sliderEl) return;

        // Function to bind arrow buttons to Swiper instance
        function bindArrows(swiperInstance) {
            if (!swiperInstance) return;

            if (prevBtn) {
                prevBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    swiperInstance.slidePrev();
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    swiperInstance.slideNext();
                });
            }
        }

        // 1. If Swiper is already initialized on the element by theme script
        if (sliderEl.swiper) {
            const sw = sliderEl.swiper;
            if (sw.params) {
                if (!sw.params.breakpoints) sw.params.breakpoints = {};
                sw.params.breakpoints[0] = { slidesPerView: 2, spaceBetween: 12 };
                if (window.innerWidth < 576) {
                    sw.params.slidesPerView = 2;
                    sw.params.spaceBetween = 12;
                    sw.update();
                }
            }
            bindArrows(sw);
            return;
        }

        // 2. If Swiper is available globally, initialize with 2 on mobile
        if (typeof Swiper !== 'undefined') {
            let userOptions = {};
            const rawOptions = sliderEl.getAttribute('data-slider-options');
            if (rawOptions) {
                try {
                    userOptions = JSON.parse(rawOptions);
                } catch (err) {
                    console.warn('Could not parse data-slider-options, using defaults.', err);
                }
            }

            const swiperConfig = Object.assign(
                {
                    slidesPerView: 2,
                    spaceBetween: 12,
                    loop: true,
                    grabCursor: true,
                    speed: 600,
                    autoplay: {
                        delay: 4500,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    },
                    navigation: {
                        nextEl: '.tour-gallery-next',
                        prevEl: '.tour-gallery-prev',
                    },
                    breakpoints: {
                        0: { slidesPerView: 2, spaceBetween: 12 },
                        576: { slidesPerView: 2, spaceBetween: 16 },
                        768: { slidesPerView: 3, spaceBetween: 20 },
                        992: { slidesPerView: 4, spaceBetween: 20 },
                        1200: { slidesPerView: 4, spaceBetween: 24 },
                    },
                },
                userOptions,
                { mousewheel: false }
            );

            // Ensure 0 breakpoint always sets 2 for mobile view
            if (swiperConfig.breakpoints && swiperConfig.breakpoints[0]) {
                swiperConfig.breakpoints[0].slidesPerView = 2;
            }

            const gallerySwiper = new Swiper(sliderEl, swiperConfig);
            bindArrows(gallerySwiper);
        } else {
            // 3. Fallback: Wait for theme script to mount Swiper, then apply 2 mobile override
            let attempts = 0;
            const checkInterval = setInterval(function () {
                attempts++;
                if (sliderEl.swiper) {
                    clearInterval(checkInterval);
                    const sw = sliderEl.swiper;
                    if (sw.params) {
                        if (!sw.params.breakpoints) sw.params.breakpoints = {};
                        sw.params.breakpoints[0] = { slidesPerView: 2, spaceBetween: 12 };
                        if (window.innerWidth < 576) {
                            sw.params.slidesPerView = 2;
                            sw.params.spaceBetween = 12;
                            sw.update();
                        }
                    }
                    bindArrows(sw);
                } if (attempts > 30) {
                    clearInterval(checkInterval);
                }
            }, 100);
        }
    }

    // ── Booking Form Handler (Book via Mail & Book via WhatsApp) ──
    function initTourBookingForm() {
        const form = document.getElementById('kawTourBookingForm');
        if (!form) return;

        const btnWhatsApp = document.getElementById('btnBookWhatsApp');
        const hiddenMsg = document.getElementById('bk_message_hidden');
        const numberInput = document.getElementById('bk_number');

        function buildMessage() {
            const pkg = document.getElementById('bk_package_title')?.value || 'Tour Package';
            const name = document.getElementById('bk_name')?.value || 'Guest';
            const pickupDrop = document.getElementById('bk_pickup_drop')?.value || 'Not provided';
            const phone = numberInput?.value || 'Not provided';
            const dest = document.getElementById('bk_destination')?.value || 'Kashmir';
            const date = document.getElementById('bk_arrival_date')?.value || 'Not specified';
            const persons = document.getElementById('bk_no_of_persons')?.value || '2';
            const rooms = document.getElementById('bk_room_details')?.value || '1 Double Room';
            const hotel = document.getElementById('bk_hotel_category')?.value || 'Standard';

            return [
                "Package Booking Request:",
                "-----------------------",
                "Package: " + pkg,
                "Guest Name: " + name,
                "Pick & Drop: " + pickupDrop,
                "Phone: " + phone,
                "Destination: " + dest,
                "Arrival Date: " + date,
                "No. of Persons: " + persons,
                "Room Preference: " + rooms,
                "Hotel Category: " + hotel
            ].join("\n");
        }

        // On Mail Submit: validate & populate hidden message, sanitize phone
        form.addEventListener('submit', function (e) {
            if (numberInput && numberInput.value) {
                // Keep only numeric characters for validator digits_between
                const digits = numberInput.value.replace(/\D/g, '');
                if (digits.length >= 10 && digits.length <= 15) {
                    numberInput.value = digits;
                }
            }
            if (hiddenMsg) {
                hiddenMsg.value = buildMessage();
            }
        });

        // On WhatsApp Click: validate, record lead in background, and open WhatsApp
        if (btnWhatsApp) {
            btnWhatsApp.addEventListener('click', function (e) {
                e.preventDefault();

                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                if (numberInput && numberInput.value) {
                    const digits = numberInput.value.replace(/\D/g, '');
                    if (digits.length >= 10 && digits.length <= 15) {
                        numberInput.value = digits;
                    }
                }

                if (hiddenMsg) {
                    hiddenMsg.value = buildMessage();
                }

                const pkg = document.getElementById('bk_package_title')?.value || 'Tour Package';
                const name = document.getElementById('bk_name')?.value || '';
                const pickupDrop = document.getElementById('bk_pickup_drop')?.value || '';
                const phone = numberInput?.value || '';
                const dest = document.getElementById('bk_destination')?.value || '';
                const date = document.getElementById('bk_arrival_date')?.value || '';
                const persons = document.getElementById('bk_no_of_persons')?.value || '2';
                const rooms = document.getElementById('bk_room_details')?.value || '1 Double Room';
                const hotel = document.getElementById('bk_hotel_category')?.value || 'Standard';
                const waPhone = btnWhatsApp.getAttribute('data-whatsapp') || '917006338617';

                const waText =
                    "🌟 *NEW TOUR PACKAGE BOOKING* 🌟\n" +
                    "--------------------------------\n" +
                    "🏷️ *Package:* " + pkg + "\n" +
                    "👤 *Guest Name:* " + name + "\n" +
                    "🚗 *Pick & Drop:* " + pickupDrop + "\n" +
                    "📱 *Phone:* " + phone + "\n" +
                    "📍 *Destination:* " + dest + "\n" +
                    "📅 *Arrival Date:* " + date + "\n" +
                    "👥 *No. of Persons:* " + persons + "\n" +
                    "🛏️ *Room Preference:* " + rooms + "\n" +
                    "🏨 *Hotel Category:* " + hotel + "\n" +
                    "--------------------------------\n" +
                    "Please confirm availability & share best quotation.";

                const waUrl = "https://wa.me/" + waPhone + "?text=" + encodeURIComponent(waText);

                // Save lead in database asynchronously
                try {
                    const formData = new FormData(form);
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    }).catch(function (err) {
                        console.warn('Lead background save:', err);
                    });
                } catch (err) {
                    console.warn(err);
                }

                // Open WhatsApp
                window.open(waUrl, '_blank');

                // Display inline success alert
                const jsAlert = document.getElementById('kawJsAlert');
                if (jsAlert) {
                    jsAlert.innerHTML = `
                        <div class="alert alert-success d-flex align-items-center gap-2 mb-3 py-2 px-3" role="alert" style="border-radius: 8px; font-size: 13px;">
                            <i class="fa-solid fa-circle-check fs-5"></i>
                            <div><strong>Booking request submitted!</strong> WhatsApp has been opened to finalize your details.</div>
                        </div>
                    `;
                    jsAlert.style.display = 'block';
                    jsAlert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            });
        }
    }

    // Initialize on DOMContentLoaded and also window load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            initTourGallerySlider();
            initTourBookingForm();
        });
    } else {
        initTourGallerySlider();
        initTourBookingForm();
    }
    window.addEventListener('load', function () {
        initTourGallerySlider();
    });
})();

/* ========================================================
   6. Cab Details Page (Thumbnail Switcher)
   ======================================================== */
function kzSelectCabThumb(imgUrl, thumbEl) {
    var mainImg = document.getElementById('kz-cab-main-img');
    if (!mainImg) return;

    // Smooth fade effect
    mainImg.style.opacity = '0.3';
    setTimeout(function () {
        mainImg.src = imgUrl;
        mainImg.style.opacity = '1';
    }, 180);

    // Update active border
    var allThumbs = document.querySelectorAll('.kz-cab-thumb-item');
    allThumbs.forEach(function (el) {
        el.classList.remove('active-thumb');
    });
    if (thumbEl) {
        thumbEl.classList.add('active-thumb');
    }
}

/* ========================================================
   7. Hotel Details Page (Room & Gallery Lightbox)
   ======================================================== */
function kzOpenHotelLightbox(imgUrl) {
    const modal = document.getElementById('kzHotelLightbox');
    const img = document.getElementById('kzLightboxImg');
    if (modal && img) {
        img.src = imgUrl;
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function kzCloseHotelLightbox() {
    const modal = document.getElementById('kzHotelLightbox');
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        kzCloseHotelLightbox();
    }
});

/* ========================================================
   8. Enterprise Notification Bar (Top-to-Bottom Animated Ticker)
   ======================================================== */
(function () {
    function initEnterpriseNoticeTicker() {
        const bar = document.getElementById('kzEntNoticeBar');
        if (!bar) return;

        const items = bar.querySelectorAll('.kz-ent-item');
        if (!items || items.length === 0) return;

        const currentEl = document.getElementById('kzEntCurrent');
        const totalEl = document.getElementById('kzEntTotal');
        const prevBtn = document.getElementById('kzEntPrev');
        const nextBtn = document.getElementById('kzEntNext');

        let currentIndex = 0;
        let isTransitioning = false;
        let autoPlayTimer = null;
        const totalItems = items.length;

        if (totalEl) {
            totalEl.textContent = String(totalItems).padStart(2, '0');
        }

        function updateCounter(idx) {
            if (currentEl) {
                currentEl.textContent = String(idx + 1).padStart(2, '0');
            }
        }

        /**
         * Transitions slides.
         * direction 'down': Top-to-bottom movement (new slide enters from top, current slides to bottom)
         * direction 'up': Bottom-to-top movement (new slide enters from bottom, current slides to top)
         */
        function goToSlide(nextIndex, direction) {
            if (isTransitioning || nextIndex === currentIndex) return;
            isTransitioning = true;
            direction = direction || 'down';

            const currentSlide = items[currentIndex];
            const nextSlide = items[nextIndex];

            if (direction === 'down') {
                // Top-to-Bottom:
                // Pre-position nextSlide at top (-100%)
                nextSlide.classList.remove('exit-to-bottom', 'exit-to-top', 'enter-from-bottom', 'active');
                nextSlide.classList.add('enter-from-top');
                void nextSlide.offsetHeight; // Force reflow

                currentSlide.classList.remove('active', 'enter-from-top', 'enter-from-bottom');
                currentSlide.classList.add('exit-to-bottom');

                nextSlide.classList.remove('enter-from-top');
                nextSlide.classList.add('active');
            } else {
                // Bottom-to-Top:
                nextSlide.classList.remove('exit-to-bottom', 'exit-to-top', 'enter-from-top', 'active');
                nextSlide.classList.add('enter-from-bottom');
                void nextSlide.offsetHeight; // Force reflow

                currentSlide.classList.remove('active', 'enter-from-top', 'enter-from-bottom');
                currentSlide.classList.add('exit-to-top');

                nextSlide.classList.remove('enter-from-bottom');
                nextSlide.classList.add('active');
            }

            currentIndex = nextIndex;
            updateCounter(currentIndex);

            setTimeout(function () {
                items.forEach(function (item, idx) {
                    if (idx !== currentIndex) {
                        item.classList.remove('active', 'exit-to-bottom', 'exit-to-top', 'enter-from-top', 'enter-from-bottom');
                    }
                });
                isTransitioning = false;
            }, 500);
        }

        function nextSlide() {
            const nextIdx = (currentIndex + 1) % totalItems;
            goToSlide(nextIdx, 'down'); // Smooth top-to-bottom transition
        }

        function prevSlide() {
            const prevIdx = (currentIndex - 1 + totalItems) % totalItems;
            goToSlide(prevIdx, 'up'); // Reverse upward transition
        }

        function startAutoplay() {
            stopAutoplay();
            autoPlayTimer = setInterval(nextSlide, 4200);
        }

        function stopAutoplay() {
            if (autoPlayTimer) {
                clearInterval(autoPlayTimer);
                autoPlayTimer = null;
            }
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function (e) {
                e.preventDefault();
                nextSlide();
                startAutoplay();
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function (e) {
                e.preventDefault();
                prevSlide();
                startAutoplay();
            });
        }

        // Pause ticker on mouse hover or touch interaction
        bar.addEventListener('mouseenter', stopAutoplay);
        bar.addEventListener('mouseleave', startAutoplay);
        bar.addEventListener('touchstart', stopAutoplay, { passive: true });
        bar.addEventListener('touchend', startAutoplay, { passive: true });

        // Keyboard accessibility
        bar.setAttribute('tabindex', '0');
        bar.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                nextSlide();
                startAutoplay();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                prevSlide();
                startAutoplay();
            }
        });

        // Initialize display
        updateCounter(0);
        startAutoplay();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initEnterpriseNoticeTicker);
    } else {
        initEnterpriseNoticeTicker();
    }
})();

/* ========================================================
   Fixed Header Spacer Sync & Scroll Elevation State
   ======================================================== */
(function () {
    function initFixedHeaderSync() {
        var hdr = document.querySelector('header.kaw-hdr.kaw-mmt-hdr');
        var stickyBar = hdr ? hdr.querySelector('.kaw-hdr-sticky') : null;
        if (!hdr || !stickyBar) return;

        function syncHeaderHeight() {
            var h = Math.ceil(stickyBar.getBoundingClientRect().height);
            if (h > 0) {
                document.documentElement.style.setProperty('--kaw-hdr-h', h + 'px');
            }
        }

        function onScroll() {
            var y = window.scrollY || window.pageYOffset || document.documentElement.scrollTop || 0;
            if (y > 12) {
                hdr.classList.add('nav-scrolled');
            } else {
                hdr.classList.remove('nav-scrolled');
            }
        }

        syncHeaderHeight();
        onScroll();

        window.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('resize', syncHeaderHeight, { passive: true });
        window.addEventListener('load', syncHeaderHeight);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFixedHeaderSync);
    } else {
        initFixedHeaderSync();
    }
})();


