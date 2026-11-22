{{-- resources/views/admin/state/index.blade.php --}}
@extends('admin.layouts.app')
@section('web_page_title', 'View States')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">State List</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">States</a></li>
                            <li class="breadcrumb-item active">State List</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            @can('create-state')
                            <div class="col-sm-12">
                                <div class="text-sm-end">
                                    <a href="{{ route('state.create') }}" class="btn btn-success btn-rounded"><i class="mdi mdi-plus me-1"></i> Add New State</a>
                                </div>
                            </div>
                            @endcan
                        </div>

                        <div class="table-responsive">
                            @include('admin.layouts.message')
                            <table class="table project-list-table align-middle table-nowrap dt-responsive nowrap w-100 table-borderless">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Country</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($states as $state)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $state->name }}</td>
                                        <td>{{ $state->code }}</td>
                                        <td>{{ $state->country->name ?? '-' }}</td>
                                        <td>
                                            <span class="badge badge-soft-{{ $state->status ? 'success' : 'danger' }}">
                                                {{ $state->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <form action="{{ route('state.destroy', $state->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                @can('edit-state')
                                                    <a href="{{ route('state.edit', $state->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                                @endcan
                                                @can('delete-state')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this?');"><i class="bi bi-trash"></i> Delete</button>
                                                @endcan
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6">
                                            <span class="text-danger"><strong>No state found!</strong></span>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $states->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection