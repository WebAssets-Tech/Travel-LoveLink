@extends('admin.layouts.app')
@section('web_page_title', 'Contact & Tour Enquiries')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Contact &amp; Tour Enquiries</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Contact &amp; Tour Enquiries</li>
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

                        <p class="text-muted mb-3">Messages and package booking inquiries submitted from the website Contact page and tour enquiry forms.</p>

                        <div class="table-responsive">
                            <table class="table project-list-table align-middle table-nowrap dt-responsive nowrap w-100 table-borderless">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Subject</th>
                                        <th>Submitted</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($contacts as $contact)
                                    <tr>
                                        <th>{{ ($contacts->currentPage() - 1) * $contacts->perPage() + $loop->iteration }}</th>
                                        <td class="fw-medium">{{ $contact->name }}</td>
                                        <td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td>
                                        <td>{{ $contact->number ?: '-' }}</td>
                                        <td>{{ Str::limit($contact->subject ?: 'General Enquiry', 50) }}</td>
                                        <td>{{ $contact->created_at ? $contact->created_at->format('d M Y, h:i A') : '-' }}</td>
                                        <td>
                                            <a href="{{ route('admin.contact.show', $contact->id) }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                            <form action="{{ route('admin.contact.destroy', $contact->id) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this enquiry?');">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7"><span class="text-danger"><strong>No contact enquiries found!</strong></span></td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $contacts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
