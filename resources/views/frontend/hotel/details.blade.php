@extends('frontend.layouts.app')

@section('page_title', $hotel->meta_title ?? ($hotel->name . ' - Luxury Hotels & Resorts'))
@section('page_meta')
{!! generateMetaTags($hotel) !!}
@endsection

@section('content')

@php
    // Gallery Sanitization
    $hotelGallery = [];
    if (!empty($hotel->gallery)) {
        if (is_array($hotel->gallery)) {
            $hotelGallery = $hotel->gallery;
        } else {
            $decoded = json_decode($hotel->gallery, true);
            $hotelGallery = is_array($decoded) ? $decoded : [];
        }
    }

    // Highlights Sanitization
    $hotelHighlights = [];
    if (!empty($hotel->highlights)) {
        if (is_array($hotel->highlights)) {
            $hotelHighlights = $hotel->highlights;
        } else {
            $decodedHigh = json_decode($hotel->highlights, true);
            if (is_array($decodedHigh)) {
                $hotelHighlights = $decodedHigh;
            } else {
                $hotelHighlights = array_filter(array_map('trim', explode("\n", (string)$hotel->highlights)));
            }
        }
    }

    $hotelsIndexRoute = Route::has('home.hotels') ? route('home.hotels') : (Route::has('hotel.index') ? route('hotel.index') : url('/hotels'));
    $contactRoute     = Route::has('home.contact') ? route('home.contact') : url('/contact');
    $phoneNumber      = $setting->phone ?? '+91 7006338617';
    $phoneClean       = preg_replace('/[^0-9+]/', '', $phoneNumber);
    if (empty($phoneClean)) { $phoneClean = '+917006338617'; }
    $hotelStarRating  = (int)($hotel->star_rating ?? 5);
    if ($hotelStarRating < 1) { $hotelStarRating = 5; }

    $whatsappMsg = urlencode("Hello Love Link Tour & Travels, I would like to inquire about booking '{$hotel->name}' in {$hotel->location}. Please share the current availability and pricing.");
@endphp

