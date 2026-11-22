@extends('admin.layouts.app') 
@section('web_page_title', 'View Hotel')
@section('content')

                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0 font-size-18">Hotel List</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hotels</a></li>
                                            <li class="breadcrumb-item active">Hotel List</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2"> 
                                            @can('create-hotel')
                                            <div class="col-sm-12">
                                                <div class="text-sm-end">
                                                    <a href="{{ route('hotel.create') }}" class="btn btn-success btn-rounded" id="addProject-btn"><i class="mdi mdi-plus me-1"></i> Add New hotel</a>
                                                </div>
                                            </div><!-- end col-->
                                            @endcan
                                              
                                        </div> 
                                        <!-- end row -->
                                        <div class="">
                                            <div class="table-responsive">
                                                @include('admin.layouts.message')
                                                <table class="table project-list-table align-middle table-nowrap dt-responsive nowrap w-100 table-borderless" id="projectList-table">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th scope="col">#</th> 
                                                            <th scope="col">Image</th> 
                                                            <th scope="col">Name</th> 
                                                            <th scope="col">Location</th>  
                                                            <th scope="col">Action</th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($hotels as $hotel)
                                                        <tr>
                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                            <td><img src="{{ asset('storage/' . $hotel->image) }}" alt="{{ $hotel->name  }}"  width="100"></td> 
                                                            <td>{{ $hotel->name  }}</td>  
                                                            <td>{{ $hotel->location  }}</td>  
                                                             
                                                            <td>
                                                                <form action="{{ route('hotel.destroy', $hotel->id) }}" method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                        
                                                                     
                                                                        @can('edit-hotel')
                                                                            <a href="{{ route('hotel.edit', $hotel->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>   
                                                                        @endcan
                                        
                                                                        @can('delete-hotel') 
                                                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this?');"><i class="bi bi-trash"></i> Delete</button>
                                                                        @endcan
                                                                     
                                        
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                            <td colspan="3">
                                                                <span class="text-danger">
                                                                    <strong>No hotel Found!</strong>
                                                                </span>
                                                            </td>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                                {{ $hotels->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                        </div>
                        <!-- end row -->
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
 
                 
@endsection