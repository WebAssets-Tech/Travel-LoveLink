<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Cab;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Destination;
use App\Models\DestinationWedding;
use App\Models\GlobalBooking;
use App\Models\Hotel;
use App\Models\Houseboat;
use App\Models\Page;
use App\Models\State;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $stats = [
            'tours'           => Tour::count(),
            'states'          => State::count(),
            'countries'       => Country::count(),
            'tourCategories'  => TourCategory::count(),
            'destinations'    => Destination::count(),
            'hotels'          => Hotel::count(),
            'houseboats'      => Houseboat::count(),
            'cabs'            => Cab::count(),
            'weddings'        => DestinationWedding::count(),
            'pages'           => Page::count(),
            'blogs'           => Blog::count(),
            'bookingsTotal'   => GlobalBooking::count(),
            'bookingsPending' => GlobalBooking::where('status', 'pending')->count(),
            'contactsTotal'   => Contact::count(),
            'totalUsers'      => User::count(),
        ];

        $recentBookings = GlobalBooking::latest()->take(5)->get();
        $recentContacts = Contact::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'recentContacts'));
    }
}
