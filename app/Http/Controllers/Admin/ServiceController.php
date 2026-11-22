<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Service;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Instantiate a new ServiceController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-service|create-service|edit-service|delete-service', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-service', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-service', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-service', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.service.index', [
            'services' => Service::latest()->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    { 
        return view('admin.service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request): RedirectResponse
    {      
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image', 'banner_footer_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) { 
                // Store new image
                $data[$image] = $request->file($image)->store('service', 'public');
            }
        }
        if ($request->hasFile('additional_images')) {
            $additionalImages = [];
            foreach ($request->file('additional_images') as $file) {
                $additionalImages[] = $file->store('servicegallery', 'public');
            }
            $data['gallery'] = json_encode($additionalImages);
        }
        Service::create($data); 

        return redirect()->back() 
            ->withSuccess('New Service  is added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service): View
    { 
        return view('admin.service.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {     
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image', 'banner_footer_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                // Delete old image if exists
                if (!empty($service->$image)) {
                    \Storage::disk('public')->delete($service->$image);
                }
        
                // Store new image
                $data[$image] = $request->file($image)->store('service', 'public');
            }
        }
            $existingImages = is_array($service->gallery)     ? $service->gallery     : json_decode($service->gallery, true) ?? [];

 
            if ($request->has('delete_images')) {
                foreach ($request->delete_images as $deleteImage) {
                    \Storage::disk('public')->delete($deleteImage);
                    $existingImages = array_diff($existingImages, [$deleteImage]); // Remove from array
                }
            }

            // Add new images
            if ($request->hasFile('additional_images')) {
                foreach ($request->file('additional_images') as $file) {
                    $existingImages[] = $file->store('servicegallery', 'public');
                }
            }

            $data['gallery'] = json_encode(array_values($existingImages));

        $service->update($data);

        return redirect()->back()->withSuccess('Service  updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service): RedirectResponse
    {
        $images = ['image', 'page_bg_image', 'banner_image', 'banner_footer_image'];

        foreach ($images as $image) {
            if (!empty($service->$image)) {
                \Storage::disk('public')->delete($service->$image);
            }
        }
        if (!empty($service->gallery)) { 
            $galleryImages = json_decode($service->gallery, true);  
            
            if (is_array($galleryImages)) {
                foreach ($galleryImages as $galleryImage) {
                    $galleryImage = str_replace('\\/', '/', $galleryImage);  
    
                    if (Storage::disk('public')->exists($galleryImage)) {
                        Storage::disk('public')->delete($galleryImage);
                    }
                }
            }
        }
    
        $service->delete();

        return redirect()->route('service.index')
            ->withSuccess('Service  is deleted successfully.');
    } 


}
