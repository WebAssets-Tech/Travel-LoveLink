@extends('frontend.layouts.app')
@section('page_title', $page->meta_title ?? $page->title)
@section('page_meta')  
{!! generateMetaTags($page) !!} 
@endsection

@section('content')
@php
    $isLegalPage = in_array(strtolower($page->slug ?? ''), ['privacy-policy', 'term-condition', 'terms-and-conditions', 'terms-of-service', 'cancellation-policy']);

    $breadcrumbImage = null;
    if (!empty($page->page_bg_image)) {
        $breadcrumbImage = asset('storage/' . $page->page_bg_image);
    } elseif (!empty($page->banner_image)) {
        $breadcrumbImage = asset('storage/' . $page->banner_image);
    } else {
        $breadcrumbImage = getImageByType($page->slug ?? '', $setting);
    }
@endphp
<!--==============================
    Dynamic Breadcrumb Section
==============================-->
<div class="breadcumb-wrapper {{ useBreadcrumbColor($setting ?? null) ? '' : 'background-image' }}" 
     {!! breadcrumbBgAttrs($breadcrumbImage, $setting ?? null, true) !!}>
    <div class="container">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">{{ $page->title }}</h1>
            <ul class="breadcumb-menu">
                <li><a href="{{ route('home') }}">Home</a></li>
                @if($isLegalPage)
                    <li>Policies</li>
                @else
                    <li>Services</li>
                @endif
                <li>{{ $page->title }}</li>
            </ul>
        </div>
    </div>
</div>

<!--==============================
    Main Content Area
==============================-->
<section class="kz-policy-sec py-5">
    <div class="container">
        <div class="row g-4 align-items-start">
            <!-- Left Main Content Card -->
            <div class="col-lg-8 col-12">
                <article class="kz-policy-card">
                    <!-- Document Meta Header -->
                    <div class="kz-policy-doc-header">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="kz-doc-icon-wrap">
                                    @if($isLegalPage)
                                        <i class="fa-regular fa-file-lines"></i>
                                    @else
                                        <i class="fa-solid fa-award"></i>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="kz-doc-heading m-0">{{ $page->title }}</h3>
                                    <small class="text-muted">{{ $setting->name ?? 'Love Link Tour & Travels' }} • {{ $isLegalPage ? 'Legal Guidelines' : 'Verified Service Guide' }}</small>
                                </div>
                            </div>
                            <span class="kz-verified-badge">
                                <i class="fa-solid fa-circle-check text-success me-1"></i> {{ $isLegalPage ? 'Verified Policy' : 'Verified Service' }}
                            </span>
                        </div>
                    </div>

                    @if(!empty($page->banner_image))
                    <div class="kz-policy-banner-img mb-4">
                        <img src="{{ asset('storage/' . $page->banner_image) }}" alt="{{ $page->title }}" class="img-fluid rounded-3">
                    </div>
                    @endif

                    <!-- Rich Body Content -->
                    <div class="kz-policy-body-content">
                        {!! $page->content !!}
                    </div>

                    <!-- Trust Seal Footer -->
                    <div class="kz-policy-footer-seal">
                        <div class="kz-policy-brand-wrap">
                            <a href="{{ route('home') }}" class="kz-policy-footer-logo-link" title="{{ $setting->name ?? 'Love Link Tour & Travels' }}">
                                <img src="{{ asset('storage/' . ($setting->header_logo ?? $setting->footer_logo ?? 'header_logo/3-1793857550-header_logo.png')) }}" 
                                     alt="{{ $setting->name ?? 'Love Link' }}" 
                                     class="kz-policy-brand-logo" 
                                     loading="lazy">
                            </a>
                            <div class="kz-policy-brand-info">
                                <span class="kz-policy-brand-name">{{ $setting->name ?? 'Love Link Tour & Travels' }}</span>
                                <span class="kz-policy-copy-text">© {{ date('Y') }} All rights reserved • Govt. Certified Native Specialist</span>
                            </div>
                        </div>
                        <a href="{{ route('home.contact') }}" class="kz-policy-contact-btn">
                            <span>{{ $isLegalPage ? 'Need Legal Clarifications?' : 'Need Assistance?' }} Contact Us</span>
                            <i class="ti ti-arrow-right"></i>
                        </a>
                    </div>
                </article>
            </div>

            <!-- Right Sidebar -->
            <div class="col-lg-4 col-12">
                <div class="kz-policy-sidebar">
                    <!-- Quick Links Card -->
                    <div class="kz-sidebar-card mb-4">
                        <h5 class="kz-sidebar-title">
                            @if($isLegalPage)
                                <i class="fa-solid fa-scale-balanced me-2 text-primary"></i> Company Policies
                            @else
                                <i class="fa-solid fa-layer-group me-2 text-primary"></i> Explore More Services
                            @endif
                        </h5>
                        <ul class="kz-sidebar-links">
                            @php
                                $otherPages = \App\Models\Page::where('slug', '!=', $page->slug)->take(6)->get();
                            @endphp
                            @foreach($otherPages as $op)
                            <li>
                                <a href="{{ route('home.page', $op->slug) }}">
                                    <span>{{ $op->title }}</span>
                                    <i class="ti ti-chevron-right"></i>
                                </a>
                            </li>
                            @endforeach
                            <li>
                                <a href="{{ route('home.faq') }}">
                                    <span>Frequently Asked Questions</span>
                                    <i class="ti ti-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- 24/7 Help Desk Card -->
                    <div class="kz-sidebar-card kz-help-card mb-4">
                        <div class="text-center">
                            <div class="kz-help-icon-circle mb-3">
                                <i class="fa-solid fa-headset"></i>
                            </div>
                            <h5 class="mb-1 fw-bold text-white">Need Assistance?</h5>
                            <p class="small text-white-50 mb-3">Our dedicated travel concierge is available 24/7 to resolve your inquiries.</p>
                            <div class="d-grid gap-2">
                                <a href="https://wa.me/917006921780" target="_blank" class="kz-help-btn-wa">
                                    <i class="fa-brands fa-whatsapp me-2"></i> WhatsApp Support
                                </a>
                                <a href="tel:+917006921780" class="kz-help-btn-call">
                                    <i class="fa-solid fa-phone me-2"></i> Call: +91 70069 21780
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Trust Checklist -->
                    <div class="kz-sidebar-card">
                        <h6 class="fw-bold mb-3" style="color: #0B3D91;">Why Choose Love Link?</h6>
                        <ul class="kz-trust-list">
                            <li><i class="fa-solid fa-circle-check text-success me-2"></i> 100% Certified Native Operators</li>
                            <li><i class="fa-solid fa-circle-check text-success me-2"></i> Transparent No-Hidden-Fee Quotes</li>
                            <li><i class="fa-solid fa-circle-check text-success me-2"></i> Sanitized Private Fleet & Cab Network</li>
                            <li><i class="fa-solid fa-circle-check text-success me-2"></i> 24/7 Live On-Trip Customer Care</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
