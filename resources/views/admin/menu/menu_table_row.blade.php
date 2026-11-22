<tr>
    <td>{{ $menu->id }}</td>
    <td>
        {!! str_repeat('&mdash; ', $level) !!} {{ $menu->title }}
    </td>
    <td>{{ $menu->route ?? 'N/A' }}</td>
    <td><i class="{{ $menu->icon }}"></i></td>
    <td>{{ $menu->parent ? $menu->parent->title : 'Root' }}</td>
    <td>
        <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-sm btn-primary">Edit</a>
        <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
        </form>
        <a href="{{ route('submenu.index', ['parent_id' => $menu->id]) }}" class="btn btn-sm btn-info">View Submenus</a>
    </td>
</tr>

@foreach($menu->childrenRecursive as $child)
    @include('menu.menu_table_row', ['menu' => $child, 'level' => $level + 1])
@endforeach
