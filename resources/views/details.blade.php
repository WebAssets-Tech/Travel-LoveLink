@extends('frontend.layouts.app')
@section('page_title', $tour->meta_title)
@section('page_meta')  
{!! generateMetaTags($tour) !!} 
@endsection
@section('content')
<style>
/**
 * ============================================================
 * TOUR GALLERY SLIDER & ARROWS STYLES
 * Matches the bottom tour plan arrow design (#0b3358 navy & #ddab43 gold)
 * ============================================================
 */
.space-details{
    padding:10px 0;
}
/* ── 1. Gallery Slider Wrapper ─────────────────────────────── */
.tour-gallery-slider-wrap {
    position: relative !important;
    width: 100% !important;
    margin-bottom: 5px !important;
    border-radius: 16px !important;
    padding: 0 !important;
}

/* Swiper container */
.tour-gallery-slider {
    position: relative !important;
    overflow: hidden !important;
    border-radius: 14px !important;
    padding: 4px 0 !important;
}

/* Slide image container */
.tour-gallery-slider .tour-slider-img {
    position: relative !important;
    border-radius: 12px !important;
    overflow: hidden !important;
    background: #0b335810 !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08) !important;
    transition: transform 0.3s ease, box-shadow 0.3s ease !important;
}

    /* ── 1B. Tour Header Rating & Price Side by Side (Desktop & Mobile) ── */
    .tour-rating-price-row {
        display: flex !important;
        align-items: center !important;
        gap: 18px !important;
        flex-wrap: nowrap !important;
        margin-top: 8px !important;
        margin-bottom: 12px !important;
    }

    .tour-rating-price-row .page-meta {
        margin: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        flex-shrink: 0 !important;
    }

    .tour-rating-price-row .tour-price {
        margin: 0 !important;
        font-size: 20px !important;
        line-height: 1 !important;
        color: #0B3D91 !important;
        display: inline-flex !important;
        align-items: baseline !important;
        gap: 2px !important;
        flex-shrink: 0 !important;
    }

    .tour-rating-price-row .tour-price .currency {
        font-weight: 700 !important;
    }

    @media (max-width: 576px) {
        .page-meta .ratting{
            padding:0 13px !important;
        }
        .tour-rating-price-row {
            justify-content:space-between;
            gap: 12px !important;
            margin-bottom: 10px !important;
        }

        .tour-rating-price-row .tour-price {
            font-size: 17px !important;
        }

        .tour-rating-price-row .tour-price .currency {
            font-size: 18px !important;
        }

        .tour-rating-price-row .page-tag {
            padding: 3px 10px !important;
            font-size: 12px !important;
        }

        .tour-rating-price-row .ratting {
            font-size: 13px !important;
        }
    }

.tour-gallery-slider .tour-slider-img img {
    width: 100% !important;
    height: 100px !important;
    object-fit: cover !important;
    display: block !important;
    transition: transform 0.45s cubic-bezier(0.16, 1, 0.3, 1) !important;
}

.tour-gallery-slider .tour-slider-img:hover img {
    transform: scale(1.08) !important;
}

/* ── 2. Gallery Navigation Arrows (Positioned Directly ON the Image) ── */
.tour-gallery-arrow {
    position: absolute !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    z-index: 20 !important;
    width: 44px !important;
    height: 44px !important;
    border-radius: 50% !important;
    background: #0b3358 !important;
    border: 2px solid rgba(255, 255, 255, 0.2) !important;
    color: #ffffff !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    box-shadow: 0 4px 14px rgba(11, 51, 88, 0.35) !important;
    transition: all 0.28s cubic-bezier(0.16, 1, 0.3, 1) !important;
    outline: none !important;
    padding: 0 !important;
}

/* Placements on image */
.tour-gallery-prev {
    left: 14px !important;
}

.tour-gallery-next {
    right: 14px !important;
}

/* Chevron icons */
.tour-gallery-arrow i {
    font-size: 16px !important;
    color: #ffffff !important;
    line-height: 1 !important;
    transition: transform 0.2s ease !important;
}

/* Hover & Active States */
.tour-gallery-arrow:hover {
    background: #ddab43 !important;
    border-color: #ddab43 !important;
    box-shadow: 0 6px 18px rgba(221, 171, 67, 0.5) !important;
    transform: translateY(-50%) scale(1.08) !important;
}

.tour-gallery-arrow:hover i {
    color: #ffffff !important;
}

.tour-gallery-arrow:active {
    transform: translateY(-50%) scale(0.95) !important;
}

.tour-gallery-prev:hover i {
    transform: translateX(-2px) !important;
}

.tour-gallery-next:hover i {
    transform: translateX(2px) !important;
}

/* Disabled Swiper State */
.tour-gallery-arrow.swiper-button-disabled,
.tour-gallery-arrow:disabled {
    opacity: 0.35 !important;
    cursor: not-allowed !important;
    pointer-events: none !important;
}

/* ── 3. Tour Plan (Bottom) Arrows Alignment Helper ─────────── */
.tour-day-arrows-mobile .slider-mobile-btn {
    width: 38px !important;
    height: 38px !important;
    border-radius: 50% !important;
    background: #0b3358 !important;
    border: none !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    color: #ffffff !important;
    transition: all 0.25s ease !important;
}

.tour-day-arrows-mobile .slider-mobile-btn:hover {
    background: #ddab43 !important;
    transform: scale(1.08) !important;
}

