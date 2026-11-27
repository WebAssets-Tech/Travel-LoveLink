@extends('frontend.layouts.app')

@section('page_title', $houseboat->meta_title ?? ($houseboat->name . ' - Luxury Houseboats'))
@section('page_meta')
{!! generateMetaTags($houseboat) !!}
@endsection

@section('content')

@php
    $houseboatGallery = [];
    if (!empty($houseboat->gallery)) {
        if (is_array($houseboat->gallery)) {
            $houseboatGallery = $houseboat->gallery;
        } else {
            $decoded = json_decode($houseboat->gallery, true);
            $houseboatGallery = is_array($decoded) ? $decoded : [];
        }
    }

    $houseboatHighlights = [];
    if (!empty($houseboat->highlights)) {
        if (is_array($houseboat->highlights)) {
            $houseboatHighlights = $houseboat->highlights;
        } else {
            $decodedHigh = json_decode($houseboat->highlights, true);
            if (is_array($decodedHigh)) {
                $houseboatHighlights = $decodedHigh;
            } else {
                $houseboatHighlights = array_filter(array_map('trim', explode("\n", (string)$houseboat->highlights)));
            }
        }
    }

    $houseboatsIndexRoute = Route::has('home.houseboats') ? route('home.houseboats') : url('/houseboats');
    $contactRoute         = Route::has('home.contact') ? route('home.contact') : url('/contact');
    $phoneNumber          = $setting->phone ?? '+91 7006338617';
    $phoneClean           = preg_replace('/[^0-9+]/', '', $phoneNumber);
    if (empty($phoneClean)) { $phoneClean = '+917006338617'; }
    $houseboatStarRating  = (int)($houseboat->star_rating ?? 5);
    if ($houseboatStarRating < 1) { $houseboatStarRating = 5; }

    $whatsappMsg = urlencode("Hello Love Link Tour & Travels, I would like to inquire about booking '{$houseboat->name}' in {$houseboat->location}. Please share the current availability and pricing.");
@endphp

