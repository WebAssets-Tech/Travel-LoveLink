{{-- resources/views/admin/country/index.blade.php --}}
@extends('admin.layouts.app')
@section('web_page_title', 'View Countries')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Country List</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Countries</a></li>
                            <li class="breadcrumb-item active">Country List</li>
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
                            @can('create-country')
                            <div class="col-sm-12">
                                <div class="text-sm-end">
                                    <a href="{{ route('country.create') }}" class="btn btn-success btn-rounded"><i class="mdi mdi-plus me-1"></i> Add New Country</a>
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
                                        <th scope="col">Image</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">States</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($countries as $country)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            @if($country->image)
                                                <img src="{{ asset('storage/' . $country->image) }}" alt="{{ $country->name }}" width="60">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $country->name }}</td>
                                        <td>{{ $country->code }}</td>
                                        <td>{{ $country->states_count }}</td>
                                        <td>
                                            <span class="badge badge-soft-{{ $country->status ? 'success' : 'danger' }}">
                                                {{ $country->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <form action="{{ route('country.destroy', $country->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                @can('edit-country')
                                                    <a href="{{ route('country.edit', $country->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                                @endcan
                                                @can('delete-country')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this?');"><i class="bi bi-trash"></i> Delete</button>
                                                @endcan
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7">
                                            <span class="text-danger"><strong>No country found!</strong></span>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $countries->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection