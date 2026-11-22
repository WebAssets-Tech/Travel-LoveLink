<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\TourCategory;
use App\Http\Requests\StoreTourCategoryRequest;
use App\Http\Requests\UpdateTourCategoryRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class TourCategoryController extends Controller
{
    /**
     * Instantiate a new TourCategoryController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-tourcategory|create-tourcategory|edit-tourcategory|delete-tourcategory', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-tourcategory', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-tourcategory', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-tourcategory', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.tourcategory.index', [
            'tourcategories' => TourCategory::whereNull('parent_id')->with('childrenRecursive')->latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {   
        $tourcategories = TourCategory::all();
        return view('admin.tourcategory.create',compact('tourcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTourCategoryRequest $request): RedirectResponse
    {    
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image', 'banner_footer_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) { 
                // Store new image
                $data[$image] = $request->file($image)->store('tourcategory', 'public');
            }
        }
        if ($request->hasFile('additional_images')) {
            $additionalImages = [];
            foreach ($request->file('additional_images') as $file) {
                $additionalImages[] = $file->store('tourcategorygallery', 'public');
            }
            $data['gallery'] = json_encode($additionalImages);
        }
        TourCategory::create($data); 

        return redirect()->back() 
            ->withSuccess('New tour category  is added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TourCategory $tourcategory): View
    { 
        $tourcategories = TourCategory::all();
        return view('admin.tourcategory.edit', compact('tourcategory','tourcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTourCategoryRequest $request, TourCategory $tourcategory): RedirectResponse
    {     
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image', 'banner_footer_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                // Delete old image if exists
                if (!empty($tourcategory->$image)) {
                    \Storage::disk('public')->delete($tourcategory->$image);
                }
        
                // Store new image
                $data[$image] = $request->file($image)->store('tourcategory', 'public');
            }
        }
            $existingImages = json_decode($tourcategory->gallery, true) ?? [];
 
            if ($request->has('delete_images')) {
                foreach ($request->delete_images as $deleteImage) {
                    \Storage::disk('public')->delete($deleteImage);
                    $existingImages = array_diff($existingImages, [$deleteImage]); // Remove from array
                }
            }

            // Add new images
            if ($request->hasFile('additional_images')) {
                foreach ($request->file('additional_images') as $file) {
                    $existingImages[] = $file->store('tourcategorygallery', 'public');
                }
            }

            $data['gallery'] = json_encode(array_values($existingImages));

        $tourcategory->update($data);

        return redirect()->back()->withSuccess('tour category  updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TourCategory $tourcategory): RedirectResponse
    {
        $images = ['image', 'page_bg_image', 'banner_image', 'banner_footer_image'];

        foreach ($images as $image) {
            if (!empty($tourcategory->$image)) {
                \Storage::disk('public')->delete($tourcategory->$image);
            }
        }
        if (!empty($tourcategory->gallery)) { 
            $galleryImages = json_decode($tourcategory->gallery, true);  
            
            if (is_array($galleryImages)) {
                foreach ($galleryImages as $galleryImage) {
                    $galleryImage = str_replace('\\/', '/', $galleryImage);  
    
                    if (Storage::disk('public')->exists($galleryImage)) {
                        Storage::disk('public')->delete($galleryImage);
                    }
                }
            }
        }
    
        $tourcategory->delete();

        return redirect()->route('tourcategory.index')
            ->withSuccess('tour category  is deleted successfully.');
    } 

    public function subtourcategory($parent_id)
    {
        $tourcategories = TourCategory::with('childrenRecursive')->findOrFail($parent_id);
        
        return view('admin.tourcategory.subtourcategory', compact('tourcategories'));
    }

}
