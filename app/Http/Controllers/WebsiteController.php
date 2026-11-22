<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Blog;
use App\Models\Country;
use App\Models\State;
use App\Models\Activity;
use App\Models\Destination;
use App\Models\Gallery;
use App\Models\Partner;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Cab;
use App\Models\Hotel;
use App\Models\DestinationWedding;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\DestinationCategory;
use App\Models\TouristGuide;
use App\Models\Faq;
use App\Models\Page;
use App\Models\GlobalBooking;
use App\Mail\GlobalBookingMail;
use App\Models\{Contact, YouTubeData, SliderIcon, TravelBestie};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Setting;

class WebsiteController extends Controller
{
    protected function getActiveLocations()
    {
        return Cache::remember('active_destination_locations', 3600, function () {
            return Destination::where('status', 1)
                ->select('location', DB::raw('COUNT(*) as count'))
                ->groupBy('location')
                ->get();
        });
    }

    protected function getActiveCategoryTour()
    {
        return Cache::remember('active_tour_categories_count', 3600, function () {
            return TourCategory::where('status', 1)
                ->select('name', DB::raw('COUNT(*) as count'))
                ->groupBy('name')
                ->get();
        });
    }

    public function home()
    {
        // Curated homepage dataset cached for 2 hours (zero SQL overhead for repeat visitors)
        $homeData = Cache::remember('homepage_curated_data', 7200, function () {
            $sliders = Slider::where(function ($query) {
                $query->where(function ($q) {
                    $q->where('spiti_is_colder', '<>', 'yes')
                        ->orWhereNull('spiti_is_colder');
                })
                    ->where(function ($q) {
                        $q->where('domestic_trip', '<>', 'yes')
                            ->orWhereNull('domestic_trip');
                    })
                    ->where(function ($q) {
                        $q->where('contact_us', '<>', 'yes')
                            ->orWhereNull('contact_us');
                    });
            })->get();

            $blogs = Blog::latest()->limit(8)->get();
            $activities = Activity::latest()->limit(5)->get();
            $destinations = Destination::withCount('tours')->latest()->take(5)->get();
            $destinations_all = $destinations;
            $galleries = Gallery::orderBy('order', 'asc')->images()->limit(7)->get();
            $partners = Partner::latest()->limit(8)->get();
            $services = Service::latest()->limit(5)->get();
            $testimonials = Testimonial::latest()->limit(5)->get();
            $tours = Tour::where(function ($query) {
                $query->where('domestic_trip', '<>', 'yes')
                    ->orWhereNull('domestic_trip')
                    ->where('type', '1');
            })
                ->latest()
                ->take(8)
                ->get();

            $faqs = Faq::latest()->limit(6)->get();
            $categories = TourCategory::latest()->limit(25)->get();
            $guides = TouristGuide::latest()->limit(5)->get();
            $sliderDomestic = Slider::where('domestic_trip', 'yes')->latest()->take(1)->first();
            $sliderSpiti = Slider::where('spiti_is_colder', 'yes')->latest()->take(1)->first();
            $youtube = YouTubeData::where('status', 1)->get();
            $slidericon = SliderIcon::where('status', 1)->get();
            $travelBestie = TravelBestie::where('status', 1)->latest()->take(6)->get();
            $hotels = Hotel::where('status', 1)->latest()->take(12)->get();
            $cabs = Cab::where('status', 1)
                ->orderByRaw('CASE WHEN `order` IS NULL THEN 1 ELSE 0 END, `order` ASC, id DESC')
                ->get();
            $countries = Country::with([
                'states' => function ($q) {
                    $q->where('status', 1)
                        ->withCount('tours')
                        ->orderBy('order', 'asc');
                }
            ])
                ->where('status', 1)
                ->orderBy('name')
                ->get();

            return compact(
                'sliders',
                'blogs',
                'activities',
                'destinations',
                'destinations_all',
                'galleries',
                'partners',
                'services',
                'testimonials',
                'tours',
                'categories',
                'guides',
                'faqs',
                'youtube',
                'slidericon',
                'travelBestie',
                'sliderSpiti',
                'sliderDomestic',
                'countries',
                'cabs',
                'hotels'
            );
        });

        // Fetch Google Reviews (cached for 24 hours with fast 3s timeout)
        $reviewData = Cache::remember('google_reviews', now()->addHours(24), function () {
            try {
                $response = Http::timeout(3)->get('https://maps.googleapis.com/maps/api/place/details/json', [
                    'place_id' => config('services.google.place_id'),
                    'fields' => 'name,rating,user_ratings_total,reviews,url',
                    'key' => config('services.google.places_api_key'),
                    'reviews_sort' => 'newest',
                ]);

                if ($response->successful()) {
                    $result = $response->json('result');
                    return [
                        'business_name' => $result['name'] ?? '',
                        'overall_rating' => $result['rating'] ?? 0,
                        'total_reviews' => $result['user_ratings_total'] ?? 0,
                        'google_url' => $result['url'] ?? '#',
                        'reviews' => $result['reviews'] ?? [],
                    ];
                }

                return [
                    'business_name' => '',
                    'overall_rating' => 0,
                    'total_reviews' => 0,
                    'google_url' => '#',
                    'reviews' => [],
                ];
            } catch (\Exception $e) {
                return [
                    'business_name' => '',
                    'overall_rating' => 0,
                    'total_reviews' => 0,
                    'google_url' => '#',
                    'reviews' => [],
                ];
            }
        });

        return view('frontend.home.index', array_merge($homeData, ['reviewData' => $reviewData]));
    }

