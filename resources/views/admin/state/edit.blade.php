{{-- resources/views/admin/state/edit.blade.php --}}
@extends('admin.layouts.app')
@section('web_page_title', 'Edit State')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Edit State</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('state.index') }}">States</a></li>
                            <li class="breadcrumb-item active">Edit State</li>
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

                        <form action="{{ route('state.update', $state->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Country <span class="text-danger">*</span></label>
                                    <select name="country_id" class="form-select @error('country_id') is-invalid @enderror">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('country_id', $state->country_id) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{ old('name', $state->name) }}" class="form-control @error('name') is-invalid @enderror">
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Code</label>
                                    <input type="text" name="code" value="{{ old('code', $state->code) }}" class="form-control @error('code') is-invalid @enderror" maxlength="10">
                                    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Order</label>
                                    <input type="number" name="order" value="{{ old('order', $state->order) }}" class="form-control @error('order') is-invalid @enderror" min="0">
                                    @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label d-block">Status</label>
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="status" value="0">
                                        <input type="checkbox" class="form-check-input" name="status" value="1" id="statusSwitch" {{ $state->status ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusSwitch">Active</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Short Destinations (comma-separated)</label>
                                    <input type="text" name="short_destinations" value="{{ old('short_destinations', $state->short_destinations) }}" class="form-control @error('short_destinations') is-invalid @enderror" placeholder="e.g. Srinagar, Gulmarg, Pahalgam, Sonamarg">
                                    <small class="text-muted">Shown as short destination pills inside the homepage destination card.</small>
                                    @error('short_destinations') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <hr>
                            <h5 class="mb-3">Images</h5>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Main Image</label>
                                    @if($state->image)
                                        <img src="{{ asset('storage/' . $state->image) }}" width="80" class="d-block mb-2 rounded">
                                    @endif
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Page BG Image</label>
                                    @if($state->page_bg_image)
                                        <img src="{{ asset('storage/' . $state->page_bg_image) }}" width="80" class="d-block mb-2 rounded">
                                    @endif
                                    <input type="file" name="page_bg_image" class="form-control @error('page_bg_image') is-invalid @enderror" accept="image/*">
                                    @error('page_bg_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Banner Image</label>
                                    @if($state->banner_image)
                                        <img src="{{ asset('storage/' . $state->banner_image) }}" width="80" class="d-block mb-2 rounded">
                                    @endif
                                    <input type="file" name="banner_image" class="form-control @error('banner_image') is-invalid @enderror" accept="image/*">
                                    @error('banner_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Banner Footer Image</label>
                                    @if($state->banner_footer_image)
                                        <img src="{{ asset('storage/' . $state->banner_footer_image) }}" width="80" class="d-block mb-2 rounded">
                                    @endif
                                    <input type="file" name="banner_footer_image" class="form-control @error('banner_footer_image') is-invalid @enderror" accept="image/*">
                                    @error('banner_footer_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gallery</label>
                                <div class="d-flex flex-wrap gap-3 mb-2">
                                    @forelse($state->gallery_array as $img)
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
                                <a href="{{ route('state.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-success">Update State</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
