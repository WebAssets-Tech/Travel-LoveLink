@extends('frontend.layouts.app')

@section('page_title', 'Luxury Cabs & Car Rentals')
@section('page_meta')  
{!! generateMetaTagsSimple('Cabs', $setting) !!} 
@endsection 

@section('content')

@php
    $cabsIndexRoute = Route::has('home.cabs') ? route('home.cabs') : url('/cabs');
    $contactRoute   = Route::has('home.contact') ? route('home.contact') : url('/contact');
    $phoneNumber    = $setting->phone ?? '+91 7006338617';
    $phoneClean     = preg_replace('/[^0-9+]/', '', $phoneNumber);
    if (empty($phoneClean)) { $phoneClean = '+917006338617'; }
    $cabHeroBg      = getImageByType('cabs', $setting);
@endphp

<!--================================================================
    KZ LUXURY CABS DIRECTORY DESIGN SYSTEM (SCOPED CSS)
    Colors: Royal Navy (#0B3D91), Dark Navy (#072355), Gold (#ddab43)
=================================================================-->
<!--==============================
    1. CINEMATIC HERO BANNER
==============================-->
<section class="kz-cabs-hero" style="background: linear-gradient(135deg, rgba(7, 35, 85, 0.88) 0%, rgba(11, 61, 145, 0.82) 100%), url('{{ $cabHeroBg }}') center/cover no-repeat !important;">
    <div class="container text-center text-md-start">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="kz-cabs-breadcrumb">
                    <a href="{{ url('/') }}"><i class="fa-solid fa-house"></i> Home</a>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span class="active-crumb">Luxury Cabs & Rentals</span>
                </div>
                <div class="kz-cabs-eyebrow">
                    <i class="fa-solid fa-car-side"></i> Premium Fleet & Chauffeurs
                </div>
                <h1 class="kz-cabs-title">Luxury Cabs & Travel Rentals</h1>
                <p class="kz-cabs-subtitle">
                    Experience effortless, sanitized, and comfortable intercity travels, airport transfers, and sightseeing tours with verified local chauffeurs.
                </p>
            </div>
            <div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
                <a href="https://wa.me/{{ $phoneClean }}?text={{ urlencode('Hi Love Link, I want to book a cab.') }}" target="_blank" class="kz-support-btn d-inline-flex px-4 py-3">
                    <i class="fa-brands fa-whatsapp fs-5"></i> Instant Cab Booking
                </a>
            </div>
        </div>
    </div>
</section>

<!--==============================
    2. DIRECTORY MAIN SECTION
==============================-->
<section class="kz-cabs-page">
    <div class="container">
        <!-- Toolbar: Search + Grid/List Controls -->
        <div class="kz-cab-toolbar">
            <div class="row g-3 align-items-center justify-content-between">
                <!-- Search Form -->
                <div class="col-md-5 col-12">
                    <form class="kz-cab-search-form" method="GET" action="{{ $cabsIndexRoute }}">
                        <input type="text" name="search" class="kz-cab-search-input" placeholder="Search cabs, sedans, SUVs, locations..." value="{{ $search ?? '' }}">
                        <button type="submit" class="kz-cab-search-btn" aria-label="Search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>

                <!-- Right Side: View Toggles & Status -->
                <div class="col-md-auto col-12 d-flex align-items-center justify-content-between gap-3">
                    <span class="text-muted small fw-semibold">
                        Showing <strong>{{ $cabs->count() }}</strong> Cabs Available
                    </span>

                    <div class="kz-view-toggle nav" role="tablist">
                        <button class="kz-view-btn active" id="tab-cabs-grid-btn" data-bs-toggle="tab" data-bs-target="#tab-cabs-grid" role="tab" aria-controls="tab-cabs-grid" aria-selected="true" title="Grid View">
                            <i class="fa-solid fa-grid-2"></i>
                        </button>
                        <button class="kz-view-btn" id="tab-cabs-list-btn" data-bs-toggle="tab" data-bs-target="#tab-cabs-list" role="tab" aria-controls="tab-cabs-list" aria-selected="false" title="List View">
                            <i class="fa-solid fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Category Filter Pills -->
        @if(isset($cabtypes) && count($cabtypes) > 0)
        <div class="d-flex flex-wrap align-items-center gap-2 mb-3 pb-2 border-bottom">
            <span class="text-muted small fw-bold me-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.05em;"><i class="fa-solid fa-filter me-1 text-primary"></i> Category:</span>
            <a href="{{ $cabsIndexRoute }}" class="badge rounded-pill px-3 py-2 text-decoration-none {{ empty($search) ? 'bg-primary text-white' : 'bg-light text-dark border' }}" style="font-size: 11.5px; transition: all 0.2s;">All Cabs</a>
            @foreach($cabtypes as $type)
            <a href="{{ $cabsIndexRoute }}?search={{ urlencode($type->cab_type) }}" class="badge rounded-pill px-3 py-2 text-decoration-none {{ ($search ?? '') === $type->cab_type ? 'bg-primary text-white' : 'bg-light text-dark border' }}" style="font-size: 11.5px; transition: all 0.2s;">
                {{ $type->cab_type }} <span class="opacity-75">({{ $type->count }})</span>
            </a>
            @endforeach
        </div>
        @endif

        <div class="row">
            <!-- Main Content Area: 3 Cabs Per Row -->
            <div class="col-12">
                <div class="tab-content" id="kzCabsTabContent">
                    @if ($cabs->count() > 0)
                        <!-- GRID VIEW TAB -->
                        <div class="tab-pane fade active show" id="tab-cabs-grid" role="tabpanel" aria-labelledby="tab-cabs-grid-btn">
                            <div class="row g-3">
                                @foreach ($cabs as $cab)
                                @php
                                    $cabDetailsUrl = route('home.cabdetails', $cab->slug);
                                    $cabWaMsg      = urlencode("Hi Love Link, I would like to book the cab: {$cab->name} ({$cab->location}). Please share rate & availability.");
                                @endphp
                                <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                                    <div class="kz-cab-card">
                                        <!-- Vehicle Image -->
                                        <div class="kz-cab-media">
                                            <a href="{{ $cabDetailsUrl }}">
                                                <img src="{{ asset('storage/' . $cab->image) }}" alt="{{ $cab->name }}">
                                            </a>
                                            <div class="kz-cab-overlay"></div>
                                            
                                            <!-- Type Tag -->
                                            <span class="kz-cab-type-badge">
                                                <i class="fa-solid fa-car"></i> {{ $cab->cab_type ?? 'Luxury Cab' }}
                                            </span>

                                            <!-- Location Badge -->
                                            <span class="kz-cab-badge-loc">
                                                <i class="fa-solid fa-location-dot"></i> {{ $cab->location }}
                                            </span>
                                        </div>

                                        <!-- Content -->
                                        <div class="kz-cab-content">
                                            <h3 class="kz-cab-name">
                                                <a href="{{ $cabDetailsUrl }}">{{ $cab->name }}</a>
                                            </h3>

                                            <p class="kz-cab-desc">
                                                {{ Str::limit(strip_tags($cab->short_description), 75) }}
                                            </p>

                                            <!-- Quick Specs -->
                                            <div class="kz-cab-specs-row">
                                                <div class="kz-cab-spec-item" title="Capacity">
                                                    <i class="fa-solid fa-users"></i>
                                                    <span>{{ $cab->seating_capacity ?? '4-6' }} Seats</span>
                                                </div>
                                                <div class="kz-cab-spec-item" title="AC Available">
                                                    <i class="fa-solid fa-snowflake"></i>
                                                    <span>AC / Heater</span>
                                                </div>
                                                <div class="kz-cab-spec-item" title="Driver">
                                                    <i class="fa-solid fa-id-card"></i>
                                                    <span>Chauffeur</span>
                                                </div>
                                            </div>

                                            <!-- Dual Actions -->
                                            <div class="kz-cab-actions">
                                                <a href="{{ $cabDetailsUrl }}" class="kz-cab-btn-details">
                                                    <span>View Details</span>
                                                    <i class="fa-solid fa-arrow-right-long"></i>
                                                </a>
                                                <a href="https://wa.me/{{ $phoneClean }}?text={{ $cabWaMsg }}" target="_blank" class="kz-cab-btn-wa" title="Book via WhatsApp">
                                                    <i class="fa-brands fa-whatsapp"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- LIST VIEW TAB -->
                        <div class="tab-pane fade" id="tab-cabs-list" role="tabpanel" aria-labelledby="tab-cabs-list-btn">
                            <div class="row">
                                @foreach ($cabs as $cab)
                                @php
                                    $cabDetailsUrl = route('home.cabdetails', $cab->slug);
                                    $cabWaMsg      = urlencode("Hi Love Link, I would like to book the cab: {$cab->name} ({$cab->location}). Please share rate & availability.");
                                @endphp
                                <div class="col-12">
                                    <div class="kz-cab-card-list">
                                        <!-- Vehicle Image -->
                                        <div class="kz-cab-media">
                                            <a href="{{ $cabDetailsUrl }}">
                                                <img src="{{ asset('storage/' . $cab->image) }}" alt="{{ $cab->name }}">
                                            </a>
                                            <div class="kz-cab-overlay"></div>
                                            
                                            <span class="kz-cab-type-badge">
                                                <i class="fa-solid fa-car"></i> {{ $cab->cab_type ?? 'Luxury Cab' }}
                                            </span>

                                            <span class="kz-cab-badge-loc">
                                                <i class="fa-solid fa-location-dot"></i> {{ $cab->location }}
                                            </span>
                                        </div>

                                        <!-- Content -->
                                        <div class="kz-cab-content">
                                            <h3 class="kz-cab-name">
                                                <a href="{{ $cabDetailsUrl }}">{{ $cab->name }}</a>
                                            </h3>

                                            <p class="kz-cab-desc">
                                                {{ Str::limit(strip_tags($cab->short_description), 130) }}
                                            </p>

                                            <!-- Quick Specs -->
                                            <div class="kz-cab-specs-row mb-3" style="max-width: 460px;">
                                                <div class="kz-cab-spec-item">
                                                    <i class="fa-solid fa-users"></i>
                                                    <span>{{ $cab->seating_capacity ?? '4-6' }} Seater</span>
                                                </div>
                                                <div class="kz-cab-spec-item">
                                                    <i class="fa-solid fa-snowflake"></i>
                                                    <span>AC Equipped</span>
                                                </div>
                                                <div class="kz-cab-spec-item">
                                                    <i class="fa-solid fa-shield-check"></i>
                                                    <span>Certified Driver</span>
                                                </div>
                                            </div>

                                            <!-- Actions -->
                                            <div class="kz-cab-actions">
                                                <a href="{{ $cabDetailsUrl }}" class="kz-cab-btn-details">
                                                    <span>View Details & Rates</span>
                                                    <i class="fa-solid fa-arrow-right-long"></i>
                                                </a>
                                                <a href="https://wa.me/{{ $phoneClean }}?text={{ $cabWaMsg }}" target="_blank" class="kz-cab-btn-wa" title="Book via WhatsApp">
                                                    <i class="fa-brands fa-whatsapp"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <!-- EMPTY STATE -->
                        <div class="kz-empty-state">
                            <div class="kz-empty-icon">
                                <i class="fa-solid fa-car"></i>
                            </div>
                            <h3 class="kz-empty-title">No Cabs Found</h3>
                            <p class="kz-empty-text">We couldn't find any vehicles matching your search criteria. Try a different query or explore our full fleet.</p>
                            <a href="{{ $cabsIndexRoute }}" class="kz-cab-btn-details d-inline-flex px-4">
                                <i class="fa-solid fa-rotate-left"></i> View All Cabs
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Pagination Links -->
                <div class="kz-pagination-wrap">
                    {{ $cabs->links() }}
                </div>
            </div>
        </div>

        <!-- Bottom Assistance Cards Banner -->
        <div class="row g-3 mt-4">
            <!-- Card 1: Instant Dispatch -->
            <div class="col-md-6 col-12">
                <div class="kz-sidebar-box h-100 p-4 rounded-4 d-flex flex-column" style="border: 1.5px solid rgba(221, 171, 67, 0.4); background: linear-gradient(135deg, #ffffff 0%, #fefcf8 100%); box-shadow: 0 8px 24px rgba(11,61,145,0.06);">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="kz-support-icon" style="background: rgba(221, 171, 67, 0.15); width: 44px; height: 44px; min-width: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #b8860b; margin: 0;">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <div>
                            <div class="small fw-bold text-uppercase" style="color: #b8860b; letter-spacing: 0.08em; font-size: 10.5px; margin-bottom: 2px;">Instant Dispatch</div>
                            <h4 class="kz-sidebar-title mb-0" style="font-size: 17px; font-weight: 700; color: #072355;">Book a Private Cab in 2 Minutes</h4>
                        </div>
                    </div>
                    <p class="text-muted small mb-3" style="font-size: 12.5px; line-height: 1.6; text-align: justify; text-justify: inter-word;">
                        Direct coordination with licensed mountain drivers for airport transfers, Gulmarg, Pahalgam, and Ladakh circuits.
                    </p>
                    <div class="mt-auto pt-2 d-flex flex-wrap gap-2">
                        <a href="https://wa.me/{{ $phoneClean }}?text={{ urlencode('Hi Love Link, I would like to book a cab.') }}" target="_blank" class="kz-cab-btn-details flex-grow-1 text-center py-2" style="background: #25D366; box-shadow: 0 4px 14px rgba(37, 211, 102, 0.35); font-size: 12.5px; color: #ffffff;">
                            <i class="fa-brands fa-whatsapp fs-6 me-1"></i> <span>WhatsApp Booking</span>
                        </a>
                        <a href="tel:{{ $phoneClean }}" class="kz-cab-btn-details flex-grow-1 text-center py-2" style="background: #0B3D91; font-size: 12.5px; color: #ffffff;">
                            <i class="fa-solid fa-phone me-1"></i> <span>Call {{ $phoneNumber }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 2: 24/7 Dedicated Support -->
            <div class="col-md-6 col-12">
                <div class="kz-cab-support-card h-100 p-4 rounded-4 d-flex flex-column" style="background: linear-gradient(135deg, #072355 0%, #0B3D91 100%); color: #ffffff; box-shadow: 0 8px 24px rgba(11,61,145,0.15); text-align: left;">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="kz-support-icon" style="background: rgba(255,255,255,0.15); width: 44px; height: 44px; min-width: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #ddab43; margin: 0;">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <div>
                            <div class="small fw-bold text-uppercase" style="color: #ddab43; letter-spacing: 0.08em; font-size: 10.5px; margin-bottom: 2px;">Assistance Desk</div>
                            <h4 class="kz-support-title mb-0" style="color: #ffffff; font-size: 17px; font-weight: 700;">24/7 Dedicated Support</h4>
                        </div>
                    </div>
                    <p class="small mb-3" style="color: rgba(255,255,255,0.85); font-size: 12.5px; line-height: 1.6; text-align: justify; text-justify: inter-word;">
                        Need custom multi-day cab packages across Kashmir, Sonamarg, or Zojila Pass? Our dispatch desk is active around the clock.
                    </p>
                    <div class="mt-auto pt-2 d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <a href="tel:{{ $phoneClean }}" class="kz-cab-btn-details flex-grow-1 text-center py-2" style="background: rgba(221, 171, 67, 0.2); border: 1.5px solid #ddab43; color: #ddab43; font-size: 12.5px; font-weight: 700;">
                            <i class="fa-solid fa-phone-volume me-1"></i> {{ $phoneNumber }}
                        </a>
                        <a href="{{ $contactRoute }}" class="kz-cab-btn-details flex-grow-1 text-center py-2" style="background: #ffffff; color: #072355; font-size: 12.5px; font-weight: 700;">
                            <span>Inquire Now</span> <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
