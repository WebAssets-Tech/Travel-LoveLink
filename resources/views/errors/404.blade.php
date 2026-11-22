@extends('frontend.layouts.app')
@section('page_title', 'Page Not Found')
@section('content')

    <!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper " data-bg-src="{{ asset('webassets/img/bg/breadcumb-bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Error Page</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Error Page</li>
                </ul>
            </div>
        </div>
    </div><!--==============================
Error Area 
==============================-->
    <section class="space bg-smoke">
        <div class="container">
            <div class="row flex-row-reverse align-items-center">
                <div class="col-lg-6">
                    <div class="error-img">
                        <img src="{{ asset('webassets/img/theme-img/error.svg') }}" alt="404 image">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="error-content">
                        <h2 class="error-title">Oops! Page Not Found</h2>
                        <h4 class="error-subtitle">This page seems to have slipped through a time portal</h4>
                        <p class="error-text">We appologize for any distruction to the space-time continuum. Feel free to journey back to our homepage</p>
                        <a href="{{ route('home') }}" class="th-btn style3"><img src="{{ asset('webassets/img/icon/right-arrow2.svg') }}" alt="">Go Back Home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection