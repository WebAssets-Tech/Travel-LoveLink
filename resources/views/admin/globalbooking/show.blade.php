{{-- resources/views/admin/globalbooking/show.blade.php --}}
@extends('admin.layouts.app')
@section('web_page_title', 'Booking Enquiry Details')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Booking Enquiry Details</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Website</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('global-booking.index') }}">Booking Enquiries</a></li>
                            <li class="breadcrumb-item active">#{{ $globalBooking->id }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        @include('admin.layouts.message')

                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="mb-0">
                                <span class="badge badge-soft-{{ $globalBooking->booking_type === 'cab' ? 'primary' : 'info' }} font-size-14">
                                    {{ ucfirst($globalBooking->booking_type) }} Enquiry
                                </span>
                            </h5>
                            <span class="badge badge-soft-{{ $globalBooking->status === 'closed' ? 'success' : ($globalBooking->status === 'contacted' ? 'warning' : 'danger') }} font-size-13">
                                {{ ucfirst($globalBooking->status) }}
                            </span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-borderless table-nowrap mb-0">
                                <tbody>
                                    @if($globalBooking->booking_type === 'cab')
                                        <tr>
                                            <th scope="row" style="width: 200px;">Pickup Location</th>
                                            <td>{{ $globalBooking->pickup_location }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Drop Location</th>
                                            <td>{{ $globalBooking->drop_location }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Pick-up Time</th>
                                            <td>{{ $globalBooking->pickup_time ? \Carbon\Carbon::parse($globalBooking->pickup_time)->format('h:i A') : '-' }}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <th scope="row" style="width: 200px;">Location</th>
                                            <td>{{ $globalBooking->hotel_location }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Rooms</th>
                                            <td>{{ $globalBooking->rooms }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Kids</th>
                                            <td>{{ $globalBooking->kids ?? 0 }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th scope="row">Check-in Date</th>
                                        <td>{{ $globalBooking->checkin_date->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Check-out Date</th>
                                        <td>{{ $globalBooking->checkout_date->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Adults</th>
                                        <td>{{ $globalBooking->adults }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Submitted On</th>
                                        <td>{{ $globalBooking->created_at->format('d M Y, h:i A') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Update Status</h5>
                        <form action="{{ route('global-booking.status', $globalBooking->id) }}" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <select name="status" class="form-select">
                                    <option value="pending" {{ $globalBooking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="contacted" {{ $globalBooking->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                                    <option value="closed" {{ $globalBooking->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Update Status</button>
                        </form>

                        <hr>

                        <form action="{{ route('global-booking.destroy', $globalBooking->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Delete this enquiry?');">
                                <i class="bi bi-trash"></i> Delete Enquiry
                            </button>
                        </form>

                        <a href="{{ route('global-booking.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="bi bi-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection