<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Faq;
use App\Http\Requests\StoreFaqRequest;
use App\Http\Requests\UpdateFaqRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class FaqController extends Controller
{
    /**
     * Instantiate a new FaqController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-faq|create-faq|edit-faq|delete-faq', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-faq', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-faq', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-faq', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.faq.index', [
            'faqs' => Faq::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    { 
        return view('admin.faq.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaqRequest $request): RedirectResponse
    { 
        $data = $request->validated();
 

        Faq::create($data); 

        return redirect()->back() 
            ->withSuccess('New faq is added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq): View
    { 
        return view('admin.faq.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaqRequest $request, Faq $faq): RedirectResponse
    {
        $data = $request->validated(); 
        $faq->update($data);

        return redirect()->back()->withSuccess('faq updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq): RedirectResponse
    { 
        $faq->delete();

        return redirect()->route('faq.index')
            ->withSuccess('faq is deleted successfully.');
    } 


}
