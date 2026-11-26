@extends('admin.layouts.app') 
@section('web_page_title', 'Video Reviews (YouTube)')
@section('content')

                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0 font-size-18">Video Reviews (YouTube)</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Video Reviews</li>
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
                                            @canany(['create-youtube', 'create-blog'])
                                            <div class="col-sm-12">
                                                <div class="text-sm-end">
                                                    <a href="{{ route('youtube.create') }}" class="btn btn-success btn-rounded" id="addProject-btn"><i class="mdi mdi-plus me-1"></i> Add Video Review</a>
                                                </div>
                                            </div><!-- end col-->
                                            @endcanany
                                              
                                        </div> 
                                        <!-- end row -->
                                        <div class="">
                                            <div class="table-responsive">
                                                @include('admin.layouts.message')
                                                <table class="table project-list-table align-middle table-nowrap dt-responsive nowrap w-100 table-borderless" id="projectList-table">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th scope="col">#</th>  
                                                            <th scope="col">Title</th> 
                                                            <th scope="col">YouTube Link</th>  
                                                            <th scope="col">Status</th>  
                                                            <th scope="col">Action</th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($youtube as $y)
                                                        <tr>
                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                            <td>{{ $y->title  }}</td> 
                                                             <td><a href="{{$y->youtube_link}}" target="_blank">YouTube Link</a></td>
   
                                                            <td>
                                                                <span class="badge {{ $y->status ? 'bg-success' : 'bg-danger' }}">
                                                                    {{ $y->status ? 'Active' : 'Inactive' }}
                                                                </span>
                                                            </td>
                                                           
                                                             
                                                            <td>
                                                                <form action="{{ route('youtube.destroy', $y->id) }}" method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                        
                                                                     
                                                                        @can('edit-blog')
                                                                            <a href="{{ route('youtube.edit', $y->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>   
                                                                        @endcan
                                        
                                                                        @can('delete-blog') 
                                                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this?');"><i class="bi bi-trash"></i> Delete</button>
                                                                        @endcan
                                                                     
                                        
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                            <td colspan="5">
                                                                <span class="text-danger">
                                                                    <strong>No video reviews found!</strong>
                                                                </span>
                                                            </td>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                                {{ $youtube->links() }}
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