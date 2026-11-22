<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Testimonial;
use App\Http\Requests\StoreTestimonialRequest;
use App\Http\Requests\UpdateTestimonialRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Instantiate a new TestimonialController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-testimonial|create-testimonial|edit-testimonial|delete-testimonial', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-testimonial', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-testimonial', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-testimonial', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.testimonial.index', [
            'testimonials' => Testimonial::latest()->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    { 
        return view('admin.testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTestimonialRequest $request): RedirectResponse
    { 
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('testimonial', 'public');
        }

        Testimonial::create($data); 

        return redirect()->back() 
            ->withSuccess('New testimonial is added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial): View
    { 
        return view('admin.testimonial.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTestimonialRequest $request, Testimonial $testimonial): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($testimonial->image) {
                \Storage::disk('public')->delete($testimonial->image);
            }
    
            $imagePath = $request->file('image')->store('testimonial', 'public');
            $data['image'] = $imagePath;
        }

        $testimonial->update($data);

        return redirect()->back()->withSuccess('testimonial updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        if ($testimonial->image) {
            \Storage::disk('public')->delete($testimonial->image);
        }
        $testimonial->delete();

        return redirect()->route('testimonial.index')
            ->withSuccess('testimonial is deleted successfully.');
    } 


}
