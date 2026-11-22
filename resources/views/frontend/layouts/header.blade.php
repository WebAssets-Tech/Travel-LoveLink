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
	Header Area  
==============================-->
<header class="kaw-hdr">
    <div class="kaw-hdr-sticky">
        <div class="container th-container">
            <div class="kaw-hdr-wrap">

                {{-- LEFT: Logo --}}
                <div class="kaw-hdr-logo-area">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('storage/' . $setting->header_logo) }}" alt="{{ $setting->name }}"
                            width="160" height="48" fetchpriority="high" decoding="async">
                    </a>
                </div>

                {{-- CENTER: Feature Icons (Defensive Active Filtering) --}}
                @php
                    $isSliderIconSectionActive = true;

                    // 1. Check all standard toggle/status keys on $setting
                    $statusCheckKeys = [
                        'slider_icon_status',
                        'slidericon_status',
                        'slider_icons_status',
                        'slider_icon',
                        'slidericon',
                        'header_icon_status',
                        'header_icons_status',
                        'feature_icon_status',
                        'feature_icons_status',
                        'is_slider_icon',
                        'is_slidericon',
                        'is_slider_icon_active',
                        'show_slider_icons'
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

                    // 2. Filter collection: remove items explicitly marked inactive (status = 0 / inactive)
                    $activeSliderIcons = collect($slidericon ?? [])->filter(function ($item) {
                        if (is_object($item) && isset($item->status)) {
                            return $item->status == 1 || $item->status === true || $item->status === '1' || $item->status === 'active';
                        }
                        if (is_array($item) && isset($item['status'])) {
                            return $item['status'] == 1 || $item['status'] === true || $item['status'] === '1' || $item['status'] === 'active';
                        }
                        return true;
                    });
                @endphp

                @if($isSliderIconSectionActive && $activeSliderIcons->isNotEmpty())
                    <div class="kaw-hdr-icons-area">
                        <div class="kaw-hdr-fi" id="kawHdrFi">
                            @foreach($activeSliderIcons as $index => $slid)
                                @php
                                    $itemClass = '';
                                    if ($index >= 8) {
                                        $itemClass = 'kaw-hdr-fi-hidden';
                                    } elseif ($index >= 6) {
                                        $itemClass = 'kaw-hdr-fi-desktop-only';
                                    }
                                    $itemUrl = \Illuminate\Support\Str::startsWith($slid->link, ['http://', 'https://'])
                                        ? $slid->link
                                        : url('/' . ltrim($slid->link, '/'));
                                @endphp
                                <div class="kaw-hdr-fi-item {{ $itemClass }}" onclick="location.href='{{ $itemUrl }}'">
                                    @if($slid->image)
                                        <div class="kaw-hdr-fi-icon">
                                            <img src="{{ asset('storage/' . $slid->image) }}" alt="{{ $slid->title }}"
                                                class="kaw-hdr-fi-img" width="32" height="32" loading="lazy" decoding="async">
                                        </div>
                                    @else
                                        <div class="kaw-hdr-fi-icon">
                                            <span class="kaw-hdr-fi-no-icon"></span>
                                        </div>
                                    @endif
                                    <p class="kaw-hdr-fi-label">{{ $slid->title }}</p>
                                </div>
                            @endforeach

                            {{-- More button (always visible if > 6 icons on mobile; only > 8 on desktop) --}}
                            @if($activeSliderIcons->count() > 6)
                                <button
                                    class="kaw-hdr-fi-more {{ $activeSliderIcons->count() <= 8 ? 'kaw-hdr-fi-more-mobile-only' : '' }}"
                                    id="kawFiMoreBtn" type="button" aria-expanded="false" aria-controls="kawFiPanel">
                                    <div class="kaw-hdr-fi-icon">
                                        <span class="kaw-hdr-fi-more-svg">
                                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                                                <circle cx="8" cy="8" r="2"></circle>
                                                <circle cx="16" cy="8" r="2"></circle>
                                                <circle cx="8" cy="16" r="2"></circle>
                                                <circle cx="16" cy="16" r="2"></circle>
                                            </svg>
                                        </span>
                                    </div>
                                    <p class="kaw-hdr-fi-label" id="kawFiMoreLabel">More</p>
                                </button>
                            @endif
                        </div>

                        {{-- Backdrop --}}
                        <div class="kaw-hdr-fi-backdrop" id="kawFiBackdrop"></div>

                        {{-- More dropdown panel --}}
                        @if($activeSliderIcons->count() > 6)
                            <div class="kaw-hdr-fi-panel" id="kawFiPanel">
                                @foreach($activeSliderIcons as $index => $slid)
                                    @if($index >= 6)
                                        @php
                                            $panelItemUrl = \Illuminate\Support\Str::startsWith($slid->link, ['http://', 'https://'])
                                                ? $slid->link
                                                : url('/' . ltrim($slid->link, '/'));
                                        @endphp
                                        <div class="kaw-hdr-fi-panel-item {{ $index < 8 ? 'kaw-hdr-fi-mobile-only' : '' }}"
                                            onclick="location.href='{{ $panelItemUrl }}'">
                                            @if($slid->image)
                                                <div class="kaw-hdr-fi-icon">
                                                    <img src="{{ asset('storage/' . $slid->image) }}" alt="{{ $slid->title }}"
                                                        class="kaw-hdr-fi-img" width="32" height="32" loading="lazy" decoding="async">
                                                </div>
                                            @else
                                                <div class="kaw-hdr-fi-icon">
                                                    <span class="kaw-hdr-fi-no-icon"></span>
                                                </div>
                                            @endif
                                            <p class="kaw-hdr-fi-panel-title">{{ $slid->title }}</p>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                {{-- RIGHT: Customer Service + Hamburger (always visible) --}}
                <div class="kaw-hdr-actions">
                    <div class="kaw-hdr-cs-wrap">
                        <button class="kaw-hdr-cs-btn" id="kawCsBtn" type="button" aria-expanded="false">
                            <span class="kaw-hdr-cs-pulse-dot"></span>
                            <i class="fa-regular fa-headset kaw-hdr-cs-icon"></i>
                            <span class="kaw-hdr-cs-label">Customer Service</span>
                            <i class="fa-regular fa-chevron-down kaw-hdr-cs-arrow"></i>
                        </button>
                        <div class="kaw-hdr-cs-drop" id="kawCsDrop">
                            <div class="kaw-cs-card-head">
                                <span class="kaw-cs-badge"><i class="fa-solid fa-sparkles text-warning me-1"></i>
                                    Concierge 24/7</span>
                                <span class="kaw-cs-live-pill"><span class="kaw-cs-pulse"></span> Online</span>
                            </div>
                            <a href="tel:{{ $setting->phone }}" class="kaw-hdr-cs-link">
                                <div class="kaw-cs-ico-wrap phone-ico">
                                    <i class="fa-solid fa-phone-volume"></i>
                                </div>
                                <div class="kaw-cs-body">
                                    <span class="kaw-cs-sub">Helpline & Hotline</span>
                                    <span class="kaw-cs-val">{{ $setting->phone }}</span>
                                </div>
                                <i class="fa-regular fa-chevron-right kaw-cs-chevron"></i>
                            </a>
                            <a href="mailto:{{ $setting->email }}" class="kaw-hdr-cs-link">
                                <div class="kaw-cs-ico-wrap mail-ico">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <div class="kaw-cs-body">
                                    <span class="kaw-cs-sub">Email Assistance</span>
                                    <span class="kaw-cs-val">{{ $setting->email }}</span>
                                </div>
                                <i class="fa-regular fa-chevron-right kaw-cs-chevron"></i>
                            </a>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $setting->phone ?? '917006338617') }}"
                                target="_blank" class="kaw-hdr-cs-link kaw-hdr-cs-wa">
                                <div class="kaw-cs-ico-wrap wa-ico">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </div>
                                <div class="kaw-cs-body">
                                    <span class="kaw-cs-sub">WhatsApp Support</span>
                                    <span class="kaw-cs-val">{{ $setting->phone ?? '+91 7006338617' }}</span>
                                </div>
                                <i class="fa-regular fa-chevron-right kaw-cs-chevron"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Hamburger: ALWAYS visible (menu lives in sidebar) --}}
                    <button type="button" class="kaw-hdr-burger th-menu-toggle" aria-label="Open Navigation Menu">
                        <i class="far fa-bars"></i>
                    </button>
                </div>

            </div>
        </div>
    </div>
</header>