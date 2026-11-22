@extends('frontend.layouts.app')
@section('page_title', 'About Us - Love Link Tours & Travels')
@section('page_meta')  
{!! generateMetaTagsSimple('About Us', $setting) !!} 
@endsection 

@section('content')
<!--==============================
    Compact Breadcrumb Header
==============================-->
<div class="kz-about-page-hero">
    <div class="container">
        <div class="kz-about-hero-content text-center">
            <span class="kz-about-hero-tag">About Our Journey</span>
            <h1 class="kz-about-hero-title">Discover Love Link Tours & Travels</h1>
            <ul class="kz-about-hero-breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><i class="ti ti-chevron-right"></i></li>
                <li>About Us</li>
            </ul>
        </div>
    </div>
</div>

<!--==============================
    Main Story Section (Compact & Refined)
==============================-->
<section class="kz-about-main-sec py-5" id="about-story">
    <div class="container">
        <div class="row align-items-stretch g-4 g-lg-5">
            <!-- Left Showcase Image Card -->
            <div class="col-lg-5 col-12 d-flex flex-column">
                <div class="kz-about-page-imgcard flex-grow-1">
                    @php
                        $aboutImages = is_string($setting->about_images) ? json_decode($setting->about_images, true) : ($setting->about_images ?? []);
                        $aboutImageOne = collect($aboutImages)->firstWhere('order', 1);
                        $firstImg = !empty($aboutImageOne['image']) ? $aboutImageOne['image'] : (isset($aboutImages[0]['image']) ? $aboutImages[0]['image'] : null);
                    @endphp

                    <div class="kz-about-page-imgframe">
                        @if($firstImg)
                            <img src="{{ asset('storage/' . $firstImg) }}" alt="About Love Link" class="kz-about-page-img">
                        @else
                            <img src="{{ asset('webassets/img/normal/about_1_1.jpg') }}" alt="About Love Link" class="kz-about-page-img">
                        @endif
                        <div class="kz-about-page-imgoverlay"></div>
                    </div>

                    <!-- Floating 14+ Years Badge -->
                    <div class="kz-about-page-badge">
                        <span class="kz-badge-number">14+</span>
                        <span class="kz-badge-text">Years Of Excellence</span>
                    </div>

                    <!-- Floating Verified Tag -->
                    <div class="kz-about-verified-tag">
                        <i class="fa-solid fa-shield-halved text-warning me-2"></i>
                        <span>Govt. Recognized Travel Operator</span>
                    </div>
                </div>
            </div>

            <!-- Right Content & Values -->
            <div class="col-lg-7 col-12">
                <div class="kz-about-content-wrap ps-lg-2">
                    <span class="kz-about-eyebrow">WHO WE ARE</span>
                    <h2 class="kz-about-page-heading">{{ $setting->about_title ?? 'We Are A Globally Renowned & Trusted Travel Agency' }}</h2>
                    <p class="kz-about-lead-desc">
                        {{ $setting->about_subtitle ?? 'Crafting authentic, unforgettable journeys across Kashmir, Ladakh, and beyond with passion, integrity, and local expertise.' }}
                    </p>

                    <div class="kz-about-page-body">
                        {!! $setting->about_content !!}
                    </div>

                    <!-- Compact Value Pills Grid -->
                    <div class="kz-about-pills-row row g-3 my-3">
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="kz-about-mini-pill">
                                <div class="kz-mini-ico"><i class="ti ti-compass"></i></div>
                                <div>
                                    <h6>Exclusive Trips</h6>
                                    <small>Custom Handcrafted Plans</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="kz-about-mini-pill">
                                <div class="kz-mini-ico"><i class="ti ti-user-check"></i></div>
                                <div>
                                    <h6>Expert Guides</h6>
                                    <small>Local Native Drivers & Team</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="kz-about-mini-pill">
                                <div class="kz-mini-ico"><i class="ti ti-shield-check"></i></div>
                                <div>
                                    <h6>Safety First</h6>
                                    <small>24/7 Dedicated Support</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Compact Numeric Stats Bar -->
                    <div class="kz-about-stats-bar">
                        <div class="kz-stat-item">
                            <h4>50,000+</h4>
                            <p>Happy Travelers</p>
                        </div>
                        <div class="kz-stat-divider"></div>
                        <div class="kz-stat-item">
                            <h4>2,500+</h4>
                            <p>Tour Packages</p>
                        </div>
                        <div class="kz-stat-divider"></div>
                        <div class="kz-stat-item">
                            <h4>4.9 ★</h4>
                            <p>Guest Rating</p>
                        </div>
                        <div class="kz-stat-divider d-none d-sm-block"></div>
                        <div class="kz-stat-action ms-auto">
                            <a href="{{ route('home.contact') }}" class="kz-about-cta-btn">
                                <span>Plan Your Trip</span>
                                <i class="ti ti-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if(isset($services) && $services->isNotEmpty())
<!--==============================
    Services We Offer (Compact Cards)
==============================-->
<section class="kz-about-services-sec py-4 bg-light-subtle">
    <div class="container">
        <div class="text-center mb-4">
            <span class="kz-about-eyebrow">WHAT WE DELIVER</span>
            <h3 class="kz-about-sec-title">Our Premium Travel Services</h3>
            <p class="text-muted small mx-auto" style="max-width: 580px;">Everything you need for a seamless holiday, from premium hotel stays to sanitized private cabs and guided excursions.</p>
        </div>
        <div class="row g-3">
            @foreach($services as $service)
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="kz-about-srv-card">
                    <div class="kz-srv-img-wrap">
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" loading="lazy">
                    </div>
                    <div class="kz-srv-info">
                        <h5 class="kz-srv-title">{{ $service->title }}</h5>
                        <a href="{{ route('home.contact') }}" class="kz-srv-link">Book Service <i class="ti ti-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if(isset($guides) && $guides->isNotEmpty())
