<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Slider;
use App\Http\Requests\StoreSliderRequest;
use App\Http\Requests\UpdateSliderRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Instantiate a new SliderController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-slider|create-slider|edit-slider|delete-slider', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-slider', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-slider', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-slider', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.slider.index', [
            'sliders' => Slider::latest()->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    { 
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSliderRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        Slider::create($data); 

        return redirect()->back() 
            ->withSuccess('New slider is added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider): View
    { 
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSliderRequest $request, Slider $slider): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($slider->image) {
                \Storage::disk('public')->delete($slider->image);
            }
    
            $imagePath = $request->file('image')->store('sliders', 'public');
            $data['image'] = $imagePath;
        }

        $slider->update($data);

        return redirect()->back()->withSuccess('slider updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider): RedirectResponse
    {
        if ($slider->image) {
            \Storage::disk('public')->delete($slider->image);
        }
        $slider->delete();

        return redirect()->route('slider.index')
            ->withSuccess('slider is deleted successfully.');
    } 


}
