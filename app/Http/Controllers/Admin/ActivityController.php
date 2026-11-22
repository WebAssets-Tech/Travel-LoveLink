<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Activity;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    /**
     * Instantiate a new ActivityController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-activity|create-activity|edit-activity|delete-activity', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-activity', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-activity', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-activity', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.activity.index', [
            'activities' => Activity::latest()->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    { 
        return view('admin.activity.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActivityRequest $request): RedirectResponse
    {      
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) { 
                // Store new image
                $data[$image] = $request->file($image)->store('activity', 'public');
            }
        } 
        if ($request->hasFile('additional_images')) {
            $additionalImages = [];
            foreach ($request->file('additional_images') as $file) {
                $additionalImages[] = $file->store('activitygallery', 'public');
            }
            $data['gallery'] = json_encode($additionalImages);
        }
        Activity::create($data); 

        return redirect()->back() 
            ->withSuccess('New activity  is added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity): View
    { 
        return view('admin.activity.edit', compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActivityRequest $request, Activity $activity): RedirectResponse
    {     
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                // Delete old image if exists
                if (!empty($activity->$image)) {
                    \Storage::disk('public')->delete($activity->$image);
                }
        
                // Store new image
                $data[$image] = $request->file($image)->store('activity', 'public');
            }
        } 
        $existingImages = json_decode($activity->gallery, true) ?? [];

        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $deleteImage) {
                \Storage::disk('public')->delete($deleteImage);
                $existingImages = array_diff($existingImages, [$deleteImage]); // Remove from array
            }
        }

        // Add new images
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $file) {
                $existingImages[] = $file->store('activitygallery', 'public');
            }
        }

        $data['gallery'] = json_encode(array_values($existingImages));

        $activity->update($data);

        return redirect()->back()->withSuccess('Destination  updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity): RedirectResponse
    {
        $images = ['image', 'page_bg_image', 'banner_image'];

        foreach ($images as $image) {
            if (!empty($activity->$image)) {
                \Storage::disk('public')->delete($activity->$image);
            }
        } 
        if (!empty($activity->gallery)) { 
            $galleryImages = json_decode($activity->gallery, true);  
            
            if (is_array($galleryImages)) {
                foreach ($galleryImages as $galleryImage) {
                    $galleryImage = str_replace('\\/', '/', $galleryImage);  
    
                    if (Storage::disk('public')->exists($galleryImage)) {
                        Storage::disk('public')->delete($galleryImage);
                    }
                }
            }
        }
    
        $activity->delete();

        return redirect()->route('activity.index')
            ->withSuccess('activity  is deleted successfully.');
    } 


}
