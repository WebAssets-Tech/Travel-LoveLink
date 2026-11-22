@extends('layouts.app')

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
                                            <li class="breadcrumb-item"><a href="{{ route('hotel.index') }}">Hotel</a></li>
                                            <li class="breadcrumb-item active">Create New</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <form id="createproject-form" autocomplete="off"  enctype="multipart/form-data" class="repeater"  novalidate  action="{{ route('hotel.store') }}" method="POST">
                        @csrf
                            <div class="row">
                                <div class="col-lg-8">
                                @include('layouts.message')
                                    <div class="card">
                                        <div class="card-body">   
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Name</label>
                                                
                                                <input id="projectname-input" name="name" type="text" class="form-control" placeholder="Enter Name..." required> 
                                            </div>
                                             
                                            <div class="mb-3">
                                                <label for="projectdesc-input" class="form-label">Content</label>
                                                <textarea class="form-control" name="content" id="content" rows="3" placeholder="Enter content..." required></textarea> 
                                            </div>  
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Rating</label>
                                                
                                                <input id="rating" name="rating" type="text" class="form-control" placeholder="Enter rating..." required> 
                                            </div>
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Price</label>
                                                
                                                <input id="price" name="price" type="number" class="form-control" placeholder="Enter Price..." required> 
                                            </div> 
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Image</label>
                                                
                                                <input id="image" name="image_main" type="file" class="form-control" placeholder="Enter image..."  accept="image/*" required> 
                                            </div>  
                                          
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Gallery</label>
                                                
                                                <input id="image" name="images[]" multiple type="file" class="form-control" placeholder="Enter image..."  accept="image/*" > 
                                            </div>  
                                          
                                        </div>
                                        <!-- end card body -->
                                         
                                    </div>
                                    <!-- end card -->
                                    
                                </div>
                                <!-- end col -->
                                <div class="col-lg-4">
                                    
                                <div class="card">
                                        <div class="card-body">  
                                            <h5 class="card-title mb-3">Status</h5>
                                                <select class="form-select" id="type_status" name="status" >
                                                        <option >Status</option>
                                                        <option value="1">Active</option>
                                                        <option value="0" >InActive</option> 
                                                </select> 
                                                <br> 
                                            <h5 class="card-title mb-3">Type</h5>
                                                <select class="form-select" id="type" name="type">
                                                        <option >Type</option>
                                                        <option value="1">Hotel</option>
                                                        <option value="0" >Houseboat</option> 
                                                </select> 
                                                <br>
                                            <h5 class="card-title mb-3">Category</h5>
                                                <select class="form-select" id="cat_id" name="cat_id">
                                                        <option >Category</option>
                                                        @foreach($hotelcats as $id => $name)
                                                            <option value="{{ $id }}">{{ $name }}</option>
                                                        @endforeach
                                                </select>  
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                     

                                </div>
                                <!-- end col -->

                                <div class="col-lg-8">
                                    <div class="text-end mb-4">
                                        <button type="submit" class="btn btn-primary">Create Hotel</button>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </form>

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
 


@endsection