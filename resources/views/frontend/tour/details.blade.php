@extends('frontend.layouts.app')
@section('page_title', $tour->meta_title)
@section('page_meta')  
{!! generateMetaTags($tour) !!} 



@endsection
@section('content')
<!--==============================
tour Area
==============================-->
<section class="space-details">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-lg-12">
                <div class="tour-page-single">

                    {{-- Image Slider (Scoped with .tour-gallery-slider-wrap & #tourGallerySlider) --}}
                    <div class="slider-area tour-slider1 tour-gallery-slider-wrap position-relative">
                        <div class="swiper th-slider tour-thumb-slider tour-gallery-slider" id="tourGallerySlider"
                             data-slider-options='{
                                "effect": "slide",
                                "loop": true,
                                "grabCursor": true,
                                "speed": 600,
                                "autoplay": {"delay": 4500, "disableOnInteraction": false},
                                "breakpoints": {
                                    "0": {"slidesPerView": 2, "spaceBetween": 12},
                                    "576": {"slidesPerView": 2, "spaceBetween": 16},
                                    "768": {"slidesPerView": 3, "spaceBetween": 20},
                                    "992": {"slidesPerView": 4, "spaceBetween": 20},
                                    "1200": {"slidesPerView": 4, "spaceBetween": 24}
                                },
                                "autoplayDisableOnInteraction": "true"
                             }'>
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="tour-slider-img">
                                        <img src="{{ asset('storage/' . $tour->banner_image) }}" alt="Image">
                                    </div>
                                </div>
                                @if(!empty($tour->footer_gallery))
                                    @foreach(json_decode($tour->footer_gallery) as $image)
                                    <div class="swiper-slide">
                                        <div class="tour-slider-img">
                                            <img src="{{ asset('storage/' . $image) }}" alt="img">
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        {{-- Gallery Slider Navigation Arrows (Positioned Directly ON the Image) --}}
                        <button type="button" data-slider-prev="#tourGallerySlider" class="tour-gallery-arrow tour-gallery-prev" aria-label="Previous image">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <button type="button" data-slider-next="#tourGallerySlider" class="tour-gallery-arrow tour-gallery-next" aria-label="Next image">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>

                    {{-- Tour Header --}}
                    <div class="page-content">
                        {{-- Modern Executive Header --}}
                        <div class="kz-tour-header-wrap mb-4">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-2">
                                <div class="kz-header-badges d-flex flex-wrap align-items-center gap-2">
                                    <span class="kz-tour-badge badge-dest">
                                        <i class="fa-solid fa-location-dot"></i> {{ $tour->location ?? ($tour->state->name ?? 'Kashmir') }}
                                    </span>
                                    <span class="kz-tour-badge badge-duration">
                                        <i class="fa-solid fa-clock"></i> {{ $tour->duration > 1 ? ($tour->duration - 1) . 'N / ' . $tour->duration . 'D' : $tour->duration . ' Days' }}
                                    </span>
                                    <span class="kz-tour-badge badge-rating">
                                        <i class="fa-solid fa-star text-warning"></i> {{ number_format($tour->rating ?? 5.0, 1) }} / 5.0
                                    </span>
                                    @if(!empty($tour->badge_type))
                                    <span class="kz-tour-badge badge-deal">
                                        <i class="fa-solid fa-bolt"></i> {{ ucfirst(str_replace('_', ' ', $tour->badge_type)) }}
                                    </span>
                                    @endif
                                </div>
                                <div class="kz-header-pricing">
                                    <span class="kz-price-prefix">From</span>
                                    <span class="kz-price-amount">{{ str_replace('.00', '', $tour->formatted_price) }}</span>
                                    <span class="kz-price-suffix">/ Person</span>
                                </div>
                            </div>
                            <h1 class="kz-tour-headline">{{ $tour->title }}</h1>
                        </div>

                        {{-- ========== CONTINUOUS FLOW WITH STICKY TABS SIDEBAR ========== --}}
                        <div class="row g-4 align-items-start position-relative">
                            {{-- LEFT: Sticky Tabs Sidebar (col-lg-3 col-md-4) --}}
                            <div class="col-lg-3 col-md-4 kz-tour-nav-col">
                                <div class="kz-sticky-tabs-wrap">
                                    <div class="kz-tabs-header">
                                        <i class="fa-solid fa-compass"></i>
                                        <span>Tour Details</span>
                                    </div>
                                    <ul class="kz-sticky-nav-list" id="tourScrollspyNav">
                                        <span class="kz-tour-glider" aria-hidden="true"></span>
                                        <li>
                                            <a href="#tour-overview" class="kz-nav-link active" data-target="tour-overview">
                                                <i class="ti ti-info-circle"></i>
                                                <span>Overview</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#tour-plan" class="kz-nav-link" data-target="tour-plan">
                                                <i class="ti ti-map-2"></i>
                                                <span>Tour Plan</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#tour-included" class="kz-nav-link" data-target="tour-included">
                                                <i class="ti ti-circle-check"></i>
                                                <span>Included</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#tour-excluded" class="kz-nav-link" data-target="tour-excluded">
                                                <i class="ti ti-circle-x"></i>
                                                <span>Excluded</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#tour-remarks" class="kz-nav-link" data-target="tour-remarks">
                                                <i class="ti ti-alert-triangle"></i>
                                                <span>Special Remarks</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#tour-booking" class="kz-nav-link" data-target="tour-booking">
                                                <i class="ti ti-clipboard-check"></i>
                                                <span>Booking Policy</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#tour-cancellation" class="kz-nav-link" data-target="tour-cancellation">
                                                <i class="ti ti-calendar-x"></i>
                                                <span>Cancellation Policy</span>
                                            </a>
                                        </li>
                                    </ul>

                                    {{-- Quick CTA in Sticky Sidebar --}}
                                    <div class="kz-sticky-cta mt-3 pt-3">
                                        <a href="#kawTourBookingForm" class="kz-sticky-book-btn">
                                            <i class="fa-solid fa-bolt"></i> Book Package
                                        </a>
                                        <a href="https://api.whatsapp.com/send?phone=917006338617&text={{ urlencode('Hi LoveLink, I would like to inquire about: ' . $tour->title) }}" target="_blank" class="kz-sticky-wa-btn">
                                            <i class="fa-brands fa-whatsapp"></i> WhatsApp Inquire
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- RIGHT: Continuous Section Cards (col-lg-9 col-md-8) --}}
                            <div class="col-lg-9 col-md-8 kz-tour-content-col">

                                {{-- SECTION 1: Overview --}}
                                <div class="kz-detail-section-card" id="tour-overview">
                                    <div class="kz-section-header">
                                        <div class="kz-section-title-wrap">
                                            <span class="kz-section-icon"><i class="ti ti-info-circle"></i></span>
                                            <h3 class="kz-section-title">Overview</h3>
                                        </div>
                                        <span class="kz-section-badge"><i class="fa-solid fa-compass"></i> Tour Highlights</span>
                                    </div>

                                    {{-- Quick Specifications Pill Bar --}}
                                    <div class="kz-overview-specs-grid mb-4">
                                        <div class="kz-spec-pill">
                                            <i class="fa-solid fa-clock text-primary"></i>
                                            <div>
                                                <small>Duration</small>
                                                <strong>{{ $tour->duration > 1 ? ($tour->duration - 1) . 'N / ' . $tour->duration . 'D' : $tour->duration . ' Days' }}</strong>
                                            </div>
                                        </div>
                                        <div class="kz-spec-pill">
                                            <i class="fa-solid fa-map-location-dot text-primary"></i>
                                            <div>
                                                <small>Destination</small>
                                                <strong>{{ $tour->state->name ?? 'Kashmir' }}</strong>
                                            </div>
                                        </div>
                                        <div class="kz-spec-pill">
                                            <i class="fa-solid fa-user-group text-primary"></i>
                                            <div>
                                                <small>Tour Type</small>
                                                <strong>Customized Private</strong>
                                            </div>
                                        </div>
                                        <div class="kz-spec-pill">
                                            <i class="fa-solid fa-car-side text-primary"></i>
                                            <div>
                                                <small>Transport</small>
                                                <strong>Private Cab Included</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="kz-overview-prose">
                                        @if(!empty(trim(strip_tags($tour->description ?? ''))))
                                            <div class="overview-description mb-3">
                                                {!! $tour->description !!}
                                            </div>
                                        @endif
                                        @if(!empty(trim(strip_tags($tour->basic_content ?? ''))))
                                            <div class="overview-content">
                                                {!! $tour->basic_content !!}
                                            </div>
                                        @endif
                                        @if(empty(trim(strip_tags($tour->description ?? ''))) && empty(trim(strip_tags($tour->basic_content ?? ''))))
                                            <p class="mb-0">Explore our handcrafted tour itinerary and experience scenic mountain backdrops, luxury stays, and memorable journeys with Love Link Tour & Travels.</p>
                                        @endif
                                    </div>
                                </div>

                                {{-- SECTION 2: Tour Plan (Day-wise Itinerary) --}}
                                <div class="kz-detail-section-card" id="tour-plan">
                                    <div class="kz-section-header">
                                        <div class="kz-section-title-wrap">
                                            <span class="kz-section-icon"><i class="ti ti-map-2"></i></span>
                                            <h3 class="kz-section-title">Tour Plan & Daily Itinerary</h3>
                                        </div>
                                        <span class="kz-section-badge"><i class="fa-solid fa-route"></i> Day-by-Day Experience</span>
                                    </div>

                                    @php
                                        $itineraryData = json_decode($tour->itinerary, true);
                                    @endphp

                                    <div class="kz-itinerary-timeline">
                                        @if(!empty($itineraryData) && is_array($itineraryData))
                                            @foreach ($itineraryData as $day => $details)
                                                @php
                                                    $dayNumber = str_replace('day_', '', $day);
                                                    $dayNumPadded = str_pad($dayNumber, 2, '0', STR_PAD_LEFT);

                                                    // Normalize text lines
                                                    $rawDetailsText = is_string($details) ? $details : (is_array($details) ? implode("\n", array_map('strval', $details)) : (string) ($details ?? ''));
                                                    $cleanDetails = str_replace(["\r\n", "\r"], "\n", trim($rawDetailsText));
                                                    $lines = array_values(array_filter(explode("\n", $cleanDetails), function($line) {
                                                        return trim($line) !== '';
                                                    }));

                                                    $dayTitle = '';
                                                    $bodyLines = $lines;

                                                    if (!empty($lines)) {
                                                        $first = trim($lines[0]);
                                                        // Check for *Title* pattern
                                                        if (preg_match('/^\*([^*]+)\*(.*)$/', $first, $m)) {
                                                            $dayTitle = trim($m[1] ?? '');
                                                            $rest = trim($m[2] ?? '');
                                                            if (!empty($rest)) {
                                                                $bodyLines[0] = ltrim($rest, " \t-–—:");
                                                            } else {
                                                                array_shift($bodyLines);
                                                            }
                                                        } elseif (strlen($first) <= 90 && !preg_match('/^(morning|afternoon|evening|night|day\s*\d+|after\s+breakfast)/i', $first) && count($lines) > 1) {
                                                            // Short descriptive title (e.g. "Arrival in Srinagar & Local Sightseeing")
                                                            $dayTitle = trim($first, "* \t-–—");
                                                            array_shift($bodyLines);
                                                        } elseif (preg_match('/^(Arrival\s+(?:at|in)\s+[^,.]+)/i', $first, $m)) {
                                                            $dayTitle = trim($m[1] ?? $m[0] ?? "Day {$dayNumber} Itinerary");
                                                        } elseif (preg_match('/^(After\s+(?:the\s+)?breakfast,\s*(?:proceed|drive|travel)\s+(?:to|towards)\s+[^,.]+)/i', $first, $m)) {
                                                            $dayTitle = trim($m[1] ?? $m[0] ?? "Day {$dayNumber} Itinerary");
                                                        } else {
                                                            $dayTitle = "Day {$dayNumber} Itinerary";
                                                        }
                                                    } else {
                                                        $dayTitle = "Day {$dayNumber} Itinerary";
                                                    }

                                                    $formattedBody = implode("\n\n", $bodyLines);
                                                @endphp
                                                <div class="kz-day-item">
                                                    <div class="kz-day-card">
                                                        {{-- Highlighted Day Header --}}
                                                        <div class="kz-day-card-header">
                                                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                                                <span class="kz-day-pill">Day {{ $dayNumPadded }}</span>
                                                                <h4 class="kz-day-title mb-0">
                                                                    <i class="fa-solid fa-location-dot kz-day-title-icon"></i>
                                                                    {{ $dayTitle }}
                                                                </h4>
                                                            </div>
                                                            <span class="kz-day-route-tag d-none d-sm-inline-flex">
                                                                <i class="fa-solid fa-route"></i> Sightseeing
                                                            </span>
                                                        </div>
                                                        <div class="kz-day-text">
                                                            {!! nl2br(e($formattedBody)) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted mb-0">Detailed day-wise itinerary will be shared upon booking confirmation.</p>
                                        @endif
                                    </div>
                                </div>

                                {{-- SECTION 3: Included --}}
                                <div class="kz-detail-section-card" id="tour-included">
                                    <div class="kz-section-header">
                                        <div class="kz-section-title-wrap">
                                            <span class="kz-section-icon icon-success"><i class="ti ti-circle-check"></i></span>
                                            <h3 class="kz-section-title">What's Included</h3>
                                        </div>
                                        <span class="kz-section-badge badge-success"><i class="fa-solid fa-check"></i> Handcrafted Inclusions</span>
                                    </div>

                                    @if(!empty(trim(strip_tags($tour->include_exclude_content ?? ''))))
                                        <div class="tour-info-card mb-3">
                                            {!! $tour->include_exclude_content !!}
                                        </div>
                                    @endif

                                    @php
                                        $incRaw = $tour->include_exclude;
                                        if (is_string($incRaw)) {
                                            $incRaw = json_decode($incRaw, true);
                                        }
                                        $include_exclude = is_array($incRaw) ? $incRaw : (is_object($incRaw) ? (array)$incRaw : []);
                                        $includedItems = [];
                                        foreach ($include_exclude as $chkItem) {
                                            $chkObj = (object) $chkItem;
                                            if (isset($chkObj->type) && $chkObj->type == 1 && !empty($chkObj->title)) {
                                                $includedItems[] = $chkObj->title;
                                            }
                                        }
                                        if (empty($includedItems)) {
                                            $includedItems = [
                                                'Comfortable Hotel / Houseboat Accommodation',
                                                'Daily Delicious Breakfast & Dinner',
                                                'Dedicated Private Cab for Airport Transfers & Sightseeing',
                                                '1-Hour Romantic Shikara Ride on Dal Lake',
                                                'All Toll Taxes, Driver Allowances & Parking Fees'
                                            ];
                                        }
                                    @endphp

                                    <ul class="kz-tour-bullet-list kz-bullet-included">
                                        @foreach ($includedItems as $itemTitle)
                                            <li>{{ $itemTitle }}</li>
                                        @endforeach
                                    </ul>
                                </div>

                                {{-- SECTION 4: Excluded --}}
                                <div class="kz-detail-section-card" id="tour-excluded">
                                    <div class="kz-section-header">
                                        <div class="kz-section-title-wrap">
                                            <span class="kz-section-icon icon-danger"><i class="ti ti-circle-x"></i></span>
                                            <h3 class="kz-section-title">What's Excluded</h3>
                                        </div>
                                        <span class="kz-section-badge badge-danger">Not Included</span>
                                    </div>

                                    @php
                                        $excludedItems = [];
                                        foreach ($include_exclude as $chkItem) {
                                            $chkObj = (object) $chkItem;
                                            if (isset($chkObj->type) && $chkObj->type == 0 && !empty($chkObj->title)) {
                                                $excludedItems[] = $chkObj->title;
                                            }
                                        }
                                        if (empty($excludedItems)) {
                                            $excludedItems = [
                                                'Airfare / Train tickets to and from Srinagar',
                                                'Personal expenses (laundry, beverages, extra meals)',
                                                'Gondola cable car tickets in Gulmarg',
                                                'Pony rides, sledging, or snow activities',
                                                'Anything not specifically mentioned in inclusions'
                                            ];
                                        }
                                    @endphp

                                    <ul class="kz-tour-bullet-list kz-bullet-excluded">
                                        @foreach ($excludedItems as $itemTitle)
                                            <li>{{ $itemTitle }}</li>
                                        @endforeach
                                    </ul>
                                </div>

                                {{-- SECTION 5: Special Remarks --}}
                                <div class="kz-detail-section-card" id="tour-remarks">
                                    <div class="kz-section-header">
                                        <div class="kz-section-title-wrap">
                                            <span class="kz-section-icon icon-warning"><i class="ti ti-alert-triangle"></i></span>
                                            <h3 class="kz-section-title">Special Remarks & Guidelines</h3>
                                        </div>
                                        <span class="kz-section-badge badge-warning">Important Tips</span>
                                    </div>

                                    @php
                                        $existingImpor = $tour->basic ?? [];
                                        if (is_string($existingImpor)) {
                                            $existingImpor = json_decode($existingImpor, true) ?: [$existingImpor];
                                        }
                                        $remarkItems = [];
                                        if (!empty($existingImpor) && is_array($existingImpor)) {
                                            foreach ($existingImpor as $important_info) {
                                                if (!empty(trim((string) $important_info))) {
                                                    $remarkItems[] = trim((string) $important_info);
                                                }
                                            }
                                        }
                                    @endphp

                                    @if (!empty($remarkItems))
                                        <ul class="kz-tour-bullet-list kz-bullet-remarks">
                                            @foreach ($remarkItems as $remarkText)
                                                <li>{{ $remarkText }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <ul class="kz-tour-bullet-list kz-bullet-remarks">
                                            <li>Carry valid Government photo IDs and postpaid SIM cards for seamless connectivity across Jammu &amp; Kashmir.</li>
                                        </ul>
                                    @endif
                                </div>

                                {{-- SECTION 6: Booking Policy --}}
                                <div class="kz-detail-section-card" id="tour-booking">
                                    <div class="kz-section-header">
                                        <div class="kz-section-title-wrap">
                                            <span class="kz-section-icon"><i class="ti ti-clipboard-check"></i></span>
                                            <h3 class="kz-section-title">Booking Policy</h3>
                                        </div>
                                        <span class="kz-section-badge"><i class="fa-solid fa-handshake"></i> Verified Terms</span>
                                    </div>

                                    <div class="kz-policy-card">
                                        @if(!empty(trim(strip_tags($tour->booking ?? ''))))
                                            {!! $tour->booking !!}
                                        @else
                                            <p class="mb-0">To confirm your reservation, please submit your travel requirements via our instant booking form below. Our reservation desk will verify hotel and cab availability and issue instant digital confirmation upon advance payment receipt.</p>
                                        @endif
                                    </div>
                                </div>

                                {{-- SECTION 7: Cancellation Policy --}}
                                <div class="kz-detail-section-card" id="tour-cancellation">
                                    <div class="kz-section-header">
                                        <div class="kz-section-title-wrap">
                                            <span class="kz-section-icon icon-danger"><i class="ti ti-calendar-x"></i></span>
                                            <h3 class="kz-section-title">Cancellation & Refund Policy</h3>
                                        </div>
                                        <span class="kz-section-badge badge-danger"><i class="fa-solid fa-rotate-left"></i> Refund Terms</span>
                                    </div>

                                    <div class="kz-policy-card">
                                        @if(!empty(trim(strip_tags($tour->cancellation ?? ''))))
                                            {!! $tour->cancellation !!}
                                        @else
                                            <p class="mb-0">Cancellations made 15 days or more prior to arrival date are eligible for a partial refund as per hotel and transport partner terms. Cancellations within 7 days of arrival are subject to non-refundable hotel retention charges.</p>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        {{-- END CONTINUOUS FLOW LAYOUT --}}

                        {{-- ========================================== --}}
                        {{-- MINIMAL PACKAGE BOOKING FORM               --}}
                        {{-- ========================================== --}}
                        <div class="kaw-booking-wrap mt-3 mb-2">
                            <div class="kaw-booking-box">
                                <div class="kaw-booking-header d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                    <div>
                                        <span class="kaw-booking-badge"><i class="fa-solid fa-bolt"></i> Instant Booking</span>
                                        <h4 class="kaw-booking-title mb-0">Book This Package</h4>
                                    </div>
                                    <div class="kaw-booking-price-pill">
                                        <span>Starting from <strong>{{ str_replace('.00', '', $tour->formatted_price) }}</strong> / PP</span>
                                    </div>
                                </div>

                                {{-- Success & Error Alerts --}}
                                @if (session('success'))
                                    <div class="alert alert-success d-flex align-items-center gap-2 mb-3 py-2 px-3" role="alert" style="border-radius: 8px; font-size: 13px;">
                                        <i class="fa-solid fa-circle-check fs-5"></i>
                                        <div>{{ session('success') }}</div>
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger mb-3 py-2 px-3" role="alert" style="border-radius: 8px; font-size: 12.5px;">
                                        <ul class="mb-0 ps-3">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div id="kawJsAlert" style="display: none;"></div>

                                <form id="kawTourBookingForm" action="{{ Route::has('home.contact.submit') ? route('home.contact.submit') : url('/contact-submit') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                                    <input type="hidden" name="subject" value="Package Booking: {{ $tour->title }}">
                                    <input type="hidden" name="message" id="bk_message_hidden">
                                    {{-- Hidden Fallback Email for Backend Validation (ContactSubmit requires email) --}}
                                    <input type="hidden" name="email" id="bk_email_hidden" value="{{ !empty($setting->email) ? $setting->email : (config('mail.from.address') ?: 'info@webassets.tech') }}">

                                    <div class="row g-2">
                                        {{-- 1. Package Title (Automatic / Readonly) --}}
                                        <div class="col-6 col-md-4 col-lg-4 kaw-field-col">
                                            <label class="kaw-label"><i class="fa-solid fa-box-archive"></i> Package Title</label>
                                            <input type="text" id="bk_package_title" name="package_title" value="{{ $tour->title }}" class="kaw-input kaw-readonly" readonly title="{{ $tour->title }}">
                                        </div>

                                        {{-- 2. Name --}}
                                        <div class="col-6 col-md-4 col-lg-4 kaw-field-col">
                                            <label class="kaw-label"><i class="fa-solid fa-user"></i> Name</label>
                                            <input type="text" id="bk_name" name="name" class="kaw-input" placeholder="Your Name" required>
                                        </div>

                                        {{-- 3. Pick and Drop (Replaces Email Address) --}}
                                        <div class="col-6 col-md-4 col-lg-4 kaw-field-col">
                                            <label class="kaw-label"><i class="fa-solid fa-car"></i> Pick and Drop</label>
                                            <input type="text" id="bk_pickup_drop" name="pickup_drop" class="kaw-input" placeholder="e.g. Srinagar Airport" required>
                                        </div>

                                        {{-- 4. Phone Number --}}
                                        <div class="col-6 col-md-4 col-lg-4 kaw-field-col">
                                            <label class="kaw-label"><i class="fa-solid fa-phone"></i> Phone Number</label>
                                            <input type="tel" id="bk_number" name="number" class="kaw-input" placeholder="Phone / WhatsApp" required>
                                        </div>

                                        {{-- 5. Destination --}}
                                        <div class="col-6 col-md-4 col-lg-4 kaw-field-col">
                                            <label class="kaw-label"><i class="fa-solid fa-location-dot"></i> Destination</label>
                                            <input type="text" id="bk_destination" name="destination" class="kaw-input" value="{{ $tour->location ?? 'Kashmir' }}" placeholder="Destination" required>
                                        </div>

                                        {{-- 6. Arrival Date --}}
                                        <div class="col-6 col-md-4 col-lg-4 kaw-field-col">
                                            <label class="kaw-label"><i class="fa-solid fa-calendar-days"></i> Arrival Date</label>
                                            <input type="date" id="bk_arrival_date" name="arrival_date" class="kaw-input" required min="{{ date('Y-m-d') }}">
                                        </div>

                                        {{-- 7. No of Persons --}}
                                        <div class="col-6 col-md-4 col-lg-4 kaw-field-col">
                                            <label class="kaw-label"><i class="fa-solid fa-users"></i> No of Persons</label>
                                            <input type="number" id="bk_no_of_persons" name="no_of_persons" class="kaw-input" min="1" max="50" value="2" placeholder="Persons" required>
                                        </div>

                                        {{-- 8. Room Details (Standard text input to match No of Persons height) --}}
                                        <div class="col-6 col-md-4 col-lg-4 kaw-field-col">
                                            <label class="kaw-label"><i class="fa-solid fa-bed"></i> Room Details</label>
                                            <input type="text" id="bk_room_details" name="room_details" class="kaw-input" placeholder="e.g. 1 Double Room" value="1 Double Room" required>
                                        </div>

                                        {{-- 9. Hotel Category (Full width col-12 on mobile, col-md-4 on desktop) --}}
                                        <div class="col-12 col-md-4 col-lg-4 kaw-field-col">
                                            <label class="kaw-label"><i class="fa-solid fa-hotel"></i> Hotel Category</label>
                                            <select id="bk_hotel_category" name="hotel_category" class="kaw-input">
                                                <option value="Standard" selected>Standard</option>
                                                <option value="3 Star">3 Star</option>
                                                <option value="3 Star Premium">3 Star Premium</option>
                                                <option value="4 Star Standard">4 Star Standard</option>
                                                <option value="4 Star">4 Star</option>
                                                <option value="5 Star Standard">5 Star Standard</option>
                                                <option value="5 Star">5 Star</option>
                                            </select>
                                        </div>

                                        {{-- Dual Action Buttons: Book via Mail & Book via WhatsApp --}}
                                        <div class="col-12">
                                            <div class="kaw-booking-actions">
                                                <button type="submit" id="btnBookMail" class="kaw-book-btn kaw-btn-mail">
                                                    <i class="fa-solid fa-envelope"></i>
                                                    <span>Book via Mail</span>
                                                </button>
                                                <button type="button" id="btnBookWhatsApp" class="kaw-book-btn kaw-btn-whatsapp" data-whatsapp="917006338617">
                                                    <i class="fa-brands fa-whatsapp"></i>
                                                    <span>Book via WhatsApp</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Shape decorations --}}
    <div class="shape-mockup about-shape movingX d-none d-xxl-block" data-bottom="40%" data-right="17%">
        <img src="{{ asset('webassets/img/normal/about-slide-img.png') }}" alt="shape">
    </div>
    <div class="shape-mockup about-rating d-none d-xxl-block" data-bottom="48%" data-right="12%">
        <i class="fa-sharp fa-solid fa-star"></i><span>4.9k</span>
    </div>
    <div class="shape-mockup about-emoji d-none d-xxl-block" data-bottom="45%" data-right="29%">
        <img src="{{ asset('webassets/img/icon/emoji.png') }}" alt="">
    </div>
    <div class="shape-mockup shape1 d-none d-xxl-block" data-bottom="55%" data-right="12%">
        <img src="{{ asset('webassets/img/shape/shape_1.png') }}" alt="shape">
    </div>
    <div class="shape-mockup shape2 d-none d-xl-block" data-bottom="51%" data-right="8%">
        <img src="{{ asset('webassets/img/shape/shape_2.png') }}" alt="shape">
    </div>
    <div class="shape-mockup shape3 d-none d-xxl-block" data-bottom="53%" data-right="5%">
        <img src="{{ asset('webassets/img/shape/shape_3.png') }}" alt="shape">
    </div>