<!--==============================
    Our Native Guides & Specialists
==============================-->
<section class="kz-about-guides-sec py-5">
    <div class="container">
        <div class="text-center mb-4">
            <span class="kz-about-eyebrow">LOCAL EXPERTISE</span>
            <h3 class="kz-about-sec-title">Meet Our Mountain Guides & Team</h3>
            <p class="text-muted small mx-auto" style="max-width: 550px;">Born and raised in the valleys of Jammu & Kashmir, our certified guides ensure your journey is rich in local culture, safety, and wonder.</p>
        </div>
        <div class="row g-3 justify-content-center">
                        @foreach($guides as $guide)
            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <div class="kz-about-guide-card">
                    <div class="kz-guide-photo-wrap">
                        @if(!empty($guide->image))
                            <img src="{{ asset('storage/' . $guide->image) }}" alt="{{ $guide->name }}" class="kz-guide-photo">
                        @else
                            <img src="{{ asset('webassets/img/icon/user.svg') }}" alt="{{ $guide->name }}" class="kz-guide-photo kz-guide-photo-default">
                        @endif
                        <div class="kz-guide-photo-overlay"></div>
                        <span class="kz-guide-badge"><i class="fa-solid fa-certificate text-warning"></i> Certified Specialist</span>
                    </div>
                    <div class="kz-guide-details">
                        <h5 class="kz-guide-name">{{ $guide->name }}</h5>
                        <p class="kz-guide-role">{{ $guide->designation ?? 'Senior Tour Specialist' }}</p>
                        <div class="kz-guide-footer">
                            <span class="kz-guide-tag"><i class="fa-regular fa-compass"></i> Local Native</span>
                            <a href="{{ route('home.contact') }}" class="kz-guide-btn">Inquire</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif



<!--==============================
    HOME PAGE REVIEWS & TESTIMONIALS IN ABOUT US
==============================-->
<section class="kz-about-reviews-sec py-5" style="background: #fbfcfe;">
    <div class="container">
        <div class="text-center mb-4">
            <span class="kz-about-eyebrow">UNFILTERED TRAVELER STORIES</span>
            <h2 class="kz-about-sec-title">What Our Guests Say About Love Link</h2>
            <p class="text-muted small mx-auto" style="max-width: 600px;">Authentic video stories and verified guest reviews from travelers who experienced Kashmir with our team.</p>
        </div>

        @if(isset($youtube) && $youtube->isNotEmpty())
        <!-- YouTube Video Reviews Row (Exact Theme from Homepage) -->
        <div class="row g-3 mb-4">
            @foreach($youtube->take(4) as $y)
            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <div class="kz-video-card">
                    <div class="kz-video-wrapper">
                        @php
                            $ytUrl = $y->url ?? '';
                            $ytId = '';
                            if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $ytUrl, $matches)) {
                                $ytId = $matches[1];
                            }
                        @endphp
                        @if($ytId)
                            <iframe class="kz-video-frame"
                                    src="https://www.youtube-nocookie.com/embed/{{ $ytId }}?rel=0&modestbranding=1"
                                    title="{{ $y->title }}"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                    loading="lazy">
                            </iframe>
                        @endif
                    </div>
                    <div class="kz-video-caption">
                        <h5 class="kz-video-caption-title">{{ $y->title }}</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if(isset($testimonials) && $testimonials->isNotEmpty())
        <!-- Customer Testimonials Grid -->
        <div class="row g-3">
            @foreach($testimonials->take(3) as $testimonial)
            <div class="col-lg-4 col-md-6 col-12">
                <div class="kz-about-testi-card">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center gap-2">
                            @if(!empty($testimonial->image))
                                <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}" class="kz-testi-avatar">
                            @else
                                <div class="kz-testi-avatar-placeholder">{{ substr($testimonial->name, 0, 1) }}</div>
                            @endif
                            <div>
                                <h6 class="kz-testi-name m-0">{{ $testimonial->name }}</h6>
                                <small class="text-muted">{{ $testimonial->designation ?? 'Verified Traveler' }}</small>
                            </div>
                        </div>
                        <div class="kz-testi-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-solid fa-star text-warning"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="kz-testi-msg">“{{ Str::limit($testimonial->message, 180) }}”</p>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

@if(isset($partners) && $partners->isNotEmpty())
<!--==============================
    Brand Partners (Continuous Infinite Marquee)
==============================-->
<div class="brand-area kz-brand-marquee-section overflow-hidden py-4 border-top border-bottom bg-white">
    <div class="container th-container">
        <div class="d-flex align-items-center justify-content-center mb-3">
            <span class="text-muted small fw-bold text-uppercase tracking-wider">Accredited & Associated With Premier Travel Partners:</span>
        </div>
        <div class="kz-brand-marquee-viewport">
            <div class="kz-brand-marquee-track">
                @for($repeat = 0; $repeat < 4; $repeat++)
                    @foreach($partners as $partnerIndex => $partner)
                    <div class="kz-brand-item">
                        <a href="{{ $partner->link ?? '#' }}" target="_blank" rel="noopener" title="{{ $partner->name }}">
                            <img class="kz-brand-logo-img" src="{{ asset('storage/' . $partner->image) }}" alt="{{ $partner->name }}">
                        </a>
                        <p class="d-none">{{ $partner->name }}</p>
                    </div> 
                    @endforeach
                @endfor
            </div>
        </div>
    </div>
</div>
@endif

@endsection