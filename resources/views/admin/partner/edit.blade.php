@extends('admin.layouts.app')
@section('web_page_title', 'Edit Partner') 
@section('content')

<div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Edit Partner</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('partner.index') }}">Partners</a></li>
                                            <li class="breadcrumb-item active">Edit Partner</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <form id="createproject-form" autocomplete="off"   enctype="multipart/form-data" class="repeater"    novalidate  action="{{ route('partner.update',$partner->id) }}" method="POST">
                        @csrf
                        @method("PUT")
                            <div class="row">
                                <div class="col-lg-8">
                                @include('admin.layouts.message')
                                    <div class="card">
                                        <div class="card-body">   
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Name</label> 
                                                <input id="name" name="name" type="text" class="form-control" placeholder="Enter name..." required value="{{ old('name',$partner->name) }}"> 
                                            </div>
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Link</label> 
                                                <input id="link" name="link" type="text" class="form-control" placeholder="Enter Link..." required value="{{ old('link',$partner->link) }}"> 
                                            </div>
                                              
                                            <div class="mb-3">
                                                <label for="projectname-input" class="form-label">Image </label>
                                                
                                                <input id="image" name="image" type="file" accept="image/*" class="form-control" required> 
                                                @if($partner->image)
                                                    <img src="{{ asset('storage/' . $partner->image) }}" alt="partner Image" width="100" class="mt-2">
                                                @endif
                                            </div>  
                                          
                                        </div>
                                        <!-- end card body -->
                                         
                                    </div>
                                    <!-- end card -->
                                    
                                </div>
                                <!-- end col --> 

                                <div class="col-lg-8">
                                    <div class="text-end mb-4">
                                        <button type="submit" class="btn btn-primary">Update Partner</button>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </form>

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
 


@endsection
 