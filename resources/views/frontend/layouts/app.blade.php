@php
    $raw_wa_number = !empty($setting->whatsapp) 
        ? $setting->whatsapp 
        : (!empty($setting->phone) 
            ? $setting->phone 
            : (!empty($setting->phone1) 
                ? $setting->phone1 
                : '917006338617'));
    $wa_phone_clean = preg_replace('/[^0-9]/', '', (string)$raw_wa_number);
    if (strlen($wa_phone_clean) === 10) {
        $wa_phone_clean = '91' . $wa_phone_clean;
    }
    if (empty($wa_phone_clean)) {
        $wa_phone_clean = '917006338617';
    }
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge"> 
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
    <meta name="author" content="{{ $setting->name ?? 'Love Link Tour & Travels' }}">   
    
    <!--==============================
	  Resource Hints & Preconnects
	============================== -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    <!-- Largest Contentful Paint (LCP) Preload Hook -->
    @yield('preload_lcp')

    <!-- Google Fonts (Non-Blocking Asynchronous Load) -->
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&family=Seaweed+Script&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&family=Seaweed+Script&display=swap">
    </noscript>

    <!-- Tabler Webfont Icons (Non-Blocking) -->
    <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/tabler-icons.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/tabler-icons.min.css">
    </noscript>

    @if(View::hasSection('page_meta'))
        @yield('page_meta')
    @else
        {!! \App\Helpers\SeoEngine::render() !!}
    @endif

    <!-- Favicons -->
    @if(!empty($setting->favicon))
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/' . $setting->favicon) }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/' . $setting->favicon) }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/' . $setting->favicon) }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/' . $setting->favicon) }}">
    @endif
    <link rel="manifest" href="{{ asset('webassets/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    @if(!empty($setting->favicon))
        <meta name="msapplication-TileImage" content="{{ asset('storage/' . $setting->favicon) }}">
    @endif
    <meta name="theme-color" content="#0B3D91">
    
    <!--==============================
	    All CSS Files (Gzip-compressed & Cached)
	============================== -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('webassets/css/bootstrap.min.css') }}">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="{{ asset('webassets/css/fontawesome.min.css') }}">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{ asset('webassets/css/magnific-popup.min.css') }}">

    <!-- Swiper css -->
    <link rel="stylesheet" href="{{ asset('webassets/css/swiper-bundle.min.css') }}">
    <!-- Lenis Smooth Scroll CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lenis@1.1.13/dist/lenis.css">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('webassets/css/style.css') }}?v={{ filemtime(public_path('webassets/css/style.css')) }}">
@yield('page_css') 
    @if(!empty($setting->header_script))
        {!! $setting->header_script !!}
    @endif

</head>
<body>
     
    @include('frontend.layouts.header') <!-- Header File -->
     
    @yield('content') <!-- Page Content --> 
    
    @include('frontend.layouts.footer') <!-- Footer File -->
    
