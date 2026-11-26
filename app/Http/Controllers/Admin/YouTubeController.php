<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\YouTubeData;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class YouTubeController extends Controller
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
        return view('admin.youtube.index', [
            'youtube' => YouTubeData::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    { 
        return view('admin.youtube.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'youtube_link' => 'required|url',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        YouTubeData::create([
            'title' => $validated['title'],
            'youtube_link' => $validated['youtube_link'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('youtube.index')->with('success', 'New YouTube Slide has been added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(YouTubeData $youtube): View
    { 
        return view('admin.youtube.edit', compact('youtube'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, YouTubeData $youtube): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'youtube_link' => 'required|url',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $youtube->update($validated);

        return redirect()->route('youtube.index')->with('success', 'YouTube slide updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(YouTubeData $youtube): RedirectResponse
    {
      
        $youtube->delete();

        return redirect()->route('youtube.index')
            ->withSuccess('Youtube Data  is deleted successfully.');
    } 


}
