<!--==============================
	Footer Area - Modern Luxury Design
==============================-->
<footer class="site-footer kz-luxury-footer">

    {{-- 1. Pre-Footer VIP Concierge Banner --}}
    <div class="kz-ftr-cta-wrap">
        <div class="container">
            <div class="kz-ftr-cta-card">
                <div class="kz-ftr-cta-content">
                    <div class="kz-ftr-cta-badge">
                        <i class="fas fa-crown me-1 text-gold"></i>
                        <span>KASHMIR &amp; LADAKH DESTINATION SPECIALISTS</span>
                    </div>
                    <h3 class="kz-ftr-cta-title">Begin Your Himalayan Journey With True Locals</h3>
                    <p class="kz-ftr-cta-subtitle">Bespoke itineraries &bull; 100% In-house luxury fleet &bull; Private houseboats &bull; 24/7 on-ground concierge</p>
                </div>
                <div class="kz-ftr-cta-actions">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $setting->phone ?? '+917006338617') }}?text=Hello%20LoveLink%20Travels,%20I%20would%20like%20to%20plan%20a%20luxury%20Himalayan%20journey" target="_blank" rel="noopener noreferrer" class="kz-ftr-btn-wa">
                        <span class="kz-pulse-dot"></span>
                        <i class="fab fa-whatsapp"></i>
                        <span>WhatsApp VIP Concierge</span>
                    </a>
                    <button type="button" class="kz-ftr-btn-custom" data-bs-toggle="modal" data-bs-target="#globalContactModal">
                        <i class="fas fa-paper-plane me-1"></i>
                        <span>Plan Custom Trip</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Main Footer: 4-Column Luxury Grid (24/7 Concierge > Quick Links > Destinations > About) --}}
    <div class="footer-main kz-ftr-main">
        <div class="container">
            <div class="kz-ftr-grid">

                {{-- Column 1: 24/7 Concierge & Regional Offices --}}
                <div class="kz-ftr-col footer-accordion-col kz-col-concierge">
                    <div class="footer-col-header" data-accordion-toggle>
                        <h4 class="kz-col-heading">24/7 Concierge</h4>
                        <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
                    </div>
                    <div class="footer-col-body">

                        {{-- Direct Call & Inquire Pill --}}
                        <div class="kz-ftr-call-pill">
                            <div class="kz-pill-main">
                                <span class="kz-pill-icon"><i class="fas fa-phone-alt"></i></span>
                                <div class="kz-pill-info">
                                    <span class="kz-pill-tag">Always Active &bull; 24/7</span>
                                    <a href="tel:{{ $setting->phone }}" class="kz-pill-phone">{{ $setting->phone }}</a>
                                </div>
                            </div>
                            <button type="button" class="kz-pill-inquire-btn" data-bs-toggle="modal" data-bs-target="#globalContactModal">
                                Inquire
                            </button>
                        </div>

                        {{-- Address & Email --}}
                        <div class="kz-concierge-meta">
                            <div class="kz-meta-item">
                                <i class="fas fa-envelope kz-meta-icon"></i>
                                <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a>
                            </div>
                            <div class="kz-meta-item">
                                <i class="fas fa-map-marker-alt kz-meta-icon"></i>
                                <span>NH1, Near Power House, 191202 Srinagar, Jammu &amp; Kashmir (INDIA)</span>
                            </div>
                        </div>

                        {{-- Regional Offices Accordion --}}
                        @if($setting->phone1 || $setting->email || $setting->email1 || $setting->address)
                        <div class="footer-other-offices kz-other-offices">
                            <div class="other-offices-toggle kz-offices-toggle" data-offices-toggle>
                                <span><i class="fas fa-building me-2 text-gold"></i> Regional Offices</span>
                                <i class="fas fa-chevron-down other-offices-chevron"></i>
                            </div>
                            <div class="other-offices-body kz-offices-body">
                                @if($setting->phone1)
                                <div class="office-contact-item">
                                    <i class="fas fa-phone-alt office-icon text-gold"></i>
                                    <a href="tel:{{ $setting->phone1 }}" class="contact-link">{{ $setting->phone1 }}</a>
                                </div>
                                @endif
                                @if($setting->email)
                                <div class="office-contact-item">
                                    <i class="fas fa-envelope office-icon text-gold"></i>
                                    <a href="mailto:{{ $setting->email }}" class="contact-link">{{ $setting->email }}</a>
                                </div>
                                @endif
                                @if($setting->email1)
                                <div class="office-contact-item">
                                    <i class="fas fa-envelope office-icon text-gold"></i>
                                    <a href="mailto:{{ $setting->email1 }}" class="contact-link">{{ $setting->email1 }}</a>
                                </div>
                                @endif
                                @if($setting->address)
                                <div class="office-contact-item">
                                    <i class="fas fa-map-marker-alt office-icon text-gold"></i>
                                    <p>{!! nl2br(e($setting->address)) !!}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif

                    </div>
                </div>

                {{-- Column 2: Quick Links & Experiences --}}
                <div class="kz-ftr-col footer-accordion-col kz-col-links">
                    <div class="footer-col-header" data-accordion-toggle>
                        <h4 class="kz-col-heading">Quick Links</h4>
                        <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
                    </div>
                    <div class="footer-col-body">
                        <ul class="kz-ftr-nav">
                            <li><a href="{{ route('aboutus.index') }}"><i class="fas fa-chevron-right"></i> About Us</a></li>
                            <li><a href="{{ route('home.hotels') }}"><i class="fas fa-chevron-right"></i> Luxury Stays &amp; Houseboats</a></li>
                            <li><a href="{{ route('home.cabs') }}"><i class="fas fa-chevron-right"></i> In-House Fleet &amp; Cabs</a></li>
                            <li><a href="{{ route('home.destinationwedding') }}"><i class="fas fa-chevron-right"></i> Destination Weddings</a></li>
                            @foreach ($footerMenus as $menu)
                                @if(!in_array(strtolower(trim($menu->title)), ['about us', 'destinations']))
                                <li>
                                    <a href="{{ isset($menu->link) ? url($menu->link) : '#' }}"><i class="fas fa-chevron-right"></i> {{ $menu->title }}</a>
                                </li>
                                @endif
                            @endforeach
                            <li><a href="{{ route('home.contact') }}"><i class="fas fa-chevron-right"></i> Contact Us</a></li>
                        </ul>
                    </div>
                </div>

                {{-- Column 3: Destinations (Curated) --}}
                <div class="kz-ftr-col footer-accordion-col kz-col-destinations">
                    <div class="footer-col-header" data-accordion-toggle>
                        <h4 class="kz-col-heading">Destinations</h4>
                        <span class="accordion-icon"><i class="fas fa-chevron-down"></i></span>
                    </div>
                    <div class="footer-col-body">
                        <ul class="kz-ftr-nav">
                            <li><a href="{{ route('destinations.index') }}"><i class="fas fa-chevron-right"></i> Kashmir Valley All Tours</a></li>
                            <li><a href="{{ route('home.tour') }}?search=Gulmarg"><i class="fas fa-chevron-right"></i> Gulmarg Snow &amp; Gondola</a></li>
                            <li><a href="{{ route('home.tour') }}?search=Pahalgam"><i class="fas fa-chevron-right"></i> Pahalgam &amp; Betaab Valley</a></li>
                            <li><a href="{{ route('home.tour') }}?search=Sonamarg"><i class="fas fa-chevron-right"></i> Sonamarg &amp; Thajiwas Glacier</a></li>
                            <li><a href="{{ route('home.tour') }}?search=Ladakh"><i class="fas fa-chevron-right"></i> Leh–Ladakh High Passes</a></li>
                            <li><a href="{{ route('home.tour') }}?search=Gurez"><i class="fas fa-chevron-right"></i> Gurez Valley Offbeat</a></li>
                        </ul>
                    </div>
                </div>

                {{-- Column 4: About (Brand & Heritage) --}}
                <div class="kz-ftr-col kz-col-brand">
                    <div class="kz-ftr-logo-box">
                        <a href="{{ route('home') }}" class="kz-brand-logo-link">
                            <img src="{{ asset('storage/' . $setting->footer_logo) }}" alt="{{ $setting->name }}" width="170" height="52" loading="lazy" decoding="async">
                        </a>
                    </div>
                    <p class="kz-brand-bio">
                        {!! strip_tags($setting->footer_about) ?: 'Love Link Tour and Travels crafts seamless, personalized travel experiences that turn every Himalayan journey into a lifelong memory. Travel smart with verified local destination experts.' !!}
                    </p>
                    <div class="kz-accreditation-pill">
                        <i class="fas fa-certificate text-gold"></i>
                        <span>Official Tourism Partner &bull; Srinagar &amp; Leh</span>
                    </div>
                    <div class="kz-social-links">
                        @php
                            $social_link = json_encode($setting->social_link, true) ?? [];
                            $social_link = json_decode($social_link) ?? [];
                        @endphp
                        @if(!empty($social_link))
                            @foreach($social_link as $index => $item)
                                <a href="{{ $item->social_link }}" title="{{ $item->social_name }}" class="kz-social-btn" target="_blank" rel="noopener noreferrer">
                                    <i class="{{ $item->social_icon }}"></i>
                                </a>
                            @endforeach
                        @else
                            <a href="#" class="kz-social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="kz-social-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="kz-social-btn" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="kz-social-btn" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- 4. Copyright & Trust Bottom Bar --}}
    <div class="footer-bottom kz-ftr-bottom">
        <div class="container">
            <div class="kz-ftr-bottom-inner">
                <p class="copyright-text kz-copy">
                    &copy; {{ date('Y') }} <strong>Love Link Tour and Travels</strong>. All Rights Reserved.
                    <span class="footer-copy-divider">|</span>
                    Developed &amp; Designed by <a href="https://webassets.tech/" target="_blank" rel="noopener noreferrer" class="footer-credit-link">Web Assets</a>
                </p>
                <div class="kz-safe-badge d-none d-lg-flex">
                    <i class="fas fa-shield-alt text-gold me-2"></i>
                    <span>100% Safe &amp; Verified Booking</span>
                </div>
                <div class="footer-bottom-right kz-ftr-payments">
                    <span class="accept-label">We Accept:</span>
                    <img src="{{ asset('webassets/img/shape/cards.png') }}" alt="Payment Methods" width="220" height="28" loading="lazy" decoding="async">
                </div>
            </div>
        </div>
    </div>