    public function globalBookingSubmit(Request $request)
    {
        $rules = [
            'booking_type' => 'required|in:cab,hotel',
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date|after_or_equal:checkin_date',
            'adults' => 'required|integer|min:1|max:20',
        ];

        if ($request->booking_type === 'cab') {
            $rules['pickup_location'] = 'required|string|max:255';
            $rules['drop_location'] = 'required|string|max:255';
            $rules['pickup_time'] = 'required';
        } else {
            $rules['hotel_location'] = 'required|string|max:255';
            $rules['rooms'] = 'required|integer|min:1|max:20';
            $rules['kids'] = 'nullable|integer|min:0|max:20';
        }

        $validated = $request->validate($rules);

        GlobalBooking::create($validated);

        $setting = Setting::first();
        $adminEmail = $setting->email ?? null;
        if ($adminEmail) {
            Mail::to($adminEmail)->send(new GlobalBookingMail($validated));
        }

        return redirect()->back()->with('success', 'Your booking request has been received! We will contact you shortly.');
    }
    public function aboutus()
    {
        $galleries = Gallery::orderBy('order', 'asc')->images()->limit(7)->get();
        $partners = Partner::latest()->limit(8)->get();
        $services = Service::latest()->limit(6)->get();
        $testimonials = Testimonial::latest()->limit(6)->get();
        $guides = TouristGuide::latest()->limit(6)->get();
        $youtube = YouTubeData::where('status', 1)->get();
        return view('frontend.home.aboutus', compact('services', 'testimonials', 'partners', 'galleries', 'guides', 'youtube'));
    }
    public function faq()
    {
        $faqs = Faq::latest()->get();
        return view('frontend.faq.index', compact('faqs'));
    }
    public function destinationsindex(Request $request)
    {
        $search = $request->input('search');
        $query = Destination::query();
        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%");
        }
        $destinations = $query->paginate(9);
        $locations = $this->getActiveLocations();
        return view('frontend.destination.index', compact('destinations', 'search', 'locations'));
    }
    public function cabsindex(Request $request)
    {
        $search = $request->input('search');
        $query = Cab::query()->where('status', 1);
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('cab_type', 'like', "%{$search}%");
            });
        }
        $cabs = $query->orderByRaw('CASE WHEN `order` IS NULL THEN 1 ELSE 0 END, `order` ASC, id DESC')->paginate(12);
        $cabtypes = Cab::where('status', 1)->select('cab_type', DB::raw('COUNT(*) as count'))->groupBy('cab_type')->get();
        return view('frontend.cab.index', compact('cabs', 'search', 'cabtypes'));
    }
    public function destinationwedding(Request $request)
    {
        $search = $request->input('search');
        $query = DestinationWedding::weddings();
        if (!empty($search)) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%");
        }
        $destinationweddings = $query->paginate(9);
        $title = 'Destination Weddings';
        $weddinglocations = DestinationWedding::weddings()->where('status', 1)->select('location', DB::raw('COUNT(*) as count'))->groupBy('location')->get();
        return view('frontend.destinationwedding.index', compact('destinationweddings', 'search', 'weddinglocations', 'title'));
    }
    public function destinationvendor(Request $request)
    {
        $search = $request->input('search');
        $query = DestinationWedding::vendor();
        if (!empty($search)) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%");
        }
        $destinationweddings = $query->paginate(9);
        $title = 'Destination Vendors';
        $weddinglocations = DestinationWedding::vendor()->where('status', 1)->select('location', DB::raw('COUNT(*) as count'))->groupBy('location')->get();
        return view('frontend.destinationwedding.index', compact('destinationweddings', 'search', 'weddinglocations', 'title'));
    }
    public function hotelsindex(Request $request)
    {
        $search = $request->input('search');
        $query = Hotel::query();
        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%");
        }
        $hotels = $query->paginate(12);
        $hotellocations = Hotel::where('status', 1)->select('location', DB::raw('COUNT(*) as count'))->groupBy('location')->get();
        $hotelcategories = Hotel::where('status', 1)->select('category', DB::raw('COUNT(*) as count'))->groupBy('category')->get();
        return view('frontend.hotel.index', compact('hotels', 'search', 'hotellocations', 'hotelcategories'));
    }

    /**
     * Tours Directory with Search, State & Sorting Order Filters
     */
    public function toursindex(Request $request, $stateSlug = null)
    {
        $search = $request->input('search');
        $domestic = $request->input('domestic');
        $orderby = $request->input('orderby', 'menu_order');

        if ($domestic !== 'yes') {
            $query = Tour::NonVenue();
        } else {
            $query = Tour::query()->where('domestic_trip', 'yes');
        }

        $stateParam = $stateSlug ?: $request->input('state');
        $state = null;
        if (!empty($stateParam)) {
            $state = \App\Models\State::where('slug', $stateParam)
                ->orWhere('id', $stateParam)
                ->first();
            // When default sorting (menu_order or empty): show ONLY this state (e.g. Kashmir)
            // When sorting by price/date/rating: checks across packages
            if ($state && ($orderby === 'menu_order' || empty($orderby))) {
                $query->where('state_id', $state->id);
            }
        }

        // 1. Search Query Filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 2. Sorting / OrderBy Filter
        switch ($orderby) {
            case 'price':
                $query->orderBy('price', 'asc');
                break;
            case 'price-desc':
                $query->orderBy('price', 'desc');
                break;
            case 'date':
                $query->orderBy('created_at', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'popularity':
                $query->orderBy('views', 'desc');
                break;
            case 'menu_order':
            default:
                // Default: Sort based on days & nights (4 night first, then 5 night, etc.)
                $query->orderByRaw('CASE WHEN duration IS NULL OR duration = 0 THEN 1 ELSE 0 END, duration ASC, id ASC');
                break;
        }

        // Preserve all query parameters across pagination pages
        $tours = $query->paginate(9)->appends($request->query());

        $locations = $this->getActiveLocations();
        $categoryTour = $this->getActiveCategoryTour();

        return view('frontend.tour.index', compact('tours', 'search', 'orderby', 'locations', 'categoryTour', 'state'));
    }

    public function toursindexold(Request $request)
    {
        $search = $request->input('search');
        $domestic = $request->input('domestic');
        $state = $request->input('state');
        $orderby = $request->input('orderby', 'menu_order');

        if ($domestic !== 'yes') {
            $query = Tour::NonVenue();
        } else {
            $query = Tour::query()->where('domestic_trip', 'yes');
        }
        $stateParam = $request->input('state');
        $state = null;
        if (!empty($stateParam)) {
            $state = is_numeric($stateParam)
                ? \App\Models\State::find($stateParam)
                : \App\Models\State::where('slug', $stateParam)->first();
            if ($state && ($orderby === 'menu_order' || empty($orderby))) {
                $query->where('state_id', $state->id);
            }
        }

        if (!empty($search)) {
            $query->where('title', 'like', "%{$search}%");
        }

        switch ($orderby) {
            case 'price':
                $query->orderBy('price', 'asc');
                break;
            case 'price-desc':
                $query->orderBy('price', 'desc');
                break;
            case 'date':
                $query->orderBy('created_at', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'popularity':
                $query->orderByRaw('CASE WHEN duration IS NULL OR duration = 0 THEN 1 ELSE 0 END, duration ASC, id ASC');
                break;
            default:
                $query->orderByRaw('CASE WHEN duration IS NULL OR duration = 0 THEN 1 ELSE 0 END, duration ASC, id ASC');
                break;
        }

        $tours = $query->paginate(9)->appends($request->query());

        $locations = Destination::where('status', 1)
            ->select('location', DB::raw('COUNT(*) as count'))
            ->groupBy('location')
            ->get();

        $categoryTour = TourCategory::where('status', 1)
            ->select('name', DB::raw('COUNT(*) as count'))
            ->groupBy('name')
            ->get();

        return view('frontend.tour.index', compact('tours', 'search', 'orderby', 'locations', 'categoryTour'));
    }

    public function toursfits(Request $request)
    {
        $search = $request->input('search');
        $orderby = $request->input('orderby', 'menu_order');
        $query = Tour::Venue();

        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%");
        }

        switch ($orderby) {
            case 'price':
                $query->orderBy('price', 'asc');
                break;
            case 'price-desc':
                $query->orderBy('price', 'desc');
                break;
            case 'date':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderByRaw('CASE WHEN duration IS NULL OR duration = 0 THEN 1 ELSE 0 END, duration ASC, id ASC');
                break;
        }

        $tours = $query->paginate(9)->appends($request->query());
        $locations = Destination::where('status', 1)->select('location', DB::raw('COUNT(*) as count'))->groupBy('location')->get();
        $categoryTour = TourCategory::where('status', 1)
            ->select('name', DB::raw('COUNT(*) as count'))
            ->groupBy('name')
            ->get();
        return view('frontend.tour.index', compact('tours', 'search', 'orderby', 'locations', 'categoryTour'));
    }

    public function toursgits(Request $request)
    {
        $search = $request->input('search');
        $orderby = $request->input('orderby', 'menu_order');
        $query = Tour::Fvnue();

        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%");
        }

        switch ($orderby) {
            case 'price':
                $query->orderBy('price', 'asc');
                break;
            case 'price-desc':
                $query->orderBy('price', 'desc');
                break;
            case 'date':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderByRaw('CASE WHEN duration IS NULL OR duration = 0 THEN 1 ELSE 0 END, duration ASC, id ASC');
                break;
        }

        $tours = $query->paginate(9)->appends($request->query());
        $locations = Destination::where('status', 1)->select('location', DB::raw('COUNT(*) as count'))->groupBy('location')->get();
        $categoryTour = TourCategory::where('status', 1)
            ->select('name', DB::raw('COUNT(*) as count'))
            ->groupBy('name')
            ->get();
        return view('frontend.tour.index', compact('tours', 'search', 'orderby', 'locations', 'categoryTour'));
    }

    public function serviceindex(Request $request)
    {
        $categories = TourCategory::latest()->limit(25)->get();
        $destinations = Destination::latest()->limit(8)->get();
        $tours = Tour::latest()->limit(8)->get();
        $search = $request->input('search');
        $query = Service::query();
        if (!empty($search)) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }
        $services = $query->paginate(16);
        return view('frontend.service.index', compact('services', 'search', 'destinations', 'tours', 'categories'));
    }

    public function photogallery(Request $request)
    {
        $search = $request->input('search');
        $query = Gallery::query();
        if (!empty($search)) {
            $query->where('title', 'like', "%{$search}%");
        }
        $galleries = $query->images()->paginate(40);
        $titles = Gallery::where('status', 1)->select('title', DB::raw('COUNT(*) as count'))->groupBy('title')->get();
        return view('frontend.home.gallery', compact('galleries', 'titles'));
    }

    public function videogallery(Request $request)
    {
        $search = $request->input('search');
        $query = Gallery::query();
        if (!empty($search)) {
            $query->where('title', 'like', "%{$search}%");
        }
        $galleries = $query->videos()->paginate(40);
        $titles = Gallery::where('status', 1)->select('title', DB::raw('COUNT(*) as count'))->videos()->groupBy('title')->get();
        $youtube = YouTubeData::where('status', 1)->latest()->get();
        return view('frontend.home.vgallery', compact('galleries', 'titles', 'youtube'));
    }

    public function contact(Request $request)
    {
        $sliderContact = Slider::where('contact_us', 'yes')->latest()->take(1)->first();
        return view('frontend.home.contact', compact('sliderContact'));
    }

    public function activityindex(Request $request)
    {
        $search = $request->input('search');
        $query = Activity::query();
        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%");
        }

        $activities = $query->paginate(9);
        return view('frontend.activity.index', compact('activities', 'search'));
    }

    public function blogsindex(Request $request)
    {
        $search = $request->input('search');
        $query = Blog::query();
        if (!empty($search)) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%")
                ->orWhere('tags', 'like', "%{$search}%")
                ->orWhere('meta_title', 'like', "%{$search}%");
        }
        $allTags = Blog::pluck('tags')->toArray();
        $tagArray = [];
        foreach ($allTags as $tags) {
            $tagArray = array_merge($tagArray, explode(',', $tags));
        }
        $uniqueTags = array_slice(array_unique($tagArray), 0, 10);

        $categories = Blog::where('status', 1)->select('category', DB::raw('COUNT(*) as count'))->groupBy('category')->get();
        $blogs = $query->paginate(9);
        return view('frontend.blog.index', compact('blogs', 'search', 'categories', 'uniqueTags'));
    }

    public function toursByCategory($slug)
    {
        $locations = Destination::where('status', 1)->select('location', DB::raw('COUNT(*) as count'))->groupBy('location')->get();
        $category = TourCategory::where('slug', $slug)->firstOrFail();
        $tours = $category->tours()->orderByRaw('CASE WHEN duration IS NULL OR duration = 0 THEN 1 ELSE 0 END, duration ASC, id ASC')->paginate(9)->appends(request()->query());

        return view('frontend.tour.category', compact('tours', 'category', 'locations'));
    }

    public function destinationsByCategory($slug)
    {
        $locations = Destination::where('status', 1)->select('location', DB::raw('COUNT(*) as count'))->groupBy('location')->get();
        $category = DestinationCategory::where('slug', $slug)->firstOrFail();
        $destinations = $category->destinations()->paginate(9);

        return view('frontend.destination.category', compact('destinations', 'category', 'locations'));
    }

    public function CategoryByType($slug)
    {
        if ($slug == "domestic") {
            $ss = 1;
            $type = "Domestic";
        } else {
            $ss = 2;
            $type = "International";
        }
        $locations = Destination::where('status', 1)->select('location', DB::raw('COUNT(*) as count'))->groupBy('location')->get();
        $states = State::where('country_id', $ss)->paginate(6);

        return view('frontend.tour.typecategory', compact('type', 'states', 'locations'));
    }

    public function toursByDestination($slug)
    {
        $locations = Destination::where('status', 1)->select('location', DB::raw('COUNT(*) as count'))->groupBy('location')->get();
        $destination = Destination::where('slug', $slug)->firstOrFail();
        $tours = $destination->tours()->orderByRaw('CASE WHEN duration IS NULL OR duration = 0 THEN 1 ELSE 0 END, duration ASC, id ASC')->paginate(9)->appends(request()->query());

        return view('frontend.tour.destination', compact('tours', 'destination', 'locations'));
    }

    public function servicedetails($slug)
    {
        $service = Service::where('slug', $slug)->firstOrFail();
        $recentservice = Service::latest()->where('id', '!=', $service->id)->take(3)->get();

        $locations = Destination::where('status', 1)
            ->select('location', DB::raw('COUNT(*) as count'))
            ->groupBy('location')
            ->get();
        return view('frontend.service.details', compact('service', 'recentservice', 'locations'));
    }

    public function guidedetails($slug)
    {
        $touristguide = TouristGuide::where('slug', $slug)->firstOrFail();
        $moreGuide = TouristGuide::latest()->where('id', '!=', $touristguide->id)->take(9)->get();

        return view('frontend.home.guidedetail', compact('touristguide', 'moreGuide'));
    }

    public function toursdetails($slug)
    {
        $tour = Tour::where('slug', $slug)->firstOrFail();
        Tour::where('id', $tour->id)->increment('views');
        $recentTour = Tour::latest()->where('id', '!=', $tour->id)->take(3)->get();

        $locations = $this->getActiveLocations();
        $categoryTour = $this->getActiveCategoryTour();
        return view('frontend.tour.details', compact('tour', 'recentTour', 'locations', 'categoryTour'));
    }

    public function activitydetails($slug)
    {
        $activity = Activity::where('slug', $slug)->firstOrFail();
        $recentActivity = Activity::latest()->where('id', '!=', $activity->id)->take(3)->get();

        return view('frontend.activity.details', compact('activity', 'recentActivity'));
    }

    public function pagedetails($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        return view('frontend.home.page', compact('page'));
    }

    public function destinationdetails($slug)
    {
        $destination = Destination::where('slug', $slug)->firstOrFail();
        $tours = $destination->tours()->where('status', 1)->latest()->get();
        $recentdestinations = Destination::latest()->where('id', '!=', $destination->id)->take(3)->get();

        $locations = Destination::where('status', 1)
            ->select('location', DB::raw('COUNT(*) as count'))
            ->groupBy('location')
            ->get();
        return view('frontend.destination.details', compact('destination', 'tours', 'recentdestinations', 'locations'));
    }

    public function hoteldetails($slug)
    {
        $hotel = Hotel::where('slug', $slug)->firstOrFail();

        $hotellocations = Hotel::where('status', 1)
            ->select('location', DB::raw('COUNT(*) as count'))
            ->groupBy('location')
            ->get();
        $hotelcategories = Hotel::where('status', 1)->select('category', DB::raw('COUNT(*) as count'))->groupBy('category')->get();
        return view('frontend.hotel.details', compact('hotel', 'hotelcategories', 'hotellocations'));
    }

    public function destinationweddingdetails($slug)
    {
        $destinationwedding = DestinationWedding::where('slug', $slug)->firstOrFail();

        $destinationweddinglocations = DestinationWedding::where('status', 1)
            ->select('location', DB::raw('COUNT(*) as count'))
            ->groupBy('location')
            ->get();
        $title = 'Destination Weddings';
        $rts = 'home.destinationwedding';
        return view('frontend.destinationwedding.details', compact('destinationwedding', 'destinationweddinglocations', 'title', 'rts'));
    }

    public function destinationvendordetails($slug)
    {
        $destinationwedding = DestinationWedding::where('slug', $slug)->firstOrFail();

        $destinationweddinglocations = DestinationWedding::where('status', 1)
            ->select('location', DB::raw('COUNT(*) as count'))
            ->groupBy('location')
            ->get();
        $title = 'Destination Vendors';
        $rts = 'home.destinationvendor';
        return view('frontend.destinationwedding.details', compact('destinationwedding', 'destinationweddinglocations', 'title', 'rts'));
    }

    public function cabdetails($slug)
    {
        $cab = Cab::where('slug', $slug)->firstOrFail();

        $cabtypes = Cab::where('status', 1)->select('cab_type', DB::raw('COUNT(*) as count'))->groupBy('cab_type')->get();
        return view('frontend.cab.details', compact('cab', 'cabtypes'));
    }

    public function blogdetails($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $recentBlogs = Blog::latest()->where('id', '!=', $blog->id)->take(3)->get();

        $allTags = Blog::pluck('tags')->toArray();
        $tagArray = [];
        foreach ($allTags as $tags) {
            $tagArray = array_merge($tagArray, explode(',', $tags));
        }
        $uniqueTags = array_slice(array_unique($tagArray), 0, 10);
        $categories = Blog::where('status', 1)->select('category', DB::raw('COUNT(*) as count'))->groupBy('category')->get();
        return view('frontend.blog.details', compact('blog', 'recentBlogs', 'uniqueTags', 'categories'));
    }

    public function contactsubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'number' => 'nullable|digits_between:10,15',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        $setting = Setting::first();
        $adminEmail = $setting->email ?? null;

        if ($adminEmail) {
            Mail::to($adminEmail)->send(new ContactMail($validated));
        }

        return redirect()->back()->with('success', 'Your message has been saved successfully!');
    }

    public function homesubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'number' => 'nullable|digits_between:10,15',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        $setting = Setting::first();
        $adminEmail = $setting->email ?? null;

        if ($adminEmail) {
            Mail::to($adminEmail)->send(new ContactMail($validated));
        }

        return redirect()->back()->with('success', 'Your message has been submitted successfully!');
    }

    public function generateXml()
    {
        return \App\Helpers\SeoEngine::generateSitemapXml();
    }

    public function generateSubSitemap($type)
    {
        return \App\Helpers\SeoEngine::generateSitemapXml($type);
    }

    public function robots()
    {
        return \App\Helpers\SeoEngine::generateRobotsTxt();
    }
}