/* ── 4. Responsive Breakpoints ─────────────────────────────── */
@media (max-width: 768px) {
    .tour-gallery-arrow {
        width: 38px !important;
        height: 38px !important;
    }

    .tour-gallery-arrow i {
        font-size: 14px !important;
    }

    .tour-gallery-prev {
        left: 8px !important;
    }

    .tour-gallery-next {
        right: 8px !important;
    }
}

@media (max-width: 576px) {
    .tour-gallery-slider .tour-slider-img {
        border-radius: 12px !important;
    }
}

/* Tour Day Slider Arrows */
.tour-day-slider-area {
    padding: 0 50px;
}

.tour-day-slider-area .slider-arrow {
    position: absolute !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    z-index: 10 !important;
    width: 44px !important;
    height: 44px !important;
    border-radius: 50% !important;
    background: #0b3358 !important;
    border: none !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15) !important;
    transition: all 0.3s ease !important;
}

.tour-day-slider-area .slider-arrow:hover {
    background: #ddab43;
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
}

.tour-day-slider-area .slider-arrow img {
    width: 20px;
    height: 20px;
    filter: brightness(0) invert(1);
}

.tour-day-slider-area .slider-prev {
    left: 0;
}

.tour-day-slider-area .slider-next {
    right: 0;
}

