@extends('admin.layouts.app')
@section('web_page_title', 'Create Testimonial') 
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
                                            <li class="breadcrumb-item"><a href="{{ route('testimonial.index') }}">Testimonials</a></li>
                                            <li class="breadcrumb-item active">Create New</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <form id="createproject-form" autocomplete="off"   enctype="multipart/form-data" class="repeater"   novalidate  action="{{ route('testimonial.store') }}" method="POST">
                        @csrf
                            <div class="row">
                                <div class="col-lg-8">
                                @include('admin.layouts.message')
                                    <div class="card">
                                        <div class="card-body">   
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Name</label> 
                                                <input id="name" name="name" type="text" class="form-control" placeholder="Enter name..." required value="{{ old('name') }}"> 
                                            </div> 
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Designation </label> 
                                                <input id="designation " name="designation" type="text" class="form-control" placeholder="Enter designation ..." required value="{{ old('designation') }}" > 
                                            </div>
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Rating </label> 
                                                <input id="rating" name="rating" type="number" class="form-control" placeholder="Enter rating ..." required value="{{ old('rating') }}" "> 
                                            </div>
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Image </label> 
                                                <input id="image" name="image" type="file" accept="image/*" class="form-control" required> 
                                            </div>  
                                            <div class="mb-3">
                                                <label for="message" class="form-label">Message</label>
                                                <textarea class="form-control" name="message" rows="6" placeholder=" message">{{ old('message') }}</textarea>  
                                            </div>     
                                            <div class="mb-3">
                                                <label class="form-label">Status</label> 
                                                <select class="form-control"  name="status"> 
                                                    <option value="1"  @if(old('status')  ==  1 ) selected @endif >Active</option> 
                                                    <option value="0"  @if(old('status')  ==  0 ) selected @endif >InActive</option>
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
                                        <button type="submit" class="btn btn-primary">Create testimonial</button>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </form>

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
 


@endsection
 