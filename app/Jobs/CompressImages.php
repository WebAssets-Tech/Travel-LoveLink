<?php

namespace App\Jobs;

use App\Models\CompressedImage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class CompressImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $directories;

    public function __construct()
    {
        $this->directories = [
            'about_images', 'activity', 'activitygallery', 'blog', 'brand', 'category',
            'destination', 'destinationgallery', 'document', 'favicon', 'footer_logo',
            'gallery', 'header_logo', 'hotelgallery', 'images', 'logo', 'page', 'partner',
            'service', 'servicegallery', 'sliders'
        ];
    }

    public function handle(): void
    {
        
        Log::info('Image compression job started.');
        foreach ($this->directories as $directory) {
            $files = Storage::files("public/{$directory}");
            Log::info("Scanning directory: {$directory}, Found Files: " . count($files));

            foreach ($files as $file) {
                $imageName = basename($file);

                // Skip if already compressed
                if (CompressedImage::where('directory', $directory)->where('image_name', $imageName)->exists()) {
                    Log::info("Skipping already compressed: {$imageName} in {$directory}");

                    continue;
                }

                $compressedPath = str_replace($directory, "{$directory}/compressed", $file);
                $fullPath = storage_path("app/{$file}");
                $compressedFullPath = storage_path("app/{$compressedPath}");
                Log::info("Compressing: {$fullPath} -> {$compressedFullPath}");

                if ($this->compressImage($fullPath, $compressedFullPath, 70)) {
                    CompressedImage::create([
                        'directory' => $directory,
                        'image_name' => $imageName,
                    ]);

                    // Delete original file after compression
                    Storage::delete($file);
                    Log::info("Compression successful, deleted original: {$imageName}");

                }else {
                    Log::error("Compression failed for: {$imageName}");
                }
            }
        }
        Log::info('Image compression job completed.');

    }

    private function compressImage($source, $destination, $quality = 70): bool
    {
        $info = getimagesize($source);
        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($source);
            imagejpeg($image, $destination, $quality);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source);
            imagepng($image, $destination, round($quality / 10));
        } elseif ($info['mime'] == 'image/webp') {
            $image = imagecreatefromwebp($source);
            imagewebp($image, $destination, $quality);
        } else {
            return false;
        }

        imagedestroy($image);
        return true;
    }
}
