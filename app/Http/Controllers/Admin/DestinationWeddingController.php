<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\DestinationWedding;
use App\Http\Requests\StoreDestinationWeddingRequest;
use App\Http\Requests\UpdateDestinationWeddingRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class DestinationWeddingController extends Controller
{
    /**
     * Instantiate a new DestinationWeddingController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-destinationwedding|create-destinationwedding|edit-destinationwedding|delete-destinationwedding', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-destinationwedding', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-destinationwedding', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-destinationwedding', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.destinationwedding.index', [
            'destinationweddings' => DestinationWedding::latest()->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    { 
        return view('admin.destinationwedding.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDestinationWeddingRequest $request): RedirectResponse
    {     
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) { 
                // Store new image
                $data[$image] = $request->file($image)->store('destinationwedding', 'public');
            }
        }
        if ($request->hasFile('additional_images')) {
            $additionalImages = [];
            foreach ($request->file('additional_images') as $file) {
                $additionalImages[] = $file->store('destinationwedding/gallery', 'public');
            }
            $data['gallery'] = json_encode($additionalImages);
        }
        DestinationWedding::create($data); 

        return redirect()->back() 
            ->withSuccess('New Destination Wedding is added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DestinationWedding $destinationwedding): View
    { 
        return view('admin.destinationwedding.edit', compact('destinationwedding'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDestinationWeddingRequest $request, DestinationWedding $destinationwedding): RedirectResponse
    {     
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                // Delete old image if exists
                if (!empty($destinationwedding->$image)) {
                    \Storage::disk('public')->delete($destinationwedding->$image);
                }
        
                // Store new image
                $data[$image] = $request->file($image)->store('destinationwedding', 'public');
            }
        }
    $existingImages = is_string($destinationwedding->gallery) ? json_decode($destinationwedding->gallery, true) : ($destinationwedding->gallery ?? []);
 
            if ($request->has('delete_images')) {
                foreach ($request->delete_images as $deleteImage) {
                    \Storage::disk('public')->delete($deleteImage);
                    $existingImages = array_diff($existingImages, [$deleteImage]); // Remove from array
                }
            }

            // Add new images
            if ($request->hasFile('additional_images')) {
                foreach ($request->file('additional_images') as $file) {
                    $existingImages[] = $file->store('destinationwedding/gallery', 'public');
                }
            }

            $data['gallery'] = json_encode(array_values($existingImages));

        $destinationwedding->update($data);

        return redirect()->back()->withSuccess('Destination Wedding updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestinationWedding $destinationwedding): RedirectResponse
    {
        $images = ['image', 'page_bg_image', 'banner_image'];

        foreach ($images as $image) {
            if (!empty($destinationwedding->$image)) {
                \Storage::disk('public')->delete($destinationwedding->$image);
            }
        }
        if (!empty($destinationwedding->gallery)) { 
            $galleryImages = json_decode($destinationwedding->gallery, true);  
            
            if (is_array($galleryImages)) {
                foreach ($galleryImages as $galleryImage) {
                    $galleryImage = str_replace('\\/', '/', $galleryImage);  
    
                    if (Storage::disk('public')->exists($galleryImage)) {
                        Storage::disk('public')->delete($galleryImage);
                    }
                }
            }
        }
    
        $destinationwedding->delete();

        return redirect()->route('destinationwedding.index')
            ->withSuccess('Destination Wedding is deleted successfully.');
    } 


}