</footer>
<!--********************************
		Code End  Here 
******************************** -->

<!-- Scroll To Top -->
<div class="scroll-top">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
        </path>
    </svg>
</div>

<!--==============================
modal Area  
==============================-->
<div id="login-form" class="popup-login-register mfp-hide">
    <ul class="nav" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-menu" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="false">Login</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-menu active" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="true">Register</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <h3 class="box-title mb-30">Sign in to your account</h3>
            <div class="th-login-form">
                <form action="mail.php" method="POST" class="login-form ajax-contact">
                    <div class="row">
                        <div class="form-group col-12">
                            <label>Username or email</label>
                            <input type="text" class="form-control" name="email" id="email" required="required">
                        </div>
                        <div class="form-group col-12">
                            <label>Password</label>
                            <input type="password" class="form-control" name="pasword" id="pasword" required="required">
                        </div>

                        <div class="form-btn mb-20 col-12">
                            <button class="th-btn btn-fw th-radius2 ">Send Message</button>
                        </div>
                    </div>
                    <div id="forgot_url">
                        <a href="my-account.html">Forgot password?</a>
                    </div>
                    <p class="form-messages mb-0 mt-3"></p>
                </form>
            </div>
        </div>
        <div class="tab-pane fade active show" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <h3 class="th-form-title mb-30">Sign in to your account</h3>
            <form action="mail.php" method="POST" class="login-form ajax-contact">
                <div class="row">
                    <div class="form-group col-12">
                        <label>Username*</label>
                        <input type="text" class="form-control" name="usename" id="usename" required="required">
                    </div>
                    <div class="form-group col-12">
                        <label>First name*</label>
                        <input type="text" class="form-control" name="firstname" id="firstname" required="required">
                    </div>
                    <div class="form-group col-12">
                        <label>Last name*</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" required="required">
                    </div>
                    <div class="form-group col-12">
                        <label for="new_email">Your email*</label>
                        <input type="text" class="form-control" name="new_email" id="new_email" required="required">
                    </div>
                    <div class="form-group col-12">
                        <label for="new_email_confirm">Confirm email*</label>
                        <input type="text" class="form-control" name="new_email_confirm" id="new_email_confirm" required="required">
                    </div>
                    <div class="statement">
                        <span class="register-notes">A password will be emailed to you.</span>
                    </div>

                    <div class="form-btn mt-20 col-12">
                        <button class="th-btn btn-fw th-radius2 ">Sign up</button>
                    </div>
                </div>
                <p class="form-messages mb-0 mt-3"></p>
            </form>
        </div>
    </div>
