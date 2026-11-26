@extends('frontend.layouts.app')
@section('page_title', $activity->meta_title) 
@section('page_meta')  
{!! generateMetaTags($activity) !!} 
@endsection
@section('content')
 <!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper " {!! breadcrumbBgAttrs(!empty($activity->page_bg_image) ? asset('storage/' . $activity->page_bg_image) : getImageByType(request()->segment(1), $setting ?? null), $setting ?? null) !!}>
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{$activity->title}}</h1>
                <ul class="breadcumb-menu">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ url('activity') }}">Activities</a></li>
                    <li>{{$activity->title}}</li>
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
                    <div class="tour-page-single">
                        <div class="slider-area tour-slider1">
                            <div class="swiper th-slider mb-4" id="tourSlider4" data-slider-options='{"effect":"fade","loop":true,"thumbs":{"swiper":".tour-thumb-slider"},"autoplayDisableOnInteraction":"true"}'>
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="tour-slider-img">
                                            <img src="{{ asset('storage/' . $activity->banner_image) }}" alt="img">
                                        </div>
                                    </div>
                                    
                                    @if(!empty($activity->gallery))
                                        @foreach(json_decode($activity->gallery) as $image)
                                        <div class="swiper-slide">
                                            <div class="tour-slider-img">
                                                <img src="{{ asset('storage/' . $image) }}" alt="img">
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif 
                                </div>
                            </div>
                            <div class="swiper th-slider tour-thumb-slider" data-slider-options='{"effect":"slide","loop":true,"breakpoints":{"0":{"slidesPerView":2},"576":{"slidesPerView":"2"},"768":{"slidesPerView":"3"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"}},"autoplayDisableOnInteraction":"true"}'>
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="tour-slider-img">
                                            <img src="{{ asset('storage/' . $activity->banner_image) }}" alt="Image">
                                        </div>
                                    </div>
                                    
                                    @if(!empty($activity->gallery))
                                        @foreach(json_decode($activity->gallery) as $image)
                                        <div class="swiper-slide">
                                            <div class="tour-slider-img">
                                                <img src="{{ asset('storage/' . $image) }}" alt="img">
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif  
                                </div>
                            </div>

                            <button data-slider-prev="#tourSlider4" class="slider-arrow style3 slider-prev"><img src="assets/img/icon/hero-arrow-left.svg" alt=""></button>
                            <button data-slider-next="#tourSlider4" class="slider-arrow style3 slider-next"><img src="assets/img/icon/hero-arrow-right.svg" alt=""></button>
                        </div>
                        <div class="page-content">
                            <div class="page-meta mb-45">
                                <a class="page-tag" href="#">Featured</a>
                                <span class="ratting"><i class="fa-sharp fa-solid fa-star"></i><span>4.8</span></span>
                            </div>
                            <h2 class="box-title">{{$activity->title}}</h2>
                            <p class="box-text mb-30">{!! $activity->description !!}</p>
                                
                            <div class="checklist mb-50">
                                <ul>
                                    @php
                                        $existingHighlights =  $activity->highlights ?? [];
                                    @endphp
                                    @if (!empty($existingHighlights))
                                        @foreach ($existingHighlights as $highlight)
                                            <li>{{ $highlight }}</li>
                                        @endforeach
                                    @endif 
                                </ul>
                            </div>
                            <h2 class="box-title">Important Information</h2> 
                            <div class="activities-checklist mb-50">
                                @php
                                    $existingImpor = $activity->important_info ?? [];
                                    $totalItems = count($existingImpor);
                                    $half = ceil($totalItems / 2);
                                @endphp
                                @if (!empty($existingImpor))
                                <div class="checklist style2">
                                    <ul>
                                        
                                        @foreach (array_slice($existingImpor, 0, $half) as $important_info)
                                            <li>{{ $important_info }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="checklist style2">
                                    <ul>
                                        @foreach (array_slice($existingImpor, $half) as $important_info)
                                            <li>{{ $important_info }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                            <h2 class="box-title">Included and Excluded</h2> 
                            <div class="destination-checklist">
                                <div class="checklist style2 style4">
                                    <ul>
                                        @php
                                            $include_exclude = json_encode($activity->include_exclude, true) ?? [];
                                            $include_exclude = json_decode($include_exclude) ?? []; 
                                        @endphp

                                        @if (!empty($include_exclude))
                                            @foreach ($include_exclude as $item)
                                                @if (isset($item->type) && $item->type == 0)
                                                    <li>{{ $item->title ?? '' }}</li>
                                                @endif
                                            @endforeach
                                        @endif
 
                                    </ul>
                                </div>
                                <div class="checklist style5">
                                    <ul>
                                        
                                    @php
                                            $include_exclude = json_encode( $activity->include_exclude, true) ?? [];
                                            $include_exclude = json_decode($include_exclude) ?? []; 
                                        @endphp

                                        @if (!empty($include_exclude))
                                            @foreach ($include_exclude as $item)
                                                @if (isset($item->type) && $item->type == 1)
                                                    <li>{{ $item->title ?? '' }}</li>
                                                @endif
                                            @endforeach
                                        @endif
 
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="location-map">
                            <h3 class="page-title mt-45 mb-30">Activity Location</h3>
                            <div class="contact-map">
                                <iframe src="{!!  $activity->map_link !!}" allowfullscreen="" loading="lazy"></iframe>
                                <div class="contact-icon">
                                    <img src="{{ asset('assets/img/icon/location-dot3.svg') }}" alt="">
                                </div>
                            </div>
                        </div>
                        <?php /*<div class="th-comments-wrap style2 d-none">
                            <h2 class="blog-inner-title h4">Reviews (3)</h2>
                            <ul class="comment-list">
                                <li class="th-comment-item">
                                    <div class="th-post-comment">
                                        <div class="comment-avater">
                                            <img src="assets/img/blog/comment-author-1.jpg" alt="Comment Author">
                                        </div>
                                        <div class="comment-content">
                                            <h3 class="name">Adam Jhon</h3>
                                            <div class="commented-wrapp">
                                                <span class="commented-on">20 Jun, 2024</span>
                                                <span class="commented-time">08:56pm </span>
                                                <span class="comment-review">
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                </span>
                                            </div>
                                            <p class="text">Credibly pontificate transparent quality vectors with quality mindshare. Efficiently
                                                architect worldwide strategic theme areas after user.</p>
                                            <div class="reply_and_edit">
                                                <i class="fa-solid fa-thumbs-up"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="children">
                                        <li class="th-comment-item">
                                            <div class="th-post-comment">
                                                <div class="comment-avater">
                                                    <img src="assets/img/blog/comment-author-4.jpg" alt="Comment Author">
                                                </div>
                                                <div class="comment-content">
                                                    <div class="">
                                                        <h3 class="name">Maria Willson</h3>
                                                        <div class="commented-wrapp">
                                                            <span class="commented-on">23 Jun, 2024</span>
                                                            <span class="commented-time">08:56pm </span>
                                                            <span class="comment-review">
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <p class="text">It is different from airport transfer or port transfer, which are services
                                                        that pick you up</p>
                                                    <div class="reply_and_edit">
                                                        <i class="fa-solid fa-thumbs-up"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li class="th-comment-item">
                                    <div class="th-post-comment">
                                        <div class="comment-avater">
                                            <img src="assets/img/blog/comment-author-5.jpg" alt="Comment Author">
                                        </div>
                                        <div class="comment-content">
                                            <div class="">
                                                <h3 class="name">Michel Edwards</h3>
                                                <div class="commented-wrapp">
                                                    <span class="commented-on">27 Jun, 2024</span>
                                                    <span class="commented-time">08:56pm </span>
                                                    <span class="comment-review">
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                        <i class="fa-solid fa-star"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <p class="text">Credibly pontificate transparent quality vectors with quality mindshare. Efficiently
                                                architect worldwide strategic theme areas after user.</p>
                                            <div class="reply_and_edit">
                                                <i class="fa-solid fa-thumbs-up"></i>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div> <!-- Comment end --> <!-- Comment Form -->
                        <div class="th-comment-form d-none">
                            <div class="row">
                                <h3 class="blog-inner-title h4 mb-2">Leave a Reply</h3>
                                <p class="mb-25">Your email address will not be published. Required fields are marked</p>
                                <div class="col-md-6 form-group">
                                    <input type="text" placeholder="Full Name*" class="form-control" required>
                                    <i class="far fa-user"></i>
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" placeholder="Your Email*" class="form-control" required>
                                    <i class="far fa-envelope"></i>
                                </div>
                                <div class="col-12 form-group">
                                    <input type="text" placeholder="Website" class="form-control" required>
                                    <i class="far fa-globe"></i>
                                </div>
                                <div class="col-12 form-group">
                                    <textarea placeholder="Comment*" class="form-control"></textarea>
                                    <i class="far fa-pencil"></i>
                                </div>
                                <div class="col-12 form-group">
                                    <input type="checkbox" id="html">
                                    <label for="html">Save my name, email, and website in this browser for the next time I
                                        comment.</label>
                                </div>
                                <div class="col-12 form-group mb-0">
                                    <button class="th-btn">Send Message<img src="assets/img/icon/plane2.svg" alt=""></button>
                                </div>
                            </div>
                        </div>*/ ?>
                    </div>
                </div>
                <div class="col-xxl-4 col-lg-5">
                    <aside class="sidebar-area style2">
                        <div class="widget widget_search  ">
                            <form class="search-form"   method="GET" action="{{ route('home.activity') }}">
                                <input type="text" name="search" placeholder="Search">
                                <button type="submit"><i class="far fa-search"></i></button>
                            </form>
                        </div>
                        <div class="widget widget_categories  ">
                            <h3 class="widget_title">More</h3>
                            <ul>
                                @foreach($recentActivity as $recentActivit)
                                <li>
                                    <a href="{{ route('activity.details',$recentActivit->slug) }}"><img src="assets/img/theme-img/map.svg" alt="">{{ $recentActivit->title }}</a>    
                                </li>
                                @endforeach 
                            </ul>
                        </div>
                        <div class="widget tour-booking  ">
                            <p class="widget_subtitle">From <span class="widget_price">{{ $activity->formatted_price }}</span></p>
                             
                            <a href="{{ route('home.contact') }}" class="th-btn th-icon">Book Now</a>
                            <span class="review"><i class="fa-light fa-heart"></i> 88% of travelers recommend this experience</span>
                        </div>
                        <?php /*<div class="widget widget_tag_cloud  ">
                            <h3 class="widget_title">Popular Tags</h3>
                            <div class="tagcloud">
                                <a href="blog.html">Tour</a>
                                <a href="blog.html">Adventure</a>
                                <a href="blog.html">Rent</a>
                                <a href="blog.html">Innovate</a>
                                <a href="blog.html">Hotel</a>
                                <a href="blog.html">Modern</a>
                                <a href="blog.html">Luxury</a>
                                <a href="blog.html">Travel</a>
                            </div>
                        </div>*/ ?>
                        <div class="widget widget_offer  " data-bg-src="{{ asset('webassets/img/bg/widget_bg_1.jpg')}}">
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
                                    <a href="{{ route('home.contact') }}" class="th-btn style2 th-icon">Read More</a>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>

            </div>

        </div>
    </section>
    @endsection