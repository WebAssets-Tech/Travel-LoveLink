<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\TravelBestie;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class TravelBestieController extends Controller
{
    /**
     * Instantiate a new BlogController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-blog|create-blog|edit-blog|delete-blog', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-blog', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-blog', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-blog', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.trevel-bestie.index', [
            'travelBestie' => TravelBestie::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    { 
        return view('admin.trevel-bestie.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:2048', 
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('treavel-bestie', 'public'); 
            $validated['image'] = $path;
        }

        TravelBestie::create($validated);

        return redirect()->route('travel-bestie.index')
                        ->with('success', 'New TravelBestie  has been added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TravelBestie $travelBestie): View
    { 
        return view('admin.trevel-bestie.edit', compact('travelBestie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TravelBestie $TravelBestie): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($TravelBestie->image && Storage::exists($TravelBestie->image)) {
                Storage::delete($TravelBestie->image);
            }

            $path = $request->file('image')->store('slider_icons', 'public');
            $validated['image'] = $path;
        }

        $TravelBestie->update($validated);

        return redirect()->route('travel-bestie.index')
            ->with('success', 'TravelBestie updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TravelBestie $TravelBestie): RedirectResponse
    {

            if (!empty($TravelBestie->image)) {
                \Storage::disk('public')->delete($TravelBestie->image);
            }
    
        $TravelBestie->delete();

        return redirect()->route('travel-bestie.index')
            ->withSuccess('TravelBestie  is deleted successfully.');
    } 


}
