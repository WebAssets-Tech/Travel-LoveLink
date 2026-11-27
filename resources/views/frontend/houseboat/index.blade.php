@extends('frontend.layouts.app')

@section('page_title', 'Heritage & Luxury Houseboats')
@section('page_meta')
{!! generateMetaTagsSimple('Houseboats', $setting) !!}
@endsection

@section('page_css')
@endsection

@section('content')

@php
    $houseboatsListRoute = Route::has('home.houseboats') ? route('home.houseboats') : url()->current();
    $contactRoute        = Route::has('home.contact') ? route('home.contact') : url('contact');
    $phoneNumber         = $setting->phone ?? '+91 7006338617';
    $phoneRaw            = preg_replace('/[^\d]/', '', $phoneNumber);
    if (empty($phoneRaw)) $phoneRaw = '917006338617';

    $houseboatHeroBg = getImageByType('hotels', $setting);
@endphp

<!--==============================
1. CINEMATIC HERO / BREADCRUMB
==============================-->
<section class="kz-hotels-hero" {!! breadcrumbBgAttrs($houseboatHeroBg, $setting ?? null, false, true) !!}>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-10">
                <div class="kz-hotels-breadcrumb">
                    <a href="{{ url('/') }}"><i class="fas fa-home"></i> Home</a>
                    <i class="fas fa-chevron-right"></i>
                    <span class="active-crumb">Houseboats</span>
                </div>

                <div class="kz-hotels-eyebrow">
                    <i class="fas fa-ship"></i> Dal &amp; Nigeen Lake Stays
                </div>

                <h1 class="kz-hotels-title">Heritage &amp; Luxury Houseboats</h1>
                <p class="kz-hotels-subtitle">
                    Experience authentic Kashmiri cedarwood houseboats, serene lake sunrises, shikara rides, and royal hospitality on Dal and Nigeen Lakes.
                </p>
            </div>
        </div>
    </div>
</section>

