<?php
use App\Models\Destination;
use App\Models\Tour;

if (!function_exists('getToursByVenueDate')) {
    function getToursByVenueDate($venueDate)
    {
        return Tour::Venue()
            ->whereDate('venue_date', $venueDate)
            ->orderBy('venue_date')
            ->get();
    }
}
if (!function_exists('getDestinationTourCountBySlug')) {
    function getDestinationTourCountBySlug($slug)
    {
        return Destination::where('slug', $slug)->withCount('tours')->first();
    }
}  
if (!function_exists('getImageByType')) {
    function getImageByType($type,$setting)
    { 
        $images = is_string($setting->page_bg_image)    ? json_decode($setting->page_bg_image, true)  : ($setting->page_bg_image ?? []); // Get existing images

        if (!$setting || !isset($setting->page_bg_image)) {
            return null;
        }

        //$images = json_decode($setting->about_images, true);

        foreach ($images as $item) { 
            if (isset($item['type']) && $item['type'] == $type) {
                return asset('storage/'.$item['image']);
            }
        }

        return asset('webassets/img/bg/breadcumb-bg.jpg');
    }
}

if (!function_exists('useBreadcrumbColor')) {
    function useBreadcrumbColor($setting = null): bool
    {
        return ($setting->breadcrumb_bg_type ?? 'image') === 'color';
    }
}

if (!function_exists('getBreadcrumbBgColor')) {
    function getBreadcrumbBgColor($setting = null): string
    {
        $default = 'linear-gradient(135deg, #072355 0%, #0B3D91 60%, #0e46a3 100%)';
        $color = trim((string) ($setting->breadcrumb_bg_color ?? ''));
        $color = preg_replace('/\s*!important\s*;?\s*$/i', '', $color);
        return $color !== '' ? $color : $default;
    }
}

if (!function_exists('breadcrumbBgAttrs')) {
    function breadcrumbBgAttrs(?string $imageUrl, $setting = null, bool $withInlineFallback = false, bool $useInlineBackground = false): string
    {
        if (useBreadcrumbColor($setting)) {
            $bgColor = e(getBreadcrumbBgColor($setting));
            return 'style="background: ' . $bgColor . ' !important;"';
        }

        if (empty($imageUrl)) {
            return '';
        }

        $escapedUrl = e($imageUrl);

        if ($useInlineBackground) {
            return 'style="background: url(\'' . $escapedUrl . '\') center/cover no-repeat !important;"';
        }

        $attrs = 'data-bg-src="' . $escapedUrl . '"';
        if ($withInlineFallback) {
            $attrs .= ' style="background-image: url(\'' . $escapedUrl . '\');"';
        }

        return $attrs;
    }
}

if (!function_exists('generateMetaTags')) {
    function generateMetaTags($entity)
    {
        return \App\Helpers\SeoEngine::render($entity);
    }
}

if (!function_exists('generateMetaTagsSimple')) {
    function generateMetaTagsSimple($title, $setting = null)
    {
        return \App\Helpers\SeoEngine::render(['title' => $title, 'setting' => $setting]);
    }
}

if (!function_exists('getYoutubeEmbedUrl')) {
    function getYoutubeEmbedUrl($url) {
        if (empty($url)) {
            return null;
        }
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?|shorts)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url, $match)) {
            return 'https://www.youtube.com/embed/' . $match[1];
        }
        return $url;
    }
}
