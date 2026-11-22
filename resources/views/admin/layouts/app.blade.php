@php
    $setting = \App\Models\Setting::find(1);
@endphp 
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> @yield('web_page_title') | @if($setting->name != null || !empty($setting->name)) {{ $setting->name }} @endif  </title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="{{ $setting->name ?? 'Love Link' }}" name="author" />
    <!-- Favicon -->
    
        <link rel="shortcut icon" type="image/x-icon" href="{{ url('/') }}/assets/images/favicon.ico">
    
 
    <!-- Bootstrap Css -->
    <link href="{{ url('/') }}/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ url('/') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ url('/') }}/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <script src="{{ url('/') }}/assets/js/plugin.js"></script>
    @yield('page_css') 
    </head>

    <body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            
        @include('admin.layouts.header')
        @include('admin.layouts.sidebar')
        

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                    @yield('content')

            <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © {{ $setting->name ?? 'Love Link' }}.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    All rights reserved.
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <?php /*<!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title d-flex align-items-center px-3 py-4">
            
                    <h5 class="m-0 me-2">Settings</h5>

                    <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>

                <!-- Settings -->
                <hr class="mt-0" />
                <h6 class="text-center mb-0">Choose Layouts</h6>

                <div class="p-4">
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-1.jpg" class="img-thumbnail" alt="layout images">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                        <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                    </div>
    
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-2.jpg" class="img-thumbnail" alt="layout images">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch">
                        <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                    </div>
    
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-3.jpg" class="img-thumbnail" alt="layout images">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch">
                        <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                    </div>

                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-4.jpg" class="img-thumbnail" alt="layout images">
                    </div>
                    <div class="form-check form-switch mb-5">
                        <input class="form-check-input theme-choice" type="checkbox" id="dark-rtl-mode-switch">
                        <label class="form-check-label" for="dark-rtl-mode-switch">Dark RTL Mode</label>
                    </div>

            
                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->*/ ?>

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="{{ url('/') }}/assets/libs/jquery/jquery.min.js"></script>
        <script src="{{ url('/') }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="{{ url('/') }}/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="{{ url('/') }}/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="{{ url('/') }}/assets/libs/node-waves/waves.min.js"></script>

        <!-- apexcharts -->
        <script src="{{ url('/') }}/assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- dashboard init -->
        <script src="{{ url('/') }}/assets/js/pages/dashboard.init.js"></script>

        <!-- form repeater js -->
        <script src="{{ url('/') }}/assets/libs/jquery.repeater/jquery.repeater.min.js"></script>

        <script src="{{ url('/') }}/assets/js/pages/form-repeater.int.js"></script>
        <!-- App js -->
        <script src="{{ url('/') }}/assets/js/app.js"></script>
        <!-- jQuery --> 
 
        @yield('web_page_script')

        <script>
            $('#change-password').on('submit',function(event){
                event.preventDefault(); 
                var current_password = $('#current-password').val();
                var password = $('#password').val();
                var password_confirm = $('#password-confirm').val();
                $('#current_passwordError').text('');
                $('#passwordError').text('');
                $('#password_confirmError').text('');
                $.ajax({
                    url: "{{ url('update-password') }}",
                    type:"POST",
                    data:{
                        "current_password": current_password,
                        "password": password,
                        "password_confirmation": password_confirm,
                        "_token": "{{ csrf_token() }}",
                    },
                    success:function(response){
                        console.log(response);
                        $('#current_passwordError').text('');
                        $('#passwordError').text('');
                        $('#password_confirmError').text('');
                        if(response.isSuccess == false){ 
                            $('#current_passwordError').text(response.Message);
                        }else if(response.isSuccess == true){
                            alert('Password Changed Successfully');
                            setTimeout(function () {   
                                window.location.href = "{{ url('/') }}"; 
                            }, 1000);
                        }
                    },
                    error: function(response) {
                        console.log(response);
                        $('#current_passwordError').text(response.responseJSON.errors.current_password);
                        $('#passwordError').text(response.responseJSON.errors.password);
                        $('#password_confirmError').text(response.responseJSON.errors.password_confirmation);
                    }
                });
            });
        </script>
            
    </body>

</html>