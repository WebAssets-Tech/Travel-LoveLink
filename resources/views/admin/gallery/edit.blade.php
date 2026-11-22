@extends('admin.layouts.app')
@section('web_page_title', 'Edit gallery') 
@section('content')
                <div class="page-content">
                    <div class="container-fluid"> 
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Edit gallery</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('gallery.index') }}">Gallery</a></li>
                                            <li class="breadcrumb-item active">Edit gallery</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <form id="createproject-form" autocomplete="off"   enctype="multipart/form-data" class="repeater"   novalidate  action="{{ route('gallery.update', $gallery->id ) }}" method="POST">
                        @csrf
                        @method('PUT')
                            <div class="row">
                                <div class="col-lg-8">
                                @include('admin.layouts.message')
                                    <div class="card">
                                        <div class="card-body">   
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Title</label> 
                                                <input id="title" name="title" type="text" class="form-control" placeholder="Enter Title..." required value="{{ old('title', $gallery->title) }}"> 
                                            </div> 
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Order By </label> 
                                                <input id="order " name="order" type="text" class="form-control" placeholder="Enter order ..." required value="{{ old('order', $gallery->order) }}"> 
                                            </div>
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Link </label> 
                                                <input id="video_link" name="video_link" type="text" class="form-control" placeholder="Enter video link ..." required value="{{ old('video_link', $gallery->video_link) }}""> 
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Current Image</label><br>
                                                <img src="{{ asset('storage/' . $gallery->file) }}" alt="Image" width="80">
                                            </div> 
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Image </label> 
                                                <input id="image" name="image" type="file" accept="image/*" class="form-control" required> 
                                            </div>  
                                            <div class="mb-3">
                                                <label class="form-label">Type</label> 
                                                <select class="form-control"  name="type"> 
                                                    <option value="image"  @if(old('type', $gallery->type)  ==  "image" ) selected @endif >Image</option> 
                                                    <option value="video"  @if(old('type', $gallery->type)  ==  "video" ) selected @endif >Video</option>
                                                </select> 
                                            </div>    
                                            <div class="mb-3">
                                                <label class="form-label">Status</label> 
                                                <select class="form-control"  name="status"> 
                                                    <option value="1"  @if(old('status', $gallery->status)  ==  1 ) selected @endif >Active</option> 
                                                    <option value="0"  @if(old('status', $gallery->status)  ==  0 ) selected @endif >InActive</option>
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
                                        <button type="submit" class="btn btn-primary">Update Gallery</button>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </form>

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
 


@endsection
 