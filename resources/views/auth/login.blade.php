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
                                <h4 class="mb-3"><i class="bx bxs-quote-alt-left text-primary h1 align-middle me-3"></i><span class="text-primary">5k</span>+ Satisfied clients</h4>
                                <div dir="ltr">
                                    <div class="owl-carousel owl-theme auth-review-carousel" id="auth-review-carousel">
                                        <div class="item">
                                            <div class="py-3">
                                                <p class="font-size-16 mb-4">" Fantastic theme with a ton of options. "</p>
                                                <div>
                                                    <h4 class="font-size-16 text-primary">Abs1981</h4>
                                                    <p class="font-size-14 mb-0">- Skote User</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <div class="py-3">
                                                <p class="font-size-16 mb-4">" Great support and documentation. "</p>
                                                <div>
                                                    <h4 class="font-size-16 text-primary">nezerious</h4>
                                                    <p class="font-size-14 mb-0">- Skote User</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end carousel -->
                            </div>
                        </div>
                    </div>
                </div> <!-- end mt-auto -->
            </div>
        </div>
    </div>
</div>
<!-- end col -->

<div class="col-xl-3">
    <div class="auth-full-page-content p-md-5 p-4">
        <div class="w-100">
            <div class="d-flex flex-column h-100">
                <div class="mb-4 mb-md-5 text-center">
                    <a href="{{ url('/') }}" class="d-block card-logo">
                        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="22" class="card-logo-dark">
                        <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="22" class="card-logo-light">
                    </a>
                </div>

                <div class="my-auto">
                    <div>
                        <h5 class="text-primary">Welcome Back !</h5>
                        <p class="text-muted">Sign in to continue to {{ config('app.name', 'Love Link') }} Admin.</p>
                    </div>

                    <div class="mt-4">
                            <form method="POST" action="{{ route('login.submit') }}" enctype="multipart/form-data">

                            @csrf

                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" placeholder="Enter email" name="email" 
                                       value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="float-end">
                                    <a href="#" class="text-muted">Forgot password?</a>
                                </div>
                                <label class="form-label">Password</label>
                                <div class="input-group auth-pass-inputgroup">
                                    <input id="password" type="password" class="form-control" placeholder="Enter password"
                                           name="password" required autocomplete="current-password">
                                    <button class="btn btn-light" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>

                            <div class="mt-3 d-grid">
                                <button class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
                            </div>
                        </form>

                        <div class="mt-5 text-center">
                            <p>Don't have an account? <a href="#" class="fw-medium text-primary"> Signup now </a></p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 mt-md-5 text-center">
                    <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> {{ config('app.name', 'Love Link') }}. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end col -->
@endsection
