@extends('admin.layouts.app')
@section('web_page_title', 'Create Menu')
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
                                            <li class="breadcrumb-item"><a href="{{ route('menu.index') }}">Menu</a></li>
                                            <li class="breadcrumb-item active">Create New</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <form id="createproject-form" autocomplete="off" class="needs-validation" novalidate action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="row">
                                <div class="col-lg-8">

                                @include('admin.layouts.message')
                                    <div class="card">
                                        <div class="card-body">   
                                              
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Menu Name</label>
                                                
                                                <input id="projectname-input" name="title" type="text" class="form-control" placeholder="Enter Menu Name..."  value="{{ old('title') }}" >
                                                 
                                            </div>  
                                            <div class="mb-3 row">
                                                <label class="col-md-2 col-form-label">Parent Menu</label> 
                                                    <select class="form-control"  name="parent_id"> 
                                                        <option value="">Select</option>
                                                        @foreach ($menus as $menu)
                                                            <option value="{{ $menu->id }}"  @if(old('parent_id') == $menu->id) selected @endif >{{ $menu->title }}</option> 
                                                        @endforeach 
                                                    </select> 
                                            </div>        
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Order</label>
                                                
                                                <input id="projectname-input" name="order" type="number" class="form-control" placeholder="Enter order..."  value="{{ old('order') }}" >
                                            </div>  
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Link</label>
                                                
                                                <input id="projectname-input" name="link" type="text" class="form-control" placeholder="Enter link..."  value="{{ old('link') }}" >
                                            </div>  
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">type</label>
                                                <select name="type" id="type" class="form-control">
                                                    <option value="">Select Type</option>
                                                    <option value="0" @if(old('type') == 0) selected @endif >Header Menu</option>
                                                    <option value="1" @if(old('type') == 1) selected @endif >Fooetr Menu</option>
                                                    <option value="2" @if(old('type') == 2) selected @endif >TopBar Menu</option>
                                                </select> 
                                            </div>
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">type</label>
                                                <select name="status" id="status_menu" class="form-control">
                                                    <option value="">Select Status</option>
                                                    <option value="1"  @if(old('status') == 1) selected @endif >Active</option> 
                                                    <option value="0"  @if(old('status') == 0) selected @endif >InActive</option>
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
                                        <button type="submit" class="btn btn-primary">Create Menu</button>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </form>

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
 


@endsection
 