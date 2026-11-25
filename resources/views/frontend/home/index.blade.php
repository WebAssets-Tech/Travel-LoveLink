@extends('frontend.layouts.app')
@section('page_title', 'Home')
@section('preload_lcp')
@if(isset($sliders) && $sliders->isNotEmpty())
    <link rel="preload" as="image" href="{{ asset('storage/' . $sliders->first()->image) }}" fetchpriority="high">
@endif
@endsection
@section('page_meta')  
{!! generateMetaTagsSimple('Home',$setting) !!} 
@endsection 

@section('page_css')  
 <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('webassets/css/google-reviews.css') }}">
@endsection 

@section('content')
@php
    $raw_wa_number = !empty($setting->whatsapp) 
        ? $setting->whatsapp 
        : (!empty($setting->phone) 
            ? $setting->phone 
            : (!empty($setting->phone1) 
                ? $setting->phone1 
                : '917006338617'));
    $wa_phone_clean = preg_replace('/[^0-9]/', '', (string)$raw_wa_number);
    if (strlen($wa_phone_clean) === 10) {
        $wa_phone_clean = '91' . $wa_phone_clean;
    }
    if (empty($wa_phone_clean)) {
        $wa_phone_clean = '917006338617';
    }
@endphp

<!--==============================
Hero Area (Slider kept untouched)
==============================-->
<div class="th-hero-wrapper hero-1" id="hero">

    <div class="swiper th-slider hero-slider-1" id="heroSlide1"
        data-slider-options='{"speed":1200,"autoplay":{"delay":5500,"disableOnInteraction":false},"loop":true,"watchSlidesProgress":true,"grabCursor":true}'>

        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
                <div class="swiper-slide">
                    <div class="hero-inner">
                        <div class="th-hero-bg">
                            <img src="{{ asset('storage/' . $slider->image) }}"
                                 alt="{{ $slider->title }}"
                                 class="hero-bg-img"
                                 @if($loop->first)
                                 fetchpriority="high"
                                 loading="eager"
                                 decoding="sync"
                                 @else
                                 loading="lazy"
                                 decoding="async"
                                 @endif
                                 width="1920"
                                 height="900">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="th-swiper-custom">
            <button data-slider-prev="#heroSlide1" class="slider-arrow slider-prev" aria-label="Previous Slide">
                <img src="{{ asset('webassets/img/icon/right-arrow.svg') }}" alt="Previous" width="20" height="20" loading="lazy" decoding="async">
            </button>
            <button data-slider-next="#heroSlide1" class="slider-arrow slider-next" aria-label="Next Slide">
                <img src="{{ asset('webassets/img/icon/left-arrow.svg') }}" alt="Next" width="20" height="20" loading="lazy" decoding="async">
            </button>
        </div>

    </div>

</div>

