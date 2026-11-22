@extends('frontend.layouts.app')

@section('page_title', $cab->meta_title ?? ($cab->name . ' - Luxury Cab Rental'))
@section('page_meta')
{!! generateMetaTags($cab) !!}
@endsection

@section('content')

@php
    // Prepare consolidated gallery images
    $allGalleryImages = [];
    if (!empty($cab->image)) {
        $allGalleryImages[] = $cab->image;
    }
    if (!empty($cab->banner_image) && $cab->banner_image !== $cab->image) {
        $allGalleryImages[] = $cab->banner_image;
    }
    if (!empty($cab->footer_gallery)) {
        $footerImgs = is_array($cab->footer_gallery) ? $cab->footer_gallery : json_decode($cab->footer_gallery, true);
        if (is_array($footerImgs)) {
            foreach ($footerImgs as $fImg) {
                if (!empty($fImg) && !in_array($fImg, $allGalleryImages)) {
                    $allGalleryImages[] = $fImg;
                }
            }
        }
    }
    $mainFeatureImage = !empty($allGalleryImages) ? $allGalleryImages[0] : null;

    // Sanitize highlights
    $existingHighlights = $cab->highlights ?? [];
    if (is_string($existingHighlights)) {
        $decodedHighlights = json_decode($existingHighlights, true);
        $existingHighlights = is_array($decodedHighlights) ? $decodedHighlights : array_filter(array_map('trim', explode("\n", $existingHighlights)));
    }

    $cabsListRoute = Route::has('home.cabs') ? route('home.cabs') : url('/cabs');
    $contactRoute  = Route::has('home.contact') ? route('home.contact') : url('/contact');
    $phoneDisplay  = '+91 7006338617';
    $phoneRaw      = '+917006338617';
    $whatsappMsg   = urlencode('Hi Love Link, I want to book: ' . $cab->name . ' (' . ($cab->cab_type ?? 'Cab') . ')');
@endphp

