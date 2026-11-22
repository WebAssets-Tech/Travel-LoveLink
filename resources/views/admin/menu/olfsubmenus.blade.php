@extends('layouts.app')
@section('web_page_title', 'Edit Menu')@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Submenus of {{ $menu->title }}</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Menu Name</th>
                <th>Route</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menu->childrenRecursive as $submenu)
                <tr>
                    <td>{{ $submenu->id }}</td>
                    <td>{{ $submenu->title }}</td>
                    <td>{{ $submenu->route ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('menu.edit', $submenu->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('menu.destroy', $submenu->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
