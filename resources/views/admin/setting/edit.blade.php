@extends('admin.layouts.app')
@section('web_page_title', 'Manage Setting')
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
                                    <h4 class="mb-sm-0 font-size-18">Manage Setting</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="#">Settings</a></li>
                                            <li class="breadcrumb-item active">Manage Setting</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <form id="createproject-form" autocomplete="off"  enctype="multipart/form-data" class="repeater"  novalidate  action="{{ route('setting.update', $setting->id) }}"   method="POST">
                        @csrf
                        @method("PUT")
                            <div class="row">
                                <div class="col-lg-12">

                                @include('admin.layouts.message')
                                <div class="card">
                                    <div class="card-body">     
                                        <div class="row">
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">App Name<span class="text-danger">*</span></label>
                                                        
                                                        <input id="name" name="name" type="text" class="form-control" placeholder="Enter name..." value="{{ $setting->name }}" > 
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">E-Mail <span class="text-danger">*</span></label>
                                                        
                                                        <input id="email" name="email" type="email" class="form-control" placeholder="Enter email ..."  value="{{  $setting->email }}"> 
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">E-Mail 1<span class="text-danger">*</span></label>
                                                        
                                                        <input id="email1" name="email1" type="email" class="form-control" placeholder="Enter email 1 ..."  value="{{  $setting->email1 }}"> 
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="mb-3">
                                                        <label for="client_phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                                        
                                                        <input id="phone" name="phone" type="tel" class="form-control" placeholder="Enter phone..."  value="{{  $setting->phone  }}"> 
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="mb-3">
                                                        <label for="client_phone" class="form-label">Phone 1<span class="text-danger">*</span></label>
                                                        
                                                        <input id="phone" name="phone1" type="tel" class="form-control" placeholder="Enter phone 1..."  value="{{  $setting->phone1  }}"> 
                                                    </div>
                                                </div>
                                                
                                                <div class="col-sm-3"> 
                                                    <div class="mb-3">
                                                        <label for="header_logo" class="form-label">Header Logo </label> 
                                                        <input id="header_logo" name="header_logo" type="file" class="form-control"  accept="image/*" > 
                                                        @if(isset($setting->header_logo))
                                                            <br>
                                                            <img src="{{ asset('storage/' . $setting->header_logo) }}" alt="Image" width="100">
                                                        @endif
                                                    </div>  
                                                </div>  
                                                <div class="col-sm-3"> 
                                                    <div class="mb-3">
                                                        <label for="favicon" class="form-label">Favicon</label> 
                                                        <input id="favicon" name="favicon" type="file" class="form-control"  accept="image/*" > 
                                                        @if(isset($setting->favicon))
                                                            <br>
                                                            <img src="{{ asset('storage/' . $setting->favicon) }}" alt="Image" width="100">
                                                        @endif
                                                    </div>  
                                                </div>  
                                                <div class="col-sm-12"> 
                                                    <div class="mb-3">
                                                        <label for="projectname-input" class="form-label">Address</label>
                                                        <textarea class="form-control" name="address"   rows="4" placeholder="">{{  $setting->address }}</textarea>  
                                                    </div> 
                                                </div> 

                                                <div class="row">
                                                    <h3>Social Link</h3>
                                                    <div class="social_link">  
                                                        <div data-repeater-list="social_link" class="items">
                                                        @php
                                                        $social_link = json_encode($setting->social_link, true) ?? [];
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
                                                    <h3>Home Counter</h3>
                                                    <div class="home_counter">
                                                        <div id="homeCounterList">
                                                            @if(!empty($setting->home_counter))
                                                                @foreach($setting->home_counter as $index => $item)
                                                                    <div class="row home-counter-item">
                                                                        <div class="mb-3 col-lg-3">
                                                                            <label for="count_number" class="form-label">Number</label>
                                                                            <input name="home_counter[{{ $index }}][count_number]" type="text" class="form-control" placeholder="Enter Number..." value="{{ $item['count_number'] ?? '' }}">
                                                                        </div>  
                                                                        <div class="mb-3 col-lg-3">
                                                                            <label for="count_sufix" class="form-label">Suffix</label> 
                                                                            <input name="home_counter[{{ $index }}][count_sufix]" type="text" class="form-control" placeholder="Enter Suffix..." value="{{ $item['count_sufix'] ?? '' }}">
                                                                        </div> 
                                                                        <div class="mb-3 col-lg-3">
                                                                            <label for="count_text" class="form-label">Text</label> 
                                                                            <input name="home_counter[{{ $index }}][count_text]" type="text" class="form-control" placeholder="Enter Text..." value="{{ $item['count_text'] ?? '' }}">
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
                                                                        <input name="home_counter[0][count_number]" type="text" class="form-control" placeholder="Enter Number...">
                                                                    </div>  
                                                                    <div class="mb-3 col-lg-3">
                                                                        <label for="count_sufix" class="form-label">Suffix</label> 
                                                                        <input name="home_counter[0][count_sufix]" type="text" class="form-control" placeholder="Enter Suffix...">
                                                                    </div> 
                                                                    <div class="mb-3 col-lg-3">
                                                                        <label for="count_text" class="form-label">Text</label> 
                                                                        <input name="home_counter[0][count_text]" type="text" class="form-control" placeholder="Enter Text...">
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


                                                <div class="row">
                                                    <h3>About Page Content</h3>
                                                    <div class="about_ot_content">
                                                        <div id="aboutOtContentList">
                                                            @if(!empty($setting->about_ot_content))
                                                                @foreach($setting->about_ot_content as $index => $item)
                                                                    <div class="row about-ot-item">
                                                                        <div class="mb-4 col-lg-4">
                                                                            <label for="title" class="form-label">Title</label> 
                                                                            <input name="about_ot_content[{{ $index }}][title]" type="text" class="form-control" placeholder="Enter Title..." value="{{ $item['title'] ?? '' }}">
                                                                        </div> 
                                                                        <div class="mb-4 col-lg-4">
                                                                            <label for="content" class="form-label">Content</label> 
                                                                            <input name="about_ot_content[{{ $index }}][content]" type="text" class="form-control" placeholder="Enter Content..." value="{{ $item['content'] ?? '' }}">
                                                                        </div>
                                                                        <div class="col-lg-4 align-self-center">
                                                                            <div class="d-grid">
                                                                                <button type="button" class="btn btn-danger removeItem">Delete</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div class="row about-ot-item">
                                                                    <div class="mb-4 col-lg-4">
                                                                        <label for="title" class="form-label">Title</label> 
                                                                        <input name="about_ot_content[0][title]" type="text" class="form-control" placeholder="Enter Title...">
                                                                    </div> 
                                                                    <div class="mb-4 col-lg-4">
                                                                        <label for="content" class="form-label">Content</label> 
                                                                        <input name="about_ot_content[0][content]" type="text" class="form-control" placeholder="Enter Content...">
                                                                    </div>
                                                                    <div class="col-lg-4 align-self-center">
                                                                        <div class="d-grid">
                                                                            <button type="button" class="btn btn-danger removeItem">Delete</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 align-self-center">
                                                        <button type="button" class="btn btn-success mt-3" id="addItem">Add</button><br><br>
                                                    </div> 
                                                </div>

                                                <div class="row">
                                                    <h3>About Page Image</h3>
                                                    <div class="about_images">
                                                        <div id="aboutImagesList">
                                                        @php
                                                        $aboutImages = is_string($setting->about_images)    ? json_decode($setting->about_images, true)  : ($setting->about_images ?? []);
                                                        @endphp
                                                            @if(!empty($aboutImages))
                                                                @foreach($aboutImages as $index => $item)
                                                                    <div class="row about-image-item">
                                                                        <div class="mb-4 col-lg-4">
                                                                            <label for="image" class="form-label">Image</label> 
                                                                            <input name="about_images[{{ $index }}][image]" type="file" accept="image/*" class="form-control">
                                                                            @if(isset($item['image']))
                                                                                <img src="{{ asset('storage/' . $item['image']) }}" alt="Image" width="100">
                                                                            @endif
                                                                        </div> 
                                                                        <div class="mb-4 col-lg-4">
                                                                            <label for="order" class="form-label">Order</label> 
                                                                            <input name="about_images[{{ $index }}][order]" type="number" class="form-control" placeholder="Enter order..." value="{{ $item['order'] ?? '' }}">
                                                                        </div>
                                                                        <div class="col-lg-4 align-self-center">
                                                                            <div class="d-grid">
                                                                                <button type="button" class="btn btn-danger removeItem">Delete</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div class="row about-image-item">
                                                                    <div class="mb-4 col-lg-4">
                                                                        <label for="image" class="form-label">Image</label> 
                                                                        <input name="about_images[0][image]" type="file" accept="image/*" class="form-control">
                                                                    </div> 
                                                                    <div class="mb-4 col-lg-4">
                                                                        <label for="order" class="form-label">Order</label> 
                                                                        <input name="about_images[0][order]" type="number" class="form-control" placeholder="Enter order...">
                                                                    </div>
                                                                    <div class="col-lg-4 align-self-center">
                                                                        <div class="d-grid">
                                                                            <button type="button" class="btn btn-danger removeItem">Delete</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 align-self-center">
                                                        <button type="button" class="btn btn-success mt-3" id="addImageItem">Add</button><br><br>
                                                    </div> 
                                                </div>



                                                <div class="row">
                                                    <h3>Page Backgorund Image</h3>
                                                    <div class="page_bg_image">
                                                        <div id="page_bg_imageImagesList">
                                                        @php
                                                        $page_bg_imageImages = is_string($setting->page_bg_image)    ? json_decode($setting->page_bg_image, true)  : ($setting->page_bg_image ?? []);
                                                        @endphp
                                                            @if(!empty($page_bg_imageImages))
                                                                @foreach($page_bg_imageImages as $index => $item)
                                                                    <div class="row page_bg_image-image-item">
                                                                        <div class="mb-4 col-lg-4">
                                                                            <label for="image" class="form-label">Image</label> 
                                                                            <input name="page_bg_image[{{ $index }}][image]" type="file" accept="image/*" class="form-control">
                                                                            @if(isset($item['image']))
                                                                                <img src="{{ asset('storage/' . $item['image']) }}" alt="Image" width="100">
                                                                            @endif
                                                                        </div> 
                                                                        <div class="mb-4 col-lg-4">
                                                                            <label for="order" class="form-label">Type</label> 
                                                                            <input name="page_bg_image[{{ $index }}][type]" type="text" class="form-control" placeholder="Enter type..." value="{{ $item['type'] ?? '' }}">
                                                                        </div>
                                                                        <div class="col-lg-4 align-self-center">
                                                                            <div class="d-grid">
                                                                                <button type="button" class="btn btn-danger removeItempage_bg_image">Delete</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div class="row page_bg_image-image-item">
                                                                    <div class="mb-4 col-lg-4">
                                                                        <label for="image" class="form-label">Image</label> 
                                                                        <input name="page_bg_image[0][image]" type="file" accept="image/*" class="form-control">
                                                                    </div> 
                                                                    <div class="mb-4 col-lg-4">
                                                                        <label for="type" class="form-label">Type</label> 
                                                                        <input name="page_bg_image[0][type]" type="text" class="form-control" placeholder="Enter type...">
                                                                    </div>
                                                                    <div class="col-lg-4 align-self-center">
                                                                        <div class="d-grid">
                                                                            <button type="button" class="btn btn-danger removeItempage_bg_image">Delete</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 align-self-center">
                                                        <button type="button" class="btn btn-success mt-3" id="addpage_bg_imageImageItem">Add</button><br><br>
                                                    </div> 
                                                </div>



                                                    

                                                    
                                            </div>
                                        </div> 
                                    </div>
                                
                                    <div class="card">
                                        <div class="card-body">  
                                        <h4 class="card-title">About Us</h4>
                                            <div class="row">
                                                <div class="col-sm-6"> 
                                                    <div class="mb-3">
                                                        <label for="about_title" class="form-label">About Us Title</label>
                                                        
                                                        <input id="about_title" name="about_title" type="text" class="form-control" placeholder="Enter about us title..." value="{{  $setting->about_title }}" > 
                                                    </div>  
                                                </div>  
                                                <div class="col-sm-6"> 
                                                    <div class="mb-3">
                                                        <label for="about_subtitle" class="form-label">About Us SubTitle</label>
                                                        
                                                        <input id="about_subtitle" name="about_subtitle" type="text" class="form-control" placeholder="Enter about us subtitle..." value="{{  $setting->about_subtitle }}" > 
                                                    </div>  
                                                </div>  
                                            </div>   
                                            <div class="mb-3">
                                                <label for="about_content" class="form-label">About Us Content</label>
                                                <textarea class="form-control editor" name="about_content"   rows="6" placeholder="">{{  $setting->about_content }}</textarea>  
                                            </div>   
                                             
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                
                                    <div class="card">
                                        <div class="card-body">  
                                        <h4 class="card-title">Seo Details</h4>
                                            <div class="row">
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label for="meta_title" class="form-label">Meta Title</label>
                                                        
                                                        <input id="meta_title" name="meta_title" type="text" class="form-control" placeholder="Enter meta title..." value="{{  $setting->meta_title }}" > 
                                                    </div>  
                                                </div>  
                                                
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label for="meta_image" class="form-label">Meta Image</label> 
                                                        <input id="meta_image" name="meta_image" type="file" class="form-control"  accept="image/*" > 
                                                        @if(isset($setting->meta_image))
                                                            <br>
                                                            <img src="{{ asset('storage/' . $setting->meta_image) }}" alt="Image" width="100">
                                                        @endif
                                                    </div>  
                                                </div>   
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                                        
                                                        <input id="meta_keywords" name="meta_keywords" type="text" class="form-control" placeholder="Enter meta keywords..." value="{{  $setting->meta_keywords }}" > 
                                                    </div>  
                                                </div>  
                                            </div>   
                                            <div class="mb-3">
                                                <label for="meta_description" class="form-label">Meta Description</label>
                                                <textarea class="form-control" name="meta_description"   rows="6" placeholder="">{{  $setting->meta_description }}</textarea>  
                                            </div>   
                                             
                                        </div>
                                        <!-- end card body -->
                                    </div>

                                    <div class="card">
                                        <div class="card-body">  
                                        <h4 class="card-title">Footer Details</h4>
                                            <div class="row">
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label for="footer_logo" class="form-label">Footer Logo</label> 
                                                        <input id="footer_logo" name="footer_logo" type="file" class="form-control"  accept="image/*" > 
                                                        @if(isset($setting->footer_logo))
                                                            <br>
                                                            <img src="{{ asset('storage/' . $setting->footer_logo) }}" alt="Image" width="100">
                                                        @endif
                                                    </div>  
                                                </div> 
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label for="footer_copyright" class="form-label">Footer Copyright</label> 
                                                        <input id="footer_copyright" name="footer_copyright" type="text" class="form-control" placeholder="Enter footer copyrights..." value="{{  $setting->footer_copyright }}" > 
                                                    </div>  
                                                </div>   
                                                <div class="col-sm-4"> 
                                                    <div class="mb-3">
                                                        <label class="form-label">Preloader</label> 
                                                        <select class="form-control"  name="preloader"> 
                                                                <option value="1"  @if($setting->preloader  ==  1 ) selected @endif >Active</option>
                                                                <option value="0"  @if($setting->preloader  ==  0 ) selected @endif >InActive</option> 
                                                        </select> 
                                                    </div>  
                                                </div>  
                                            </div>   
                                            <div class="mb-3">
                                                <label for="footer_about" class="form-label">Footer About</label>
                                                <textarea class="form-control" name="footer_about"   rows="6" placeholder="">{{  $setting->footer_about }}</textarea>  
                                            </div>    
                                            <div class="mb-3">
                                                <label for="map_link" class="form-label">Map Link</label>
                                                <textarea class="form-control" name="map_link"   rows="6" placeholder="">{{  $setting->map_link }}</textarea>  
                                            </div>     
                                            <div class="mb-3">
                                                <label for="youtube_vid_link" class="form-label">Youtube Video Link</label>
                                                <textarea class="form-control" name="youtube_vid_link"   rows="6" placeholder="">{{  $setting->youtube_vid_link }}</textarea>  
                                            </div>     
                                            <div class="mb-3">
                                                <label for="footer_script" class="form-label">Footer Script</label>
                                                <textarea class="form-control" name="footer_script"   rows="6" placeholder="">{{  $setting->footer_script }}</textarea>  
                                            </div>    
                                            <div class="mb-3">
                                                <label for="header_script" class="form-label">Header Script</label>
                                                <textarea class="form-control" name="header_script"   rows="6" placeholder="">{{  $setting->header_script }}</textarea>  
                                            </div>  
                                              
                                             
                                             
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                      

                                <div class="col-lg-12">
                                    <div class="text-end mb-4">
                                        <button type="submit" class="btn btn-primary">Update Setting</button>
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
    // Select2
    $(".select2").select2();
