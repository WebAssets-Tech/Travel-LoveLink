<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Gallery;
use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Instantiate a new GalleryController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-gallery|create-gallery|edit-gallery|delete-gallery', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-gallery', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-gallery', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-gallery', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.gallery.index', [
            'galleries' => Gallery::latest()->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    { 
        return view('admin.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGalleryRequest $request): RedirectResponse
    { 
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['file'] = $request->file('image')->store('gallery', 'public');
        }

        Gallery::create($data); 

        return redirect()->back() 
            ->withSuccess('New gallery is added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery): View
    { 
        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($gallery->file) {
                \Storage::disk('public')->delete($gallery->file);
            }
    
            $imagePath = $request->file('image')->store('gallery', 'public');
            $data['file'] = $imagePath;
        }

        $gallery->update($data);

        return redirect()->back()->withSuccess('gallery updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery): RedirectResponse
    {
        if ($gallery->file) {
            \Storage::disk('public')->delete($gallery->file);
        }
        $gallery->delete();

        return redirect()->route('gallery.index')
            ->withSuccess('gallery is deleted successfully.');
    } 


}
