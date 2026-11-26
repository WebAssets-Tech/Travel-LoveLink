<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Menu;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MenuController extends Controller
{
    /**
     * Instantiate a new MenuController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-menu|create-menu|edit-menu|delete-menu', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-menu', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-menu', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-menu', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.menu.index', [
            'menus' => Menu::whereNull('parent_id')->with('childrenRecursive')->orderBy('order')->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $menus = Menu::all();
        return view('admin.menu.create',compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuRequest $request): RedirectResponse
    {
        Menu::create($request->validated());
        \Illuminate\Support\Facades\Cache::forget('global_layout_shared_data');

        return redirect()->back() 
            ->withSuccess('New Menu is added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu): View
    {
        $menus = Menu::all();
        return view('admin.menu.edit', compact('menu','menus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuRequest $request, Menu $menu): RedirectResponse
    {
        $menu->update($request->validated());
        \Illuminate\Support\Facades\Cache::forget('global_layout_shared_data');

        return redirect()->back()->withSuccess('Menu updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu): RedirectResponse
    {
        $menu->delete();
        \Illuminate\Support\Facades\Cache::forget('global_layout_shared_data');

        return redirect()->route('menu.index')
            ->withSuccess('Menu is deleted successfully.');
    }
    public function getSubmenus(Menu $menu)
    {
        $submenus = $menu->childrenRecursive;

        return response()->json($submenus->map(function ($submenu) {
            return [
                'id'          => $submenu->id,
                'title'       => $submenu->title,
                'link'       => $submenu->link, 
                'order'       => $submenu->order,
                'type'       => $submenu->type, 
                'status'       => $submenu->status, 
                'parent_name' => $submenu->parent->title ?? 'N/A',
            ];
        }));
    }

    public function submenus($parent_id)
    {
        $menu = Menu::with('childrenRecursive')->findOrFail($parent_id);
        
        return view('admin.menu.submenus', compact('menu'));
    }


}

