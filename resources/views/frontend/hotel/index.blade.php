@extends('frontend.layouts.app')

@section('page_title', 'Hotels & Luxury Resorts')
@section('page_meta')  
{!! generateMetaTagsSimple('Hotels', $setting) !!} 
@endsection 

@section('page_css')
@endsection

@section('content')

@php
    $hotelsListRoute = Route::has('hotel.index') ? route('hotel.index') : url()->current();
    $contactRoute    = Route::has('home.contact') ? route('home.contact') : url('contact');
    $phoneNumber     = $setting->phone ?? '+91 7006338617';
    $phoneRaw        = preg_replace('/[^\d]/', '', $phoneNumber);
    if (empty($phoneRaw)) $phoneRaw = '917006338617';

    $hasSidebar = (!empty($hotelcategories) && count($hotelcategories) > 0) || (!empty($hotellocations) && count($hotellocations) > 0);
@endphp

<!--==============================
1. CINEMATIC HERO / BREADCRUMB
==============================-->
<section class="kz-hotels-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-10">
                <!-- Breadcrumb Capsule -->
                <div class="kz-hotels-breadcrumb">
                    <a href="{{ url('/') }}"><i class="fas fa-home"></i> Home</a>
                    <i class="fas fa-chevron-right"></i>
                    <span class="active-crumb">Hotels & Resorts</span>
                </div>

                <!-- Eyebrow -->
                <div class="kz-hotels-eyebrow">
                    <i class="fas fa-hotel"></i> Handpicked Accommodations
                </div>

                <!-- Title & Subtitle -->
                <h1 class="kz-hotels-title">Hotels & Luxury Resorts</h1>
                <p class="kz-hotels-subtitle">
                    Experience world-class Kashmiri hospitality, scenic mountain backdrops, and verified luxury rooms across prime destinations.
                </p>
            </div>
        </div>
    </div>
</section>

