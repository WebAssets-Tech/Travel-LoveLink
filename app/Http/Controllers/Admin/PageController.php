<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Page;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    /**
     * Instantiate a new PageController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-page|create-page|edit-page|delete-page', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-page', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-page', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-page', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.page.index', [
            'pages' => Page::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    { 
        return view('admin.page.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePageRequest $request): RedirectResponse
    {      
        $data = $request->validated();
        $images = [ 'page_bg_image', 'banner_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) { 
                // Store new image
                $data[$image] = $request->file($image)->store('page', 'public');
            }
        } 
        Page::create($data); 

        return redirect()->back() 
            ->withSuccess('New page  is added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page): View
    { 
        return view('admin.page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, Page $page): RedirectResponse
    {     
        $data = $request->validated();
        $images = [ 'page_bg_image', 'banner_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                // Delete old image if exists
                if (!empty($page->$image)) {
                    \Storage::disk('public')->delete($page->$image);
                }
        
                // Store new image
                $data[$image] = $request->file($image)->store('page', 'public');
            }
        } 
        $page->update($data);

        return redirect()->back()->withSuccess('page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page): RedirectResponse
    {
        $images = [ 'page_bg_image', 'banner_image'];

        foreach ($images as $image) {
            if (!empty($page->$image)) {
                \Storage::disk('public')->delete($page->$image);
            }
        } 
    
        $blog->delete();

        return redirect()->route('page.index')
            ->withSuccess('page is deleted successfully.');
    } 


}
