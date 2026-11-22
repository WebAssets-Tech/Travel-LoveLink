@extends('admin.layouts.app')
@section('web_page_title', 'Create Activity') 
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
                                            <li class="breadcrumb-item"><a href="{{ route('activity.index') }}">Activity</a></li>
                                            <li class="breadcrumb-item active">Create New</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <form id="createproject-form" autocomplete="off"   enctype="multipart/form-data" class="outer-repeater"    novalidate  action="{{ route('activity.store') }}" method="POST">
                        @csrf
                            <div class="row">
                                <div class="col-lg-8">
                                @include('admin.layouts.message')
                                    <div class="card">
                                        <div class="card-body">  
                                            <div class="row">    
                                                <div class="col-sm-6"> 
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Title</label> 
                                                        <input id="title" name="title" type="text" class="form-control" placeholder="Enter title..." required value="{{ old('title') }}"> 
                                                    </div> 
                                                </div>   
                                                <div class="col-sm-6">  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Days </label> 
                                                        <input id="days" name="days" type="text" class="form-control" placeholder="Enter days ..." required  value="{{ old('days') }}"> 
                                                    </div> 
                                                </div>   
                                                <div class="col-sm-4">  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Price </label> 
                                                        <input id="price" name="price" type="number" class="form-control" placeholder="Enter price ..." required  value="{{ old('price') }}"> 
                                                    </div> 
                                                </div>   
                                                <div class="col-sm-4">  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Rating </label> 
                                                        <input id="rating" name="rating" type="text" class="form-control" placeholder="Enter rating ..." required  value="{{ old('rating') }}"> 
                                                    </div> 
                                                </div>   
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label> 
                                                        <select class="form-control"  name="status"> 
                                                                <option value="1"  @if(old('status')  ==  1 ) selected @endif >Active</option> 
                                                                <option value="0"  @if(old('status')  ==  0 ) selected @endif >InActive</option>
                                                        </select> 
                                                    </div>   
                                                </div>     
                                            </div>
                                             
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control editor" name="description" placeholder=" description">{{  old('description') }}</textarea>  
                                            </div>    
                                            <div class="mb-3">
                                                <label for="map_link" class="form-label">Map Link</label>
                                                <textarea class="form-control" name="map_link" placeholder=" map link">{{  old('map_link') }}</textarea>  
                                            </div>    
                                            <div class="row" id="highlightWrapper"> 
                                            </div> 
                                            
                                            <div class="col-sm-12"> 
                                                <button type="button" class="btn btn-success " id="addHighlight">Add New Highlights</button>
                                            </div>  
                                            <br>

                                            <div class="row" id="important_infoWrapper"> 
                                            </div>  
                                            <div class="col-sm-12"> 
                                                <button type="button" class="btn btn-success" id="addimportant_info">Add New Importent Info</button>
                                            </div>

                                            
                                            <div class="row">    
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Image </label> 
                                                        <input id="image" name="image" type="file" accept="image/*" class="form-control" required> 
                                                    </div>   
                                                </div>   
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Page BG Image </label> 
                                                        <input id="page_bg_image" name="page_bg_image" type="file" accept="image/*" class="form-control" required> 
                                                    </div>   
                                                </div>   
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Banner Image </label> 
                                                        <input id="banner_image" name="banner_image" type="file" accept="image/*" class="form-control" required> 
                                                    </div>   
                                                </div>  
                                                
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="additional_images" class="form-label">Additional Images</label>
                                                        <input id="additional_images" name="additional_images[]" type="file" accept="image/*" class="form-control" multiple>
                                                    </div>
                                                </div>  
                                            </div> 
                                            
                                            <div class="row"> 
                                                    <div class="include_exclude">  
                                                        <div data-repeater-list="include_exclude" class="items">
                                                        @php
                                                        $include_exclude = json_encode(old('include_exclude'), true) ?? [];
                                                        $include_exclude = json_decode($include_exclude) ?? []; 
                                                        @endphp
                                                        @if(!empty($include_exclude))
                                                            @foreach($include_exclude as $index => $item)
                                                                <div data-repeater-item class="row">
                                                                    <div class="mb-3 col-lg-3">
                                                                        <label for="projectdesc-input" class="form-label">Type</label> 
                                                                        <select class="form-select" name="items[0][type]"> 
                                                                                <option value="0"  @if($item->type == 0 ) selected @endif >Exclude</option>
                                                                                <option value="1"  @if($item->type  == 1 ) selected @endif >Include</option>
                                                                        </select> 
                                                                    </div>  
                                                                    <div class="mb-3 col-lg-3">
                                                                        <label for="projectname-input" class="form-label">Title</label> 
                                                                        <input name="items[0][title]" type="text" class="form-control" placeholder="Enter Title..."  value="{{ $item->title ?? '' }}" >  
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
                                                                        <label for="projectdesc-input" class="form-label">Type</label> 
                                                                        <select class="form-select" name="items[0][type]"> 
                                                                                <option value="0">Exclude</option>
                                                                                <option value="1">Include</option>
                                                                        </select> 
                                                                    </div>  
                                                                    <div class="mb-3 col-lg-3">
                                                                        <label for="projectname-input" class="form-label">Title</label> 
                                                                        <input name="items[0][title]" type="text" class="form-control" placeholder="Enter Title..."  >  
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

                                    
                                
                                    <div class="card">
                                        <div class="card-body">  
                                        <h4 class="card-title">Seo Details</h4>
                                            <div class="row">
                                                <div class="col-sm-6"> 
                                                    <div class="mb-3">
                                                        <label for="meta_title" class="form-label">Meta Title</label>
                                                        
                                                        <input id="meta_title" name="meta_title" type="text" class="form-control" placeholder="Enter meta title..." value="{{  old('meta_title') }}" > 
                                                    </div>  
                                                </div>  
                                                <div class="col-sm-6"> 
                                                    <div class="mb-3">
                                                        <label for="meta_keywords" class="form-label">Meta Keywords</label> 
                                                        <input id="meta_keywords" name="meta_keywords" type="text" class="form-control" placeholder="Enter meta keywords  (comma separated)..." value="{{  old('meta_keywords') }}" > 
                                                    </div>  
                                                </div>  
                                            </div>   
                                            <div class="mb-3">
                                                <label for="meta_description" class="form-label">Meta Description</label>
                                                <textarea class="form-control" name="meta_description"   rows="6" placeholder="">{{  old('meta_description') }}</textarea>  
                                            </div>   
                                             
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                    
                                </div>
                                <!-- end col --> 

                                <div class="col-lg-8">
                                    <div class="text-end mb-4">
                                        <button type="submit" class="btn btn-primary">Create Activity</button>
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
<script src="{{ url('/') }}/assets/libs/jquery.repeater/jquery.repeater.min.js"></script>
<script src="{{ url('/') }}/assets/js/pages/form-repeater.int.js"></script> 
 
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
        let existingHighlights = @json(old('highlights', $destination->highlights ?? []));
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
                                <input type="text" class="form-control " name="important_info[]" placeholder="Enter your important info..." value="${value}">      
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
        let existingimportant_info = @json(old('important_info', $activity->important_info ?? []));
        if (existingimportant_info.length > 0) {
            existingimportant_info.forEach(important_info => addImporttentInfoField(important_info));
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
@endsection