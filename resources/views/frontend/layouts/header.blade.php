<!--********************************
    Code Start From Here 
******************************** -->

<!--==============================
    PRELOADER - ULTRA-PREMIUM HAUTE LUXURY MINIMALIST
==============================-->
<div id="preloader" class="preloader kaw-preloader" aria-label="Loading experience">
    <div class="kaw-preloader-inner">
        <!-- Minimalist Floating Brand Logo -->
        <div class="kaw-preloader-brand">
            <img src="{{ asset('storage/' . $setting->header_logo) }}" alt="{{ $setting->name ?? 'Love Link' }}"
                class="kaw-preloader-logo" width="160" height="48" fetchpriority="high" decoding="sync">
        </div>

        <!-- Live Real-Time Luxury Progress Experience -->
        <div class="kaw-preloader-meter-wrap">
            <div class="kaw-preloader-meter">
                <div class="kaw-preloader-fill" id="kawPreloaderFill"></div>
            </div>
            <div class="kaw-preloader-num-box">
                <span class="kaw-preloader-num" id="kawPreloaderNum">00</span><span class="kaw-preloader-pct">%</span>
            </div>
        </div>

        <!-- Refined Editorial Typography & Dynamic Stage Status -->
        <div class="kaw-preloader-caption">
            <span class="kaw-preloader-title">{{ $setting->name ?? 'LOVE LINK' }}</span>
            <span class="kaw-preloader-status-text" id="kawPreloaderStatus">Curating Luxury Travel</span>
        </div>
    </div>
</div>
<!--==============================
    Sidemenu
