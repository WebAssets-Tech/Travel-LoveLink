@extends('admin.layouts.app')
@section('web_page_title', 'Create Houseboat')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Create New Houseboat</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('houseboat.index') }}">Houseboats</a></li>
                            <li class="breadcrumb-item active">Create New</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <form id="createproject-form" autocomplete="off" enctype="multipart/form-data" class="outer-repeater" novalidate action="{{ route('houseboat.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    @include('admin.layouts.message')
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input id="name" name="name" type="text" class="form-control" placeholder="Enter Name..." required value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label for="location" class="form-label">Location</label>
                                        <input id="location" name="location" type="text" class="form-control" placeholder="e.g. Dal Lake, Nigeen Lake" required value="{{ old('location') }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Category</label>
                                        <input id="category" name="category" type="text" class="form-control" placeholder="e.g. Deluxe, Super Deluxe, Luxury" required value="{{ old('category') }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label for="star_rating" class="form-label">Rating</label>
                                        <input id="star_rating" name="star_rating" type="number" min="1" max="5" class="form-control" placeholder="Enter Rating (1-5)..." required value="{{ old('star_rating', 5) }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-control" name="status">
                                            <option value="1" @if(old('status', 1) == 1) selected @endif>Active</option>
                                            <option value="0" @if(old('status', 1) == 0) selected @endif>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Type</label>
                                        <select class="form-control" name="type">
                                            <option value="Houseboat" @if(old('type', 'Houseboat') == 'Houseboat') selected @endif>Houseboat</option>
                                            <option value="Luxury Houseboat" @if(old('type') == 'Luxury Houseboat') selected @endif>Luxury Houseboat</option>
                                            <option value="Shikara Stay" @if(old('type') == 'Shikara Stay') selected @endif>Shikara Stay</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="short_description" class="form-label">Short Description</label>
                                <textarea class="form-control" id="short_description" maxlength="1000" name="short_description" rows="3" placeholder="Please Enter Short Description">{{ old('short_description') }}</textarea>
                                <small id="charCount" class="form-text text-muted">0/1000 characters</small>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control editor" name="description" placeholder="Description">{{ old('description') }}</textarea>
                            </div>

                            <label class="form-label">Highlights</label>
                            <div class="row" id="highlightWrapper"></div>

                            <div class="col-sm-12 mb-3">
                                <button type="button" class="btn btn-success mt-2" id="addHighlight">Add New Highlight</button>
                            </div>

                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="additional_images" class="form-label">Additional Images (Gallery)</label>
                                    <input id="additional_images" name="additional_images[]" type="file" accept="image/*" class="form-control" multiple>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image</label>
                                        <input id="image" name="image" type="file" accept="image/*" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="page_bg_image" class="form-label">Page BG Image</label>
                                        <input id="page_bg_image" name="page_bg_image" type="file" accept="image/*" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="banner_image" class="form-label">Banner Image</label>
                                        <input id="banner_image" name="banner_image" type="file" accept="image/*" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="banner_footer_image" class="form-label">Banner Footer Image</label>
                                        <input id="banner_footer_image" name="banner_footer_image" type="file" accept="image/*" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">SEO Details</h4>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="meta_title" class="form-label">Meta Title</label>
                                        <input id="meta_title" name="meta_title" type="text" class="form-control" placeholder="Enter meta title..." value="{{ old('meta_title') }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                        <input id="meta_keywords" name="meta_keywords" type="text" class="form-control" placeholder="Enter meta keywords (comma separated)..." value="{{ old('meta_keywords') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control" name="meta_description" rows="6" placeholder="">{{ old('meta_description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="text-end mb-4">
                        <button type="submit" class="btn btn-primary">Create Houseboat</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('web_page_script')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.editor').forEach(editorElement => {
            ClassicEditor.create(editorElement).catch(error => console.error(error));
        });
    });
</script>
<script>
    $(document).ready(function () {
        function addHighlightField(value = '') {
            let highlightHTML = `
                <div class="col-12 highlight-container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <input type="text" class="form-control highlight-input" name="highlights[]" placeholder="Enter your highlight..." value="${value}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <button type="button" class="btn btn-danger removeHighlight">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $("#highlightWrapper").append(highlightHTML);
        }

        let existingHighlights = @json(old('highlights', []));
        if (existingHighlights.length > 0) {
            existingHighlights.forEach(highlight => addHighlightField(highlight));
        } else {
            addHighlightField();
        }

        $("#addHighlight").click(function () {
            addHighlightField();
        });

        $(document).on("click", ".removeHighlight", function () {
            $(this).closest(".highlight-container").remove();
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const description = document.getElementById('short_description');
        const charCount = document.getElementById('charCount');
        const maxLength = description.getAttribute('maxlength');

        function updateCharCount() {
            charCount.textContent = `${description.value.length}/${maxLength} characters`;
        }

        description.addEventListener('input', updateCharCount);
        updateCharCount();
    });
</script>
@endsection
