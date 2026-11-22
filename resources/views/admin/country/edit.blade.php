{{-- resources/views/admin/country/edit.blade.php --}}
@extends('admin.layouts.app')
@section('web_page_title', 'Edit Country')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Edit Country</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('country.index') }}">Countries</a></li>
                            <li class="breadcrumb-item active">Edit Country</li>
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

                        <form action="{{ route('country.update', $country->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{ old('name', $country->name) }}" class="form-control @error('name') is-invalid @enderror">
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Code (ISO)</label>
                                    <input type="text" name="code" value="{{ old('code', $country->code) }}" class="form-control @error('code') is-invalid @enderror" maxlength="5">
                                    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label d-block">Status</label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" name="status" value="1" id="statusSwitch" {{ $country->status ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusSwitch">Active</label>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <h5 class="mb-3">Images</h5>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Main Image</label>
                                    @if($country->image)
                                        <img src="{{ asset('storage/' . $country->image) }}" width="80" class="d-block mb-2 rounded">
                                    @endif
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Page BG Image</label>
                                    @if($country->page_bg_image)
                                        <img src="{{ asset('storage/' . $country->page_bg_image) }}" width="80" class="d-block mb-2 rounded">
                                    @endif
                                    <input type="file" name="page_bg_image" class="form-control @error('page_bg_image') is-invalid @enderror" accept="image/*">
                                    @error('page_bg_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Banner Image</label>
                                    @if($country->banner_image)
                                        <img src="{{ asset('storage/' . $country->banner_image) }}" width="80" class="d-block mb-2 rounded">
                                    @endif
                                    <input type="file" name="banner_image" class="form-control @error('banner_image') is-invalid @enderror" accept="image/*">
                                    @error('banner_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Banner Footer Image</label>
                                    @if($country->banner_footer_image)
                                        <img src="{{ asset('storage/' . $country->banner_footer_image) }}" width="80" class="d-block mb-2 rounded">
                                    @endif
                                    <input type="file" name="banner_footer_image" class="form-control @error('banner_footer_image') is-invalid @enderror" accept="image/*">
                                    @error('banner_footer_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gallery</label>
                                <div class="d-flex flex-wrap gap-3 mb-2">
                                    @forelse($country->gallery_array as $img)
                                        <div class="position-relative" style="width:90px;">
                                            <img src="{{ asset('storage/' . $img) }}" width="90" height="90" class="rounded" style="object-fit:cover;">
                                            <div class="form-check mt-1">
                                                <input type="checkbox" class="form-check-input" name="delete_images[]" value="{{ $img }}" id="del_{{ $loop->index }}">
                                                <label class="form-check-label small text-danger" for="del_{{ $loop->index }}">Delete</label>
                                            </div>
                                        </div>
                                    @empty
                                        <span class="text-muted">No gallery images yet.</span>
                                    @endforelse
                                </div>
                                <label class="form-label">Add More Gallery Images</label>
                                <input type="file" name="additional_images[]" class="form-control @error('additional_images.*') is-invalid @enderror" accept="image/*" multiple>
                                @error('additional_images.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="text-end">
                                <a href="{{ route('country.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-success">Update Country</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection