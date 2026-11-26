@extends('frontend.layouts.app')
@section('page_title', $category->meta_title ?? ($category->name . ' Tours'))
@section('page_meta')  
{!! generateMetaTags($category) !!} 
@endsection

@section('content')

<!--================================================================
    KZ LUXURY CATEGORY TOURS DIRECTORY DESIGN SYSTEM (SCOPED CSS)
    Colors: Royal Navy (#0B3D91), Dark Navy (#072355), Gold (#ddab43)
=================================================================-->
<!--==============================
    Breadcrumb Section
============================== -->
@php
    $categoryBgImage = !empty($category->page_bg_image)
        ? asset('storage/' . $category->page_bg_image)
        : getImageByType('tours', $setting ?? null);
@endphp
<div class="breadcumb-wrapper" {!! breadcrumbBgAttrs($categoryBgImage, $setting ?? null, true) !!}>
    <div class="container">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">{{ $category->name }} Tours</h1>
            <ul class="breadcumb-menu">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('home.tour') }}">Tours</a></li>
                <li>{{ $category->name }} Tours</li>
            </ul>
        </div>
    </div>
</div> 

<!--==============================
    Product Area
==============================-->
<section style="padding:10px 0" class="spacee">
    <div class="container">
        <!-- Filter / Sort Bar -->
        <div class="th-sort-bar">
            <div class="row justify-content-between align-items-center g-3">
                <div class="col-md-4">
                    <div class="search-form-area">
                        <form class="search-form" method="GET" action="{{ route('home.tour') }}">
                            <input type="text" name="search" placeholder="Search tours in {{ $category->name }}...">
                            <button type="submit" aria-label="Search"><i class="fa-light fa-magnifying-glass"></i></button>
                        </form>
                    </div>
                </div>

                <div class="col-md-auto">
                    <div class="sorting-filter-wrap">
                        <div class="nav" role="tablist">
                            <a class="active" href="#" id="tab-destination-grid" data-bs-toggle="tab" data-bs-target="#tab-grid" role="tab" aria-controls="tab-grid" aria-selected="true" title="Grid View">
                                <i class="fa-light fa-grid-2"></i>
                            </a>
                            <a href="#" id="tab-destination-list" data-bs-toggle="tab" data-bs-target="#tab-list" role="tab" aria-controls="tab-list" aria-selected="false" title="List View">
                                <i class="fa-solid fa-list"></i>
                            </a>
                        </div>
                        <form class="woocommerce-ordering" method="get">
                            <select name="orderby" class="orderby" aria-label="destination order">
                                <option value="menu_order" selected="selected">Default Sorting</option>
                                <option value="popularity">Sort by popularity</option>
                                <option value="rating">Sort by average rating</option>
                                <option value="date">Sort by latest</option>
                                <option value="price">Sort by price: low to high</option>
                                <option value="price-desc">Sort by price: high to low</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-12 col-lg-12">
                <div class="tab-content" id="nav-tabContent">
                    {{-- ========== GRID VIEW ========== --}}
                    <div class="tab-pane fade active show" id="tab-grid" role="tabpanel" aria-labelledby="tab-destination-grid">
                        <div class="row gy-24 gx-24">
                            @foreach($tours as $tour)
                            <div class="col-md-3">
                                <div class="kaw-pkg-card">
                                    @if(isset($tour->badge_type) && $tour->badge_type === 'deal')
                                        <span class="kaw-pkg-badge kaw-badge-deal">
                                            <i class="ti ti-discount-2"></i> Deal
                                        </span>
                                    @elseif((isset($tour->badge_type) && $tour->badge_type === 'most_booked') || (isset($loop) && $loop->first))
                                        <span class="kaw-pkg-badge kaw-badge-booked">
                                            <i class="ti ti-thumb-up"></i> Most Booked
                                        </span>
                                    @elseif(!empty($tour->discount_percent))
                                        <span class="kaw-pkg-badge kaw-badge-discount">
                                            {{ $tour->discount_percent }}% OFF
                                        </span>
                                    @endif

                                    <div class="kaw-pkg-img-wrap">
                                        <a href="{{ route('tour.details', $tour->slug) }}" class="kaw-pkg-img-link" aria-label="{{ $tour->title }}">
                                            <img src="{{ asset('storage/' . ($tour->image ?? $tour->banner_image)) }}" alt="{{ $tour->title }}" class="kaw-pkg-img" loading="lazy">
                                        </a>
                                        @if(isset($tour->gallery_count) && $tour->gallery_count > 1)
                                        <button class="kaw-pkg-arrow kaw-pkg-arrow-prev" aria-label="Previous"><i class="ti ti-chevron-left"></i></button>
                                        <button class="kaw-pkg-arrow kaw-pkg-arrow-next" aria-label="Next"><i class="ti ti-chevron-right"></i></button>
                                        @endif
                                    </div>

                                    <div class="kaw-pkg-body">
                                        <div class="kaw-pkg-meta-top">
                                            <h3 class="kaw-pkg-title">
                                                <a href="{{ route('tour.details', $tour->slug) }}">{{ $tour->title }}</a>
                                            </h3>
                                            <p class="kaw-pkg-subtitle">
                                                @if(isset($tour->state->name))
                                                    {{ ucwords($tour->state->name ?? 'Kashmir') }} Package
                                                @elseif(isset($tour->category->name))
                                                    {{ $tour->category->name }}
                                                @else
                                                    Luxury Tour Package
                                                @endif
                                                @if(isset($tour->duration) && $tour->duration > 0)
                                                    • {{ $tour->duration > 1 ? ($tour->duration - 1) . 'N/' . $tour->duration . 'D' : $tour->duration . ' Days' }}
                                                @endif
                                            </p>
                                        </div>

                                        {{-- Specs Row: Exact replica of Card Two --}}
                                        <div class="kaw-pkg-spec-row">
                                            <div class="kaw-spec-item kaw-spec-price">
                                                <i class="fa-solid fa-tag kaw-spec-icon"></i>
                                                <span class="kaw-spec-from">from</span>
                                                <span class="kaw-spec-amount">{{ str_replace('.00', '', $tour->formatted_price ?? ('₹' . number_format($tour->price ?? 0))) }}</span>
                                            </div>
                                            <div class="kaw-spec-item kaw-spec-code">
                                                <i class="fa-solid fa-plane-departure kaw-spec-icon"></i>
                                                <span class="kaw-spec-dest">
                                                    {{ strtoupper($tour->destination->name ?? $tour->state->name ?? 'KASHMIR') }}
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Bottom Action Row: Pill Button + Circular Heart Button --}}
                                        <div class="kaw-pkg-action-row">
                                            <a href="{{ route('tour.details', $tour->slug) }}" class="kaw-pkg-action-btn">
                                                <span>View Details</span>
                                            </a>
                                            <a href="https://api.whatsapp.com/send?phone=917006338617&text={{ urlencode('Hi LoveLink, I would like to inquire about: ' . $tour->title) }}" 
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

                    {{-- ========== LIST VIEW ========== --}}
                    <div class="tab-pane fade" id="tab-list" role="tabpanel" aria-labelledby="tab-destination-list">
                        <div class="row gy-30">
                            @foreach($tours as $tour)
                            <div class="col-12">
                                <div class="kaw-pkg-card style-flex">
                                    @if(isset($tour->badge_type) && $tour->badge_type === 'deal')
                                        <span class="kaw-pkg-badge kaw-badge-deal">
                                            <i class="ti ti-discount-2"></i> Deal
                                        </span>
                                    @elseif((isset($tour->badge_type) && $tour->badge_type === 'most_booked') || (isset($loop) && $loop->first))
                                        <span class="kaw-pkg-badge kaw-badge-booked">
                                            <i class="ti ti-thumb-up"></i> Most Booked
                                        </span>
                                    @elseif(!empty($tour->discount_percent))
                                        <span class="kaw-pkg-badge kaw-badge-discount">
                                            {{ $tour->discount_percent }}% OFF
                                        </span>
                                    @endif

                                    <div class="kaw-pkg-img-wrap">
                                        <a href="{{ route('tour.details', $tour->slug) }}" class="kaw-pkg-img-link" aria-label="{{ $tour->title }}">
                                            <img src="{{ asset('storage/' . ($tour->image ?? $tour->banner_image)) }}" alt="{{ $tour->title }}" class="kaw-pkg-img" loading="lazy">
                                        </a>
                                        @if(isset($tour->gallery_count) && $tour->gallery_count > 1)
                                        <button class="kaw-pkg-arrow kaw-pkg-arrow-prev" aria-label="Previous"><i class="ti ti-chevron-left"></i></button>
                                        <button class="kaw-pkg-arrow kaw-pkg-arrow-next" aria-label="Next"><i class="ti ti-chevron-right"></i></button>
                                        @endif
                                    </div>

                                    <div class="kaw-pkg-body">
                                        <div class="kaw-pkg-meta-top">
                                            <h3 class="kaw-pkg-title">
                                                <a href="{{ route('tour.details', $tour->slug) }}">{{ $tour->title }}</a>
                                            </h3>
                                            <p class="kaw-pkg-subtitle">
                                                @if(isset($tour->state->name))
                                                    {{ ucwords($tour->state->name ?? 'Kashmir') }} Package
                                                @elseif(isset($tour->category->name))
                                                    {{ $tour->category->name }}
                                                @else
                                                    Luxury Tour Package
                                                @endif
                                                @if(isset($tour->duration) && $tour->duration > 0)
                                                    • {{ $tour->duration > 1 ? ($tour->duration - 1) . 'N/' . $tour->duration . 'D' : $tour->duration . ' Days' }}
                                                @endif
                                            </p>
                                            @if(!empty($tour->highlights))
                                            <p class="kaw-pkg-itinerary mt-2">
                                                @php
                                                    $highlights = is_array($tour->highlights) ? $tour->highlights : json_decode($tour->highlights, true);
                                                @endphp
                                                @if(is_array($highlights))
                                                    @foreach($highlights as $index => $item)
                                                        <span class="kaw-itinerary-stop">{{ $item }}</span>
                                                        @if($index < count($highlights) - 1)
                                                            <span class="kaw-itinerary-dot">></span>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </p>
                                            @endif
                                        </div>

                                        <div class="kaw-pkg-spec-row">
                                            <div class="kaw-spec-item kaw-spec-price">
                                                <i class="fa-solid fa-tag kaw-spec-icon"></i>
                                                <span class="kaw-spec-from">from</span>
                                                <span class="kaw-spec-amount">{{ str_replace('.00', '', $tour->formatted_price ?? ('₹' . number_format($tour->price ?? 0))) }}</span>
                                            </div>
                                            <div class="kaw-spec-item kaw-spec-code">
                                                <i class="fa-solid fa-plane-departure kaw-spec-icon"></i>
                                                <span class="kaw-spec-dest">
                                                    {{ strtoupper($tour->destination->name ?? $tour->state->name ?? 'KASHMIR') }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="kaw-pkg-action-row">
                                            <a href="{{ route('tour.details', $tour->slug) }}" class="kaw-pkg-action-btn">
                                                <span>View Details</span>
                                            </a>
                                            <a href="https://api.whatsapp.com/send?phone=917006338617&text={{ urlencode('Hi LoveLink, I would like to inquire about: ' . $tour->title) }}" 
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
                </div>

                <!-- Pagination Links -->
                <div class="pagination text-center mt-5 mb-0">
                    {{ $tours->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="shape-mockup shape1 d-none d-xxl-block" data-bottom="7%" data-right="8%">
        <img src="{{ asset('webassets/img/shape/shape_1.png')}}" alt="shape">
    </div>
    <div class="shape-mockup shape2 d-none d-xl-block" data-bottom="1%" data-right="7%">
        <img src="{{ asset('webassets/img/shape/shape_2.png')}}" alt="shape">
    </div>
    <div class="shape-mockup shape3 d-none d-xxl-block" data-bottom="2%" data-right="4%">
        <img src="{{ asset('webassets/img/shape/shape_3.png')}}" alt="shape">
    </div>
</section>

@endsection