<!--==============================
Destinations Section
==============================-->
<section class="dst-section position-relative overflow-hidden">
    <div class="dst-vignette"></div>
    <div class="container dst-inner">

        <div class="row align-items-center mb-3">
            <div class="col-lg-8">
                <form class="search-form m-0" method="GET" action="{{ route('home.tour') }}">
                    <div class="kt-search-bar" style="margin-top: 5px;">
                        <i class="fa fa-search kt-s-icon"></i>
                        <input type="text" name="search" placeholder="Enter Your Dream Destination!">
                        <button type="submit" class="kt-s-btn">Search</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 d-flex justify-content-lg-end justify-content-center mt-2 mt-lg-0">
                <div class="dst-toggle-group nav" id="countryTab" role="tablist">
                    <span class="dst-toggle-glider" aria-hidden="true"></span>
                    @foreach($countries as $index => $country)
                    <button class="dst-toggle-btn dst-country-tab-btn nav-link {{ $index === 0 ? 'active' : '' }}"
                            id="country-tab-{{ $country->id }}"
                            data-tab-switch="true"
                            data-bs-target="#country-pane-{{ $country->id }}"
                            data-country-id="{{ $country->id }}"
                            type="button" role="tab"
                            aria-controls="country-pane-{{ $country->id }}"
                            aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                        {{ $country->name }}
                    </button>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="tab-content" id="countryTabContent">
            @foreach($countries as $index => $country)
            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                 id="country-pane-{{ $country->id }}"
                 role="tabpanel"
                 aria-labelledby="country-tab-{{ $country->id }}">

                @if($country->states->isNotEmpty())
                <div class="dst-carousel-wrap">
                    <div class="swiper" id="stateSwiper{{ $country->id }}">
                        <div class="swiper-wrapper">
                            @foreach($country->states as $stateIndex => $state)
                            @php
                                $shortDests = $state->short_destinations_list;
                            @endphp
                            <div class="swiper-slide">
                                <div class="dst-card dst-card-formal">
                                    <a href="{{ route('home.tour.state', $state->slug) }}" class="dst-card-media">
                                        @if($state->image)
                                            <img src="{{ asset('storage/' . $state->image) }}" alt="{{ $state->name }}" class="dst-card-img" width="320" height="200" loading="lazy" decoding="async">
                                        @else
                                            <div class="dst-card-img dst-card-img-placeholder"></div>
                                        @endif
                                        @if(($state->tours_count ?? 0) > 0)
                                            <span class="dst-card-count-badge">{{ $state->tours_count }} {{ $state->tours_count == 1 ? 'Package' : 'Packages' }}</span>
                                        @endif
                                    </a>

                                    <div class="dst-card-body">
                                        <h3 class="dst-card-title">
                                            <a href="{{ route('home.tour.state', $state->slug) }}">{{ $state->name }}</a>
                                        </h3>

                                        @if(!empty($shortDests))
                                            <div class="dst-short-chips">
                                                @foreach($shortDests as $chip)
                                                    <a href="{{ route('home.tour.state', $state->slug) }}" class="dst-short-chip">{{ $chip }}</a>
                                                @endforeach
                                            </div>
                                        @endif

                                        <div class="dst-card-footer">
                                            <a href="{{ route('home.tour.state', $state->slug) }}" class="dst-card-viewmore">
                                                <span>View More</span>
                                                <i class="ti ti-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @if($country->states->count() > 3)
                    <div class="dst-nav">
                        <button class="dst-nav-btn dst-nav-prev" id="statePrev{{ $country->id }}" type="button" aria-label="Previous">
                            <i class="ti ti-chevron-left"></i>
                        </button>
                        <button class="dst-nav-btn dst-nav-next" id="stateNext{{ $country->id }}" type="button" aria-label="Next">
                            <i class="ti ti-chevron-right"></i>
                        </button>
                    </div>
                    @endif
                </div>
                @else
                <p class="text-center dst-empty-text">No states added yet for {{ $country->name }}.</p>
                @endif

            </div>
            @endforeach
        </div>
    </div>
</section>

