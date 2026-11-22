<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ImageProcessingController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\GoogleReviewController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UserController; 
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SettingController; 
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\DestinationCategoryController;
use App\Http\Controllers\Admin\TourCategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\{BlogController,YouTubeController,SliderIconController,TravelBestieController,GlobalBookingController};
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\TouristGuideController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\CabController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\DestinationWeddingController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\LoginController;




Route::get('/', [WebsiteController::class, 'home'])->name('home');
Route::get('/home', [WebsiteController::class, 'home'])->name('home.index');
Route::get('/contact', [WebsiteController::class, 'contact'])->name('home.contact');
Route::post('/contact', [WebsiteController::class, 'contactsubmit'])->name('home.contact.submit')->middleware('throttle:5,1');
Route::post('/home', [WebsiteController::class, 'homesubmit'])->name('home.homesubmit')->middleware('throttle:5,1');
Route::get('/faq', [WebsiteController::class, 'faq'])->name('home.faq');
Route::get('/services', [WebsiteController::class, 'serviceindex'])->name('home.service'); 
Route::get('/photo-gallery', [WebsiteController::class, 'photogallery'])->name('home.photogallery'); 
Route::get('/video-gallery', [WebsiteController::class, 'videogallery'])->name('home.videogallery');
Route::get('/destination-weddings', [WebsiteController::class, 'destinationwedding'])->name('home.destinationwedding');
Route::get('/destination-vendors', [WebsiteController::class, 'destinationvendor'])->name('home.destinationvendor');  
Route::get('/cabs', [WebsiteController::class, 'cabsindex'])->name('home.cabs'); 
Route::get('/hotels', [WebsiteController::class, 'hotelsindex'])->name('home.hotels'); 
Route::get('/about-us', [WebsiteController::class, 'aboutus'])->name('aboutus.index');
Route::get('/view-destination', [WebsiteController::class, 'destinationsindex'])->name('destinations.index');
Route::get('/blogs', [WebsiteController::class, 'blogsindex'])->name('home.blogs'); 
Route::get('/activity', [WebsiteController::class, 'activityindex'])->name('home.activity');
Route::get('/tours', [WebsiteController::class, 'toursindex'])->name('home.tour'); 
Route::get('/fits', [WebsiteController::class, 'toursfits'])->name('home.venue'); 
Route::get('/gits', [WebsiteController::class, 'toursgits'])->name('home.toursgits'); 
Route::get('/sitemap.xml', [WebsiteController::class, 'generateXml']);
Route::get('/sitemap-{type}.xml', [WebsiteController::class, 'generateSubSitemap']);
Route::get('/robots.txt', [WebsiteController::class, 'robots']); 
Route::get('/tours-by-state/{stateSlug}', [WebsiteController::class, 'toursindex'])
    ->name('home.tour.state');
//Route::get('/scanAndCompress', [ImageProcessingController::class, 'scanAndCompress']);
Route::post('/global-booking/submit', [WebsiteController::class, 'globalBookingSubmit'])
    ->name('home.global-booking.submit')
    ->middleware('throttle:5,1');
Route::get('/destination/category/{slug}', [WebsiteController::class, 'destinationsByCategory'])->name('destinations.by.category');
Route::get('/tours/category/{slug}', [WebsiteController::class, 'toursByCategory'])->name('tours.by.category');
Route::get('/category/{slug}', [WebsiteController::class, 'CategoryByType'])->name('CategoryByType');
Route::get('/tours/destination/{slug}', [WebsiteController::class, 'toursByDestination'])->name('tours.by.destination');
Route::get('/page/{slug}', [WebsiteController::class, 'pagedetails'])->name('home.page');
Route::get('/hotel/{slug}', [WebsiteController::class, 'hoteldetails'])->name('home.hoteldetails');
Route::get('/cab/{slug}', [WebsiteController::class, 'cabdetails'])->name('home.cabdetails');
Route::get('/destination-wedding/{slug}', [WebsiteController::class, 'destinationweddingdetails'])->name('home.destinationweddingdetails');
Route::get('/guide/{slug}', [WebsiteController::class, 'guidedetails'])->name('home.guidedetails');
Route::get('/service/{slug}', [WebsiteController::class, 'servicedetails'])->name('service.details');
Route::get('/activity/{slug}', [WebsiteController::class, 'activitydetails'])->name('activity.details');
Route::get('/blog/{slug}', [WebsiteController::class, 'blogdetails'])->name('blog.details');
Route::get('/destinations/{slug}', [WebsiteController::class, 'destinationdetails'])->name('destination.details');   
Route::get('/tours/{tour}', [WebsiteController::class, 'toursdetails'])->name('tour.details');

