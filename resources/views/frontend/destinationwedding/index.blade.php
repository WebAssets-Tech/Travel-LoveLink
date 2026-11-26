@extends('frontend.layouts.app')
@section('page_title', $title)
@section('page_meta')  
{!! generateMetaTagsSimple($title,$setting) !!} 
@endsection 
@section('content')

    <!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper " {!! breadcrumbBgAttrs(getImageByType(request()->segment(1), $setting ?? null), $setting ?? null) !!}>
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ $title }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>{{ $title }}</li>
                </ul>
            </div>
        </div>
    </div><!--==============================
Product Area
==============================-->
    <section class="space">
        <div class="container">
            <div class="th-sort-bar">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-4">
                        <div class="search-form-area" method="GET" action="{{ route('home.destinationwedding') }}">
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
                             
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-9 col-lg-8">
                    <div class="tab-content" id="nav-tabContent">
                    @if ($destinationweddings->count() > 0)
                        <div class="tab-pane fade active show" id="tab-grid" role="tabpanel" aria-labelledby="tab-destination-grid">
                            <div class="row gy-30">
                            @foreach ($destinationweddings as $destinationwedding)
                                <div class="col-xxl-4 col-xl-6">
                                    <div class="tour-box th-ani">
                                        <div class="tour-box_img global-img">
                                            <img src="{{ asset('storage/' . $destinationwedding->image) }}" alt="image">
                                        </div>
                                        <div class="tour-content">
                                            <h3 class="box-title"><a href="{{ route('home.destinationweddingdetails',$destinationwedding->slug) }}">{{ $destinationwedding->title }}</a></h3>
                                             
                                            <h4 class="tour-box_price">{{ $destinationwedding->location }}</h4>
                                            <div class="tour-action"> 
                                                <a href="{{ route('home.destinationweddingdetails',$destinationwedding->slug) }}" class="th-btn style4 th-icon">Book Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
 

                            </div>
                        </div>

                        <div class="tab-pane fade " id="tab-list" role="tabpanel" aria-labelledby="tab-destination-list">
                            <div class="row gy-30">
                            @foreach ($destinationweddings as $destinationwedding)
                                <div class="col-12">
                                    <div class="tour-box style-flex th-ani">
                                        <div class="tour-box_img global-img">
                                            <img src="{{ asset('storage/' . $destinationwedding->image) }}" alt="image">
                                        </div>
                                        <div class="tour-content">
                                            <h3 class="box-title"><a href="{{ route('home.hoteldetails',$destinationwedding->slug) }}">{{ $destinationwedding->name }}</a></h3>
                                             
                                            <h4 class="tour-box_price">{{ $destinationwedding->location }}</h4>
                                            <div class="tour-action"> 
                                                <a href="{{ route('home.destinationweddingdetails',$destinationwedding->slug) }}" class="th-btn style4 th-icon">Book Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
 

                            </div>
                        </div>
                        @else
                            <p>No destination wedding found.</p>
                        @endif

                    </div>
                    <!-- Pagination Links -->
                    <div class="pagination  text-center mt-60 mb-0">
                        {{ $destinationweddings->links() }}
                    </div>
                    <?php /* <div class="th-pagination text-center mt-60 mb-0">
                        <ul>
                            <li><a class="active" href="blog.html">1</a></li>
                            <li><a href="blog.html">2</a></li>
                            <li><a href="blog.html">3</a></li>
                            <li><a href="blog.html">4</a></li>
                            <li><a class="next-page" href="blog.html">Next <img src="assets/img/icon/arrow-right4.svg" alt=""></a></li>
                        </ul>
                    </div>*/ ?>
                </div>
                <div class="col-xxl-3 col-lg-4">
                    <aside class="sidebar-area style2"> 
                        <div class="widget widget_categories  ">
                            <h3 class="widget_title">Location</h3>
                            <ul>
                                @foreach($weddinglocations as $location)
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
    </section>
    @endsection