/* ── 5. Tabs Content Box-Shaped Grid Background ───────────── */
.kaw-tab-content {
    background-color: #fafbfc !important;
    background-image: 
        linear-gradient(rgba(11, 61, 145, 0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(11, 61, 145, 0.04) 1px, transparent 1px) !important;
    background-size: 28px 28px !important;
    border: 1px solid rgba(11, 61, 145, 0.09) !important;
    border-radius: 18px !important;
    padding: 24px !important;
    box-shadow: 0 4px 18px rgba(11, 61, 145, 0.04) !important;
}

/* ── 5B. Inner Shaded Card (Matches Tour Plan & Checklist Two-Tone Look) ── */
.tour-info-card {
    background: #0b3d9114 !important;
    border: 1px solid rgba(11, 61, 145, 0.08) !important;
    border-radius: 14px !important;
    padding: 20px 24px !important;
    color: #334155 !important;
    line-height: 1.75 !important;
}
.tour-info-card p,
.tour-info-card div {
    color: #475569 !important;
    line-height: 1.75 !important;
}
.tour-info-card p:last-child {
    margin-bottom: 0 !important;
}

/* ── 5C. Single Column Bullet Dot Layout for Included, Excluded & Special Remarks ── */
.kaw-single-list {
    background:#0b3d9114 !important;
    width: 100% !important;
    margin: 0 !important;
    border-radius:15px !important;
    padding: 20px !important;
}
.kaw-single-list ul {
    list-style: none !important;
    padding: 0 !important;
    margin: 0 !important;
    display: flex !important;
    flex-direction: column !important;
    gap: 12px !important;
}
.kaw-single-list li {
    display: flex !important;
    align-items: flex-start !important;
    gap: 12px !important;
    font-size: 13px !important;
    line-height: 1.6 !important;
    color: #475569  !important;
    /*font-weight: 500 !important;*/
    margin: 0 !important;
    padding: 0 !important;
}
.kaw-dot-bullet {
    width: 7px !important;
    height: 7px !important;
    min-width: 7px !important;
    border-radius: 50% !important;
    background-color: #000 !important;
    margin-top: 8px !important;
    flex-shrink: 0 !important;
    /*box-shadow: 0 0 0 3px rgba(11, 61, 145, 0.15) !important;*/
}

/* ── 6. Small & Minimal Package Booking Form ───────────────── */
.kaw-booking-wrap {
    width: 100%;
}
.kaw-booking-box {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid rgba(11, 61, 145, 0.1);
    box-shadow: 0 4px 18px rgba(11, 61, 145, 0.06);
    padding: 18px 20px;
    position: relative;
    overflow: hidden;
}
.kaw-booking-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #0B3D91 0%, #ddab43 100%);
}
.kaw-booking-badge {
    background: rgba(221, 171, 67, 0.15);
    color: #855307;
    font-size: 10.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding: 2px 7px;
    border-radius: 4px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    margin-bottom: 2px;
}
.kaw-booking-title {
    font-size: 17px;
    font-weight: 800;
    color: #072355;
    margin: 0;
}
.kaw-booking-price-pill {
    font-size: 12px;
    color: #64748b;
    background: #f8fafc;
    border: 1px solid rgba(11, 61, 145, 0.08);
    padding: 4px 12px;
    border-radius: 20px;
}
.kaw-booking-price-pill strong {
    color: #0B3D91;
    font-size: 15px;
    font-weight: 800;
}
.kaw-label {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    margin-bottom: 4px;
}
.kaw-label i {
    color: #0B3D91;
    font-size: 11px;
}
.kaw-input {
    width: 100%;
    background: #f8fafc;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 6px 10px;
    font-size: 12.5px;
    color: #1e293b;
    font-weight: 500;
    height: 36px;
    transition: all 0.2s ease;
}
textarea.kaw-input {
    height: 36px;
    min-height: 36px;
    resize: vertical;
    line-height: 1.4;
    padding-top: 7px;
}
.kaw-input:focus {
    background: #ffffff;
    border-color: #0B3D91;
    box-shadow: 0 0 0 3px rgba(11, 61, 145, 0.1);
    outline: none;
}
.kaw-readonly {
    background: #f1f5f9;
    color: #0B3D91;
    font-weight: 700;
    border-color: #e2e8f0;
    cursor: default;
}
@media (max-width: 576px) {
    .kaw-booking-box {
        padding: 14px 12px !important;
    }
    .kaw-label {
        font-size: 10px !important;
        margin-bottom: 2px !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    .kaw-input {
        padding: 5px 8px !important;
        font-size: 11.5px !important;
        height: 34px !important;
    }
    textarea.kaw-input {
        height: 34px !important;
        min-height: 34px !important;
        padding-top: 6px !important;
    }
}
.kaw-book-btn {
    width: 100%;
    height: 36px;
    background: #0B3D91;
    color: #ffffff !important;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    cursor: pointer;
    box-shadow: 0 3px 10px rgba(11, 61, 145, 0.2);
    transition: all 0.25s ease;
}
.kaw-book-btn:hover {
    background: #ddab43;
    color: #072355 !important;
    transform: translateY(-1px);
    box-shadow: 0 5px 14px rgba(221, 171, 67, 0.35);
}
</style>

<!--==============================
tour Area
==============================-->
<section class="space-details">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-lg-12">
                <div class="tour-page-single">

                    {{-- Image Slider (Scoped with .tour-gallery-slider-wrap & #tourGallerySlider) --}}
                    <div class="slider-area tour-slider1 tour-gallery-slider-wrap position-relative">
                        <div class="swiper th-slider tour-thumb-slider tour-gallery-slider" id="tourGallerySlider"
                             data-slider-options='{
                                "effect": "slide",
                                "loop": true,
                                "grabCursor": true,
                                "breakpoints": {
                                    "0": {"slidesPerView": 2, "spaceBetween": 12},
                                    "576": {"slidesPerView": 2, "spaceBetween": 16},
                                    "768": {"slidesPerView": 3, "spaceBetween": 20},
                                    "992": {"slidesPerView": 4, "spaceBetween": 20},
                                    "1200": {"slidesPerView": 4, "spaceBetween": 24}
                                },
                                "autoplayDisableOnInteraction": "true"
                             }'>
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="tour-slider-img">
                                        <img src="{{ asset('storage/' . $tour->banner_image) }}" alt="Image">
                                    </div>
                                </div>
                                @if(!empty($tour->footer_gallery))
                                    @foreach(json_decode($tour->footer_gallery) as $image)
                                    <div class="swiper-slide">
                                        <div class="tour-slider-img">
                                            <img src="{{ asset('storage/' . $image) }}" alt="img">
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        {{-- Gallery Slider Navigation Arrows (Positioned Directly ON the Image) --}}
                        <button type="button" data-slider-prev="#tourGallerySlider" class="tour-gallery-arrow tour-gallery-prev" aria-label="Previous image">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <button type="button" data-slider-next="#tourGallerySlider" class="tour-gallery-arrow tour-gallery-next" aria-label="Next image">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>

                    {{-- Tour Header --}}
                    <div class="page-content">
                        <div class="tour-rating-price-row">
                            <div class="page-meta">
                                <a class="page-tag" href="#">Rating</a>
                                <span class="ratting"><i class="fa-sharp fa-solid fa-star"></i><span>4.8</span></span>
                            </div>
                            <h4 class="tour-price"><span class="currency">{{ str_replace('.00', '', $tour->formatted_price) }}</span>/PP</h4>
                        </div>
                        <h2 class="box-title">{{ $tour->title }}</h2>

                        {{-- ========== VERTICAL TABS LAYOUT ========== --}}
                        <div class="row">
                            {{-- LEFT: Vertical Tab Buttons (col-md-3) --}}
                            <div class="col-md-3">
                                <ul class="nav nav-tabs tour-tab flex-column kaw-vertical-tabs" id="tourDetailTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview-pane" type="button" role="tab" aria-controls="overview-pane" aria-selected="true">
                                            <i class="ti ti-info-circle"></i> Overview
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="plan-tab" data-bs-toggle="tab" data-bs-target="#plan-pane" type="button" role="tab" aria-controls="plan-pane" aria-selected="false">
                                            <i class="ti ti-map-2"></i> Tour Plan
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="included-tab" data-bs-toggle="tab" data-bs-target="#included-pane" type="button" role="tab" aria-controls="included-pane" aria-selected="false">
                                            <i class="ti ti-circle-check"></i> Included
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="excluded-tab" data-bs-toggle="tab" data-bs-target="#excluded-pane" type="button" role="tab" aria-controls="excluded-pane" aria-selected="false">
                                            <i class="ti ti-circle-x"></i> Excluded
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="remarks-tab" data-bs-toggle="tab" data-bs-target="#remarks-pane" type="button" role="tab" aria-controls="remarks-pane" aria-selected="false">
                                            <i class="ti ti-alert-triangle"></i> Special Remarks
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="booking-tab" data-bs-toggle="tab" data-bs-target="#booking-pane" type="button" role="tab" aria-controls="booking-pane" aria-selected="false">
                                            <i class="ti ti-clipboard-check"></i> Booking Policy
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="cancellation-tab" data-bs-toggle="tab" data-bs-target="#cancellation-pane" type="button" role="tab" aria-controls="cancellation-pane" aria-selected="false">
                                            <i class="ti ti-calendar-x"></i> Cancellation Policy
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            {{-- RIGHT: Tab Content (col-md-9) --}}
                            <div class="col-md-9">
                                <div class="tab-content kaw-tab-content" id="tourDetailTabContent">

                                    {{-- Overview --}}
                                    <div class="tab-pane fade show active" id="overview-pane" role="tabpanel" aria-labelledby="overview-tab" tabindex="0">
                                        <h2 class="box-title">Overview</h2>
                                        <div class="tour-info-card">
                                            @if(!empty(trim(strip_tags($tour->description ?? ''))))
                                                <div class="overview-description @if(!empty(trim(strip_tags($tour->basic_content ?? '')))) mb-3 @endif">
                                                    {!! $tour->description !!}
                                                </div>
                                            @endif
                                            @if(!empty(trim(strip_tags($tour->basic_content ?? ''))))
                                                <div class="overview-content">
                                                    {!! $tour->basic_content !!}
                                                </div>
                                            @endif
                                            @if(empty(trim(strip_tags($tour->description ?? ''))) && empty(trim(strip_tags($tour->basic_content ?? ''))))
                                                <p class="mb-0">Explore our handcrafted tour itinerary and experience the best destinations, luxury stays, and memorable journeys.</p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Booking Policy --}}
                                    <div class="tab-pane fade" id="booking-pane" role="tabpanel" aria-labelledby="booking-tab" tabindex="0">
                                        <h2 class="box-title">Booking Policy</h2>
                                        <div class="tour-info-card">
                                            @if(!empty(trim(strip_tags($tour->booking ?? ''))))
                                                {!! $tour->booking !!}
                                            @else
                                                <p class="mb-0">To confirm your booking, please submit your travel details. Our team will verify availability and share payment confirmation immediately.</p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Cancellation Policy --}}
                                    <div class="tab-pane fade" id="cancellation-pane" role="tabpanel" aria-labelledby="cancellation-tab" tabindex="0">
                                        <h2 class="box-title">Cancellation Policy</h2>
                                        <div class="tour-info-card">
                                            @if(!empty(trim(strip_tags($tour->cancellation ?? ''))))
                                                {!! $tour->cancellation !!}
                                            @else
                                                <p class="mb-0">Cancellations made 15 days prior to arrival are eligible for a partial refund as per hotel and transport partner guidelines.</p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Special Remarks (Single Column with Bullet Dots) --}}
                                    <div class="tab-pane fade" id="remarks-pane" role="tabpanel" aria-labelledby="remarks-tab" tabindex="0">
                                        <h2 class="box-title">Special Remarks</h2>
                                        <div class="kaw-single-list">
                                            @php
                                                $existingImpor = $tour->basic ?? [];
                                                if (is_string($existingImpor)) {
                                                    $existingImpor = json_decode($existingImpor, true) ?: [$existingImpor];
                                                }
                                            @endphp
                                            @if (!empty($existingImpor) && is_array($existingImpor))
                                                <ul>
                                                    @foreach ($existingImpor as $important_info)
                                                        @if(!empty(trim($important_info)))
                                                        <li>
                                                            <span class="kaw-dot-bullet"></span>
                                                            <span>{{ $important_info }}</span>
                                                        </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p class="text-muted mb-0">No special remarks noted for this tour.</p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Included (Single Column with Bullet Dots, No Ticks) --}}
                                    <div class="tab-pane fade" id="included-pane" role="tabpanel" aria-labelledby="included-tab" tabindex="0">
                                        <h2 class="box-title">Included</h2>
                                        @if(!empty(trim(strip_tags($tour->include_exclude_content ?? ''))))
                                            <div class="tour-info-card mb-20">
                                                {!! $tour->include_exclude_content !!}
                                            </div>
                                        @endif
                                        @php
                                            $incRaw = $tour->include_exclude;
                                            if (is_string($incRaw)) {
                                                $incRaw = json_decode($incRaw, true);
                                            }
                                            $include_exclude = is_array($incRaw) ? $incRaw : (is_object($incRaw) ? (array)$incRaw : []);
                                            $includedItems = [];
                                            foreach ($include_exclude as $chkItem) {
                                                $chkObj = (object) $chkItem;
                                                if (isset($chkObj->type) && $chkObj->type == 1 && !empty($chkObj->title)) {
                                                    $includedItems[] = $chkObj->title;
                                                }
                                            }
                                            if (empty($includedItems)) {
                                                $includedItems = [
                                                    'Comfortable Hotel / Houseboat Accommodation',
                                                    'Daily Delicious Breakfast & Dinner',
                                                    'Dedicated Private Cab for Airport Transfers & Sightseeing',
                                                    '1-Hour Romantic Shikara Ride on Dal Lake',
                                                    'All Toll Taxes, Driver Allowances & Parking Fees'
                                                ];
                                            }
                                        @endphp
                                        <div class="kaw-single-list">
                                            <ul>
                                                @foreach ($includedItems as $itemTitle)
                                                    <li>
                                                        <span class="kaw-dot-bullet"></span>
                                                        <span>{{ $itemTitle }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                    {{-- Excluded (Single Column with Bullet Dots, No Crosses) --}}
                                    <div class="tab-pane fade" id="excluded-pane" role="tabpanel" aria-labelledby="excluded-tab" tabindex="0">
                                        <h2 class="box-title">Excluded</h2>
                                        @php
                                            $excludedItems = [];
                                            foreach ($include_exclude as $chkItem) {
                                                $chkObj = (object) $chkItem;
                                                if (isset($chkObj->type) && $chkObj->type == 0 && !empty($chkObj->title)) {
                                                    $excludedItems[] = $chkObj->title;
                                                }
                                            }
                                            if (empty($excludedItems)) {
                                                $excludedItems = [
                                                    'Airfare / Train tickets to and from Srinagar',
                                                    'Personal expenses (laundry, beverages, extra meals)',
                                                    'Gondola cable car tickets in Gulmarg',
                                                    'Pony rides, sledging, or snow activities',
                                                    'Anything not specifically mentioned in inclusions'
                                                ];
                                            }
                                        @endphp
                                        <div class="kaw-single-list">
                                            <ul>
                                                @foreach ($excludedItems as $itemTitle)
                                                    <li>
                                                        <span class="kaw-dot-bullet"></span>
                                                        <span>{{ $itemTitle }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                    {{-- Tour Plan --}}
                                    <div class="tab-pane fade" id="plan-pane" role="tabpanel" aria-labelledby="plan-tab" tabindex="0">
                                        
                                        {{-- Header Area: Title + Arrows (Visible on ALL devices) --}}
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h3 class="page-title mt-0 mb-0">Tour Plan</h3>
                                            
                                            <div class="tour-day-arrows-mobile d-flex" style="gap: 10px;">
                                                <button data-slider-prev="#tourDaySlider" class="btn btn-primary slider-mobile-btn" aria-label="Previous day">
                                                    <i class="fa-solid fa-chevron-left"></i>
                                                </button>
                                                <button data-slider-next="#tourDaySlider" class="btn btn-primary slider-mobile-btn" aria-label="Next day">
                                                    <i class="fa-solid fa-chevron-right"></i>
                                                </button>
                                            </div>
                                        </div>

                                        @php
                                            $itineraryData = json_decode($tour->itinerary, true);
                                        @endphp

                                        <div class="slider-area tour-day-slider-area position-relative">
                                            <div class="swiper th-slider tour-day-slider" id="tourDaySlider"
                                                 data-slider-options='{
                                                    "slidesPerView": 1,
                                                    "spaceBetween": 20,
                                                    "loop": false,
                                                    "breakpoints": {
                                                        "0": {"slidesPerView": 1},
                                                        "576": {"slidesPerView": 1},
                                                        "768": {"slidesPerView": 1},
                                                        "992": {"slidesPerView": 1},
                                                        "1200": {"slidesPerView": 1}
                                                    }
                                                 }'>
                                                <div class="swiper-wrapper">
                                                    @foreach ($itineraryData as $day => $details)
                                                        @php $dayNumber = str_replace('day_', '', $day); @endphp
                                                        <div class="swiper-slide">
                                                            <div class="tour-day-block h-100">
                                                                <h4 class="day-title">Day {{ str_pad($dayNumber, 2, '0', STR_PAD_LEFT) }}</h4>
                                                                <div class="tour-grid-plan">
                                                                    {{ $details }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        {{-- END VERTICAL TABS LAYOUT --}}

                        {{-- ========================================== --}}
                        {{-- MINIMAL PACKAGE BOOKING FORM               --}}
                        {{-- ========================================== --}}
                        <div class="kaw-booking-wrap mt-30 mb-10">
                            <div class="kaw-booking-box">
                                <div class="kaw-booking-header d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                                    <div>
                                        <span class="kaw-booking-badge"><i class="fa-solid fa-bolt"></i> Instant Booking</span>
                                        <h4 class="kaw-booking-title mb-0">Book This Package</h4>
                                    </div>
                                    <div class="kaw-booking-price-pill">
                                        <span>Starting from <strong>{{ str_replace('.00', '', $tour->formatted_price) }}</strong> / PP</span>
                                    </div>
                                </div>

                                <form action="{{ Route::has('home.contact.submit') ? route('home.contact.submit') : url('/contact-submit') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                                    <input type="hidden" name="subject" value="Package Booking: {{ $tour->title }}">

                                    <div class="row g-2 align-items-end">
                                        {{-- Package Title (Automatic / Readonly) --}}
                                        <div class="col-6 col-md-6 col-lg-4">
                                            <label class="kaw-label"><i class="fa-solid fa-box-archive"></i> Package Title</label>
                                            <input type="text" name="package_title" value="{{ $tour->title }}" class="kaw-input kaw-readonly" readonly title="{{ $tour->title }}">
                                        </div>

                                        {{-- Name --}}
                                        <div class="col-6 col-md-6 col-lg-4">
                                            <label class="kaw-label"><i class="fa-solid fa-user"></i> Name</label>
                                            <input type="text" name="name" class="kaw-input" placeholder="Your Name" required>
                                        </div>

                                        {{-- Phone Number --}}
                                        <div class="col-6 col-md-6 col-lg-4">
                                            <label class="kaw-label"><i class="fa-solid fa-phone"></i> Phone Number</label>
                                            <input type="tel" name="number" class="kaw-input" placeholder="Phone / WhatsApp" required>
                                        </div>

                                        {{-- Destination --}}
                                        <div class="col-6 col-md-6 col-lg-3">
                                            <label class="kaw-label"><i class="fa-solid fa-location-dot"></i> Destination</label>
                                            <input type="text" name="destination" class="kaw-input" value="{{ $tour->location ?? 'Kashmir' }}" placeholder="Destination" required>
                                        </div>

                                        {{-- Arrival Date --}}
                                        <div class="col-6 col-md-6 col-lg-3">
                                            <label class="kaw-label"><i class="fa-solid fa-calendar-days"></i> Arrival Date</label>
                                            <input type="date" name="arrival_date" class="kaw-input" required min="{{ date('Y-m-d') }}">
                                        </div>

                                        {{-- No of Persons --}}
                                        <div class="col-6 col-md-6 col-lg-3">
                                            <label class="kaw-label"><i class="fa-solid fa-users"></i> No of Persons</label>
                                            <input type="number" name="no_of_persons" class="kaw-input" min="1" max="50" value="2" placeholder="Persons" required>
                                        </div>

                                        {{-- Room Details --}}
                                        <div class="col-6 col-md-6 col-lg-3">
                                            <label class="kaw-label"><i class="fa-solid fa-bed"></i> Room Details</label>
                                            <textarea name="room_details" class="kaw-input" placeholder="e.g. 1 Double Room, Extra Bed" rows="1"></textarea>
                                        </div>

                                        {{-- Hotel Category --}}
                                        <div class="col-6 col-md-6 col-lg-9">
                                            <label class="kaw-label"><i class="fa-solid fa-hotel"></i> Hotel Category</label>
                                            <select name="hotel_category" class="kaw-input">
                                                <option value="Standard" selected>Standard</option>
                                                <option value="3 Star">3 Star</option>
                                                <option value="3 Star Premium">3 Star Premium</option>
                                                <option value="4 Star Standard">4 Star Standard</option>
                                                <option value="4 Star">4 Star</option>
                                                <option value="5 Star Standard">5 Star Standard</option>
                                                <option value="5 Star">5 Star</option>
                                            </select>
                                        </div>

                                        {{-- Book Now Button --}}
                                        <div class="col-12 col-md-12 col-lg-3">
                                            <button type="submit" class="kaw-book-btn">
                                                <span>Book Now</span>
                                                <i class="fa-solid fa-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Shape decorations --}}
    <div class="shape-mockup about-shape movingX d-none d-xxl-block" data-bottom="40%" data-right="17%">
        <img src="{{ asset('webassets/img/normal/about-slide-img.png') }}" alt="shape">
    </div>
    <div class="shape-mockup about-rating d-none d-xxl-block" data-bottom="48%" data-right="12%">
        <i class="fa-sharp fa-solid fa-star"></i><span>4.9k</span>
    </div>
    <div class="shape-mockup about-emoji d-none d-xxl-block" data-bottom="45%" data-right="29%">
        <img src="{{ asset('webassets/img/icon/emoji.png') }}" alt="">
    </div>
    <div class="shape-mockup shape1 d-none d-xxl-block" data-bottom="55%" data-right="12%">
        <img src="{{ asset('webassets/img/shape/shape_1.png') }}" alt="shape">
    </div>
    <div class="shape-mockup shape2 d-none d-xl-block" data-bottom="51%" data-right="8%">
        <img src="{{ asset('webassets/img/shape/shape_2.png') }}" alt="shape">
    </div>
    <div class="shape-mockup shape3 d-none d-xxl-block" data-bottom="53%" data-right="5%">
        <img src="{{ asset('webassets/img/shape/shape_3.png') }}" alt="shape">
    </div>
</section>

<!--==============================
Related Tours / Packages Area (Matches Previous Packages Architecture)
==============================-->
<style>
/* Scoped styles for Related Packages to match previous packages */
.related-packages-section {
    padding: 40px 0 70px;
    background: #f8fafc;
}
.related-packages-section .title-area {
    margin-bottom: 35px;
}
.related-packages-section .sub-title {
    color: #ddab43;
    font-weight: 700;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    display: block;
    margin-bottom: 6px;
}
.related-packages-section .sec-title {
    color: #072355;
    font-size: 32px;
    font-weight: 800;
    margin: 0;
}
.kaw-pkg-card {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid rgba(11, 61, 145, 0.08);
    box-shadow: 0 4px 18px rgba(11, 61, 145, 0.05);
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
    transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.25s ease;
}
.kaw-pkg-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 36px rgba(11, 61, 145, 0.12);
    border-color: rgba(11, 61, 145, 0.22);
}
.kaw-pkg-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    z-index: 3;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.kaw-badge-deal {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #ffffff;
    box-shadow: 0 3px 10px rgba(239, 68, 68, 0.3);
}
.kaw-badge-booked {
    background: linear-gradient(135deg, #ddab43 0%, #b88a29 100%);
    color: #072355;
    box-shadow: 0 3px 10px rgba(221, 171, 67, 0.35);
}
.kaw-pkg-img-wrap {
    height: 200px;
    position: relative;
    overflow: hidden;
    background: #0f172a;
}
.kaw-pkg-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}
.kaw-pkg-card:hover .kaw-pkg-img {
    transform: scale(1.08);
}
.kaw-img-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(7, 35, 85, 0.1) 0%, rgba(7, 35, 85, 0.3) 50%, rgba(7, 35, 85, 0.85) 100%);
    pointer-events: none;
}
.kaw-img-title {
    position: absolute;
    bottom: 12px;
    left: 14px;
    right: 14px;
    margin: 0;
    font-size: 15.5px;
    font-weight: 700;
    color: #ffffff;
    line-height: 1.35;
    z-index: 2;
    text-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
}
.kaw-img-title a {
    color: #ffffff !important;
    text-decoration: none;
    transition: color 0.2s ease;
}
.kaw-img-title a:hover {
    color: #ddab43 !important;
}
.kaw-pkg-body {
    padding: 16px 14px 14px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}
