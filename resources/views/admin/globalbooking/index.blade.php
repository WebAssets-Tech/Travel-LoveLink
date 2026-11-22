@extends('admin.layouts.app')
@section('web_page_title', 'Booking Enquiries')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Booking Enquiries</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Website</a></li>
                            <li class="breadcrumb-item active">Booking Enquiries</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @include('admin.layouts.message')

                        <div class="mb-3">
                            <a href="{{ route('global-booking.index') }}" class="btn btn-sm btn-outline-secondary {{ !$type ? 'active' : '' }}">All</a>
                            <a href="{{ route('global-booking.index', ['type' => 'cab']) }}" class="btn btn-sm btn-outline-primary {{ $type === 'cab' ? 'active' : '' }}">Cabs</a>
                            <a href="{{ route('global-booking.index', ['type' => 'hotel']) }}" class="btn btn-sm btn-outline-info {{ $type === 'hotel' ? 'active' : '' }}">Hotels</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table project-list-table align-middle table-nowrap dt-responsive nowrap w-100 table-borderless">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Route / Location</th>
                                        <th>Dates</th>
                                        <th>Pax</th>
                                        <th>Status</th>
                                        <th>Submitted</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($bookings as $booking)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td>
                                            <span class="badge badge-soft-{{ $booking->booking_type === 'cab' ? 'primary' : 'info' }}">
                                                {{ ucfirst($booking->booking_type) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($booking->booking_type === 'cab')
                                                {{ $booking->pickup_location }} → {{ $booking->drop_location }}
                                            @else
                                                {{ $booking->hotel_location }}
                                            @endif
                                        </td>
                                        <td>{{ $booking->checkin_date->format('d M Y') }} - {{ $booking->checkout_date->format('d M Y') }}</td>
                                        <td>
                                            {{ $booking->adults }} Adults
                                            @if($booking->kids) / {{ $booking->kids }} Kids @endif
                                            @if($booking->rooms) / {{ $booking->rooms }} Rooms @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-{{ $booking->status === 'closed' ? 'success' : ($booking->status === 'contacted' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $booking->created_at->format('d M Y, h:i A') }}</td>
                                        <td>
                                            <a href="{{ route('global-booking.show', $booking->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i> View</a>
                                            <form action="{{ route('global-booking.destroy', $booking->id) }}" method="post" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this enquiry?');"><i class="bi bi-trash"></i>Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="8"><span class="text-danger"><strong>No enquiries found!</strong></span></td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $bookings->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection