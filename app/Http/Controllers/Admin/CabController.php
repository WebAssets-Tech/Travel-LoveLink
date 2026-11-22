<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Cab;
use App\Http\Requests\StoreCabRequest;
use App\Http\Requests\UpdateCabRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class CabController extends Controller
{
    /**
     * Instantiate a new CabController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-cab|create-cab|edit-cab|delete-cab', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-cab', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-cab', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-cab', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.cab.index', [
            'cabs' => Cab::orderByRaw('CASE WHEN `order` IS NULL THEN 1 ELSE 0 END, `order` ASC, id DESC')->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    { 
        return view('admin.cab.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCabRequest $request): RedirectResponse
    {     
        $data = $request->validated();
        if ($request->has('order')) {
            $data['order'] = $request->filled('order') ? (int)$request->input('order') : 0;
        }
        $images = ['image', 'page_bg_image', 'banner_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) { 
                // Store new image
                $data[$image] = $request->file($image)->store('cab', 'public');
            }
        }
        if ($request->hasFile('additional_images')) {
            $additionalImages = [];
            foreach ($request->file('additional_images') as $file) {
                $additionalImages[] = $file->store('destinationgallery', 'public');
            }
            $data['gallery'] = json_encode($additionalImages);
        }

         $data['footer_gallery'] = collect($request->file('footer_images', []))
            ->map(fn($file) => $file->store('cab/footergallery', 'public'))
            ->toJson();
        Cab::create($data); 

        return redirect()->back() 
            ->withSuccess('New Cab  is added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cab $cab): View
    { 
        return view('admin.cab.edit', compact('cab'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCabRequest $request, Cab $cab): RedirectResponse
    {     
        $data = $request->validated();
        if ($request->has('order')) {
            $data['order'] = $request->filled('order') ? (int)$request->input('order') : 0;
        }
        $images = ['image', 'page_bg_image', 'banner_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                // Delete old image if exists
                if (!empty($cab->$image)) {
                    \Storage::disk('public')->delete($cab->$image);
                }
        
                // Store new image
                $data[$image] = $request->file($image)->store('cab', 'public');
            }
        } 
          $existingFooterImages = json_decode($cab->footer_gallery, true) ?? [];

        if ($request->hasFile('footer_images')) {
            foreach ($request->file('footer_images') as $file) {
                $existingFooterImages[] = $file->store('cab/footergallery', 'public');
            }
        }
    
        $data['footer_gallery'] = json_encode(array_values($existingFooterImages));
        $cab->update($data);

        return redirect()->back()->withSuccess('Cab  updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cab $cab): RedirectResponse
    {
        $images = ['image', 'page_bg_image', 'banner_image'];

        foreach ($images as $image) {
            if (!empty($cab->$image)) {
                \Storage::disk('public')->delete($cab->$image);
            }
        } 
    
        $cab->delete();

        return redirect()->route('cab.index')
            ->withSuccess('Cab is deleted successfully.');
    } 


}