<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHouseboatRequest;
use App\Http\Requests\UpdateHouseboatRequest;
use App\Models\Houseboat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HouseboatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-houseboat|create-houseboat|edit-houseboat|delete-houseboat', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-houseboat', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-houseboat', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-houseboat', ['only' => ['destroy']]);
    }

    public function index(): View
    {
        return view('admin.houseboat.index', [
            'houseboats' => Houseboat::latest()->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.houseboat.create');
    }

    public function store(StoreHouseboatRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['highlights'] = array_values(array_filter($request->input('highlights', []), fn ($v) => trim((string) $v) !== ''));

        foreach (['image', 'page_bg_image', 'banner_image', 'banner_footer_image'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('houseboat', 'public');
            }
        }

        if ($request->hasFile('additional_images')) {
            $additionalImages = [];
            foreach ($request->file('additional_images') as $file) {
                $additionalImages[] = $file->store('houseboat/gallery', 'public');
            }
            $data['gallery'] = $additionalImages;
        }

        unset($data['additional_images']);
        Houseboat::create($data);

        return redirect()->route('houseboat.index')
            ->withSuccess('New houseboat added successfully.');
    }

    public function edit(Houseboat $houseboat): View
    {
        return view('admin.houseboat.edit', compact('houseboat'));
    }

    public function update(UpdateHouseboatRequest $request, Houseboat $houseboat): RedirectResponse
    {
        $data = $request->validated();
        $data['highlights'] = array_values(array_filter($request->input('highlights', []), fn ($v) => trim((string) $v) !== ''));

        foreach (['image', 'page_bg_image', 'banner_image', 'banner_footer_image'] as $field) {
            if ($request->hasFile($field)) {
                if (!empty($houseboat->$field) && Storage::disk('public')->exists($houseboat->$field)) {
                    Storage::disk('public')->delete($houseboat->$field);
                }
                $data[$field] = $request->file($field)->store('houseboat', 'public');
            }
        }

        $existingImages = is_array($houseboat->gallery)
            ? $houseboat->gallery
            : (json_decode((string) $houseboat->gallery, true) ?: []);

        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $deleteImage) {
                if (Storage::disk('public')->exists($deleteImage)) {
                    Storage::disk('public')->delete($deleteImage);
                }
                $existingImages = array_values(array_diff($existingImages, [$deleteImage]));
            }
        }

        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $file) {
                $existingImages[] = $file->store('houseboat/gallery', 'public');
            }
        }

        $data['gallery'] = array_values($existingImages);
        unset($data['additional_images'], $data['delete_images']);

        $houseboat->update($data);

        return redirect()->back()->withSuccess('Houseboat updated successfully.');
    }

    public function destroy(Houseboat $houseboat): RedirectResponse
    {
        foreach (['image', 'page_bg_image', 'banner_image', 'banner_footer_image'] as $field) {
            if (!empty($houseboat->$field) && Storage::disk('public')->exists($houseboat->$field)) {
                Storage::disk('public')->delete($houseboat->$field);
            }
        }

        $galleryImages = is_array($houseboat->gallery)
            ? $houseboat->gallery
            : json_decode((string) $houseboat->gallery, true);

        if (is_array($galleryImages)) {
            foreach ($galleryImages as $galleryImage) {
                $galleryImage = str_replace('\\/', '/', (string) $galleryImage);
                if (Storage::disk('public')->exists($galleryImage)) {
                    Storage::disk('public')->delete($galleryImage);
                }
            }
        }

        $houseboat->delete();

        return redirect()->route('houseboat.index')
            ->withSuccess('Houseboat deleted successfully.');
    }
}
