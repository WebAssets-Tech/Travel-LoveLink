@extends('frontend.layouts.app')
@section('page_title', $blog->meta_title)

@section('page_meta')  
{!! generateMetaTags($blog) !!} 
@endsection
@section('content')

    <!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper " data-bg-src="{{ asset('storage/' . $blog->page_bg_image) }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ $blog->title }}</h1>
                <ul class="breadcumb-menu">
                <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('home.blogs') }}">Blogs</a></li>
                    <li>{{ $blog->title }}</li>
                </ul>
            </div>
        </div>
    </div><!--==============================
        Blog Area
    ==============================-->
    <section class="th-blog-wrapper blog-details space-top space-extra-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-lg-7">
                    <div class="th-blog blog-single">
                        <div class="blog-img">
                            <img src="{{ asset('storage/' . $blog->banner_image) }}" alt="Blog Image">
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <a class="author" href="{{ route('home.blogs', ['search' => $blog->author]) }}"><i class="fa-light fa-user"></i>by {{ $blog->author }}</a>
                                <a href="#"><i class="fa-regular fa-calendar"></i>{{ \Carbon\Carbon::parse($blog->published_at)->format('F d, Y') }}</a>
                                <a href="{{ route('home.blogs', ['search' => $blog->category]) }}"><img src="{{ asset('webassets/img/icon/map.svg') }}" alt="">{{ $blog->category }}</a>
                            </div>
                            <h2 class="blog-title">{{ $blog->title }}</h2>
                            <p class="blog-text mb-30">{!! $blog->content !!}</p>

                            @if(!empty($blog->youtube_link))
                                @php $embedUrl = getYoutubeEmbedUrl($blog->youtube_link); @endphp
                                @if(!empty($embedUrl))
                                    <div class="blog-video-wrap mb-30" style="position:relative; padding-bottom:56.25%; height:0; overflow:hidden; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.12); margin-top:20px;">
                                        <iframe src="{{ $embedUrl }}" title="{{ $blog->title }} Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen style="position:absolute; top:0; left:0; width:100%; height:100%; border:none;"></iframe>
                                    </div>
                                @endif
                            @endif

                            <div class="share-links clearfix ">
                                <div class="row justify-content-between">
                                    <div class="col-md-auto">
                                        <span class="share-links-title">Tags:</span>
                                        <div class="tagcloud">
                                            @foreach(explode(',', $blog->tags) as $tag)
                                                <a href="{{ route('home.blogs', ['search' => trim($tag)]) }}">{{ ucfirst(trim($tag)) }}</a>
                                            @endforeach 
                                        </div>
                                    </div>
                                    <div class="col-md-auto text-xl-end">
                                        <div class="share-links_wrapp">
                                            <span class="share-links-title">Share:</span>
                                            <div class="social-links">
                                                @php
                                                    $blogTitle = urlencode($blog->title);
                                                    $blogUrl = urlencode(url()->current());
                                                @endphp

                                                <!-- Facebook Share -->
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $blogUrl }}&quote={{ $blogTitle }}" target="_blank">
                                                    <i class="fab fa-facebook-f"></i>
                                                </a>

                                                <!-- Twitter Share -->
                                                <a href="https://twitter.com/intent/tweet?url={{ $blogUrl }}&text={{ $blogTitle }}" target="_blank">
                                                    <i class="fab fa-twitter"></i>
                                                </a>

                                                <!-- LinkedIn Share -->
                                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $blogUrl }}" target="_blank">
                                                    <i class="fab fa-linkedin-in"></i>
                                                </a>

                                                <!-- WhatsApp Share -->
                                                <a href="https://api.whatsapp.com/send?text={{ $blogTitle }}%20{{ $blogUrl }}" target="_blank">
                                                    <i class="fab fa-whatsapp"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Share Links Area end -->
                                </div>
                            </div>
                        </div>


                    </div>
                     
                </div>
                <div class="col-xxl-4 col-lg-5">
                    <aside class="sidebar-area">
                        <div class="widget widget_search  ">
                            <form class="search-form" method="GET" action="{{ route('home.blogs') }}" >
                                <input type="text" name="search" placeholder="Search">
                                <button type="submit"><i class="far fa-search"></i></button>
                            </form>
                        </div>
                        <div class="widget widget_categories  ">
                            <h3 class="widget_title">Categories</h3>
                            <ul>
                                @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('home.blogs', ['search' => $category->category]) }}"><img src="{{ asset('webassets/img/theme-img/map.svg') }}" alt="">{{ $category->category }}</a>
                                    <span>({{ $category->count }})</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="widget  ">
                            <h3 class="widget_title">Recent Posts</h3>
                            <div class="recent-post-wrap">
                                @foreach($recentBlogs as $recentBlog)
                                <div class="recent-post">
                                    <div class="media-img">
                                        <a href="{{ route('blog.details', $recentBlog->slug) }}"><img src="{{ asset('storage/' . $recentBlog->image) }}" alt="Blog Image"></a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="post-title"><a class="text-inherit" href="{{ route('blog.details', $recentBlog->slug) }}">{{ $recentBlog->title }}</a></h4>
                                        <div class="recent-post-meta">
                                            <a href="{{ route('blog.details', $recentBlog->slug) }}"><i class="fa-regular fa-calendar"></i>{{ \Carbon\Carbon::parse($recentBlog->published_at)->format('F d, Y') }}</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach 
                            </div>
                        </div>
                        <div class="widget widget_tag_cloud  ">
                            <h3 class="widget_title">Popular Tags</h3>
                            <div class="tagcloud">
                                @foreach($uniqueTags as $tag)
                                    <a href="{{ route('home.blogs', ['search' => $tag ]) }}">{{ $tag }}</a>
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
        <div class="shape-mockup shape1 d-none d-xxl-block" data-bottom="5%" data-right="8%">
            <img src="{{ asset('webassets/img/shape/shape_1.png') }}" alt="shape">
        </div>
        <div class="shape-mockup shape2 d-none d-xl-block" data-bottom="1%" data-right="7%">
            <img src="{{ asset('webassets/img/shape/shape_2.png') }}" alt="shape">
        </div>
        <div class="shape-mockup shape3 d-none d-xxl-block" data-bottom="2%" data-right="4%">
            <img src="{{ asset('webassets/img/shape/shape_3.png') }}" alt="shape">
        </div>
    </section>
    @endsection