<div class="modal fade" id="globalContactModal" data-default-wa="{{ $wa_phone_clean }}" data-has-errors="{{ $errors->any() ? '1' : '0' }}" tabindex="-1" aria-labelledby="globalContactModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered gb-dialog">
    <div class="modal-content gb-modal">

      <div class="modal-header gb-header flex-column align-items-start">
        <span class="gb-badge">50% off on first booking</span>
        <h5 class="gb-title" id="globalContactModalLabel">Book your package, ride or stay</h5>
        <small class="gb-subtitle">Tell us where you're headed and we'll take care of the rest.</small>
        <button type="button" class="btn-close btn-close-white position-absolute end-0 top-0 m-3"
                data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- TABS: Packages > Cabs > Hotels -->
      <div class="gb-tabs" role="tablist">
        <button type="button" class="gb-tab active" id="gb-tab-packages" data-target="gb-panel-packages" role="tab" aria-selected="true">
          <svg class="gb-tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 6h18M3 12h18M3 18h18"/><rect x="2" y="4" width="20" height="16" rx="2"/>
            <path d="M8 4v16M16 4v16"/>
          </svg>
          Packages
        </button>
        <button type="button" class="gb-tab" id="gb-tab-cabs" data-target="gb-panel-cabs" role="tab" aria-selected="false">
          <svg class="gb-tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 11l1.5-4.5A2 2 0 0 1 8.4 5h7.2a2 2 0 0 1 1.9 1.5L19 11"/><rect x="3" y="11" width="18" height="6" rx="1.5"/><circle cx="7.5" cy="17" r="1.5"/><circle cx="16.5" cy="17" r="1.5"/></svg>
          Cabs
        </button>
        <button type="button" class="gb-tab" id="gb-tab-hotels" data-target="gb-panel-hotels" role="tab" aria-selected="false">
          <svg class="gb-tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21V7a1 1 0 0 1 1-1h4v15"/><path d="M16 21V10a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v11"/><path d="M8 21h13"/><path d="M8 21V3.6a.6.6 0 0 1 .84-.55l6.32 2.7"/><circle cx="12" cy="11" r=".9" fill="currentColor" stroke="none"/></svg>
          Hotels
        </button>
        <button type="button" class="gb-tab" id="gb-tab-houseboats" data-target="gb-panel-houseboats" role="tab" aria-selected="false">
  <svg class="gb-tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 10l7-5 7 5"/><path d="M6.5 10v5"/><path d="M17.5 10v5"/><path d="M3 15h18l-2 3.5a1 1 0 0 1-.87.5H5.87a1 1 0 0 1-.87-.5z"/><path d="M2 22c1.5 0 1.5-1 3-1s1.5 1 3 1 1.5-1 3-1 1.5 1 3 1 1.5-1 3-1 1.5 1 3 1"/><circle cx="12" cy="12.5" r=".9" fill="currentColor" stroke="none"/></svg>
  H-boat
