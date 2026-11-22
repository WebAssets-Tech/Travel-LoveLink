@extends('admin.layouts.app')
@section('web_page_title', 'View Menu')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Menu List</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                            <li class="breadcrumb-item active">Menu List</li>
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
                            @can('create-menu')
                                <div class="col-sm-auto">
                                    <div class="text-sm-end">
                                        <a href="{{ route('menu.create') }}" class="btn btn-success btn-rounded">
                                            <i class="mdi mdi-plus me-1"></i> Add New Menu
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
                                        <th>Menu Name</th>
                                        <th>Route</th>
                                        <th>Actions</th>  
                                    </tr>
                                </thead>
                                <tbody> 
                                @foreach($menus as $menu)
                                    <tr>
                                        <td>{{ $menu->id }}</td>
                                        <td>{{ $menu->title }}</td>
                                        <td>{{ $menu->link ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                            @if ($menu->childrenRecursive->count() > 0)
                                                <a href="{{ route('submenu.index', $menu->id) }}" class="btn btn-sm btn-info">View Submenu</a>
                                            @endif 
                                        </td>
                                    </tr>
 

                                @endforeach

                                </tbody>
                            </table>
                            {{ $menus->links() }}
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