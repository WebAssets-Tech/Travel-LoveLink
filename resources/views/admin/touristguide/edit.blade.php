@extends('admin.layouts.app')
@section('web_page_title', 'Edit Tourist Guide') 
@section('content')

<div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Edit Tourist Guide</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('touristguide.index') }}">Tourist Guide</a></li>
                                            <li class="breadcrumb-item active">Edit Tourist Guide</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <form id="createproject-form" autocomplete="off"   enctype="multipart/form-data" class="outer-repeater"    novalidate  action="{{ route('touristguide.update',$touristguide->id) }}" method="POST">
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
                                                        <label for="projectname-input" class="form-label">Name</label> 
                                                        <input id="name" name="name" type="text" class="form-control" placeholder="Enter name..." required value="{{ old('name',$touristguide->name) }}"> 
                                                    </div> 
                                                </div>   
                                                <div class="col-sm-4">  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Phone </label> 
                                                        <input id="phone" name="phone" type="tel" class="form-control" placeholder="Enter phone ..." required  value="{{ old('phone',$touristguide->phone) }}"> 
                                                    </div> 
                                                </div>   
                                                <div class="col-sm-4">  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Phone 1 </label> 
                                                        <input id="phone2" name="phone2" type="tel" class="form-control" placeholder="Enter price ..." required  value="{{ old('phone2',$touristguide->phone2) }}"> 
                                                    </div> 
                                                </div>    
                                                <div class="col-sm-4">  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">E-Mail </label> 
                                                        <input id="email" name="email" type="email" class="form-control" placeholder="Enter E-Mail ..." required  value="{{ old('email',$touristguide->email) }}"> 
                                                    </div> 
                                                </div>   
                                                <div class="col-sm-4">  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">E-Mail 1 </label> 
                                                        <input id="email2" name="email2" type="email" class="form-control" placeholder="Enter E-Mail 1 ..." required  value="{{ old('email2',$touristguide->email2) }}"> 
                                                    </div> 
                                                </div>   
                                                <div class="col-sm-4">  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Rating </label> 
                                                        <input id="rating" name="rating" type="number" class="form-control" placeholder="Enter rating ..." required  value="{{ old('rating',$touristguide->rating) }}"> 
                                                    </div> 
                                                </div>  
                                                   
                                                <div class="col-sm-12"> 
                                                    <div class="mb-3">
                                                        <label for="address" class="form-label">Address</label>
                                                        <textarea class="form-control" name="address" placeholder=" addressk">{{  old('address',$touristguide->address) }}</textarea>  
                                                    </div> 
                                                </div>    
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label> 
                                                        <select class="form-control"  name="status"> 
                                                                <option value="1"  @if(old('status',$touristguide->status)  ==  1 ) selected @endif >Active</option> 
                                                                <option value="0"  @if(old('status',$touristguide->status)  ==  0 ) selected @endif >InActive</option>
                                                        </select> 
                                                    </div>   
                                                </div>   
                                                <div class="col-sm-4">  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Language </label> 
                                                        <input id="language" name="language" type="text" class="form-control" placeholder="Enter language ..." required  value="{{ old('language',$touristguide->language) }}"> 
                                                    </div> 
                                                </div>   
                                                <div class="col-sm-4">  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Experience </label> 
                                                        <input id="experience" name="experience" type="text" class="form-control" placeholder="Enter experience ..." required  value="{{ old('experience',$touristguide->experience) }}"> 
                                                    </div> 
                                                </div>   
                                                <div class="col-sm-4">  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Location </label> 
                                                        <input id="location" name="location" type="text" class="form-control" placeholder="Enter location ..." required  value="{{ old('location',$touristguide->location) }}"> 
                                                    </div> 
                                                </div>    
                                                
                                                  <div class="col-sm-4">  
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Designation </label> 
                                                        <input id="designation" name="designation" type="text" class="form-control" placeholder="Enter designation ..." required  value="{{ old('designation',$touristguide->designation) }}"> 
                                                    </div> 
                                                </div>    
                                            </div>
                                             
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Bio</label>
                                                <textarea class="form-control editor" name="bio" placeholder=" bio">{{  old('bio',$touristguide->bio) }}</textarea>  
                                            </div>  
                                            

                                            <div class="row">
                                                    <h3>Social Link</h3>
                                                    <div class="social_link">  
                                                        <div data-repeater-list="social_link" class="items">
                                                        @php
                                                        $social_link = json_encode(old('social_link',$touristguide->social_link), true) ?? [];
                                                        $social_link = json_decode($social_link) ?? []; 
                                                        @endphp
                                                        @if(!empty($social_link))
                                                            @foreach($social_link as $index => $item)
                                                                <div data-repeater-item class="row">
                                                                    <div class="mb-3 col-lg-3">
                                                                        <label for="projectdesc-input" class="form-label">Social</label>
                                                                        
                                                                        <select class="form-select" name="items[0][social_name]"> 
                                                                                <option value="Facebook"  @if($item->social_name == "Facebook" ) selected @endif >Facebook</option>
                                                                                <option value="Instagram"  @if($item->social_name  == "Instagram" ) selected @endif >Instagram</option>
                                                                                <option value="Whatsapp"  @if($item->social_name == "Whatsapp" ) selected @endif >Whatsapp</option>
                                                                                <option value="Twitter"  @if($item->social_name  == "Twitter" ) selected @endif >Twitter</option>
                                                                                <option value="LinkedIn"  @if($item->social_name  == "LinkedIn" ) selected @endif >LinkedIn</option>
                                                                        </select> 
                                                                    </div>  
                                                                    <div class="mb-3 col-lg-3">
                                                                        <label for="projectname-input" class="form-label">Social Link</label> 
                                                                        <input name="items[0][social_link]" type="text" class="form-control" placeholder="Enter Link..."  value="{{ $item->social_link ?? '' }}" >  
                                                                    </div>  
                                                                    <div class="mb-3 col-lg-3">
                                                                        <label for="projectname-input" class="form-label">Social Icon</label> 
                                                                        <input name="items[0][social_icon]" type="text" class="form-control" placeholder="Enter Icon..."  value="{{ $item->social_icon  ?? '' }}" >  
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
                                                                    <label for="projectdesc-input" class="form-label">Social</label>
                                                                    
                                                                    <select class="form-select" name="items[0][social_name]"> 
                                                                            <option value="Facebook">Facebook</option>
                                                                            <option value="Instagram">Instagram</option>
                                                                            <option value="Whatsapp">Whatsapp</option>
                                                                            <option value="Twitter">Twitter</option>
                                                                            <option value="LinkedIn">LinkedIn</option>
                                                                    </select> 
                                                                </div>  
                                                                <div class="mb-3 col-lg-3">
                                                                    <label for="projectname-input" class="form-label">Social Link</label> 
                                                                    <input name="items[0][social_link]" type="text" class="form-control" placeholder="Enter Link..." >  
                                                                </div>
                                                                <div class="mb-3 col-lg-3">
                                                                    <label for="projectname-input" class="form-label">Social Icon</label> 
                                                                    <input name="items[0][social_icon]" type="text" class="form-control" placeholder="Enter Icon..." >  
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
                                                 
                                            </div> 
                                            
                                            <div class="row">
                                                    <h3>Home Counter</h3>
                                                    <div class="details_counter">
                                                        <div id="homeCounterList">
                                                            @if(!empty(old('details_counter',$touristguide->details_counter)))
                                                                @foreach(old('details_counter',$touristguide->details_counter) as $index => $item)
                                                                    <div class="row home-counter-item">
                                                                        <div class="mb-3 col-lg-3">
                                                                            <label for="count_number" class="form-label">Number</label>
                                                                            <input name="details_counter[{{ $index }}][count_number]" type="number" class="form-control" placeholder="Enter Number..." value="{{ $item['count_number'] ?? '' }}">
                                                                        </div>  
                                                                        <div class="mb-3 col-lg-3">
                                                                            <label for="count_sufix" class="form-label">Suffix</label> 
                                                                            <input name="details_counter[{{ $index }}][count_sufix]" type="text" class="form-control" placeholder="Enter Suffix..." value="{{ $item['count_sufix'] ?? '' }}">
                                                                        </div> 
                                                                        <div class="mb-3 col-lg-3">
                                                                            <label for="count_text" class="form-label">Text</label> 
                                                                            <input name="details_counter[{{ $index }}][count_text]" type="text" class="form-control" placeholder="Enter Text..." value="{{ $item['count_text'] ?? '' }}">
                                                                        </div>
                                                                        <div class="col-lg-3 align-self-center">
                                                                            <div class="d-grid">
                                                                                <button type="button" class="btn btn-danger removeCounter">Delete</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div class="row home-counter-item">
                                                                    <div class="mb-3 col-lg-3">
                                                                        <label for="count_number" class="form-label">Number</label>
                                                                        <input name="details_counter[0][count_number]" type="number" class="form-control" placeholder="Enter Number...">
                                                                    </div>  
                                                                    <div class="mb-3 col-lg-3">
                                                                        <label for="count_sufix" class="form-label">Suffix</label> 
                                                                        <input name="details_counter[0][count_sufix]" type="text" class="form-control" placeholder="Enter Suffix...">
                                                                    </div> 
                                                                    <div class="mb-3 col-lg-3">
                                                                        <label for="count_text" class="form-label">Text</label> 
                                                                        <input name="details_counter[0][count_text]" type="text" class="form-control" placeholder="Enter Text...">
                                                                    </div>
                                                                    <div class="col-lg-3 align-self-center">
                                                                        <div class="d-grid">
                                                                            <button type="button" class="btn btn-danger removeCounter">Delete</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 align-self-center">
                                                        <button type="button" class="btn btn-success mt-3" id="addCounter">Add</button><br><br>
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
                                                        
                                                        <input id="meta_title" name="meta_title" type="text" class="form-control" placeholder="Enter meta title..." value="{{  old('meta_title',$touristguide->meta_title) }}" > 
                                                    </div>  
                                                </div>  
                                                <div class="col-sm-6"> 
                                                    <div class="mb-3">
                                                        <label for="meta_keywords" class="form-label">Meta Keywords</label> 
                                                        <input id="meta_keywords" name="meta_keywords" type="text" class="form-control" placeholder="Enter meta keywords  (comma separated)..." value="{{  old('meta_keywords',$touristguide->meta_keywords) }}" > 
                                                    </div>  
                                                </div>  
                                            </div>   
                                            <div class="mb-3">
                                                <label for="meta_description" class="form-label">Meta Description</label>
                                                <textarea class="form-control" name="meta_description"   rows="6" placeholder="">{{  old('meta_description',$touristguide->meta_description) }}</textarea>  
                                            </div>   
                                             
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                    
                                </div>
                                <!-- end col --> 

                                <div class="col-lg-8">
                                    <div class="text-end mb-4">
                                        <button type="submit" class="btn btn-primary">Update Tourist Guide</button>
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
document.addEventListener("DOMContentLoaded", function () {
    let counterIndex = {{ !empty(old('details_counter')) ? count(old('details_counter')) : 1 }};

    // Add new counter row
    document.getElementById("addCounter").addEventListener("click", function () {
        let container = document.getElementById("homeCounterList");
        let newRow = `
            <div class="row home-counter-item">
                <div class="mb-3 col-lg-3">
                    <label for="count_number" class="form-label">Number</label>
                    <input name="details_counter[${counterIndex}][count_number]" type="number" class="form-control" placeholder="Enter Number...">
                </div>  
                <div class="mb-3 col-lg-3">
                    <label for="count_sufix" class="form-label">Suffix</label> 
                    <input name="details_counter[${counterIndex}][count_sufix]" type="text" class="form-control" placeholder="Enter Suffix...">
                </div> 
                <div class="mb-3 col-lg-3">
                    <label for="count_text" class="form-label">Text</label> 
                    <input name="details_counter[${counterIndex}][count_text]" type="text" class="form-control" placeholder="Enter Text...">
                </div>
                <div class="col-lg-3 align-self-center">
                    <div class="d-grid">
                        <button type="button" class="btn btn-danger removeCounter">Delete</button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML("beforeend", newRow);
        counterIndex++;
    });

    // Remove counter row
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("removeCounter")) {
            event.target.closest(".home-counter-item").remove();
        }
    });
});
</script>

@endsection