.kaw-pkg-tags {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 6px;
}
.kaw-pkg-pill {
    background: #fef8ec;
    color: #855307;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 12px;
    border: 1px solid rgba(221, 171, 67, 0.3);
    display: inline-block;
}
.kaw-pkg-itinerary {
    font-size: 12px;
    color: #475569;
    margin: 6px 0 14px;
    line-height: 1.45;
    font-weight: 500;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.kaw-itinerary-stop {
    color: #334155;
}
.kaw-itinerary-dot {
    color: #ddab43;
    font-weight: 800;
    margin: 0 3px;
}
.kaw-pkg-bottom {
    background: #f8fafc;
    border: 1px solid rgba(11, 61, 145, 0.06);
    border-radius: 12px;
    padding: 12px 10px 10px;
    margin-top: auto;
}
.kaw-pkg-amenities {
    display: flex;
    align-items: center;
    justify-content: space-around;
    gap: 4px;
    padding-bottom: 10px;
    border-bottom: 1px dashed #cbd5e1;
    margin-bottom: 10px;
}
.kaw-amenity-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 3px;
    text-align: center;
    color: #64748b;
}
.kaw-amenity-item i {
    font-size: 14px;
    color: #0B3D91;
    transition: color 0.2s ease;
}
.kaw-pkg-card:hover .kaw-amenity-item i {
    color: #ddab43;
}
.kaw-amenity-item span {
    font-size: 9.5px;
    font-weight: 600;
    white-space: nowrap;
}
.kaw-pkg-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
}
.kaw-pkg-price-block {
    line-height: 1.2;
}
.kaw-pkg-old-price-row {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 2px;
}
.kaw-pkg-old-price {
    font-size: 11px;
    text-decoration: line-through;
    color: #94a3b8;
    font-weight: 500;
}
.kaw-pkg-discount {
    font-size: 10px;
    font-weight: 700;
    color: #16a34a;
    background: rgba(221, 171, 67, 0.15);
    padding: 2px 5px;
    border-radius: 6px;
}
.kaw-pkg-price {
    font-size: 16px;
    font-weight: 800;
    color: #072355;
    margin: 0;
}
.kaw-pkg-price-label {
    font-size: 9.5px;
    color: #64748b;
    display: block;
    font-weight: 500;
}
.kaw-pkg-btn {
    background: #0B3D91;
    color: #ffffff !important;
    font-size: 11.5px;
    font-weight: 700;
    padding: 8px 14px;
    border-radius: 20px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all 0.25s ease;
    white-space: nowrap;
    border: none;
}
.kaw-pkg-btn:hover {
    background: #ddab43 !important;
    color: #072355 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(221, 171, 67, 0.35);
}
</style>

