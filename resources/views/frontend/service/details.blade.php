@extends('frontend.layouts.app')
@section('page_title', $service->meta_title)
@section('page_meta')  
{!! generateMetaTags($service) !!} 
@endsection
@section('content')
 <!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper " data-bg-src="{{ asset('storage/' . $service->page_bg_image) }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Service Details</h1>
                <ul class="breadcumb-menu">
                <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('home.service') }}">Services</a></li>
                    <li>{{ $service->title }}</li>
                </ul>
            </div>
        </div>
    </div><!--==============================
tour Area
==============================-->
    <section class="space">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-lg-7">
                    <div class="page-single">
                        <div class="service-img"><img src="{{ asset('storage/' . $service->banner_image) }}" alt=""></div>
                        <div class="page-content">
                            <div class="page-meta mt-50 mb-45">
                                <a class="page-tag" href="tour.html">Featured</a>
                                <span class="ratting"><i class="fa-sharp fa-solid fa-star"></i><span>4.8</span></span>
                            </div>
                            <h2 class="box-title">{{ $service->title }}</h2>
                            <p class="box-text mb-30">{!! $service->description !!}</p>
                            <div class="service-inner-img mb-40"><img src="{{ asset('storage/' . $service->banner_footer_image) }}" alt=""></div>
                            <h2 class="box-title">Highlights</h2>
                            <div class="checklist">
                                <ul>
                                    @php
                                        $existingHighlights =  $service->highlights ?? [];
                                    @endphp
                                    @if (!empty($existingHighlights))
                                        @foreach ($existingHighlights as $highlight)
                                            <li>{{ $highlight }}</li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        @if(!empty($service->gallery))
                        <div class="destination-gallery-wrapper">
                            <h3 class="page-title mt-30 mb-30">From our gallery</h3>
                            <div class="row gy-4 gallery-row filter-active">
                                @foreach(json_decode($service->gallery) as $image)
                                <div class="col-xxl-auto filter-item">
                                    <div class="gallery-box style3">
                                        <div class="gallery-img global-img">
                                            <img src="{{ asset('storage/' . $image) }}" alt="gallery image">
                                            <a href="{{ asset('storage/' . $image) }}" class="icon-btn popup-image"><i class="fal fa-magnifying-glass-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach  
                            </div>
                        </div>
                        @endif
                         
                    </div>
                </div>
                <div class="col-xxl-4 col-lg-5">
                    <aside class="sidebar-area style3">
                        <div class="widget widget_search  ">
                            <form class="search-form"  method="GET" action="{{ route('home.service') }}">
                                <input type="text" placeholder="Search"  name="search">
                                <button type="submit"><i class="far fa-search"></i></button>
                            </form>
                        </div>
                        <div class="widget widget_categories  ">
                            <h3 class="widget_title">Locations</h3>
                            <ul> 
                                @foreach($locations as $location)
                                <li>
                                    <a href="{{ route('destinations.index', ['search' => $location->location]) }}"><img src="{{ asset('webassets/img/theme-img/map.svg') }}" alt="">{{ $location->location }}</a>
                                    <span>({{ $location->count }})</span>
                                </li>
                                @endforeach 
                            </ul>
                        </div>
                        <div class="widget tour-booking  ">
                            <p class="widget_subtitle">From <span class="widget_price">{{ $service->formatted_price }}</span></p>
                            <div class="info-list d-none">
                                <ul>
                                    <li>
                                        <strong>Date </strong>
                                        <span>sun 15 June - Fri 20 July</span>
                                    </li>
                                    <li>
                                        <strong>Number of travelers</strong>
                                        <span>2 adults - 1 childeren - 1 room</span>
                                    </li>
                                </ul>
                            </div>
                            <a href="contact" class="th-btn th-icon">Book Now</a>
                            <span class="review"><i class="fa-light fa-heart"></i> 88% of travelers recommend this experience</span>
                        </div>
                        <div class="widget  ">
                            <h3 class="widget_title">More Services</h3>
                            <div class="recent-post-wrap">
                                @foreach($recentservice as $recentse)
                                <div class="recent-post">
                                    <div class="media-img">
                                        <a href="{{ route('service.details',$recentse->slug ) }}"><img src="{{ asset('storage/' . $recentse->image) }}" alt="Blog Image"></a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="post-title"><a class="text-inherit" href="{{ route('service.details',$recentse->slug ) }}">{{ $service->title }}</a></h4>
                                        <div class="recent-post-meta">
                                            <a href="{{ route('service.details',$recentse->slug ) }}"><i class="fa-regular fa-calendar"></i>{{ \Carbon\Carbon::parse($recentse->created_at)->format('F d, Y') }}</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach 
                            </div>
                        </div> 
                        <div class="widget widget_offer  " data-bg-src="{{ asset('webassets/img/bg/widget_bg_1.jpg') }}">
                            <div class="offer-banner">
                                <div class="offer">
                                    <h6 class="box-title">Need Help? We Are Here To Help You</h6>
                                    <div class="banner-logo">
                                        <img src="{{ asset('storage/' . $setting->header_logo) }}" alt="Tourm">
                                    </div>
                                    <div class="offer">
                                        <h6 class="offer-title">You Get Online support</h6>
                                        <a class="offter-num" href="{{ $setting->phone }}">{{ $setting->phone }}</a>
                                    </div>
                                    <a href="{{ route('home.contact') }}" class="th-btn style2 th-icon">Read More</a>
                                </div>
                            </div>
                        </div>
                    </aside>
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
    @endsection