<!--==============================
1. About Area
==============================-->
<section class="kz-about-section" id="about-sec">
    <div class="container">
        <div class="row align-items-center">

            <!-- Image Area -->
            <div class="col-xl-6">
                <div class="kz-about-img-card">

                    @php
                        $aboutImages = is_string($setting->about_images) ? json_decode($setting->about_images, true) : ($setting->about_images ?? []);
                        $aboutImage = collect($aboutImages)->firstWhere('order', 1);
                    @endphp

                    @if(!empty($aboutImage))
                    <div class="kz-about-img-frame">
                        <img src="{{ asset('storage/' . $aboutImage['image']) }}" alt="Travel Experience" width="560" height="420" loading="lazy" decoding="async">
                    </div>
                    @endif

                    <div class="kz-about-exp-badge">
                        <span>15+</span>
                        <small>Years of Excellence</small>
                    </div>

                </div>
            </div>

            <!-- Content Area -->
            <div class="col-xl-6">
                <div class="kz-about-info-wrap">

                    <span class="kz-about-eyebrow">
                        {{ $setting->about_subtitle ?? 'Welcome To Love Link Tour & Travels' }}
                    </span>

                    <h2 class="kz-about-heading">
                        {{ $setting->about_title ?? 'Crafting Unforgettable Himalayan & Kashmir Journeys' }}
                    </h2>

                    <div class="kz-about-body-text">
                        {!! $setting->about_content !!}
                    </div>

                    <!-- Features -->
                    <div class="kz-about-features-grid">
                        @if(!empty($setting->about_ot_content))
                            @foreach($setting->about_ot_content as $itemIndex => $item)
                            <div class="kz-about-feature-pill">
                                <div class="kz-about-feature-ico">
                                    <i class="fas fa-map-marked-alt"></i>
                                </div>
                                <div class="kz-about-feature-txt">
                                    <h5>{{ $item['title'] ?? '' }}</h5>
                                    <p>{{ $item['content'] ?? '' }}</p>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Animated Stats -->
                    <div class="kz-about-stat-row">
                        <div class="kz-about-stat-card">
                            <h3>50,000+</h3>
                            <span>Happy Travellers</span>
                        </div>
                        <div class="kz-about-stat-card">
                            <h3>2500+</h3>
                            <span>Tour Packages</span>
                        </div>
                        <div class="kz-about-stat-card">
                            <h3>4.9</h3>
                            <span>Guest Rating</span>
                        </div>
                    </div>

                    <!-- CTA -->
                    <div>
                        <a href="{{ route('aboutus.index') }}" class="kz-about-btn-cta">
                            <span>Learn More</span>
                            <span class="kz-about-btn-icon"><i class="ti ti-arrow-right"></i></span>
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!--==============================
2. Category Area
==============================-->
<section class="kz-cat-section" id="categories-sec">
    <div class="container">
        <div class="kz-cat-header">
            <span class="kz-cat-eyebrow">Wonderful Places For You</span>
            <h2 class="kz-cat-heading">Tour Categories</h2>
        </div>
        
        <div class="swiper" id="kzCategorySwiper">
            <div class="swiper-wrapper">
                @foreach($categories as $catIndex => $category)
                <div class="swiper-slide">
                    <div class="kz-cat-card">
                        <div class="kz-cat-img-wrap">
                            @if($category->image)
                                <img class="kz-cat-img" src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" width="320" height="380" loading="lazy" decoding="async">
                            @else
                                <div class="kz-cat-img kaw-state-img-placeholder"></div>
                            @endif
                            <span class="kz-cat-badge">Category</span>
                            <span class="kz-cat-tag"><i class="ti ti-compass"></i> Explore</span>
                        </div>
                        <div class="kz-cat-body">
                            <h3 class="kz-cat-title">
                                <a href="{{ route('tours.by.category', $category->slug) }}">{{ $category->name }}</a>
                            </h3>
                            <p class="kz-cat-desc">Curated itineraries & bespoke travel experiences</p>
                            <a class="kz-cat-btn" href="{{ route('tours.by.category', $category->slug) }}">
                                <span>View Tours</span>
                                <span class="kz-cat-btn-arrow"><i class="ti ti-arrow-up-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="kz-swiper-dots kz-cat-pagination"></div>
        </div>
    </div>
</section>

<!--==============================
3. Cabs Section (In-Between)
==============================-->
@php
    $homeCabs = isset($cabs) && $cabs->isNotEmpty() 
        ? $cabs 
        : (\App\Models\Cab::where('status', 1)->orderByRaw('CASE WHEN `order` IS NULL THEN 1 ELSE 0 END, `order` ASC, id DESC')->get() ?? collect());
@endphp
@if(!empty($homeCabs) && $homeCabs->count() > 0)
<section class="kz-cabs-section" id="cabs-sec">
    <div class="container">
        <div class="kz-cabs-header">
            <span class="kz-cabs-eyebrow">Reliable & Comfortable Rides</span>
            <h2 class="kz-cabs-heading">Available Cabs & Fleet</h2>
            <p class="kz-cabs-subtitle">Well-maintained, sanitized vehicles with experienced local drivers for a smooth journey</p>
        </div>

        <div class="swiper" id="kzCabsSwiper">
            <div class="swiper-wrapper">
                @foreach($homeCabs as $cabIndex => $cab)
                <div class="swiper-slide">
                    <div class="kz-cab-box">
                        <div class="kz-cab-media">
                            @if(!empty($cab->image))
                                <img src="{{ asset('storage/' . $cab->image) }}" alt="{{ $cab->name }}" width="340" height="220" loading="lazy" decoding="async">
                            @else
                                <div class="kaw-state-img-placeholder"></div>
                            @endif
                            <span class="kz-cab-badge">Verified Fleet</span>
                        </div>
                        <div class="kz-cab-content">
                            <h4 class="kz-cab-title">
                                <a href="{{ route('home.cabdetails', $cab->slug) }}">{{ $cab->name }}</a>
                            </h4>
                            <span class="kz-cab-loc">
                                <i class="ti ti-map-pin"></i> {{ !empty($cab->location) ? $cab->location : 'Kashmir Valley • Airport & Outstation' }}
                            </span>
                            <p class="kz-cab-desc">
                                {{ Str::limit($cab->short_description ?? 'Comfortable AC cab with professional chauffeur.', 48) }}
                            </p>
                            @php
                                $cabWaUrl = 'https://wa.me/' . $wa_phone_clean . '?text=' . urlencode('Hi Love Link, I would like to book the cab: ' . $cab->name . '. Please share rates and availability.');
                            @endphp
                            <div class="kz-cab-footer">
                                <a href="{{ $cabWaUrl }}" target="_blank" class="kz-cab-link">
                                    <i class="fab fa-whatsapp me-1 text-success"></i> Book Now
                                </a>
                                <a href="{{ route('home.cabdetails', $cab->slug) }}" class="kz-cab-btn">
                                    Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="kz-swiper-dots kz-cabs-pagination"></div>
        </div>
        <div class="text-center mt-4 pt-2">
            <a href="{{ route('home.cabs') }}" class="kz-blog-viewall-btn">
                <span>Explore Full Fleet</span>
                <span class="kz-blog-viewall-ico"><i class="ti ti-arrow-right"></i></span>
            </a>
        </div>
    </div>
