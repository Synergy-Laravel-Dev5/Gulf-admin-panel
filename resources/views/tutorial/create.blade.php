@extends('layout.master')
@section('title', 'Add Tutorial')
@section('header-title', 'Add Tutorial')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Add New Tutorial</h4>
                    </div>
                    <div>
                        <a href="{{ route('tutorial.index') }}" class="btn btn-outline-secondary">
                            <i class="mdi mdi-arrow-left"></i> Back to Tutorials
                        </a>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Tutorial Details</h5>
                            </div>
                            <div class="card-body">
                                <form id="tutorialForm" action="{{ route('tutorial.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <!-- Title -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Title <span class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="Enter tutorial title">
                                        </div>

                                        <!-- Category -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Category</label>
                                            <input type="text" name="category" class="form-control" value="{{ old('category') }}" placeholder="e.g. Visa, Hajj, Umrah, General">
                                        </div>

                                        <!-- Description -->
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" class="form-control" rows="3" placeholder="Enter tutorial description">{{ old('description') }}</textarea>
                                        </div>

                                        <!-- Video URL -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Video URL (YouTube/Vimeo/Direct Link)</label>
                                            <input type="url" name="video_url" class="form-control" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=...">
                                        </div>

                                        <!-- Video File -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Video File Upload (MP4, MOV, AVI - Max 100MB)</label>
                                            <input type="file" name="video_file" class="form-control" accept="video/*">
                                        </div>

                                        <!-- Thumbnail -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Thumbnail Image</label>
                                            <input type="file" name="thumbnail" class="form-control" accept="image/*">
                                        </div>

                                        <!-- Status -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-control" required>
                                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="text-end mt-3">
                                        <button type="submit" id="submitBtn" class="btn btn-primary px-4">Save Tutorial</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('tutorialForm').addEventListener('submit', function(e) {
            var btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Uploading Video... Please wait';
        });
    </script>

@endsection
