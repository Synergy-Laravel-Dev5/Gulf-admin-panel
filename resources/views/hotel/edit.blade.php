@extends('layout.master')
@section('title', 'Edit Hotel')
@section('header-title', 'Edit Hotel')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Edit Hotel</h4>
                    </div>
                    <a href="{{ route('hotel.index') }}" class="btn btn-outline-secondary">
                        <i class="mdi mdi-arrow-left"></i> Back to Hotels
                    </a>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <form action="{{ route('hotel.update', $hotel->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Hotel Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ old('name', $hotel->name) }}" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">City <span class="text-danger">*</span></label>
                                            <select name="city" class="form-select" required>
                                                <option value="">Select City</option>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->name }}" {{ old('city', $hotel->city) == $city->name ? 'selected' : '' }}>
                                                        {{ ucfirst($city->name) }} ({{ $city->country }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Star Rating <span class="text-danger">*</span></label>
                                            <select name="star_rating" class="form-select" required>
                                                <option value="5" {{ old('star_rating', $hotel->star_rating) == '5' ? 'selected' : '' }}>5 Star (★★★★★)</option>
                                                <option value="4" {{ old('star_rating', $hotel->star_rating) == '4' ? 'selected' : '' }}>4 Star (★★★★)</option>
                                                <option value="3" {{ old('star_rating', $hotel->star_rating) == '3' ? 'selected' : '' }}>3 Star (★★★)</option>
                                                <option value="2" {{ old('star_rating', $hotel->star_rating) == '2' ? 'selected' : '' }}>2 Star (★★)</option>
                                                <option value="1" {{ old('star_rating', $hotel->star_rating) == '1' ? 'selected' : '' }}>1 Star (★)</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Distance / Location Info</label>
                                            <input type="text" name="distance" class="form-control"
                                                value="{{ old('distance', $hotel->distance) }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Main Cover Image (Change image)</label>
                                            <input type="file" name="image" class="form-control" accept="image/*">
                                            @if ($hotel->image_url)
                                                <div class="mt-2">
                                                    <img src="{{ $hotel->image_url }}" width="80" height="80" style="object-fit:cover; border-radius:4px;" class="border">
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Add More Gallery Images</label>
                                            <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-select" required>
                                                <option value="active" {{ old('status', $hotel->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status', $hotel->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="form-label">Hotel Description (Summernote Rich Editor)</label>
                                            <textarea name="description" class="form-control summernote" rows="6">{{ old('description', $hotel->description) }}</textarea>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3">Update Hotel</button>
                                    <a href="{{ route('hotel.index') }}" class="btn btn-outline-secondary mt-3">Cancel</a>
                                </form>

                                @if($hotel->images && $hotel->images->count() > 0)
                                    <hr class="my-4">
                                    <h5 class="mb-3 text-primary"><i class="mdi mdi-image-multiple me-1"></i> Current Gallery Images</h5>
                                    <div class="row g-3">
                                        @foreach($hotel->images as $img)
                                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 text-center">
                                                <div class="border rounded p-2 position-relative bg-light">
                                                    <img src="{{ $img->image_url }}" class="img-fluid rounded mb-2" style="height:100px; object-fit:cover; width:100%;">
                                                    <form action="{{ route('hotel.image.delete', $img->id) }}" method="POST" onsubmit="return confirm('Delete this image?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger w-100">
                                                            <i class="mdi mdi-delete"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush
