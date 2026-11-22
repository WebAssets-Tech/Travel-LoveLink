<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Hotel;
use App\Http\Requests\StoreHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    /**
     * Instantiate a new HotelController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-hotel|create-hotel|edit-hotel|delete-hotel', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-hotel', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-hotel', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-hotel', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.hotel.index', [
            'hotels' => Hotel::latest()->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    { 
        return view('admin.hotel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHotelRequest $request): RedirectResponse
    {     
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image', 'banner_footer_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) { 
                // Store new image
                $data[$image] = $request->file($image)->store('hotel', 'public');
            }
        }
        if ($request->hasFile('additional_images')) {
            $additionalImages = [];
            foreach ($request->file('additional_images') as $file) {
                $additionalImages[] = $file->store('hotel/gallery', 'public');
            }
            $data['gallery'] = json_encode($additionalImages);
        }
        Hotel::create($data); 

        return redirect()->back() 
            ->withSuccess('New hotel is added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel): View
    { 
        return view('admin.hotel.edit', compact('hotel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHotelRequest $request, Hotel $hotel): RedirectResponse
    {     
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image', 'banner_footer_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                // Delete old image if exists
                if (!empty($hotel->$image)) {
                    \Storage::disk('public')->delete($hotel->$image);
                }
        
                // Store new image
                $data[$image] = $request->file($image)->store('hotel', 'public');
            }
        }
    $existingImages = is_string($hotel->gallery) ? json_decode($hotel->gallery, true) : ($hotel->gallery ?? []);
 
            if ($request->has('delete_images')) {
                foreach ($request->delete_images as $deleteImage) {
                    \Storage::disk('public')->delete($deleteImage);
                    $existingImages = array_diff($existingImages, [$deleteImage]); // Remove from array
                }
            }

            // Add new images
            if ($request->hasFile('additional_images')) {
                foreach ($request->file('additional_images') as $file) {
                    $existingImages[] = $file->store('hotel/gallery', 'public');
                }
            }

            $data['gallery'] = json_encode(array_values($existingImages));

        $hotel->update($data);

        return redirect()->back()->withSuccess('hotel updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel): RedirectResponse
    {
        $images = ['image', 'page_bg_image', 'banner_image', 'banner_footer_image'];

        foreach ($images as $image) {
            if (!empty($hotel->$image)) {
                \Storage::disk('public')->delete($hotel->$image);
            }
        }
        if (!empty($hotel->gallery)) { 
            $galleryImages = json_decode($hotel->gallery, true);  
            
            if (is_array($galleryImages)) {
                foreach ($galleryImages as $galleryImage) {
                    $galleryImage = str_replace('\\/', '/', $galleryImage);  
    
                    if (Storage::disk('public')->exists($galleryImage)) {
                        Storage::disk('public')->delete($galleryImage);
                    }
                }
            }
        }
    
        $hotel->delete();

        return redirect()->route('hotel.index')
            ->withSuccess('hotel  is deleted successfully.');
    } 


}
