@extends('frontend.layouts.app')
@section('page_title', 'Contact Us')
@section('page_meta')  
{!! generateMetaTagsSimple('Contact Us', $setting) !!} 
@endsection 

@section('content')

@php
    $phoneNumber = $setting->phone ?? '+91 7006338617';
    $phoneClean  = preg_replace('/[^0-9+]/', '', $phoneNumber);
    if (empty($phoneClean)) { $phoneClean = '+917006338617'; }
    $phone1Clean = preg_replace('/[^0-9+]/', '', $setting->phone1 ?? '');
@endphp

<!--==============================
    Contact Header
============================== -->
<section class="kz-contact-hero-sec py-3 text-center position-relative overflow-hidden" style="background: linear-gradient(180deg, #f8fafc 0%, #edf2f7 100%); border-bottom: 1px solid rgba(11,61,145,0.08);">
    <div class="container position-relative" style="z-index: 2;">
        <span class="kz-about-eyebrow" style="font-size: 11px; letter-spacing: 0.12em; color: #0B3D91;">24/7 CONCIERGE & SUPPORT</span>
        <h1 class="kz-about-sec-title my-1" style="font-size: 24px; font-weight: 800; color: #072355;">We’d Love to Plan Your Next Journey</h1>
        <p class="text-muted small mx-auto mb-0" style="max-width: 520px; font-size: 12.5px;">Have questions about customized Kashmir, Ladakh, domestic or international tour packages? Our specialists are active 24/7.</p>
    </div>
</section>

<!--==============================
    Bento Grid Contact Section
