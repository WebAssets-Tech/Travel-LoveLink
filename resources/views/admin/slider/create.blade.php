@extends('admin.layouts.app')
@section('web_page_title', 'Create Slider') 
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
                                            <li class="breadcrumb-item"><a href="{{ route('slider.index') }}">Slider</a></li>
                                            <li class="breadcrumb-item active">Create New</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <form id="createproject-form" autocomplete="off"   enctype="multipart/form-data" class="repeater"    novalidate  action="{{ route('slider.store') }}" method="POST">
                        @csrf
                            <div class="row">
                                <div class="col-lg-8">
                                @include('admin.layouts.message')
                                    <div class="card">
                                        <div class="card-body">   
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Title</label>
                                                
                                                <input id="title" name="title" type="text" class="form-control" placeholder="Enter Name..." required> 
                                            </div>
                                             
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Sub Title </label>
                                                
                                                <input id="subtitle " name="subtitle" type="text" class="form-control" placeholder="Enter subtitle ..." required> 
                                            </div>
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Image </label>
                                                
                                                <input id="image" name="image" type="file" accept="image/*" class="form-control" required> 
                                            </div> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Spiti Is Colder</label> 
                                                        <select class="form-control"  name="spiti_is_colder"> 
                                                                <option value="yes">Yes</option> 
                                                                <option value="no">No</option>
                                                              
                                                        </select> 
                                                    </div> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Domestic Trip</label> 
                                                        <select class="form-control"  name="domestic_trip"> 
                                                                <option value="yes">Yes</option> 
                                                                <option value="no">No</option>
                                                        </select> 
                                                    </div> 

                                                    <div class="mb-3">
                                                        <label class="form-label">Contact US</label> 
                                                        <select class="form-control"  name="contact_us"> 
                                                                <option value="yes">Yes</option> 
                                                                <option value="no">No</option>
                                                              
                                                        </select> 
                                                    </div> 
                                                    
                                                    
                                            <div class="row"> 
                                                    <div class="buttons">  
                                                        <div data-repeater-list="buttons" class="items">
                                                        @php
                                                        $buttons = json_encode(old('buttons'), true) ?? [];
                                                        $buttons = json_decode($buttons) ?? []; 
                                                        @endphp
                                                        @if(!empty($buttons))
                                                            @foreach($buttons as $index => $item)
                                                                <div data-repeater-item class="row"> 
                                                                    <div class="mb-3 col-lg-3">
                                                                        <label for="projectname-input" class="form-label">Button Text</label> 
                                                                        <input name="items[0][buttons_title]" type="text" class="form-control" placeholder="Enter Button Text..."  value="{{ $item->buttons_title ?? '' }}" >  
                                                                    </div>  
                                                                    <div class="mb-3 col-lg-3">
                                                                        <label for="projectname-input" class="form-label">Button Link</label> 
                                                                        <input name="items[0][buttons_link]" type="text" class="form-control" placeholder="Enter Button Link..."  value="{{ $item->buttons_link  ?? '' }}" >  
                                                                    </div>
                                                                    
                                                                    <div class="col-lg-3 align-self-center">
                                                                        <div class="d-grid">
                                                                            <input data-repeater-delete type="button" class="btn btn-primary" value="Delete"/>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <div data-repeater-item class="row"> 
                                                                <div class="mb-3 col-lg-3">
                                                                    <label for="projectname-input" class="form-label">Button Text</label> 
                                                                    <input name="items[0][buttons_title]" type="text" class="form-control" placeholder="Enter Button Text..."  >  
                                                                </div>  
                                                                <div class="mb-3 col-lg-3">
                                                                    <label for="projectname-input" class="form-label">Button Link</label> 
                                                                    <input name="items[0][buttons_link]" type="text" class="form-control" placeholder="Enter Button Link..."  >  
                                                                </div>
                                                                
                                                                <div class="col-lg-3 align-self-center">
                                                                    <div class="d-grid">
                                                                        <input data-repeater-delete type="button" class="btn btn-primary" value="Delete"/>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                            @endif
                                                            
                                                                    
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-lg-3 align-self-center">
                                                        <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0" value="Add"/><br><br>
                                                    </div> 
                                                </div> 
                                          
                                        </div>
                                        <!-- end card body -->
                                         
                                    </div>
                                    <!-- end card -->
                                    
                                </div>
                                <!-- end col --> 

                                <div class="col-lg-8">
                                    <div class="text-end mb-4">
                                        <button type="submit" class="btn btn-primary">Create Slider</button>
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

<!-- form repeater js -->
<script src="{{ url('assets/libs/jquery.repeater/jquery.repeater.min.js') }}"></script>
<script src="{{ url('assets/js/pages/form-repeater.int.js') }}"></script> 
@endsection