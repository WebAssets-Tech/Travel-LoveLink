@extends('admin.layouts.app')
@section('web_page_title', 'View Houseboats')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Houseboat List</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Houseboats</a></li>
                            <li class="breadcrumb-item active">Houseboat List</li>
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
                                <p class="text-muted mb-0">
                                    Frontend listing link: <a href="{{ route('home.houseboats') }}" target="_blank">{{ url('/houseboats') }}</a>
                                </p>
                            </div>
                            @can('create-houseboat')
                            <div class="col-sm-5">
                                <div class="text-sm-end">
                                    <a href="{{ route('houseboat.create') }}" class="btn btn-success btn-rounded" id="addProject-btn">
                                        <i class="mdi mdi-plus me-1"></i> Add New Houseboat
                                    </a>
                                </div>
                            </div>
                            @endcan
                        </div>

                        <div class="table-responsive">
                            @include('admin.layouts.message')
                            <table class="table project-list-table align-middle table-nowrap dt-responsive nowrap w-100 table-borderless" id="projectList-table">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($houseboats as $houseboat)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            @if(!empty($houseboat->image))
                                                <img src="{{ asset('storage/' . $houseboat->image) }}" alt="{{ $houseboat->name }}" width="100" class="rounded">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td>{{ $houseboat->name }}</td>
                                        <td>{{ $houseboat->location ?? '—' }}</td>
                                        <td>{{ $houseboat->category ?? '—' }}</td>
                                        <td>
                                            <span class="badge {{ $houseboat->status ? 'bg-success' : 'bg-danger' }}">
                                                {{ $houseboat->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <form action="{{ route('houseboat.destroy', $houseboat->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')

                                                <a href="{{ route('home.houseboatdetails', $houseboat->slug) }}" target="_blank" class="btn btn-info btn-sm">
                                                    <i class="bi bi-eye"></i> View
                                                </a>

                                                @can('edit-houseboat')
                                                    <a href="{{ route('houseboat.edit', $houseboat->id) }}" class="btn btn-primary btn-sm">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>
                                                @endcan

                                                @can('delete-houseboat')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this houseboat?');">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </button>
                                                @endcan
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-danger">
                                            <strong>No Houseboat Found!</strong>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $houseboats->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
