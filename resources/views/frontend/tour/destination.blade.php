@extends('frontend.layouts.app')
@section('page_title', $destination->meta_title)
@section('page_meta')  
{!! generateMetaTags($destination) !!} 
@endsection
@section('content')

    <!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper " {!! breadcrumbBgAttrs(!empty($destination->page_bg_image) ? asset('storage/' . $destination->page_bg_image) : getImageByType(request()->segment(1), $setting ?? null), $setting ?? null) !!}>
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ $destination->title }} Tours</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home')}}">Home</a></li>
                    <li><a href="{{ route('destinations.index') }}">Destinations</a></li>
                    <li><a href="{{ route('destination.details',$destination->slug) }}">{{ $destination->title }}</a></li>
                    <li>Tours</li>
                </ul>
            </div>
        </div>
    </div>
    <!--==============================
Team Area  
==============================-->
    <!--==============================
Product Area
==============================-->
    <section class="space">
        <div class="container">
            <div class="th-sort-bar">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-4">
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
                <div class="col-xxl-8 col-lg-7">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="tab-grid" role="tabpanel" aria-labelledby="tab-tour-grid">
                            <div class="row gy-24 gx-24">
                                @foreach($tours as $tour)
                                <div class="col-md-6">
                                    <div class="tour-box th-ani">
                                        <div class="tour-box_img global-img">
                                            <img src="{{ asset('storage/' . $tour->image) }}" alt="image">
                                        </div>
                                        <div class="tour-content">
                                            <h3 class="box-title"><a href="{{ route('tour.details',$tour->slug) }}">{{ $tour->title }}</a></h3>
                                            <div class="tour-rating">
                                                <div class="star-rating" role="img" aria-label="Rated {{ number_format($tour->rating ?? 4.8, 1) }} out of 5"><span style="width:{{ (($tour->rating ?? 4.8) / 5) * 100 }}%">Rated
                                                        <strong class="rating">{{ number_format($tour->rating ?? 4.8, 1) }}</strong> out of 5 based on <span class="rating">{{ number_format($tour->rating ?? 4.8, 1) }}</span>({{ number_format($tour->rating ?? 4.8, 1) }}
                                                        Rating)</span></div>
                                                <a href="{{ route('tour.details',$tour->slug) }}" class="woocommerce-review-link">(<span class="count">{{ number_format($tour->rating ?? 4.8, 1) }}</span>
                                                    Rating)</a>
                                            </div>
                                            <h4 class="tour-box_price"><span class="currency">{{ $tour->formatted_price }}</span>/Person</h4>
                                            <div class="tour-action">
                                                <span><i class="fa-light fa-clock"></i>{{ $tour->duration }}  Days</span>
                                                <a href="{{ route('tour.details',$tour->slug) }}" class="th-btn style4">Detail View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach      


                            </div>
                        </div>

                        <div class="tab-pane fade " id="tab-list" role="tabpanel" aria-labelledby="tab-tour-list">
                            <div class="row gy-30">
                            @foreach($tours as $tour)
                                <div class="col-12">
                                    <div class="tour-box style-flex th-ani">
                                        <div class="tour-box_img global-img">
                                            <img src="{{ asset('storage/' . $tour->image) }}" alt="image">
                                        </div>
                                        <div class="tour-content">
                                            <h3 class="box-title"><a href="{{ route('tour.details',$tour->slug) }}">{{ $tour->title }}</a></h3>
                                            <div class="tour-rating">
                                                <div class="star-rating" role="img" aria-label="Rated {{ number_format($tour->rating ?? 4.8, 1) }} out of 5"><span style="width:{{ (($tour->rating ?? 4.8) / 5) * 100 }}%">Rated
                                                        <strong class="rating">{{ number_format($tour->rating ?? 4.8, 1) }}</strong> out of 5 based on <span class="rating">{{ number_format($tour->rating ?? 4.8, 1) }}</span>({{ number_format($tour->rating ?? 4.8, 1) }}
                                                        Rating)</span></div>
                                                <a href="{{ route('tour.details',$tour->slug) }}" class="woocommerce-review-link">(<span class="count">{{ number_format($tour->rating ?? 4.8, 1) }}</span>
                                                    Rating)</a>
                                            </div>
                                            <h4 class="tour-box_price"><span class="currency">{{ $tour->formatted_price }}</span>/Person</h4>
                                            <div class="tour-action">
                                                <span><i class="fa-light fa-clock"></i>7 Days</span>
                                                <a href="{{ route('tour.details',$tour->slug) }}" class="th-btn style4">Detail View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach 
 

                            </div>
                        </div>
                        {{ $tours->links() }}
                        <?php /*<div class="th-pagination text-center mt-60">
                            <ul>
                                <li><a class="active" href="blog.html">1</a></li>
                                <li><a href="blog.html">2</a></li>
                                <li><a href="blog.html">3</a></li>
                                <li><a href="blog.html">4</a></li>
                                <li><a class="next-page" href="blog.html">Next <img src="assets/img/icon/arrow-right4.svg" alt=""></a></li>
                            </ul>
                        </div>*/ ?>
                    </div>
                </div>
                <div class="col-xxl-4 col-lg-5">
                    <aside class="sidebar-area">
                        <div class="widget widget_categories  ">
                            <h3 class="widget_title">Categories</h3>
                            <ul>
                                <ul>
                                    @foreach($locations as $location)
                                    <li>
                                        <a href="{{ route('destinations.index', ['search' => $location->location]) }}"><img src="{{ asset('webassets/img/theme-img/map.svg') }}" alt="">{{ $location->location }}</a>
                                        <span>({{ $location->count }})</span>
                                    </li>
                                    @endforeach 
                                </ul> 
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