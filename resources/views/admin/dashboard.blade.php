@extends('admin.layouts.app')
@section('web_page_title', 'Dashboard')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Admin</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Welcome + KPI Overview -->
        <div class="row">
            <div class="col-xl-4">
                <div class="card overflow-hidden">
                    <div class="bg-primary-subtle">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary">Welcome Back!</h5>
                                    <p class="mb-0">{{ Auth::user()->name }}</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{ asset('assets/images/profile-img.png') }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="avatar-md profile-user-wid mb-3">
                                    <img src="{{ asset('assets/images/users/User.png') }}" alt="" class="img-thumbnail rounded-circle">
                                </div>
                                <h5 class="font-size-15 text-truncate">{{ Auth::user()->name }}</h5>
                                <p class="text-muted mb-0 font-size-12">Administrator</p>
                            </div>

                            <div class="col-sm-8">
                                <div class="pt-4">
                                    <div class="row">
                                        <div class="col-6">
                                            <h5 class="font-size-15">{{ $stats['bookingsTotal'] ?? 0 }}</h5>
                                            <p class="text-muted mb-0">Bookings</p>
                                        </div>
                                        <div class="col-6">
                                            <h5 class="font-size-15">{{ $stats['contactsTotal'] ?? 0 }}</h5>
                                            <p class="text-muted mb-0">Enquiries</p>
                                        </div>
                                    </div>
                                    <div class="mt-4 d-flex flex-wrap gap-2">
                                        <a href="{{ route('home') }}" target="_blank" class="btn btn-primary btn-sm">
                                            View Website <i class="mdi mdi-open-in-new ms-1"></i>
                                        </a>
                                        <a href="{{ route('setting.edit', 1) }}" class="btn btn-outline-secondary btn-sm">
                                            Site Settings
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Frontend Section Guide -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Website Section Guide</h5>
                        <p class="text-muted font-size-12 mb-3">Quick map showing which backend menu controls each section of the live site:</p>
                        <ul class="list-group list-group-flush font-size-13">
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span><strong>Header Icons</strong> <small class="text-muted d-block">Packages, Hotels, Cabs, Trains, Flights...</small></span>
                                <a href="{{ route('slidericon.index') }}" class="btn btn-sm btn-light">Edit</a>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span><strong>Domestic / Intl</strong> <small class="text-muted d-block">Top-level Country scopes</small></span>
                                <a href="{{ route('country.index') }}" class="btn btn-sm btn-light">Edit</a>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span><strong>Regions (States)</strong> <small class="text-muted d-block">Kashmir, Ladakh, Dubai, Goa package cards</small></span>
                                <a href="{{ route('state.index') }}" class="btn btn-sm btn-light">Edit</a>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span><strong>Tour Themes</strong> <small class="text-muted d-block">Nature, Adventure, Camping carousel</small></span>
                                <a href="{{ route('tourcategory.index') }}" class="btn btn-sm btn-light">Edit</a>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span><strong>Pages &amp; Policies</strong> <small class="text-muted d-block">Trains, Flights, Gandola, Terms &amp; Privacy</small></span>
                                <a href="{{ route('page.index') }}" class="btn btn-sm btn-light">Edit</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <!-- Website Metrics Grid -->
                <div class="row">
                    @php
                        $kpiCards = [
                            ['label' => 'Tour Packages', 'count' => $stats['tours'] ?? 0, 'icon' => 'bx-briefcase-alt-2', 'route' => route('tour.index'), 'color' => 'primary'],
                            ['label' => 'Package Regions (States)', 'count' => $stats['states'] ?? 0, 'icon' => 'bx-map-alt', 'route' => route('state.index'), 'color' => 'info'],
                            ['label' => 'Popular Destinations', 'count' => $stats['destinations'] ?? 0, 'icon' => 'bx-map-pin', 'route' => route('destination.index'), 'color' => 'success'],
                            ['label' => 'Hotels & Resorts', 'count' => $stats['hotels'] ?? 0, 'icon' => 'bx-building-house', 'route' => route('hotel.index'), 'color' => 'warning'],
                            ['label' => 'Cabs & Fleet', 'count' => $stats['cabs'] ?? 0, 'icon' => 'bx-car', 'route' => route('cab.index'), 'color' => 'primary'],
                            ['label' => 'Booking Enquiries', 'count' => $stats['bookingsTotal'] ?? 0, 'sub' => ($stats['bookingsPending'] ?? 0) . ' pending', 'icon' => 'bx-calendar-check', 'route' => route('global-booking.index'), 'color' => 'danger'],
                            ['label' => 'Contact Messages', 'count' => $stats['contactsTotal'] ?? 0, 'icon' => 'bx-envelope', 'route' => route('admin.contact.index'), 'color' => 'info'],
                            ['label' => 'Blogs & Pages', 'count' => ($stats['blogs'] ?? 0) . ' / ' . ($stats['pages'] ?? 0), 'icon' => 'bx-file', 'route' => route('page.index'), 'color' => 'success'],
                        ];
                    @endphp
                    @foreach($kpiCards as $kpi)
                    <div class="col-md-6 col-xl-3">
                        <a href="{{ $kpi['route'] }}" class="text-reset">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium mb-1 font-size-12">{{ $kpi['label'] }}</p>
                                            <h4 class="mb-0">{{ $kpi['count'] }}</h4>
                                            @if(!empty($kpi['sub']))
                                                <small class="text-danger">{{ $kpi['sub'] }}</small>
                                            @endif
                                        </div>
                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-{{ $kpi['color'] }}">
                                                <span class="avatar-title">
                                                    <i class="bx {{ $kpi['icon'] }} font-size-20"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                <!-- Recent Booking Enquiries -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title mb-0">Recent Booking Enquiries</h5>
                            <a href="{{ route('global-booking.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Type</th>
                                        <th>Route / Location</th>
                                        <th>Dates</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentBookings as $booking)
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-{{ $booking->booking_type === 'cab' ? 'primary' : 'info' }}">
                                                {{ ucfirst($booking->booking_type) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($booking->booking_type === 'cab')
                                                {{ $booking->pickup_location }} &rarr; {{ $booking->drop_location }}
                                            @else
                                                {{ $booking->hotel_location }}
                                            @endif
                                        </td>
                                        <td>{{ $booking->checkin_date?->format('d M Y') }} - {{ $booking->checkout_date?->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge badge-soft-{{ $booking->status === 'closed' ? 'success' : ($booking->status === 'contacted' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('global-booking.show', $booking->id) }}" class="btn btn-sm btn-light">View</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="5" class="text-muted text-center">No booking enquiries yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Contact & Tour Enquiries -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title mb-0">Recent Contact &amp; Package Enquiries</h5>
                            <a href="{{ route('admin.contact.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Subject</th>
                                        <th>Phone</th>
                                        <th>Submitted</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentContacts as $contact)
                                    <tr>
                                        <td class="fw-medium">{{ $contact->name }}</td>
                                        <td>{{ Str::limit($contact->subject ?: 'General Enquiry', 40) }}</td>
                                        <td>{{ $contact->number ?: '-' }}</td>
                                        <td>{{ $contact->created_at ? $contact->created_at->format('d M Y') : '-' }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.contact.show', $contact->id) }}" class="btn btn-sm btn-light">View</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="5" class="text-muted text-center">No contact enquiries yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
