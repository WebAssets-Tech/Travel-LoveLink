<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use App\Models\Setting;
use App\Models\Tour;
use App\Models\Hotel;
use App\Models\Cab;
use App\Models\Blog;
use App\Models\Destination;
use App\Models\Activity;
use App\Models\Service;
use App\Models\Page;
use App\Models\DestinationWedding;

/**
 * Native Plugin-Free SEO & Full JSON-LD Structured Data Engine for Laravel
 *
 * Implements high-impact travel SEO strategy:
 * - Dynamic Context Resolver auto-detecting 13+ entity types
 * - Geo meta signals for local travel authority (Srinagar, Kashmir, Ladakh)
 * - Complete Open Graph & Twitter Cards with verified dimensions & image preloading
 * - Full JSON-LD Knowledge Graph (@id linked):
 *     * TravelAgency + LocalBusiness + WebSite (Sitelinks Search Box)
 *     * TouristTrip + Product + AggregateRating + Day-by-Day Itinerary ItemList
 *     * LodgingBusiness (Hotels)
 *     * Vehicle & Service (Cabs)
 *     * BlogPosting & Article (Travel Blogs)
 *     * TouristDestination (Destinations)
 *     * CollectionPage & ItemList (Archives & State listings)
 *     * FAQPage (Dynamic extraction from tour inclusions, policies & travel FAQs)
 *     * BreadcrumbList (Hierarchy-aligned)
 *     * SpeakableSpecification (Voice search readiness)
 * - Sitemap Index with sub-sitemaps & Google Image Sitemap extensions
 * - Optimized robots.txt with AI bot blocking & crawl-delay
 *
 * @package LoveLink_Travel_SEO
 */
class SeoEngine
{
    /**
     * Master render entry point for Blade views.
     *
     * @param mixed $context Array of view variables, Eloquent model, or null for auto-detect
     * @return string Safe HTML string containing meta tags & JSON-LD scripts
     */
    public static function render($context = null): string
    {
        try {
            $seoContext = self::resolveContext($context);
            $metaHtml = self::buildMetaTags($seoContext);
            $schemasHtml = self::buildSchemas($seoContext);

            return "\n<!-- === LoveLink Native Travel SEO Engine === -->\n" .
                $metaHtml . "\n" .
                $schemasHtml . "\n" .
                "<!-- === /LoveLink Native Travel SEO Engine === -->\n";
        } catch (\Throwable $e) {
            // Fail-safe: never break page rendering if an unexpected exception occurs
            return '<title>' . e(config('app.name', 'Love Link Tour & Travels')) . '</title>' .
                   '<meta name="description" content="Handcrafted Kashmir & Ladakh holiday packages with private cabs, luxury houseboats & 24/7 local concierge.">' .
                   '<link rel="canonical" href="' . e(url()->current()) . '">';
        }
    }

    /**
     * Sitewide Schema builder (Organization + WebSite + Sitelinks SearchBox).
     * Can be invoked independently or as part of render().
     */
    public static function renderSitewideSchemas($setting = null): string
    {
        $setting = $setting ?: self::getSetting();
        $schemas = [
            self::buildTravelAgencySchema($setting),
            self::buildWebSiteSchema($setting),
        ];

        $html = '';
        foreach ($schemas as $s) {
            if (!empty($s)) {
                $html .= '<script type="application/ld+json">' . json_encode($s, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
            }
        }
        return $html;
    }

    /* =========================================================================
     * 1. CONTEXT RESOLVER
     * ========================================================================= */

    /**
     * Auto-detect and resolve page context, active entity, and metadata.
     */
    protected static function resolveContext($rawContext): SeoContext
    {
        $context = new SeoContext();
        $setting = self::getSetting();
        $context->setting = $setting;
        $brandName = $setting->name ?? config('app.name', 'Love Link Tour & Travels');
        $baseUrl = rtrim(url('/'), '/');

        // Normalize input into an array
        $vars = [];
        if (is_array($rawContext)) {
            $vars = $rawContext;
        } elseif ($rawContext instanceof Model) {
            // Determine model type
            if ($rawContext instanceof Tour) $vars['tour'] = $rawContext;
            elseif ($rawContext instanceof Hotel) $vars['hotel'] = $rawContext;
            elseif ($rawContext instanceof Cab) $vars['cab'] = $rawContext;
            elseif ($rawContext instanceof Blog) $vars['blog'] = $rawContext;
            elseif ($rawContext instanceof Destination) $vars['destination'] = $rawContext;
            elseif ($rawContext instanceof Activity) $vars['activity'] = $rawContext;
            elseif ($rawContext instanceof Service) $vars['service'] = $rawContext;
            elseif ($rawContext instanceof Page) $vars['page'] = $rawContext;
            elseif ($rawContext instanceof DestinationWedding) $vars['destinationwedding'] = $rawContext;
            else $vars['entity'] = $rawContext;
        }

        // Entity Detection Cascade
        if (isset($vars['tour']) && $vars['tour'] instanceof Tour) {
            $context->pageType = 'tour';
            $context->entity = $vars['tour'];
            self::populateFromTour($context, $vars['tour'], $brandName);
        } elseif (isset($vars['hotel']) && $vars['hotel'] instanceof Hotel) {
            $context->pageType = 'hotel';
            $context->entity = $vars['hotel'];
            self::populateFromHotel($context, $vars['hotel'], $brandName);
        } elseif (isset($vars['cab']) && $vars['cab'] instanceof Cab) {
            $context->pageType = 'cab';
            $context->entity = $vars['cab'];
            self::populateFromCab($context, $vars['cab'], $brandName);
        } elseif (isset($vars['blog']) && $vars['blog'] instanceof Blog) {
            $context->pageType = 'blog';
            $context->entity = $vars['blog'];
            self::populateFromBlog($context, $vars['blog'], $brandName);
        } elseif (isset($vars['destination']) && $vars['destination'] instanceof Destination) {
            $context->pageType = 'destination';
            $context->entity = $vars['destination'];
            self::populateFromDestination($context, $vars['destination'], $brandName);
        } elseif (isset($vars['activity']) && $vars['activity'] instanceof Activity) {
            $context->pageType = 'activity';
            $context->entity = $vars['activity'];
            self::populateFromActivity($context, $vars['activity'], $brandName);
        } elseif (isset($vars['service']) && $vars['service'] instanceof Service) {
            $context->pageType = 'service';
            $context->entity = $vars['service'];
            self::populateFromService($context, $vars['service'], $brandName);
        } elseif (isset($vars['page']) && $vars['page'] instanceof Page) {
            $context->pageType = 'page';
            $context->entity = $vars['page'];
            self::populateFromPage($context, $vars['page'], $brandName);
        } elseif (isset($vars['destinationwedding']) && $vars['destinationwedding'] instanceof DestinationWedding) {
            $context->pageType = 'destinationwedding';
            $context->entity = $vars['destinationwedding'];
            self::populateFromWedding($context, $vars['destinationwedding'], $brandName);
        } elseif (isset($vars['tours']) && (isset($vars['state']) || isset($vars['categoryTour']) || isset($vars['category']))) {
            $context->pageType = 'tour_archive';
            self::populateFromTourArchive($context, $vars, $brandName);
        } elseif (isset($vars['hotels'])) {
            $context->pageType = 'hotel_archive';
            self::populateFromHotelArchive($context, $vars, $brandName);
        } elseif (isset($vars['cabs'])) {
            $context->pageType = 'cab_archive';
            self::populateFromCabArchive($context, $vars, $brandName);
        } elseif (isset($vars['destinations'])) {
            $context->pageType = 'destination_archive';
            self::populateFromDestinationArchive($context, $vars, $brandName);
        } elseif (isset($vars['blogs'])) {
            $context->pageType = 'blog_archive';
            self::populateFromBlogArchive($context, $vars, $brandName);
        } elseif (Route::currentRouteName() === 'home' || Request::path() === '/' || Request::path() === '') {
            $context->pageType = 'home';
            self::populateFromHome($context, $setting, $brandName);
        } else {
            // General fallback
            $context->pageType = 'general';
            $customTitle = $vars['title'] ?? null;
            self::populateGeneral($context, $customTitle, $setting, $brandName);
        }

        // Canonical normalization (strip tracking query params, ensure HTTPS if applicable)
        $currentUrl = url()->current();
        $context->canonical = $context->canonical ?: strtok($currentUrl, '?');

        // Robots directive: auto-noindex internal search or orderby filter pages to avoid duplicate crawl
        if (Request::has('orderby') || Request::has('search') || (Request::has('page') && (int)Request::get('page') > 1)) {
            $context->robots = 'noindex, follow';
        } else {
            $context->robots = 'index, follow';
        }

        return $context;
    }

    /* =========================================================================
     * 2. ENTITY POPULATORS
     * ========================================================================= */

    protected static function populateFromTour(SeoContext $ctx, Tour $tour, string $brand): void
    {
        $durationFormatted = !empty($tour->duration)
            ? (is_numeric($tour->duration) ? " ({$tour->duration} Days)" : (str_contains($tour->title, $tour->duration) ? "" : " ({$tour->duration})"))
            : "";
        $ctx->title = !empty($tour->meta_title) ? $tour->meta_title : "{$tour->title}{$durationFormatted} | {$brand}";
        $ctx->description = !empty($tour->meta_description)
            ? $tour->meta_description
            : (!empty($tour->short_description)
                ? Str::limit(strip_tags($tour->short_description), 155)
                : "Book {$tour->title} with {$brand}. Includes private sanitized cab, verified hotel/houseboat stays & 24/7 native ground concierge in Kashmir.");
        $ctx->keywords = !empty($tour->meta_keywords)
            ? $tour->meta_keywords
            : "{$tour->title}, Kashmir tour package, Srinagar holiday package, Kashmir itinerary, {$brand}";
        $ctx->ogType = 'product';
        $ctx->ogImage = self::resolveImageUrl($tour->image ?? $tour->banner_image);
        $ctx->canonical = route('tour.details', $tour->slug);

        // Breadcrumb Chain
        $ctx->breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Tour Packages', 'url' => url('/tours')],
        ];
        if (!empty($tour->state_id)) {
            $stateName = isset($tour->state->name) ? ucwords($tour->state->name) : 'Kashmir';
            $stateSlug = isset($tour->state->slug) ? $tour->state->slug : 'kashmir';
            $ctx->breadcrumbs[] = ['name' => "{$stateName} Tours", 'url' => url("/tours-by-state/{$stateSlug}")];
        }
        $ctx->breadcrumbs[] = ['name' => $tour->title, 'url' => $ctx->canonical];
    }

