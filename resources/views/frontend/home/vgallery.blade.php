@extends('frontend.layouts.app')
@section('page_title', 'Video Gallery')
@section('page_meta')  
{!! generateMetaTagsSimple('Video Gallery', $setting) !!} 
@endsection 

@section('content')
<!--==============================
    Breadcrumb Header
============================== -->
<section class="kz-vgallery-hero-sec py-5 text-center position-relative overflow-hidden" style="background: #f8fafc; border-bottom: 1px solid #eef2f6;">
    <div class="container position-relative" style="z-index: 2;">
        <span class="kz-about-eyebrow">CINEMATIC STORIES</span>
        <h1 class="kz-about-sec-title mt-2 mb-2">Our Travel Video Journals</h1>
        <p class="text-muted small mx-auto mb-0" style="max-width: 580px;">Experience the raw, breathtaking beauty of Kashmir, Ladakh, and luxury escapes through real guest video journeys.</p>
    </div>
</section>

<!--==============================
    Video Gallery Area
==============================-->
<section class="kz-vgallery-sec py-5 position-relative overflow-hidden" id="vgallery-sec" style="background: #ffffff;">
    <div class="container position-relative" style="z-index: 2;">

        @php
            $hasGalleries = isset($galleries) && $galleries->isNotEmpty();
            $hasCustomYt  = false;
            foreach ($youtube ?? [] as $checkY) {
                if (!empty($checkY->url)) { $hasCustomYt = true; break; }
            }

            // Fallback curated video stories featuring Love Link Tours
            $defaultVideos = [
                [
                    'title' => 'Kashmir Paradise on Earth - Exclusive Tour Experience',
                    'id'    => 'vOM2TjbJT9g',
                    'tag'   => 'Featured Expedition'
                ],
                [
                    'title' => 'Gulmarg Snow Valley & Gondola Ride Journey',
                    'id'    => 'vOM2TjbJT9g',
                    'tag'   => 'Winter Wonder'
                ],
                [
                    'title' => 'Dal Lake Luxury Shikara Cruise & Houseboat Heritage',
                    'id'    => 'vOM2TjbJT9g',
                    'tag'   => 'Heritage Stay'
                ]
            ];
        @endphp

        @if($hasGalleries)
            <!-- Gallery Model Videos -->
            <div class="row g-3">
                @foreach($galleries as $gallary)
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="kz-video-bento-card">
                        <div class="kz-video-bento-wrapper">
                            @php
                                $ytId = '';
                                $raw = $gallary->file ?? '';
                                if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $raw, $matches)) {
                                    $ytId = $matches[1];
                                } elseif (strlen($raw) == 11) {
                                    $ytId = $raw;
                                }
                            @endphp
                            @if($ytId)
                                <iframe src="https://www.youtube-nocookie.com/embed/{{ $ytId }}?rel=0&modestbranding=1" 
                                        title="{{ $gallary->title ?? 'Video Story' }}" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen
                                        loading="lazy">
                                </iframe>
                            @endif
                        </div>
                        @if(!empty($gallary->title))
                        <div class="kz-video-bento-info">
                            <span class="kz-video-bento-badge"><i class="fa-brands fa-youtube text-danger me-1"></i> Story</span>
                            <h5 class="kz-video-bento-title">{{ $gallary->title }}</h5>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach 
            </div>
        @else
            <!-- Curated Kashmir Video Journals -->
            <div class="row g-3">
                @foreach($defaultVideos as $vid)
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="kz-video-bento-card">
                        <div class="kz-video-bento-wrapper">
                            <iframe src="https://www.youtube-nocookie.com/embed/{{ $vid['id'] }}?rel=0&modestbranding=1" 
                                    title="{{ $vid['title'] }}" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen
                                    loading="lazy">
                            </iframe>
                        </div>
                        <div class="kz-video-bento-info">
                            <span class="kz-video-bento-badge"><i class="fa-brands fa-youtube text-danger me-1"></i> {{ $vid['tag'] }}</span>
                            <h5 class="kz-video-bento-title">{{ $vid['title'] }}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif

    </div>
</section>

@endsection
