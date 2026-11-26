<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateSettingRequest;
use Spatie\Permission\Models\Permission;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DB;
class SettingController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-setting|edit-setting|delete-setting', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-setting', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-setting', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-setting', ['only' => ['destroy']]);
    }
 
    public function edit(Setting $setting): View
    {
 
        return view('admin.setting.edit', [
            'setting' => $setting
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingRequest $request, Setting $setting): RedirectResponse
    {
        //echo json_encode($request->all());
        //exit;
        $files = ['header_logo', 'footer_logo', 'favicon', 'meta_image'];

        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                // Delete old file if it exists
                if ($setting->$file) {
                    Storage::disk('public')->delete($setting->$file);
                }
        
                // Store new file
                $fileName = Auth::id() . '-' . now()->timestamp . "-$file." . $request->file($file)->extension();
                $filePath = $request->file($file)->storeAs($file, $fileName, 'public');
        
                // Update in database
                $setting->update([$file => $filePath]);
            }
        }
        $updatedImages = [];
        if ($request->has('about_images')) {
            $existingImages = is_string($setting->about_images)    ? json_decode($setting->about_images, true)  : ($setting->about_images ?? []); // Get existing images
            $updatedImages = [];
        
            foreach ($request->input('about_images') as $index => $imageData) {
                if ($request->hasFile("about_images.$index.image")) { 
                    // If a new image is uploaded, store it
                    $file = $request->file("about_images.$index.image");
                    $path = $file->store('about_images', 'public');
        
                    $updatedImages[] = [
                        'image' => $path,
                        'order' => $imageData['order'] ?? 0,
                    ];
                } else {
                    // If no new image is uploaded, keep the old image and update order
                    $updatedImages[] = [
                        'image' => $existingImages[$index]['image'] ?? null, // Keep existing image
                        'order' => $imageData['order'] ?? 0, // Update order
                    ];
                }
            }
        
            $setting->about_images = json_encode($updatedImages);
        } else {
            $setting->about_images = json_encode([]);
        }
        
        if ($request->has('page_bg_image')) {
            $existingImagesa = is_string($setting->page_bg_image)    ? json_decode($setting->page_bg_image, true)  : ($setting->page_bg_image ?? []); // Get existing images
            $updatedImagess = [];
        
            foreach ($request->input('page_bg_image') as $index => $imageDatas) {
                if ($request->hasFile("page_bg_image.$index.image")) { 
                    // If a new image is uploaded, store it
                    $file = $request->file("page_bg_image.$index.image");
                    $path = $file->store('pagebg', 'public');
        
                    $updatedImagess[] = [
                        'image' => $path,
                        'type' => $imageDatas['type'] ?? 0,
                    ];
                } else {
                    // If no new image is uploaded, keep the old image and update order
                    $updatedImagess[] = [
                        'image' => $existingImagesa[$index]['image'] ?? null, // Keep existing image
                        'type' => $imageDatas['type'] ?? 0, // Update order
                    ];
                }
            }
        
            $setting->page_bg_image = $updatedImagess;
        } else {
            $setting->page_bg_image = json_encode([]);
        }
        
        
        
        
        
  
        $defaultBreadcrumbColor = 'linear-gradient(135deg, #072355 0%, #0B3D91 60%, #0e46a3 100%)';
        $breadcrumbBgType = in_array($request->input('breadcrumb_bg_type'), ['image', 'color'], true)
            ? $request->input('breadcrumb_bg_type')
            : 'image';
        $rawBreadcrumbColor = trim((string) $request->input('breadcrumb_bg_color', ''));
        $rawBreadcrumbColor = preg_replace('/\s*!important\s*;?\s*$/i', '', $rawBreadcrumbColor);
        $breadcrumbBgColor = $rawBreadcrumbColor !== '' ? $rawBreadcrumbColor : $defaultBreadcrumbColor;

        $setting->fill([
           'social_link' => $request->social_link ?? json_encode([]),
            'about_images' => $updatedImages,
            'breadcrumb_bg_type' => $breadcrumbBgType,
            'breadcrumb_bg_color' => $breadcrumbBgColor,
            'about_ot_content' => $request->about_ot_content ?? json_encode([]),
            'home_counter' => $request->home_counter ?? json_encode([]),
            'name' => $request->name,
            'footer_script' => $request->footer_script,
            'header_script' => $request->header_script,
            'youtube_vid_link' => $request->youtube_vid_link,
            'email' => $request->email,
            'email1' => $request->email1,
            'phone1' => $request->phone1,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => 1,
            'footer_about' => $request->footer_about,
            'footer_copyright' => $request->footer_copyright,
            'map_link' => $request->map_link,
            'about_subtitle' => $request->about_subtitle,
            'about_title' => $request->about_title,
            'about_content' => $request->about_content,
            'preloader' => $request->preloader, 
            'updated_at' => now(),
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'meta_title' => $request->meta_title,
        ]);
        
        $setting->save();

        \Illuminate\Support\Facades\Cache::forget('global_layout_shared_data');
        \Illuminate\Support\Facades\Cache::forget('homepage_curated_data');

        return redirect()->back()
                ->withSuccess('Setting is updated successfully.');
 
    }

     
}
