@extends('admin.layouts.app')
@section('web_page_title', 'Edit Tour') 
@section('page_css')
<!-- select2 Css -->
<link href="{{ url('/') }}/assets/libs/select2/css/select2.min.css"  rel="stylesheet" type="text/css" />  
@endsection
@section('content')

<div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Edit Tour</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('tour.index') }}">Tours</a></li>
                                            <li class="breadcrumb-item active">Edit Tour</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <form id="createproject-form" autocomplete="off"   enctype="multipart/form-data" class="outer-repeater"    novalidate  action="{{ route('tour.update',$tour->id) }}" method="POST">
                        @csrf
                        @method("PUT")
                            <div class="row">
                                <div class="col-lg-10">
                                @include('admin.layouts.message')
                                    <div class="card">
                                        <div class="card-body">  
                                            <div class="row">    
                                                <div class="col-sm-6"> 
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Title</label> 
                                                        <input id="title" name="title" type="text" class="form-control" placeholder="Enter title..." required value="{{ old('title',$tour->title) }}"> 
                                                    </div> 
                                                </div>   
                                                <div class="col-sm-6">  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Days </label> 
                                                        <input id="days" name="duration" type="text" class="form-control" placeholder="Enter days ..." required  value="{{ old('duration',$tour->duration) }}"> 
                                                    </div> 
                                                </div>   
                                                <div class="col-sm-4">  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Price </label> 
                                                        <input id="price" name="price" type="number" class="form-control" placeholder="Enter price ..." required  value="{{ old('price',$tour->price) }}"> 
                                                    </div> 
                                                </div>  
                                                <div class="col-sm-4">  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Discount Price </label> 
                                                        <input id="discount_price" name="discount_price" type="number" class="form-control" placeholder="Enter discount price ..." required  value="{{ old('discount_price',$tour->discount_price) }}"> 
                                                    </div> 
                                                </div>    
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label> 
                                                        <select class="form-control"  name="status"> 
                                                                <option value="1"  {{ $tour->status == '1' ? 'selected' : '' }} >Active</option> 
                                                                <option value="0" {{ $tour->status == '0' ? 'selected' : '' }} >InActive</option>
                                                        </select> 
                                                    </div>   
                                                </div>    
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Type</label> 
                                                        <select class="form-control"  name="type"> 
                                                                <option value="1" {{ $tour->type == '1' ? 'selected' : '' }} >Tours</option> 
                                                                <option value="0" {{ $tour->type == '0' ? 'selected' : '' }} >For FITS</option>
                                                                <option value="2"  {{ $tour->type == '2' ? 'selected' : '' }} >For GITS</option> 
                                                        </select> 
                                                    </div>   
                                                </div> 
                                                <div class="col-md-4">
                                                    <label class="form-label">State</label>
                                                    <select name="state_id" class="form-select @error('state_id') is-invalid @enderror">
                                                        <option value="">Select State</option>
                                                        @foreach($states as $state)
                                                            <option value="{{ $state->id }}" {{ old('state_id', $tour->state_id ?? '') == $state->id ? 'selected' : '' }}>
                                                                {{ $state->name }} ({{ $state->country->name ?? '-' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('state_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                                 <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Domestic Trip</label> 
                                                       <select class="form-control" name="domestic_trip">
                                                            <option value="yes" {{ $tour->domestic_trip == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ $tour->domestic_trip == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>

                                                    </div>   
                                                </div>  
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Package Rating (1.0 to 5.0)</label> 
                                                        <input type="number" step="0.1" min="1" max="5" name="rating" class="form-control" placeholder="e.g. 4.8" value="{{ old('rating', $tour->rating ?? '4.8') }}">
                                                    </div>   
                                                </div>     
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Activities</label> 
                                                            <select name="activity_ids[]" id="activities" multiple class="form-control select2">
                                                                @foreach($activities as $activity)
                                                                    <option value="{{ $activity->id }}" {{ in_array($activity->id, old('activity_ids', $selectedActivities ?? [])) ? 'selected' : '' }}>{{ $activity->title }}</option>
                                                                @endforeach
                                                            </select> 
                                                    </div>   
                                                </div>     
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Destinations</label> 
                                                            <select name="destination_ids[]" id="destinations" multiple class="form-control select2">
                                                                @foreach($destinations as $destination)
                                                                    <option value="{{ $destination->id }}" {{ in_array($destination->id,  old('destination_ids', $selectedDestinations ?? [])) ? 'selected' : '' }} >{{ $destination->name }}</option>
                                                                @endforeach
                                                            </select>
                                                    </div>   
                                                </div>     
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Categories</label> 
                                                            <select name="category_ids[]" id="categories" multiple class="form-control select2">
                                                                @foreach($tourcategories as $category)
                                                                    <option value="{{ $category->id }}" {{ in_array($category->id,  old('category_ids', $selectedCategories ?? [])) ? 'selected' : '' }}>{{ $category->name }}</option>
                                                                @endforeach
                                                            </select>
                                                    </div>   
                                                </div>     
                                            </div>
                                            
                                             <div class="mb-3">
                                                <label for="description" class="form-label">Short Description</label>
                                                <textarea class="form-control"  id="short_description" minlength="50" maxlength="1000" name="short_description" rows="3" placeholder=" Please Enter Short Description">{{  old('short_description',$tour->short_description) }}</textarea>  
                                               <small id="charCount" class="form-text text-muted">0/1000 characters</small>

                                            </div>

                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control editor" name="description" placeholder=" description">{{  old('description',$tour->description) }}</textarea>  
                                            </div>  
                                            
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Booking</label>
                                                <textarea class="form-control editor" name="booking" placeholder=" booking">{{  old('booking',$tour->booking) }}</textarea>  
                                            </div>   
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Cancellation</label>
                                                <textarea class="form-control editor" name="cancellation" placeholder=" cancellation">{{  old('cancellation',$tour->cancellation) }}</textarea>  
                                            </div>    
                                            <div class="mb-3">
                                                <label for="map_link" class="form-label">Highlight Content</label>
                                                <textarea class="form-control editor" name="highlights_content" placeholder="Highlight Content">{{  old('highlights_content',$tour->highlights_content) }}</textarea>  
                                            </div>    
                                            <div class="col-12 mt-2 mb-1">
                                                <label class="form-label fw-bold" style="font-size: 15px;">Add Short Itineraries</label>
                                            </div>
                                            <div class="row" id="highlightWrapper"> 
                                            </div> 
                                            
                                            <div class="col-sm-12 mb-3"> 
                                                <button type="button" class="btn btn-success" id="addHighlight">Add Short Itineraries</button>
                                            </div>  
                                            <div class="mb-3">
                                                <label for="include_exclude_content" class="form-label">Include/Exclude Details</label>
                                                <textarea class="form-control editor" name="include_exclude_content" placeholder="Include/Exclude Details">{{  old('include_exclude_content',$tour->include_exclude_content) }}</textarea>  
                                            </div>   
                                            <div class="mb-3">
                                                <label for="basic_content" class="form-label">Special Remarks</label>
                                                <textarea class="form-control editor" name="basic_content" placeholder="Enter Special Remarks Content">{{  old('basic_content',$tour->basic_content) }}</textarea>  
                                            </div>  

                                            <div class="col-12 mt-2 mb-1">
                                                <label class="form-label fw-bold" style="font-size: 15px;">Add Special Remarks</label>
                                            </div>
                                            <div class="row" id="important_infoWrapper"> 
                                            </div>  
                                            <div class="col-sm-12 mb-3"> 
                                                <button type="button" class="btn btn-success" id="addimportant_info">Add Special Remarks</button>
                                            </div>

                                            
                                            <div class="row">    
                                                <div class="col-sm-4"> 
                                                
                                                    <div class="mb-3">
                                                        <label class="form-label">Current Image</label><br>
                                                        <img src="{{ asset('storage/' . $tour->image) }}" alt="Image" width="80">
                                                    </div> 
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Image </label> 
                                                        <input id="image" name="image" type="file" accept="image/*" class="form-control" required> 
                                                    </div>   
                                                </div>   
                                                <div class="col-sm-4">  
                                                    <div class="mb-3">
                                                        <label class="form-label">Current BG Image</label><br>
                                                        <img src="{{ asset('storage/' . $tour->page_bg_image) }}" alt="Page BG Image" width="80">
                                                    </div> 
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Page BG Image </label> 
                                                        <input id="page_bg_image" name="page_bg_image" type="file" accept="image/*" class="form-control" required> 
                                                    </div>   
                                                </div>   
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Current Banner Image</label><br>
                                                        <img src="{{ asset('storage/' . $tour->banner_image) }}" alt="Banner Image" width="80">
                                                    </div> 
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Banner Image </label> 
                                                        <input id="banner_image" name="banner_image" type="file" accept="image/*" class="form-control" required> 
                                                    </div>   
                                                </div>  
                                                
                                                <?php /*
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="additional_images" class="form-label">Additional Images</label>
                                                        <input id="additional_images" name="additional_images[]" type="file" accept="image/*" class="form-control" multiple>
                                                    </div>
                                                </div>  
                                                
                                                @if(!empty($tour->gallery))
                                                    <div class="mb-3">
                                                        <label class="form-label">Existing Images</label>
                                                        <div class="row">
                                                            @foreach(json_decode($tour->gallery) as $image)
                                                                <div class="col-md-2">
                                                                    <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail" width="100">
                                                                    <input type="checkbox" name="delete_images[]" value="{{ $image }}"> Delete
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif 
                                                */?>
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="footer_images" class="form-label">Footer Gallery Images</label>
                                                        <input id="footer_images" name="footer_images[]" type="file" accept="image/*" class="form-control" multiple>
                                                    </div>
                                                </div> 
                                                
                                                @if(!empty($tour->footer_gallery))
                                                    <div class="mb-3">
                                                        <label class="form-label">Existing Images</label>
                                                        <div class="row">
                                                            @foreach(json_decode($tour->footer_gallery) as $image)
                                                                <div class="col-md-2">
                                                                    <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail" width="100">
                                                                    <input type="checkbox" name="delete_images[]" value="{{ $image }}"> Delete
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div> 
                                            
                                            <div class="row"> 
                                                    <div class="include_exclude">  
                                                        <div data-repeater-list="include_exclude" class="items">
                                                        @php
                                                        $include_exclude = json_encode(old('include_exclude',$tour->include_exclude), true) ?? [];
                                                        $include_exclude = json_decode($include_exclude) ?? []; 
                                                        @endphp
                                                        @if(!empty($include_exclude))
                                                            @foreach($include_exclude as $index => $item)
                                                                <div data-repeater-item class="row">
                                                                    <div class="mb-3 col-lg-3">
                                                                        <label for="projectdesc-input" class="form-label">Type</label> 
                                                                        <select class="form-select" name="items[0][type]"> 
                                                                                <option value="0"  {{ ($item->type ?? 0) == 0 ? 'selected' : '' }} >Exclude</option>
                                                                                <option value="1"  {{ ($item->type ?? 1) == 1 ? 'selected' : '' }} >Include</option>
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
                                        <h4 class="card-title">Itenary Details</h4>
                                            <div class="row">
                                                <div id="itinerary-container">
                                                @if(old('itinerary',$tour->itinerary))
                                                @php
                                                    $itineraries = is_array(old('itinerary',$tour->itinerary)) ? old('itinerary',$tour->itinerary) : json_decode(old('itinerary',$tour->itinerary), true);
                                                @endphp

                                                @foreach($itineraries as $key => $itinerary)
                                                        <div class="mb-3 itinerary-item" id="itinerary_day_{{ str_replace('day_', '', $key) }}">
                                                            <label for="itinerary_{{ $key }}">Day {{ str_replace('day_', '', $key) }} Itinerary:</label>
                                                            <textarea name="itinerary[{{ $key }}]" id="itinerary_{{ $key }}" row="6" class="form-control">{{ $itinerary }}</textarea>
                                                        </div>
                                                    @endforeach
                                                @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">  
                                        <h4 class="card-title">Seo Details</h4>
                                            <div class="row">
                                                <div class="col-sm-6"> 
                                                    <div class="mb-3">
                                                        <label for="meta_title" class="form-label">Meta Title</label>
                                                        
                                                        <input id="meta_title" name="meta_title" type="text" class="form-control" placeholder="Enter meta title..." value="{{  old('meta_title',$tour->meta_title) }}" > 
                                                    </div>  
                                                </div>  
                                                <div class="col-sm-6"> 
                                                    <div class="mb-3">
                                                        <label for="meta_keywords" class="form-label">Meta Keywords</label> 
                                                        <input id="meta_keywords" name="meta_keywords" type="text" class="form-control" placeholder="Enter meta keywords  (comma separated)..." value="{{  old('meta_keywords',$tour->meta_keywords) }}" > 
                                                    </div>  
                                                </div>  
                                            </div>   
                                            <div class="mb-3">
                                                <label for="meta_description" class="form-label">Meta Description</label>
                                                <textarea class="form-control" name="meta_description"   rows="6" placeholder="">{{  old('meta_description',$tour->meta_description) }}</textarea>  
                                            </div>   
                                             
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                    
                                </div>
                                <!-- end col --> 

                                <div class="col-lg-10">
                                    <div class="text-end mb-4">
                                        <button type="submit" class="btn btn-primary">Update Tour</button>
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
<script src="{{ url('/') }}/assets/libs/select2/js/select2.min.js"></script> 
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script> 
<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.editor').forEach(editorElement => {
        ClassicEditor.create(editorElement).catch(error => console.error(error));
    });
});

</script>
<script>
    // Select2
    $(".select2").select2();
</script>
<script>
        $(document).ready(function () {
            function addHighlightField(value = '') {
                let highlightHTML = `
                
                <div class="highlight-container">
                    <div class="col-sm-3"> 
                            <div class="mb-3">
                                <input type="text" class="form-control highlight-input" name="highlights[]" placeholder="Enter Short Itinerary (e.g. Delhi)..." value="${value}">      
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
        let existingHighlights = @json(old('highlights', $tour->highlights ?? []));
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
                                <input type="text" class="form-control " name="basic[]" placeholder="Enter Special Remark..." value="${value}">      
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
        let existingimportant_info = @json(old('basic', $tour->basic ?? []));
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
        $(document).ready(function () {
            $('#days').on('input', function () {
                let days = parseInt($(this).val()) || 0; // Get entered number of days
                let container = $('#itinerary-container');

                let existingCount = container.children('.itinerary-item').length;
                if (days > existingCount) {
                    // If increasing days, append new textareas
                    for (let i = existingCount + 1; i <= days; i++) {
                        container.append(`
                            <div class="mb-3 itinerary-item" id="itinerary_day_${i}">
                                <label for="itinerary_${i}">Day ${i} Itinerary:</label>
                                <textarea name="itinerary[day_${i}]" class="form-control"></textarea>
                            </div>
                        `);
                    }
                }

                // If reducing days, remove extra textareas
                if (days < existingCount) {
                    for (let i = existingCount; i > days; i--) {
                        $("#itinerary_day_" + i).remove();
                    }
                }
            });
        });
    </script>
@endsection