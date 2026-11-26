@extends('frontend.layouts.app')
@section('page_title', 'Activities')
@section('page_meta')  
{!! generateMetaTagsSimple('Activities',$setting) !!} 
@endsection 
@section('content')
<!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper " {!! breadcrumbBgAttrs(getImageByType(request()->segment(1), $setting ?? null), $setting ?? null) !!}>
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Activities</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Activities</li>
                </ul>
            </div>
        </div>
    </div>
    <!--==============================
Product Area
==============================-->
    <section class="space">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-lg-7">
                    <div class="row gy-24 gx-24">
                    @foreach ($activities as $activity)
                        <div class="col-md-6">
                            <div class="tour-box th-ani">
                                <div class="tour-box_img global-img">
                                    <img src="{{ asset('storage/' . $activity->image) }}" alt="image">
                                </div>
                                <div class="tour-content">
                                    <h3 class="box-title"><a href="{{ route('activity.details',$activity->slug) }}">{{ $activity->title }}</a></h3>
                                    <div class="tour-rating">
                                    <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated {{ $activity->rating ?? 'N/A' }} out of 5">
                                                <span style="width:{{ ($activity->rating / 5) * 100 }}%">
                                                    Rated <strong class="rating">{{ number_format($activity->rating, 2) }}</strong> out of 5 
                                                    based on <span class="rating">{{ number_format($activity->rating, 1) }}</span> 
                                                    ({{ number_format($activity->rating, 1) }} Rating)
                                                </span>
                                            </div>
                                        </div>

                                        <a href="{{ route('activity.details',$activity->slug) }}" class="woocommerce-review-link">(<span class="count">4.8</span>
                                            Rating)</a>
                                    </div>
                                    <h4 class="tour-box_price"><span class="currency">{{ $activity->formatted_price }}</span>/Person</h4>
                                    <div class="tour-action">
                                        <span><i class="fa-light fa-clock"></i>{{ $activity->days }} Days</span>
                                        <a href="{{ route('activity.details',$activity->slug) }}" class="th-btn style4">Detail View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach 

                    <!-- Pagination Links -->
                    <div class="pagination  text-center mt-60 mb-0">
                        {{ $activities->links() }}
                    </div>
                    <?php /* 
                        <div class="th-pagination mt-60 mb-0 text-center">
                            <ul>
                                <li><a class="active" href="blog.html">1</a></li>
                                <li><a href="blog.html">2</a></li>
                                <li><a href="blog.html">3</a></li>
                                <li><a href="blog.html">4</a></li>
                                <li><a class="next-page" href="blog.html">Next <img src="assets/img/icon/arrow-right4.svg" alt=""></a></li>
                            </ul>
                        </div> */ ?>
                    </div>
                </div>
                <div class="col-xxl-4 col-lg-5">
                    <aside class="sidebar-area">
                        <div class="widget widget_search  ">
                            <form class="search-form"  method="GET" action="{{ route('home.activity') }}">
                                <input type="text" name="search" placeholder="Search" value="{{ $search }}">
                                <button type="submit"><i class="far fa-search"></i></button>
                            </form>
                        </div>
                        <?php /*<div class="widget widget_categories  ">
                            <h3 class="widget_title">Activity Type</h3>
                            <ul>
                                <li>
                                    <a href="blog.html"><i class="fa-light fa-square-check"></i>Food and drink</a>
                                    <span>(10)</span>
                                </li>
                                <li>
                                    <a href="blog.html"><i class="fa-light fa-square-check"></i>Entertainment</a>
                                    <span>(6)</span>
                                </li>
                                <li>
                                    <a href="blog.html"><i class="fa-light fa-square-check"></i>Sports</a>
                                    <span>(2)</span>
                                </li>
                                <li>
                                    <a href="blog.html"><i class="fa-light fa-square-check"></i>Nature and outdoors</a>
                                    <span>(7)</span>
                                </li>
                                <li>
                                    <a href="blog.html"><i class="fa-light fa-square-check"></i>Culture and events</a>
                                    <span>(9)</span>
                                </li>
                                <li>
                                    <a href="blog.html"><i class="fa-light fa-square-check"></i>Mountain Campaigning</a>
                                    <span>(10)</span>
                                </li>
                            </ul>
                        </div>
                        <div class="widget widget_price_filter  ">
                            <h4 class="widget_title">Filter By Price</h4>
                            <div class="price_slider_wrapper">
                                <div class="price_label">
                                    Price: <span class="from">$0 </span> — <span class="to">$1000</span>
                                </div>
                                <div class="price_slider"></div>
                            </div>
                        </div>
                        <div class="widget widget_categories  ">
                            <h3 class="widget_title">Duration</h3>
                            <ul>
                                <li>
                                    <a href="blog.html"><i class="fa-light fa-square-check"></i>Up to 2 hour</a>
                                    <span>(20)</span>
                                </li>
                                <li>
                                    <a href="blog.html"><i class="fa-light fa-square-check"></i>1 to 4 hour</a>
                                    <span>(24)</span>
                                </li>
                                <li>
                                    <a href="blog.html"><i class="fa-light fa-square-check"></i>4 hour to 1 day</a>
                                    <span>(25)</span>
                                </li>
                            </ul>
                        </div>
                        <div class="widget widget_categories  ">
                            <h3 class="widget_title">Duration</h3>
                            <ul>
                                <li>
                                    <a href="blog.html"><i class="fa-light fa-square-check"></i>Gozayan Tour, BD</a>
                                    <span>(26)</span>
                                </li>
                                <li>
                                    <a href="blog.html"><i class="fa-light fa-square-check"></i>Tourope UK</a>
                                    <span>(27)</span>
                                </li>
                                <li>
                                    <a href="blog.html"><i class="fa-light fa-square-check"></i>European Tours Limited</a>
                                    <span>(29)</span>
                                </li>
                            </ul>
                        </div> */ ?>
                    </aside>
                </div>

            </div>

        </div>
    </section>
    @endsection