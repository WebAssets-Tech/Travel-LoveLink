@extends('frontend.layouts.app')
@section('page_title', 'FAQs - ' . ($setting->name ?? 'Love Link Tour and Travels'))
@section('page_meta')
{!! generateMetaTagsSimple('FAQs', $setting) !!}
@endsection

@section('content')
@php
    $phoneNumber = $setting->phone ?? '+91 7006338617';
    $phoneClean  = preg_replace('/[^0-9]/', '', $phoneNumber) ?: '917006338617';
    $totalFaqs   = $faqs->count();
@endphp

<!--==============================
    Modern Theme Hero Header
==============================-->
<section class="kz-faq-page-hero">
    <div class="container position-relative" style="z-index: 2;">
        <div class="kz-faq-hero-inner text-center">
            <ul class="kz-about-hero-breadcrumb mb-3">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><i class="ti ti-chevron-right"></i></li>
                <li>FAQs</li>
            </ul>
            <span class="kz-faq-hero-eyebrow">Help Center &amp; Travel Guide</span>
            <h1 class="kz-faq-hero-title">Frequently Asked Questions</h1>
            <p class="kz-faq-hero-subtitle">
                Clear answers about bookings, customized Kashmir &amp; Ladakh itineraries, payments, safety, and 24/7 on-ground assistance.
            </p>

            {{-- Live Search Box --}}
            <div class="kz-faq-search-wrap mx-auto">
                <span class="kz-faq-search-ico"><i class="fas fa-search"></i></span>
                <input
                    type="search"
                    id="kzFaqSearchInput"
                    class="kz-faq-search-input"
                    placeholder="Search questions (e.g. booking, cancel, payment, Kashmir)..."
                    aria-label="Search frequently asked questions"
                    autocomplete="off">
                <button type="button" id="kzFaqSearchClear" class="kz-faq-search-clear d-none" aria-label="Clear search">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<!--==============================
    FAQs Knowledge Base & Inquiry Sidebar
