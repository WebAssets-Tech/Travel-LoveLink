@extends('frontend.layouts.app')
@section('page_title', $destination->meta_title) 
@section('page_meta')  
{!! generateMetaTags($destination) !!} 
@endsection

@section('content')
<!--==============================
    Destination Details Area
==============================-->
<section class="space destination-detail-section">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-lg-12">
                <div class="page-single">
                    @if(!empty($destination->banner_image))
                    <div class="service-img">
                        <img src="{{ asset('storage/' . $destination->banner_image) }}" alt="{{ $destination->name }}">
                    </div>
                    @endif

                    <div class="page-content">
                        <div class="page-meta mt-35 mb-25">
                            <a class="page-tag kz-dest-location-badge" href="{{ url('destinations.index', ['search' => $destination->location]) }}">
                                <i class="fa-solid fa-location-dot me-1"></i> {{ $destination->location }}
                            </a>
                            <span class="ratting d-none">
                                <i class="fa-sharp fa-solid fa-star"></i><span>4.8</span>
                            </span>
                        </div>

                        @if(!empty($destination->short_description))
                        <p class="text-muted mb-3 hotel-desc fs-6">{!! $destination->short_description !!}</p>
                        @endif

                        <h2 class="box-title">{{ $destination->name }}</h2>
                        
                        <div class="blog-text mb-30">
                            {!! $destination->description !!}
                        </div>
                         
                        @php
                            $existingHighlights = $destination->highlights ?? [];
                        @endphp
                        @if (!empty($existingHighlights))
                        <h2 class="box-title">Highlights</h2>
                        <div class="checklist">
                            <ul>
                                @foreach ($existingHighlights as $highlight)
                                    <li>{{ $highlight }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>

                    @if(!empty($destination->gallery))
                        @php
                            $galleryImages = is_string($destination->gallery) ? json_decode($destination->gallery, true) : (is_array($destination->gallery) ? $destination->gallery : []);
                        @endphp
                        @if(!empty($galleryImages))
                        <div class="destination-gallery-wrapper mt-40 pt-30 border-top">
                            <div class="d-flex align-items-center justify-content-between mb-20 flex-wrap gap-2">
                                <div>
                                    <span class="dest-gal-eyebrow" style="color: #ddab43; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; font-size: 11.5px;">Visual Highlights</span>
                                    <h3 class="dest-gal-title m-0" style="color: #0B3D91; font-size: 22px; font-weight: 800;">From Our Gallery</h3>
                                </div>
                                <div class="dest-gallery-nav d-flex gap-2">
                                    <button class="dest-gal-nav-btn dest-gal-prev" type="button" aria-label="Previous photo">
                                        <i class="fa-solid fa-chevron-left"></i>
                                    </button>
                                    <button class="dest-gal-nav-btn dest-gal-next" type="button" aria-label="Next photo">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="swiper dest-gallery-slider" data-lenis-prevent="true">
                                <div class="swiper-wrapper">
                                    @foreach($galleryImages as $image)
                                    <div class="swiper-slide">
                                        <div class="dest-gal-card">
                                            <div class="dest-gal-img-wrap">
                                                <img src="{{ asset('storage/' . $image) }}" alt="{{ $destination->name }} gallery" loading="lazy">
                                                <a href="{{ asset('storage/' . $image) }}" class="dest-gal-zoom popup-image" aria-label="Zoom Photo">
                                                    <i class="fal fa-magnifying-glass-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach 
                                </div>
                            </div>
                        </div>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>

    <div class="shape-mockup shape1 d-none d-xxl-block" data-bottom="35%" data-right="12%">
        <img src="{{ asset('webassets/img/shape/shape_1.png') }}" alt="shape">
    </div>
    <div class="shape-mockup shape2 d-none d-xl-block" data-bottom="31%" data-right="8%">
        <img src="{{ asset('webassets/img/shape/shape_2.png') }}" alt="shape">
    </div>
    <div class="shape-mockup shape3 d-none d-xxl-block" data-bottom="33%" data-right="5%">
        <img src="{{ asset('webassets/img/shape/shape_3.png') }}" alt="shape">
    </div>
</section>

@if(isset($tours) && $tours->isNotEmpty())
<!--==============================
    Related Tour Packages for this Destination
==============================-->
<section class="space-bottom" style="padding-top: 15px; padding-bottom: 70px; background: #fbfcfe;">
    <div class="container">
        <div class="title-area text-center mb-40">
            <span class="sub-title" style="color: #ddab43; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; font-size: 13px;">Curated Itineraries</span>
            <h2 class="sec-title" style="color: #0b3358; font-size: 32px; font-weight: 800; margin-top: 8px;">Tour Packages Including {{ $destination->name }}</h2>
            <p class="text-muted" style="max-width: 650px; margin: 10px auto 0;">Explore our best handcrafted tour itineraries and holiday packages featuring {{ $destination->name }}.</p>
        </div>
        <div class="row gy-4">
            @foreach($tours as $item)
                <div class="col-xl-3 col-lg-3 col-md-6">

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
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    function initDestGallerySwiper() {
        if (typeof Swiper !== 'undefined' && document.querySelector('.dest-gallery-slider')) {
            new Swiper('.dest-gallery-slider', {
                slidesPerView: 1.3,
                spaceBetween: 14,
                grabCursor: true,
                navigation: {
                    prevEl: '.dest-gal-prev',
                    nextEl: '.dest-gal-next',
                },
                breakpoints: {
                    480: { slidesPerView: 2.2, spaceBetween: 14 },
                    768: { slidesPerView: 3.2, spaceBetween: 16 },
                    992: { slidesPerView: 4.2, spaceBetween: 16 },
                    1200: { slidesPerView: 5, spaceBetween: 18 }
                }
            });
        }
    }
    if (document.readyState === 'complete') {
        initDestGallerySwiper();
    } else {
        window.addEventListener('load', initDestGallerySwiper);
    }
});
</script>

@endsection
