@extends('frontend.layouts.app')
@section('page_title', $type)
@section('page_meta')  
{!! generateMetaTagsSimple($type,$setting) !!}  
@endsection
@section('content')

@php
    $typeCategoryBg = getImageByType('tours', $setting ?? null);
@endphp
<div class="kz-about-page-hero py-3 text-center position-relative overflow-hidden mb-4" {!! breadcrumbBgAttrs($typeCategoryBg, $setting ?? null, true, true) !!}>
    <div class="container">
        <span class="kz-about-hero-tag" style="font-size: 11px; letter-spacing: 0.12em; color: #ddab43;">CURATED PACKAGES</span>
        <h1 class="kz-about-hero-title mb-1" style="font-size: 26px; font-weight: 800; color: #ffffff;">{{ $type }} Tours & Packages</h1>
        <ul class="kz-about-hero-breadcrumb d-flex justify-content-center align-items-center gap-2 list-unstyled mb-0" style="font-size: 12px; color: rgba(255,255,255,0.75);">
            <li><a href="{{ route('home') }}" style="color: #ffffff; text-decoration: none;">Home</a></li>
            <li><i class="ti ti-chevron-right" style="font-size: 10px;"></i></li>
            <li style="color: #ddab43;">{{ $type }}</li>
        </ul>
    </div>
</div>

    <!--==============================
Team Area  
==============================-->
    <!--==============================
Product Area
==============================-->
    <section class="py-2">
        <div class="container">
            <div class="th-sort-bar">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-5">
                        <div class="search-form-area">
                            <form class="search-form"  method="GET" action="{{ route('home.tour') }}">
                                <input type="text"  name="search" placeholder="Search" >
                                <button type="submit"><i class="fa-light fa-magnifying-glass"></i></button>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-auto">
                        <div class="sorting-filter-wrap">
                            <div class="nav" role="tablist">
                                <a class="active" href="#" id="tab-destination-grid" data-bs-toggle="tab" data-bs-target="#tab-grid" role="tab" aria-controls="tab-grid" aria-selected="true"><i class="fa-light fa-grid-2"></i></a>

                                <a href="#" id="tab-destination-list" data-bs-toggle="tab" data-bs-target="#tab-list" role="tab" aria-controls="tab-list" aria-selected="false" class=""><i class="fa-solid fa-list"></i></a>
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
        <div class="tab-pane fade active show" id="tab-grid" role="tabpanel" aria-labelledby="tab-tour-grid">
            <div class="row g-3">
                 @foreach($states as $state)
                <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                    <div class="swiper-slide">
                        <div class="kaw-cat-card">
                            <div class="kaw-cat-card-img-wrap">
                                <img class="kaw-cat-card-img" src="{{ asset('storage/' . $state->image) }}" alt="{{ $state->name }}">
                            </div>
                            <div class="kaw-cat-card-content">
                                <h3 class="kaw-cat-card-title">
                                    <a href="{{ route('home.tour.state', $state->slug) }}">{{ $state->name }}</a>
                                </h3>
                                <a class="kaw-cat-action-btn" href="{{ route('home.tour.state', $state->slug) }}">
                                    View Tours <i class="ti ti-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="tab-pane fade" id="tab-list" role="tabpanel" aria-labelledby="tab-tour-list">
            <div class="row gy-30">
                @foreach($states as $state)
                <div class="col-md-12">
                    <div class="swiper-slide">
                        <div class="kaw-cat-card">
                            <div class="kaw-cat-card-img-wrap">
                                <img class="kaw-cat-card-img" src="{{ asset('storage/' . $state->image) }}" alt="{{ $state->name }}">
                            </div>
                            <div class="kaw-cat-card-content">
                                <h3 class="kaw-cat-card-title">
                                    <a href="{{ route('home.tour.state', $state->slug) }}">{{ $state->name }}</a>
                                </h3>
                                <a class="kaw-cat-action-btn" href="{{ route('home.tour.state', $state->slug) }}">
                                    View Tours <i class="ti ti-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        {{ $states->links() }}
    </div>
</div>
               {{-- 
<div class="col-xxl-4 col-lg-5">
    <aside class="sidebar-area">
        <div class="widget widget_categories">
            <h3 class="widget_title">Locations</h3>
            <ul>
                <ul>
                    @foreach($locations as $location)
                    <li>
                        <a href="{{ url('destinations.index', ['search' => $location->location]) }}">
                            <img src="{{ asset('webassets/img/theme-img/map.svg') }}" alt="">
                            {{ $location->location }}
                        </a>
                        <span>({{ $location->count }})</span>
                    </li>
                    @endforeach
                </ul>
            </ul>
        </div>

        <div class="widget widget_offer" data-bg-src="{{ asset('webassets/img/bg/widget_bg_1.jpg') }}">
            <div class="offer-banner">
                <div class="offer">
                    <h6 class="box-title">Need Help? We Are Here To Help You</h6>

                    <div class="banner-logo">
                        <img src="{{ asset('storage/' . $setting->header_logo) }}" alt="Tourm">
                    </div>

                    <div class="offer">
                        <h6 class="offer-title">You Get Online support</h6>
                        <a class="offter-num" href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a>
                    </div>

                    <a href="{{ route('home.contact') }}" class="th-btn style2 th-icon">
                        Read More
                    </a>
                </div>
            </div>
        </div>
    </aside>
</div>
--}}

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