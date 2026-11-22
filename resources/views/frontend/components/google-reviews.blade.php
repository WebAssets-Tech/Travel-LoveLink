{{-- ========== GOOGLE REVIEWS SECTION ========== --}}
<section class="google-reviews" id="google-reviews">
    <div class="gr-container">

        {{-- Section Header --}}
        <div class="gr-header">
            <div class="gr-header__badge">
                <svg class="gr-google-icon" viewBox="0 0 24 24" width="28" height="28">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                <span>Google Reviews</span>
            </div>
            <h2 class="gr-header__title">What Our Customers Say</h2>
            <p class="gr-header__subtitle">Real reviews from real customers on Google</p>
        </div>

        {{-- Overall Rating Summary --}}
        <div class="gr-summary">
            <div class="gr-summary__rating">
                <span class="gr-summary__number">{{ number_format($reviewData['overall_rating'], 1) }}</span>
                <div class="gr-summary__stars">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= floor($reviewData['overall_rating']))
                            <svg class="gr-star gr-star--filled" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        @elseif ($i - $reviewData['overall_rating'] < 1)
                            <svg class="gr-star gr-star--half" viewBox="0 0 24 24">
                                <defs><linearGradient id="halfStar"><stop offset="50%" stop-color="#FBBC05"/><stop offset="50%" stop-color="#ddd"/></linearGradient></defs>
                                <path fill="url(#halfStar)" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        @else
                            <svg class="gr-star gr-star--empty" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        @endif
                    @endfor
                </div>
                <span class="gr-summary__count">Based on {{ $reviewData['total_reviews'] }} reviews</span>
            </div>
            <a href="{{ $reviewData['google_url'] }}" target="_blank" rel="noopener" class="gr-summary__cta">
                <svg viewBox="0 0 24 24" width="18" height="18">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Write a Review
            </a>
        </div>

        {{-- Review Cards Slider --}}
        <div class="gr-slider-wrapper">
            <button class="gr-slider__arrow gr-slider__arrow--prev" aria-label="Previous review">
                <svg viewBox="0 0 24 24" width="20" height="20"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z" fill="currentColor"/></svg>
            </button>

            <div class="gr-slider">
                <div class="gr-slider__track">
                    @if(count($reviewData['reviews']) > 0)
                        @foreach ($reviewData['reviews'] as $index => $review)
                        {{--
                            KEY CHANGE: Added data-full-text="{{ $review['text'] }}" to the card div.
                            This lets the JS safely expand truncated text without inline onclick + addslashes.
                        --}}
                        <div class="gr-card" data-index="{{ $index }}" data-full-text="{{ $review['text'] }}">
                            <div class="gr-card__header">
                                <div class="gr-card__avatar">
                                    <img src="{{ $review['profile_photo_url'] ?? '' }}"
                                         alt="{{ $review['author_name'] }}"
                                         width="44"
                                         height="44"
                                         loading="lazy"
                                         decoding="async"
                                         onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 40 40%22><rect fill=%22%234285F4%22 width=%2240%22 height=%2240%22 rx=%2220%22/><text x=%2220%22 y=%2226%22 text-anchor=%22middle%22 fill=%22white%22 font-size=%2218%22>{{ substr($review["author_name"], 0, 1) }}</text></svg>'">
                                </div>
                                <div class="gr-card__author">
                                    <h4 class="gr-card__name">{{ $review['author_name'] }}</h4>
                                    <span class="gr-card__time">{{ $review['relative_time_description'] }}</span>
                                </div>
                                <svg class="gr-card__google-g" viewBox="0 0 24 24" width="22" height="22">
                                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
                                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                                </svg>
                            </div>

                            <div class="gr-card__stars">
                                @for ($s = 1; $s <= 5; $s++)
                                    <svg class="gr-star {{ $s <= $review['rating'] ? 'gr-star--filled' : 'gr-star--empty' }}" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                @endfor
                            </div>

                            <p class="gr-card__text">{{ Str::limit($review['text'], 220) }}</p>

                            {{--
                                KEY CHANGE: Removed inline onclick with addslashes().
                                The JS handles expansion via event delegation + data-full-text attribute above.
                            --}}
                            @if(strlen($review['text']) > 220)
                                <button class="gr-card__read-more">Read more</button>
                            @endif
                        </div>
                        @endforeach
                    @else
                        <div class="gr-empty">
                            <p>Reviews are loading... Check back soon!</p>
                        </div>
                    @endif
                </div>
            </div>

            <button class="gr-slider__arrow gr-slider__arrow--next" aria-label="Next review">
                <svg viewBox="0 0 24 24" width="20" height="20"><path d="M8.59 16.59L10 18l6-6-6-6-1.41 1.41L13.17 12z" fill="currentColor"/></svg>
            </button>
        </div>

        {{-- Dots Navigation --}}
        <div class="gr-slider__dots"></div>

        {{-- View All on Google --}}
        <div class="gr-footer">
            <a href="{{ $reviewData['google_url'] }}" target="_blank" rel="noopener" class="gr-footer__link">
                View all {{ $reviewData['total_reviews'] }} reviews on Google
                <svg viewBox="0 0 24 24" width="16" height="16"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" fill="currentColor"/></svg>
            </a>
        </div>

    </div>
</section>