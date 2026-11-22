@extends('frontend.layouts.app')
@section('page_title', 'Blogs')
@section('page_meta')  
{!! generateMetaTagsSimple('Blogs',$setting) !!} 
@endsection 
@section('content')

    <!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper " data-bg-src="{{ getImageByType(request()->segment(1),$setting) }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Blogs</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Blogs</li>
                </ul>
            </div>
        </div>
    </div><!--==============================
Blog Area
==============================-->
    <section class="th-blog-wrapper space-top space-extra-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-lg-7">
                    @foreach($blogs as $blog)
                        <div class="th-blog blog-single has-post-thumbnail">
                            <div class="blog-img" style="position:relative;">
                                @if(!empty($blog->youtube_link))
                                    <span style="position:absolute; top:15px; right:15px; background:rgba(235, 23, 23, 0.9); color:#fff; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600; display:inline-flex; align-items:center; gap:5px; z-index:2;">
                                        <i class="fab fa-youtube"></i> Video
                                    </span>
                                @endif
                                <a href="{{ route('blog.details', $blog->slug) }}"><img src="{{ asset('storage/' . $blog->image) }}" alt="Blog Image"></a>
                            </div>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <a class="author" href="{{ route('blog.details', $blog->slug) }}"><i class="fa-light fa-user"></i>by {{ $blog->author }}</a>
                                    <a href="{{ route('blog.details', $blog->slug) }}"><i class="fa-solid fa-calendar-days"></i>{{ \Carbon\Carbon::parse($blog->published_at)->format('F d, Y') }}</a>
                                    <a href="{{ route('blog.details', $blog->slug) }}"><img src="{{ asset('assets/img/icon/map.svg') }}" alt="">{{ $blog->category }}</a>
                                </div>
                                <h2 class="blog-title"><a href="{{ route('blog.details', $blog->slug) }}">{{ $blog->title }}</a>
                                </h2>
                                <p class="blog-text">{!! \Illuminate\Support\Str::limit($blog->content, 150) !!}</p>
                                <a href="{{ route('blog.details', $blog->slug) }}" class="th-btn style4 th-icon">Read More</a>
                            </div>
                        </div>
                    @endforeach 

                    <div class="pagination  text-center mt-60 mb-0">
                        {{ $blogs->links() }}
                    </div>
                    <?php /*<div class="th-pagination ">
                        <ul>
                            <li><a class="active" href="blog.html">1</a></li>
                            <li><a href="blog.html">2</a></li>
                            <li><a href="blog.html">3</a></li>
                            <li><a href="blog.html">4</a></li>
                            <li><a class="next-page" href="blog.html">Next <img src="assets/img/icon/arrow-right4.svg" alt=""></a></li>
                        </ul>
                    </div>*/ ?>
                </div>
                <div class="col-xxl-4 col-lg-5">
                    <aside class="sidebar-area">
                        <div class="widget widget_search  ">
                            <form class="search-form" method="GET" action="{{ route('home.blogs') }}">
                                <input type="text"  name="search" placeholder="Search" value="{{ $search }}">
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
                         
                        <div class="widget widget_tag_cloud  ">
                            <h3 class="widget_title">Popular Tags</h3>
                            <div class="tagcloud">
                                @foreach($uniqueTags as $tag)
                                    <a href="{{ route('home.blogs', ['search' => $tag ]) }}">{{ $tag }}</a>
                                @endforeach 
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

@endsection

