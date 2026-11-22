<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Partner;
use App\Http\Requests\StorePartnerRequest;
use App\Http\Requests\UpdatePartnerRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    /**
     * Instantiate a new PartnerController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-partner|create-partner|edit-partner|delete-partner', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-partner', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-partner', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-partner', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.partner.index', [
            'partners' => Partner::latest()->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    { 
        return view('admin.partner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePartnerRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('partner', 'public');
        }

        Partner::create($data); 

        return redirect()->back() 
            ->withSuccess('New partner is added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partner $partner): View
    { 
        return view('admin.partner.edit', compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePartnerRequest $request, Partner $partner): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($partner->image) {
                \Storage::disk('public')->delete($partner->image);
            }
    
            $imagePath = $request->file('image')->store('partner', 'public');
            $data['image'] = $imagePath;
        }

        $partner->update($data);

        return redirect()->back()->withSuccess('partner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner): RedirectResponse
    {
        if ($partner->image) {
            \Storage::disk('public')->delete($partner->image);
        }
        $partner->delete();

        return redirect()->route('partner.index')
            ->withSuccess('partner is deleted successfully.');
    } 


}