==============================-->
<section class="kz-faq-page-section">
    <div class="container">
        <div class="row g-4 align-items-start">

            {{-- Left Column: Searchable Accordion List --}}
            <div class="col-lg-8 col-12">
                <div class="kz-faq-toolbar">
                    <div class="kz-faq-count-pill">
                        <i class="fas fa-list-ul"></i>
                        <span id="kzFaqMatchText">Showing {{ $totalFaqs }} {{ Str::plural('Question', $totalFaqs) }}</span>
                    </div>
                    @if($totalFaqs > 1)
                    <button type="button" id="kzFaqToggleAllBtn" class="kz-faq-toggle-all-btn" data-expanded="false">
                        <i class="fas fa-expand-alt"></i>
                        <span>Expand All</span>
                    </button>
                    @endif
                </div>

                <div class="kz-faq-page-list" id="faqPageAccordion">
                    @forelse($faqs as $faq)
                        <div class="kz-faq-page-card {{ $loop->first ? 'is-open' : '' }}"
                             data-faq-search="{{ strtolower(trim($faq->question . ' ' . strip_tags($faq->answer))) }}">
                            <div class="kz-faq-page-card-head" id="faq-heading-{{ $loop->index }}">
                                <button
                                    class="kz-faq-page-trigger {{ $loop->first ? '' : 'collapsed' }}"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faq-collapse-{{ $loop->index }}"
                                    aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                    aria-controls="faq-collapse-{{ $loop->index }}">
                                    <span class="kz-faq-page-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="kz-faq-page-q">{{ $faq->question }}</span>
                                    <span class="kz-faq-page-ico" aria-hidden="true">
                                        <i class="fas fa-chevron-down"></i>
                                    </span>
                                </button>
                            </div>
                            <div id="faq-collapse-{{ $loop->index }}"
                                 class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                 aria-labelledby="faq-heading-{{ $loop->index }}">
                                <div class="kz-faq-page-body">
                                    <p>{{ $faq->answer }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="kz-faq-empty-box">
                            <i class="fas fa-question-circle"></i>
                            <h4>No FAQs Available Yet</h4>
                            <p>Please check back shortly or reach out to our 24/7 travel concierge using the inquiry form.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Empty Search Result Box --}}
                <div id="kzFaqNoResults" class="kz-faq-empty-box d-none">
                    <i class="fas fa-search"></i>
                    <h4>No Matching Questions Found</h4>
                    <p>Try a different keyword or ask our travel experts directly on the right.</p>
                    <button type="button" id="kzFaqResetBtn" class="kz-faq-reset-btn">
                        <i class="fas fa-redo-alt me-1"></i> Show All Questions
                    </button>
                </div>
            </div>

            {{-- Right Column: Concierge Card + Working Inquiry Form --}}
            <div class="col-lg-4 col-12">
                <div class="kz-faq-sidebar">

                    {{-- Direct 24/7 Support Card (#1A2332 formal palette) --}}
                    <div class="kz-faq-concierge-box mb-4">
                        <div class="kz-faq-concierge-badge">
                            <i class="fas fa-headset"></i>
                            <span>24/7 Travel Concierge</span>
                        </div>
                        <h3 class="kz-faq-concierge-title">Still Have Questions?</h3>
                        <p class="kz-faq-concierge-text">
                            Speak directly with our verified Kashmir &amp; Ladakh specialists for instant guidance on dates, permits, hotels, or custom packages.
                        </p>
                        <div class="kz-faq-concierge-actions">
                            <a href="tel:{{ $phoneNumber }}" class="kz-faq-call-btn">
                                <i class="fas fa-phone-alt"></i>
                                <span>Call {{ $phoneNumber }}</span>
                            </a>
                            <a href="https://wa.me/{{ $phoneClean }}?text=Hello%20LoveLink%20Travels,%20I%20have%20a%20question%20about%20a%20tour%20package"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="kz-faq-wa-btn">
                                <i class="fab fa-whatsapp"></i>
                                <span>Chat on WhatsApp</span>
                            </a>
                        </div>
                    </div>

                    {{-- Ask Our Experts Form --}}
                    <div class="kz-faq-form-card">
                        <div class="kz-faq-form-head">
                            <span class="kz-faq-form-eyebrow">Quick Inquiry</span>
                            <h3 class="kz-faq-form-title">Ask Our Experts</h3>
                            <p class="kz-faq-form-subtitle">Send us your question and receive a tailored response shortly.</p>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success rounded-3 small mb-3">
                                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger rounded-3 small mb-3">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('home.contact.submit') }}" method="POST" class="kz-faq-inquiry-form">
                            @csrf
                            <div class="kz-faq-field">
                                <i class="fas fa-user kz-faq-field-ico"></i>
                                <input type="text" name="name" value="{{ old('name') }}" class="kz-faq-input" placeholder="Full Name" required>
                            </div>
                            <div class="kz-faq-field">
                                <i class="fas fa-phone-alt kz-faq-field-ico"></i>
                                <input type="tel" name="number" value="{{ old('number') }}" class="kz-faq-input" placeholder="Mobile Number" required>
                            </div>
                            <div class="kz-faq-field">
                                <i class="fas fa-envelope kz-faq-field-ico"></i>
                                <input type="email" name="email" value="{{ old('email') }}" class="kz-faq-input" placeholder="Email Address" required>
                            </div>
                            <div class="kz-faq-field">
                                <i class="fas fa-map-marked-alt kz-faq-field-ico"></i>
                                <select name="subject" class="kz-faq-select">
                                    <option value="" disabled {{ old('subject') ? '' : 'selected' }}>Select Inquiry Topic</option>
                                    <option value="Kashmir Honeymoon Package" {{ old('subject') == 'Kashmir Honeymoon Package' ? 'selected' : '' }}>Kashmir Honeymoon Package</option>
                                    <option value="Kashmir Family Tour" {{ old('subject') == 'Kashmir Family Tour' ? 'selected' : '' }}>Kashmir Family Tour</option>
                                    <option value="Ladakh Adventure Tour" {{ old('subject') == 'Ladakh Adventure Tour' ? 'selected' : '' }}>Ladakh Adventure Tour</option>
                                    <option value="Domestic / International Packages" {{ old('subject') == 'Domestic / International Packages' ? 'selected' : '' }}>Domestic &amp; International Tours</option>
                                    <option value="Booking, Payment or Cancellation" {{ old('subject') == 'Booking, Payment or Cancellation' ? 'selected' : '' }}>Booking, Payment or Cancellation</option>
                                    <option value="Custom Group Tour" {{ old('subject') == 'Custom Group Tour' ? 'selected' : '' }}>Custom Group Tour</option>
                                </select>
                            </div>
                            <div class="kz-faq-field">
                                <textarea name="message" rows="3" class="kz-faq-textarea" placeholder="Write your question, travel dates, or preferences..." required>{{ old('message') }}</textarea>
                            </div>
                            <button type="submit" class="kz-faq-submit-btn">
                                <span>Send Message</span>
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const accordion = document.getElementById('faqPageAccordion');
    const searchInput = document.getElementById('kzFaqSearchInput');
    const clearBtn = document.getElementById('kzFaqSearchClear');
    const resetBtn = document.getElementById('kzFaqResetBtn');
    const noResults = document.getElementById('kzFaqNoResults');
    const matchText = document.getElementById('kzFaqMatchText');
    const toggleAllBtn = document.getElementById('kzFaqToggleAllBtn');

    if (!accordion) return;

    const cards = Array.from(accordion.querySelectorAll('.kz-faq-page-card'));
    const totalCount = cards.length;

    function setCollapseState(collapseEl, open) {
        if (!collapseEl) return;
        const card = collapseEl.closest('.kz-faq-page-card');
        const trigger = card ? card.querySelector('.kz-faq-page-trigger') : null;

        if (typeof bootstrap !== 'undefined' && bootstrap.Collapse) {
            const instance = typeof bootstrap.Collapse.getOrCreateInstance === 'function'
                ? bootstrap.Collapse.getOrCreateInstance(collapseEl, { toggle: false })
                : (bootstrap.Collapse.getInstance(collapseEl) || new bootstrap.Collapse(collapseEl, { toggle: false }));
            if (open) instance.show();
            else instance.hide();
        } else {
            collapseEl.classList.toggle('show', open);
            if (trigger) {
                trigger.classList.toggle('collapsed', !open);
                trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
            }
            if (card) card.classList.toggle('is-open', open);
        }
    }

    // Sync open card visual state with Bootstrap collapse events
    cards.forEach(function (card) {
        const collapseEl = card.querySelector('.accordion-collapse');
        if (!collapseEl) return;

        collapseEl.addEventListener('show.bs.collapse', function () {
            card.classList.add('is-open');
        });
        collapseEl.addEventListener('shown.bs.collapse', function () {
            card.classList.add('is-open');
        });
        collapseEl.addEventListener('hide.bs.collapse', function () {
            card.classList.remove('is-open');
        });
        collapseEl.addEventListener('hidden.bs.collapse', function () {
            card.classList.remove('is-open');
        });
    });

    function applyFilter() {
        const query = (searchInput ? searchInput.value : '').trim().toLowerCase();
        if (clearBtn) {
            clearBtn.classList.toggle('d-none', query.length === 0);
        }

        let visible = 0;
        cards.forEach(function (card) {
            const hay = card.getAttribute('data-faq-search') || '';
            const matches = query === '' || hay.indexOf(query) !== -1;
            card.classList.toggle('d-none', !matches);
            if (matches) {
                visible++;
                if (query !== '') {
                    setCollapseState(card.querySelector('.accordion-collapse'), true);
                }
            }
        });

        if (matchText) {
            if (query === '') {
                matchText.textContent = 'Showing ' + totalCount + (totalCount === 1 ? ' Question' : ' Questions');
            } else {
                matchText.textContent = 'Showing ' + visible + ' of ' + totalCount + ' Questions';
            }
        }
        if (noResults) {
            noResults.classList.toggle('d-none', visible > 0 || totalCount === 0);
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', applyFilter);
    }

    function resetSearch() {
        if (searchInput) {
            searchInput.value = '';
            applyFilter();
            searchInput.focus();
        }
    }

    if (clearBtn) clearBtn.addEventListener('click', resetSearch);
    if (resetBtn) resetBtn.addEventListener('click', resetSearch);

    // Expand All / Collapse All toggle
    if (toggleAllBtn) {
        toggleAllBtn.addEventListener('click', function () {
            const shouldExpand = toggleAllBtn.getAttribute('data-expanded') !== 'true';
            cards.forEach(function (card) {
                if (card.classList.contains('d-none')) return;
                setCollapseState(card.querySelector('.accordion-collapse'), shouldExpand);
            });
            toggleAllBtn.setAttribute('data-expanded', shouldExpand ? 'true' : 'false');
            const label = toggleAllBtn.querySelector('span');
            const icon = toggleAllBtn.querySelector('i');
            if (label) label.textContent = shouldExpand ? 'Collapse All' : 'Expand All';
            if (icon) icon.className = shouldExpand ? 'fas fa-compress-alt' : 'fas fa-expand-alt';
        });
    }
});
</script>
@endsection
