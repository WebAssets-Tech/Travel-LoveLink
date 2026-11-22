/**
 * Google Reviews Slider — Vanilla JS
 * Touch-friendly, auto-play, responsive card slider
 *
 * FIXES vs original:
 * 1. Offset math corrected — no longer double-multiplies cardsPerView,
 *    so all 43 reviews are reachable and slide count is always accurate.
 * 2. calcTotalSlides() is a function so it recomputes correctly after resize.
 * 3. Mouse drag listeners moved to `document` so releasing outside the
 *    track doesn't leave the slider stuck mid-drag.
 * 4. "Read more" uses event delegation + data-full-text instead of
 *    inline onclick + addslashes (safe against quotes / backslashes in reviews).
 * 5. Auto-play pauses when section leaves the viewport, resumes on re-entry.
 */
document.addEventListener('DOMContentLoaded', () => {

    const slider  = document.querySelector('.gr-slider');
    const track   = document.querySelector('.gr-slider__track');
    const cards   = document.querySelectorAll('.gr-card');
    const prevBtn = document.querySelector('.gr-slider__arrow--prev');
    const nextBtn = document.querySelector('.gr-slider__arrow--next');
    const dotsEl  = document.querySelector('.gr-slider__dots');

    if (!track || cards.length === 0) return;

    // ── "Read more" — safe event delegation ──────────────────────────────
    // Reads the full review text from data-full-text on the parent .gr-card
    // (set in the Blade template). No inline onclick, no addslashes needed.
    track.addEventListener('click', (e) => {
        const btn = e.target.closest('.gr-card__read-more');
        if (!btn) return;
        const card = btn.closest('.gr-card');
        const fullText = card?.dataset.fullText;
        if (fullText) {
            const textEl = card.querySelector('.gr-card__text');
            if (textEl) textEl.textContent = fullText;
        }
        btn.style.display = 'none';
    });

    // ── State ─────────────────────────────────────────────────────────────
    let currentIndex  = 0;     // current slide index (0-based), each slide = cardsPerView cards
    let cardsPerView  = getCardsPerView();
    let totalSlides   = calcTotalSlides();
    let autoPlayTimer = null;
    let isDragging    = false;
    let dragStartX    = 0;

    // ── Helpers ───────────────────────────────────────────────────────────
    function getCardsPerView() {
        if (window.innerWidth <= 768)  return 1;
        if (window.innerWidth <= 1024) return 2;
        return 3;
    }

    function calcTotalSlides() {
        // e.g. 43 reviews / 3 per view = 15 slides (last slide has 1 card)
        return Math.ceil(cards.length / cardsPerView);
    }

    // ── Offset calculation ────────────────────────────────────────────────
    // THE core fix. The track is a single flex row; each card occupies
    // (cardWidth + gap) px. Slide N starts at card (N * cardsPerView), so:
    //
    //   offset = N * cardsPerView * (cardWidth + gap)
    //
    // The original code used currentIndex as the slide index but also
    // multiplied by cardsPerView inside goToSlide, doubling the jump and
    // skipping blocks of reviews (showing 4-5 on screen depending on widths).
    function getOffset(slideIndex) {
        if (cards.length === 0) return 0;
        const cardWidth = cards[0].offsetWidth;
        // Respect CSS gap value if set; fall back to 24px
        const gap = parseFloat(getComputedStyle(track).gap) || 24;
        return slideIndex * cardsPerView * (cardWidth + gap);
    }

    // ── Dots ──────────────────────────────────────────────────────────────
    function buildDots() {
        dotsEl.innerHTML = '';
        for (let i = 0; i < totalSlides; i++) {
            const dot = document.createElement('button');
            dot.classList.add('gr-slider__dot');
            dot.classList.toggle('gr-slider__dot--active', i === currentIndex);
            dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
            dot.addEventListener('click', () => goToSlide(i));
            dotsEl.appendChild(dot);
        }
    }

    function updateDots() {
        dotsEl.querySelectorAll('.gr-slider__dot').forEach((d, i) => {
            d.classList.toggle('gr-slider__dot--active', i === currentIndex);
        });
    }

    // ── Navigation ────────────────────────────────────────────────────────
    function goToSlide(index) {
        // Wrap around at both ends
        if (index < 0)            index = totalSlides - 1;
        if (index >= totalSlides) index = 0;

        currentIndex = index;
        track.style.transform = `translateX(-${getOffset(currentIndex)}px)`;
        updateDots();
        resetAutoPlay();
    }

    // ── Arrows ────────────────────────────────────────────────────────────
    prevBtn?.addEventListener('click', () => goToSlide(currentIndex - 1));
    nextBtn?.addEventListener('click', () => goToSlide(currentIndex + 1));

    // ── Keyboard ─────────────────────────────────────────────────────────
    document.addEventListener('keydown', (e) => {
        const section = document.querySelector('.google-reviews');
        if (!section) return;
        const { top, bottom } = section.getBoundingClientRect();
        // Only respond when the section is in the viewport
        if (top >= window.innerHeight || bottom <= 0) return;
        if (e.key === 'ArrowLeft')  goToSlide(currentIndex - 1);
        if (e.key === 'ArrowRight') goToSlide(currentIndex + 1);
    });

    // ── Mouse drag ────────────────────────────────────────────────────────
    // Listeners on `document` so releasing outside the track still fires mouseup.
    track.addEventListener('mousedown', (e) => {
        isDragging = true;
        dragStartX = e.pageX;
        track.style.transition = 'none';
    });

    document.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        const diff = e.pageX - dragStartX;
        if (Math.abs(diff) > 60) {
            isDragging = false;
            track.style.transition = '';
            goToSlide(diff < 0 ? currentIndex + 1 : currentIndex - 1);
        }
    });

    document.addEventListener('mouseup', () => {
        if (!isDragging) return;
        isDragging = false;
        track.style.transition = '';
    });

    // ── Touch ─────────────────────────────────────────────────────────────
    let touchStartX = 0;

    track.addEventListener('touchstart', (e) => {
        touchStartX = e.touches[0].clientX;
        clearInterval(autoPlayTimer);
    }, { passive: true });

    track.addEventListener('touchend', (e) => {
        const diff = touchStartX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) {
            goToSlide(diff > 0 ? currentIndex + 1 : currentIndex - 1);
        }
        resetAutoPlay();
    }, { passive: true });

    // ── Auto-play ─────────────────────────────────────────────────────────
    function startAutoPlay() {
        if (autoPlayTimer) clearInterval(autoPlayTimer);
        autoPlayTimer = setInterval(() => goToSlide(currentIndex + 1), 5000);
    }

    function resetAutoPlay() {
        clearInterval(autoPlayTimer);
        startAutoPlay();
    }

    // Pause on hover
    slider?.addEventListener('mouseenter', () => clearInterval(autoPlayTimer));
    slider?.addEventListener('mouseleave', startAutoPlay);

    // ── Resize ────────────────────────────────────────────────────────────
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            cardsPerView = getCardsPerView();
            totalSlides  = calcTotalSlides();
            buildDots();
            goToSlide(0);  // reset to start to avoid stranding on a partial slide
        }, 200);
    });

    // ── Intersection Observer ─────────────────────────────────────────────
    // Start auto-play only when the section is visible; pause when scrolled away.
    const section = document.querySelector('.google-reviews');
    if (section) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) startAutoPlay();
                else clearInterval(autoPlayTimer);
            });
        }, { threshold: 0.2 });
        observer.observe(section);
    }

    // ── Init ──────────────────────────────────────────────────────────────
    buildDots();
    track.style.transform = 'translateX(0)';
    // Auto-play starts via IntersectionObserver when section scrolls into view.

});