</section>

<!--==============================
Related Tours / Packages Area (Matches Previous Packages Architecture)
==============================-->
<section class="related-packages-section">
    <div class="container">
        <div class="title-area text-center mb-40">
            <span class="sub-title">Explore More</span>
            <h2 class="sec-title">Related Packages & Itineraries</h2>
        </div>
        <div class="row gy-4">
            @php
                $relatedTours = $relatedTours ?? (isset($tour->category_id) ? \App\Models\Tour::where('id', '!=', $tour->id)->where('category_id', $tour->category_id)->take(3)->get() : \App\Models\Tour::where('id', '!=', $tour->id)->take(4)->get());
                if ($relatedTours->isEmpty()) {
                    $relatedTours = \App\Models\Tour::where('id', '!=', $tour->id)->latest()->take(4)->get();
                }
            @endphp
            @foreach($relatedTours as $item)
                <div class="col-xl-3 col-lg-4 col-md-6">

                                <div class="kaw-pkg-card">
                                    @if(isset($item->badge_type) && $item->badge_type === 'deal')
                                        <span class="kaw-pkg-badge kaw-badge-deal">
                                            <i class="ti ti-discount-2"></i> Deal
                                        </span>
                                    @elseif((isset($item->badge_type) && $item->badge_type === 'most_booked') || (isset($loop) && $loop->first))
                                        <span class="kaw-pkg-badge kaw-badge-booked">
                                            <i class="ti ti-thumb-up"></i> Most Booked
                                        </span>
                                    @elseif(!empty($item->discount_percent))
                                        <span class="kaw-pkg-badge kaw-badge-discount">
                                            {{ $item->discount_percent }}% OFF
                                        </span>
                                    @endif

                                    <div class="kaw-pkg-img-wrap">
                                        <a href="{{ route('tour.details', $item->slug) }}" class="kaw-pkg-img-link" aria-label="{{ $item->title }}">
                                            <img src="{{ asset('storage/' . ($item->image ?? $item->banner_image)) }}" alt="{{ $item->title }}" class="kaw-pkg-img" loading="lazy">
                                        </a>
                                        @if(isset($item->gallery_count) && $item->gallery_count > 1)
                                        <button class="kaw-pkg-arrow kaw-pkg-arrow-prev" aria-label="Previous"><i class="ti ti-chevron-left"></i></button>
                                        <button class="kaw-pkg-arrow kaw-pkg-arrow-next" aria-label="Next"><i class="ti ti-chevron-right"></i></button>
                                        @endif
                                    </div>

                                    <div class="kaw-pkg-body">
                                        <div class="kaw-pkg-meta-top">
                                            <h3 class="kaw-pkg-title">
                                                <a href="{{ route('tour.details', $item->slug) }}">{{ $item->title }}</a>
                                            </h3>
                                            <p class="kaw-pkg-subtitle">
                                                @if(isset($item->state->name))
                                                    {{ ucwords($item->state->name ?? 'Kashmir') }} Package
                                                @elseif(isset($item->category->name))
                                                    {{ $item->category->name }}
                                                @else
                                                    Luxury Tour Package
                                                @endif
                                                @if(isset($item->duration) && $item->duration > 0)
                                                    • {{ $item->duration > 1 ? ($item->duration - 1) . 'N/' . $item->duration . 'D' : $item->duration . ' Days' }}
                                                @endif
                                            </p>
                                            
                                        </div>

                                        {{-- Specs Row: Exact replica of Card Two --}}
                                        <div class="kaw-pkg-spec-row">
                                            <div class="kaw-spec-item kaw-spec-price">
                                                <i class="fa-solid fa-tag kaw-spec-icon"></i>
                                                <span class="kaw-spec-from">from</span>
                                                <span class="kaw-spec-amount">{{ str_replace('.00', '', $item->formatted_price ?? ('₹' . number_format($item->price ?? 0))) }}</span>
                                            </div>
                                            <div class="kaw-spec-item kaw-spec-code">
                                                <i class="fa-solid fa-plane-departure kaw-spec-icon"></i>
                                                <span class="kaw-spec-dest">
                                                    {{ strtoupper($item->destination->name ?? $item->state->name ?? 'KASHMIR') }}
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Bottom Action Row: Pill Button + Circular Heart Button --}}
                                        <div class="kaw-pkg-action-row">
                                            <a href="{{ route('tour.details', $item->slug) }}" class="kaw-pkg-action-btn">
                                                <span>View Details</span>
                                            </a>
                                            <a href="https://api.whatsapp.com/send?phone=917006338617&text={{ urlencode('Hi LoveLink, I would like to inquire about: ' . $item->title) }}" 
                                               target="_blank" 
                                               class="kaw-pkg-heart-btn kaw-pkg-wa-btn" title="Chat on WhatsApp" target="_blank"><i class="fa-brands fa-whatsapp"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
    
                </div>
            @endforeach
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const navCol = document.querySelector('.kz-tour-nav-col');
    const navList = document.getElementById('tourScrollspyNav');
    const navLinks = Array.from(document.querySelectorAll('.kz-nav-link'));
    const sections = Array.from(document.querySelectorAll('.kz-detail-section-card'));
    let glider = navList ? navList.querySelector('.kz-tour-glider') : null;

    if (!navList || !navLinks.length || !sections.length) return;

    if (!glider) {
        glider = document.createElement('span');
        glider.className = 'kz-tour-glider';
        glider.setAttribute('aria-hidden', 'true');
        navList.insertBefore(glider, navList.firstChild);
    }

    let activeLink = navLinks.find(l => l.classList.contains('active')) || navLinks[0];
    let isClickScrolling = false;
    let clickScrollTimer = null;
    let clickScrollTargetY = null;

    function releaseClickScrollLock() {
        isClickScrolling = false;
        clickScrollTargetY = null;
        if (clickScrollTimer) {
            clearTimeout(clickScrollTimer);
            clickScrollTimer = null;
        }
    }

    // Cancel programmatic scroll lock immediately if the user manually touches/wheels
    ['wheel', 'touchstart'].forEach(function (evt) {
        window.addEventListener(evt, function () {
            if (isClickScrolling) releaseClickScrollLock();
        }, { passive: true });
    });

    // Accurate Header Offset Sync (measure fixed .kaw-hdr-sticky bar so sticky tabs always clear it)
    function getFixedHeaderHeight() {
        const stickyBar = document.querySelector('.kaw-hdr-sticky') || document.querySelector('.kaw-hdr');
        if (!stickyBar) return 0;
        const pos = window.getComputedStyle(stickyBar).position;
        const hdr = stickyBar.closest('.kaw-hdr');
        if (hdr && hdr.classList.contains('nav-hidden') && pos !== 'fixed') return 0;
        if (pos === 'fixed' || pos === 'sticky') {
            const rect = stickyBar.getBoundingClientRect();
            return rect.bottom > 0 ? Math.round(rect.bottom) : 0;
        }
        return 0;
    }

    function updateMobileHeaderOffset() {
        if (!navCol) return;
        const fixedHeaderHeight = getFixedHeaderHeight();
        if (window.innerWidth < 992) {
            navCol.style.setProperty('top', fixedHeaderHeight + 'px', 'important');
        } else {
            navCol.style.setProperty('top', Math.max(24, fixedHeaderHeight + 16) + 'px', 'important');
        }
    }

    // Accurate Glider Positioning using stable offsetParent coordinates (zero scroll jitter)
    function positionTourGlider(targetLink, immediate) {
        if (!navList || !glider || !targetLink) return;

        let targetTop, targetLeft;
        if (targetLink.offsetParent === navList) {
            targetTop = Math.round(targetLink.offsetTop);
            targetLeft = Math.round(targetLink.offsetLeft);
        } else {
            const listRect = navList.getBoundingClientRect();
            const linkRect = targetLink.getBoundingClientRect();
            targetTop = Math.round(linkRect.top - listRect.top + navList.scrollTop);
            targetLeft = Math.round(linkRect.left - listRect.left + navList.scrollLeft);
        }
        const targetWidth = Math.round(targetLink.offsetWidth || targetLink.getBoundingClientRect().width);
        const targetHeight = Math.round(targetLink.offsetHeight || targetLink.getBoundingClientRect().height);

        glider.style.opacity = '1';

        if (immediate || typeof gsap === 'undefined') {
            if (typeof gsap !== 'undefined') gsap.killTweensOf(glider);
            glider.style.setProperty('transition', 'none', 'important');
            glider.style.setProperty('top', targetTop + 'px', 'important');
            glider.style.setProperty('left', targetLeft + 'px', 'important');
            glider.style.setProperty('width', targetWidth + 'px', 'important');
            glider.style.setProperty('height', targetHeight + 'px', 'important');
            glider.style.setProperty('transform', 'none', 'important');
            glider._currTop = targetTop;
            glider._currLeft = targetLeft;
            glider._currWidth = targetWidth;
            glider._currHeight = targetHeight;
            return;
        }

        const currentTop = glider._currTop !== undefined ? glider._currTop : (parseInt(glider.style.top) || targetTop);
        const currentLeft = glider._currLeft !== undefined ? glider._currLeft : (parseInt(glider.style.left) || targetLeft);
        const currentWidth = glider._currWidth !== undefined ? glider._currWidth : (parseInt(glider.style.width) || targetWidth);
        const currentHeight = glider._currHeight !== undefined ? glider._currHeight : (parseInt(glider.style.height) || targetHeight);

        if (Math.abs(currentTop - targetTop) < 2 && Math.abs(currentLeft - targetLeft) < 2 && Math.abs(currentWidth - targetWidth) < 2 && Math.abs(currentHeight - targetHeight) < 2) {
            glider.style.setProperty('top', targetTop + 'px', 'important');
            glider.style.setProperty('left', targetLeft + 'px', 'important');
            glider.style.setProperty('width', targetWidth + 'px', 'important');
            glider.style.setProperty('height', targetHeight + 'px', 'important');
            return;
        }

        glider._currTop = targetTop;
        glider._currLeft = targetLeft;
        glider._currWidth = targetWidth;
        glider._currHeight = targetHeight;

        gsap.killTweensOf(glider);
        glider.style.removeProperty('transition');

        gsap.to(glider, {
            top: targetTop,
            left: targetLeft,
            width: targetWidth,
            height: targetHeight,
            duration: 0.32,
            ease: "power3.out",
            overwrite: "auto",
            onComplete: function () {
                glider.style.setProperty('top', targetTop + 'px', 'important');
                glider.style.setProperty('left', targetLeft + 'px', 'important');
                glider.style.setProperty('width', targetWidth + 'px', 'important');
                glider.style.setProperty('height', targetHeight + 'px', 'important');
                glider.style.setProperty('transform', 'none', 'important');
            }
        });
    }

    function setActiveTab(newLink, immediate) {
        if (!newLink || newLink === activeLink) return;
        navLinks.forEach(function (l) { l.classList.remove('active'); });
        newLink.classList.add('active');
        activeLink = newLink;

        positionTourGlider(newLink, immediate);

        if (window.innerWidth < 992 && navList) {
            // Smoothly center the active tab in the horizontal scroll track
            const listWidth = navList.clientWidth;
            const linkLeft = newLink.offsetLeft;
            const linkWidth = newLink.offsetWidth;
            const targetScrollLeft = Math.max(0, linkLeft - (listWidth / 2) + (linkWidth / 2));
            navList.scrollTo({
                left: targetScrollLeft,
                behavior: immediate ? 'auto' : 'smooth'
            });
        }
    }

    // Click navigation handler (locks ScrollSpy during smooth scroll to prevent intermediate flicker)
    navLinks.forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target') || (this.getAttribute('href') || '').replace('#', '');
            const targetEl = document.getElementById(targetId);
            if (targetEl) {
                const isMobile = window.innerWidth < 992;
                const fixedHeaderHeight = getFixedHeaderHeight();
                const headerOffset = isMobile ? (fixedHeaderHeight + 58) : (fixedHeaderHeight + 20);
                const elementTop = targetEl.getBoundingClientRect().top + window.pageYOffset;
                const offsetPosition = Math.max(0, elementTop - headerOffset);

                // Lock scrollspy so intermediate sections do not hijack active tab mid-scroll
                releaseClickScrollLock();
                isClickScrolling = true;
                clickScrollTargetY = offsetPosition;
                clickScrollTimer = setTimeout(releaseClickScrollLock, 950);

                setActiveTab(link, false);

                if (window.lenis && typeof window.lenis.scrollTo === 'function') {
                    window.lenis.scrollTo(offsetPosition, {
                        duration: 0.75,
                        onComplete: releaseClickScrollLock
                    });
                } else {
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    // ScrollSpy continuous detection
    let isTicking = false;
    function highlightActiveTab() {
        updateMobileHeaderOffset();
        if (isClickScrolling) {
            // If native scroll reached destination, release lock cleanly
            if ((!window.lenis || typeof window.lenis.scrollTo !== 'function') && clickScrollTargetY !== null) {
                const maxScroll = Math.max(0, document.documentElement.scrollHeight - window.innerHeight);
                const clampedTarget = Math.min(clickScrollTargetY, maxScroll);
                if (Math.abs(window.pageYOffset - clampedTarget) <= 4) {
                    releaseClickScrollLock();
                }
            }
            isTicking = false;
            return;
        }
        const isMobile = window.innerWidth < 992;
        const threshold = isMobile ? 80 : 160;
        let currentSectionId = '';

        for (let i = 0; i < sections.length; i++) {
            const rect = sections[i].getBoundingClientRect();
            if (rect.top <= threshold && rect.bottom > threshold) {
                currentSectionId = sections[i].getAttribute('id');
                break;
            }
        }

        if ((window.innerHeight + window.pageYOffset) >= (document.documentElement.scrollHeight - 100)) {
            currentSectionId = sections[sections.length - 1].getAttribute('id');
        } else if (!currentSectionId && sections.length > 0) {
            if (sections[0].getBoundingClientRect().top > threshold) {
                currentSectionId = sections[0].getAttribute('id');
            }
        }

        if (currentSectionId) {
            const targetLink = navLinks.find(link => {
                const lt = link.getAttribute('data-target') || (link.getAttribute('href') || '').replace('#', '');
                return lt === currentSectionId;
            });
            if (targetLink && targetLink !== activeLink) {
                setActiveTab(targetLink, false);
            }
        }
        isTicking = false;
    }

    function onScroll() {
        if (!isTicking) {
            window.requestAnimationFrame(highlightActiveTab);
            isTicking = true;
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    if (window.lenis && typeof window.lenis.on === 'function') {
        window.lenis.on('scroll', onScroll);
    }
    window.addEventListener('resize', function () {
        updateMobileHeaderOffset();
        if (activeLink) positionTourGlider(activeLink, true);
    });

    updateMobileHeaderOffset();
    setTimeout(function () {
        if (activeLink) positionTourGlider(activeLink, true);
    }, 150);
});
</script>
@endsection
