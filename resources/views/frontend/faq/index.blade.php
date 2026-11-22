@extends('frontend.layouts.app')
@section('page_title', 'Faq')
@section('page_meta')  
{!! generateMetaTagsSimple('Faq',$setting) !!} 
@endsection 

@section('content')
<!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper " data-bg-src="{{ getImageByType(request()->segment(1),$setting) }}">
    <div class="container">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">FAQs</h1>
            <ul class="breadcumb-menu">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>FAQs</li>
            </ul>
        </div>
    </div>
</div>

<!--==============================
Faq Area
==============================-->
<div style="padding:20px 0" class="space-top space-extra-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7">
                <div class="title-area text-center">
                    <span class="sub-title">FAQ</span>
                    <h2 class="sec-title">frequently Ask Questions</h2>
                    <p>Have questions you want answers to?</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="accordion-area accordion mb-30" id="faqAccordion">
                    @foreach($faqs as $faq)
                    <div class="accordion-card style2 {{ $loop->first ? 'active' : '' }} ">
                        <div class="accordion-header" id="collapse-item-{{ $loop->index }}">
                            <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $loop->index }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse-{{ $loop->index }}">Q{{ $loop->iteration }}. {{ $faq->question }}</button>
                        </div>
                        <div id="collapse-{{ $loop->index }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }} " aria-labelledby="collapse-item-{{ $loop->index }}" data-bs-parent="#faqAccordion">
                            <div class="accordion-body style2">
                                <p class="faq-text">{{ $faq->answer }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>



<!--==============================
Contact Area  
==============================-->
<div class="bg-top-center space overflow-hidden" data-bg-src="{{ asset('webassets/img/bg/tour_bg_3.jpg')}}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div>
                    <div class="title-area text-center mb-30">
                        <span class="sub-title style1">Meet with Our Guide</span>
                        <h2 class="sec-title">Do You Have Any More Questions?</h2>
                    </div>
                    <form action="mail.php" method="POST" class="contact-form ajax-contact">
                        <h3 class="sec-title mb-30">Book a tour</h3>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" class="form-control" name="name" id="name3" placeholder="First Name">
                                <img src="{{ asset('webassets') }}/img/icon/user.svg" alt="">
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="email" class="form-control" name="email3" id="email3" placeholder="Your Mail">
                                <img src="{{ asset('webassets') }}/img/icon/mail.svg" alt="">
                            </div>
                            <div class="form-group col-12">
                                <select name="subject" id="subject" class="form-select nice-select">
                                    <option value="Select Tour Destination" selected disabled>Select Tour Destination</option>
                                    <option value="Kashmir">Kashmir</option>
                                    <option value="Kashmir Trekking">Kashmir Trekking</option>
                                    <option value="Ladakh">Ladakh</option>
                                    <option value="Shimla-Manali">Shimla-Manali</option>
                                    <option value="Golden Triangle">Golden Triangle</option>
                                    <option value="Goa">Goa</option>
                                    <option value="Darjelling">Darjelling</option>
                                    <option value="Kerala">Kerala</option>
                                    <option value="Vaishno Devi">Vaishno Devi</option>
                                    <option value="Amarnath Yatra">Amarnath Yatra</option>
                                    <option value="Mussoorie">Mussoorie</option>
                                    <option value="Ooty">Ooty</option>
                                </select>
                            </div>
                            <div class="form-group col-12">
                                <textarea name="message" id="message" cols="30" rows="3" class="form-control" placeholder="Your Message"></textarea>
                                <img src="{{ asset('webassets') }}/img/icon/chat.svg" alt="">
                            </div>
                            <div class="form-btn col-12 mt-24">
                                <button type="submit" class="th-btn style3">Send message <img src="{{ asset('webassets') }}/img/icon/plane.svg" alt=""></button>
                            </div>
                        </div>
                        <p class="form-messages mb-0 mt-3"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