</section>
@endif

<!--==============================
4. Popular Destinations (Glass Effect)
==============================-->
<section class="kz-dest-section" id="destination-sec">
    <div class="container">
        <div class="kz-dest-header">
            <span class="kz-dest-eyebrow">Top Places For You</span>
            <h2 class="kz-dest-heading">Popular Destinations</h2>
            <p class="kz-dest-subtitle">Explore Kashmir’s most captivating valleys, lakes, meadows and alpine wonderlands</p>
        </div>

        <div class="swiper" id="kzDestSwiper">
            <div class="swiper-wrapper">
                @foreach($destinations as $destIndex => $destination)
                <div class="swiper-slide">
                    <div class="kz-glass-card">
                        <div class="kz-glass-img-wrap">
                            @if($destination->image)
                                <img class="kz-glass-img" src="{{ asset('storage/' . $destination->image) }}" alt="{{ $destination->name }}" width="380" height="400" loading="lazy" decoding="async">
                            @else
                                <div class="kz-glass-img kaw-state-img-placeholder"></div>
                            @endif
                            <span class="kz-glass-badge">FEATURED</span>
                            <span class="kz-glass-count">{{ $destination->tours_count ?? 0 }} Packages</span>
                        </div>
                        <div class="kz-glass-body">
                            <h3 class="kz-glass-title">
                                <a href="{{ route('destination.details', $destination->slug) }}">{{ $destination->name }}</a>
                            </h3>
                            <p class="kz-glass-desc">Experience pristine valleys, snow trails and local culture</p>
                            <a href="{{ route('destination.details', $destination->slug) }}" class="kz-glass-btn">
                                <span>Explore Destination</span>
                                <span class="kz-glass-btn-arrow"><i class="ti ti-arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="kz-swiper-dots kz-glass-dots kz-dest-pagination"></div>
        </div>
    </div>
</section>

<!--==============================
5. Handpicked Hotels & Luxury Resorts
==============================-->
@php
    $homeHotels = $hotels ?? collect();
