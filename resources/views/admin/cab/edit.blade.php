@extends('admin.layouts.app')
@section('web_page_title', 'Edit Cab') 
@section('content')

<div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Edit Cab</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('cab.index') }}">Cabs</a></li>
                                            <li class="breadcrumb-item active">Edit Cab</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <form id="createproject-form" autocomplete="off"   enctype="multipart/form-data" class="outer-repeater"    novalidate  action="{{ route('cab.update', $cab->id) }}" method="POST">
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
                                                        <input id="name" name="name" type="text" class="form-control" placeholder="Enter Name..." required value="{{ old('name', $cab->name) }}"> 
                                                    </div> 
                                                </div>   
                                                <div class="col-sm-4">  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Price </label> 
                                                        <input id="price" name="price" type="number" class="form-control" placeholder="Enter price ..." required  value="{{ old('price', $cab->price) }}"> 
                                                    </div> 
                                                </div>    
                                                <div class="col-sm-4">  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Seating Capacity </label> 
                                                        <input id="seating_capacity" name="seating_capacity" type="number" class="form-control" placeholder="Enter Seating Capacity ..." required  value="{{ old('seating_capacity', $cab->seating_capacity) }}"> 
                                                    </div> 
                                                </div>   
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label> 
                                                        <select class="form-control"  name="status"> 
                                                                <option value="1"  @if(old('status', $cab->status)  ==  1 ) selected @endif >Active</option> 
                                                                <option value="0"  @if(old('status', $cab->status)  ==  0 ) selected @endif >InActive</option>
                                                        </select> 
                                                    </div>   
                                                </div>  
                                                <div class="col-sm-4"> 
    <div class="mb-3">
        <label for="order" class="form-label">Display Order</label> 
        <input id="order" name="order" type="number" class="form-control" placeholder="e.g. 1, 2, 3..." value="{{ old('order', $cab->order ?? 0) }}"> 
        <small class="text-muted">Display sequence (e.g. 1 shows first)</small>
    </div>   
