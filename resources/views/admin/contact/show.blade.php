@extends('admin.layouts.app')
@section('web_page_title', 'Contact Enquiry Details')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Enquiry Details</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.contact.index') }}">Contact Enquiries</a></li>
                            <li class="breadcrumb-item active">#{{ $contact->id }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">{{ $contact->subject ?: 'General Contact Enquiry' }}</h5>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row" style="width: 180px;">Name</th>
                                        <td>{{ $contact->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Email</th>
                                        <td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Phone Number</th>
                                        <td>{{ $contact->number ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Submitted On</th>
                                        <td>{{ $contact->created_at ? $contact->created_at->format('d M Y, h:i A') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="align-top">Message</th>
                                        <td>
                                            <div class="p-3 bg-light rounded border" style="white-space: pre-line;">{{ $contact->message }}</div>
                                        </td>
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
                        <h5 class="card-title mb-3">Actions</h5>
                        @if($contact->number)
                            <a href="tel:{{ $contact->number }}" class="btn btn-primary w-100 mb-2">
                                <i class="bx bx-phone me-1"></i> Call {{ $contact->number }}
                            </a>
                        @endif
                        <a href="mailto:{{ $contact->email }}" class="btn btn-outline-primary w-100 mb-2">
                            <i class="bx bx-envelope me-1"></i> Reply via Email
                        </a>
                        <form action="{{ route('admin.contact.destroy', $contact->id) }}" method="post" class="mb-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Delete this enquiry?');">
                                <i class="bi bi-trash me-1"></i> Delete Enquiry
                            </button>
                        </form>
                        <a href="{{ route('admin.contact.index') }}" class="btn btn-outline-secondary w-100">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
