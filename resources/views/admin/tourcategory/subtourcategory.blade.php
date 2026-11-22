@extends('admin.layouts.app')
@section('web_page_title', 'Edit sub tour category')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Submenus of {{ $tourcategories->title }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('menu.index') }}">Menu</a></li>
                            <li class="breadcrumb-item active">Submenus of {{ $tourcategories->title }}</li>
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
                            @can('create-tourcategory')
                                <div class="col-sm-auto">
                                    <div class="text-sm-end">
                                        <a href="{{ route('tourcategory.create') }}" class="btn btn-success btn-rounded">
                                            <i class="mdi mdi-plus me-1"></i> Add New tour category
                                        </a>
                                    </div>
                                </div>
                            @endcan
                        </div>
                        <!-- end row -->

                        <div class="table-responsive">
                            @include('admin.layouts.message')
                            <table class="table project-list-table align-middle table-nowrap dt-responsive nowrap w-100 table-borderless" id="projectList-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Name</th> 
                                        <th>Actions</th>  
                                    </tr>
                                </thead>
                                <tbody> 
                                @foreach($tourcategories->childrenRecursive as $tourcategory)
                                    <tr>
                                        <td>{{ $tourcategory->id }}</td>
                                        <td><img src="{{ asset('storage/' . $tourcategory->image) }}" alt="{{ $tourcategory->name  }}"  width="100"></td> 
                                        <td>{{ $tourcategory->name  }}</td>   
                                        <td>
                                            <a href="{{ route('tourcategory.edit', $tourcategory->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('tourcategory.destroy', $tourcategory->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                @if ($tourcategory->childrenRecursive->count() > 0)
                                                <a href="{{ route('subtourcategory.index', $tourcategory->id) }}" class="btn btn-sm btn-info">View Subsubtourcategory</a>

                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table> 
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