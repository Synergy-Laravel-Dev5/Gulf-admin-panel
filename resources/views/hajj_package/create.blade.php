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
                                        <!-- General Info Section -->
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

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Maktab Category</label>
                                            <input type="text" name="maktab_category" class="form-control"
                                                placeholder="e.g. Category A, Maktab 3" value="{{ old('maktab_category') }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Zone</label>
                                            <input type="text" name="zone" class="form-control"
                                                placeholder="e.g. Zone A" value="{{ old('zone') }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">No of Days</label>
                                            <input type="text" name="no_of_days" class="form-control"
                                                placeholder="e.g. 40 Days" value="{{ old('no_of_days') }}">
                                        </div>

                                        <h5 class="my-3 text-primary">Makkah Hotel Details</h5>
                                        <hr>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Makkah Hotel Name</label>
                                            <select name="makkah_hotel_name" class="form-select makkah-hotel-select">
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

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Makkah Hotel Period</label>
                                            <input type="text" name="makkah_hotel_period" class="form-control"
                                                placeholder="e.g. 15 Zil Qadda to 25 Zil Qadda"
                                                value="{{ old('makkah_hotel_period') }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Makkah Hotel Meal Plan</label>
                                            <select name="makkah_hotel_meal_plan" class="form-select">
                                                <option value="">Select Meal Plan</option>
                                                @foreach($mealTypes as $meal)
                                                    <option value="{{ $meal->name }}" {{ old('makkah_hotel_meal_plan') == $meal->name ? 'selected' : '' }}>
                                                        {{ $meal->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Makkah Hotel Category</label>
                                            <input type="text" name="makkah_hotel_category" class="form-control"
                                                placeholder="e.g. 5 Star" value="{{ old('makkah_hotel_category') }}">
                                        </div>

                                        <h5 class="my-3 text-primary">Medina Hotel Details</h5>
                                        <hr>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Madinah Hotel Name</label>
                                            <select name="madinah_hotel_name" class="form-select madinah-hotel-select">
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

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Madinah Hotel Period</label>
                                            <input type="text" name="madinah_hotel_period" class="form-control"
                                                placeholder="e.g. 25 Zil Qadda to 05 Zil Hujja"
                                                value="{{ old('madinah_hotel_period') }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Madinah Hotel Meal Plan</label>
                                            <select name="madinah_hotel_meal_plan" class="form-select">
                                                <option value="">Select Meal Plan</option>
                                                @foreach($mealTypes as $meal)
                                                    <option value="{{ $meal->name }}" {{ old('madinah_hotel_meal_plan') == $meal->name ? 'selected' : '' }}>
                                                        {{ $meal->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Madinah Hotel Category</label>
                                            <input type="text" name="madinah_hotel_category" class="form-control"
                                                placeholder="e.g. 5 Star" value="{{ old('madinah_hotel_category') }}">
                                        </div>

                                        <h5 class="my-3 text-primary">Azizia Hotel Details</h5>
                                        <hr>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Azizia Hotel Name</label>
                                            <select name="azizia_hotel_name" class="form-select azizia-hotel-select">
                                                <option value="">Select Azizia Hotel</option>
                                                @foreach ($aziziaHotels as $hotel)
                                                    <option value="{{ $hotel->name }}"
                                                        data-distance="{{ $hotel->distance }}"
                                                        {{ old('azizia_hotel_name') == $hotel->name ? 'selected' : '' }}>
                                                        {{ $hotel->name }} ({{ $hotel->star_rating }}★)
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Azizia Hotel Distance</label>
                                            <input type="text" name="azizia_hotel_distance" id="azizia_hotel_distance"
                                                class="form-control" placeholder="e.g. 2 KM"
                                                value="{{ old('azizia_hotel_distance') }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Azizia Hotel Period</label>
                                            <input type="text" name="azizia_hotel_period" class="form-control"
                                                placeholder="e.g. 05 Zil Hujja to 15 Zil Qadda"
                                                value="{{ old('azizia_hotel_period') }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Azizia Hotel Meal Plan</label>
                                            <select name="azizia_hotel_meal_plan" class="form-select">
                                                <option value="">Select Meal Plan</option>
                                                @foreach($mealTypes as $meal)
                                                    <option value="{{ $meal->name }}" {{ old('azizia_hotel_meal_plan') == $meal->name ? 'selected' : '' }}>
                                                        {{ $meal->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Azizia Hotel Category</label>
                                            <input type="text" name="azizia_hotel_category" class="form-control"
                                                placeholder="e.g. Building" value="{{ old('azizia_hotel_category') }}">
                                        </div>

                                        <h5 class="my-3 text-primary">Inclusions & Pricing</h5>
                                        <hr>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Qurbani</label>
                                            <select name="qurbani" class="form-select">
                                                <option value="Included" {{ old('qurbani') == 'Included' ? 'selected' : '' }}>Included</option>
                                                <option value="Not Included" {{ old('qurbani') == 'Not Included' ? 'selected' : '' }}>Not Included</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Airline Ticket</label>
                                            <select name="airline_ticket" class="form-select">
                                                <option value="Direct Airline" {{ old('airline_ticket') == 'Direct Airline' ? 'selected' : '' }}>Direct Airline</option>
                                                <option value="Indirect Airline" {{ old('airline_ticket') == 'Indirect Airline' ? 'selected' : '' }}>Indirect Airline</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Ziarat</label>
                                            <select name="ziarat" class="form-select">
                                                <option value="Included" {{ old('ziarat') == 'Included' ? 'selected' : '' }}>Included</option>
                                                <option value="Not Included" {{ old('ziarat') == 'Not Included' ? 'selected' : '' }}>Not Included</option>
                                            </select>
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

                                        <h5 class="my-3 text-primary">Transportation</h5>
                                        <hr>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label fw-bold">Route Selection</label>
                                            <select name="transportation_route" id="transportation_route" class="form-select">
                                                <option value="">Select Transportation Route</option>
                                                @foreach($transportationRoutes as $route)
                                                    <option value="{{ $route->code }}" {{ old('transportation_route') == $route->code ? 'selected' : '' }}>
                                                        {{ $route->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Route Segments (Dynamically Shown/Hidden) -->
                                        <div id="transportation_segments_container" class="row g-3" style="display: none;">
                                            <div class="col-md-6 mb-2 trans-segment" data-segment="jeddah_makk">
                                                <label class="form-label">Jeddah Airport to Makkah Hotel</label>
                                                <select name="trans_jeddah_makkah" class="form-select">
                                                    <option value="">Select Option</option>
                                                    <option value="Bus" {{ old('trans_jeddah_makkah') == 'Bus' ? 'selected' : '' }}>Bus</option>
                                                    <option value="Private Car" {{ old('trans_jeddah_makkah') == 'Private Car' ? 'selected' : '' }}>Private Car</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-2 trans-segment" data-segment="makkah_madinah">
                                                <label class="form-label">Makkah Hotel to Medina Hotel</label>
                                                <select name="trans_makkah_madinah" class="form-select">
                                                    <option value="">Select Option</option>
                                                    <option value="Bus" {{ old('trans_makkah_madinah') == 'Bus' ? 'selected' : '' }}>Bus</option>
                                                    <option value="Train" {{ old('trans_makkah_madinah') == 'Train' ? 'selected' : '' }}>Train</option>
                                                    <option value="Private Car" {{ old('trans_makkah_madinah') == 'Private Car' ? 'selected' : '' }}>Private Car</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-2 trans-segment" data-segment="madinah_makkah">
                                                <label class="form-label">Medina Hotel to Makkah Hotel</label>
                                                <select name="trans_madinah_makkah" class="form-select">
                                                    <option value="">Select Option</option>
                                                    <option value="Bus" {{ old('trans_madinah_makkah') == 'Bus' ? 'selected' : '' }}>Bus</option>
                                                    <option value="Train" {{ old('trans_madinah_makkah') == 'Train' ? 'selected' : '' }}>Train</option>
                                                    <option value="Private Car" {{ old('trans_madinah_makkah') == 'Private Car' ? 'selected' : '' }}>Private Car</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-2 trans-segment" data-segment="makkah_jeddah">
                                                <label class="form-label">Makkah Hotel to Jeddah Airport</label>
                                                <select name="trans_makkah_jeddah" class="form-select">
                                                    <option value="">Select Option</option>
                                                    <option value="Bus" {{ old('trans_makkah_jeddah') == 'Bus' ? 'selected' : '' }}>Bus</option>
                                                    <option value="Private Car" {{ old('trans_makkah_jeddah') == 'Private Car' ? 'selected' : '' }}>Private Car</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-2 trans-segment" data-segment="madinah_madinah">
                                                <label class="form-label">Medina Hotel to Medina Airport</label>
                                                <select name="trans_madinah_madinah" class="form-select">
                                                    <option value="">Select Option</option>
                                                    <option value="Bus" {{ old('trans_madinah_madinah') == 'Bus' ? 'selected' : '' }}>Bus</option>
                                                    <option value="Private Car" {{ old('trans_madinah_madinah') == 'Private Car' ? 'selected' : '' }}>Private Car</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-2 trans-segment" data-segment="madinah_jeddah">
                                                <label class="form-label">Medina Hotel to Jeddah Airport</label>
                                                <select name="trans_madinah_jeddah" class="form-select">
                                                    <option value="">Select Option</option>
                                                    <option value="Bus" {{ old('trans_madinah_jeddah') == 'Bus' ? 'selected' : '' }}>Bus</option>
                                                    <option value="Train" {{ old('trans_madinah_jeddah') == 'Train' ? 'selected' : '' }}>Train</option>
                                                    <option value="Private Car" {{ old('trans_madinah_jeddah') == 'Private Car' ? 'selected' : '' }}>Private Car</option>
                                                </select>
                                            </div>
                                        </div>

                                        <h5 class="my-3 text-primary">Documents Requirements</h5>
                                        <hr>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label d-block">Documents Required</label>
                                            <div class="requirements-wrapper" id="requirementsWrapper">
                                                @php
                                                    $requirements = old('requirements', ['Valid Passport', 'Picture with White Background', 'CNIC Front & Back']);
                                                @endphp

                                                @foreach ($requirements as $req)
                                                    <div class="input-group mb-2 requirement-row">
                                                        <input type="text" name="requirements[]" class="form-control" value="{{ $req }}" placeholder="Enter document requirement">
                                                        <button type="button" class="btn btn-outline-danger remove-requirement-btn">&times;</button>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" id="addRequirementBtn">
                                                <i class="mdi mdi-plus"></i> Add Requirement
                                            </button>
                                        </div>

                                        <h5 class="my-3 text-primary">Key Features & Description</h5>
                                        <hr>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Key Features</label>
                                            <textarea name="features" rows="6" class="form-control summernote">{{ old('features') }}</textarea>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" rows="6" class="form-control summernote">{{ old('description') }}</textarea>
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
            // Hotel select helpers
            const makkahSelect = document.querySelector('.makkah-hotel-select');
            const makkahDistance = document.getElementById('makkah_hotel_distance');
            const madinahSelect = document.querySelector('.madinah-hotel-select');
            const madinahDistance = document.getElementById('madinah_hotel_distance');
            const aziziaSelect = document.querySelector('.azizia-hotel-select');
            const aziziaDistance = document.getElementById('azizia_hotel_distance');

            if(makkahSelect) {
                makkahSelect.addEventListener('change', function() {
                    const selected = this.options[this.selectedIndex];
                    makkahDistance.value = selected.getAttribute('data-distance') || '';
                });
            }

            if(madinahSelect) {
                madinahSelect.addEventListener('change', function() {
                    const selected = this.options[this.selectedIndex];
                    madinahDistance.value = selected.getAttribute('data-distance') || '';
                });
            }

            if(aziziaSelect) {
                aziziaSelect.addEventListener('change', function() {
                    const selected = this.options[this.selectedIndex];
                    aziziaDistance.value = selected.getAttribute('data-distance') || '';
                });
            }

            // Route-based transportation options visibility logic
            const routeSelect = document.getElementById('transportation_route');
            const segmentsContainer = document.getElementById('transportation_segments_container');
            const segments = document.querySelectorAll('.trans-segment');

            const routeMapping = {
                'jeddah_makkah_madinah_jeddah': ['jeddah_makk', 'makkah_madinah', 'madinah_jeddah'],
                'jeddah_makkah_madinah_madinah': ['jeddah_makk', 'makkah_madinah', 'madinah_madinah'],
                'madinah_madinah_makkah_jeddah': ['madinah_makkah', 'makkah_jeddah'],
                'jeddah_makkah_jeddah': ['jeddah_makk', 'makkah_jeddah'],
                'madinah_madinah_makkah_madinah': ['madinah_makkah', 'madinah_madinah'],
                'custom': ['jeddah_makk', 'makkah_madinah', 'madinah_makkah', 'makkah_jeddah', 'madinah_madinah', 'madinah_jeddah']
            };

            function handleRouteVisibility() {
                const selectedRoute = routeSelect.value;
                if (!selectedRoute) {
                    segmentsContainer.style.display = 'none';
                    segments.forEach(seg => {
                        seg.style.display = 'none';
                        const selectEl = seg.querySelector('select');
                        if (selectEl) selectEl.value = '';
                    });
                    return;
                }

                segmentsContainer.style.display = 'flex';
                const activeSegments = routeMapping[selectedRoute] || [];

                segments.forEach(seg => {
                    const segName = seg.getAttribute('data-segment');
                    const selectEl = seg.querySelector('select');
                    if (activeSegments.includes(segName)) {
                        seg.style.display = 'block';
                    } else {
                        seg.style.display = 'none';
                        if (selectEl) selectEl.value = '';
                    }
                });
            }

            routeSelect.addEventListener('change', handleRouteVisibility);
            handleRouteVisibility(); // Initialize on page load

            // Dynamic requirements repeater logic
            const reqWrapper = document.getElementById('requirementsWrapper');
            const addReqBtn = document.getElementById('addRequirementBtn');

            if(addReqBtn) {
                addReqBtn.addEventListener('click', function() {
                    const row = document.createElement('div');
                    row.className = 'input-group mb-2 requirement-row';
                    row.innerHTML = `
                        <input type="text" name="requirements[]" class="form-control" value="" placeholder="Enter document requirement">
                        <button type="button" class="btn btn-outline-danger remove-requirement-btn">&times;</button>
                    `;
                    reqWrapper.appendChild(row);
                });
            }

            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-requirement-btn')) {
                    const row = e.target.closest('.requirement-row');
                    if (reqWrapper.querySelectorAll('.requirement-row').length <= 1) {
                        row.querySelector('input').value = '';
                        return;
                    }
                    row.remove();
                }
            });
        });
    </script>
@endsection