</script> 
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.editor').forEach(editorElement => {
            ClassicEditor
                .create(editorElement, {
                    toolbar: [
                        'heading', '|', 'bold', 'italic', 'underline', 'strikethrough', '|',
                        'alignment', '|', 'bulletedList', 'numberedList', '|',
                        'blockQuote', 'link', 'insertTable', '|',
                        'undo', 'redo'
                    ],
                    heading: {
                        options: [
                            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                        ]
                    },
                    table: {
                        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        });
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let counterIndex = {{ !empty($setting->home_counter) ? count($setting->home_counter) : 1 }};

    // Add new counter row
    document.getElementById("addCounter").addEventListener("click", function () {
        let container = document.getElementById("homeCounterList");
        let newRow = `
            <div class="row home-counter-item">
                <div class="mb-3 col-lg-3">
                    <label for="count_number" class="form-label">Number</label>
                    <input name="home_counter[${counterIndex}][count_number]" type="number" class="form-control" placeholder="Enter Number...">
                </div>  
                <div class="mb-3 col-lg-3">
                    <label for="count_sufix" class="form-label">Suffix</label> 
                    <input name="home_counter[${counterIndex}][count_sufix]" type="text" class="form-control" placeholder="Enter Suffix...">
                </div> 
                <div class="mb-3 col-lg-3">
                    <label for="count_text" class="form-label">Text</label> 
                    <input name="home_counter[${counterIndex}][count_text]" type="text" class="form-control" placeholder="Enter Text...">
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

<script>
document.addEventListener("DOMContentLoaded", function () {
    let itemIndex = {{ !empty($setting->about_ot_content) ? count($setting->about_ot_content) : 1 }};

    // Add new item
    document.getElementById("addItem").addEventListener("click", function () {
        let container = document.getElementById("aboutOtContentList");
        let newRow = `
            <div class="row about-ot-item">
                <div class="mb-4 col-lg-4">
                    <label for="title" class="form-label">Title</label> 
                    <input name="about_ot_content[${itemIndex}][title]" type="text" class="form-control" placeholder="Enter Title...">
                </div> 
                <div class="mb-4 col-lg-4">
                    <label for="content" class="form-label">Content</label> 
                    <input name="about_ot_content[${itemIndex}][content]" type="text" class="form-control" placeholder="Enter Content...">
                </div>
                <div class="col-lg-4 align-self-center">
                    <div class="d-grid">
                        <button type="button" class="btn btn-danger removeItem">Delete</button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML("beforeend", newRow);
        itemIndex++;
    });

    // Remove item
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("removeItem")) {
            event.target.closest(".about-ot-item").remove();
        }
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let itemIndex = {{ !empty($aboutImages) ? count($aboutImages) : 1 }};

    // Add new image upload field
    document.getElementById("addImageItem").addEventListener("click", function () {
        let container = document.getElementById("aboutImagesList");
        let newRow = `
            <div class="row about-image-item">
                <div class="mb-4 col-lg-4">
                    <label for="image" class="form-label">Image</label> 
                    <input name="about_images[${itemIndex}][image]" type="file" accept="image/*" class="form-control">
                </div> 
                <div class="mb-4 col-lg-4">
                    <label for="order" class="form-label">Order</label> 
                    <input name="about_images[${itemIndex}][order]" type="number" class="form-control" placeholder="Enter order...">
                </div>
                <div class="col-lg-4 align-self-center">
                    <div class="d-grid">
                        <button type="button" class="btn btn-danger removeItem">Delete</button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML("beforeend", newRow);
        itemIndex++;
    });

    // Remove image upload field
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("removeItem")) {
            event.target.closest(".about-image-item").remove();
        }
    });
});
document.addEventListener("DOMContentLoaded", function () {
    let itemIndex = {{ !empty($page_bg_imageImages) ? count($page_bg_imageImages) : 1 }};

    // Add new image upload field
    document.getElementById("addpage_bg_imageImageItem").addEventListener("click", function () {
        let container = document.getElementById("page_bg_imageImagesList");
        let newRow = `
            <div class="row about-image-item">
                <div class="mb-4 col-lg-4">
                    <label for="image" class="form-label">Image</label> 
                    <input name="page_bg_image[${itemIndex}][image]" type="file" accept="image/*" class="form-control">
                </div> 
                <div class="mb-4 col-lg-4">
                    <label for="type" class="form-label">Type</label> 
                    <input name="page_bg_image[${itemIndex}][type]" type="text" class="form-control" placeholder="Enter type...">
                </div>
                <div class="col-lg-4 align-self-center">
                    <div class="d-grid">
                        <button type="button" class="btn btn-danger removeItempage_bg_image">Delete</button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML("beforeend", newRow);
        itemIndex++;
    });

    // Remove image upload field
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("removeItempage_bg_image")) {
            event.target.closest(".page_bg_image-image-item").remove();
        }
    });
});
</script>
@endsection