</button>
      </div>

      @if ($errors->any())
        <div class="alert alert-danger gb-alert mx-4 mt-3 mb-0">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <div id="gc-form-alert" style="display:none;"></div>

      <!-- 1. PACKAGES FORM (FIRST & ACTIVE) -->
      <form id="gb-panel-packages" class="gb-panel active" method="POST" action="{{ route('home.global-booking.submit') }}">
        @csrf
        <input type="hidden" name="booking_type" value="package">
        <div class="modal-body">

          <div class="gb-row">
            <div class="gb-field">
              <label class="gb-label" for="pkg-name">Name</label>
              <input type="text" class="form-control" id="pkg-name" name="name"
                     placeholder="Your full name" maxlength="120" required>
            </div>
            <div class="gb-field">
              <label class="gb-label" for="pkg-phone">Phone Number</label>
              <input type="tel" class="form-control" id="pkg-phone" name="phone"
                     placeholder="Your phone number" maxlength="20" required>
            </div>
          </div>

          <div class="gb-row">
            <div class="gb-field">
              <label class="gb-label" for="pkg-destination">Destination</label>
              <div class="gb-input-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-6.5-6.1-6.5-11A6.5 6.5 0 0 1 18.5 10c0 4.9-6.5 11-6.5 11Z"/><circle cx="12" cy="10" r="2.3"/></svg>
                <input type="text" class="form-control" id="pkg-destination" name="destination"
                       placeholder="e.g. Gulmarg, Pahalgam" maxlength="255" required>
              </div>
            </div>
            <div class="gb-field">
              <label class="gb-label" for="pkg-tour">Tour</label>
              <select class="form-control gb-select" id="pkg-tour" name="tour" required>
                <option value="" disabled selected>Select tour type</option>
                <option value="honeymoon">Honeymoon</option>
                <option value="family">Family</option>
                <option value="group">Group</option>
                <option value="adventure">Adventure</option>
                <option value="pilgrimage">Pilgrimage</option>
                <option value="custom">Custom</option>
              </select>
            </div>
          </div>

          <div class="gb-row">
            <div class="gb-field">
              <label class="gb-label" for="pkg-arrival">Arrival Date</label>
              <input type="date" class="form-control" id="pkg-arrival" name="arrival_date" required>
            </div>
            <div class="gb-field">
              <label class="gb-label" for="pkg-persons">Total Persons</label>
              <input type="number" class="form-control" id="pkg-persons" name="total_persons"
                     placeholder="No. of persons" min="1" max="100" value="2" required>
            </div>
          </div>

          <div class="gb-row">
            <div class="gb-field">
              <label class="gb-label" for="pkg-rooms">Room Details</label>
              <input type="number" class="form-control" id="pkg-rooms" name="rooms"
                     placeholder="No. of rooms" min="1" max="20" value="1" required>
            </div>
            <div class="gb-field">
              <label class="gb-label" for="pkg-hotel-cat">Hotel Category</label>
              <select class="form-control gb-select" id="pkg-hotel-cat" name="hotel_category" required>
                <option value="" disabled selected>Select category</option>
                <option value="standard">Standard</option>
                <option value="3-star">3 Star</option>
                <option value="3-star-premium">3 Star Premium</option>
                <option value="4-star-standard">4 Star Standard</option>
                <option value="4-star">4 Star</option>
                <option value="5-star-standard">5 Star Standard</option>
                <option value="5-star">5 Star</option>
              </select>
            </div>
          </div>

          <div class="gb-row">
            <div class="gb-field">
              <label class="gb-label" for="pkg-pickup">Pick-up</label>
              <div class="gb-input-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-6.5-6.1-6.5-11A6.5 6.5 0 0 1 18.5 10c0 4.9-6.5 11-6.5 11Z"/><circle cx="12" cy="10" r="2.3"/></svg>
                <input type="text" class="form-control" id="pkg-pickup" name="pickup_location"
                       placeholder="Pick-up point" maxlength="255" required>
              </div>
            </div>
            <div class="gb-field">
              <label class="gb-label" for="pkg-drop">Drop</label>
              <div class="gb-input-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-6.5-6.1-6.5-11A6.5 6.5 0 0 1 18.5 10c0 4.9-6.5 11-6.5 11Z"/><circle cx="12" cy="10" r="2.3"/></svg>
                <input type="text" class="form-control" id="pkg-drop" name="drop_location"
                       placeholder="Drop-off point" maxlength="255" required>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer gb-footer">
          <button type="submit" class="btn gb-btn-mail" id="pkg-mail-btn">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m22 7-10 7L2 7"></path></svg>
            Book via Mail
          </button>
          <button type="button" class="btn gb-btn-whatsapp" id="pkg-wa-btn" data-whatsapp="{{ $wa_phone_clean }}" data-type="package">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.117 1.528 5.845L.057 23.617a.75.75 0 0 0 .92.919l5.84-1.47A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75a9.718 9.718 0 0 1-4.953-1.354l-.355-.211-3.673.924.942-3.588-.231-.368A9.715 9.715 0 0 1 2.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12 17.385 21.75 12 21.75z"/></svg>
            Book via WhatsApp
          </button>
          <button type="button" class="btn gb-btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>

      <!-- 2. CABS FORM -->
      <form id="gb-panel-cabs" class="gb-panel" method="POST" action="{{ route('home.global-booking.submit') }}">
        @csrf
        <input type="hidden" name="booking_type" value="cab">
        <div class="modal-body">

          <div class="gb-row">
            <div class="gb-field">
              <label class="gb-label" for="cab-name">Name</label>
              <input type="text" class="form-control" id="cab-name" name="name"
                     placeholder="Your full name" maxlength="120" required>
            </div>
            <div class="gb-field">
              <label class="gb-label" for="cab-phone">Phone Number</label>
              <input type="tel" class="form-control" id="cab-phone" name="phone"
                     placeholder="Your phone number" maxlength="20" required>
            </div>
          </div>

          <div class="gb-row">
            <div class="gb-field">
              <label class="gb-label" for="cab-from">From</label>
              <div class="gb-input-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-6.5-6.1-6.5-11A6.5 6.5 0 0 1 18.5 10c0 4.9-6.5 11-6.5 11Z"/><circle cx="12" cy="10" r="2.3"/></svg>
                <input type="text" class="form-control" id="cab-from" name="pickup_location"
                       placeholder="Enter pickup city" maxlength="255" required>
              </div>
            </div>
            <div class="gb-field">
              <label class="gb-label" for="cab-to">To</label>
              <div class="gb-input-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-6.5-6.1-6.5-11A6.5 6.5 0 0 1 18.5 10c0 4.9-6.5 11-6.5 11Z"/><circle cx="12" cy="10" r="2.3"/></svg>
                <input type="text" class="form-control" id="cab-to" name="drop_location"
                       placeholder="Enter drop-off city" maxlength="255" required>
              </div>
            </div>
          </div>

          <div class="gb-row">
            <div class="gb-field">
              <label class="gb-label" for="cab-arrival">Arrival Date</label>
              <input type="date" class="form-control" id="cab-arrival" name="arrival_date" required>
            </div>
            <div class="gb-field">
              <label class="gb-label" for="cab-vehicle">Choose Vehicle</label>
              <select class="form-control gb-select" id="cab-vehicle" name="vehicle" required>
                <option value="" disabled selected>Select a vehicle</option>
                <option value="swift-dzire" data-url="https://demo-lovelinktourandtravels-com.stackstaging.com/cab/swift-dzire">Swift Dzire</option>
                <option value="ertiga" data-url="https://demo-lovelinktourandtravels-com.stackstaging.com/cab/ertiga">Ertiga</option>
                <option value="innova-crysta" data-url="https://demo-lovelinktourandtravels-com.stackstaging.com/cab/innova-crysta">Innova Crysta</option>
                <option value="toyota-etios" data-url="https://demo-lovelinktourandtravels-com.stackstaging.com/cab/toyota-etios">Toyota Etios</option>
                <option value="tavera" data-url="https://demo-lovelinktourandtravels-com.stackstaging.com/cab/tavera">Tavera</option>
                <option value="scorpio">Scorpio</option>
                <option value="tempo-traveller" data-url="https://demo-lovelinktourandtravels-com.stackstaging.com/cab/tempo-traveller">Tempo Traveller</option>
                <option value="toyota-innova" data-url="https://demo-lovelinktourandtravels-com.stackstaging.com/cab/toyota-innova-1">Toyota Innova</option>
                <option value="bus">Bus</option>
              </select>
            </div>
          </div>

          <div class="gb-field">
            <label class="gb-label" for="cab-message">Message</label>
            <textarea class="form-control gb-textarea" id="cab-message" name="message"
                      rows="2" placeholder="Any additional details (optional)"></textarea>
          </div>

        </div>
        <div class="modal-footer gb-footer">
          <button type="submit" class="btn gb-btn-mail" id="cab-mail-btn">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m22 7-10 7L2 7"></path></svg>
            Book via Mail
          </button>
          <button type="button" class="btn gb-btn-whatsapp" id="cab-wa-btn" data-whatsapp="{{ $wa_phone_clean }}" data-type="cab">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.117 1.528 5.845L.057 23.617a.75.75 0 0 0 .92.919l5.84-1.47A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75a9.718 9.718 0 0 1-4.953-1.354l-.355-.211-3.673.924.942-3.588-.231-.368A9.715 9.715 0 0 1 2.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12 17.385 21.75 12 21.75z"/></svg>
            Book via WhatsApp
          </button>
          <button type="button" class="btn gb-btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>

      <!-- 3. HOTELS FORM -->
      <form id="gb-panel-hotels" class="gb-panel" method="POST" action="{{ route('home.global-booking.submit') }}">
        @csrf
        <input type="hidden" name="booking_type" value="hotel">
        <div class="modal-body">

          <div class="gb-row">
            <div class="gb-field">
              <label class="gb-label" for="hotel-name">Name</label>
              <input type="text" class="form-control" id="hotel-name" name="name"
                     placeholder="Your full name" maxlength="120" required>
            </div>
            <div class="gb-field">
              <label class="gb-label" for="hotel-phone">Phone Number</label>
              <input type="tel" class="form-control" id="hotel-phone" name="phone"
                     placeholder="Your phone number" maxlength="20" required>
            </div>
          </div>

          <div class="gb-row">
            <div class="gb-field">
              <label class="gb-label" for="hotel-location">Hotel Location</label>
              <select class="form-control gb-select" id="hotel-location" name="hotel_location" required>
                <option value="" disabled selected>Select location</option>
                <option value="sonamarg">Sonamarg</option>
                <option value="gulmarg">Gulmarg</option>
                <option value="pahalgam">Pahalgam</option>
                <option value="srinagar">Srinagar</option>
              </select>
            </div>
            <div class="gb-field">
              <label class="gb-label" for="hotel-category">Choose Hotel Category</label>
              <select class="form-control gb-select" id="hotel-category" name="hotel_category" required>
                <option value="" disabled selected>Select category</option>
                <option value="standard">Standard</option>
                <option value="3-star">3 Star</option>
                <option value="3-star-premium">3 Star Premium</option>
                <option value="4-star-standard">4 Star Standard</option>
                <option value="4-star">4 Star</option>
                <option value="5-star-standard">5 Star Standard</option>
                <option value="5-star">5 Star</option>
              </select>
            </div>
          </div>

          <div class="gb-row">
            <div class="gb-field">
              <label class="gb-label" for="hotel-checkin">Check-in date</label>
              <input type="date" class="form-control" id="hotel-checkin" name="checkin_date" required>
            </div>
            <div class="gb-field">
              <label class="gb-label" for="hotel-checkout">Check-out date</label>
              <input type="date" class="form-control" id="hotel-checkout" name="checkout_date" required>
            </div>
          </div>

          <div class="gb-row gb-row-3">
            <div class="gb-field">
              <label class="gb-label" for="hotel-rooms">Rooms</label>
              <input type="number" class="form-control" id="hotel-rooms" name="rooms"
                     placeholder="Rooms" min="1" max="20" value="1" required>
            </div>
            <div class="gb-field">
              <label class="gb-label" for="hotel-adults">Adults</label>
              <input type="number" class="form-control" id="hotel-adults" name="adults"
                     placeholder="Adults" min="1" max="20" value="2" required>
            </div>
            <div class="gb-field">
              <label class="gb-label" for="hotel-kids">Kids</label>
              <input type="number" class="form-control" id="hotel-kids" name="kids"
                     placeholder="Kids" min="0" max="20" value="0">
            </div>
          </div>

          <div class="gb-field">
            <label class="gb-label" for="hotel-message">Message</label>
            <textarea class="form-control gb-textarea" id="hotel-message" name="message"
                      rows="2" placeholder="Any additional details (optional)"></textarea>
          </div>

        </div>
        <div class="modal-footer gb-footer">
          <button type="submit" class="btn gb-btn-mail" id="hotel-mail-btn">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m22 7-10 7L2 7"></path></svg>
            Book via Mail
          </button>
          <button type="button" class="btn gb-btn-whatsapp" id="hotel-wa-btn" data-whatsapp="{{ $wa_phone_clean }}" data-type="hotel">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.117 1.528 5.845L.057 23.617a.75.75 0 0 0 .92.919l5.84-1.47A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75a9.718 9.718 0 0 1-4.953-1.354l-.355-.211-3.673.924.942-3.588-.231-.368A9.715 9.715 0 0 1 2.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12 17.385 21.75 12 21.75z"/></svg>
            Book via WhatsApp
          </button>
          <button type="button" class="btn gb-btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
      <form id="gb-panel-houseboats" class="gb-panel" method="POST" action="{{ route('home.global-booking.submit') }}">
        @csrf
        <input type="hidden" name="booking_type" value="hotel">
        <div class="modal-body">

          <div class="gb-row">
            <div class="gb-field">
              <label class="gb-label" for="hotel-name">Name</label>
              <input type="text" class="form-control" id="hotel-name" name="name"
                     placeholder="Your full name" maxlength="120" required>
            </div>
            <div class="gb-field">
              <label class="gb-label" for="hotel-phone">Phone Number</label>
              <input type="tel" class="form-control" id="hotel-phone" name="phone"
                     placeholder="Your phone number" maxlength="20" required>
            </div>
          </div>

          <div class="gb-row">
            <div class="gb-field">
              <label class="gb-label" for="houseboa-location">Houseboat Location</label>
              <select class="form-control gb-select" id="houseboa-location" name="houseboa_location" required>
                <option value="" disabled selected>Select location</option>
                <option value="sonamarg">Dal Lake</option>
                <option value="gulmarg">Nigeen Lake</option>
              </select>
            </div>
            <div class="gb-field">
              <label class="gb-label" for="houseboat-category">Choose Houseboat Category</label>
              <select class="form-control gb-select" id="houseboat-category" name="houseboa_category" required>
                <option value="" disabled selected>Select category</option>
                <option value="standard">Deluxe</option>
                <option value="3-star">Super Deluxe</option>
                <option value="3-star-premium">Premium</option>
                <option value="4-star-standard">4 Star</option>
                
              </select>
            </div>
          </div>

          <div class="gb-row">
            <div class="gb-field">
              <label class="gb-label" for="houseboat-checkin">Check-in date</label>
              <input type="date" class="form-control" id="houseboat-checkin" name="checkin_date" required>
            </div>
            <div class="gb-field">
              <label class="gb-label" for="houseboat-checkout">Check-out date</label>
              <input type="date" class="form-control" id="houseboat-checkout" name="checkout_date" required>
            </div>
          </div>

          <div class="gb-row gb-row-3">
            <div class="gb-field">
              <label class="gb-label" for="houseboat-rooms">Rooms</label>
              <input type="number" class="form-control" id="houseboat-rooms" name="rooms"
                     placeholder="Rooms" min="1" max="20" value="1" required>
            </div>
            <div class="gb-field">
              <label class="gb-label" for="houseboat-adults">Adults</label>
              <input type="number" class="form-control" id="houseboat-adults" name="adults"
                     placeholder="Adults" min="1" max="20" value="2" required>
            </div>
            <div class="gb-field">
              <label class="gb-label" for="houseboat-kids">Kids</label>
              <input type="number" class="form-control" id="houseboat-kids" name="kids"
                     placeholder="Kids" min="0" max="20" value="0">
            </div>
          </div>

          <div class="gb-field">
            <label class="gb-label" for="houseboat-message">Message</label>
            <textarea class="form-control gb-textarea" id="houseboat-message" name="message"
                      rows="2" placeholder="Any additional details (optional)"></textarea>
          </div>

        </div>
        <div class="modal-footer gb-footer">
          <button type="submit" class="btn gb-btn-mail" id="houseboat-mail-btn">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m22 7-10 7L2 7"></path></svg>
            Book via Mail
          </button>
          <button type="button" class="btn gb-btn-whatsapp" id="houseboat-wa-btn" data-whatsapp="{{ $wa_phone_clean }}" data-type="hotel">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.117 1.528 5.845L.057 23.617a.75.75 0 0 0 .92.919l5.84-1.47A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75a9.718 9.718 0 0 1-4.953-1.354l-.355-.211-3.673.924.942-3.588-.231-.368A9.715 9.715 0 0 1 2.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12 17.385 21.75 12 21.75z"/></svg>
            Book via WhatsApp
          </button>
          <button type="button" class="btn gb-btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- ==============================
    All Js Files (Deferred non-blocking loading)