<!--==============================
2. HOTELS DIRECTORY & FILTERING
==============================-->
<section class="kz-hotels-page">
    <div class="container">

        <!-- Toolbar (Search & View Toggle) -->
        <div class="kz-hotel-toolbar">
            <div class="row justify-content-between align-items-center g-3">
                
                <!-- Search Input Form -->
                <div class="col-md-5 col-sm-12">
                    <form method="GET" action="{{ $hotelsListRoute }}" class="kz-hotel-search-form">
                        <input type="text" 
                               name="search" 
                               class="kz-hotel-search-input" 
                               placeholder="Search hotels by name or location..." 
                               value="{{ request('search') ?? ($search ?? '') }}">
                        <button type="submit" class="kz-hotel-search-btn" title="Search">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Right Tools: Grid/List View Tabs -->
                <div class="col-md-auto col-sm-12 d-flex align-items-center justify-content-between gap-3">
                    <span class="small text-muted d-none d-sm-inline">
                        Showing <strong>{{ $hotels->count() }}</strong> @if(method_exists($hotels, 'total')) of {{ $hotels->total() }} @endif stays
                    </span>

                    <div class="kz-view-toggle nav" role="tablist">
                        <button class="kz-view-btn active" 
                                id="tab-hotel-grid-btn" 
                                data-bs-toggle="tab" 
                                data-bs-target="#tab-hotel-grid" 
                                type="button" 
                                role="tab" 
                                aria-controls="tab-hotel-grid" 
                                aria-selected="true" 
                                title="Grid View">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button class="kz-view-btn" 
                                id="tab-hotel-list-btn" 
                                data-bs-toggle="tab" 
                                data-bs-target="#tab-hotel-list" 
                                type="button" 
                                role="tab" 
                                aria-controls="tab-hotel-list" 
                                aria-selected="false" 
                                title="List View">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Quick Category & Location Filter Pills -->
        @if((!empty($hotelcategories) && count($hotelcategories) > 0) || (!empty($hotellocations) && count($hotellocations) > 0))
        <div class="d-flex flex-wrap align-items-center gap-2 mb-3 pb-2 border-bottom">
            <span class="text-muted small fw-bold me-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.05em;"><i class="fas fa-filter me-1 text-primary"></i> Stays:</span>
            <a href="{{ route('home.hotels') }}" class="badge rounded-pill px-3 py-2 text-decoration-none {{ empty($search) ? 'bg-primary text-white' : 'bg-light text-dark border' }}" style="font-size: 11.5px;">All Stays</a>
            @if(!empty($hotelcategories))
                @foreach($hotelcategories as $cat)
                <a href="{{ route('home.hotels', ['search' => $cat->category]) }}" class="badge rounded-pill px-3 py-2 text-decoration-none {{ ($search ?? '') === $cat->category ? 'bg-primary text-white' : 'bg-light text-dark border' }}" style="font-size: 11.5px;">
                    {{ $cat->category }} <span class="opacity-75">({{ $cat->count }})</span>
                </a>
                @endforeach
            @endif
            @if(!empty($hotellocations))
                @foreach($hotellocations->take(4) as $loc)
                <a href="{{ route('home.hotels', ['search' => $loc->location]) }}" class="badge rounded-pill px-3 py-2 text-decoration-none {{ ($search ?? '') === $loc->location ? 'bg-primary text-white' : 'bg-light text-dark border' }}" style="font-size: 11.5px;">
                    <i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $loc->location }}
                </a>
                @endforeach
            @endif
        </div>
        @endif

        <!-- Main Content Row: 3 Hotels Per Row -->
        <div class="row g-3">
            <!-- Hotels Listing Column (Full Width, 3 Cards Per Row) -->
            <div class="col-12">
                <div class="tab-content" id="hotelTabContent">
                    
                    @if ($hotels->count() > 0)
                        <!-- Tab 1: Grid View -->
                        <div class="tab-pane fade show active" id="tab-hotel-grid" role="tabpanel" aria-labelledby="tab-hotel-grid-btn">
                            <div class="row g-3">
                                @foreach ($hotels as $hotel)
                                    @php
                                        $hotelRating = (float)($hotel->star_rating ?? 5);
                                        $hotelDetailUrl = route('home.hoteldetails', $hotel->slug);
                                        $whatsappBookingUrl = 'https://wa.me/' . $phoneRaw . '?text=' . urlencode('Hi Love Link, I would like to inquire about booking: ' . $hotel->name . ' in ' . ($hotel->location ?? 'Kashmir'));
                                    @endphp
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                                        <div class="kz-hotel-card">
                                            
                                            <!-- Media Frame -->
                                            <div class="kz-hotel-media">
                                                <a href="{{ $hotelDetailUrl }}" class="d-block w-100 h-100">
                                                    @if(!empty($hotel->image))
                                                        <img src="{{ asset('storage/' . $hotel->image) }}" alt="{{ $hotel->name }}">
                                                    @else
                                                        <div class="d-flex align-items-center justify-content-center h-100 bg-light text-muted">
                                                            <i class="fas fa-hotel fa-2x"></i>
                                                        </div>
                                                    @endif
                                                </a>
                                                <span class="kz-hotel-badge-tag">Verified Stay</span>
                                                <span class="kz-hotel-star-pill">
                                                    <i class="fas fa-star text-warning"></i> {{ $hotelRating }} Star
                                                </span>
                                            </div>

                                            <!-- Content Body -->
                                            <div class="kz-hotel-body">
                                                <div class="kz-hotel-location">
                                                    <i class="fas fa-map-marker-alt"></i> {{ $hotel->location ?? 'Kashmir Valley' }}
                                                </div>

                                                <h3 class="kz-hotel-title">
                                                    <a href="{{ $hotelDetailUrl }}">{{ $hotel->name }}</a>
                                                </h3>

                                                <!-- Star Rating Row -->
                                                <div class="kz-hotel-rating-row">
                                                    <div class="kz-hotel-stars">
                                                        @for($s = 1; $s <= 5; $s++)
                                                            <i class="fas fa-star {{ $s <= $hotelRating ? '' : 'text-muted opacity-25' }}"></i>
                                                        @endfor
                                                    </div>
                                                    <span class="kz-hotel-rating-text">({{ $hotelRating }}.0 Rating)</span>
                                                </div>

                                                <!-- Short Description -->
                                                <p class="kz-hotel-desc">
                                                    {{ Str::limit($hotel->short_description ?? 'Comfortable, premium mountain stay with modern amenities and local hospitality.', 75) }}
                                                </p>

                                                <!-- Action Buttons -->
                                                <div class="kz-hotel-footer">
                                                    <a href="{{ $whatsappBookingUrl }}" target="_blank" class="kz-hotel-btn-book">
                                                        <i class="fab fa-whatsapp me-1"></i> Book Now
                                                    </a>
                                                    <a href="{{ $hotelDetailUrl }}" class="kz-hotel-btn-detail">
                                                        <span>See Details</span>
                                                        <span class="kz-hotel-btn-arrow"><i class="fas fa-arrow-right"></i></span>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Tab 2: List View -->
                        <div class="tab-pane fade" id="tab-hotel-list" role="tabpanel" aria-labelledby="tab-hotel-list-btn">
                            <div class="row g-3">
                                @foreach ($hotels as $hotel)
                                    @php
                                        $hotelRating = (float)($hotel->star_rating ?? 5);
                                        $hotelDetailUrl = route('home.hoteldetails', $hotel->slug);
                                        $whatsappBookingUrl = 'https://wa.me/' . $phoneRaw . '?text=' . urlencode('Hi Love Link, I would like to inquire about booking: ' . $hotel->name . ' in ' . ($hotel->location ?? 'Kashmir'));
                                    @endphp
                                    <div class="col-12">
                                        <div class="kz-hotel-card-list">
                                            
                                            <!-- Media Frame -->
                                            <div class="kz-hotel-media">
                                                <a href="{{ $hotelDetailUrl }}" class="d-block w-100 h-100">
                                                    @if(!empty($hotel->image))
                                                        <img src="{{ asset('storage/' . $hotel->image) }}" alt="{{ $hotel->name }}">
                                                    @else
                                                        <div class="d-flex align-items-center justify-content-center h-100 bg-light text-muted">
                                                            <i class="fas fa-hotel fa-2x"></i>
                                                        </div>
                                                    @endif
                                                </a>
                                                <span class="kz-hotel-badge-tag">Verified Stay</span>
                                                <span class="kz-hotel-star-pill">
                                                    <i class="fas fa-star text-warning"></i> {{ $hotelRating }} Star
                                                </span>
                                            </div>

                                            <!-- Content Body -->
                                            <div class="kz-hotel-body">
                                                <div class="kz-hotel-location">
                                                    <i class="fas fa-map-marker-alt"></i> {{ $hotel->location ?? 'Kashmir Valley' }}
                                                </div>

                                                <h3 class="kz-hotel-title">
                                                    <a href="{{ $hotelDetailUrl }}">{{ $hotel->name }}</a>
                                                </h3>

                                                <!-- Rating Row -->
                                                <div class="kz-hotel-rating-row">
                                                    <div class="kz-hotel-stars">
                                                        @for($s = 1; $s <= 5; $s++)
                                                            <i class="fas fa-star {{ $s <= $hotelRating ? '' : 'text-muted opacity-25' }}"></i>
                                                        @endfor
                                                    </div>
                                                    <span class="kz-hotel-rating-text">({{ $hotelRating }}.0 Star Certified Accommodation)</span>
                                                </div>

                                                <!-- Description -->
                                                <p class="kz-hotel-desc">
                                                    {{ Str::limit($hotel->short_description ?? 'Comfortable, premium mountain stay with modern amenities, round-the-clock room service, and scenic valley views.', 150) }}
                                                </p>

                                                <!-- Action Buttons -->
                                                <div class="kz-hotel-footer justify-content-start gap-3 mt-auto">
                                                    <a href="{{ $whatsappBookingUrl }}" target="_blank" class="kz-hotel-btn-book">
                                                        <i class="fab fa-whatsapp me-1 fs-6"></i> Book via WhatsApp
                                                    </a>
                                                    <a href="{{ $hotelDetailUrl }}" class="kz-hotel-btn-detail">
                                                        <span>View Rooms & Rates</span>
                                                        <span class="kz-hotel-btn-arrow"><i class="fas fa-arrow-right"></i></span>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    @else
                        <!-- Empty State -->
                        <div class="text-center py-5 bg-white rounded-4 border p-4">
                            <i class="fas fa-hotel fa-3x text-muted mb-3 opacity-50"></i>
                            <h4 class="fw-bold" style="color:var(--kz-blue);">No Hotels Found</h4>
                            <p class="text-muted small mb-3">We couldn't find any stays matching your search. Please try a different location or keyword.</p>
                            <a href="{{ $hotelsListRoute }}" class="kz-hotel-btn-book">
                                Clear Search & View All Hotels
                            </a>
                        </div>
                    @endif

                </div>

                <!-- Pagination Links -->
                @if ($hotels->hasPages())
                    <div class="kz-pagination-wrap">
                        {{ $hotels->links() }}
                    </div>
                @endif
            </div>

            </div>
        <!-- Bottom Concierge & Hotel Assistance Banner -->
        <div class="row g-3 mt-4">
            <div class="col-md-6 col-12">
                <div class="p-4 rounded-4 h-100" style="border: 1.5px solid rgba(221, 171, 67, 0.4); background: linear-gradient(135deg, #ffffff 0%, #fefcf8 100%); box-shadow: 0 8px 24px rgba(11,61,145,0.06);">
                    <div class="small fw-bold text-uppercase" style="color: #b8860b; letter-spacing: 0.1em; margin-bottom: 4px;">Direct Booking Assistance</div>
                    <h4 class="mb-2" style="font-size: 18px; font-weight: 700; color: #072355;">Custom Luxury Resort & Houseboat Deals</h4>
                    <p class="text-muted small mb-3">Speak directly with our local Kashmir concierge for customized room upgrades, Dal Lake shikara packages, and exclusive seasonal discounts.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="https://wa.me/{{ $phoneRaw }}?text={{ urlencode('Hi Love Link, I would like to inquire about hotel reservations.') }}" target="_blank" class="btn text-white flex-grow-1 text-center py-2 rounded-pill fw-bold" style="background: #25D366; box-shadow: 0 4px 14px rgba(37, 211, 102, 0.35); font-size: 13px;">
                            <i class="fab fa-whatsapp fs-5 me-1"></i> WhatsApp Concierge
                        </a>
                        <a href="tel:{{ $phoneRaw }}" class="btn text-white flex-grow-1 text-center py-2 rounded-pill fw-bold" style="background: #0B3D91; font-size: 13px;">
                            <i class="fas fa-phone-alt me-1"></i> Call {{ $phoneNumber }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="p-4 rounded-4 h-100" style="background: linear-gradient(135deg, #072355 0%, #0B3D91 100%); color: #ffffff; box-shadow: 0 8px 24px rgba(11,61,145,0.15);">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div style="background: rgba(255,255,255,0.15); width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #ddab43;">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-white" style="font-size: 18px;">24/7 Dedicated Support</h4>
                            <small style="color: rgba(255,255,255,0.75);">Group bookings, transfers & meal plans</small>
                        </div>
                    </div>
                    <p class="small mb-3" style="color: rgba(255,255,255,0.85); font-size: 12.5px;">
                        Need verified stays with heated rooms, mountain views, and genuine Kashmiri hospitality? We ensure a seamless check-in experience.
                    </p>
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="tel:{{ $phoneRaw }}" class="fw-bold text-decoration-none" style="color: #ddab43; font-size: 16px;">
                            <i class="fas fa-phone-volume me-1"></i> {{ $phoneNumber }}
                        </a>
                        <a href="{{ $contactRoute }}" class="btn btn-sm btn-light rounded-pill px-3 fw-bold" style="color: #072355; font-size: 12px;">
                            Inquire Now <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
