<?php
// app/Http/Controllers/Admin/GlobalBookingController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GlobalBooking;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GlobalBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-booking', ['only' => ['index', 'show']]);
        $this->middleware('permission:edit-booking', ['only' => ['updateStatus']]);
        $this->middleware('permission:delete-booking', ['only' => ['destroy']]);
    }

    public function index(Request $request): View
    {
        $type = $request->input('type');
        $query = GlobalBooking::latest();
        if (!empty($type)) {
            $query->where('booking_type', $type);
        }
        return view('admin.globalbooking.index', [
            'bookings' => $query->paginate(20),
            'type' => $type,
        ]);
    }

    public function show(GlobalBooking $globalBooking): View
    {
        return view('admin.globalbooking.show', compact('globalBooking'));
    }

    public function updateStatus(Request $request, GlobalBooking $globalBooking): RedirectResponse
    {
        $request->validate(['status' => 'required|in:pending,contacted,closed']);
        $globalBooking->update(['status' => $request->status]);

        return redirect()->back()->withSuccess('Status updated successfully.');
    }

    public function destroy(GlobalBooking $globalBooking): RedirectResponse
    {
        $globalBooking->delete();

        return redirect()->route('global-booking.index')->withSuccess('Enquiry deleted successfully.');
    }
}