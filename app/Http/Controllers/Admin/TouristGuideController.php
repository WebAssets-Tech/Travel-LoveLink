<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\TouristGuide;
use App\Http\Requests\StoreTouristGuideRequest;
use App\Http\Requests\UpdateTouristGuideRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class TouristGuideController extends Controller
{
    /**
     * Instantiate a new TouristGuideController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-touristguide|create-touristguide|edit-touristguide|delete-touristguide', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-touristguide', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-touristguide', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-touristguide', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.touristguide.index', [
            'touristguides' => TouristGuide::latest()->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    { 
        return view('admin.touristguide.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTouristGuideRequest $request): RedirectResponse
    {       
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) { 
                // Store new image
                $data[$image] = $request->file($image)->store('activity', 'public');
            }
        }  
        TouristGuide::create($data); 

        return redirect()->back() 
            ->withSuccess('New Tourist Guide  is added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TouristGuide $touristguide): View
    { 
        return view('admin.touristguide.edit', compact('touristguide'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTouristGuideRequest $request, TouristGuide $touristguide): RedirectResponse
    {     
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                // Delete old image if exists
                if (!empty($touristguide->$image)) {
                    \Storage::disk('public')->delete($touristguide->$image);
                }
        
                // Store new image
                $data[$image] = $request->file($image)->store('touristguide', 'public');
            }
        }   

        $touristguide->update($data);

        return redirect()->back()->withSuccess('Tourist Guide  updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TouristGuide $touristguide): RedirectResponse
    {
        $images = ['image', 'page_bg_image', 'banner_image'];

        foreach ($images as $image) {
            if (!empty($touristguide->$image)) {
                \Storage::disk('public')->delete($touristguide->$image);
            }
        }  
    
        $touristguide->delete();

        return redirect()->route('touristguide.index')
            ->withSuccess('Tourist Guide  is deleted successfully.');
    } 


}
