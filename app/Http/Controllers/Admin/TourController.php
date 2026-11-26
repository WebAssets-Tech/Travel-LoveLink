<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\State;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\Destination;
use App\Models\Activity;
use App\Http\Requests\StoreTourRequest;
use App\Http\Requests\UpdateTourRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class TourController extends Controller
{
    /**
     * Instantiate a new TourController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-tour|create-tour|edit-tour|delete-tour', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-tour', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-tour', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-tour', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.tour.index', [
            'tours' => Tour::with(['destinations', 'categories', 'activities','state.country'])->latest()->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    { 
        $states = State::with('country')->where('status', 1)->orderBy('name')->get();
        $tourcategories = TourCategory::all();
        $activities = Activity::all();
        $destinations = Destination::all();
        return view('admin.tour.create',compact('tourcategories','activities','destinations','states'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTourRequest $request): RedirectResponse
    {      
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) { 
                // Store new image
                $data[$image] = $request->file($image)->store('tour', 'public');
            }
        } 
        /*
        $data['gallery'] = collect($request->file('additional_images', []))
            ->map(fn($file) => $file->store('tour/gallery', 'public'))
            ->toJson();
            */

        $data['footer_gallery'] = collect($request->file('footer_images', []))
            ->map(fn($file) => $file->store('tour/footergallery', 'public'))
            ->toJson();
        if ($request->has('itinerary')) {
            $data['itinerary'] = json_encode($request->input('itinerary'));
        }
        if (empty($data['venue_date'])) {
            $data['venue_date'] = now()->format('Y-m-d');
        }
        if (!\Illuminate\Support\Facades\Schema::hasColumn('tours', 'rating')) {
            unset($data['rating']);
        }
        $tour = Tour::create($data);
        
        $tour->destinations()->sync($request->input('destination_ids', []));
        $tour->categories()->sync($request->input('category_ids', []));
        $tour->activities()->sync($request->input('activity_ids', []));
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data');

        return redirect()->back() 
            ->withSuccess('New tour  is added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tour $tour): View
    {   
        $states = State::with('country')->where('status', 1)->orderBy('name')->get();
        $tourcategories = TourCategory::all();
        $activities = Activity::all();
        $destinations = Destination::all();
            
        $selectedCategories = $tour->categories->pluck('id')->toArray();
        $selectedActivities = $tour->activities->pluck('id')->toArray();
        $selectedDestinations = $tour->destinations->pluck('id')->toArray();
        return view('admin.tour.edit',
        compact('tour',
                'tourcategories',
                'activities',
                'destinations',
                'selectedCategories',
                'selectedActivities',
                'selectedDestinations',
                'states'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTourRequest $request, Tour $tour): RedirectResponse
    {     
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                // Delete old image if exists
                if (!empty($tour->$image)) {
                    \Storage::disk('public')->delete($tour->$image);
                }
        
                // Store new image
                $data[$image] = $request->file($image)->store('tour', 'public');
            }
        } 
       /*
        $existingImages = json_decode($tour->gallery, true) ?? [];

        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $deleteImage) {
                Storage::disk('public')->delete($deleteImage);
                $existingImages = array_diff($existingImages, [$deleteImage]); // Remove from array
            }
        }
    
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $file) {
                $existingImages[] = $file->store('tour/gallery', 'public');
            }
        }
        $data['gallery'] = json_encode(array_values($existingImages));
        */
    
        // Handle footer gallery images
        $existingFooterImages = json_decode($tour->footer_gallery, true) ?? [];
    
        
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $deleteFooterImage) {
                if (Storage::disk('public')->exists($deleteFooterImage)) {
                    Storage::disk('public')->delete($deleteFooterImage);
                } else {
                    //Log::warning("File not found: $deleteFooterImage");
                }
        
                // Also remove it from the saved footer_gallery array, if you're updating the model
                $existingFooterImages = array_diff($existingFooterImages, [$deleteFooterImage]);
            }
        }
    
        if ($request->hasFile('footer_images')) {
            foreach ($request->file('footer_images') as $file) {
                $existingFooterImages[] = $file->store('tour/footergallery', 'public');
            }
        }
    
        $data['footer_gallery'] = json_encode(array_values($existingFooterImages));
    
        if ($request->has('itinerary')) {
            $data['itinerary'] = json_encode($request->input('itinerary'));
        }
        if (empty($data['venue_date']) && !empty($tour->venue_date)) {
            $data['venue_date'] = $tour->venue_date;
        } elseif (empty($data['venue_date'])) {
            $data['venue_date'] = now()->format('Y-m-d');
        }
        if (!\Illuminate\Support\Facades\Schema::hasColumn('tours', 'rating')) {
            unset($data['rating']);
        }
        $tour->update($data);
        $tour->destinations()->sync($request->input('destination_ids', []));
        $tour->categories()->sync($request->input('category_ids', []));
        $tour->activities()->sync($request->input('activity_ids', []));
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data');

        return redirect()->back()->withSuccess('Tour updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tour $tour): RedirectResponse
    {
        $images = ['image', 'page_bg_image', 'banner_image'];

        foreach ($images as $image) {
            if (!empty($tour->$image)) {
                \Storage::disk('public')->delete($tour->$image);
            }
        } 
        /*
        if (!empty($tour->gallery)) { 
            $galleryImages = json_decode($tour->gallery, true);  
            
            if (is_array($galleryImages)) {
                foreach ($galleryImages as $galleryImage) {
                    $galleryImage = str_replace('\\/', '/', $galleryImage);  
    
                    if (Storage::disk('public')->exists($galleryImage)) {
                        Storage::disk('public')->delete($galleryImage);
                    }
                }
            }
        }
        */
        if (!empty($tour->footer_gallery)) { 
            $footer_gallerygalleryImages = json_decode($tour->footer_gallery, true);  
            
            if (is_array($footer_gallerygalleryImages)) {
                foreach ($footer_gallerygalleryImages as $galleryImage) {
                    $galleryImage = str_replace('\\/', '/', $galleryImage);  
    
                    if (Storage::disk('public')->exists($galleryImage)) {
                        Storage::disk('public')->delete($galleryImage);
                    }
                }
            }
        }
    
        $tour->delete();
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data');

        return redirect()->route('tour.index')
            ->withSuccess('Tour is deleted successfully.');
    } 


}