<section class="related-packages-section">
    <div class="container">
        <div class="title-area text-center mb-40">
            <span class="sub-title">Explore More</span>
            <h2 class="sec-title">Related Packages & Itineraries</h2>
        </div>
        <div class="row gy-4">
            @php
                $relatedTours = $relatedTours ?? (isset($tour->category_id) ? \App\Models\Tour::where('id', '!=', $tour->id)->where('category_id', $tour->category_id)->take(3)->get() : \App\Models\Tour::where('id', '!=', $tour->id)->take(4)->get());
                if ($relatedTours->isEmpty()) {
                    $relatedTours = \App\Models\Tour::where('id', '!=', $tour->id)->latest()->take(4)->get();
                }
            @endphp
            @foreach($relatedTours as $item)
                <div class="col-xl-3 col-lg-4 col-md-6">

                                <div class="kaw-pkg-card">
                                    @if(isset($item->badge_type) && $item->badge_type === 'deal')
                                        <span class="kaw-pkg-badge kaw-badge-deal">
                                            <i class="ti ti-discount-2"></i> Deal
                                        </span>
                                    @elseif((isset($item->badge_type) && $item->badge_type === 'most_booked') || (isset($loop) && $loop->first))
                                        <span class="kaw-pkg-badge kaw-badge-booked">
                                            <i class="ti ti-thumb-up"></i> Most Booked
                                        </span>
                                    @elseif(!empty($item->discount_percent))
                                        <span class="kaw-pkg-badge kaw-badge-discount">
                                            {{ $item->discount_percent }}% OFF
                                        </span>
                                    @endif

                                    <div class="kaw-pkg-img-wrap">
                                        <a href="{{ route('tour.details', $item->slug) }}" class="kaw-pkg-img-link" aria-label="{{ $item->title }}">
                                            <img src="{{ asset('storage/' . ($item->image ?? $item->banner_image)) }}" alt="{{ $item->title }}" class="kaw-pkg-img" loading="lazy">
                                        </a>
                                        @if(isset($item->gallery_count) && $item->gallery_count > 1)
                                        <button class="kaw-pkg-arrow kaw-pkg-arrow-prev" aria-label="Previous"><i class="ti ti-chevron-left"></i></button>
                                        <button class="kaw-pkg-arrow kaw-pkg-arrow-next" aria-label="Next"><i class="ti ti-chevron-right"></i></button>
                                        @endif
                                    </div>

                                    <div class="kaw-pkg-body">
                                        <div class="kaw-pkg-meta-top">
                                            <h3 class="kaw-pkg-title">
                                                <a href="{{ route('tour.details', $item->slug) }}">{{ $item->title }}</a>
                                            </h3>
                                            <p class="kaw-pkg-subtitle">
                                                @if(isset($item->state->name))
                                                    {{ ucwords($item->state->name ?? 'Kashmir') }} Package
                                                @elseif(isset($item->category->name))
                                                    {{ $item->category->name }}
                                                @else
                                                    Luxury Tour Package
                                                @endif
                                                @if(isset($item->duration) && $item->duration > 0)
                                                    • {{ $item->duration > 1 ? ($item->duration - 1) . 'N/' . $item->duration . 'D' : $item->duration . ' Days' }}
                                                @endif
                                            </p>
                                            
                                        </div>

                                        {{-- Specs Row: Exact replica of Card Two --}}
                                        <div class="kaw-pkg-spec-row">
                                            <div class="kaw-spec-item kaw-spec-price">
                                                <i class="fa-solid fa-tag kaw-spec-icon"></i>
                                                <span class="kaw-spec-from">from</span>
                                                <span class="kaw-spec-amount">{{ str_replace('.00', '', $item->formatted_price ?? ('₹' . number_format($item->price ?? 0))) }}</span>
                                            </div>
                                            <div class="kaw-spec-item kaw-spec-code">
                                                <i class="fa-solid fa-plane-departure kaw-spec-icon"></i>
                                                <span class="kaw-spec-dest">
                                                    {{ strtoupper($item->destination->name ?? $item->state->name ?? 'KASHMIR') }}
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Bottom Action Row: Pill Button + Circular Heart Button --}}
                                        <div class="kaw-pkg-action-row">
                                            <a href="{{ route('tour.details', $item->slug) }}" class="kaw-pkg-action-btn">
                                                <span>View Details</span>
                                            </a>
                                            <a href="https://api.whatsapp.com/send?phone=917006338617&text={{ urlencode('Hi LoveLink, I would like to inquire about: ' . $item->title) }}" 
                                               target="_blank" 
                                               class="kaw-pkg-heart-btn kaw-pkg-wa-btn" title="Chat on WhatsApp" target="_blank"><i class="fa-brands fa-whatsapp"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
    
                </div>
            @endforeach
        </div>
    </div>
