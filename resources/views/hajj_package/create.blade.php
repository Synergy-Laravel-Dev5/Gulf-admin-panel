@extends('layout.master')
@section('title', 'Add Hajj Package')
@section('header-title', 'Add Hajj Package')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3">
                    <h4 class="fs-18 fw-semibold m-0">Add Hajj Package</h4>
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

                                <form action="{{ route('hajj-package.store') }}" method="POST"
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
                                            <label class="form-label">Makkah Hotel Name</label>
                                            <select name="makkah_hotel_name" class="form-select">
                                                <option value="">Select Makkah Hotel</option>
                                                @foreach ($makkahHotels as $hotel)
                                                    <option value="{{ $hotel->name }}"
                                                        data-distance="{{ $hotel->distance }}"
                                                        {{ old('makkah_hotel_name') == $hotel->name ? 'selected' : '' }}>
                                                        {{ $hotel->name }} ({{ $hotel->star_rating }}★)
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Makkah Hotel Distance</label>
                                            <input type="text" name="makkah_hotel_distance" id="makkah_hotel_distance"
                                                class="form-control" placeholder="e.g. 550 Meters"
                                                value="{{ old('makkah_hotel_distance') }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Madinah Hotel Name</label>
                                            <select name="madinah_hotel_name" class="form-select">
                                                <option value="">Select Madinah Hotel</option>
                                                @foreach ($madinahHotels as $hotel)
                                                    <option value="{{ $hotel->name }}"
                                                        data-distance="{{ $hotel->distance }}"
                                                        {{ old('madinah_hotel_name') == $hotel->name ? 'selected' : '' }}>
                                                        {{ $hotel->name }} ({{ $hotel->star_rating }}★)
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Madinah Hotel Distance</label>
                                            <input type="text" name="madinah_hotel_distance" id="madinah_hotel_distance"
                                                class="form-control" placeholder="e.g. 200 Meters"
                                                value="{{ old('madinah_hotel_distance') }}">
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

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Price (Sharing)</label>
                                            <input type="number" step="0.01" name="price_sharing" class="form-control"
                                                value="{{ old('price_sharing') }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Price (Triple)</label>
                                            <input type="number" step="0.01" name="price_triple" class="form-control"
                                                value="{{ old('price_triple') }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Price (Double)</label>
                                            <input type="number" step="0.01" name="price_double" class="form-control"
                                                value="{{ old('price_double') }}">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Key Features <small class="text-muted">(one per
                                                    line)</small></label>
                                            <textarea name="features" rows="4" class="form-control">{{ old('features') }}</textarea>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Requirements <small class="text-muted">(one per
                                                    line)</small></label>
                                            <textarea name="requirements" rows="4" class="form-control">{{ old('requirements') }}</textarea>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Package Image</label>
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3">Save Package</button>
                                    <a href="{{ route('hajj-package.index') }}"
                                        class="btn btn-outline-secondary mt-3">Cancel</a>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const makkahSelect = document.querySelector('select[name="makkah_hotel_name"]');
            const makkahDistance = document.getElementById('makkah_hotel_distance');
            const madinahSelect = document.querySelector('select[name="madinah_hotel_name"]');
            const madinahDistance = document.getElementById('madinah_hotel_distance');

            makkahSelect.addEventListener('change', function() {
                const selected = this.options[this.selectedIndex];
                makkahDistance.value = selected.getAttribute('data-distance') || '';
            });

            madinahSelect.addEventListener('change', function() {
                const selected = this.options[this.selectedIndex];
                madinahDistance.value = selected.getAttribute('data-distance') || '';
            });
        });
    </script>
@endsection
