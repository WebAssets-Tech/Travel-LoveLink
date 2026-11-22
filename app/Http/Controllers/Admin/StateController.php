<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Country;
use App\Http\Requests\StoreStateRequest;
use App\Http\Requests\UpdateStateRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class StateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-state|create-state|edit-state|delete-state', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-state', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-state', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-state', ['only' => ['destroy']]);
    }

    public function index(): View
    {
        return view('admin.state.index', [
            'states' => State::with('country')->orderBy('order', 'asc')->paginate(10)
        ]);
    }

    public function create(): View
    {
        $countries = Country::where('status', 1)->orderBy('name')->get();
        return view('admin.state.create', compact('countries'));
    }

    public function store(StoreStateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image', 'banner_footer_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                $data[$image] = $request->file($image)->store('state', 'public');
            }
        }

        if ($request->hasFile('additional_images')) {
            $additionalImages = [];
            foreach ($request->file('additional_images') as $file) {
                $additionalImages[] = $file->store('stategallery', 'public');
            }
            $data['gallery'] = json_encode($additionalImages);
        }

        State::create($data);

        return redirect()->back()->withSuccess('New state is added successfully.');
    }

    public function edit(State $state): View
    {
        $countries = Country::where('status', 1)->orderBy('name')->get();
        return view('admin.state.edit', compact('state', 'countries'));
    }

    public function update(UpdateStateRequest $request, State $state): RedirectResponse
    {
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image', 'banner_footer_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                if (!empty($state->$image)) {
                    Storage::disk('public')->delete($state->$image);
                }
                $data[$image] = $request->file($image)->store('state', 'public');
            }
        }

        $existingImages = json_decode($state->gallery, true) ?? [];

        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $deleteImage) {
                Storage::disk('public')->delete($deleteImage);
                $existingImages = array_diff($existingImages, [$deleteImage]);
            }
        }

        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $file) {
                $existingImages[] = $file->store('stategallery', 'public');
            }
        }

        $data['gallery'] = json_encode(array_values($existingImages));

        $state->update($data);

        return redirect()->back()->withSuccess('State updated successfully.');
    }

    public function destroy(State $state): RedirectResponse
    {
        $images = ['image', 'page_bg_image', 'banner_image', 'banner_footer_image'];

        foreach ($images as $image) {
            if (!empty($state->$image)) {
                Storage::disk('public')->delete($state->$image);
            }
        }

        if (!empty($state->gallery)) {
            $galleryImages = json_decode($state->gallery, true);

            if (is_array($galleryImages)) {
                foreach ($galleryImages as $galleryImage) {
                    $galleryImage = str_replace('\\/', '/', $galleryImage);

                    if (Storage::disk('public')->exists($galleryImage)) {
                        Storage::disk('public')->delete($galleryImage);
                    }
                }
            }
        }

        $state->delete();

        return redirect()->route('state.index')->withSuccess('State is deleted successfully.');
    }
}