<!--================================================================
    KZ LUXURY HOTEL DETAIL SYSTEM (SCOPED CSS)
    Colors: Royal Navy (#0B3D91), Dark Navy (#072355), Gold (#ddab43)
=================================================================-->
<div class="kz-htld-wrapper">
    <!--==============================
        1. CINEMATIC HERO & BREADCRUMBS
    ==============================-->
    <section class="kz-htld-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <!-- Breadcrumbs -->
                    <div class="kz-htld-breadcrumb">
                        <a href="{{ url('/') }}"><i class="fa-solid fa-house"></i> Home</a>
                        <i class="fa-solid fa-chevron-right"></i>
                        <a href="{{ $hotelsIndexRoute }}">Hotels</a>
                        <i class="fa-solid fa-chevron-right"></i>
                        <span class="active-crumb">{{ $hotel->name }}</span>
                    </div>

                    <!-- Eyebrow -->
                    <div>
                        <span class="kz-htld-hero-tag">
                            <i class="fa-solid fa-crown"></i> Luxury Stay & Experience
                        </span>
                    </div>

                    <!-- Hotel Title -->
                    <h1 class="kz-htld-hero-title">{{ $hotel->name }}</h1>

                    <!-- Meta Badges -->
                    <div class="kz-htld-hero-meta">
                        <div class="kz-htld-meta-pill">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>{{ $hotel->location }}</span>
                        </div>
                        @if($hotelStarRating > 0)
                        <div class="kz-htld-meta-pill">
                            <div class="kz-htld-hero-stars">
                                @for($i = 0; $i < $hotelStarRating; $i++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                            </div>
                            <span class="ms-1 fw-bold">{{ $hotelStarRating }}.0 Star Hotel</span>
                        </div>
                        @endif
                        <div class="kz-htld-meta-pill">
                            <i class="fa-solid fa-shield-check"></i>
                            <span>100% Verified Quality</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <a href="https://wa.me/{{ $phoneClean }}?text={{ $whatsappMsg }}" target="_blank" class="kz-htld-btn-whatsapp d-inline-flex px-4">
                        <i class="fa-brands fa-whatsapp fs-5"></i> Check Availability
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!--==============================
        2. MAIN BODY CONTENT & SIDEBAR
    ==============================-->
    <div class="container kz-htld-body">
        <div class="row">
            <!-- Left Main Column -->
            <div class="col-lg-8">
                <!-- Main Showcase Card -->
                <div class="kz-htld-card">
                    <!-- Image Showcase Box -->
                    <div class="kz-htld-showcase-box">
                        @php
                            $mainBanner = !empty($hotel->banner_image) ? $hotel->banner_image : $hotel->image;
                        @endphp
                        <img src="{{ asset('storage/' . $mainBanner) }}" 
                             alt="{{ $hotel->name }}" 
                             class="kz-htld-showcase-img">
                        <div class="kz-htld-showcase-gradient"></div>

                        <!-- Top Floating Badges -->
                        <div class="kz-htld-showcase-badge-top">
                            <a href="{{ $hotelsIndexRoute }}?search={{ urlencode($hotel->location) }}" class="kz-htld-badge-loc">
                                <i class="fa-solid fa-location-dot"></i> {{ $hotel->location }}
                            </a>
                            <span class="kz-htld-badge-verified">
                                <i class="fa-solid fa-badge-check"></i> Verified Partner
                            </span>
                        </div>

                        <!-- Bottom Floating Bar -->
                        <div class="kz-htld-showcase-bottom-bar">
                            <div class="kz-htld-showcase-stars-badge">
                                <span>Rating:</span>
                                @for($i = 0; $i < $hotelStarRating; $i++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                                <span class="ms-1 text-white">({{ $hotelStarRating }}/5)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Specs Strip -->
                    <div class="kz-htld-quick-grid">
                        <div class="kz-htld-quick-item">
                            <div class="kz-htld-quick-icon">
                                <i class="fa-solid fa-hotel"></i>
                            </div>
                            <div class="kz-htld-quick-info">
                                <div class="kz-htld-quick-label">Property Type</div>
                                <div class="kz-htld-quick-val">{{ $hotelStarRating }} Star Resort</div>
                            </div>
                        </div>
                        <div class="kz-htld-quick-item">
                            <div class="kz-htld-quick-icon">
                                <i class="fa-solid fa-map-pin"></i>
                            </div>
                            <div class="kz-htld-quick-info">
                                <div class="kz-htld-quick-label">Destination</div>
                                <div class="kz-htld-quick-val">{{ $hotel->location }}</div>
                            </div>
                        </div>
                        <div class="kz-htld-quick-item">
                            <div class="kz-htld-quick-icon">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <div class="kz-htld-quick-info">
                                <div class="kz-htld-quick-label">Booking</div>
                                <div class="kz-htld-quick-val">Instant Confirmation</div>
                            </div>
                        </div>
                        <div class="kz-htld-quick-item">
                            <div class="kz-htld-quick-icon">
                                <i class="fa-solid fa-headset"></i>
                            </div>
                            <div class="kz-htld-quick-info">
                                <div class="kz-htld-quick-label">Concierge</div>
                                <div class="kz-htld-quick-val">24/7 Dedicated</div>
                            </div>
                        </div>
                    </div>

                    <!-- About / Descriptions Section -->
                    <div class="kz-htld-section-body">
                        <div class="kz-htld-heading-wrap">
                            <h2 class="kz-htld-sec-title">About {{ $hotel->name }}</h2>
                            <span class="kz-htld-badge-count"><i class="fa-solid fa-circle-info"></i> Details</span>
                        </div>

                        <!-- Short Description Highlight -->
                        @if(!empty($hotel->short_description))
                            <div class="kz-htld-short-desc-box">
                                {!! $hotel->short_description !!}
                            </div>
                        @endif

                        <!-- Full Rich Description -->
                        @if(!empty($hotel->description))
                            <div class="kz-htld-rich-text">
                                {!! $hotel->description !!}
                            </div>
                        @endif

                        <!-- Panoramic Footer Banner (if present) -->
                        @if(!empty($hotel->banner_footer_image))
                            <div class="kz-htld-panoramic-box">
                                <img src="{{ asset('storage/' . $hotel->banner_footer_image) }}" 
                                     alt="{{ $hotel->name }} Panorama" 
                                     class="kz-htld-panoramic-img">
                                <div class="kz-htld-panoramic-tag">
                                    <i class="fa-solid fa-image"></i> Panoramic View of Property
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Highlights Section -->
                @if(!empty($hotelHighlights))
                <div class="kz-htld-card">
                    <div class="kz-htld-section-body">
                        <div class="kz-htld-heading-wrap">
                            <h3 class="kz-htld-sec-title">Property Highlights & Perks</h3>
                            <span class="kz-htld-badge-count">{{ count($hotelHighlights) }} Features</span>
                        </div>

                        <div class="kz-htld-highlights-grid">
                            @foreach($hotelHighlights as $highlight)
                                <div class="kz-htld-highlight-pill">
                                    <div class="kz-htld-highlight-icon">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                    <span class="kz-htld-highlight-text">{{ $highlight }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Photo Gallery Section -->
                @if(!empty($hotelGallery))
                <div class="kz-htld-card">
                    <div class="kz-htld-section-body">
                        <div class="kz-htld-heading-wrap">
                            <h3 class="kz-htld-sec-title">From Our Gallery</h3>
                            <span class="kz-htld-badge-count">{{ count($hotelGallery) }} Photos</span>
                        </div>

                        <div class="kz-htld-gallery-grid">
                            @foreach($hotelGallery as $img)
                                @php $imgUrl = asset('storage/' . $img); @endphp
                                <div class="kz-htld-gallery-item" onclick="kzOpenHotelLightbox('{{ $imgUrl }}')">
                                    <img src="{{ $imgUrl }}" alt="Gallery Image of {{ $hotel->name }}">
                                    <div class="kz-htld-gallery-overlay">
                                        <div class="kz-htld-gallery-btn">
                                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Sidebar Column -->
            <div class="col-lg-4">
                <aside class="kz-htld-sidebar">
                    <!-- Search Widget -->
                    <div class="kz-htld-side-box">
                        <div class="kz-htld-search-box">
                            <form method="GET" action="{{ $hotelsIndexRoute }}">
                                <div class="kz-htld-search-input-wrap">
                                    <input type="text" name="search" placeholder="Search hotels, cities...">
                                    <button type="submit" aria-label="Search">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Fast Booking / Inquire Card -->
                    <div class="kz-htld-booking-card">
                        <div class="kz-htld-booking-eyebrow">Instant Reservation</div>
                        <h4 class="kz-htld-booking-title">Inquire About This Hotel</h4>

                        <div class="kz-htld-booking-guarantee">
                            <i class="fa-solid fa-badge-percent"></i>
                            <span>Best Local Price Guarantee & Direct Agent Confirmation</span>
                        </div>

                        <!-- Direct WhatsApp -->
                        <a href="https://wa.me/{{ $phoneClean }}?text={{ $whatsappMsg }}" target="_blank" class="kz-htld-btn-whatsapp">
                            <i class="fa-brands fa-whatsapp fs-5"></i> Book via WhatsApp
                        </a>

                        <!-- Direct Phone Call -->
                        <a href="tel:{{ $phoneClean }}" class="kz-htld-btn-call">
                            <i class="fa-solid fa-phone"></i> Call {{ $phoneNumber }}
                        </a>

                        <!-- Contact Us Form Link -->
                        <a href="{{ $contactRoute }}" class="kz-htld-btn-inquire">
                            <i class="fa-solid fa-envelope"></i> Send Custom Inquiry
                        </a>

                        <!-- Trust Bullet Points -->
                        <ul class="kz-htld-trust-checklist">
                            <li><i class="fa-solid fa-circle-check"></i> Free consultation & customized itinerary</li>
                            <li><i class="fa-solid fa-circle-check"></i> Verified sanitized & certified rooms</li>
                            <li><i class="fa-solid fa-circle-check"></i> Zero hidden booking charges</li>
                        </ul>
                    </div>

                    <!-- Categories Widget (if available) -->
                    @if(isset($hotelcategories) && count($hotelcategories) > 0)
                    <div class="kz-htld-side-box">
                        <h4 class="kz-htld-list-widget-title">
                            <i class="fa-solid fa-layer-group"></i> Hotel Categories
                        </h4>
                        <ul class="kz-htld-link-list">
                            @foreach($hotelcategories as $cat)
                            <li class="kz-htld-link-item">
                                <a href="{{ $hotelsIndexRoute }}?search={{ urlencode($cat->category) }}">
                                    <i class="fa-solid fa-angle-right text-muted small"></i>
                                    {{ $cat->category }}
                                </a>
                                <span class="kz-htld-link-badge">{{ $cat->count }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Locations Widget (if available) -->
                    @if(isset($hotellocations) && count($hotellocations) > 0)
                    <div class="kz-htld-side-box">
                        <h4 class="kz-htld-list-widget-title">
                            <i class="fa-solid fa-map-location-dot"></i> Popular Destinations
                        </h4>
                        <ul class="kz-htld-link-list">
                            @foreach($hotellocations as $loc)
                            <li class="kz-htld-link-item">
                                <a href="{{ $hotelsIndexRoute }}?search={{ urlencode($loc->location) }}">
                                    <i class="fa-solid fa-location-dot text-muted small"></i>
                                    {{ $loc->location }}
                                </a>
                                <span class="kz-htld-link-badge">{{ $loc->count }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- 24/7 Support Banner -->
                    <div class="kz-htld-support-card">
                        <div class="kz-htld-support-icon-wrap">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <h4 class="kz-htld-support-title">Need Help Booking?</h4>
                        <p class="kz-htld-support-text">
                            Our destination experts are here 24/7 to help you book the finest hotels and luxury stays.
                        </p>
                        <a href="tel:{{ $phoneClean }}" class="kz-htld-support-phone">
                            {{ $phoneNumber }}
                        </a>
                        <div>
                            <a href="{{ $contactRoute }}" class="kz-htld-support-btn">
                                <i class="fa-solid fa-comments"></i> Contact Support
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>

<!-- Lightbox Modal for Gallery Images -->
<div id="kzHotelLightbox" class="kz-htld-lightbox-modal" onclick="kzCloseHotelLightbox(event)">
    <div class="kz-htld-lightbox-content" onclick="event.stopPropagation()">
        <button type="button" class="kz-htld-lightbox-close" onclick="kzCloseHotelLightbox()" aria-label="Close modal">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <img id="kzLightboxImg" src="" alt="Hotel Photo Preview" class="kz-htld-lightbox-img">
    </div>
</div>
@endsection