@endphp
@if(!empty($homeHotels) && $homeHotels->count() > 0)
<section class="kz-hotels-section" id="hotels-sec">
    <div class="container">
        <div class="kz-hotels-header">
            <span class="kz-hotels-eyebrow">Handpicked Accommodations</span>
            <h2 class="kz-hotels-heading">Hotels & Luxury Resorts</h2>
            <p class="kz-hotels-subtitle">Stay in premium handpicked resorts, scenic valley view retreats, and authentic heritage houseboats</p>
        </div>

        <div class="kz-hotels-slider-wrap position-relative">
            <div class="swiper" id="kzHotelsSwiper">
                <div class="swiper-wrapper">
                    @foreach($homeHotels as $hotelIndex => $hotel)
                    @php
                        $hotelRating = (float)($hotel->star_rating ?? 4);
                        $hotelLocation = !empty($hotel->location) ? $hotel->location : 'Kashmir Valley';
                        $hotelDetailUrl = route('home.hoteldetails', $hotel->slug);
                        $hotelWaUrl = 'https://wa.me/' . $wa_phone_clean . '?text=' . urlencode('Hi Love Link, I would like to inquire about booking: ' . $hotel->name . ' in ' . $hotelLocation);
                    @endphp
                    <div class="swiper-slide">
                        <div class="kz-hotel-home-card">
                            <div class="kz-hotel-media">
                                <a href="{{ $hotelDetailUrl }}" class="d-block w-100 h-100">
                                    @if(!empty($hotel->image))
                                        <img src="{{ asset('storage/' . $hotel->image) }}" alt="{{ $hotel->name }}" width="380" height="260" loading="lazy" decoding="async">
                                    @else
                                        <div class="kaw-state-img-placeholder"></div>
                                    @endif
                                </a>
                                <span class="kz-hotel-badge">Verified Stay</span>
                                <span class="kz-hotel-star-pill">
                                    <i class="fas fa-star text-warning"></i> {{ number_format($hotelRating, 1) }} Star
                                </span>
                            </div>
                            <div class="kz-hotel-body">
                                <div class="kz-hotel-loc">
                                    <i class="ti ti-map-pin"></i> {{ $hotelLocation }}
                                </div>
                                <h3 class="kz-hotel-title">
                                    <a href="{{ $hotelDetailUrl }}">{{ $hotel->name }}</a>
                                </h3>
                                <p class="kz-hotel-desc">
                                    {{ Str::limit($hotel->short_description ?? 'Comfortable, premium mountain stay with modern amenities and local hospitality.', 58) }}
                                </p>
                                <div class="kz-hotel-footer">
                                    <a href="{{ $hotelWaUrl }}" target="_blank" class="kz-hotel-wa-btn">
                                        <i class="fab fa-whatsapp me-1"></i> Book Now
                                    </a>
                                    <a href="{{ $hotelDetailUrl }}" class="kz-hotel-detail-btn">
                                        <span>Details</span>
                                        <i class="ti ti-arrow-up-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Custom Branded Navigation Arrows -->
            <button class="kz-hotels-nav-btn kz-hotels-prev" id="kzHotelsPrev" type="button" aria-label="Previous Hotel">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="kz-hotels-nav-btn kz-hotels-next" id="kzHotelsNext" type="button" aria-label="Next Hotel">
                <i class="fas fa-chevron-right"></i>
            </button>

            <!-- Swiper Pagination Dots -->
            <div class="kz-swiper-dots kz-hotels-pagination"></div>
        </div>

        <div class="text-center mt-4 pt-2">
            <a href="{{ route('home.hotels') }}" class="kz-blog-viewall-btn">
                <span>Explore All Hotels</span>
                <span class="kz-blog-viewall-ico"><i class="ti ti-arrow-right"></i></span>
            </a>
        </div>
    </div>
</section>
@endif

