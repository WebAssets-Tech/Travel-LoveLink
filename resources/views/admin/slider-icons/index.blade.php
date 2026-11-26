@extends('admin.layouts.app') 
@section('web_page_title', 'Header Quick Icons')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Header Quick Icons</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Header Quick Icons</li>
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
                                <p class="text-muted mb-0">Controls the floating header icon menu bar (Packages, Hotels, Cabs, Trains, Flights, Adventure, Gandola, Helicopter).</p>
                            </div>
                            @canany(['create-slider-icon', 'create-slidericon', 'create-blog'])
                            <div class="col-sm-5">
                                <div class="text-sm-end">
                                    <a href="{{ route('slidericon.create') }}" class="btn btn-success btn-rounded" id="addProject-btn">
                                        <i class="mdi mdi-plus me-1"></i> Add Header Icon
                                    </a>
                                </div>
                            </div>
                            @endcanany
                        </div> 
                        <!-- end row -->

                        <div class="table-responsive">
                            @include('admin.layouts.message')
                            <table class="table table-bordered table-hover align-middle table-nowrap w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>  
                                        <th>Title</th> 
                                        <th>Image</th>  
                                        <th>Status</th>  
                                        <th>Action</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($slidericon as $slide)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $slide->title }}</td> 
                                            <td>
                                                @if($slide->image)
                                                    <img src="{{ asset('storage/' . $slide->image) }}" alt="{{ $slide->title }}" width="80" height="50">
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge {{ $slide->status ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $slide->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    @can('edit-slider-icon')
                                                        <a href="{{ route('slidericon.edit', $slide->id) }}" class="btn btn-primary btn-sm">
                                                            <i class="bi bi-pencil-square"></i> Edit
                                                        </a>
                                                    @endcan
                                                    @can('delete-slider-icon')
                                                        <form action="{{ route('slidericon.destroy', $slide->id) }}" method="POST" onsubmit="return confirm('Do you want to delete this?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="bi bi-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-danger">
                                                <strong>No Slider Icons Found!</strong>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $slidericon->links() }}
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