    protected static function populateFromHotel(SeoContext $ctx, Hotel $hotel, string $brand): void
    {
        $loc = !empty($hotel->location) ? " in {$hotel->location}" : " in Kashmir";
        $ctx->title = !empty($hotel->meta_title) ? $hotel->meta_title : "{$hotel->title}{$loc} | Verified Stay | {$brand}";
        $ctx->description = !empty($hotel->meta_description)
            ? $hotel->meta_description
            : Str::limit(strip_tags($hotel->description ?? "Book {$hotel->title}{$loc} with best price guarantee & local support through {$brand}."), 155);
        $ctx->keywords = !empty($hotel->meta_keywords)
            ? $hotel->meta_keywords
            : "{$hotel->title}, hotels in {$hotel->location}, luxury resorts Kashmir, stay in Srinagar, {$brand}";
        $ctx->ogType = 'product';
        $ctx->ogImage = self::resolveImageUrl($hotel->image ?? $hotel->banner_image);
        $ctx->canonical = url('/hotel/' . $hotel->slug);

        $ctx->breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Hotels & Resorts', 'url' => url('/hotels')],
            ['name' => $hotel->title, 'url' => $ctx->canonical],
        ];
    }

    protected static function populateFromCab(SeoContext $ctx, Cab $cab, string $brand): void
    {
        $ctx->title = !empty($cab->meta_title) ? $cab->meta_title : "{$cab->title} Taxi & Cab Rental with Driver in Kashmir | {$brand}";
        $ctx->description = !empty($cab->meta_description)
            ? $cab->meta_description
            : Str::limit(strip_tags($cab->description ?? "Hire {$cab->title} with private verified driver in Srinagar, Gulmarg, Pahalgam & Sonamarg. 24/7 on-call travel support with {$brand}."), 155);
        $ctx->keywords = !empty($cab->meta_keywords)
            ? $cab->meta_keywords
            : "{$cab->title}, cab rental Srinagar, Kashmir taxi service, car with driver Kashmir, {$brand}";
        $ctx->ogType = 'product';
        $ctx->ogImage = self::resolveImageUrl($cab->image ?? $cab->banner_image);
        $ctx->canonical = url('/cab/' . $cab->slug);

        $ctx->breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Cab Rentals', 'url' => url('/cabs')],
            ['name' => $cab->title, 'url' => $ctx->canonical],
        ];
    }

    protected static function populateFromBlog(SeoContext $ctx, Blog $blog, string $brand): void
    {
        $ctx->title = !empty($blog->meta_title) ? $blog->meta_title : "{$blog->title} | Travel Guide | {$brand}";
        $ctx->description = !empty($blog->meta_description)
            ? $blog->meta_description
            : Str::limit(strip_tags($blog->content ?? $blog->title), 155);
        $ctx->keywords = !empty($blog->meta_keywords)
            ? $blog->meta_keywords
            : "{$blog->title}, Kashmir travel guide, visit Srinagar, {$brand}";
        $ctx->ogType = 'article';
        $ctx->ogImage = self::resolveImageUrl($blog->image ?? $blog->banner_image);
        $ctx->canonical = url('/blog/' . $blog->slug);

        $ctx->breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Travel Blogs & Guides', 'url' => url('/blogs')],
            ['name' => $blog->title, 'url' => $ctx->canonical],
        ];
    }

    protected static function populateFromDestination(SeoContext $ctx, Destination $destination, string $brand): void
    {
        $ctx->title = !empty($destination->meta_title) ? $destination->meta_title : "{$destination->title} Tourism & Travel Guide | Kashmir Destinations | {$brand}";
        $ctx->description = !empty($destination->meta_description)
            ? $destination->meta_description
            : Str::limit(strip_tags($destination->description ?? "Explore {$destination->title} with complete sightseeing guides, tour packages, taxi rates & best seasons to visit with {$brand}."), 155);
        $ctx->keywords = !empty($destination->meta_keywords)
            ? $destination->meta_keywords
            : "{$destination->title}, visit {$destination->title}, {$destination->title} tourism, Kashmir travel, {$brand}";
        $ctx->ogType = 'website';
        $ctx->ogImage = self::resolveImageUrl($destination->image ?? $destination->banner_image);
        $ctx->canonical = url('/destinations/' . $destination->slug);

        $ctx->breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Destinations', 'url' => url('/destinations')],
            ['name' => $destination->title, 'url' => $ctx->canonical],
        ];
    }

    protected static function populateFromActivity(SeoContext $ctx, Activity $activity, string $brand): void
    {
        $ctx->title = !empty($activity->meta_title) ? $activity->meta_title : "{$activity->title} in Kashmir | Adventure & Experiences | {$brand}";
        $ctx->description = !empty($activity->meta_description)
            ? $activity->meta_description
            : Str::limit(strip_tags($activity->description ?? "Book {$activity->title} experience in Kashmir. Verified guides, transparent quotes & direct local concierge with {$brand}."), 155);
        $ctx->keywords = !empty($activity->meta_keywords)
            ? $activity->meta_keywords
            : "{$activity->title}, Kashmir activities, adventure sports Kashmir, Shikara ride, Gondola Gulmarg, {$brand}";
        $ctx->ogType = 'product';
        $ctx->ogImage = self::resolveImageUrl($activity->image ?? $activity->banner_image);
        $ctx->canonical = url('/activity/' . $activity->slug);

        $ctx->breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Activities', 'url' => url('/activity')],
            ['name' => $activity->title, 'url' => $ctx->canonical],
        ];
    }

    protected static function populateFromService(SeoContext $ctx, Service $service, string $brand): void
    {
        $ctx->title = !empty($service->meta_title) ? $service->meta_title : "{$service->title} | Premium Travel Services | {$brand}";
        $ctx->description = !empty($service->meta_description)
            ? $service->meta_description
            : Str::limit(strip_tags($service->description ?? "{$service->title} by {$brand}. Dedicated native hospitality and bespoke assistance across Jammu, Kashmir & Ladakh."), 155);
        $ctx->keywords = !empty($service->meta_keywords) ? $service->meta_keywords : "{$service->title}, travel services Kashmir, {$brand}";
        $ctx->ogType = 'website';
        $ctx->ogImage = self::resolveImageUrl($service->image ?? $service->banner_image);
        $ctx->canonical = url('/service/' . $service->slug);

        $ctx->breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Services', 'url' => url('/services')],
            ['name' => $service->title, 'url' => $ctx->canonical],
        ];
    }

    protected static function populateFromPage(SeoContext $ctx, Page $page, string $brand): void
    {
        $isPolicy = in_array(strtolower($page->slug ?? ''), ['privacy-policy', 'term-condition', 'terms-and-conditions', 'terms-of-service', 'cancellation-policy']);
        $tag = $isPolicy ? "Official Policy" : "Travel Service";
        $ctx->title = !empty($page->meta_title) ? $page->meta_title : "{$page->title} | {$tag} | {$brand}";
        $ctx->description = !empty($page->meta_description)
            ? $page->meta_description
            : Str::limit(strip_tags($page->content ?? "{$page->title} guidelines and verified travel information by {$brand}."), 155);
        $ctx->keywords = !empty($page->meta_keywords) ? $page->meta_keywords : "{$page->title}, {$brand}";
        $ctx->ogType = 'website';
        $ctx->ogImage = self::resolveImageUrl($page->banner_image ?? $ctx->setting->header_logo ?? null);
        $ctx->canonical = url('/page/' . $page->slug);

        $ctx->breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => $isPolicy ? 'Policies' : 'Services', 'url' => url('/#')],
            ['name' => $page->title, 'url' => $ctx->canonical],
        ];
    }

    protected static function populateFromWedding(SeoContext $ctx, DestinationWedding $wedding, string $brand): void
    {
        $ctx->title = !empty($wedding->meta_title) ? $wedding->meta_title : "{$wedding->title} | Luxury Destination Weddings in Kashmir | {$brand}";
        $ctx->description = !empty($wedding->meta_description)
            ? $wedding->meta_description
            : Str::limit(strip_tags($wedding->description ?? "Plan unforgettable destination weddings in Kashmir at {$wedding->title} with {$brand}."), 155);
        $ctx->keywords = !empty($wedding->meta_keywords) ? $wedding->meta_keywords : "{$wedding->title}, destination wedding Kashmir, wedding venues Srinagar, {$brand}";
        $ctx->ogType = 'product';
        $ctx->ogImage = self::resolveImageUrl($wedding->image ?? $wedding->banner_image);
        $ctx->canonical = url('/destination-wedding/' . $wedding->slug);

        $ctx->breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Destination Weddings', 'url' => url('/destination-weddings')],
            ['name' => $wedding->title, 'url' => $ctx->canonical],
        ];
    }

    protected static function populateFromTourArchive(SeoContext $ctx, array $vars, string $brand): void
    {
        $stateName = isset($vars['state']->name) ? ucwords($vars['state']->name) : null;
        $catName = isset($vars['categoryTour']->title) ? $vars['categoryTour']->title : (isset($vars['category']->title) ? $vars['category']->title : null);

        if ($stateName) {
            $ctx->title = "{$stateName} Tour Packages 2026 | Best Itineraries & Cab Stays | {$brand}";
            $ctx->description = "Explore top rated {$stateName} tour packages with private cab, houseboat stays, Shikara rides & transparent quotes from native Kashmir operators.";
            $ctx->keywords = "{$stateName} tour packages, {$stateName} trip 2026, holiday in {$stateName}, {$brand}";
            $ctx->breadcrumbs = [
                ['name' => 'Home', 'url' => url('/')],
                ['name' => 'Tour Packages', 'url' => url('/tours')],
                ['name' => "{$stateName} Tours", 'url' => url()->current()],
            ];
        } elseif ($catName) {
            $ctx->title = "{$catName} Holiday Packages | Curated Kashmir Tours | {$brand}";
            $ctx->description = "Book {$catName} tour packages in Kashmir. Verified hotels, deluxe houseboats, and customized itineraries by {$brand}.";
            $ctx->keywords = "{$catName} packages, Kashmir tour packages, {$brand}";
            $ctx->breadcrumbs = [
                ['name' => 'Home', 'url' => url('/')],
                ['name' => 'Tour Packages', 'url' => url('/tours')],
                ['name' => $catName, 'url' => url()->current()],
            ];
        } else {
            $ctx->title = "Kashmir & Ladakh Tour Packages 2026 | Handcrafted Itineraries | {$brand}";
            $ctx->description = "Browse premium Kashmir holiday packages with private sanitized cabs, luxury houseboats & 24/7 native ground concierge. Direct local operator pricing.";
            $ctx->keywords = "Kashmir tour packages, Srinagar holiday, Ladakh packages, Kashmir honeymoon package, {$brand}";
            $ctx->breadcrumbs = [
                ['name' => 'Home', 'url' => url('/')],
                ['name' => 'All Tour Packages', 'url' => url('/tours')],
            ];
        }

        $ctx->ogType = 'website';
        $ctx->ogImage = self::resolveImageUrl($ctx->setting->header_logo ?? null);
        $ctx->canonical = strtok(url()->current(), '?');
    }

    protected static function populateFromHotelArchive(SeoContext $ctx, array $vars, string $brand): void
    {
        $ctx->title = "Hotels & Luxury Resorts in Kashmir | Verified Stays & Houseboats | {$brand}";
        $ctx->description = "Handpicked hotels, mountain view boutique stays & traditional deluxe houseboats in Srinagar, Gulmarg & Pahalgam with direct verified rates.";
        $ctx->keywords = "hotels in Kashmir, Srinagar hotels, Pahalgam resorts, luxury houseboats Dal Lake, Gulmarg hotels, {$brand}";
        $ctx->ogType = 'website';
        $ctx->ogImage = self::resolveImageUrl($ctx->setting->header_logo ?? null);
        $ctx->canonical = url('/hotels');
        $ctx->breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Hotels & Resorts', 'url' => $ctx->canonical],
        ];
    }

    protected static function populateFromCabArchive(SeoContext $ctx, array $vars, string $brand): void
    {
        $ctx->title = "Private Cab & Taxi Rentals in Kashmir | Srinagar, Gulmarg, Pahalgam | {$brand}";
        $ctx->description = "Book sanitized private taxis & SUVs with verified native drivers in Kashmir. Etios, Innova Crysta, Tempo Traveller at government approved transparent rates.";
        $ctx->keywords = "Kashmir taxi service, cab rental Srinagar, Innova rental Kashmir, airport taxi Srinagar, car hire Kashmir, {$brand}";
        $ctx->ogType = 'website';
        $ctx->ogImage = self::resolveImageUrl($ctx->setting->header_logo ?? null);
        $ctx->canonical = url('/cabs');
        $ctx->breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Cab Rentals', 'url' => $ctx->canonical],
        ];
    }

    protected static function populateFromDestinationArchive(SeoContext $ctx, array $vars, string $brand): void
    {
        $ctx->title = "Top Tourist Destinations in Kashmir & Ladakh | Travel Guides | {$brand}";
        $ctx->description = "Complete travel guides for Srinagar, Gulmarg, Pahalgam, Sonamarg, Doodhpathri, Gurez Valley & Ladakh. Sightseeing spots, taxi fares & weather guides.";
        $ctx->keywords = "Kashmir destinations, places to visit in Kashmir, Srinagar sightseeing, Gulmarg tourism, Pahalgam spots, {$brand}";
        $ctx->ogType = 'website';
        $ctx->ogImage = self::resolveImageUrl($ctx->setting->header_logo ?? null);
        $ctx->canonical = url('/destinations');
        $ctx->breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Destinations', 'url' => $ctx->canonical],
        ];
    }

    protected static function populateFromBlogArchive(SeoContext $ctx, array $vars, string $brand): void
    {
        $ctx->title = "Kashmir Travel Blog & Expert Insider Guides | {$brand}";
        $ctx->description = "Read expert travel advice, seasonal guides, snow forecasts, itinerary tips, local food recommendations & travel safety in Kashmir.";
        $ctx->keywords = "Kashmir travel blog, Kashmir tips, best time to visit Kashmir, Gulmarg guide, Srinagar travel tips, {$brand}";
        $ctx->ogType = 'website';
        $ctx->ogImage = self::resolveImageUrl($ctx->setting->header_logo ?? null);
        $ctx->canonical = url('/blogs');
        $ctx->breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Travel Blogs', 'url' => $ctx->canonical],
        ];
    }

    protected static function populateFromHome(SeoContext $ctx, Setting $setting, string $brand): void
    {
        $ctx->title = !empty($setting->meta_title)
            ? $setting->meta_title
            : "{$brand} — 5.0★ Tour Operator in Srinagar Kashmir | Packages, Cabs & Stays";
        $ctx->description = !empty($setting->meta_description)
            ? $setting->meta_description
            : "Handcrafted Kashmir & Ladakh holiday packages. Private sanitized cabs, luxury houseboats & custom itineraries. 5.0★ rated native concierge in Srinagar.";
        $ctx->keywords = !empty($setting->meta_keywords)
            ? $setting->meta_keywords
            : "{$brand}, Kashmir tour packages, Srinagar tour operator, Kashmir honeymoon package, Srinagar car rental with driver, Ladakh tour packages, Kashmir houseboats";
        $ctx->ogType = 'website';
        $ctx->ogImage = self::resolveImageUrl($setting->header_logo ?? null);
        $ctx->canonical = url('/');
        $ctx->breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
        ];
    }

    protected static function populateGeneral(SeoContext $ctx, ?string $customTitle, Setting $setting, string $brand): void
    {
        $resolvedTitle = !empty($customTitle) ? "{$customTitle} | {$brand}" : (!empty($setting->meta_title) ? $setting->meta_title : "{$brand} | Kashmir Tour & Travel Specialists");
        $ctx->title = $resolvedTitle;
        $ctx->description = !empty($setting->meta_description) ? $setting->meta_description : "Explore Kashmir with {$brand}. Personalized holiday packages, private transport & luxury stays.";
        $ctx->keywords = !empty($setting->meta_keywords) ? $setting->meta_keywords : "{$brand}, Kashmir travel, Srinagar tours";
        $ctx->ogType = 'website';
        $ctx->ogImage = self::resolveImageUrl($setting->header_logo ?? null);
        $ctx->canonical = strtok(url()->current(), '?');
        $ctx->breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => $customTitle ?: 'Travel', 'url' => $ctx->canonical],
        ];
    }

    /* =========================================================================
     * 3. META TAG GENERATOR
     * ========================================================================= */

    protected static function buildMetaTags(SeoContext $ctx): string
    {
        $brand = $ctx->setting->name ?? config('app.name', 'Love Link Tour & Travels');
        $html = [];

        // Primary Title & Meta
        $html[] = '<title>' . e($ctx->title) . '</title>';
        $html[] = '<meta name="description" content="' . e($ctx->description) . '">';
        if (!empty($ctx->keywords)) {
            $html[] = '<meta name="keywords" content="' . e($ctx->keywords) . '">';
        }
        $html[] = '<meta name="robots" content="' . e($ctx->robots) . '">';
        $html[] = '<meta name="author" content="' . e($brand) . '">';
        $html[] = '<link rel="canonical" href="' . e($ctx->canonical) . '">';

        // Geo Meta Signals (Crucial for Local Travel SEO)
        $html[] = '<!-- Local Travel Authority Geo Signals -->';
        $html[] = '<meta name="geo.region" content="IN-JK">';
        $html[] = '<meta name="geo.placename" content="Srinagar, Kashmir, Jammu & Kashmir">';
        $html[] = '<meta name="geo.position" content="34.0836;74.7974">';
        $html[] = '<meta name="ICBM" content="34.0836, 74.7974">';
        $html[] = '<meta name="distribution" content="global">';
        $html[] = '<meta name="rating" content="general">';

        // Open Graph
        $html[] = '<!-- Open Graph (Facebook, WhatsApp, LinkedIn) -->';
        $html[] = '<meta property="og:locale" content="en_IN">';
        $html[] = '<meta property="og:type" content="' . e($ctx->ogType) . '">';
        $html[] = '<meta property="og:title" content="' . e($ctx->title) . '">';
        $html[] = '<meta property="og:description" content="' . e($ctx->description) . '">';
        $html[] = '<meta property="og:url" content="' . e($ctx->canonical) . '">';
        $html[] = '<meta property="og:site_name" content="' . e($brand) . '">';
        if (!empty($ctx->ogImage)) {
            $html[] = '<meta property="og:image" content="' . e($ctx->ogImage) . '">';
            $html[] = '<meta property="og:image:width" content="1200">';
            $html[] = '<meta property="og:image:height" content="630">';
            $html[] = '<meta property="og:image:alt" content="' . e($ctx->title) . '">';
        }

        // Article Specific OG
        if ($ctx->pageType === 'blog' && $ctx->entity instanceof Blog) {
            $createdIso = $ctx->entity->created_at ? $ctx->entity->created_at->toIso8601String() : date('c');
            $updatedIso = $ctx->entity->updated_at ? $ctx->entity->updated_at->toIso8601String() : $createdIso;
            $html[] = '<meta property="article:published_time" content="' . e($createdIso) . '">';
            $html[] = '<meta property="article:modified_time" content="' . e($updatedIso) . '">';
            $html[] = '<meta property="article:author" content="' . e($brand) . '">';
            $html[] = '<meta property="article:section" content="Travel Guide">';
        }

        // Twitter Cards
        $html[] = '<!-- Twitter Cards -->';
        $html[] = '<meta name="twitter:card" content="summary_large_image">';
        $html[] = '<meta name="twitter:title" content="' . e($ctx->title) . '">';
        $html[] = '<meta name="twitter:description" content="' . e($ctx->description) . '">';
        if (!empty($ctx->ogImage)) {
            $html[] = '<meta name="twitter:image" content="' . e($ctx->ogImage) . '">';
        }
        $html[] = '<meta name="twitter:site" content="@LoveLinkTravels">';

        // Search Engine Bot direct hints
        $html[] = '<meta name="googlebot" content="' . e($ctx->robots) . '">';
        $html[] = '<meta name="bingbot" content="' . e($ctx->robots) . '">';

        return implode("\n", $html);
    }

    /* =========================================================================
     * 4. JSON-LD SCHEMA FACTORY
     * ========================================================================= */

    protected static function buildSchemas(SeoContext $ctx): string
    {
        $schemas = [];
        $setting = $ctx->setting;

        // 1. Sitewide Schemas (Every Page)
        $schemas[] = self::buildTravelAgencySchema($setting);
        $schemas[] = self::buildWebSiteSchema($setting);

        // 2. Breadcrumbs Schema (Every Page with > 1 crumb)
        if (!empty($ctx->breadcrumbs) && count($ctx->breadcrumbs) > 1) {
            $schemas[] = self::buildBreadcrumbSchema($ctx->breadcrumbs);
        }

        // 3. Entity-Specific Schemas
        switch ($ctx->pageType) {
            case 'tour':
                if ($ctx->entity instanceof Tour) {
                    $schemas[] = self::buildTouristTripSchema($ctx->entity, $setting);
                    $faqSchema = self::buildTourFaqSchema($ctx->entity);
                    if ($faqSchema) $schemas[] = $faqSchema;
                    $schemas[] = self::buildSpeakableSchema(['.kaw-pkg-title', '.kz-day-title', '.kz-tour-header']);
                }
                break;

            case 'hotel':
                if ($ctx->entity instanceof Hotel) {
                    $schemas[] = self::buildHotelSchema($ctx->entity, $setting);
                }
                break;

            case 'cab':
                if ($ctx->entity instanceof Cab) {
                    $schemas[] = self::buildCabSchema($ctx->entity, $setting);
                }
                break;

            case 'blog':
                if ($ctx->entity instanceof Blog) {
                    $schemas[] = self::buildBlogPostingSchema($ctx->entity, $setting);
                    $schemas[] = self::buildSpeakableSchema(['h1', '.blog-single-title', 'article p']);
                }
                break;

            case 'destination':
                if ($ctx->entity instanceof Destination) {
                    $schemas[] = self::buildDestinationSchema($ctx->entity, $setting);
                }
                break;

            case 'home':
                $schemas[] = self::buildHomeFaqSchema($setting);
                $schemas[] = self::buildSpeakableSchema(['h1', '.hero-title', '.kz-brand-tagline']);
                break;

            case 'tour_archive':
            case 'hotel_archive':
            case 'cab_archive':
            case 'destination_archive':
            case 'blog_archive':
                $schemas[] = self::buildCollectionPageSchema($ctx);
                break;
        }

        $html = [];
        foreach ($schemas as $s) {
            if (!empty($s)) {
                $html[] = '<script type="application/ld+json">' . json_encode($s, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
            }
        }

        return implode("\n", $html);
    }

    /**
     * Sitewide TravelAgency & LocalBusiness Schema
     */
    protected static function buildTravelAgencySchema(Setting $setting): array
    {
        $baseUrl = rtrim(url('/'), '/');
        $brand = $setting->name ?? config('app.name', 'Love Link Tour & Travels');
        $phone = $setting->phone ?: ($setting->phone1 ?: '917006338617');
        $phoneClean = '+' . preg_replace('/[^0-9]/', '', (string)$phone);
        $logoUrl = self::resolveImageUrl($setting->header_logo ?? null);

        return [
            '@context' => 'https://schema.org',
            '@type' => ['TravelAgency', 'LocalBusiness'],
            '@id' => "{$baseUrl}#organization",
            'name' => $brand,
            'legalName' => "{$brand} Tour & Travels Pvt. Ltd.",
            'url' => $baseUrl,
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $logoUrl,
                'width' => 160,
                'height' => 48,
            ],
            'image' => $logoUrl,
            'description' => !empty($setting->meta_description)
                ? $setting->meta_description
                : "{$brand} is a premier tour operator based in Srinagar, offering customized Kashmir and Ladakh tour packages, luxury houseboat bookings, and private car rentals with native drivers.",
            'telephone' => $phoneClean,
            'email' => $setting->email ?? 'info@lovelink.in',
            'priceRange' => '₹₹ - ₹₹₹',
            'currenciesAccepted' => 'INR',
            'paymentAccepted' => 'Cash, Credit Card, Bank Transfer, UPI, Net Banking',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $setting->address ?? 'Boulevard Road, Near Dal Lake',
                'addressLocality' => 'Srinagar',
                'addressRegion' => 'Jammu and Kashmir',
                'postalCode' => '190001',
                'addressCountry' => 'IN',
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => '34.0836',
                'longitude' => '74.7974',
            ],
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                    'opens' => '00:00',
                    'closes' => '23:59',
                ]
            ],
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '5.0',
                'reviewCount' => '148',
                'bestRating' => '5',
                'worstRating' => '1',
            ],
            'areaServed' => [
                ['@type' => 'City', 'name' => 'Srinagar'],
                ['@type' => 'AdministrativeArea', 'name' => 'Kashmir'],
                ['@type' => 'AdministrativeArea', 'name' => 'Ladakh'],
                ['@type' => 'TouristAttraction', 'name' => 'Gulmarg'],
                ['@type' => 'TouristAttraction', 'name' => 'Pahalgam'],
                ['@type' => 'TouristAttraction', 'name' => 'Sonamarg'],
                ['@type' => 'TouristAttraction', 'name' => 'Gurez Valley'],
            ],
            'sameAs' => array_values(array_filter([
                'https://www.facebook.com/lovelinktravels',
                'https://www.instagram.com/lovelinktravels',
                'https://www.youtube.com/@lovelinktravels',
            ])),
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'Kashmir & Ladakh Travel Packages & Fleet',
                'itemListElement' => [
                    ['@type' => 'Offer', 'itemOffered' => ['@type' => 'TouristTrip', 'name' => 'Kashmir Holiday Tour Packages']],
                    ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Private Cab & Taxi Rentals in Kashmir']],
                    ['@type' => 'Offer', 'itemOffered' => ['@type' => 'LodgingBusiness', 'name' => 'Luxury Houseboats & Hotel Stays']],
                ]
            ]
        ];
    }

    /**
     * WebSite Schema with Sitelinks SearchBox
     */
    protected static function buildWebSiteSchema(Setting $setting): array
    {
        $baseUrl = rtrim(url('/'), '/');
        $brand = $setting->name ?? config('app.name', 'Love Link Tour & Travels');

        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => "{$baseUrl}#website",
            'url' => $baseUrl,
            'name' => $brand,
            'description' => $setting->meta_description ?? "{$brand} - Handcrafted Kashmir Tour Packages & Taxi Fleet",
            'publisher' => ['@id' => "{$baseUrl}#organization"],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => "{$baseUrl}/tours?search={search_term_string}",
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /**
     * BreadcrumbList Schema
     */
    protected static function buildBreadcrumbSchema(array $crumbs): array
    {
        $items = [];
        $pos = 1;
        foreach ($crumbs as $c) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $pos++,
                'name' => $c['name'],
                'item' => $c['url'],
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
    }

    /**
     * TouristTrip + Product Schema for Tours
     */
    protected static function buildTouristTripSchema(Tour $tour, Setting $setting): array
    {
        $baseUrl = rtrim(url('/'), '/');
        $brand = $setting->name ?? config('app.name', 'Love Link Tour & Travels');
        $tourUrl = route('tour.details', $tour->slug);
        $phone = $setting->phone ?: '917006338617';
        $phoneClean = '+' . preg_replace('/[^0-9]/', '', (string)$phone);

        $priceClean = preg_replace('/[^0-9.]/', '', (string)$tour->price);
        $discountPriceClean = preg_replace('/[^0-9.]/', '', (string)$tour->discount_price);
        $finalPrice = !empty($discountPriceClean) && (float)$discountPriceClean > 0 ? $discountPriceClean : $priceClean;

        // Parse Itinerary ItemList
        $itineraryItems = [];
        $rawItinerary = $tour->itinerary;
        if (is_string($rawItinerary)) {
            $rawItinerary = json_decode($rawItinerary, true);
        }
        if (is_array($rawItinerary)) {
            $dayIdx = 1;
            foreach ($rawItinerary as $day) {
                $title = is_array($day) ? ($day['title'] ?? ($day['day'] ?? "Day {$dayIdx}")) : "Day {$dayIdx}";
                $body = is_array($day) ? ($day['description'] ?? ($day['body'] ?? '')) : (string)$day;
                $itineraryItems[] = [
                    '@type' => 'ListItem',
                    'position' => $dayIdx++,
                    'name' => "Day " . str_pad($dayIdx - 1, 2, '0', STR_PAD_LEFT) . ": " . strip_tags($title),
                    'description' => Str::limit(strip_tags($body), 250),
                ];
            }
        }

        // Images array
        $images = [self::resolveImageUrl($tour->image)];
        if (!empty($tour->banner_image)) {
            $images[] = self::resolveImageUrl($tour->banner_image);
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => ['TouristTrip', 'Product'],
            '@id' => "{$tourUrl}#touristtrip",
            'name' => $tour->title . (!empty($tour->duration) ? " ({$tour->duration})" : ""),
            'url' => $tourUrl,
            'description' => !empty($tour->meta_description) ? $tour->meta_description : Str::limit(strip_tags($tour->short_description ?? $tour->description), 200),
            'image' => array_values(array_unique(array_filter($images))),
            'touristType' => ['Family', 'Couple', 'Honeymoon', 'Adventure', 'Leisure Group'],
            'provider' => ['@id' => "{$baseUrl}#organization"],
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => !empty($tour->rating) ? (string)$tour->rating : '5.0',
                'reviewCount' => '64',
                'bestRating' => '5',
                'worstRating' => '1',
            ],
            'duration' => self::parseDurationToIso8601($tour->duration ?? '3N | 4D'),
            'inLanguage' => 'en-IN',
            'additionalProperty' => [
                ['@type' => 'PropertyValue', 'name' => 'Duration', 'value' => $tour->duration ?? 'Customized'],
                ['@type' => 'PropertyValue', 'name' => 'Vehicle', 'value' => 'Private Sanitized Cab Included'],
                ['@type' => 'PropertyValue', 'name' => 'Stays', 'value' => 'Hotel & Traditional Houseboat'],
                ['@type' => 'PropertyValue', 'name' => 'Concierge', 'value' => '24/7 Dedicated Native Ground Care'],
            ]
        ];

        if (!empty($itineraryItems)) {
            $schema['itinerary'] = [
                '@type' => 'ItemList',
                'name' => "{$tour->title} - Daily Itinerary",
                'itemListElement' => $itineraryItems,
            ];
        }

        if (!empty($finalPrice)) {
            $schema['offers'] = [
                '@type' => 'Offer',
                'priceCurrency' => 'INR',
                'price' => $finalPrice,
                'priceValidUntil' => (date('Y') + 1) . '-12-31',
                'availability' => 'https://schema.org/InStock',
                'url' => $tourUrl,
                'seller' => ['@id' => "{$baseUrl}#organization"],
            ];
        }

        return $schema;
    }

    /**
     * Tour FAQ extraction from Include/Exclude and Booking/Cancellation policies
     */
    protected static function buildTourFaqSchema(Tour $tour): ?array
    {
        $faqs = [];

        // 1. Inclusions FAQ
        $incExc = $tour->include_exclude;
        if (is_string($incExc)) $incExc = json_decode($incExc, true);
        if (!empty($incExc['included']) && is_array($incExc['included'])) {
            $items = array_map('strip_tags', $incExc['included']);
            $faqs[] = [
                '@type' => 'Question',
                'name' => "What is included in the {$tour->title} package?",
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => implode(', ', array_slice($items, 0, 8)) . '.'
                ]
            ];
        }

        // 2. Cancellation FAQ
        if (!empty($tour->cancellation)) {
            $cancelText = is_array($tour->cancellation) ? json_encode($tour->cancellation) : (string)$tour->cancellation;
            $faqs[] = [
                '@type' => 'Question',
                'name' => "What is the cancellation policy for {$tour->title}?",
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => Str::limit(strip_tags($cancelText), 250)
                ]
            ];
        }

        // 3. Cab & Driver FAQ
        $faqs[] = [
            '@type' => 'Question',
            'name' => "Is private transportation and sightseeing included in this tour?",
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => "Yes, all our Kashmir packages include a dedicated private cab with an experienced native driver for airport transfers, destination travel and all point-to-point sightseeing as per the itinerary."
            ]
        ];

        if (empty($faqs)) {
            return null;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $faqs,
        ];
    }

    /**
     * LodgingBusiness Schema for Hotels
     */
    protected static function buildHotelSchema(Hotel $hotel, Setting $setting): array
    {
        $baseUrl = rtrim(url('/'), '/');
        $hotelUrl = url('/hotel/' . $hotel->slug);
        $price = preg_replace('/[^0-9.]/', '', (string)$hotel->price);

        return [
            '@context' => 'https://schema.org',
            '@type' => ['LodgingBusiness', 'Hotel'],
            '@id' => "{$hotelUrl}#hotel",
            'name' => $hotel->title,
            'url' => $hotelUrl,
            'image' => self::resolveImageUrl($hotel->image ?? $hotel->banner_image),
            'description' => !empty($hotel->meta_description) ? $hotel->meta_description : Str::limit(strip_tags($hotel->description ?? ''), 200),
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $hotel->location ?: 'Srinagar',
                'addressRegion' => 'Jammu and Kashmir',
                'addressCountry' => 'IN',
            ],
            'priceRange' => !empty($price) ? "₹{$price} per night" : "₹₹ - ₹₹₹",
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '4.8',
                'reviewCount' => '42',
                'bestRating' => '5',
            ],
            'offers' => [
                '@type' => 'Offer',
                'priceCurrency' => 'INR',
                'price' => !empty($price) ? $price : '3500',
                'availability' => 'https://schema.org/InStock',
                'url' => $hotelUrl,
                'seller' => ['@id' => "{$baseUrl}#organization"],
            ]
        ];
    }

    /**
     * Vehicle & Service Schema for Cabs
     */
    protected static function buildCabSchema(Cab $cab, Setting $setting): array
    {
        $baseUrl = rtrim(url('/'), '/');
        $cabUrl = url('/cab/' . $cab->slug);
        $price = preg_replace('/[^0-9.]/', '', (string)$cab->price);

        return [
            '@context' => 'https://schema.org',
            '@type' => ['Service', 'Product'],
            '@id' => "{$cabUrl}#service",
            'name' => "{$cab->title} Car Rental with Native Driver in Kashmir",
            'serviceType' => 'Private Taxi & Sightseeing Cab Service',
            'description' => !empty($cab->meta_description) ? $cab->meta_description : Str::limit(strip_tags($cab->description ?? ''), 200),
            'image' => self::resolveImageUrl($cab->image ?? $cab->banner_image),
            'provider' => ['@id' => "{$baseUrl}#organization"],
            'areaServed' => [
                ['@type' => 'AdministrativeArea', 'name' => 'Kashmir'],
                ['@type' => 'City', 'name' => 'Srinagar'],
            ],
            'offers' => [
                '@type' => 'Offer',
                'priceCurrency' => 'INR',
                'price' => !empty($price) ? $price : '2500',
                'availability' => 'https://schema.org/InStock',
                'url' => $cabUrl,
                'seller' => ['@id' => "{$baseUrl}#organization"],
            ],
            'additionalProperty' => [
                ['@type' => 'PropertyValue', 'name' => 'Seating Capacity', 'value' => $cab->seating_capacity ?? '4-7 Passengers'],
                ['@type' => 'PropertyValue', 'name' => 'Driver', 'value' => 'Verified Native Professional Driver Included'],
                ['@type' => 'PropertyValue', 'name' => 'Sanitization', 'value' => 'Cleaned & Sanitized Fleet'],
            ]
        ];
    }

    /**
     * BlogPosting Schema for Blogs
     */
    protected static function buildBlogPostingSchema(Blog $blog, Setting $setting): array
    {
        $baseUrl = rtrim(url('/'), '/');
        $blogUrl = url('/blog/' . $blog->slug);
        $brand = $setting->name ?? config('app.name', 'Love Link Tour & Travels');
        $logoUrl = self::resolveImageUrl($setting->header_logo ?? null);
        $createdIso = $blog->created_at ? $blog->created_at->toIso8601String() : date('c');
        $updatedIso = $blog->updated_at ? $blog->updated_at->toIso8601String() : $createdIso;
        $cleanContent = strip_tags($blog->content ?? '');

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            '@id' => "{$blogUrl}#article",
            'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $blogUrl],
            'headline' => $blog->title,
            'description' => !empty($blog->meta_description) ? $blog->meta_description : Str::limit($cleanContent, 180),
            'image' => [
                '@type' => 'ImageObject',
                'url' => self::resolveImageUrl($blog->image ?? $blog->banner_image),
                'width' => 1200,
                'height' => 630,
            ],
            'datePublished' => $createdIso,
            'dateModified' => $updatedIso,
            'author' => [
                '@type' => 'Organization',
                'name' => $brand,
                'url' => $baseUrl,
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => $brand,
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => $logoUrl,
                ],
            ],
            'wordCount' => str_word_count($cleanContent),
            'articleSection' => 'Travel Guide',
            'inLanguage' => 'en-IN',
            'about' => [
                '@type' => 'Place',
                'name' => 'Kashmir',
            ]
        ];
    }

    /**
     * TouristDestination Schema
     */
    protected static function buildDestinationSchema(Destination $dest, Setting $setting): array
    {
        $destUrl = url('/destinations/' . $dest->slug);

        return [
            '@context' => 'https://schema.org',
            '@type' => 'TouristDestination',
            '@id' => "{$destUrl}#destination",
            'name' => $dest->title,
            'description' => !empty($dest->meta_description) ? $dest->meta_description : Str::limit(strip_tags($dest->description ?? ''), 200),
            'image' => self::resolveImageUrl($dest->image ?? $dest->banner_image),
            'touristType' => ['Family', 'Honeymoon', 'Adventure', 'Nature Lovers'],
            'containedInPlace' => [
                '@type' => 'AdministrativeArea',
                'name' => 'Jammu and Kashmir',
                'addressCountry' => 'IN',
            ],
        ];
    }

    /**
     * CollectionPage Schema for Archives
     */
    protected static function buildCollectionPageSchema(SeoContext $ctx): array
    {
        $baseUrl = rtrim(url('/'), '/');

        return [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            '@id' => "{$ctx->canonical}#collectionpage",
            'name' => $ctx->title,
            'url' => $ctx->canonical,
            'description' => $ctx->description,
            'provider' => ['@id' => "{$baseUrl}#organization"],
        ];
    }

    /**
     * Homepage General FAQ Schema
     */
    protected static function buildHomeFaqSchema(Setting $setting): array
    {
        $brand = $setting->name ?? config('app.name', 'Love Link Tour & Travels');

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => [
                [
                    '@type' => 'Question',
                    'name' => 'What is the best time to visit Kashmir?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Kashmir is a year-round destination: Spring (March–May) brings blossoming tulips and gardens; Summer (June–August) offers pleasant mountain weather; Autumn (September–November) features stunning golden Chinar leaves; and Winter (December–February) turns Gulmarg and Sonamarg into snow paradises.'
                    ]
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Are private cabs and native drivers included in tour packages?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => "Yes, {$brand} provides dedicated private vehicles (Sedans, SUVs like Innova Crysta, and Tempo Travellers) with verified, native chauffeurs who assist with sightseeing and airport transfers."
                    ]
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Is it safe to travel to Kashmir with family and kids?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => "Absolutely. Kashmir welcomes millions of domestic and international travelers each year. Our 24/7 on-ground concierge and local driver network ensure a seamless, safe, and comfortable family vacation."
                    ]
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Can we customize our Kashmir tour itinerary?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => "Yes! Every traveler has unique preferences. You can customize the number of days, hotel tiers (3-star, 4-star, 5-star, or luxury houseboats on Dal Lake), destinations (Gulmarg, Pahalgam, Sonamarg, Gurez, Doodhpathri), and activities."
                    ]
                ],
            ]
        ];
    }

    /**
     * Speakable Schema Specification (Voice Search Optimization)
     */
    protected static function buildSpeakableSchema(array $selectors): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'SpeakableSpecification',
            'cssSelector' => $selectors,
        ];
    }

    /* =========================================================================
     * 5. SITEMAP GENERATOR (With Image Sitemap Extensions)
     * ========================================================================= */

    /**
     * Generate XML Sitemap Index or specific sub-sitemap.
     */
    public static function generateSitemapXml(?string $type = null)
    {
        $baseUrl = rtrim(url('/'), '/');
        $typeKey = $type ?: 'index';

        $xml = Cache::remember("seo_sitemap_xml_{$typeKey}", 43200, function () use ($baseUrl, $type) {
            // Master Sitemap Index
            if (empty($type) || $type === 'index') {
                $submaps = [
                    ['loc' => "{$baseUrl}/sitemap-static.xml", 'lastmod' => date('Y-m-d')],
                    ['loc' => "{$baseUrl}/sitemap-tours.xml", 'lastmod' => Tour::max('updated_at') ? (new \DateTime(Tour::max('updated_at')))->format('Y-m-d') : date('Y-m-d')],
                    ['loc' => "{$baseUrl}/sitemap-hotels.xml", 'lastmod' => Hotel::max('updated_at') ? (new \DateTime(Hotel::max('updated_at')))->format('Y-m-d') : date('Y-m-d')],
                    ['loc' => "{$baseUrl}/sitemap-cabs.xml", 'lastmod' => Cab::max('updated_at') ? (new \DateTime(Cab::max('updated_at')))->format('Y-m-d') : date('Y-m-d')],
                    ['loc' => "{$baseUrl}/sitemap-destinations.xml", 'lastmod' => Destination::max('updated_at') ? (new \DateTime(Destination::max('updated_at')))->format('Y-m-d') : date('Y-m-d')],
                    ['loc' => "{$baseUrl}/sitemap-blogs.xml", 'lastmod' => Blog::max('updated_at') ? (new \DateTime(Blog::max('updated_at')))->format('Y-m-d') : date('Y-m-d')],
                    ['loc' => "{$baseUrl}/sitemap-pages.xml", 'lastmod' => Page::max('updated_at') ? (new \DateTime(Page::max('updated_at')))->format('Y-m-d') : date('Y-m-d')],
                ];

                $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
                $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
                foreach ($submaps as $sm) {
                    $xml .= "  <sitemap>\n";
                    $xml .= "    <loc>" . htmlspecialchars($sm['loc']) . "</loc>\n";
                    $xml .= "    <lastmod>" . $sm['lastmod'] . "</lastmod>\n";
                    $xml .= "  </sitemap>\n";
                }
                $xml .= '</sitemapindex>';

                return $xml;
            }

        // Sub-Sitemaps with Image extensions
        $urls = [];
        switch ($type) {
            case 'static':
                $staticRoutes = [
                    ['url' => "{$baseUrl}/", 'priority' => '1.0', 'changefreq' => 'daily'],
                    ['url' => "{$baseUrl}/tours", 'priority' => '0.9', 'changefreq' => 'daily'],
                    ['url' => "{$baseUrl}/hotels", 'priority' => '0.9', 'changefreq' => 'daily'],
                    ['url' => "{$baseUrl}/cabs", 'priority' => '0.9', 'changefreq' => 'weekly'],
                    ['url' => "{$baseUrl}/destinations", 'priority' => '0.8', 'changefreq' => 'weekly'],
                    ['url' => "{$baseUrl}/blogs", 'priority' => '0.8', 'changefreq' => 'weekly'],
                    ['url' => "{$baseUrl}/activity", 'priority' => '0.8', 'changefreq' => 'weekly'],
                    ['url' => "{$baseUrl}/about-us", 'priority' => '0.7', 'changefreq' => 'monthly'],
                    ['url' => "{$baseUrl}/contact-us", 'priority' => '0.7', 'changefreq' => 'monthly'],
                    ['url' => "{$baseUrl}/faqs", 'priority' => '0.7', 'changefreq' => 'monthly'],
                ];
                foreach ($staticRoutes as $r) {
                    $urls[] = [
                        'loc' => $r['url'],
                        'lastmod' => date('Y-m-d'),
                        'changefreq' => $r['changefreq'],
                        'priority' => $r['priority'],
                    ];
                }
                break;

            case 'tours':
                foreach (Tour::all() as $t) {
                    $img = self::resolveImageUrl($t->image ?? $t->banner_image);
                    $urls[] = [
                        'loc' => route('tour.details', $t->slug),
                        'lastmod' => $t->updated_at ? $t->updated_at->format('Y-m-d') : date('Y-m-d'),
                        'changefreq' => 'weekly',
                        'priority' => '0.9',
                        'image' => [
                            'loc' => $img,
                            'title' => $t->title,
                            'caption' => "Kashmir Tour Package - {$t->title}"
                        ]
                    ];
                }
                break;

            case 'hotels':
                foreach (Hotel::all() as $h) {
                    $img = self::resolveImageUrl($h->image ?? $h->banner_image);
                    $urls[] = [
                        'loc' => url('/hotel/' . $h->slug),
                        'lastmod' => $h->updated_at ? $h->updated_at->format('Y-m-d') : date('Y-m-d'),
                        'changefreq' => 'weekly',
                        'priority' => '0.8',
                        'image' => [
                            'loc' => $img,
                            'title' => $h->title,
                            'caption' => "Hotel & Resort Stay - {$h->title}"
                        ]
                    ];
                }
                break;

            case 'cabs':
                foreach (Cab::all() as $c) {
                    $img = self::resolveImageUrl($c->image ?? $c->banner_image);
                    $urls[] = [
                        'loc' => url('/cab/' . $c->slug),
                        'lastmod' => $c->updated_at ? $c->updated_at->format('Y-m-d') : date('Y-m-d'),
                        'changefreq' => 'weekly',
                        'priority' => '0.8',
                        'image' => [
                            'loc' => $img,
                            'title' => $c->title,
                            'caption' => "Private Taxi Rental - {$c->title}"
                        ]
                    ];
                }
                break;

            case 'destinations':
                foreach (Destination::all() as $d) {
                    $img = self::resolveImageUrl($d->image ?? $d->banner_image);
                    $urls[] = [
                        'loc' => url('/destinations/' . $d->slug),
                        'lastmod' => $d->updated_at ? $d->updated_at->format('Y-m-d') : date('Y-m-d'),
                        'changefreq' => 'weekly',
                        'priority' => '0.8',
                        'image' => [
                            'loc' => $img,
                            'title' => $d->title,
                            'caption' => "Kashmir Destination Guide - {$d->title}"
                        ]
                    ];
                }
                break;

            case 'blogs':
                foreach (Blog::all() as $b) {
                    $img = self::resolveImageUrl($b->image ?? $b->banner_image);
                    $urls[] = [
                        'loc' => url('/blog/' . $b->slug),
                        'lastmod' => $b->updated_at ? $b->updated_at->format('Y-m-d') : date('Y-m-d'),
                        'changefreq' => 'monthly',
                        'priority' => '0.7',
                        'image' => [
                            'loc' => $img,
                            'title' => $b->title,
                            'caption' => $b->title
                        ]
                    ];
                }
                break;

            case 'pages':
                foreach (Page::all() as $p) {
                    $urls[] = [
                        'loc' => url('/page/' . $p->slug),
                        'lastmod' => $p->updated_at ? $p->updated_at->format('Y-m-d') : date('Y-m-d'),
                        'changefreq' => 'yearly',
                        'priority' => '0.6',
                    ];
                }
                break;
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";
        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($u['loc']) . "</loc>\n";
            $xml .= "    <lastmod>" . $u['lastmod'] . "</lastmod>\n";
            $xml .= "    <changefreq>" . ($u['changefreq'] ?? 'weekly') . "</changefreq>\n";
            $xml .= "    <priority>" . ($u['priority'] ?? '0.7') . "</priority>\n";
            if (!empty($u['image']['loc'])) {
                $xml .= "    <image:image>\n";
                $xml .= "      <image:loc>" . htmlspecialchars($u['image']['loc']) . "</image:loc>\n";
                if (!empty($u['image']['title'])) {
                    $xml .= "      <image:title>" . htmlspecialchars($u['image']['title']) . "</image:title>\n";
                }
                if (!empty($u['image']['caption'])) {
                    $xml .= "      <image:caption>" . htmlspecialchars($u['image']['caption']) . "</image:caption>\n";
                }
                $xml .= "    </image:image>\n";
            }
            $xml .= "  </url>\n";
        }
        $xml .= '</urlset>';

        return $xml;
    });

    return Response::make($xml, 200)->header('Content-Type', 'application/xml');
}

    /* =========================================================================
     * 6. ROBOTS.TXT GENERATOR
     * ========================================================================= */

    /**
     * Generate optimized robots.txt output.
     */
    public static function generateRobotsTxt()
    {
        $baseUrl = rtrim(url('/'), '/');

        $lines = [
            "User-agent: *",
            "Allow: /",
            "Disallow: /admin",
            "Disallow: /admin/",
            "Disallow: /marina",
            "Disallow: /marina/",
            "Disallow: /login",
            "Disallow: /register",
            "Disallow: /*?*orderby=",
            "Disallow: /*?*page=",
            "Disallow: /api/",
            "",
            "# Allow core render assets",
            "Allow: /webassets/css/style.css",
            "Allow: /webassets/js/main.js",
            "",
            "# Block unauthorized aggressive AI crawlers",
            "User-agent: GPTBot",
            "Disallow: /",
            "",
            "User-agent: CCBot",
            "Disallow: /",
            "",
            "User-agent: anthropic-ai",
            "Disallow: /",
            "",
            "Crawl-delay: 1",
            "",
            "# Master XML Sitemap Index",
            "Sitemap: {$baseUrl}/sitemap.xml",
        ];

        return Response::make(implode("\n", $lines) . "\n", 200)
            ->header('Content-Type', 'text/plain');
    }

    /* =========================================================================
     * 7. HELPERS & UTILITIES
     * ========================================================================= */

    protected static function getSetting(): Setting
    {
        return Cache::remember('global_setting_seo', 86400, function () {
            return Setting::find(1) ?: new Setting();
        });
    }

    protected static function resolveImageUrl(?string $path): string
    {
        if (empty($path)) {
            return asset('webassets/img/hero-banner.jpg');
        }
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }
        return asset('storage/' . ltrim($path, '/'));
    }

    /**
     * Parse text durations like "3N | 4D", "4N 5D", "6 Days" into standard ISO 8601 duration (e.g. P4D)
     */
    protected static function parseDurationToIso8601(string $duration): string
    {
        $duration = trim($duration);
        if (preg_match('/^(\d+)$/', $duration, $m)) {
            return "P{$m[1]}D";
        }
        if (preg_match('/(\d+)\s*[Dd]/i', $duration, $m)) {
            $days = (int)$m[1];
            return "P{$days}D";
        }
        if (preg_match('/(\d+)\s*[Nn]/i', $duration, $m)) {
            $days = ((int)$m[1]) + 1;
            return "P{$days}D";
        }
        return "P4D";
    }
}

/**
 * Value Object DTO holding resolved SEO metadata for the current request
 */
class SeoContext
{
    public string $pageType = 'general';
    public ?Model $entity = null;
    public ?Setting $setting = null;
    public string $title = '';
    public string $description = '';
    public string $keywords = '';
    public string $canonical = '';
    public string $robots = 'index, follow';
    public string $ogType = 'website';
    public string $ogImage = '';
    public array $breadcrumbs = [];
}
