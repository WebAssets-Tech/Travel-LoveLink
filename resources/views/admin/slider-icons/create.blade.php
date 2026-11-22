@extends('admin.layouts.app')
@section('web_page_title', 'Create Slider Icon') 

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
                    <h4 class="mb-sm-0 font-size-18">Create New Slider Icon</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('slidericon.index') }}">Slider Icons</a></li>
                            <li class="breadcrumb-item active">Create New</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <form id="create-slidericon-form" autocomplete="off" enctype="multipart/form-data" 
              action="{{ route('slidericon.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    @include('admin.layouts.message')
                    <div class="card">
                        <div class="card-body">  
                            <div class="row">    
                                <!-- Title -->
                                <div class="col-sm-6"> 
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label> 
                                        <input id="title" name="title" type="text" class="form-control" 
                                               placeholder="Enter title" required value="{{ old('title') }}"> 
                                    </div> 
                                </div>  
                                <!-- link -->
                                <div class="col-sm-6"> 
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Link</label> 
                                        <input id="link" name="link" type="text" class="form-control" 
                                               placeholder="Enter link" required value="{{ old('link') }}"> 
                                    </div> 
                                </div>   

                                <!-- Status -->
                                <div class="col-sm-6"> 
                                    <div class="mb-3">
                                        <label class="form-label">Status</label> 
                                        <select class="form-control" name="status"> 
                                            <option value="1" @if(old('status') == 1) selected @endif>Active</option> 
                                            <option value="0" @if(old('status') == 0) selected @endif>Inactive</option>
                                        </select> 
                                    </div>   
                                </div>     

                                <!-- Image Upload -->
                                <div class="col-sm-12">  
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image</label> 
                                        <input id="image" name="image" type="file" class="form-control" required> 
                                    </div> 
                                </div>     

                                <!-- Description -->
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" name="description" placeholder="Enter Description">{{ old('description') }}</textarea>  
                                    </div>
                                </div>

                            </div> <!-- end row -->
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col --> 

                <div class="col-lg-8">
                    <div class="text-end mb-4">
                        <button type="submit" class="btn btn-primary">Create Slider Icon</button>
                    </div>
                </div>
            </div>
        </form>

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
@endsection

@section('web_page_script')
@endsection
