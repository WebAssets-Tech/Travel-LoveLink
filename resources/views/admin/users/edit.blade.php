
@extends('admin.layouts.app')
@section('web_page_title', 'Edit User')
@section('page_css')
<!-- select2 Css -->
<link href="{{ url('/') }}/assets/libs/select2/css/select2.min.css"  rel="stylesheet" type="text/css" />
@endsection
@section('content')

 
            <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Edit User</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
                                            <li class="breadcrumb-item active">Edit User</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <form id="createproject-form" autocomplete="off" class="needs-validation" novalidate action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                    @method("PUT")
                            <div class="row">
                                <div class="col-lg-8">

                                @include('admin.layouts.message')
                                    <div class="card">
                                        <div class="card-body">   
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Name</label>
                                                
                                                <input id="projectname-name" name="name" type="text" class="form-control" placeholder="Enter name..."  value="{{ $user->name }}">
                                                <div class="invalid-feedback">Please enter a permissions name.</div>
                                            </div> 
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">E-Mail</label>
                                                
                                                <input id="projectname-email" name="email" type="email" class="form-control" placeholder="Enter email..."  value="{{ $user->email }}">
                                                <div class="invalid-feedback">Please enter an email.</div>
                                            </div>  
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Phone</label>
                                                
                                                <input id="projectname-email" name="phone" type="tel" class="form-control" placeholder="Enter Phone..."  value="{{ $user->phone }}">
                                                <div class="invalid-feedback">Please enter an phone.</div>
                                            </div>  
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Password</label>
                                                
                                                <input id="projectname-password" name="password" type="password" class="form-control" placeholder="Enter password..." >
                                                <div class="invalid-feedback">Please enter a password.</div>
                                            </div>  
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Confirm Password</label>
                                                
                                                <input id="projectname-password_confirmation" name="password_confirmation" type="password" class="form-control" placeholder="Enter Confirm Password..." >
                                                <div class="invalid-feedback">Please enter a password.</div>
                                            </div> 
                                            <div class="mb-3 row">
                                                <label class="col-md-2 col-form-label">Roles</label> 
                                                    <select class="form-select select2"  name="roles[]" id="mySelect2">
                                                    @forelse ($roles as $role)

                                                        @if ($role!='Super Admin')
                                                        <option value="{{ $role }}" {{ in_array($role, $userRoles ?? []) ? 'selected' : '' }}>
                                                            {{ $role }}
                                                        </option>
                                                        @else
                                                            @if (Auth::user()->hasRole('Super Admin'))   
                                                            <option value="{{ $role }}" {{ in_array($role, $userRoles ?? []) ? 'selected' : '' }}>
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
                                        <button type="submit" class="btn btn-primary">Update User</button>
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
    // Select2
    $(".select2").select2();
    </script>
@endsection