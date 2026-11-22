<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\DestinationCategory;
use App\Models\Destination;
use App\Http\Requests\StoreDestinationRequest;
use App\Http\Requests\UpdateDestinationRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    /**
     * Instantiate a new DestinationController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-destination|create-destination|edit-destination|delete-destination', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-destination', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-destination', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-destination', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.destination.index', [
            'destinations' => Destination::with(['categories'])->latest()->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    { 
        $destinationcategories = DestinationCategory::all();
        return view('admin.destination.create', compact('destinationcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDestinationRequest $request): RedirectResponse
    {     
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image', 'banner_footer_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) { 
                // Store new image
                $data[$image] = $request->file($image)->store('destination', 'public');
            }
        }
        if ($request->hasFile('additional_images')) {
            $additionalImages = [];
            foreach ($request->file('additional_images') as $file) {
                $additionalImages[] = $file->store('destinationgallery', 'public');
            }
            $data['gallery'] = json_encode($additionalImages);
        }
        $destination = Destination::create($data); 
        $destination->categories()->sync($request->input('category_ids', []));

        return redirect()->back() 
            ->withSuccess('New Destination  is added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Destination $destination): View
    { 
        $destinationcategories = DestinationCategory::all();
        $selectedCategories = $destination->categories->pluck('id')->toArray();

        return view('admin.destination.edit', compact('destination', 'destinationcategories', 'selectedCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDestinationRequest $request, Destination $destination): RedirectResponse
    {     
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image', 'banner_footer_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                // Delete old image if exists
                if (!empty($destination->$image)) {
                    \Storage::disk('public')->delete($destination->$image);
                }
        
                // Store new image
                $data[$image] = $request->file($image)->store('destination', 'public');
            }
        }
    $existingImages = is_string($destination->gallery) ? json_decode($destination->gallery, true) : ($destination->gallery ?? []);
 
            if ($request->has('delete_images')) {
                foreach ($request->delete_images as $deleteImage) {
                    \Storage::disk('public')->delete($deleteImage);
                    $existingImages = array_diff($existingImages, [$deleteImage]); // Remove from array
                }
            }

            // Add new images
            if ($request->hasFile('additional_images')) {
                foreach ($request->file('additional_images') as $file) {
                    $existingImages[] = $file->store('destinationgallery', 'public');
                }
            }

            $data['gallery'] = json_encode(array_values($existingImages));

        $destination->update($data);
        $destination->categories()->sync($request->input('category_ids', []));

        return redirect()->back()->withSuccess('Destination  updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destination $destination): RedirectResponse
    {
        $images = ['image', 'page_bg_image', 'banner_image', 'banner_footer_image'];

        foreach ($images as $image) {
            if (!empty($destination->$image)) {
                \Storage::disk('public')->delete($destination->$image);
            }
        }
        if (!empty($destination->gallery)) { 
            $galleryImages = json_decode($destination->gallery, true);  
            
            if (is_array($galleryImages)) {
                foreach ($galleryImages as $galleryImage) {
                    $galleryImage = str_replace('\\/', '/', $galleryImage);  
    
                    if (Storage::disk('public')->exists($galleryImage)) {
                        Storage::disk('public')->delete($galleryImage);
                    }
                }
            }
        }
    
        $destination->delete();

        return redirect()->route('destination.index')
            ->withSuccess('Destination  is deleted successfully.');
    } 


}
