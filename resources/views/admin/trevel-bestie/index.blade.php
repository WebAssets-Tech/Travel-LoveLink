@extends('admin.layouts.app') 
@section('web_page_title', 'Why Choose Us (Travel Bestie)')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Why Choose Us (Travel Bestie)</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Why Choose Us</li>
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
                                <p class="text-muted mb-0">Controls the <strong>Reasons To Make Us Your Travel Bestie</strong> cards on the homepage.</p>
                            </div>
                            @canany(['create-slider-icon', 'create-travel-bestie', 'create-blog'])
                            <div class="col-sm-5">
                                <div class="text-sm-end">
                                    <a href="{{ route('travel-bestie.create') }}" class="btn btn-success btn-rounded" id="addProject-btn">
                                        <i class="mdi mdi-plus me-1"></i> Add Reason Card
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
                                    @forelse ($travelBestie as $trevel)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $trevel->title }}</td> 
                                            <td>
                                                @if($trevel->image)
                                                    <img src="{{ asset('storage/' . $trevel->image) }}" alt="{{ $trevel->title }}" width="80" height="50">
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge {{ $trevel->status ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $trevel->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    @can('edit-slider-icon')
                                                        <a href="{{ route('travel-bestie.edit', $trevel->id) }}" class="btn btn-primary btn-sm">
                                                            <i class="bi bi-pencil-square"></i> Edit
                                                        </a>
                                                    @endcan
                                                    @can('delete-slider-icon')
                                                        <form action="{{ route('travel-bestie.destroy', $trevel->id) }}" method="POST" onsubmit="return confirm('Do you want to delete this?');">
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
                                                <strong>No items found!</strong>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $travelBestie->links() }}
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