============================== -->
<section class="kz-contact-bento-sec py-3 position-relative overflow-hidden" style="background: #f1f5f9;">
    <div class="container position-relative" style="z-index: 2;">
        
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-3" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-3">
            
            <!-- BENTO TILE 1: Direct Inquiry Form (Large, Left) -->
            <div class="col-lg-7 col-12">
                <div class="kz-bento-card kz-bento-form-card h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <div>
                            <span class="kz-bento-tag"><i class="fa-solid fa-bolt text-warning"></i> Fast Response</span>
                            <h3 class="kz-bento-title mt-1 mb-0">Send a Travel Inquiry</h3>
                        </div>
                        <span class="badge bg-light text-primary border rounded-pill px-3 py-2 small fw-semibold">No Booking Fees</span>
                    </div>

                    <form action="{{ route('home.contact.submit') }}" method="POST" class="kz-bento-form">
                        @csrf
                        <div class="row g-2">
                            <div class="col-md-6 col-12">
                                <label class="kz-bento-label">Full Name *</label>
                                <div class="kz-input-wrap">
                                    <i class="fa-regular fa-user kz-input-icon"></i>
                                    <input type="text" class="form-control kz-bento-input" name="name" value="{{ old('name') }}" placeholder="Your name" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="kz-bento-label">Phone / WhatsApp *</label>
                                <div class="kz-input-wrap">
                                    <i class="fa-brands fa-whatsapp kz-input-icon text-success"></i>
                                    <input type="tel" class="form-control kz-bento-input" name="number" value="{{ old('number') }}" placeholder="+91 Your number" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="kz-bento-label">Email Address *</label>
                                <div class="kz-input-wrap">
                                    <i class="fa-regular fa-envelope kz-input-icon"></i>
                                    <input type="email" class="form-control kz-bento-input" name="email" value="{{ old('email') }}" placeholder="name@domain.com" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="kz-bento-label">How can we assist you? *</label>
                                <div class="kz-input-wrap">
                                    <i class="fa-regular fa-comment-dots kz-input-icon" style="top: 14px;"></i>
                                    <textarea name="message" class="form-control kz-bento-input kz-bento-textarea" rows="3" placeholder="Tell us destination, traveler count, dates or special requirements..." required>{{ old('message') }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <button type="submit" class="kz-bento-submit-btn w-100">
                                    <span>Send Your Travel Inquiry</span>
                                    <i class="fa-solid fa-paper-plane ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- BENTO TILE 2: Interactive Location Map (Top Right) -->
            <div class="col-lg-5 col-12">
                <div class="kz-bento-card kz-bento-map-card h-100">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="kz-bento-tag"><i class="fa-solid fa-location-dot text-danger"></i> Srinagar Office</span>
                        <a href="{{ $setting->map_link }}" target="_blank" class="small text-decoration-none fw-bold text-primary">Open Maps <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                    </div>
                    <div class="kz-bento-map-wrap">
                        <iframe src="{{ $setting->map_link }}" class="kz-bento-iframe" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                    <div class="kz-bento-map-footer mt-2 pt-2 border-top">
                        <small class="text-muted d-block"><i class="fa-regular fa-compass me-1 text-primary"></i> NH1, Near Power House, Srinagar, J&K (INDIA)</small>
                    </div>
                </div>
            </div>

            <!-- BENTO TILE 3: Direct Quick Hotline Channels -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="kz-bento-card kz-bento-channel-card h-100">
                    <span class="kz-bento-tag"><i class="fa-solid fa-headset text-primary"></i> Instant Contact</span>
                    <h5 class="kz-bento-subtitle mt-1 mb-3">Call & WhatsApp Concierge</h5>
                    
                    <div class="d-flex flex-column gap-2">
                        <a href="https://wa.me/{{ $phoneClean }}" target="_blank" class="kz-channel-item kz-channel-wa">
                            <div class="kz-channel-icon"><i class="fa-brands fa-whatsapp"></i></div>
                            <div>
                                <small class="text-muted d-block" style="font-size: 11px;">WhatsApp Chat</small>
                                <span class="fw-bold" style="font-size: 13.5px;">{{ $setting->phone }}</span>
                            </div>
                            <i class="fa-solid fa-arrow-right ms-auto kz-channel-arrow"></i>
                        </a>

                        <a href="tel:{{ $phoneClean }}" class="kz-channel-item kz-channel-call">
                            <div class="kz-channel-icon"><i class="fa-solid fa-phone"></i></div>
                            <div>
                                <small class="text-muted d-block" style="font-size: 11px;">24/7 Helpline</small>
                                <span class="fw-bold" style="font-size: 13.5px;">{{ $setting->phone }}</span>
                            </div>
                            <i class="fa-solid fa-arrow-right ms-auto kz-channel-arrow"></i>
                        </a>

                        @if(!empty($setting->phone1))
                        <a href="tel:{{ $phone1Clean }}" class="kz-channel-item kz-channel-call">
                            <div class="kz-channel-icon"><i class="fa-solid fa-phone-volume"></i></div>
                            <div>
                                <small class="text-muted d-block" style="font-size: 11px;">Alternate Line</small>
                                <span class="fw-bold" style="font-size: 13.5px;">{{ $setting->phone1 }}</span>
                            </div>
                            <i class="fa-solid fa-arrow-right ms-auto kz-channel-arrow"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- BENTO TILE 4: Official Emails & Dedicated Desks -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="kz-bento-card kz-bento-email-card h-100">
                    <span class="kz-bento-tag"><i class="fa-regular fa-envelope text-danger"></i> Written Inquiries</span>
                    <h5 class="kz-bento-subtitle mt-1 mb-3">Email Desks</h5>
                    
                    <div class="d-flex flex-column gap-2">
                        @if(!empty($setting->email))
                        <a href="mailto:{{ $setting->email }}" class="kz-channel-item kz-channel-email">
                            <div class="kz-channel-icon"><i class="fa-regular fa-envelope"></i></div>
                            <div>
                                <small class="text-muted d-block" style="font-size: 11px;">General & Bookings</small>
                                <span class="fw-bold text-break" style="font-size: 13px;">{{ $setting->email }}</span>
                            </div>
                            <i class="fa-solid fa-arrow-right ms-auto kz-channel-arrow"></i>
                        </a>
                        @endif

                        @if(!empty($setting->email1))
                        <a href="mailto:{{ $setting->email1 }}" class="kz-channel-item kz-channel-email">
                            <div class="kz-channel-icon"><i class="fa-regular fa-paper-plane"></i></div>
                            <div>
                                <small class="text-muted d-block" style="font-size: 11px;">Operations Desk</small>
                                <span class="fw-bold text-break" style="font-size: 13px;">{{ $setting->email1 }}</span>
                            </div>
                            <i class="fa-solid fa-arrow-right ms-auto kz-channel-arrow"></i>
                        </a>
                        @endif

                        <div class="p-2 rounded-2 mt-1" style="background: #f8fafc; border: 1px dashed #cbd5e1;">
                            <small class="text-muted" style="font-size: 11.5px;"><i class="fa-solid fa-clock-rotate-left me-1 text-primary"></i> Average inquiry turnaround: <strong>15–30 minutes</strong>.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BENTO TILE 5: Office Network & Verified Accreditation -->
            <div class="col-lg-4 col-12">
                <div class="kz-bento-card kz-bento-offices-card h-100">
                    <span class="kz-bento-tag"><i class="fa-solid fa-building text-success"></i> Registered Network</span>
                    <h5 class="kz-bento-subtitle mt-1 mb-3">Branch Offices</h5>
                    
                    <div class="kz-office-item mb-2 pb-2 border-bottom">
                        <strong class="d-block text-primary" style="font-size: 13px;">Head Office (Srinagar)</strong>
                        <small class="text-muted" style="font-size: 12px;">NH1, Near Power House, 191202 Srinagar, J&K</small>
                    </div>

                    <div class="kz-office-item mb-2 pb-2 border-bottom">
                        <strong class="d-block text-dark" style="font-size: 13px;">Delhi Partner Desk</strong>
                        <small class="text-muted" style="font-size: 12px;">Airport Transfers & Flight Assistance, New Delhi</small>
                    </div>

                    <div class="kz-office-item">
                        <strong class="d-block text-dark" style="font-size: 13px;">Leh Ladakh Branch</strong>
                        <small class="text-muted" style="font-size: 12px;">Main Bazaar Road, Leh, Ladakh (UT)</small>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

@endsection
