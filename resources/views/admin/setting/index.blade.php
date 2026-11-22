@extends('layouts.app')

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
                                            <!-- end col -->
                                            <div class="col-sm-auto">
                                                <div class="text-sm-end">
                                                    <a href="{{ route('hotel.create') }}" class="btn btn-success btn-rounded" id="addProject-btn"><i class="mdi mdi-plus me-1"></i> Add New Hotel</a>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                            @endcan
                                        </div>
                                        <!-- end row -->
                                        <div class="">
                                            <div class="table-responsive">
                                                @include('layouts.message')
                                                <table class="table project-list-table align-middle table-nowrap dt-responsive nowrap w-100 table-borderless" id="projectList-table">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th scope="col">#</th> 
                                                            <th scope="col">Hotel Name</th> 
                                                            <th scope="col">Rating</th> 
                                                            <th scope="col">Price</th> 
                                                            <th scope="col">Type</th>  
                                                            <th scope="col">Status</th>  
                                                            <th scope="col">Category</th>  
                                                            <th scope="col">Action</th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($hotels as $hotel)
                                                        <tr>
                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                            <td>{{ $hotel->name }}</td> 
                                                            <td>{{ $hotel->rating }}</td> 
                                                            <td>{{ $hotel->price }}</td>  
                                                            <td>@if($hotel->type == 1) Hotel @endif @if($hotel->type == 0) Houseboat @endif </td> 
                                                            <td>@if($hotel->status == 1) Active @endif @if($hotel->status == 0) InActive @endif </td> 
                                                            <td>{{ $hotel->category->name }}</td>  
                                                             
                                                            <td>
                                                                <form action="{{ route('hotel.destroy', $hotel->id) }}" method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                        
                                                                     
                                                                        @can('edit-hotel')
                                                                            <a href="{{ route('hotel.edit', $hotel->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>   
                                                                        @endcan
                                        
                                                                        @can('delete-hotel') 
                                                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this Lead Source?');"><i class="bi bi-trash"></i> Delete</button>
                                                                        @endcan
                                                                     
                                        
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                            <td colspan="3">
                                                                <span class="text-danger">
                                                                    <strong>No Hotel Found!</strong>
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

                <!-- Modal -->
                <div class="modal fade" id="removeItemModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content">
                            <div class="modal-body px-4 py-5 text-center">
                                <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                                <div class="avatar-sm mb-4 mx-auto">
                                    <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">
                                        <i class="mdi mdi-trash-can-outline"></i>
                                    </div>
                                </div>
                                <p class="text-muted font-size-16 mb-4">Are you Sure You want to Remove this Order ?</p>
                                
                                <div class="hstack gap-2 justify-content-center mb-0">
                                    <button type="button" class="btn btn-danger" id="remove-item">Remove Now</button>
                                    <button type="button" class="btn btn-secondary" id="close-removeProjectModal" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end removeItemModal -->
                 
@endsection