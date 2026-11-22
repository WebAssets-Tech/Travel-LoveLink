@extends('admin.layouts.app')
@section('web_page_title', 'Edit Youtube Slider') 

@section('page_css')
<style>
    .bootstrap-tagsinput {
        width: 100% !important;
        display: block;
        min-height: 40px;
        padding: 6px 12px;
        line-height: 22px;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }
    .bootstrap-tagsinput .tag {
        margin-right: 5px;
        color: white;
        background: #007bff;
        padding: 5px 10px;
        border-radius: 3px;
        display: inline-block;
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Edit Youtube Slider</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('youtube.index') }}">Youtube Slider</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <form id="edit-youtube-form" autocomplete="off" enctype="multipart/form-data" class="outer-repeater" novalidate  
              action="{{ route('youtube.update', $youtube->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-8">
                    @include('admin.layouts.message')
                    <div class="card">
                        <div class="card-body">  
                            <div class="row">    
                                <div class="col-sm-6"> 
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label> 
                                        <input id="title" name="title" type="text" class="form-control" 
                                               placeholder="Enter title" required value="{{ old('title', $youtube->title) }}"> 
                                    </div> 
                                </div>   

                                <div class="col-sm-6"> 
                                    <div class="mb-3">
                                        <label class="form-label">Status</label> 
                                        <select class="form-control" name="status"> 
                                            <option value="1" {{ old('status', $youtube->status) == 1 ? 'selected' : '' }}>Active</option> 
                                            <option value="0" {{ old('status', $youtube->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select> 
                                    </div>   
                                </div>     

                                <div class="col-sm-12">  
                                    <div class="mb-3">
                                        <label for="youtube_link" class="form-label">Youtube Link</label> 
                                        <input id="youtube_link" name="youtube_link" type="text" class="form-control" 
                                               placeholder="Enter Youtube Link" required value="{{ old('youtube_link', $youtube->youtube_link) }}"> 
                                    </div> 
                                </div>     
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" placeholder="Enter Description">{{ old('description', $youtube->description) }}</textarea>  
                            </div>    
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col --> 

                <div class="col-lg-8">
                    <div class="text-end mb-4">
                        <button type="submit" class="btn btn-primary">Update Youtube Slider</button>
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
@endsection