</div>
                                                
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Type</label> 
                                                        <input type="text" name="cab_type" id="cab_type" class="form-control" value="{{old('cab_type',$cab->cab_type)}}">
                                                        
                                                    </div>   
                                                </div>
                                            </div>
                                            <div class="row" id="highlightWrapper"> 
                                            </div> 
                                            
                                            <div class="col-sm-12"> 
                                                <button type="button" class="btn btn-success " id="addHighlight">Add New Highlights</button>
                                            </div>  
                                            <br>  
                                              <div class="mb-3">
                                                <label for="description" class="form-label">Short Description</label>
                                                <textarea class="form-control"  id="short_description" minlength="50" maxlength="1000" name="short_description" rows="3" placeholder=" Please Enter Short Description">{{  old('short_description',$cab->short_description) }}</textarea>  
                                               <small id="charCount" class="form-text text-muted">0/1000 characters</small>

                                            </div>

                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control editor" name="description" placeholder=" description">{{  old('description', $cab->description) }}</textarea>  
                                            </div> 
                                            <div class="row">    
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Current  Image</label><br>
                                                        <img src="{{ asset('storage/' . $cab->image) }}" alt=" Image" width="80">
                                                    </div> 
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Image </label> 
                                                        <input id="image" name="image" type="file" accept="image/*" class="form-control" required> 
                                                    </div>   
                                                </div>   
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Current BG Image</label><br>
                                                        <img src="{{ asset('storage/' . $cab->page_bg_image) }}" alt=" Image" width="80">
                                                    </div> 
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Page BG Image </label> 
                                                        <input id="page_bg_image" name="page_bg_image" type="file" accept="image/*" class="form-control" required> 
                                                    </div>   
                                                </div>   
                                                <div class="col-sm-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Current Banner Image</label><br>
                                                        <img src="{{ asset('storage/' . $cab->banner_image) }}" alt=" Image" width="80">
                                                    </div>  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Banner Image </label> 
                                                        <input id="banner_image" name="banner_image" type="file" accept="image/*" class="form-control" required> 
                                                    </div>   
                                                </div>     
                                            </div>    
                                        </div>

                                          <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="footer_images" class="form-label">Footer Gallery Images</label>
                                                        <input id="footer_images" name="footer_images[]" type="file" accept="image/*" class="form-control" multiple>
                                                    </div>
                                                </div> 
                                         
                                         @if(!empty($cab->footer_gallery))
                                                    <div class="mb-3">
                                                        <label class="form-label">Existing Images</label>
                                                        <div class="row">
                                                            @foreach(json_decode($cab->footer_gallery) as $image)
                                                                <div class="col-md-2">
                                                                    <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail" width="100">
                                                                    <input type="checkbox" name="delete_images[]" value="{{ $image }}"> Delete
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                    </div>
                                
                                    <div class="card">
                                        <div class="card-body">  
                                        <h4 class="card-title">Seo Details</h4>
                                            <div class="row">
                                                <div class="col-sm-6"> 
                                                    <div class="mb-3">
                                                        <label for="meta_title" class="form-label">Meta Title</label>
                                                        
                                                        <input id="meta_title" name="meta_title" type="text" class="form-control" placeholder="Enter meta title..." value="{{  old('meta_title', $cab->meta_title) }}" > 
                                                    </div>  
                                                </div>  
                                                <div class="col-sm-6"> 
                                                    <div class="mb-3">
                                                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                                        
                                                        <input id="meta_keywords" name="meta_keywords" type="text" class="form-control" placeholder="Enter meta keywords  (comma separated)..." value="{{  old('meta_keywords', $cab->meta_keywords) }}" > 
                                                    </div>  
                                                </div>  
                                            </div>   
                                            <div class="mb-3">
                                                <label for="meta_description" class="form-label">Meta Description</label>
                                                <textarea class="form-control" name="meta_description"   rows="6" placeholder="">{{  old('meta_description', $cab->meta_description) }}</textarea>  
                                            </div>   
                                             
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                    
                                </div>
                                <!-- end col --> 

                                <div class="col-lg-8">
                                    <div class="text-end mb-4">
                                        <button type="submit" class="btn btn-primary">Update Cab</button>
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
                
                <div class="highlight-container">
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
                </div> 
                `;
                $("#highlightWrapper").append(highlightHTML);
            }
            

        // Load existing highlights (Edit Page)
        let existingHighlights = @json(old('highlights', $cab->highlights ?? []));
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
        
        function addImporttentInfoField(value = '') {
            let importentinfoHTML = `
            
                <div class="important_info-container">
                    <div class="col-sm-3"> 
                            <div class="mb-3">
                                <input type="text" class="form-control " name="basic[]" placeholder="Enter your Basic Details..." value="${value}">      
                            </div>
                        </div>  
                        <div class="col-sm-2"> 
                            <div class="mb-3">
                                <button type="button" class="btn btn-primary removeimportant_info">Delete</button>
                            </div>
                        </div>
                    </div> 
                </div> 
            `;
            $("#important_infoWrapper").append(importentinfoHTML);
        }
            

        // Load existing important_info (Edit Page)
        let existingimportant_info = @json(old('basic', $cab->basic ?? []));
        if (existingimportant_info.length > 0) {
            existingimportant_info.forEach(basic => addImporttentInfoField(basic));
        } else {
            addImporttentInfoField(); // Default 1 field if no data exists
        }
             

            // Add New Field on Click
            $("#addimportant_info").click(function () {
                addImporttentInfoField();
            });

            // Remove Field on Click
            $(document).on("click", ".removeimportant_info", function () {
                $(this).closest(".important_info-container").remove();
            });
        });
    </script>

 <script>
        document.addEventListener('DOMContentLoaded', function() {
            const description = document.getElementById('short_description');
            const charCount = document.getElementById('charCount');
            const maxLength = description.getAttribute('maxlength');

            function updateCharCount() {
                const currentLength = description.value.length;
                charCount.textContent = `${currentLength}/${maxLength} characters`;
            }

            description.addEventListener('input', updateCharCount);

            updateCharCount();
        });
    </script>
@endsection