<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-country|create-country|edit-country|delete-country', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-country', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-country', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-country', ['only' => ['destroy']]);
    }

    public function index(): View
    {
        return view('admin.country.index', [
            'countries' => Country::withCount('states')->latest()->paginate(10)
        ]);
    }

    public function create(): View
    {
        return view('admin.country.create');
    }

    public function store(StoreCountryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image', 'banner_footer_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                $data[$image] = $request->file($image)->store('country', 'public');
            }
        }

        if ($request->hasFile('additional_images')) {
            $additionalImages = [];
            foreach ($request->file('additional_images') as $file) {
                $additionalImages[] = $file->store('countrygallery', 'public');
            }
            $data['gallery'] = json_encode($additionalImages);
        }

        Country::create($data);

        return redirect()->back()->withSuccess('New country is added successfully.');
    }

    public function edit(Country $country): View
    {
        return view('admin.country.edit', compact('country'));
    }

    public function update(UpdateCountryRequest $request, Country $country): RedirectResponse
    {
        $data = $request->validated();
        $images = ['image', 'page_bg_image', 'banner_image', 'banner_footer_image'];

        foreach ($images as $image) {
            if ($request->hasFile($image)) {
                if (!empty($country->$image)) {
                    Storage::disk('public')->delete($country->$image);
                }
                $data[$image] = $request->file($image)->store('country', 'public');
            }
        }

        $existingImages = json_decode($country->gallery, true) ?? [];

        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $deleteImage) {
                Storage::disk('public')->delete($deleteImage);
                $existingImages = array_diff($existingImages, [$deleteImage]);
            }
        }

        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $file) {
                $existingImages[] = $file->store('countrygallery', 'public');
            }
        }

        $data['gallery'] = json_encode(array_values($existingImages));

        $country->update($data);

        return redirect()->back()->withSuccess('Country updated successfully.');
    }

    public function destroy(Country $country): RedirectResponse
    {
        $images = ['image', 'page_bg_image', 'banner_image', 'banner_footer_image'];

        foreach ($images as $image) {
            if (!empty($country->$image)) {
                Storage::disk('public')->delete($country->$image);
            }
        }

        if (!empty($country->gallery)) {
            $galleryImages = json_decode($country->gallery, true);

            if (is_array($galleryImages)) {
                foreach ($galleryImages as $galleryImage) {
                    $galleryImage = str_replace('\\/', '/', $galleryImage);

                    if (Storage::disk('public')->exists($galleryImage)) {
                        Storage::disk('public')->delete($galleryImage);
                    }
                }
            }
        }

        $country->delete();

        return redirect()->route('country.index')->withSuccess('Country is deleted successfully.');
    }
}