{{-- resources/views/admin/state/create.blade.php --}}
@extends('admin.layouts.app')
@section('web_page_title', 'Add Package Region (State)')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Add Package Region (State)</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('state.index') }}">Package Regions (States)</a></li>
                            <li class="breadcrumb-item active">Add Package Region</li>
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

                        <form action="{{ route('state.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Domestic / International (Country) <span class="text-danger">*</span></label>
                                    <select name="country_id" class="form-select @error('country_id') is-invalid @enderror">
                                        <option value="">Select Scope</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Region / State Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Code</label>
                                    <input type="text" name="code" value="{{ old('code') }}" class="form-control @error('code') is-invalid @enderror" maxlength="10">
                                    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label d-block">Status</label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" name="status" value="1" id="statusSwitch" checked>
                                        <label class="form-check-label" for="statusSwitch">Active</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Short Destinations (comma-separated)</label>
                                    <input type="text" name="short_destinations" value="{{ old('short_destinations') }}" class="form-control @error('short_destinations') is-invalid @enderror" placeholder="e.g. Srinagar, Gulmarg, Pahalgam, Sonamarg">
                                    <small class="text-muted">Shown as short destination pills inside the homepage destination card.</small>
                                    @error('short_destinations') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <hr>
                            <h5 class="mb-3">Images</h5>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Main Image</label>
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Page BG Image</label>
                                    <input type="file" name="page_bg_image" class="form-control @error('page_bg_image') is-invalid @enderror" accept="image/*">
                                    @error('page_bg_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Banner Image</label>
                                    <input type="file" name="banner_image" class="form-control @error('banner_image') is-invalid @enderror" accept="image/*">
                                    @error('banner_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Banner Footer Image</label>
                                    <input type="file" name="banner_footer_image" class="form-control @error('banner_footer_image') is-invalid @enderror" accept="image/*">
                                    @error('banner_footer_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Additional Gallery Images</label>
                                <input type="file" name="additional_images[]" class="form-control @error('additional_images.*') is-invalid @enderror" accept="image/*" multiple>
                                @error('additional_images.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="text-end">
                                <a href="{{ route('state.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-success">Save State</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection