@extends('frontend.layouts.app')
@section('page_title', $destinationwedding->meta_title) 
@section('page_meta')  
{!! generateMetaTags($destinationwedding) !!} 
@endsection
@section('content')


    <!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper " data-bg-src="{{ asset('storage/' . $destinationwedding->page_bg_image) }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ $destinationwedding->title }}</h1>
                <ul class="breadcumb-menu">
                <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route($rts) }}">{{ $title }}</a></li>
                    <li>{{ $destinationwedding->title }}</li>
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
                        <div class="service-img"><img src="{{ asset('storage/' . $destinationwedding->banner_image) }}" alt=""></div>
                        <div class="page-content">
                            <div class="page-meta mt-50 mb-45">
                                <a class="page-tag" href="{{ route('home.destinationwedding', ['search' => $destinationwedding->location]) }}">{{ $destinationwedding->location }}</a>
                                
                            </div>
                            <h2 class="box-title">{{ $destinationwedding->name }}</h2>
                            <p class="blog-text mb-30">{{ $destinationwedding->short_description ?? "Short"}}</p>

                            <p class="blog-text mb-30">{!! $destinationwedding->description !!}</p>
                             
                            <h2 class="box-title">Highlights</h2>
                            <div class="checklist">
                                <ul>
                                    @php
                                        $existingHighlights =  $destinationwedding->highlights ?? [];
                                    @endphp
                                    @if (!empty($existingHighlights))
                                        @foreach ($existingHighlights as $highlight)
                                            <li>{{ $highlight }}</li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        @if(!empty($destinationwedding->gallery))
                        <div class="destination-gallery-wrapper">
                            <h3 class="page-title mt-30 mb-30">From our gallery</h3>
                            <div class="row gy-4 gallery-row filter-active">
                                @foreach(json_decode($destinationwedding->gallery) as $image)
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
                            <form class="search-form"  method="GET" action="{{ route('home.destinationwedding') }}">
                                <input type="text"  name="search" placeholder="Search" >
                                <button type="submit"><i class="far fa-search"></i></button>
                            </form>
                        </div> 
                        <div class="widget widget_categories  ">
                            <h3 class="widget_title">Location</h3>
                            <ul>
                                @foreach($destinationweddinglocations as $location)
                                <li>
                                    <a href="{{ route('home.destinationwedding', ['search' => $location->location]) }}"><img src="{{ asset('webassets/img/theme-img/map.svg') }}" alt="">{{ $location->location }}</a>
                                    <span>({{ $location->count }})</span>
                                </li>
                                @endforeach 
                            </ul>
                        </div> 
                        <div class="widget widget_offer position-relative" data-bg-src="{{ asset('webassets/img/bg/widget_bg_1.jpg') }}">
    <div class="offer-banner text-center position-relative">

        <!-- Logo + Text aligned side-by-side -->
        <div class="d-flex align-items-center justify-content-center mb-3" style="gap:10px; position:absolute; top:-61px; left:2px;">
            <div class="banner-logo">
                <img src="{{ asset('storage/' . $setting->header_logo) }}" alt="Tourm" style="max-height:60px;">
            </div>
            <h5 class="m-0" style="color:#fff; font-weight:600;">Love Link</h5>
        </div>

        <div class="offer mt-5 pt-3">
            <h6 class="box-title">Need Help? We Are Here To Help You</h6>

            <div class="offer">
                <h6 class="offer-title">Chat with us anytime or call for quick support.</h6>
                <a class="offter-num" href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a>
            </div>

            <a href="{{ route('home.contact') }}" class="th-btn style2 th-icon mt-2">Contact us</a>
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