</section>

<script>
/**
 * ============================================================
 * TOUR GALLERY SLIDER & ARROWS JAVASCRIPT
 * Ensures flawless swiper control and smooth navigation
 * ============================================================
 */

(function () {
    'use strict';

    function initTourGallerySlider() {
        const sliderEl = document.querySelector('#tourGallerySlider');
        const prevBtn = document.querySelector('.tour-gallery-prev, [data-slider-prev="#tourGallerySlider"]');
        const nextBtn = document.querySelector('.tour-gallery-next, [data-slider-next="#tourGallerySlider"]');

        if (!sliderEl) return;

        // Function to bind arrow buttons to Swiper instance
        function bindArrows(swiperInstance) {
            if (!swiperInstance) return;

            if (prevBtn) {
                prevBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    swiperInstance.slidePrev();
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    swiperInstance.slideNext();
                });
            }
        }

        // 1. If Swiper is already initialized on the element by theme script
        if (sliderEl.swiper) {
            const sw = sliderEl.swiper;
            if (sw.params) {
                if (!sw.params.breakpoints) sw.params.breakpoints = {};
                sw.params.breakpoints[0] = { slidesPerView: 2, spaceBetween: 12 };
                if (window.innerWidth < 576) {
                    sw.params.slidesPerView = 2;
                    sw.params.spaceBetween = 12;
                    sw.update();
                }
            }
            bindArrows(sw);
            return;
        }

        // 2. If Swiper is available globally, initialize with 2 on mobile
        if (typeof Swiper !== 'undefined') {
            let userOptions = {};
            const rawOptions = sliderEl.getAttribute('data-slider-options');
            if (rawOptions) {
                try {
                    userOptions = JSON.parse(rawOptions);
                } catch (err) {
                    console.warn('Could not parse data-slider-options, using defaults.', err);
                }
            }

            const swiperConfig = Object.assign(
                {
                    slidesPerView: 2,
                    spaceBetween: 12,
                    loop: true,
                    grabCursor: true,
                    speed: 600,
                    autoplay: {
                        delay: 4500,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    },
                    navigation: {
                        nextEl: '.tour-gallery-next',
                        prevEl: '.tour-gallery-prev',
                    },
                    breakpoints: {
                        0: { slidesPerView: 2, spaceBetween: 12 },
                        576: { slidesPerView: 2, spaceBetween: 16 },
                        768: { slidesPerView: 3, spaceBetween: 20 },
                        992: { slidesPerView: 4, spaceBetween: 20 },
                        1200: { slidesPerView: 4, spaceBetween: 24 },
                    },
                },
                userOptions
            );

            // Ensure 0 breakpoint always sets 2 for mobile view
            if (swiperConfig.breakpoints && swiperConfig.breakpoints[0]) {
                swiperConfig.breakpoints[0].slidesPerView = 2;
            }

            const gallerySwiper = new Swiper(sliderEl, swiperConfig);
            bindArrows(gallerySwiper);
        } else {
            // 3. Fallback: Wait for theme script to mount Swiper, then apply 2 mobile override
            let attempts = 0;
            const checkInterval = setInterval(function () {
                attempts++;
                if (sliderEl.swiper) {
                    clearInterval(checkInterval);
                    const sw = sliderEl.swiper;
                    if (sw.params) {
                        if (!sw.params.breakpoints) sw.params.breakpoints = {};
                        sw.params.breakpoints[0] = { slidesPerView: 2, spaceBetween: 12 };
                        if (window.innerWidth < 576) {
                            sw.params.slidesPerView = 2;
                            sw.params.spaceBetween = 12;
                            sw.update();
                        }
                    }
                    bindArrows(sw);
                } if (attempts > 30) {
                    clearInterval(checkInterval);
                }
            }, 100);
        }
    }

    // Initialize on DOMContentLoaded and also window load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTourGallerySlider);
    } else {
        initTourGallerySlider();
    }
    window.addEventListener('load', initTourGallerySlider);
})();
</script>
@endsection
