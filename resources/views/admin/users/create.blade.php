@extends('admin.layouts.app')
@section('web_page_title', 'Create User')

@section('content')

            <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Create New User</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
                                            <li class="breadcrumb-item active">Create New</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <form id="createuser-form" autocomplete="off" class="needs-validation" novalidate action="{{ route('users.store') }}" method="POST">
                        @csrf
                            <div class="row">
                                <div class="col-lg-8">

                                @include('admin.layouts.message')
                                    <div class="card">
                                        <div class="card-body">   
                                            <div class="mb-3">
                                                <label for="user-name" class="form-label">Name</label>
                                                
                                                <input id="user-name" name="name" type="text" class="form-control" placeholder="Enter name..." value="{{ old('name') }}" required>
                                                <div class="invalid-feedback">Please enter a name.</div>
                                            </div> 
                                            <div class="mb-3">
                                                <label for="user-email" class="form-label">E-Mail</label>
                                                
                                                <input id="user-email" name="email" type="email" class="form-control" placeholder="Enter email..." value="{{ old('email') }}" required>
                                                <div class="invalid-feedback">Please enter an email address.</div>
                                            </div>  
                                            <div class="mb-3">
                                                <label for="user-phone" class="form-label">Phone</label>
                                                
                                                <input id="user-phone" name="phone" type="tel" class="form-control" placeholder="Enter phone..." value="{{ old('phone') }}">
                                                <div class="invalid-feedback">Please enter a phone number.</div>
                                            </div>  
                                            <div class="mb-3">
                                                <label for="user-password" class="form-label">Password</label>
                                                
                                                <input id="user-password" name="password" type="password" class="form-control" placeholder="Enter password..." required>
                                                <div class="invalid-feedback">Please enter a password.</div>
                                            </div>  
                                            <div class="mb-3">
                                                <label for="user-password-confirmation" class="form-label">Confirm Password</label>
                                                
                                                <input id="user-password-confirmation" name="password_confirmation" type="password" class="form-control" placeholder="Enter Confirm Password..." required>
                                                <div class="invalid-feedback">Please confirm the password.</div>
                                            </div> 
                                            <div class="mb-3 row">
                                                <label class="col-md-2 col-form-label">Roles</label> 
                                                    <select class="select2 form-control" name="roles[]" id="mySelect2" multiple>
                                                            @forelse ($roles as $role)

                                                                @if ($role!='Super Admin')
                                                                    <option value="{{ $role }}" {{ in_array($role, old('roles') ?? []) ? 'selected' : '' }}>
                                                                    {{ $role }}
                                                                    </option>
                                                                @else
                                                                    @if (Auth::user()->hasRole('Super Admin'))   
                                                                        <option value="{{ $role }}" {{ in_array($role, old('roles') ?? []) ? 'selected' : '' }}>
                                                                        {{ $role }}
                                                                        </option>
                                                                    @endif
                                                                @endif
                            
                                                            @empty
                            
                                                            @endforelse
                                                    </select>
                                                 
                                            </div> 
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                    <!-- end card -->
                                    
                                </div> 
                                <!-- end col -->

                                <div class="col-lg-8">
                                    <div class="text-end mb-4">
                                        <button type="submit" class="btn btn-primary">Create User</button>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </form>

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

@endsection

@section('web_page_script')
<script src="{{ url('/') }}/assets/libs/select2/js/select2.min.js"></script>
<script>
    $(".select2").select2();
</script>
@endsection
