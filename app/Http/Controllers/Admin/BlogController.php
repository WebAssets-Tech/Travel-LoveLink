<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
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
        return view('admin.blog.index', [
            'blogs' => Blog::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    { 
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request): RedirectResponse
    {      
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) { 
                // Store new image
                $data[$image] = $request->file($image)->store('blog', 'public');
            }
        } 
        if (!\Illuminate\Support\Facades\Schema::hasColumn('blogs', 'youtube_link')) {
            unset($data['youtube_link']);
        }
        Blog::create($data);

        return redirect()->back() 
            ->withSuccess('New Blog  is added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog): View
    { 
        return view('admin.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog): RedirectResponse
    {     
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                // Delete old image if exists
                if (!empty($blog->$image)) {
                    \Storage::disk('public')->delete($blog->$image);
                }
        
                // Store new image
                $data[$image] = $request->file($image)->store('blog', 'public');
            }
        } 
        if (!\Illuminate\Support\Facades\Schema::hasColumn('blogs', 'youtube_link')) {
            unset($data['youtube_link']);
        }
        $blog->update($data);

        return redirect()->back()->withSuccess('Blog  updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog): RedirectResponse
    {
        $images = ['image', 'page_bg_image', 'banner_image'];

        foreach ($images as $image) {
            if (!empty($blog->$image)) {
                \Storage::disk('public')->delete($blog->$image);
            }
        } 
    
        $blog->delete();

        return redirect()->route('blog.index')
            ->withSuccess('Destination  is deleted successfully.');
    } 


}