<div class="kz-htld-wrapper">
    <!--==============================
        1. CINEMATIC HERO & BREADCRUMBS
    ==============================-->
    <section class="kz-htld-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="kz-htld-breadcrumb">
                        <a href="{{ url('/') }}"><i class="fa-solid fa-house"></i> Home</a>
                        <i class="fa-solid fa-chevron-right"></i>
                        <a href="{{ $houseboatsIndexRoute }}">Houseboats</a>
                        <i class="fa-solid fa-chevron-right"></i>
                        <span class="active-crumb">{{ $houseboat->name }}</span>
                    </div>

                    <div>
                        <span class="kz-htld-hero-tag">
                            <i class="fa-solid fa-crown"></i> Heritage Lake Stay &amp; Experience
                        </span>
                    </div>

                    <h1 class="kz-htld-hero-title">{{ $houseboat->name }}</h1>

                    <div class="kz-htld-hero-meta">
                        <div class="kz-htld-meta-pill">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>{{ $houseboat->location ?? 'Dal Lake, Srinagar' }}</span>
                        </div>
                        @if($houseboatStarRating > 0)
                        <div class="kz-htld-meta-pill">
                            <div class="kz-htld-hero-stars">
                                @for($i = 0; $i < $houseboatStarRating; $i++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                            </div>
                            <span class="ms-1 fw-bold">{{ $houseboatStarRating }}.0 Star Houseboat</span>
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
            <div class="col-lg-8">
                <div class="kz-htld-card">
                    <div class="kz-htld-showcase-box">
                        @php
                            $mainBanner = !empty($houseboat->banner_image) ? $houseboat->banner_image : $houseboat->image;
                        @endphp
                        @if(!empty($mainBanner))
                        <img src="{{ asset('storage/' . $mainBanner) }}"
                             alt="{{ $houseboat->name }}"
                             class="kz-htld-showcase-img">
                        @endif
                        <div class="kz-htld-showcase-gradient"></div>

                        <div class="kz-htld-showcase-badge-top">
                            <a href="{{ $houseboatsIndexRoute }}?search={{ urlencode($houseboat->location ?? '') }}" class="kz-htld-badge-loc">
                                <i class="fa-solid fa-location-dot"></i> {{ $houseboat->location ?? 'Dal Lake' }}
                            </a>
                            <span class="kz-htld-badge-verified">
                                <i class="fa-solid fa-badge-check"></i> Verified Partner
                            </span>
                        </div>

                        <div class="kz-htld-showcase-bottom-bar">
                            <div class="kz-htld-showcase-stars-badge">
                                <span>Rating:</span>
                                @for($i = 0; $i < $houseboatStarRating; $i++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                                <span class="ms-1 text-white">({{ $houseboatStarRating }}/5)</span>
                            </div>
                        </div>
                    </div>

                    <div class="kz-htld-quick-grid">
                        <div class="kz-htld-quick-item">
                            <div class="kz-htld-quick-icon">
                                <i class="fa-solid fa-ship"></i>
                            </div>
                            <div class="kz-htld-quick-info">
                                <div class="kz-htld-quick-label">Property Type</div>
                                <div class="kz-htld-quick-val">{{ $houseboat->type ?? 'Luxury Houseboat' }}</div>
                            </div>
                        </div>
                        <div class="kz-htld-quick-item">
                            <div class="kz-htld-quick-icon">
                                <i class="fa-solid fa-map-pin"></i>
                            </div>
                            <div class="kz-htld-quick-info">
                                <div class="kz-htld-quick-label">Location</div>
                                <div class="kz-htld-quick-val">{{ $houseboat->location ?? 'Dal Lake, Srinagar' }}</div>
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

                    <div class="kz-htld-section-body">
                        <div class="kz-htld-heading-wrap">
                            <h2 class="kz-htld-sec-title">About {{ $houseboat->name }}</h2>
                            <span class="kz-htld-badge-count"><i class="fa-solid fa-circle-info"></i> Details</span>
                        </div>

                        @if(!empty($houseboat->short_description))
                            <div class="kz-htld-short-desc-box">
                                {!! $houseboat->short_description !!}
                            </div>
                        @endif

                        @if(!empty($houseboat->description))
                            <div class="kz-htld-rich-text">
                                {!! $houseboat->description !!}
                            </div>
                        @endif

                        @if(!empty($houseboat->banner_footer_image))
                            <div class="kz-htld-panoramic-box">
                                <img src="{{ asset('storage/' . $houseboat->banner_footer_image) }}"
                                     alt="{{ $houseboat->name }} Panorama"
                                     class="kz-htld-panoramic-img">
                                <div class="kz-htld-panoramic-tag">
                                    <i class="fa-solid fa-image"></i> Panoramic Lake View
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if(!empty($houseboatHighlights))
                <div class="kz-htld-card">
                    <div class="kz-htld-section-body">
                        <div class="kz-htld-heading-wrap">
                            <h3 class="kz-htld-sec-title">Houseboat Highlights &amp; Perks</h3>
                            <span class="kz-htld-badge-count">{{ count($houseboatHighlights) }} Features</span>
                        </div>

                        <div class="kz-htld-highlights-grid">
                            @foreach($houseboatHighlights as $highlight)
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

                @if(!empty($houseboatGallery))
                <div class="kz-htld-card">
                    <div class="kz-htld-section-body">
                        <div class="kz-htld-heading-wrap">
                            <h3 class="kz-htld-sec-title">From Our Gallery</h3>
                            <span class="kz-htld-badge-count">{{ count($houseboatGallery) }} Photos</span>
                        </div>

                        <div class="kz-htld-gallery-grid">
                            @foreach($houseboatGallery as $img)
                                @php $imgUrl = asset('storage/' . $img); @endphp
                                <div class="kz-htld-gallery-item" onclick="kzOpenHotelLightbox('{{ $imgUrl }}')">
                                    <img src="{{ $imgUrl }}" alt="Gallery Image of {{ $houseboat->name }}">
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

            <div class="col-lg-4">
                <aside class="kz-htld-sidebar">
                    <div class="kz-htld-side-box">
                        <div class="kz-htld-search-box">
                            <form method="GET" action="{{ $houseboatsIndexRoute }}">
                                <div class="kz-htld-search-input-wrap">
                                    <input type="text" name="search" placeholder="Search houseboats, lakes...">
                                    <button type="submit" aria-label="Search">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="kz-htld-booking-card">
                        <div class="kz-htld-booking-eyebrow">Instant Reservation</div>
                        <h4 class="kz-htld-booking-title">Inquire About This Houseboat</h4>

                        <div class="kz-htld-booking-guarantee">
                            <i class="fa-solid fa-badge-percent"></i>
                            <span>Best Local Price Guarantee &amp; Direct Owner Confirmation</span>
                        </div>

                        <a href="https://wa.me/{{ $phoneClean }}?text={{ $whatsappMsg }}" target="_blank" class="kz-htld-btn-whatsapp">
                            <i class="fa-brands fa-whatsapp fs-5"></i> Book via WhatsApp
                        </a>

                        <a href="tel:{{ $phoneClean }}" class="kz-htld-btn-call">
                            <i class="fa-solid fa-phone"></i> Call {{ $phoneNumber }}
                        </a>

                        <a href="{{ $contactRoute }}" class="kz-htld-btn-inquire">
                            <i class="fa-solid fa-envelope"></i> Send Custom Inquiry
                        </a>

                        <ul class="kz-htld-trust-checklist">
                            <li><i class="fa-solid fa-circle-check"></i> Free consultation &amp; shikara ride planning</li>
                            <li><i class="fa-solid fa-circle-check"></i> Verified cedarwood suites &amp; hospitality</li>
                            <li><i class="fa-solid fa-circle-check"></i> Zero hidden booking charges</li>
                        </ul>
                    </div>

                    @if(isset($houseboatcategories) && count($houseboatcategories) > 0)
                    <div class="kz-htld-side-box">
                        <h4 class="kz-htld-list-widget-title">
                            <i class="fa-solid fa-layer-group"></i> Houseboat Categories
                        </h4>
                        <ul class="kz-htld-link-list">
                            @foreach($houseboatcategories as $cat)
                            @if(!empty($cat->category))
                            <li class="kz-htld-link-item">
                                <a href="{{ $houseboatsIndexRoute }}?search={{ urlencode($cat->category) }}">
                                    <i class="fa-solid fa-angle-right text-muted small"></i>
                                    {{ $cat->category }}
                                </a>
                                <span class="kz-htld-link-badge">{{ $cat->count }}</span>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(isset($houseboatlocations) && count($houseboatlocations) > 0)
                    <div class="kz-htld-side-box">
                        <h4 class="kz-htld-list-widget-title">
                            <i class="fa-solid fa-map-location-dot"></i> Lake Locations
                        </h4>
                        <ul class="kz-htld-link-list">
                            @foreach($houseboatlocations as $loc)
                            @if(!empty($loc->location))
                            <li class="kz-htld-link-item">
                                <a href="{{ $houseboatsIndexRoute }}?search={{ urlencode($loc->location) }}">
                                    <i class="fa-solid fa-location-dot text-muted small"></i>
                                    {{ $loc->location }}
                                </a>
                                <span class="kz-htld-link-badge">{{ $loc->count }}</span>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="kz-htld-support-card">
                        <div class="kz-htld-support-icon-wrap">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <h4 class="kz-htld-support-title">Need Help Booking?</h4>
                        <p class="kz-htld-support-text">
                            Our Srinagar lake experts are available 24/7 to help you reserve heritage &amp; luxury houseboats.
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
        <img id="kzLightboxImg" src="" alt="Houseboat Photo Preview" class="kz-htld-lightbox-img">
    </div>
</div>
@endsection