<!--==============================
6. Reasons Section ("Why Choose Us")
==============================-->
<section class="kz-reasons-section">
    <div class="container">
        <div class="kz-reasons-header text-center">
            <span class="kz-reasons-eyebrow">Why Choose Us</span>
            <h2 class="kz-reasons-title">
                Reasons To Make Us Your <em>Travel Bestie.</em>
            </h2>
        </div>
        <div class="row g-4">
            @foreach($travelBestie as $tbIndex => $travel)
            <div class="col-lg-4 col-md-6">
                <div class="kz-reason-card">
                    <div class="kz-reason-icon-wrap">
                        @if($travel->image)
                            <img src="{{ asset('storage/' . $travel->image) }}" alt="{{ $travel->title }}" width="36" height="36" loading="lazy" decoding="async">
                        @else
                            <i class="fas fa-gem text-primary fs-4"></i>
                        @endif
                    </div>
                    <h3 class="kz-reason-heading">{{ $travel->title }}</h3>
                    <p class="kz-reason-paragraph">
                        {{ $travel->description }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!--==============================
7. Promo Offer (Spiti)
==============================-->
@if($sliderSpiti)
<div class="container kz-spiti-section">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="kz-spiti-banner-card">
                <div class="kz-spiti-banner-inner" 
                     style="background-image: url('{{ asset('storage/' . $sliderSpiti->image) }}');">
                     
                    <h3 class="kz-spiti-title">
                        <span class="kz-spiti-tag">{{ $sliderSpiti->title ?? 'Spiti' }}</span>
                        {{ $sliderSpiti->subtitle ?? 'is colder, than your ex but prettier' }}
                    </h3>

                    <p class="kz-spiti-badge">
                       <i class="fas fa-tag me-1 text-warning"></i> Book your summer Kashmir Tour and get flat ₹1999/- off
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!--==============================
8. Stats Counter Grid
==============================-->
<div class="container kz-counter-section">
    <div class="row g-4">
        @if(!empty($setting->home_counter))
            @foreach($setting->home_counter as $counterIndex => $item)
                <div class="col-md-6 col-lg-3">
                  <div class="kz-count-box">
                    <div class="kz-count-ico">
                      <i class="{{ $item['count_number'] ?? 'fas fa-award' }}"></i>
                    </div>
                    <h5 class="kz-count-val">{{ $item['count_sufix'] ?? '' }}</h5>
                    <p class="kz-count-lbl">
                      {{ $item['count_text'] ?? '' }}
                    </p>
                  </div>
                </div> 
            @endforeach
        @endif 
    </div>
</div>

<!--==============================
Brand Partners (Continuous Infinite Marquee)
==============================-->
<div class="brand-area kz-brand-marquee-section overflow-hidden py-4">
    <div class="container th-container">
        <div class="kz-brand-marquee-viewport">
            <div class="kz-brand-marquee-track">
                @for($repeat = 0; $repeat < 4; $repeat++)
                    @foreach($partners as $partnerIndex => $partner)
                    <div class="kz-brand-item">
                        <a href="{{ $partner->link ?? '#' }}" target="_blank" rel="noopener" title="{{ $partner->name }}">
                            <img class="kz-brand-logo-img" src="{{ asset('storage/' . $partner->image) }}" alt="{{ $partner->name }}" width="140" height="50" loading="lazy" decoding="async">
                        </a>
                        <p class="d-none">{{ $partner->name }}</p>
                    </div> 
                    @endforeach
                @endfor
            </div>
        </div>
    </div>
</div>

<!--==============================
9. Blog Area
==============================-->
<section class="kz-blog-section" id="blog-sec">
    <div class="container">
        <div class="kz-blog-header">
            <span class="kz-blog-eyebrow">Explore ideas, tips & experiences</span>
            <h2 class="kz-blog-heading">Blog & Insights</h2>
        </div>

        <div class="row g-4">
            @foreach($blogs->take(8) as $blogIndex => $blog)
            <div class="col-md-6 col-lg-3">
                <div class="kz-blog-card">
                    <div class="kz-blog-media">
                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" width="400" height="250" loading="lazy" decoding="async">
                        <a href="{{ route('blog.details', $blog->slug) }}" class="kz-blog-pill-date">
                            {{ \Carbon\Carbon::parse($blog->published_at)->format('M d, Y') }}
                        </a>
                        <span class="kz-blog-pill-read">6 min read</span>
                    </div>
                    <div class="kz-blog-content">
                        <h3 class="kz-blog-title">
                            <a href="{{ route('blog.details', $blog->slug) }}">{{ $blog->title }}</a>
                        </h3>
                        <a href="{{ route('blog.details', $blog->slug) }}" class="kz-blog-link">
                            <span>Read More</span>
                            <span class="kz-blog-arrow-circle"><i class="ti ti-arrow-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="kz-blog-footer-action text-center">
            <a href="{{ route('home.blogs') }}" class="kz-blog-viewall-btn">
                <span>View All Blogs</span>
                <span class="kz-blog-viewall-ico"><i class="ti ti-arrow-right"></i></span>
            </a>
        </div>
    </div>
</section>

<!--==============================
10. FAQ Area
==============================-->
<!-- FAQ moved to side-by-side section with Contact Form -->



<!--==============================
13. Recent Gallery (PREMIUM SWIPER & LIGHTBOX)
==============================-->
@if(isset($galleries) && $galleries->isNotEmpty())
<section class="kz-gallery-section" id="gallery-sec">
    <div class="container">
        <div class="kz-gallery-header">
            <span class="kz-gallery-eyebrow">Captured Moments</span>
            <h2 class="kz-gallery-heading">Recent Travel Gallery</h2>
            <p class="kz-gallery-subtitle">A glimpse into unforgettable memories, snowy peaks, and breathtaking valleys</p>
        </div>

        <div class="kz-gallery-slider-wrap">
            <div class="swiper" id="kzGallerySwiper">
                <div class="swiper-wrapper">
                    @foreach($galleries as $galleryIndex => $gallery)
                    <div class="swiper-slide">
                        <div class="kz-gallery-card">
                            <div class="kz-gallery-img-wrap">
                                <img src="{{ asset('storage/' . $gallery->file) }}" 
                                     alt="{{ $gallery->title ?? 'Kashmir Travel Memory' }}" 
                                     class="kz-gallery-img" 
                                     width="350"
                                     height="350"
                                     loading="lazy"
                                     decoding="async">

                                <div class="kz-gallery-overlay">
                                    <!-- Lightbox Open Button -->
                                    

                                    <div class="kz-gallery-caption">
                                        
                                        @if(!empty($gallery->title))
                                            <h5 class="kz-gallery-title">{{ $gallery->title }}</h5>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Custom Branded Arrows Based on Root Variables -->
            <button class="kz-gallery-nav-btn kz-gallery-prev" id="kzGalleryPrev" type="button" aria-label="Previous image">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button class="kz-gallery-nav-btn kz-gallery-next" id="kzGalleryNext" type="button" aria-label="Next image">
                <i class="bi bi-chevron-right"></i>
            </button>

            <!-- Swiper Pagination Dots -->
            <div class="kz-swiper-dots kz-gallery-pagination"></div>
        </div>
    </div>
</section>

<!-- High-End Zero-Dependency Modal Lightbox Fallback -->
<div class="kz-lightbox-modal" id="kzGalleryLightbox" aria-hidden="true" role="dialog">
    <div class="kz-lightbox-content">
        <button class="kz-lightbox-close" id="kzLightboxClose" type="button" aria-label="Close modal">&times;</button>
        <button class="kz-lightbox-prev" id="kzLightboxPrev" type="button" aria-label="Previous">&lsaquo;</button>
        <img src="" alt="Enlarged view" class="kz-lightbox-img" id="kzLightboxImg">
        <p class="kz-lightbox-caption" id="kzLightboxCaption"></p>
        <button class="kz-lightbox-next" id="kzLightboxNext" type="button" aria-label="Next">&rsaquo;</button>
    </div>
</div>
@endif

<!--==============================
6. Reviews & Testimonials
==============================-->
<section class="kz-reviews-section">
    <div class="container">
        <div class="kz-reviews-header text-center">
            <span class="kz-reviews-eyebrow">Reviews That Make Me Blush</span>
            <h2 class="kz-reviews-heading">Testimonials, Reviews, Experiences & Virtual Tours</h2>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div id="reviewsCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @php
                            $chunks = $youtube->chunk(3);
                        @endphp

                        @foreach($chunks as $key => $chunk)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <div class="row g-4">
                                    @foreach($chunk as $videoIndex => $y)
                                        <div class="col-12 col-md-4">
                                            <div class="kz-video-card">
                                                <div class="kz-video-wrapper">
                                                    <iframe class="kz-video-frame" 
                                                        src="{{ $y->youtube_link }}" 
                                                        allowfullscreen>
                                                    </iframe>
                                                    <div class="kz-video-caption">
                                                        <h5 class="kz-video-caption-title">{{ $y->title }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <button class="carousel-control-prev kz-reviews-arrow kz-reviews-prev" type="button" data-bs-target="#reviewsCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next kz-reviews-arrow kz-reviews-next" type="button" data-bs-target="#reviewsCarousel" data-bs-slide="next">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="kz-reviews-social-bar">
            <div class="kz-reviews-social-badge">
                <i class="fas fa-mountain"></i>
            </div>
            <div class="kz-reviews-social-nav">
                <a href="#" class="kz-reviews-social-link"><i class="fab fa-twitter"></i></a>
                <a href="#" class="kz-reviews-social-link"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="kz-reviews-social-link"><i class="fab fa-instagram"></i></a>
                <a href="#" class="kz-reviews-social-link"><i class="fab fa-linkedin-in"></i></a>
                <a href="https://wa.me/917006921780" class="kz-reviews-social-link"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
    </div>
</section>
@include('frontend.components.google-reviews')

<!--==============================
10. FAQs & Contact Us Form (Side-by-Side on Desktop, FAQ First on Mobile)
==============================-->
<section class="kz-faq-contact-section py-5" id="faq-sec">
    <div class="container">
        <div class="row g-4 align-items-start">
            <!-- Left Column: Frequently Asked Questions (First on mobile) -->
            <div class="col-lg-6 col-12 order-1">
                <div class="kz-faq-box">
                    <div class="kz-faq-header text-start mb-4">
                        <span class="kz-faq-eyebrow">Got Questions?</span>
                        <h2 class="kz-faq-heading">Frequently Asked Questions</h2>
                        <p class="kz-faq-subtitle text-muted">Quick answers to help you plan your perfect journey in Kashmir.</p>
                    </div>
                    <div class="kz-faq-list-wrap" id="faqAccordion">
                        @foreach($faqs as $faqIndex => $faq)
                        <div class="kz-faq-card {{ $loop->first ? 'active' : '' }}">
                            <div id="collapse-item-{{ $loop->index }}">
                                <button
                                    class="kz-faq-trigger {{ $loop->first ? '' : 'collapsed' }}"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse-{{ $loop->index }}"
                                    aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                    aria-controls="collapse-{{ $loop->index }}">
                                    <span class="kz-faq-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="kz-faq-question-txt">{{ $faq->question }}</span>
                                    <span class="kz-faq-chevron"></span>
                                </button>
                            </div>
                            <div id="collapse-{{ $loop->index }}"
                                 class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                 aria-labelledby="collapse-item-{{ $loop->index }}"
                                 data-bs-parent="#faqAccordion">
                                <div class="kz-faq-collapse-body">
                                    <p class="kz-faq-paragraph">{{ $faq->answer }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="kz-faq-footer-action mt-4 text-start">
                        <a href="{{ route('home.faq') }}" class="kz-faq-btn-more">
                            <span>See All FAQs</span>
                            <span class="kz-faq-btn-ico"><i class="ti ti-arrow-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column: Contact Inquiry Form (Second on mobile) -->
            <div class="col-lg-6 col-12 order-2" id="contact-sec">
                <div class="kz-contact-card">
                    <div class="text-start mb-4">
                        <span class="kz-contact-eyebrow">Get In Touch</span>
                        <h3 class="kz-contact-title">Have Questions? Reach Out</h3>
                        <p class="kz-contact-subtitle">Have questions about your Kashmir trip? Reach out to our travel experts anytime.</p>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('home.contact.submit') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6 col-12">
                                <div class="kz-form-field">
                                    <input type="text" class="kz-form-input" name="name" value="{{ old('name') }}" id="name3" placeholder="Full Name" required>
                                    <img src="{{ asset('webassets/img/icon/user.svg') }}" alt="" class="kz-form-icon" width="18" height="18" loading="lazy" decoding="async">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="kz-form-field">
                                    <input type="tel" class="kz-form-input" name="number" value="{{ old('number') }}" id="number" placeholder="Mobile Number" required>
                                    <img src="{{ asset('webassets/img/icon/call.svg') }}" alt="" class="kz-form-icon" width="18" height="18" loading="lazy" decoding="async">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="kz-form-field">
                                    <input type="email" class="kz-form-input" name="email" value="{{ old('email') }}" id="email3" placeholder="Email Address" required>
                                    <img src="{{ asset('webassets/img/icon/mail.svg') }}" alt="" class="kz-form-icon" width="18" height="18" loading="lazy" decoding="async">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="kz-form-field">
                                    <select name="subject" id="subject" class="kz-form-select">
                                        <option value="Select Tour Type" selected disabled>Select Tour Type</option>
                                        <option value="Kashmir Honeymoon Package">Kashmir Honeymoon Package</option>
                                        <option value="Kashmir Family Tour">Kashmir Family Tour</option>
                                        <option value="Ladakh Adventure Tour">Ladakh Adventure Tour</option>
                                        <option value="Gulmarg Ski & Snow Package">Gulmarg Ski & Snow Package</option>
                                        <option value="Custom Group Tour">Custom Group Tour</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="kz-form-field">
                                    <textarea name="message" id="message" cols="30" rows="3" class="kz-form-textarea" placeholder="Tell us about your travel dates, group size, and preferences...">{{ old('message') }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-3">
                                <button type="submit" class="kz-contact-submit-btn w-100">
                                    <span>Send Inquiry</span>
                                    <img src="{{ asset('webassets/img/icon/plane.svg') }}" alt="" width="16" height="16" loading="lazy" decoding="async">
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     ALL PAGE SCRIPTS
     ═══════════════════════════════════════════════════════════ -->
@endsection
