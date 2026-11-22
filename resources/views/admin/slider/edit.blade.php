@extends('admin.layouts.app')

@section('web_page_title', 'Edit Slider') 

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- Start Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Edit Slider</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('slider.index') }}">Slider</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Title -->

        <form id="edit-slider-form" autocomplete="off" enctype="multipart/form-data" class="repeater" novalidate  
            action="{{ route('slider.update', $slider->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-8">
                    @include('admin.layouts.message')
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input id="title" name="title" type="text" class="form-control" 
                                    placeholder="Enter Name..." required value="{{ old('title', $slider->title) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Sub Title</label>
                                <input id="subtitle" name="subtitle" type="text" class="form-control" 
                                    placeholder="Enter subtitle ..." value="{{ old('subtitle', $slider->subtitle) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input id="image" name="image" type="file" accept="image/*" class="form-control">
                                @if($slider->image)
                                    <img src="{{ asset('storage/' . $slider->image) }}" alt="Slider Image" width="100" class="mt-2">
                                @endif
                            </div>

                             <div class="mb-3">
                                                        <label class="form-label">Spiti Is Colder</label> 
                                                        <select class="form-control"  name="spiti_is_colder"> 
                                                                <option value="yes" @if(old('spiti_is_colder',$slider->spiti_is_colder)  ==  'yes' ) selected @endif >Yes</option> 
                                                                <option value="no" @if(old('spiti_is_colder',$slider->spiti_is_colder)  ==  'no' ) selected @endif >No</option>
                                                              
                                                        </select> 
                                                    </div>  

                                              
                                                <div class="mb-3">
                                                         <label class="form-label">Domestic Trip</label> 
                                                        <select class="form-control"  name="domestic_trip"> 
                                                                <option value="yes" @if(old('domestic_trip',$slider->domestic_trip)  ==  'yes' ) selected @endif >Yes</option> 
                                                                <option value="no" @if(old('domestic_trip',$slider->domestic_trip)  ==  'no' ) selected @endif >No</option>
                                                              
                                                        </select> 
                                                    </div>  
                                                    
                                                 <div class="mb-3">
                                                           <label class="form-label">Contact US</label> 
                                                        <select class="form-control"  name="contact_us">
                                                                <option value="yes" @if(old('contact_us',$slider->contact_us)  ==  'yes' ) selected @endif >Yes</option> 
                                                                <option value="no" @if(old('contact_us',$slider->contact_us)  ==  'no' ) selected @endif >No</option>
                                                              
                                                        </select> 
                                                    </div>  



                            <!-- Buttons Section -->
                            <div class="row">
                                <div class="buttons">
                                    <div data-repeater-list="buttons" class="items">
                                        @php
                                            $buttons = json_encode(old('buttons',$slider->buttons), true) ?? [];
                                            $buttons = json_decode($buttons) ?? []; 
                                        @endphp
                                        @if(!empty($buttons))
                                            @foreach($buttons as $index => $item)
                                                <div data-repeater-item class="row">
                                                    <div class="mb-3 col-lg-3">
                                                        <label class="form-label">Button Text</label>
                                                        <input name="items[{{ $index }}][buttons_title]" type="text" 
                                                            class="form-control" placeholder="Enter Button Text..."  
                                                            value="{{ $item->buttons_title ?? '' }}">  
                                                    </div>  
                                                    <div class="mb-3 col-lg-3">
                                                        <label class="form-label">Button Link</label>
                                                        <input name="items[{{ $index }}][buttons_link]" type="text" 
                                                            class="form-control" placeholder="Enter Button Link..."  
                                                            value="{{ $item->buttons_link  ?? '' }}">  
                                                    </div>

                                                    <div class="col-lg-3 align-self-center">
                                                        <div class="d-grid">
                                                            <input data-repeater-delete type="button" class="btn btn-danger" value="Delete"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div data-repeater-item class="row"> 
                                                <div class="mb-3 col-lg-3">
                                                    <label class="form-label">Button Text</label>
                                                    <input name="items[0][buttons_title]" type="text" class="form-control" 
                                                        placeholder="Enter Button Text...">  
                                                </div>  
                                                <div class="mb-3 col-lg-3">
                                                    <label class="form-label">Button Link</label>
                                                    <input name="items[0][buttons_link]" type="text" class="form-control" 
                                                        placeholder="Enter Button Link...">  
                                                </div>
                                                <div class="col-lg-3 align-self-center">
                                                    <div class="d-grid">
                                                        <input data-repeater-delete type="button" class="btn btn-danger" value="Delete"/>
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
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-lg-8">
                    <div class="text-end mb-4">
                        <button type="submit" class="btn btn-primary">Update Slider</button>
                    </div>
                </div>
            </div>
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
