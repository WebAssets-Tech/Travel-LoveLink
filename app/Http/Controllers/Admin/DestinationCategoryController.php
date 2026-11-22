<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\DestinationCategory;
use App\Http\Requests\StoreDestinationCategoryRequest;
use App\Http\Requests\UpdateDestinationCategoryRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class DestinationCategoryController extends Controller
{
    /**
     * Instantiate a new DestinationCategoryController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-destinationcategory|create-destinationcategory|edit-destinationcategory|delete-destinationcategory', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-destinationcategory', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-destinationcategory', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-destinationcategory', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.destinationcategory.index', [
            'destinationcategories' => DestinationCategory::whereNull('parent_id')->with('childrenRecursive')->latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {   
        $destinationcategories = DestinationCategory::all();
        return view('admin.destinationcategory.create',compact('destinationcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDestinationCategoryRequest $request): RedirectResponse
    {    
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image', 'banner_footer_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) { 
                // Store new image
                $data[$image] = $request->file($image)->store('destinationcategory', 'public');
            }
        }
        if ($request->hasFile('additional_images')) {
            $additionalImages = [];
            foreach ($request->file('additional_images') as $file) {
                $additionalImages[] = $file->store('destinationcategorygallery', 'public');
            }
            $data['gallery'] = json_encode($additionalImages);
        }
        DestinationCategory::create($data); 

        return redirect()->back() 
            ->withSuccess('New destination category  is added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DestinationCategory $destinationcategory): View
    { 
        $destinationcategories = DestinationCategory::all();
        return view('admin.destinationcategory.edit', compact('destinationcategory','destinationcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDestinationCategoryRequest $request, DestinationCategory $destinationcategory): RedirectResponse
    {     
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image', 'banner_footer_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                // Delete old image if exists
                if (!empty($destinationcategory->$image)) {
                    \Storage::disk('public')->delete($destinationcategory->$image);
                }
        
                // Store new image
                $data[$image] = $request->file($image)->store('destinationcategory', 'public');
            }
        }
            $existingImages = json_decode($destinationcategory->gallery, true) ?? [];
 
            if ($request->has('delete_images')) {
                foreach ($request->delete_images as $deleteImage) {
                    \Storage::disk('public')->delete($deleteImage);
                    $existingImages = array_diff($existingImages, [$deleteImage]); // Remove from array
                }
            }

            // Add new images
            if ($request->hasFile('additional_images')) {
                foreach ($request->file('additional_images') as $file) {
                    $existingImages[] = $file->store('destinationcategorygallery', 'public');
                }
            }

            $data['gallery'] = json_encode(array_values($existingImages));

        $destinationcategory->update($data);

        return redirect()->back()->withSuccess('destination category  updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestinationCategory $destinationcategory): RedirectResponse
    {
        $images = ['image', 'page_bg_image', 'banner_image', 'banner_footer_image'];

        foreach ($images as $image) {
            if (!empty($destinationcategory->$image)) {
                \Storage::disk('public')->delete($destinationcategory->$image);
            }
        }
        if (!empty($destinationcategory->gallery)) { 
            $galleryImages = json_decode($destinationcategory->gallery, true);  
            
            if (is_array($galleryImages)) {
                foreach ($galleryImages as $galleryImage) {
                    $galleryImage = str_replace('\\/', '/', $galleryImage);  
    
                    if (Storage::disk('public')->exists($galleryImage)) {
                        Storage::disk('public')->delete($galleryImage);
                    }
                }
            }
        }
    
        $destinationcategory->delete();

        return redirect()->route('destinationcategory.index')
            ->withSuccess('destination category  is deleted successfully.');
    } 

    public function subdestinationcategory($parent_id)
    {
        $destinationcategories = DestinationCategory::with('childrenRecursive')->findOrFail($parent_id);
        
        return view('admin.destinationcategory.subdestinationcategory', compact('destinationcategories'));
    }

}
