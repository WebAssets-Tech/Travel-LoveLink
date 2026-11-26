<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\SliderIcon;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class SliderIconController extends Controller
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
        return view('admin.slider-icons.index', [
            'slidericon' => SliderIcon::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    { 
        return view('admin.slider-icons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:2048', 
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('slider_icons', 'public'); 
            $validated['image'] = $path;
        }

        SliderIcon::create($validated);
        \Illuminate\Support\Facades\Cache::forget('global_layout_shared_data');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data');

        return redirect()->route('slidericon.index')
                        ->with('success', 'New Header Icon has been added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SliderIcon $slidericon): View
    { 
        return view('admin.slider-icons.edit', compact('slidericon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SliderIcon $slidericon): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($slidericon->image && Storage::exists($slidericon->image)) {
                Storage::delete($slidericon->image);
            }

            $path = $request->file('image')->store('slider_icons', 'public');
            $validated['image'] = $path;
        }

        $slidericon->update($validated);
        \Illuminate\Support\Facades\Cache::forget('global_layout_shared_data');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data');

        return redirect()->route('slidericon.index')
            ->with('success', 'Header Icon updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SliderIcon $slidericon): RedirectResponse
    {

            if (!empty($slidericon->image)) {
                \Storage::disk('public')->delete($slidericon->image);
            }
    
        $slidericon->delete();
        \Illuminate\Support\Facades\Cache::forget('global_layout_shared_data');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data');

        return redirect()->route('slidericon.index')
            ->withSuccess('Header Icon deleted successfully.');
    } 


}
