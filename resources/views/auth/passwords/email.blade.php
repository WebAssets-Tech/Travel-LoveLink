@extends('admin.layouts.loginapp')

@section('content')          

<div class="col-xl-9">
    <div class="auth-full-bg pt-lg-5 p-4">
        <div class="w-100">
            <div class="bg-overlay"></div>
            <div class="d-flex h-100 flex-column">

                <div class="p-4 mt-auto">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="text-center">
                                
                                <h4 class="mb-3"><i class="bx bxs-quote-alt-left text-primary h1 align-middle me-3"></i><span class="text-primary">WebAssets</span> - Futuristic Technology</h4>
                                
                                <div dir="ltr">
                                    <div class="owl-carousel owl-theme auth-review-carousel" id="auth-review-carousel">
                                        <div class="item">
                                            <div class="py-3">
                                                <p class="font-size-16 mb-4">" Empowering digital transformation with high-performance web architecture, robust digital marketing, and cutting-edge web technologies. "</p>

                                                <div>
                                                    <h4 class="font-size-16 text-primary">WebAssets Technology</h4>
                                                    <p class="font-size-14 mb-0">- Innovating Futuristic Technology</p>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="item">
                                            <div class="py-3">
                                                <p class="font-size-16 mb-4">" Enterprise-grade stability, seamless management tools, and modern application scalability built for growth. "</p>

                                                <div>
                                                    <h4 class="font-size-16 text-primary">WebAssets Solutions</h4>
                                                    <p class="font-size-14 mb-0">- Digital Solutions Partner</p>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end col -->

<div class="col-xl-3">
    <div class="auth-full-page-content p-md-5 p-4">
        <div class="w-100">

            <div class="d-flex flex-column h-100">
                <div class="mb-4 mb-md-5">
                    <a href="{{ url('/') }}" class="d-block auth-logo">
                        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="22" class="auth-logo-dark">
                        <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="22" class="auth-logo-light">
                    </a>
                </div>
                <div class="my-auto">
                    
                    <div>
                        <h5 class="text-primary"> {{ __('Reset Password') }}</h5>
                        <p class="text-muted">{{ __('Reset Password') }} with WebAssets Admin.</p>
                    </div>

                    <div class="mt-4">
                            @if (session('status'))
                            <div class="alert alert-success text-center mb-4" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="alert alert-success text-center mb-4" role="alert">
                            Enter your Email and instructions will be sent to you!
                        </div>
                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="useremail" class="form-label">{{ __('Email Address') }}</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="useremail" placeholder="Enter email">
                            </div>
        
                            @error('email')
                            <div class="alert alert-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </div> 
                            @enderror
                            <div class="text-end">
                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">{{ __('Send Password Reset Link') }}</button>
                            </div>

                        </form>
                        <div class="mt-5 text-center">
                            <p>Remember It ? <a href="{{ route('login') }}" class="fw-medium text-primary"> Sign In here</a> </p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 mt-md-5 text-center">
                    <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> WebAssets. All rights reserved.</p>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- end col -->
@endsection
