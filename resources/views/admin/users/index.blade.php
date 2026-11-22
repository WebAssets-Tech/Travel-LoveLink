@extends('admin.layouts.app') 
@section('web_page_title', 'View Users')
@section('content')

                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0 font-size-18">Users List</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                                            <li class="breadcrumb-item active">Users List</li>
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
                                             <div class="col-sm-4">
                                                <div class="search-box me-2 mb-2 d-inline-block">
                                                        <form method="GET"  id="search-form" action="{{ route('users.index') }}">
                                                            <div class="position-relative">
                                                                    <input type="text"  name="search" class="form-control" id="searchTableList" placeholder="Search...">
                                                                    <i class="bx bx-search-alt search-icon"  style="cursor: pointer;" onclick="document.getElementById('search-form').submit();" ></i>
                                                            </div> 
                                                        </form>
                                                </div>
                                            </div>
                                            @can('create-user')
                                            <div class="col-sm-8">
                                                <div class="text-sm-end">
                                                    <a href="{{ route('users.create') }}" class="btn btn-success btn-rounded" id="addProject-btn"><i class="mdi mdi-plus me-1"></i> Add New User</a>
                                                </div>
                                            </div><!-- end col-->
                                            @endcan
                                              
                                        </div>
                                        <!-- end row -->
                                        <div class="">
                                            <div class="table-responsive">
                                                @include('admin.layouts.message')
                                                <table class="table project-list-table align-middle table-nowrap dt-responsive nowrap w-100 table-borderless" id="projectList-table">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th scope="col" style="width: 60px">#</th> 
                                                            <th scope="col">Name</th> 
                                                            <th scope="col">Email</th>
                                                            <th scope="col">Mobile</th>
                                                            <th scope="col">Roles</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($users as $user)
                                                            <tr>
                                                                <th scope="row">{{ $loop->iteration }}</th> 
                                                                <td>{{ $user->name }}</td>
                                                                <td>{{ $user->email }}</td>
                                                                <td>{{ $user->phone  }}</td>
                                                                <td>
                                                                    <ul>
                                                                        @forelse ($user->getRoleNames() as $role)
                                                                            <li>{{ $role }}</li>
                                                                        @empty
                                                                        @endforelse
                                                                    </ul>
                                                                </td>
                                                                <td>@if($user->status == 1) Active @endif  @if($user->status == 0) Inactive @endif </td> 
                                                                <td>
                                                                    <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                                                        @csrf
                                                                        @method('DELETE')
                                            
                                                                        @if (in_array('Super Admin', $user->getRoleNames()->toArray() ?? []) )
                                                                            @if (Auth::user()->hasRole('Super Admin'))
                                                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                                                            @endif
                                                                        @else
                                                                            @can('edit-user')
                                                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>   
                                                                            @endcan
                                            
                                                                            @can('delete-user')
                                                                                @if (Auth::user()->id!=$user->id)
                                                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this user?');"><i class="bi bi-trash"></i> Delete</button>
                                                                                @endif
                                                                            @endcan
                                                                        @endif
                                            
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            @empty
                                                                <td colspan="5">
                                                                    <span class="text-danger">
                                                                        <strong>No User Found!</strong>
                                                                    </span>
                                                                </td>
                                                            @endforelse
                                                    </tbody>
                                                </table>
                                                {{ $users->links() }}
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