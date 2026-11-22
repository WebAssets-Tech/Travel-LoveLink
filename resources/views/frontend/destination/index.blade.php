@extends('frontend.layouts.app')
@section('page_title', 'Destinations')
@section('page_meta')  
{!! generateMetaTagsSimple('Destinations',$setting) !!} 
@endsection 
@section('content')

    <!--==============================
    Breadcumb
============================== -->
{{-- <div class="breadcumb-wrapper " data-bg-src="{{ getImageByType(request()->segment(1),$setting) }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Destinations</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Destinations</li>
                </ul>
            </div>
        </div>
    </div>  --}}<!--==============================
Product Area
==============================-->
    <section style="padding:40px 0;" class="destinations-top">
        <div class="container">
            <div class="th-sort-bar">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-4">
                        <div class="search-form-area" method="GET" action="{{ route('destination.index') }}">
                            <form class="search-form">
                                <input type="text" name="search" placeholder="Search" value="{{ $search }}">
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
                            <?php /*<form class="woocommerce-ordering" method="get">
                                <select name="orderby" class="orderby" aria-label="destination order">
                                    <option value="menu_order" selected="selected">Default Sorting</option>
                                    <option value="popularity">Sort by popularity</option>
                                    <option value="rating">Sort by average rating</option>
                                    <option value="date">Sort by latest</option>
                                    <option value="price">Sort by price: low to high</option>
                                    <option value="price-desc">Sort by price: high to low</option>
                                </select>
                            </form>*/ ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
               <div class="col-xxl-12 col-lg-12">
    <div class="tab-content" id="nav-tabContent">
        @if ($destinations->count() > 0)

        <!-- Grid View -->
        <div class="tab-pane fade show active" id="tab-grid" role="tabpanel" aria-labelledby="tab-destination-grid">
            <div class="row g-3">
                @foreach ($destinations as $destination)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="dest-card">

                        {{-- Image with overlay title --}}
                        <div class="dest-card-img-wrap">
                            <img src="{{ asset('storage/' . $destination->image) }}"
                                 alt="{{ $destination->name }}">
                            <div class="dest-card-img-overlay">
                                <span class="dest-card-label">{{ strtoupper($destination->name) }}</span>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="dest-card-body">

                            {{-- Duration badge --}}
                            @if($destination->duration ?? null)
                            <div class="dest-duration">{{ $destination->duration }}</div>
                            @endif

                            {{-- Route --}}
                       {{--     @if($destination->location ?? null)
                            <div class="dest-route">{{ $destination->location }}</div>
                            @endif  --}}

                            {{-- Price + Button --}}
                            <div class="dest-card-footer">
                                <div class="dest-price-wrap">
                                    @if($destination->price ?? null)
                                    <span class="dest-price">₹{{ number_format($destination->price) }}.00</span>
                                    <span class="dest-price-label">Starting price per adult</span>
                                    @endif
                                </div>
                                <a href="{{ route('destination.details', $destination->slug) }}"
                                   class="dest-btn">View Details</a>
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- List View -->
        <div class="tab-pane fade" id="tab-list" role="tabpanel" aria-labelledby="tab-destination-list">
            <div class="row g-4">
                @foreach ($destinations as $destination)
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4">
                                <img src="{{ asset('storage/' . $destination->image) }}"
                                     class="img-fluid rounded-start w-100"
                                     alt="{{ $destination->name }}"
                                     style="height:250px;object-fit:cover;">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body d-flex flex-column h-100">
                                    <h5 class="card-title">
                                        <a href="{{ route('destination.details', $destination->slug) }}"
                                           class="text-decoration-none text-dark">
                                            {{ $destination->name }}
                                        </a>
                                    </h5>
                                    <p class="mb-2">⭐ 4.8 Rating</p>
                                    <p class="text-muted">{{ $destination->location }}</p>
                                    <div class="mt-auto">
                                        <a href="{{ route('destination.details', $destination->slug) }}"
                                           class="btn btn-primary">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @else
            <p>No destinations found.</p>
        @endif
    </div>

    <!-- Pagination -->
    <div class="pagination justify-content-center mt-5">
        {{ $destinations->links() }}
    </div>
</div>
           {{--     <div class="col-xxl-3 col-lg-4">
                    <aside class="sidebar-area style2">
                        <div class="widget widget_categories  ">
                            <h3 class="widget_title">Categories</h3>
                            <ul>
                                @foreach($locations as $location)
                                <li>
                                    <a href="{{ route('destinations.index', ['search' => $location->location]) }}"><img src="{{ asset('webassets/img/theme-img/map.svg') }}" alt="">{{ $location->location }}</a>
                                    <span>({{ $location->count }})</span>
                                </li>
                                @endforeach 
                            </ul>
                        </div>
                        <?php /* <div class="widget  ">
                            <h3 class="widget_title">Recent Posts</h3>
                            <div class="recent-post-wrap">
                                <div class="recent-post">
                                    <div class="media-img">
                                        <a href="blog-details.html"><img src="assets/img/blog/recent-post-1-1.jpg" alt="Blog Image"></a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="post-title"><a class="text-inherit" href="blog-details.html">Exploring The Green Spaces Of the island maldives</a></h4>
                                        <div class="recent-post-meta">
                                            <a href="blog.html"><i class="fa-regular fa-calendar"></i>22/6/ 2024</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="recent-post">
                                    <div class="media-img">
                                        <a href="blog-details.html"><img src="assets/img/blog/recent-post-1-2.jpg" alt="Blog Image"></a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="post-title"><a class="text-inherit" href="blog-details.html">Harmony With Nature Of Belgium Tour and travle</a></h4>
                                        <div class="recent-post-meta">
                                            <a href="blog.html"><i class="fa-regular fa-calendar"></i>25/6/ 2024</a>
                                        </div>

                                    </div>
                                </div>
                                <div class="recent-post">
                                    <div class="media-img">
                                        <a href="blog-details.html"><img src="assets/img/blog/recent-post-1-3.jpg" alt="Blog Image"></a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="post-title"><a class="text-inherit" href="blog-details.html">Exploring The Green Spaces Of Realar Residence</a></h4>
                                        <div class="recent-post-meta">
                                            <a href="blog.html"><i class="fa-regular fa-calendar"></i>27/6/ 2024</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget widget_tag_cloud  ">
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
                        </div>  */ ?>
                      <div class="widget widget_offer position-relative" data-bg-src="{{ asset('webassets/img/bg/widget_bg_1.jpg') }}">
    <div class="offer-banner text-center position-relative">
        <!-- Logo + Text (top-left corner) -->
        <div class="banner-logo position-absolute d-flex align-items-center" style="top:-74px; left:0px;">
            <img src="{{ asset('/storage/header_logo/3-1758969894-header_logo.png') }}" alt="Tourm" style="max-width:80px;">
            <p class="ms-2 mb-0 fw-semibold text-white" style="font-size:15px;">Love Link</p>
        </div>

        <!-- Offer content (centered text) -->
        <div class="offer mt-5 pt-4">
            <h6 class="box-title">Need Help? We Are Here To Help You</h6>
            <div class="offer mt-3">
                <h6 class="offer-title">For any assistance, reach out via live chat or call us directly at </h6>
                <a class="offter-num d-block" href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a>
            </div>
            <a href="{{ url('contact') }}" class="th-btn style2 th-icon mt-3">Contact us</a>
        </div>
    </div>
</div>


                    </aside>
                </div>   --}}

            </div>

        </div>
    </section>
    @endsection