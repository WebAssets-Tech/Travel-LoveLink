@extends('frontend.layouts.app')
@section('page_title', $touristguide->meta_title) 
@section('page_meta')  
{!! generateMetaTags($touristguide) !!} 
@endsection
@section('content')
<!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper " {!! breadcrumbBgAttrs(!empty($touristguide->page_bg_image) ? asset('storage/' . $touristguide->page_bg_image) : getImageByType(request()->segment(1), $setting ?? null), $setting ?? null) !!}>
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ $touristguide->name }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home')}}">Home</a></li>
                    <li>{{ $touristguide->name }}</li>
                </ul>
            </div>
        </div>
    </div><!--==============================
Team Area  
==============================-->
    <section class="space">
        <div class="container">
            <div class="team-details">
                <div class="row gy-5 mb-3 mb-xl-5 pb-xl-4">
                    <div class="col-xl-4">
                        <div class="th-team team-grid">
                            <div class="team-img">
                                <img src="{{ asset('storage/' . $touristguide->banner_image) }}" alt="Team">
                            </div>
                            <div class="team-img2">
                                <img src="{{ asset('storage/' . $touristguide->image) }}" alt="Team">
                            </div>
                            <div class="team-content">
                                <div class="media-body">
                                    <h3 class="box-title"><a href="#">{{ $touristguide->name }}</a></h3>
                                    <span class="team-desig">{{$touristguide->designation ?? "Tourist"}}</span>


                                    <div class="th-social">
                                        @php
                                            $social_link = json_encode($touristguide->social_link, true) ?? [];
                                            $social_link = json_decode($social_link) ?? []; 
                                        @endphp
                                        @if(!empty($social_link))
                                            @foreach($social_link as $index => $item)
                                            <a target="_blank" href="{{ $item->social_link ?? '' }}" title="{{ $item->social_name }}" ><i class="{{ $item->social_icon  ?? '' }}"></i></a>
                                            @endforeach
                                        @endif 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 ps-3 ps-xl-5 pe-xl-4">
                        <div class="team-about">
                            <h2 class="team-about_title">About Me</h2>
                            <p class="team-about_text mb-25">{!! $touristguide->bio !!}</p>
                            <div class="counter-box-wrap">
                                
                                @if(!empty($touristguide->details_counter))
                                    @foreach($touristguide->details_counter as $index => $item)
                                    <div class="counter-box">
                                        <h2 class="counter-box_number"><span class="counter-number">{{ $item['count_number'] ?? '' }}</span>{{ $item['count_sufix'] ?? '' }} </h2>
                                        <span class="counter-box_title">{{ $item['count_text'] ?? '' }}</span>
                                    </div>
                                    @endforeach
                                @endif 
                            </div>
                        </div>
                    </div>
                </div>
                <h2 class="box-title mb-30">Contact With Me</h2>
                <div class="row gy-4 justify-content-center">
                    <div class="col-xl-4 col-lg-6">
                        <div class="about-contact-grid style2">
                            <div class="about-contact-icon">
                                <img src="{{ asset('webassets/img/icon/location-dot2.svg')}}" alt="">
                            </div>
                            <div class="about-contact-details">
                                <h6 class="box-title">Our Address</h6>
                                <p class="about-contact-details-text">{{ $touristguide->address }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div class="about-contact-grid">
                            <div class="about-contact-icon">
                                <img src="{{ asset('webassets/img/icon/call.svg')}}" alt="">
                            </div>
                            <div class="about-contact-details">
                                <h6 class="box-title">Phone Number</h6>
                                <p class="about-contact-details-text"><a href="tel:{{ $touristguide->phone }}">{{ $touristguide->phone }}</a></p>
                                <p class="about-contact-details-text"><a href="tel:{{ $touristguide->phone2 }}">{{ $touristguide->phone2 }}</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div class="about-contact-grid">
                            <div class="about-contact-icon">
                                <img src="{{ asset('webassets/img/icon/mail.svg')}}" alt="">
                            </div>
                            <div class="about-contact-details">
                                <h6 class="box-title">Email Address</h6>
                                <p class="about-contact-details-text"><a href="mailto:{{ $touristguide->email }}">{{ $touristguide->email }}</a></p>
                                <p class="about-contact-details-text"><a href="mailto:{{ $touristguide->email2 }}">{{ $touristguide->email2 }}</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!--==============================
Team Area  
==============================-->
    <section class="team-area3 position-relative bg-top-center space" data-bg-src="{{ asset('webassets/img/bg/team_bg_2.jpg')}}">
        <div class="container z-index-common">
            <div class="title-area text-center">
                <span class="sub-title">Meet with Guide</span>
                <h2 class="sec-title">Meet with Tour Guide</h2>
            </div>
            <div class="slider-area">
                <div class="swiper th-slider teamSlider3 has-shadow" id="teamSlider3" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"}}}'>
                    <div class="swiper-wrapper">
                    @foreach($moreGuide as  $guide)
                        <!-- Single Item -->
                        <div class="swiper-slide">
                            <div class="th-team team-grid">
                                <div class="team-img">
                                    <img src="{{ asset('storage/' . $guide->banner_image) }}" alt="Team">
                                </div>
                                <div class="team-img2">
                                    <img src="{{ asset('storage/' . $guide->image) }}" alt="Team">
                                </div>
                                <div class="team-content">
                                    <div class="media-body">
                                        <h3 class="box-title"><a href="{{ route('home.guidedetails',$guide->slug ) }}">{{ $guide->name }}</a></h3>
                                        <span class="team-desig">Tourist Guide</span>


                                        <div class="th-social"> 
                                            @php
                                            $social_link = json_encode($guide->social_link, true) ?? [];
                                            $social_link = json_decode($social_link) ?? []; 
                                            @endphp
                                            @if(!empty($social_link))
                                                @foreach($social_link as $index => $item)
                                                <a target="_blank" href="{{ $item->social_link ?? '' }}" title="{{ $item->social_name }}" ><i class="{{ $item->social_icon  ?? '' }}"></i></a>
                                                @endforeach
                                            @endif 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
 

                    </div>

                    <div class="slider-pagination"></div>

                </div>
                <button data-slider-prev="#teamSlider3" class="slider-arrow slider-prev"><img src="{{ asset('webassets/img/icon/right-arrow2.svg')}}" alt=""></button>
                <button data-slider-next="#teamSlider3" class="slider-arrow slider-next"><img src="{{ asset('webassets/img/icon/left-arrow2.svg')}}" alt=""></button>
            </div>
        </div>
    </section>
    @endsection