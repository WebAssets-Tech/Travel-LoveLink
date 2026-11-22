@extends('admin.layouts.app')
@section('web_page_title', 'Edit Blog') 
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
                                    <h4 class="mb-sm-0 font-size-18">Edit Blog</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blogs</a></li>
                                            <li class="breadcrumb-item active">Edit Blog</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <form id="createproject-form" autocomplete="off"   enctype="multipart/form-data" class="outer-repeater"    novalidate  action="{{ route('blog.update',$blog->id) }}" method="POST">
                        @csrf
                        @method("PUT")
                            <div class="row">
                                <div class="col-lg-8">
                                @include('admin.layouts.message')
                                    <div class="card">
                                        <div class="card-body">  
                                            <div class="row">    
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Title</label> 
                                                        <input id="title" name="title" type="text" class="form-control" placeholder="Enter title..." required value="{{ old('title',$blog->title) }}"> 
                                                    </div> 
                                                </div>   
                                                <div class="col-sm-4">  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Category </label> 
                                                        <input id="category" name="category" type="text" class="form-control" placeholder="Enter category ..." required  value="{{ old('category',$blog->category) }}"> 
                                                    </div> 
                                                </div>     
                                                <div class="col-sm-4">  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Author </label> 
                                                        <input id="author" name="author" type="text" class="form-control" placeholder="Enter author ..." required  value="{{ old('author',$blog->author) }}"> 
                                                    </div> 
                                                </div>  
                                                <div class="col-sm-8">  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Tags </label> 
                                                        <input id="tags"  data-role="tagsinput" name="tags" type="text" class="form-control" placeholder="Enter tags ..." required  value="{{ old('tags',$blog->tags) }}"> 
                                                    </div> 
                                                </div>  
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label> 
                                                        <select class="form-control"  name="status"> 
                                                                <option value="1"  @if(old('status',$blog->status)  ==  1 ) selected @endif >Active</option> 
                                                                <option value="0"  @if(old('status',$blog->status)  ==  0 ) selected @endif >InActive</option>
                                                        </select> 
                                                    </div>   
                                                </div>     
                                                <div class="col-sm-12">  
                                                    <div class="mb-3">
                                                        <label for="youtube_link" class="form-label">YouTube Video Link (Optional)</label> 
                                                        <input id="youtube_link" name="youtube_link" type="text" class="form-control" placeholder="https://www.youtube.com/watch?v=... or https://youtu.be/..." value="{{ old('youtube_link', $blog->youtube_link) }}"> 
                                                    </div> 
                                                </div>     
                                            </div>
                                             
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control editor" name="content" placeholder=" description">{{  old('content',$blog->content) }}</textarea>  
                                            </div>    
                                            <div class="row">    
                                                <div class="col-sm-3"> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Current Image</label><br>
                                                        <img src="{{ asset('storage/' . $blog->image) }}" alt="Page BG Image" width="80">
                                                    </div> 
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Image </label> 
                                                        <input id="image" name="image" type="file" accept="image/*" class="form-control" required> 
                                                    </div>   
                                                </div>   
                                                <div class="col-sm-3"> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Current BG Image</label><br>
                                                        <img src="{{ asset('storage/' . $blog->page_bg_image) }}" alt="Page BG Image" width="80">
                                                    </div> 
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Page BG Image </label> 
                                                        <input id="page_bg_image" name="page_bg_image" type="file" accept="image/*" class="form-control" required> 
                                                    </div>   
                                                </div>   
                                                <div class="col-sm-3">
                                                    <div class="mb-3">
                                                        <label class="form-label">Current Banner Image</label><br>
                                                        <img src="{{ asset('storage/' . $blog->banner_image) }}" alt="Page BG Image" width="80">
                                                    </div>  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Banner Image </label> 
                                                        <input id="banner_image" name="banner_image" type="file" accept="image/*" class="form-control" required> 
                                                    </div>   
                                                </div>  
                                            </div>    
                                        </div>
                                        <!-- end card body -->
                                         
                                    </div>
                                    <!-- end card -->

                                    
                                
                                    <div class="card">
                                        <div class="card-body">  
                                        <h4 class="card-title">Seo Details</h4>
                                            <div class="row">
                                                <div class="col-sm-6"> 
                                                    <div class="mb-3">
                                                        <label for="meta_title" class="form-label">Meta Title</label>
                                                        
                                                        <input id="meta_title" name="meta_title" type="text" class="form-control" placeholder="Enter meta title..." value="{{  old('meta_title',$blog->meta_title) }}" > 
                                                    </div>  
                                                </div>  
                                                <div class="col-sm-6"> 
                                                    <div class="mb-3">
                                                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                                        
                                                        <input id="meta_keywords" name="meta_keywords" type="text" class="form-control" placeholder="Enter meta keywords  (comma separated)..." value="{{  old('meta_keywords',$blog->meta_keywords) }}" > 
                                                    </div>  
                                                </div>  
                                            </div>   
                                            <div class="mb-3">
                                                <label for="meta_description" class="form-label">Meta Description</label>
                                                <textarea class="form-control" name="meta_description"   rows="6" placeholder="">{{  old('meta_description',$blog->meta_description) }}</textarea>  
                                            </div>   
                                             
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                    
                                </div>
                                <!-- end col --> 

                                <div class="col-lg-8">
                                    <div class="text-end mb-4">
                                        <button type="submit" class="btn btn-primary">Update Blog</button>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script> 
<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.editor').forEach(editorElement => {
        ClassicEditor.create(editorElement).catch(error => console.error(error));
    });
     
});
$(document).ready(function () {
    $('#tagInput').tagsinput({
        trimValue: true,
        confirmKeys: [13, 44] // Enter (13) and Comma (44) to add tags
    });
});

</script> 
@endsection