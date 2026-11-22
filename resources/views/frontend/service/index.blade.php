@extends('frontend.layouts.app')
@section('page_title', 'Destinations')
@section('page_meta')  
{!! generateMetaTagsSimple('Services',$setting) !!} 
@endsection 
@section('content')
<!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper " data-bg-src="{{ getImageByType(request()->segment(1),$setting) }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Services</h1>
                <ul class="breadcumb-menu">
                <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Services</li>
                </ul>
            </div>
        </div>
    </div><!--==============================
Destination Area  
==============================-->

    <section class="position-relative overflow-hidden space" id="destination-sec">
        <div class="container">
            <div class="row gy-4 gx-4">
                @foreach($services as $service)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="destination-item th-ani">
                        <div class="destination-item_img global-img">
                            <img src="{{ asset('storage/' . $service->image) }}" alt="image">
                        </div>
                        <div class="destination-content">
                            <h3 class="box-title"><a href="{{ route('service.details',$service->slug ) }}">{{ $service->title }}</a></h3> 
                            <a href="{{ route('service.details',$service->slug ) }}" class="th-btn style4 th-icon">Book Now</a>
                        </div>
                    </div>
                </div>
                @endforeach
 

            </div>
        </div>
        <div class="shape-mockup shape1 d-none d-xxl-block" data-bottom="17%" data-right="9%">
            <img src="{{ asset('webassets/img/shape/shape_1.png') }}" alt="shape">
        </div>
        <div class="shape-mockup shape2 d-none d-xl-block" data-bottom="8%" data-right="8%">
            <img src="{{ asset('webassets/img/shape/shape_2.png') }}" alt="shape">
        </div>
        <div class="shape-mockup shape3 d-none d-xxl-block" data-bottom="15%" data-right="4%">
            <img src="{{ asset('webassets/img/shape/shape_3.png') }}" alt="shape">
        </div>
    </section> <!--==============================
Service Area  
==============================-->

    <section class="position-relative bg-top-center overflow-hidden space" id="service-sec" data-bg-src="{{ asset('webassets/img/bg/tour_bg_1.jpg') }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="title-area text-center">
                        <span class="sub-title">Best Experience</span>
                        <h2 class="sec-title">Amazing Travel Experience</h2>
                    </div>
                </div>
            </div>
            <div class="nav nav-tabs tour-tabs" id="nav-tab" role="tablist">
                <button class="nav-link th-btn active" id="nav-step1-tab" data-bs-toggle="tab" data-bs-target="#nav-step1" type="button"><img src="{{ asset('webassets/img/icon/tour_icon_1.svg') }}" alt="">Tour Package</button>
                <button class="nav-link th-btn" id="nav-step2-tab" data-bs-toggle="tab" data-bs-target="#nav-step2" type="button"><img src="{{ asset('webassets/img/icon/tour_icon_2.svg') }}" alt="">Destination</button>
                <button class="nav-link th-btn" id="nav-step3-tab" data-bs-toggle="tab" data-bs-target="#nav-step3" type="button"><img src="{{ asset('webassets/img/icon/tour_icon_3.svg') }}" alt="">Tours Categories</button>
            </div>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-step1" role="tabpanel">
                    <div class="slider-area tour-slider ">
                        <div class="swiper th-slider has-shadow" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"},"1400":{"slidesPerView":"4"}}}'>
                            <div class="swiper-wrapper">
                            @foreach($tours as $tour)
                                <div class="swiper-slide">
                                    <div class="tour-box th-ani gsap-cursor">
                                        <div class="tour-box_img global-img">
                                            <img src="{{ asset('storage/' . $tour->image) }}" alt="image">
                                        </div>
                                        <div class="tour-content">
                                            <h3 class="box-title"><a href="{{ route('tour.details',$tour->slug) }}">{{ $tour->title }}</a></h3>
                                            <div class="tour-rating">
                                                <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5"><span style="width:100%">Rated
                                                        <strong class="rating">5.00</strong> out of 5 based on <span class="rating">4.8</span>(4.8
                                                        Rating)</span></div>
                                                <a href="{{ route('tour.details',$tour->slug) }}" class="woocommerce-review-link">(<span class="count">4.8</span>
                                                    Rating)</a>
                                            </div>
                                            <h4 class="tour-box_price"><span class="currency">{{ $tour->formatted_price }}</span>/Person</h4>
                                            <div class="tour-action">
                                                <span><i class="fa-light fa-clock"></i>{{ $tour->duration }} Days</span>
                                                <a href="{{ route('tour.details',$tour->slug) }}" class="th-btn style4 th-icon">Book Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach 

                            </div>

                            <div class="slider-pagination"></div>
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade" id="nav-step2" role="tabpanel">
                    <div class="slider-area tour-slider ">
                        <div class="swiper th-slider has-shadow" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"},"1400":{"slidesPerView":"4"}}}'>
                            <div class="swiper-wrapper">
                                @foreach($destinations as $destination)
                                <div class="swiper-slide">
                                    <div class="tour-box th-ani gsap-cursor">
                                        <div class="tour-box_img global-img">
                                            <img src="{{ asset('storage/' . $destination->image) }}" alt="image">
                                        </div>
                                        <div class="tour-content">
                                            <h3 class="box-title"><a href="{{ route('destination.details',$destination->slug) }}">{{ $destination->name }}</a></h3>
                                             
                                            <h4 class="tour-box_price"><span class="currency">{{ $destination->location }}</span></h4>
                                            <div class="tour-action"> 
                                                <a href="{{ route('destination.details',$destination->slug) }}" class="th-btn style4 th-icon">Book Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach 


                            </div>

                            <div class="slider-pagination"></div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-step3" role="tabpanel">
                    <div class="slider-area tour-slider ">
                        <div class="swiper th-slider has-shadow" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"},"1400":{"slidesPerView":"4"}}}'>
                            <div class="swiper-wrapper">
                            @foreach($categories as $category)
                                <div class="swiper-slide">
                                    <div class="tour-box th-ani gsap-cursor">
                                        <div class="tour-box_img global-img">
                                            <img src="{{ asset('storage/' . $category->image) }}" alt="image">
                                        </div>
                                        <div class="tour-content">
                                            <h3 class="box-title"><a href="tour-details.html">{{ $category->name }}</a></h3> 
                                            <div class="tour-action"> 
                                                <a href="tour-guider-details.html" class="th-btn style4 th-icon">Book Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                 


                            </div>

                            <div class="slider-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
     
    @endsection