// Google Reviews API endpoint
Route::get('/api/google-reviews', [GoogleReviewController::class, 'getReviews'])->name('google.reviews');

// Redirect route (handle form submission)
Route::get('/destinations', function (Illuminate\Http\Request $request) {
    $slug = $request->destination;
    if ($slug) {
        return redirect()->route('destination.details', ['destination' => $slug]);
    }
    return redirect()->back();
});





Route::middleware('throttle:10,1')->group(function () {
    Auth::routes(['register' => false]);
});

// Admin access & backward compatibility redirects
Route::get('/admin', function () {
    return redirect()->route('login');
});
Route::get('/marina', function () {
    return redirect()->to(url('admin'));
});
Route::get('/marina/{any}', function ($any) {
    return redirect()->to(url('admin/' . $any));
})->where('any', '.*');

Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Grouping all admin panel routes under '/admin'
Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    

    Route::resources([
        'roles' => RoleController::class,
        'users' => UserController::class,
        'permissions' => PermissionController::class,
        'setting' => SettingController::class,
        'menu' => MenuController::class,
        'slider' => SliderController::class,
        'destination' => DestinationController::class,
        'activity' => ActivityController::class,
        'tourcategory' => TourCategoryController::class,
        'destinationcategory' => DestinationCategoryController::class,
        'service' => ServiceController::class,
        'testimonial' => TestimonialController::class,
        'gallery' => GalleryController::class,
        'blog' => BlogController::class,
        'youtube' => YouTubeController::class,
        'slidericon' => SliderIconController::class,
        'travel-bestie' => TravelBestieController::class,
        'faq' => FaqController::class,
        'partner' => PartnerController::class,
        'page' => PageController::class,
        'cab' => CabController::class,
        'hotel' => HotelController::class,
        'destinationwedding' => DestinationWeddingController::class,
        'tour' => TourController::class,
        'touristguide' => TouristGuideController::class,
    ]);
    Route::resource('country', \App\Http\Controllers\Admin\CountryController::class);
    Route::resource('state', \App\Http\Controllers\Admin\StateController::class);
    Route::get('/tourcategory/{parent_id}/subtourcategory', [TourCategoryController::class, 'subtourcategory'])->name('subtourcategory.index'); 
    Route::get('/destinationcategory/{parent_id}/subdestinationcategory', [DestinationCategoryController::class, 'subdestinationcategory'])->name('subdestinationcategory.index'); 
    Route::get('/menu/{parent_id}/submenus', [MenuController::class, 'submenus'])->name('submenu.index'); 
    Route::get('/menu/{menu}/submenus', [MenuController::class, 'getSubmenus'])->name('menu.submenus');

    Route::get('global-booking', [GlobalBookingController::class, 'index'])->name('global-booking.index');
    Route::get('global-booking/{globalBooking}', [GlobalBookingController::class, 'show'])->name('global-booking.show');
    Route::patch('global-booking/{globalBooking}/status', [GlobalBookingController::class, 'updateStatus'])->name('global-booking.status');
    Route::delete('global-booking/{globalBooking}', [GlobalBookingController::class, 'destroy'])->name('global-booking.destroy');
    // Permissions management
    Route::get('/permissions-create', [PermissionController::class, 'create']);
    Route::post('/permissions-store', [PermissionController::class, 'store']);

    // User-related actions
    Route::post('/clear-cache', [UserController::class, 'clearCache'])->name('user.clearCache');
    Route::post('/run-migration', [UserController::class, 'runMigration'])->name('user.migration');
    Route::post('/check-duplicate-user', [UserController::class, 'checkDuplicate'])->name('check.duplicateuser');
    Route::post('/update-password', [UserController::class, 'updatePassword']);

    // Admin maintenance actions (protected)
    Route::post('/storage-link', function () {
        Artisan::call('storage:link');
        return redirect()->back()->with('success', 'Storage link has been created successfully!');
    })->name('admin.storage.link');
    Route::post('/clear-route-cache', function () {
        Artisan::call('route:clear');
        return redirect()->back()->with('success', 'Route cache cleared successfully!');
    })->name('admin.route.clear');
});

// Email verification routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/resend', [VerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])->name('verification.resend');