============================== -->
<div class="sidemenu-wrapper sidemenu-info ">
    <div class="sidemenu-content">
        <button class="closeButton sideMenuCls"><i class="far fa-times"></i></button>
        <div class="widget  ">
            <div class="th-widget-about">
                <div class="about-logo">
                    <a href="{{ route('home') }}"><img src="{{ asset('storage/' . $setting->header_logo) }}"
                            alt="{{ $setting->name }}" width="150" height="45" loading="lazy" decoding="async"></a>
                </div>
                <p class="about-text">{{ $setting->footer_about }}</p>
                <div class="th-social">
                    @php
                        $social_link = json_encode($setting->social_link, true) ?? [];
                        $social_link = json_decode($social_link) ?? []; 
                    @endphp
                    @if(!empty($social_link))
                        @foreach($social_link as $index => $item)
                            <a href="{{ $item->social_link }}" title="{{ $item->social_name }}"><i
                                    class="{{ $item->social_icon }}"></i></a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="widget  ">
            <h3 class="widget_title">Recent Posts</h3>
            <div class="recent-post-wrap">
                @foreach($Headerblogs as $recentBlog)
                    <div class="recent-post">
                        <div class="media-img">
                            <a href="{{ route('blog.details', $recentBlog->slug) }}"><img
                                    src="{{ asset('storage/' . $recentBlog->image) }}" alt="Blog Image" width="80"
                                    height="80" loading="lazy" decoding="async"></a>
                        </div>
                        <div class="media-body">
                            <h4 class="post-title"><a class="text-inherit"
                                    href="{{ route('blog.details', $recentBlog->slug) }}">{{ $recentBlog->title }}</a></h4>
                            <div class="recent-post-meta">
                                <a href="{{ route('blog.details', $recentBlog->slug) }}"><i
                                        class="fa-regular fa-calendar"></i>{{ \Carbon\Carbon::parse($recentBlog->published_at)->format('F d, Y') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="widget  ">
            <h3 class="widget_title">Get In Touch</h3>
            <div class="th-widget-contact">
                <div class="info-box_text">
                    <div class="icon">
                        <img src="{{ url('webassets/img/icon/phone.svg') }}" alt="img" width="20" height="20"
                            loading="lazy" decoding="async">
                    </div>
                    <div class="details">
                        <p><a href="tel:{{ $setting->phone }}" class="info-box_link">{{ $setting->phone }}</a></p>
                        <p><a href="tel:{{ $setting->phone1 }}" class="info-box_link">{{ $setting->phone1 }}</a></p>
                    </div>
                </div>
                <div class="info-box_text">
                    <div class="icon">
                        <img src="{{ url('webassets/img/icon/envelope.svg') }}" alt="img" width="20" height="20"
                            loading="lazy" decoding="async">
                    </div>
                    <div class="details">
                        <p><a href="mailto:{{ $setting->email }}" class="info-box_link">{{ $setting->email }}</a></p>
                        <p><a href="mailto:{{ $setting->email1 }}" class="info-box_link">{{ $setting->email1 }}</a></p>
                    </div>
                </div>
                <div class="info-box_text">
                    <div class="icon"><img src="{{ url('webassets/img/icon/location-dot.svg') }}" alt="img" width="20"
                            height="20" loading="lazy" decoding="async"></div>
                    <div class="details">
                        <p>{{ $setting->address }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="popup-search-box">
    <button class="searchClose"><i class="fal fa-times"></i></button>
    <form action="#">
        <input type="text" placeholder="What are you looking for?">
        <button type="submit"><i class="fal fa-search"></i></button>
    </form>
</div>

<!--==============================
    Mobile Menu
============================== -->
<div class="th-menu-wrapper onepage-nav">
    <div class="th-menu-area text-center">
        <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
        <div class="mobile-logo">
            <a href="{{ route('home')}}"><img src="{{ asset('storage/' . $setting->header_logo) }}"
                    alt="{{ $setting->name }}" width="140" height="42" loading="lazy" decoding="async"></a>
        </div>
        <div class="th-mobile-menu">
            <ul>
                @foreach ($headerMenus as $menu)
                    <li class="{{ $menu->children->isNotEmpty() ? 'menu-item-has-children' : '' }}">
                        <a href="{{ isset($menu->link) ? url($menu->link) : '#' }}">{{ $menu->title }}</a>
                        @if ($menu->children->isNotEmpty())
                            <ul class="sub-menu">
                                @foreach ($menu->children as $submenu)
                                    <li><a href="{{ isset($submenu->link) ? url($submenu->link) : '#' }}"
                                            class="{{ $submenu->children->isNotEmpty() ? 'menu-item-has-children' : '' }}">
                                            {{ $submenu->title }}
                                        </a>
                                        @if ($submenu->children->isNotEmpty())
                                            <ul class="sub-menu">
                                                @foreach ($submenu->children as $subsubmenu)
                                                    <li><a
                                                            href="{{ isset($subsubmenu->link) ? url($subsubmenu->link) : '#' }}">{{ $subsubmenu->title }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<!--==============================
	Header Area (MMT-Inspired Floating Menu + Top Updates & Contact Bar)
==============================-->
@php
    $hdr_wa_raw = !empty($setting->whatsapp)
        ? $setting->whatsapp
        : (!empty($setting->phone)
            ? $setting->phone
            : (!empty($setting->phone1) ? $setting->phone1 : '917006338617'));
    $hdr_wa_clean = preg_replace('/[^0-9]/', '', (string)$hdr_wa_raw);
    if (strlen($hdr_wa_clean) === 10) {
        $hdr_wa_clean = '91' . $hdr_wa_clean;
    }
    if (empty($hdr_wa_clean)) {
        $hdr_wa_clean = '917006338617';
    }

    $isSliderIconSectionActive = true;
    $statusCheckKeys = [
        'slider_icon_status', 'slidericon_status', 'slider_icons_status',
        'slider_icon', 'slidericon', 'header_icon_status', 'header_icons_status',
        'feature_icon_status', 'feature_icons_status', 'is_slider_icon',
        'is_slidericon', 'is_slider_icon_active', 'show_slider_icons'
    ];
    if (isset($setting)) {
        foreach ($statusCheckKeys as $key) {
            if (isset($setting->$key)) {
                $val = $setting->$key;
                if ($val === 0 || $val === '0' || $val === false || $val === 'inactive' || $val === 'off') {
                    $isSliderIconSectionActive = false;
                    break;
                }
            }
        }
    }
    $activeSliderIcons = collect($slidericon ?? [])->filter(function ($item) {
        if (is_object($item) && isset($item->status)) {
            return $item->status == 1 || $item->status === true || $item->status === '1' || $item->status === 'active';
        }
        if (is_array($item) && isset($item['status'])) {
            return $item['status'] == 1 || $item['status'] === true || $item['status'] === '1' || $item['status'] === 'active';
        }
        return true;
    })->values();
@endphp

<header class="kaw-hdr kaw-mmt-hdr">
    {{-- ROW 1: Top Header Bar (Logo + Updates Ticker + Phone/Email + CTA + Hamburger) --}}
    <div class="kaw-hdr-sticky">
        <div class="container th-container">
            <div class="kaw-hdr-wrap kaw-mmt-top-row">

                {{-- LEFT: Brand Logo --}}
                <div class="kaw-hdr-logo-area">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('storage/' . $setting->header_logo) }}" alt="{{ $setting->name }}"
                            width="160" height="48" fetchpriority="high" decoding="async">
                    </a>
                </div>

                {{-- CENTER: Live Updates Ticker inside Top Header --}}
                <div class="kaw-hdr-updates-wrap">
                    <div class="kz-ent-notice-bar kz-ent-header-bar" id="kzEntNoticeBar">
                        <div class="kz-ent-badge">
                            <span class="kz-ent-pulse">
                                <span class="kz-ent-dot"></span>
                                <span class="kz-ent-ring"></span>
                            </span>
                            <span class="kz-ent-badge-text">UPDATES</span>
                        </div>

                        <div class="kz-ent-ticker-viewport" id="kzEntViewport" aria-live="polite">
                            <div class="kz-ent-ticker-track" id="kzEntTrack">
                                <div class="kz-ent-item active" data-index="1">
                                    <span class="kz-ent-tag tag-dest"><i class="fas fa-mountain"></i> Trending</span>
                                    <div class="kz-ent-content">
                                        <span class="kz-ent-strong">We Offer:</span>
                                        <span class="kz-ent-text">Kashmir • Leh–Ladakh • Shimla–Manali • Goa • Golden Triangle</span>
                                    </div>
                                    <a href="{{ url('category/domestic') }}" class="kz-ent-action" title="Explore Packages">
                                        <span class="kz-ent-action-txt">Explore</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>

                                <div class="kz-ent-item" data-index="2">
                                    <span class="kz-ent-tag tag-verified"><i class="fas fa-shield-alt"></i> Certified</span>
                                    <div class="kz-ent-content">
                                        <span class="kz-ent-strong">Govt. Recognized:</span>
                                        <span class="kz-ent-text">Govt. of J&amp;K Registered Agency • 50,000+ Happy Travelers</span>
                                    </div>
                                    <a href="{{ route('aboutus.index') }}" class="kz-ent-action" title="About LoveLink">
                                        <span class="kz-ent-action-txt">About</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>

                                <div class="kz-ent-item" data-index="3">
                                    <span class="kz-ent-tag tag-offer"><i class="fas fa-tag"></i> Offer</span>
                                    <div class="kz-ent-content">
                                        <span class="kz-ent-strong">Early Bird:</span>
                                        <span class="kz-ent-text">Save up to 20% on Custom Kashmir, Ladakh &amp; Himachal Packages</span>
                                    </div>
                                    <a href="{{ route('home.contact') }}" class="kz-ent-action" title="Get Free Quote">
                                        <span class="kz-ent-action-txt">Quote</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>

                                <div class="kz-ent-item" data-index="4">
                                    <span class="kz-ent-tag tag-fleet"><i class="fas fa-car-side"></i> Fleet</span>
                                    <div class="kz-ent-content">
                                        <span class="kz-ent-strong">Zero Middlemen:</span>
                                        <span class="kz-ent-text">Sanitized Sedans, Innova Crysta &amp; Tempo Travelers with Native Chauffeurs</span>
                                    </div>
                                    <a href="{{ route('home.cabs') }}" class="kz-ent-action" title="View Fleet">
                                        <span class="kz-ent-action-txt">Fleet</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>

                                <div class="kz-ent-item" data-index="5">
                                    <span class="kz-ent-tag tag-support"><i class="fas fa-headset"></i> 24/7</span>
                                    <div class="kz-ent-content">
                                        <span class="kz-ent-strong">Always Here:</span>
                                        <span class="kz-ent-text">Dedicated Ground Coordinators in Srinagar &amp; Leh for Seamless Trips</span>
                                    </div>
                                    <a href="https://api.whatsapp.com/send?phone={{ $hdr_wa_clean }}&text=Hi%20LoveLink%2C%20I%20would%20like%20to%20plan%20a%20tour" target="_blank" class="kz-ent-action" title="WhatsApp Concierge">
                                        <span class="kz-ent-action-txt">Chat</span>
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="kz-ent-controls">
                            <div class="kz-ent-counter">
                                <span id="kzEntCurrent" class="kz-cur">01</span>
                                <span class="kz-divider">/</span>
                                <span id="kzEntTotal" class="kz-tot">05</span>
                            </div>
                            <div class="kz-ent-btns">
                                <button type="button" class="kz-ent-nav-btn prev" id="kzEntPrev" aria-label="Previous notification" title="Previous">
                                    <i class="fas fa-chevron-up"></i>
                                </button>
                                <button type="button" class="kz-ent-nav-btn next" id="kzEntNext" aria-label="Next notification" title="Next">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: Direct Phone + Email (MMT utility style) + CTA Button + Hamburger --}}
                <div class="kaw-hdr-actions kaw-mmt-actions">
                    @if(!empty($setting->phone))
                        <a href="tel:{{ $setting->phone }}" class="kaw-mmt-util-item kaw-mmt-util-phone" title="Call {{ $setting->phone }}">
                            <span class="kaw-mmt-util-ico"><i class="fa-solid fa-phone"></i></span>
                            <span class="kaw-mmt-util-text">
                                <small>24/7 Helpline</small>
                                <strong>{{ $setting->phone }}</strong>
                            </span>
                        </a>
                    @endif

                    <button type="button" class="kaw-hdr-burger th-menu-toggle" aria-label="Open Navigation Menu">
                        <i class="far fa-bars"></i>
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- ROW 2: MakeMyTrip-Style Floating Category Icon Menu Card --}}
    @if($isSliderIconSectionActive && $activeSliderIcons->isNotEmpty())
        <div class="kaw-mmt-menu-stage">
            <div class="container th-container">
                <nav class="kaw-mmt-menu-card" aria-label="Travel Categories">
                    <div class="kaw-mmt-menu-track">
                        @php
                            $currentPath = trim(request()->path(), '/');
                            $isHomeRoute = request()->routeIs('home') || request()->routeIs('home.index') || $currentPath === '';
                            $matchedAny = false;
                            foreach ($activeSliderIcons as $checkSlid) {
                                $checkPath = trim((string)parse_url(\Illuminate\Support\Str::startsWith($checkSlid->link, ['http://', 'https://']) ? $checkSlid->link : url('/' . ltrim($checkSlid->link, '/')), PHP_URL_PATH), '/');
                                if ($checkPath !== '' && ($currentPath === $checkPath || \Illuminate\Support\Str::startsWith($currentPath, $checkPath . '/'))) {
                                    $matchedAny = true;
                                    break;
                                }
                            }
                        @endphp

                        @foreach($activeSliderIcons as $index => $slid)
                            @php
                                $itemUrl = \Illuminate\Support\Str::startsWith($slid->link, ['http://', 'https://'])
                                    ? $slid->link
                                    : url('/' . ltrim($slid->link, '/'));
                                $itemPath = trim((string)parse_url($itemUrl, PHP_URL_PATH), '/');
                                $isActiveItem = false;
                                if ($matchedAny) {
                                    $isActiveItem = $itemPath !== '' && ($currentPath === $itemPath || \Illuminate\Support\Str::startsWith($currentPath, $itemPath . '/'));
                                } elseif ($isHomeRoute && $index === 0) {
                                    $isActiveItem = true;
                                }
                            @endphp
                            <a href="{{ $itemUrl }}" class="kaw-mmt-cat-item {{ $isActiveItem ? 'is-active' : '' }}">
                                <div class="kaw-mmt-cat-ico">
                                    @if($slid->image)
                                        <img src="{{ asset('storage/' . $slid->image) }}" alt="{{ $slid->title }}"
                                            width="38" height="38" loading="eager" decoding="async">
                                    @else
                                        <span class="kaw-hdr-fi-no-icon"></span>
                                    @endif
                                </div>
                                <span class="kaw-mmt-cat-label">{{ $slid->title }}</span>
                            </a>
                        @endforeach
                    </div>
                </nav>
            </div>
        </div>
    @endif
</header>