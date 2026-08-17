@extends('layout.master')
@section('title', 'Add International Package')
@section('header-title', 'Add International Package')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3">
                    <h4 class="fs-18 fw-semibold m-0">Add International Package</h4>
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

                                <form action="{{ route('international-package.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Title</label>
                                            <input type="text" name="title" class="form-control"
                                                value="{{ old('title') }}" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select" required>
                                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="inactive"
                                                    {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Subtitle</label>
                                            <input type="text" name="subtitle" class="form-control"
                                                value="{{ old('subtitle') }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Departure City</label>
                                            <input type="text" name="departure_city" class="form-control"
                                                placeholder="e.g. Karachi" value="{{ old('departure_city') }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Destination Country</label>
                                            <input type="text" name="destination_country" class="form-control"
                                                placeholder="e.g. Turkey" value="{{ old('destination_country') }}" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Destination City</label>
                                            <input type="text" name="destination_city" class="form-control"
                                                placeholder="e.g. Istanbul" value="{{ old('destination_city') }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Duration (Days)</label>
                                            <input type="number" name="duration_days" class="form-control"
                                                placeholder="e.g. 7" value="{{ old('duration_days') }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Hotel Name</label>
                                            <select name="hotel_name" class="form-select">
                                                <option value="">Select Hotel</option>
                                                @foreach ($hotels as $hotel)
                                                    <option value="{{ $hotel->name }}" {{ old('hotel_name') == $hotel->name ? 'selected' : '' }}>
                                                        {{ $hotel->name }} ({{ ucfirst($hotel->city) }} - {{ $hotel->star_rating }}★)
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Star Rating</label>
                                            <select name="star_rating" class="form-select">
                                                <option value="">Select Rating</option>
                                                @foreach (['3 Star', '4 Star', '5 Star'] as $rating)
                                                    <option value="{{ $rating }}"
                                                        {{ old('star_rating') == $rating ? 'selected' : '' }}>
                                                        {{ $rating }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Visa Required?</label>
                                            <select name="visa_required" class="form-select">
                                                <option value="1" {{ old('visa_required') == '1' ? 'selected' : '' }}>
                                                    Yes</option>
                                                <option value="0" {{ old('visa_required') == '0' ? 'selected' : '' }}>
                                                    No</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Travel Date From</label>
                                            <input type="date" name="travel_date_from" class="form-control"
                                                value="{{ old('travel_date_from') }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Travel Date To</label>
                                            <input type="date" name="travel_date_to" class="form-control"
                                                value="{{ old('travel_date_to') }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Price (Per Person)</label>
                                            <input type="number" step="0.01" name="price_per_person"
                                                class="form-control" value="{{ old('price_per_person') }}">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Key Features</label>
                                            <textarea name="features" rows="4" class="form-control summernote">{{ old('features') }}</textarea>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Requirements</label>
                                            <textarea name="requirements" rows="4" class="form-control summernote">{{ old('requirements') }}</textarea>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" rows="4" class="form-control summernote">{{ old('description') }}</textarea>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Package Image</label>
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3">Save Package</button>
                                    <a href="{{ route('international-package.index') }}"
                                        class="btn btn-outline-secondary mt-3">Cancel</a>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