<!--==============================
Custom Luxury CSS Scoped to Cab Details Page
==============================-->
<div class="kz-cab-detail-page">

    <!--==============================
    1. CINEMATIC HERO / BREADCRUMB
    ==============================-->
    <section class="kz-cab-hero-banner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-9 col-md-10">
                    <!-- Breadcrumbs -->
                    <div class="kz-cab-breadcrumb">
                        <a href="{{ url('/') }}"><i class="fas fa-home"></i> Home</a>
                        <i class="fas fa-chevron-right"></i>
                        <a href="{{ $cabsListRoute }}">Cabs</a>
                        <i class="fas fa-chevron-right"></i>
                        <span class="active-crumb">{{ $cab->name }}</span>
                    </div>

                    <!-- Kicker tag -->
                    <div class="kz-cab-hero-kicker">
                        <i class="fas fa-taxi"></i> Premium Transportation Fleet
                    </div>

                    <!-- Main Cab Title -->
                    <h1 class="kz-cab-hero-title">{{ $cab->name }}</h1>

                    <!-- Badges -->
                    <div class="kz-cab-hero-badges">
                        <span class="kz-cab-hero-badge badge-gold">
                            <i class="fas fa-car-side me-1"></i> {{ $cab->cab_type ?? 'Chauffeur Cab' }}
                        </span>
                        <span class="kz-cab-hero-badge">
                            <i class="fas fa-shield-alt text-success me-1"></i> 100% Sanitized & Insured
                        </span>
                        <span class="kz-cab-hero-badge">
                            <i class="fas fa-user-check text-info me-1"></i> Verified Local Chauffeur
                        </span>
                        <span class="kz-cab-hero-badge">
                            <i class="fas fa-star text-warning me-1"></i> 4.9 Guest Rating
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--==============================
    2. MAIN CONTENT & SIDEBAR
    ==============================-->
    <section class="kz-cab-detail-body">
        <div class="container">
            <div class="row g-4">

                <!-- Left Column: Cab Showcase Details -->
                <div class="col-xl-8 col-lg-8">
                    <div class="kz-cab-card">

                        <!-- Gallery Showcase -->
                        <div class="kz-cab-gallery-wrap">
                            <!-- Main Large Stage Viewport -->
                            <div class="kz-cab-main-stage">
                                <span class="kz-cab-floating-tag">
                                    <i class="fas fa-car me-1"></i> {{ $cab->cab_type }}
                                </span>
                                <span class="kz-cab-floating-rating">
                                    <i class="fas fa-star text-warning"></i> 4.9 <span>(Top Rated)</span>
                                </span>

                                @if(!empty($mainFeatureImage))
                                    <img id="kz-cab-main-img" 
                                         src="{{ asset('storage/' . $mainFeatureImage) }}" 
                                         alt="{{ $cab->name }}">
                                @else
                                    <div class="d-flex flex-column align-items-center justify-content-center h-100 text-white bg-dark">
                                        <i class="fas fa-car fa-3x mb-3 text-warning"></i>
                                        <h5 class="fw-bold mb-1">{{ $cab->name }}</h5>
                                        <p class="text-white-50 small mb-0">Premium Chauffeur Fleet</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Interactive Thumbnails Strip -->
                            @if(count($allGalleryImages) > 1)
                                <div class="kz-cab-thumbs-track" id="kz-cab-thumbs-track">
                                    @foreach($allGalleryImages as $imgIndex => $galleryImg)
                                        <div class="kz-cab-thumb-item {{ $imgIndex === 0 ? 'active-thumb' : '' }}" 
                                             onclick="kzSelectCabThumb('{{ asset('storage/' . $galleryImg) }}', this)">
                                            <img src="{{ asset('storage/' . $galleryImg) }}" alt="{{ $cab->name }} - Photo {{ $imgIndex + 1 }}">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Quick Vehicle Specs Bar -->
                        <div class="kz-cab-specs-grid">
                            <div class="kz-cab-spec-box">
                                <div class="kz-cab-spec-icon"><i class="fas fa-car-side"></i></div>
                                <div>
                                    <div class="kz-cab-spec-label">Cab Type</div>
                                    <div class="kz-cab-spec-val">{{ $cab->cab_type ?? 'Sedan / SUV' }}</div>
                                </div>
                            </div>
                            <div class="kz-cab-spec-box">
                                <div class="kz-cab-spec-icon"><i class="fas fa-snowflake"></i></div>
                                <div>
                                    <div class="kz-cab-spec-label">Climate Control</div>
                                    <div class="kz-cab-spec-val">AC & Heater</div>
                                </div>
                            </div>
                            <div class="kz-cab-spec-box">
                                <div class="kz-cab-spec-icon"><i class="fas fa-user-tie"></i></div>
                                <div>
                                    <div class="kz-cab-spec-label">Driver</div>
                                    <div class="kz-cab-spec-val">Expert Chauffeur</div>
                                </div>
                            </div>
                            <div class="kz-cab-spec-box">
                                <div class="kz-cab-spec-icon"><i class="fas fa-suitcase-rolling"></i></div>
                                <div>
                                    <div class="kz-cab-spec-label">Luggage</div>
                                    <div class="kz-cab-spec-val">Spacious Boot</div>
                                </div>
                            </div>
                        </div>

                        <!-- Short Description / Lead Box -->
                        @if(!empty($cab->short_description))
                            <div class="kz-cab-lead-box">
                                {!! $cab->short_description !!}
                            </div>
                        @endif

                        <!-- Highlights Section -->
                        @if(!empty($existingHighlights))
                            <div class="kz-cab-section-head">
                                <span class="bar"></span>
                                <h3>Vehicle Highlights & Amenities</h3>
                            </div>
                            <div class="kz-highlights-grid">
                                @foreach ($existingHighlights as $highlight)
                                    @if(!empty($highlight))
                                        <div class="kz-highlight-card">
                                            <span class="kz-highlight-icon"><i class="fas fa-check-circle"></i></span>
                                            <span class="kz-highlight-text">{{ $highlight }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        <!-- Detailed Rich Content -->
                        @if(!empty($cab->description))
                            <div class="kz-cab-section-head">
                                <span class="bar"></span>
                                <h3>Overview & Rental Details</h3>
                            </div>
                            <div class="kz-cab-prose">
                                {!! $cab->description !!}
                            </div>
                        @endif

                        <!-- Bottom Action Navigation -->
                        <div class="kz-cab-action-bar">
                            <a href="{{ $cabsListRoute }}" class="kz-btn-back">
                                <i class="fas fa-arrow-left"></i> Back to All Cabs
                            </a>
                            <div class="d-flex align-items-center gap-2">
                                <a href="https://wa.me/{{ preg_replace('/[^\d]/', '', $phoneRaw) }}?text={{ $whatsappMsg }}" 
                                   target="_blank" 
                                   class="kz-btn-book-cta">
                                    <i class="fab fa-whatsapp me-1 fs-5"></i> Book Cab via WhatsApp
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right Column: Luxury Sidebar -->
                <div class="col-xl-4 col-lg-4">
                    <aside class="kz-cab-sidebar">

                        <!-- Widget 1: Instant Booking / Inquiries -->
                        <div class="kz-sidebar-card kz-booking-widget" style="background: linear-gradient(145deg, #072355 0%, #0B3D91 100%) !important; color: #ffffff !important; border: 1px solid rgba(221, 171, 67, 0.3) !important;">
                            <div class="kz-sidebar-head">
                                <h4 class="kz-sidebar-title"><i class="fas fa-calendar-check me-2 text-warning"></i> Quick Booking</h4>
                                <span class="badge bg-white text-dark fw-bold px-2 py-1">24/7 Available</span>
                            </div>
                            <p class="kz-booking-lead">
                                Reserve <strong>{{ $cab->name }}</strong> with transparent pricing, sanitized interiors, and polite local drivers.
                            </p>

                            <!-- Direct Call Action -->
                            <a href="tel:{{ $phoneRaw }}" class="kz-sidebar-btn kz-btn-call">
                                <i class="fas fa-phone-alt"></i> Call Now: {{ $phoneDisplay }}
                            </a>

                            <!-- Direct WhatsApp Action -->
                            <a href="https://wa.me/{{ preg_replace('/[^\d]/', '', $phoneRaw) }}?text={{ $whatsappMsg }}" 
                               target="_blank" 
                               class="kz-sidebar-btn kz-btn-whatsapp">
                                <i class="fab fa-whatsapp fs-5"></i> Instant WhatsApp Booking
                            </a>

                            <!-- Custom Inquiry Link -->
                            <a href="{{ $contactRoute }}" class="kz-sidebar-btn kz-btn-inquiry">
                                <i class="fas fa-envelope"></i> Send Custom Inquiry
                            </a>

                            <!-- Trust Checklist -->
                            <ul class="kz-booking-guarantees">
                                <li><i class="fas fa-check-circle"></i> Best Rate Guarantee — No hidden fees</li>
                                <li><i class="fas fa-check-circle"></i> On-time doorstep pickup & drop</li>
                                <li><i class="fas fa-check-circle"></i> Free cancellation up to 24h before trip</li>
                                <li><i class="fas fa-check-circle"></i> Verified commercial permit & insurance</li>
                            </ul>
                        </div>

                        <!-- Widget 2: Search Other Cabs -->
                        <div class="kz-sidebar-card">
                            <div class="kz-sidebar-head">
                                <h4 class="kz-sidebar-title"><i class="fas fa-search me-2 text-primary"></i> Search Cabs</h4>
                            </div>
                            <form method="GET" action="{{ $cabsListRoute }}" class="kz-search-form">
                                <div class="input-group">
                                    <input type="text" 
                                           name="search" 
                                           class="form-control" 
                                           placeholder="Search by cab type or name..." 
                                           required>
                                    <button type="submit" title="Search Cabs">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Widget 3: Cab Fleet Categories / Cab Types -->
                        @if(!empty($cabtypes) && count($cabtypes) > 0)
                            <div class="kz-sidebar-card">
                                <div class="kz-sidebar-head">
                                    <h4 class="kz-sidebar-title"><i class="fas fa-layer-group me-2 text-primary"></i> Cab Fleet Categories</h4>
                                </div>
                                <div class="kz-cabtypes-list">
                                    @foreach($cabtypes as $cabtype)
                                        @php
                                            $isCurrentType = !empty($cab->cab_type) && strtolower($cabtype->cab_type) === strtolower($cab->cab_type);
                                        @endphp
                                        <a href="{{ route('home.cabs', ['search' => $cabtype->cab_type]) }}" 
                                           class="kz-cabtype-item {{ $isCurrentType ? 'active-type' : '' }}">
                                            <span>
                                                <i class="fas fa-taxi"></i> {{ $cabtype->cab_type }}
                                            </span>
                                            <span class="kz-cabtype-badge">{{ $cabtype->count }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Widget 4: Need Help / Support Banner -->
                        <div class="kz-sidebar-card text-center" style="background:#f1f5f9; border-color:#e2e8f0;">
                            <div class="mb-3">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle" 
                                     style="width:54px; height:54px; background:var(--kz-navy); color:#ffffff; font-size:22px;">
                                    <i class="fas fa-headset"></i>
                                </div>
                            </div>
                            <h5 class="fw-bold mb-1" style="color:var(--kz-navy);">Need Assistance?</h5>
                            <p class="text-muted small mb-3">Our dedicated Kashmir travel desk is available 24/7 to help you plan your itinerary.</p>
                            <a href="tel:{{ $phoneRaw }}" class="fw-bold text-decoration-none" style="color:var(--kz-navy); font-size:16px;">
                                <i class="fas fa-phone-alt me-1 text-warning"></i> {{ $phoneDisplay }}
                            </a>
                        </div>

                    </aside>
                </div>

            </div>
        </div>
    </section>

</div>

<!--==============================
Thumbnail Gallery Vanilla JS
==============================-->
@endsection
