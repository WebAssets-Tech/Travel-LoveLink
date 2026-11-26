
<header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a target="blank" href="{{ route('home') }}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{ !empty($setting->header_logo) ? asset('storage/' . $setting->header_logo) : asset('assets/images/logo.png') }}" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ !empty($setting->header_logo) ? asset('storage/' . $setting->header_logo) : asset('assets/images/logo-dark.png') }}" alt="" height="24">
                                </span>
                            </a>

                            <a target="blank" href="{{ route('home') }}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{ !empty($setting->header_logo) ? asset('storage/' . $setting->header_logo) : asset('assets/images/logo.png') }}" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ !empty($setting->header_logo) ? asset('storage/' . $setting->header_logo) : asset('assets/images/logo-light.png') }}" alt="" height="24">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>

                         
                    </div>

                    <div class="d-flex">


                        

                        

                        <div class="dropdown d-none d-lg-inline-block ms-1">
                            <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                                <i class="bx bx-fullscreen"></i>
                            </button>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="{{ url('assets/images/users/user-dummy-img.jpg') }}"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ Auth::user()->name }}</span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="{{ route('users.edit', Auth::user()->id) }}"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a> 
                                    <a class="dropdown-item d-block" href="#" data-bs-toggle="modal" data-bs-target=".change-password"><i class="bx bx-wrench font-size-16 align-middle me-1"></i> Change Password</a>
                                <a class="dropdown-item" href="#"><i class="bx bx-lock-open font-size-16 align-middle me-1"></i> <span key="t-lock-screen">Lock screen</span></a>
                                
                                
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                            
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> 
                                    <span key="t-logout">Logout</span>
                                </a>
                                 
                            
                            @if(Auth::user()->hasRole('Super Admin')) 
                                <a class="dropdown-item text-warning" href="{{ route('user.migration') }}" onclick="event.preventDefault();
                                                     document.getElementById('user-migration-form').submit();">
                                    <i class="bx bx-spa font-size-16 align-middle me-1 text-warning"></i> 
                                    <span key="t-logout">Migrate</span>
                                </a>
                                <form id="user-migration-form" action="{{ route('user.migration') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                <a class="dropdown-item text-warning" href="{{ route('user.clearCache') }}" onclick="event.preventDefault();
                                                     document.getElementById('user-clearCache').submit();">
                                    <i class="bx bx-spa font-size-16 align-middle me-1 text-warning"></i> 
                                    <span key="t-logout">Clear Cache</span>
                                </a>
                                <form id="user-clearCache" action="{{ route('user.clearCache') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                               @endif 
                             
                            </div>
                        </div>
 

                    </div>
                </div>
            </header>

            
<!--  Change-Password example -->
<div class="modal fade change-password" tabindex="-1" role="dialog"
aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="change-password">
                    @csrf
                    <div class="mb-3">
                        <label for="current_password">Current Password <span class="text-danger">*</span></label>
                        <input id="current-password" type="password"
                            class="form-control @error('current_password') is-invalid @enderror"
                            name="current_password" autocomplete="current_password"
                            placeholder="Enter Current Password" value="{{ old('current_password') }}">
                        <div class="text-danger" id="current_passwordError" data-ajax-feedback="current_password"></div>
                    </div>

                    <div class="mb-3">
                        <label for="newpassword">New Password <span class="text-danger">*</span></label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password"
                            autocomplete="new_password" placeholder="Enter New Password">
                        <div class="text-danger" id="passwordError" data-ajax-feedback="password"></div>
                    </div>

                    <div class="mb-3">
                        <label for="userpassword">Confirm Password <span class="text-danger">*</span></label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            autocomplete="new_password" placeholder="Enter New Confirm password">
                        <div class="text-danger" id="password_confirmError" data-ajax-feedback="password-confirm"></div>
                    </div>

                    <div class="mt-3 d-grid">
                        <button class="btn btn-primary waves-effect waves-light UpdatePassword" 
                            type="submit">Update Password</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

