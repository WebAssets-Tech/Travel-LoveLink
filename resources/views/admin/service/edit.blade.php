@extends('admin.layouts.app')
@section('web_page_title', 'Edit Service') 
@section('content')

<div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Edit Service</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('service.index') }}">Service</a></li>
                                            <li class="breadcrumb-item active">Edit Service</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <form id="createproject-form" autocomplete="off"   enctype="multipart/form-data" class="outer-repeater"    novalidate  action="{{ route('service.update', $service->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                            <div class="row">
                                <div class="col-lg-8">
                                @include('admin.layouts.message')
                                    <div class="card">
                                        <div class="card-body">  
                                            <div class="row">    
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Name</label> 
                                                        <input id="title" name="title" type="text" class="form-control" placeholder="Enter Name..." required value="{{ old('title', $service->title) }}"> 
                                                    </div> 
                                                </div>   
                                                <div class="col-sm-4">  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Price </label> 
                                                        <input id="price" name="price" type="number" class="form-control" placeholder="Enter Price ..." required  value="{{ old('price', $service->price) }}"> 
                                                    </div> 
                                                </div>   
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label> 
                                                        <select class="form-control"  name="status"> 
                                                                <option value="1"  @if(old('status', $service->service)  ==  1 ) selected @endif >Active</option> 
                                                                <option value="0"  @if(old('status', $service->service)  ==  0 ) selected @endif >InActive</option>
                                                        </select> 
                                                    </div>   
                                                </div>     
                                            </div>
                                             
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control editor" name="description" placeholder=" description">{{  old('description', $service->description) }}</textarea>  
                                            </div>    
                                            <div class="row" id="highlightWrapper">
                                                 
                                            </div> 
                                            
                                            <div class="col-sm-12"> 
                                                    <button type="button" class="btn btn-success mt-2" id="addHighlight">Add New</button>
                                                </div>  
                                                
                                            <div class="row">    
                                                <div class="col-sm-3">  
                                                    <div class="mb-3">
                                                        <label class="form-label">Current Image</label><br>
                                                        <img src="{{ asset('storage/' . $service->image) }}" alt="Image" width="80">
                                                    </div> 
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Image </label> 
                                                        <input id="image" name="image" type="file" accept="image/*" class="form-control" required> 
                                                    </div>   
                                                </div>   
                                                <div class="col-sm-3"> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Current BG Image</label><br>
                                                        <img src="{{ asset('storage/' . $service->page_bg_image) }}" alt="Page BG Image" width="80">
                                                    </div> 
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Page BG Image </label> 
                                                        <input id="page_bg_image" name="page_bg_image" type="file" accept="image/*" class="form-control" required> 
                                                    </div>   
                                                </div>   
                                                <div class="col-sm-3">
                                                    <div class="mb-3">
                                                        <label class="form-label">Current Banner Image</label><br>
                                                        <img src="{{ asset('storage/' . $service->banner_image) }}" alt="Banner Image" width="80">
                                                    </div>  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Banner Image </label> 
                                                        <input id="banner_image" name="banner_image" type="file" accept="image/*" class="form-control" required> 
                                                    </div>   
                                                </div>   
                                                <div class="col-sm-3"> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Current Banner Footer Image</label><br>
                                                        <img src="{{ asset('storage/' . $service->banner_footer_image) }}" alt="Banner Footer Image" width="80">
                                                    </div> 
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Banner Footer Image </label> 
                                                        <input id="banner_footer_image" name="banner_footer_image" type="file" accept="image/*" class="form-control" required> 
                                                    </div>  
                                                </div> 
                                                
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="additional_images" class="form-label">Additional Images</label>
                                                        <input id="additional_images" name="additional_images[]" type="file" accept="image/*" class="form-control" multiple>
                                                    </div>
                                                </div>
                                                @if(!empty($service->gallery))
                                                    <div class="mb-3">
                                                        <label class="form-label">Existing Images</label>
                                                        <div class="row">
                                                            @foreach(json_decode($service->gallery) as $image)
                                                                <div class="col-md-2">
                                                                    <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail" width="100">
                                                                    <input type="checkbox" name="delete_images[]" value="{{ $image }}"> Delete
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                        
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
                                                        
                                                        <input id="meta_title" name="meta_title" type="text" class="form-control" placeholder="Enter meta title..." value="{{  old('meta_title', $service->meta_title) }}" > 
                                                    </div>  
                                                </div>  
                                                <div class="col-sm-6"> 
                                                    <div class="mb-3">
                                                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                                        
                                                        <input id="meta_keywords" name="meta_keywords" type="text" class="form-control" placeholder="Enter meta keywords  (comma separated)..." value="{{  old('meta_keywords', $service->meta_keywords) }}" > 
                                                    </div>  
                                                </div>  
                                            </div>   
                                            <div class="mb-3">
                                                <label for="meta_description" class="form-label">Meta Description</label>
                                                <textarea class="form-control" name="meta_description"   rows="6" placeholder="">{{  old('meta_description', $service->meta_description) }}</textarea>  
                                            </div>   
                                             
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                    
                                </div>
                                <!-- end col --> 

                                <div class="col-lg-8">
                                    <div class="text-end mb-4">
                                        <button type="submit" class="btn btn-primary">Update Service</button>
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
 
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script> 
<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.editor').forEach(editorElement => {
        ClassicEditor.create(editorElement).catch(error => console.error(error));
    });
});

</script>
<script>
        $(document).ready(function () {
            function addHighlightField(value = '') {
                let highlightHTML = `
                
                <div class="col-sm-3"> 
                        <div class="mb-3">
                            <input type="text" class="form-control highlight-input" name="highlights[]" placeholder="Enter your highlight..." value="${value}">      
                        </div>
                    </div>  
                    <div class="col-sm-2"> 
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary removeHighlight">Delete</button>
                        </div>
                    </div>
                </div> 
                `;
                $("#highlightWrapper").append(highlightHTML);
            }
            

        // Load existing highlights (Edit Page)
        let existingHighlights = @json(old('highlights', $service->highlights ?? []));
        if (existingHighlights.length > 0) {
            existingHighlights.forEach(highlight => addHighlightField(highlight));
        } else {
            addHighlightField(); // Default 1 field if no data exists
        }
             

            // Add New Field on Click
            $("#addHighlight").click(function () {
                addHighlightField();
            });

            // Remove Field on Click
            $(document).on("click", ".removeHighlight", function () {
                $(this).closest(".highlight-container").remove();
            });
        });
    </script>
@endsection