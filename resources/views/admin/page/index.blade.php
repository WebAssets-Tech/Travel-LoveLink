@extends('admin.layouts.app') 
@section('web_page_title', 'Service & Policy Pages')
@section('content')

                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0 font-size-18">Service &amp; Policy Pages</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Pages</li>
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
                                        <div class="row mb-2 align-items-center">
                                            <div class="col-sm-7">
                                                <p class="text-muted mb-0">Manages service landing pages (Trains, Flights, Gandola, Helicopter, etc.) and legal pages (Privacy Policy, Terms).</p>
                                            </div>
                                            @canany(['create-page', 'create-blog'])
                                            <div class="col-sm-5">
                                                <div class="text-sm-end">
                                                    <a href="{{ route('page.create') }}" class="btn btn-success btn-rounded" id="addProject-btn"><i class="mdi mdi-plus me-1"></i> Add New Page</a>
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
                                                            <th scope="col">Slug</th>  
                                                            <th scope="col">Action</th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($pages as $page)
                                                        <tr>
                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                            <td>{{ $page->title  }}</td>  
                                                            <td>{{ $page->slug  }}</td>  
                                                             
                                                            <td>
                                                                <form action="{{ route('page.destroy', $page->id) }}" method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                        
                                                                     
                                                                        @can('edit-page')
                                                                            <a href="{{ route('page.edit', $page->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>   
                                                                        @endcan
                                        
                                                                        @can('delete-page') 
                                                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this?');"><i class="bi bi-trash"></i> Delete</button>
                                                                        @endcan
                                                                     
                                        
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                            <td colspan="3">
                                                                <span class="text-danger">
                                                                    <strong>No page Found!</strong>
                                                                </span>
                                                            </td>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                                {{ $pages->links() }}
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