</div>

<?php
/**
 * ==============================================================================
 * FLOATING SIDEBAR (Desktop Right) + FLOATING BOTTOM BAR (Mobile)
 * ==============================================================================
 */

// Dynamic fallback constants if defined in CMS
$fsb_phone = defined('CONTACT_PHONE') ? CONTACT_PHONE : ($setting->phone ?? '+917006338617');
$fsb_phone_clean = preg_replace('/[^0-9]/', '', $fsb_phone);
$fsb_email = defined('CONTACT_EMAIL') ? CONTACT_EMAIL : ($setting->email ?? 'Lovelinktravels@gmail.com');
?>


<!-- FIXED RIGHT SIDEBAR (Desktop) + BOTTOM BAR (Mobile) -->
<div class="fsb-wrapper">

  <!-- WhatsApp -->
  <a href="https://wa.me/<?= $fsb_phone_clean; ?>" target="_blank" rel="noopener noreferrer" class="fsb-btn fsb-whatsapp" aria-label="WhatsApp">
    <span class="fsb-icon">
      <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.117 1.528 5.845L.057 23.617a.75.75 0 0 0 .92.919l5.84-1.47A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75a9.718 9.718 0 0 1-4.953-1.354l-.355-.211-3.673.924.942-3.588-.231-.368A9.715 9.715 0 0 1 2.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12 17.385 21.75 12 21.75z"/>
      </svg>
    </span>
    <span class="fsb-label">WhatsApp</span>
  </a>

  <!-- Email -->
  <a href="mailto:<?= $fsb_email; ?>" class="fsb-btn fsb-email" aria-label="Email">
    <span class="fsb-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <rect x="2" y="4" width="20" height="16" rx="2"/>
        <path d="m2 7 10 7 10-7"/>
      </svg>
    </span>
    <span class="fsb-label">Email Us</span>
  </a>

  <!-- Book Now -->
  <a href="#" class="fsb-btn fsb-book" aria-label="Book Now"
     data-bs-toggle="modal" data-bs-target="#globalContactModal">
    <span class="fsb-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="4" width="18" height="18" rx="2"/>
        <path d="M16 2v4M8 2v4M3 10h18"/>
        <path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01"/>
      </svg>
    </span>
    <span class="fsb-label">Book Now</span>
  </a>

  <!-- Pay Now -->
  <a href="{{ url('https://razorpay.me/@lovelinktours') }}" class="fsb-btn fsb-pay" aria-label="Pay Now">
    <span class="fsb-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <rect x="2" y="5" width="20" height="14" rx="2"/>
        <line x1="2" y1="10" x2="22" y2="10"/>
        <line x1="6" y1="15" x2="10" y2="15"/>
      </svg>
    </span>
    <span class="fsb-label">Pay Now</span>
  </a>

  <!-- Call Us -->
  <a href="tel:<?= $fsb_phone; ?>" class="fsb-btn fsb-call" aria-label="Call Us">
    <span class="fsb-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.27h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 8.8a16 16 0 0 0 6.29 6.29l.91-.91a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
      </svg>
    </span>
    <span class="fsb-label">Call Us</span>
  </a>

</div>

