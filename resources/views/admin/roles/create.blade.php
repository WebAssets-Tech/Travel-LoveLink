@extends('admin.layouts.app')
@section('web_page_title', 'Create Role')
@section('content') 


            <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Create New</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Permissions</a></li>
                                            <li class="breadcrumb-item active">Create New</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <form id="createproject-form" autocomplete="off" class="needs-validation" novalidate action="{{ route('roles.store') }}" method="POST">
                        @csrf
                            <div class="row">
                                <div class="col-lg-8">

                                @include('admin.layouts.message')
                                    <div class="card">
                                        <div class="card-body">  
                                        <input type="hidden" name="guard_name" value="web">
                                        <input type="hidden" class="form-control" id="formAction" name="formAction" value="add">
                                            <input type="hidden" class="form-control" id="project-id-input">
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Name</label>
                                                
                                                <input id="projectname-input" name="name" type="text" class="form-control" placeholder="Enter Role name..."  value="{{ old('name') }}">
                                                <div class="invalid-feedback">Please enter a Role name.</div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-md-2 col-form-label">Permissions</label> 
                                                    <select class="select2"  name="permissions[]" multiple id="mySelect2">
                                                            @forelse ($permissions as $permission)
                                                                <option value="{{ $permission->id }}" {{ in_array($permission->id, old('permissions') ?? []) ? 'selected' : '' }}>
                                                                    {{ $permission->name }}
                                                                </option>
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
                                        <button type="submit" class="btn btn-primary">Create Role</button>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </form>

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
           


@endsection