============================== -->
<!-- Jquery -->
<script src="{{ asset('webassets/js/vendor/jquery-3.6.0.min.js') }}" defer></script>

<!-- Swiper Js -->
<script src="{{ asset('webassets/js/swiper-bundle.min.js') }}" defer></script>

<!-- Bootstrap -->
<script src="{{ asset('webassets/js/bootstrap.min.js') }}" defer></script>

<!-- Magnific Popup -->
<script src="{{ asset('webassets/js/jquery.magnific-popup.min.js') }}" defer></script>

<!-- Counter Up -->
<script src="{{ asset('webassets/js/jquery.counterup.min.js') }}" defer></script>

<!-- imagesloaded -->
<script src="{{ asset('webassets/js/imagesloaded.pkgd.min.js') }}" defer></script>

<!-- isotope -->
<script src="{{ asset('webassets/js/isotope.pkgd.min.js') }}" defer></script>

<!-- nice select -->
<script src="{{ asset('webassets/js/nice-select.min.js') }}" defer></script>

<!-- GSAP 3.12.5 & ScrollTrigger -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>
<!-- Lenis 1.1.13 Smooth Scroll -->
<script src="https://cdn.jsdelivr.net/npm/lenis@1.1.13/dist/lenis.min.js" defer></script>

<!-- Love Link Custom Interactions -->
<script src="{{ asset('webassets/js/custom.js') }}?v={{ filemtime(public_path('webassets/js/custom.js')) }}" defer></script>
<!-- Love Link GSAP + Lenis Scroll Animation Engine -->
<script src="{{ asset('webassets/js/scroll-animations.js') }}?v={{ filemtime(public_path('webassets/js/scroll-animations.js')) }}" defer></script>
<!-- Main Js File -->
<script src="{{ asset('webassets/js/main.js') }}" defer></script>
{!! $setting->footer_script !!}
</body>
</html>