<!--==============================
2. HOUSEBOATS DIRECTORY & FILTERING
==============================-->
<section class="kz-hotels-page">
    <div class="container">

        <div class="kz-hotel-toolbar">
            <div class="row justify-content-between align-items-center g-3">
                <div class="col-md-5 col-sm-12">
                    <form method="GET" action="{{ $houseboatsListRoute }}" class="kz-hotel-search-form">
                        <input type="text"
                               name="search"
                               class="kz-hotel-search-input"
                               placeholder="Search houseboats by name or location..."
                               value="{{ request('search') ?? ($search ?? '') }}">
                        <button type="submit" class="kz-hotel-search-btn" title="Search">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <div class="col-md-auto col-sm-12 d-flex align-items-center justify-content-between gap-3">
                    <span class="small text-muted d-none d-sm-inline">
                        Showing <strong>{{ $houseboats->count() }}</strong> @if(method_exists($houseboats, 'total')) of {{ $houseboats->total() }} @endif houseboats
                    </span>

                    <div class="kz-view-toggle nav" role="tablist">
                        <button class="kz-view-btn active"
                                id="tab-houseboat-grid-btn"
                                data-bs-toggle="tab"
                                data-bs-target="#tab-houseboat-grid"
                                type="button"
                                role="tab"
                                aria-controls="tab-houseboat-grid"
                                aria-selected="true"
                                title="Grid View">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button class="kz-view-btn"
                                id="tab-houseboat-list-btn"
                                data-bs-toggle="tab"
                                data-bs-target="#tab-houseboat-list"
                                type="button"
                                role="tab"
                                aria-controls="tab-houseboat-list"
                                aria-selected="false"
                                title="List View">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if((!empty($houseboatcategories) && count($houseboatcategories) > 0) || (!empty($houseboatlocations) && count($houseboatlocations) > 0))
        <div class="d-flex flex-wrap align-items-center gap-2 mb-3 pb-2 border-bottom">
            <span class="text-muted small fw-bold me-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.05em;"><i class="fas fa-filter me-1 text-primary"></i> Stays:</span>
            <a href="{{ route('home.houseboats') }}" class="badge rounded-pill px-3 py-2 text-decoration-none {{ empty($search) ? 'bg-primary text-white' : 'bg-light text-dark border' }}" style="font-size: 11.5px;">All Houseboats</a>
            @if(!empty($houseboatcategories))
                @foreach($houseboatcategories as $cat)
                @if(!empty($cat->category))
                <a href="{{ route('home.houseboats', ['search' => $cat->category]) }}" class="badge rounded-pill px-3 py-2 text-decoration-none {{ ($search ?? '') === $cat->category ? 'bg-primary text-white' : 'bg-light text-dark border' }}" style="font-size: 11.5px;">
                    {{ $cat->category }} <span class="opacity-75">({{ $cat->count }})</span>
                </a>
                @endif
                @endforeach
            @endif
            @if(!empty($houseboatlocations))
                @foreach($houseboatlocations->take(4) as $loc)
                @if(!empty($loc->location))
                <a href="{{ route('home.houseboats', ['search' => $loc->location]) }}" class="badge rounded-pill px-3 py-2 text-decoration-none {{ ($search ?? '') === $loc->location ? 'bg-primary text-white' : 'bg-light text-dark border' }}" style="font-size: 11.5px;">
                    <i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $loc->location }}
                </a>
                @endif
                @endforeach
            @endif
        </div>
        @endif

        <div class="row g-3">
            <div class="col-12">
                <div class="tab-content" id="houseboatTabContent">

                    @if ($houseboats->count() > 0)
                        <!-- Tab 1: Grid View -->
                        <div class="tab-pane fade show active" id="tab-houseboat-grid" role="tabpanel" aria-labelledby="tab-houseboat-grid-btn">
                            <div class="row g-3">
                                @foreach ($houseboats as $houseboat)
                                    @php
                                        $rating = (float)($houseboat->star_rating ?? 5);
                                        $detailUrl = route('home.houseboatdetails', $houseboat->slug);
                                        $whatsappBookingUrl = 'https://wa.me/' . $phoneRaw . '?text=' . urlencode('Hi Love Link, I would like to inquire about booking houseboat: ' . $houseboat->name . ' at ' . ($houseboat->location ?? 'Dal Lake, Srinagar'));
                                    @endphp
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                                        <div class="kz-hotel-card">
                                            <div class="kz-hotel-media">
                                                <a href="{{ $detailUrl }}" class="d-block w-100 h-100">
                                                    @if(!empty($houseboat->image))
                                                        <img src="{{ asset('storage/' . $houseboat->image) }}" alt="{{ $houseboat->name }}">
                                                    @else
                                                        <div class="d-flex align-items-center justify-content-center h-100 bg-light text-muted">
                                                            <i class="fas fa-ship fa-2x"></i>
                                                        </div>
                                                    @endif
                                                </a>
                                                <span class="kz-hotel-badge-tag">{{ $houseboat->type ?? 'Verified Houseboat' }}</span>
                                                <span class="kz-hotel-star-pill">
                                                    <i class="fas fa-star text-warning"></i> {{ $rating }} Star
                                                </span>
                                            </div>

                                            <div class="kz-hotel-body">
                                                <div class="kz-hotel-location">
                                                    <i class="fas fa-map-marker-alt"></i> {{ $houseboat->location ?? 'Dal Lake, Srinagar' }}
                                                </div>

                                                <h3 class="kz-hotel-title">
                                                    <a href="{{ $detailUrl }}">{{ $houseboat->name }}</a>
                                                </h3>

                                                <div class="kz-hotel-rating-row">
                                                    <div class="kz-hotel-stars">
                                                        @for($s = 1; $s <= 5; $s++)
                                                            <i class="fas fa-star {{ $s <= $rating ? '' : 'text-muted opacity-25' }}"></i>
                                                        @endfor
                                                    </div>
                                                    <span class="kz-hotel-rating-text">({{ $rating }}.0 Rating)</span>
                                                </div>

                                                <p class="kz-hotel-desc">
                                                    {{ Str::limit($houseboat->short_description ?? 'Handcrafted cedarwood houseboat with scenic lake views and traditional Kashmiri hospitality.', 75) }}
                                                </p>

                                                <div class="kz-hotel-footer">
                                                    <a href="{{ $whatsappBookingUrl }}" target="_blank" class="kz-hotel-btn-book">
                                                        <i class="fab fa-whatsapp me-1"></i> Book Now
                                                    </a>
                                                    <a href="{{ $detailUrl }}" class="kz-hotel-btn-detail">
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
                        <div class="tab-pane fade" id="tab-houseboat-list" role="tabpanel" aria-labelledby="tab-houseboat-list-btn">
                            <div class="row g-3">
                                @foreach ($houseboats as $houseboat)
                                    @php
                                        $rating = (float)($houseboat->star_rating ?? 5);
                                        $detailUrl = route('home.houseboatdetails', $houseboat->slug);
                                        $whatsappBookingUrl = 'https://wa.me/' . $phoneRaw . '?text=' . urlencode('Hi Love Link, I would like to inquire about booking houseboat: ' . $houseboat->name . ' at ' . ($houseboat->location ?? 'Dal Lake, Srinagar'));
                                    @endphp
                                    <div class="col-12">
                                        <div class="kz-hotel-card-list">
                                            <div class="kz-hotel-media">
                                                <a href="{{ $detailUrl }}" class="d-block w-100 h-100">
                                                    @if(!empty($houseboat->image))
                                                        <img src="{{ asset('storage/' . $houseboat->image) }}" alt="{{ $houseboat->name }}">
                                                    @else
                                                        <div class="d-flex align-items-center justify-content-center h-100 bg-light text-muted">
                                                            <i class="fas fa-ship fa-2x"></i>
                                                        </div>
                                                    @endif
                                                </a>
                                                <span class="kz-hotel-badge-tag">{{ $houseboat->type ?? 'Verified Houseboat' }}</span>
                                                <span class="kz-hotel-star-pill">
                                                    <i class="fas fa-star text-warning"></i> {{ $rating }} Star
                                                </span>
                                            </div>

                                            <div class="kz-hotel-body">
                                                <div class="kz-hotel-location">
                                                    <i class="fas fa-map-marker-alt"></i> {{ $houseboat->location ?? 'Dal Lake, Srinagar' }}
                                                </div>

                                                <h3 class="kz-hotel-title">
                                                    <a href="{{ $detailUrl }}">{{ $houseboat->name }}</a>
                                                </h3>

                                                <div class="kz-hotel-rating-row">
                                                    <div class="kz-hotel-stars">
                                                        @for($s = 1; $s <= 5; $s++)
                                                            <i class="fas fa-star {{ $s <= $rating ? '' : 'text-muted opacity-25' }}"></i>
                                                        @endfor
                                                    </div>
                                                    <span class="kz-hotel-rating-text">({{ $rating }}.0 Star Certified Houseboat)</span>
                                                </div>

                                                <p class="kz-hotel-desc">
                                                    {{ Str::limit($houseboat->short_description ?? 'Handcrafted cedarwood houseboat with scenic lake views, shikara transfers, and traditional Kashmiri cuisine.', 150) }}
                                                </p>

                                                <div class="kz-hotel-footer justify-content-start gap-3 mt-auto">
                                                    <a href="{{ $whatsappBookingUrl }}" target="_blank" class="kz-hotel-btn-book">
                                                        <i class="fab fa-whatsapp me-1 fs-6"></i> Book via WhatsApp
                                                    </a>
                                                    <a href="{{ $detailUrl }}" class="kz-hotel-btn-detail">
                                                        <span>View Deck &amp; Rooms</span>
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
                        <div class="text-center py-5 bg-white rounded-4 border p-4">
                            <i class="fas fa-ship fa-3x text-muted mb-3 opacity-50"></i>
                            <h4 class="fw-bold" style="color:var(--kz-blue);">No Houseboats Found</h4>
                            <p class="text-muted small mb-3">We couldn't find any houseboats matching your search. Please try a different location or keyword.</p>
                            <a href="{{ $houseboatsListRoute }}" class="kz-hotel-btn-book">
                                Clear Search &amp; View All Houseboats
                            </a>
                        </div>
                    @endif

                </div>

                @if ($houseboats->hasPages())
                    <div class="kz-pagination-wrap">
                        {{ $houseboats->links() }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row g-3 mt-4">
            <div class="col-md-6 col-12">
                <div class="p-4 rounded-4 h-100" style="border: 1.5px solid rgba(221, 171, 67, 0.4); background: linear-gradient(135deg, #ffffff 0%, #fefcf8 100%); box-shadow: 0 8px 24px rgba(11,61,145,0.06);">
                    <div class="small fw-bold text-uppercase" style="color: #b8860b; letter-spacing: 0.1em; margin-bottom: 4px;">Direct Booking Assistance</div>
                    <h4 class="mb-2" style="font-size: 18px; font-weight: 700; color: #072355;">Custom Dal &amp; Nigeen Lake Houseboat Deals</h4>
                    <p class="text-muted small mb-3">Speak directly with our local Srinagar concierge for customized room suites, sunset shikara rides, and seasonal houseboat packages.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="https://wa.me/{{ $phoneRaw }}?text={{ urlencode('Hi Love Link, I would like to inquire about houseboat reservations.') }}" target="_blank" class="btn text-white flex-grow-1 text-center py-2 rounded-pill fw-bold" style="background: #25D366; box-shadow: 0 4px 14px rgba(37, 211, 102, 0.35); font-size: 13px;">
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
                            <small style="color: rgba(255,255,255,0.75);">Lake transfers, honeymoon decor &amp; meal plans</small>
                        </div>
                    </div>
                    <p class="small mb-3" style="color: rgba(255,255,255,0.85); font-size: 12.5px;">
                        Looking for verified heritage houseboats with heated suites, carved walnut wood interiors, and authentic Wazwan hospitality?
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
