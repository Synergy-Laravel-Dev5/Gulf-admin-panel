@extends('layout.master')
@section('title', 'Edit Tutorial')
@section('header-title', 'Edit Tutorial')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Edit Tutorial</h4>
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
                                <h5 class="mb-0">Edit Tutorial Details</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('tutorial.update', $tutorial->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <!-- Title -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Title <span class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control" value="{{ old('title', $tutorial->title) }}" required>
                                        </div>

                                        <!-- Category -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Category</label>
                                            <input type="text" name="category" class="form-control" value="{{ old('category', $tutorial->category) }}">
                                        </div>

                                        <!-- Description -->
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" class="form-control" rows="3">{{ old('description', $tutorial->description) }}</textarea>
                                        </div>

                                        <!-- Video URL -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Video URL</label>
                                            <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $tutorial->video_url) }}">
                                        </div>

                                        <!-- Video File -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Video File Upload (Change file)</label>
                                            <input type="file" name="video_file" class="form-control" accept="video/*">
                                            @if ($tutorial->video_file_url)
                                                <small class="d-block mt-1">Current: <a href="{{ $tutorial->video_file_url }}" target="_blank">View Video File</a></small>
                                            @endif
                                        </div>

                                        <!-- Thumbnail -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Thumbnail Image (Change image)</label>
                                            <input type="file" name="thumbnail" class="form-control" accept="image/*">
                                            @if ($tutorial->thumbnail_url)
                                                <div class="mt-2">
                                                    <img src="{{ $tutorial->thumbnail_url }}" alt="thumbnail" style="height:60px;" class="rounded border">
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Status -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-control" required>
                                                <option value="active" {{ old('status', $tutorial->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status', $tutorial->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="text-end mt-3">
                                        <button type="submit" class="btn btn-primary px-4">Update Tutorial</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
