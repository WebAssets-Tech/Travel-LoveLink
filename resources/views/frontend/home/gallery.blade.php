@extends('frontend.layouts.app')
@section('page_title', 'Photo Gallery')
@section('page_meta')  
{!! generateMetaTagsSimple('Photo Gallery', $setting) !!} 
@endsection 

@section('content')
<!--==============================
    Breadcrumb Header
============================== -->
<section class="kz-gallery-hero-sec py-5 text-center position-relative overflow-hidden" style="background: #f8fafc; border-bottom: 1px solid #eef2f6;">
    <div class="container position-relative" style="z-index: 2;">
        <span class="kz-about-eyebrow">CAPTURED MOMENTS</span>
        <h1 class="kz-about-sec-title mt-2 mb-2">Our Kashmir & Travel Gallery</h1>
        <p class="text-muted small mx-auto mb-0" style="max-width: 580px;">Glimpses of pristine snow valleys, shikara cruises, luxury stays, and unforgettable guest smiles across our destinations.</p>
    </div>
</section>

<!--==============================
    Photo Gallery Area
==============================-->
<section class="kz-gallery-sec py-5 position-relative overflow-hidden" id="gallery-sec" style="background: #ffffff;">
    <div class="container position-relative" style="z-index: 2;">
        
        <!-- Filter Tabs -->
        @if(isset($titles) && $titles->isNotEmpty())
        <div class="kz-gallery-filter-wrap mb-4 d-flex justify-content-center">
            <div class="kz-filter-pill-group">
                <button data-filter="*" class="kz-gallery-filter-btn active" type="button">
                    <span>All Photos</span>
                    <span class="kz-filter-count">{{ $galleries->total() ?? $galleries->count() }}</span>
                </button>
                @foreach ($titles as $item)
                <button data-filter=".cat-{{ Str::slug($item->title) }}" class="kz-gallery-filter-btn" type="button">
                    <span>{{ $item->title }}</span>
                    <span class="kz-filter-count">{{ $item->count }}</span>
                </button>
                @endforeach 
            </div>
        </div>
        @endif

        <!-- Responsive Modern 4-Column Photo Grid -->
        <div class="kz-photo-grid" id="kzPhotoGrid">
            @foreach($galleries as $gallary)
            <div class="kz-photo-card-wrap cat-{{ Str::slug($gallary->title) }}">
                <div class="kz-photo-card">
                    <div class="kz-photo-media">
                        <img src="{{ asset('storage/' . $gallary->file) }}" alt="{{ $gallary->title ?? 'Gallery Photo' }}" loading="lazy">
                        <div class="kz-photo-overlay"></div>
                        <a href="{{ asset('storage/' . $gallary->file) }}" class="kz-photo-zoom-btn popup-image" title="{{ $gallary->title ?? 'View Photo' }}">
                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                        </a>
                        @if(!empty($gallary->title))
                        <div class="kz-photo-caption">
                            <span>{{ $gallary->title }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach 
        </div>

        @if(method_exists($galleries, 'links'))
        <div class="mt-4 pt-3 d-flex justify-content-center">
            {{ $galleries->links() }}
        </div>
        @endif

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.kz-gallery-filter-btn');
    const cards = document.querySelectorAll('.kz-photo-card-wrap');

    filterBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.getAttribute('data-filter');
            cards.forEach(function(card) {
                if (filter === '*' || card.matches(filter)) {
                    card.style.display = 'block';
                    if (typeof gsap !== 'undefined') {
                        gsap.fromTo(card, { opacity: 0, scale: 0.95 }, { opacity: 1, scale: 1, duration: 0.35, ease: 'power2.out' });
                    }
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
</script>

@endsection
