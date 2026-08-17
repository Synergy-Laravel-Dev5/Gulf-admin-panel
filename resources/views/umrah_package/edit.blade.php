@extends('layout.master')
@section('title', 'Edit Umrah Package')
@section('header-title', 'Edit Umrah Package')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3">
                    <h4 class="fs-18 fw-semibold m-0">Edit Umrah Package</h4>
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

                                <form action="{{ route('umrah-package.update', $umrahPackage->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Title</label>
                                            <input type="text" name="title" class="form-control"
                                                value="{{ old('title', $umrahPackage->title) }}" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select" required>
                                                <option value="active"
                                                    {{ old('status', $umrahPackage->status) == 'active' ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="inactive"
                                                    {{ old('status', $umrahPackage->status) == 'inactive' ? 'selected' : '' }}>
                                                    Inactive</option>
                                            </select>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Subtitle</label>
                                            <input type="text" name="subtitle" class="form-control"
                                                value="{{ old('subtitle', $umrahPackage->subtitle) }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Makkah Hotel Name</label>
                                            <select name="makkah_hotel_name" class="form-select">
                                                <option value="">Select Makkah Hotel</option>
                                                @foreach ($makkahHotels as $hotel)
                                                    <option value="{{ $hotel->name }}"
                                                        data-distance="{{ $hotel->distance }}"
                                                        {{ old('makkah_hotel_name', $umrahPackage->makkah_hotel_name) == $hotel->name ? 'selected' : '' }}>
                                                        {{ $hotel->name }} ({{ $hotel->star_rating }}★)
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Makkah Hotel Distance</label>
                                            <input type="text" name="makkah_hotel_distance" id="makkah_hotel_distance"
                                                class="form-control" placeholder="e.g. 550 Meters"
                                                value="{{ old('makkah_hotel_distance', $umrahPackage->makkah_hotel_distance) }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Madinah Hotel Name</label>
                                            <select name="madinah_hotel_name" class="form-select">
                                                <option value="">Select Madinah Hotel</option>
                                                @foreach ($madinahHotels as $hotel)
                                                    <option value="{{ $hotel->name }}"
                                                        data-distance="{{ $hotel->distance }}"
                                                        {{ old('madinah_hotel_name', $umrahPackage->madinah_hotel_name) == $hotel->name ? 'selected' : '' }}>
                                                        {{ $hotel->name }} ({{ $hotel->star_rating }}★)
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Madinah Hotel Distance</label>
                                            <input type="text" name="madinah_hotel_distance" id="madinah_hotel_distance"
                                                class="form-control" placeholder="e.g. 200 Meters"
                                                value="{{ old('madinah_hotel_distance', $umrahPackage->madinah_hotel_distance) }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Travel Date From</label>
                                            <input type="date" name="travel_date_from" class="form-control"
                                                value="{{ old('travel_date_from', $umrahPackage->travel_date_from) }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Travel Date To</label>
                                            <input type="date" name="travel_date_to" class="form-control"
                                                value="{{ old('travel_date_to', $umrahPackage->travel_date_to) }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Price (Sharing)</label>
                                            <input type="number" step="0.01" name="price_sharing" class="form-control"
                                                value="{{ old('price_sharing', $umrahPackage->price_sharing) }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Price (Triple)</label>
                                            <input type="number" step="0.01" name="price_triple" class="form-control"
                                                value="{{ old('price_triple', $umrahPackage->price_triple) }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Price (Double)</label>
                                            <input type="number" step="0.01" name="price_double" class="form-control"
                                                value="{{ old('price_double', $umrahPackage->price_double) }}">
                                        </div>

                                        <div class="col-12 my-3">
                                            <hr>
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <h5 class="fs-16 fw-semibold text-primary m-0"><i class="mdi mdi-clock-outline me-1"></i> Package Duration & Pricing Options <small class="text-muted fs-13">(Optional)</small></h5>
                                            </div>
                                            <p class="text-muted fs-13 mb-3">Click on any duration option below to enable it and enter package prices for that specific duration (10, 15, 20, or 28 days).</p>
                                            
                                            <div class="row g-3">
                                                @php
                                                    $durationsData = old('durations', $umrahPackage->durations ?? []);
                                                @endphp
                                                @foreach ([10, 15, 20, 28] as $days)
                                                    @php
                                                        $durationItem = $durationsData[$days] ?? null;
                                                        $isOldEnabled = old("durations.$days.enabled", !empty($durationItem['enabled']));
                                                        $sharingVal = old("durations.$days.price_sharing", $durationItem['price_sharing'] ?? '');
                                                        $tripleVal  = old("durations.$days.price_triple", $durationItem['price_triple'] ?? '');
                                                        $doubleVal  = old("durations.$days.price_double", $durationItem['price_double'] ?? '');
                                                    @endphp
                                                    <div class="col-md-6 col-lg-3">
                                                        <div class="card border {{ $isOldEnabled ? 'border-primary' : 'border-light' }} shadow-sm h-100 duration-card" id="duration_card_{{ $days }}">
                                                            <div class="card-header bg-light d-flex align-items-center justify-content-between" style="cursor: pointer;" 
                                                                 onclick="toggleDuration('{{ $days }}')">
                                                                <span class="fw-bold text-dark fs-14"><i class="mdi mdi-calendar-clock me-1 text-primary"></i> {{ $days }} Days Package</span>
                                                                <div class="form-check form-switch m-0" onclick="event.stopPropagation();">
                                                                    <input class="form-check-input duration-toggle" type="checkbox" name="durations[{{ $days }}][enabled]" 
                                                                           id="duration_switch_{{ $days }}" value="1" 
                                                                           {{ $isOldEnabled ? 'checked' : '' }} onchange="updateDurationForm('{{ $days }}')">
                                                                </div>
                                                            </div>
                                                            <div class="card-body duration-form-body {{ $isOldEnabled ? '' : 'd-none' }}" id="duration_form_{{ $days }}">
                                                                <div class="mb-2">
                                                                    <label class="form-label fs-12 mb-1">Price (Sharing)</label>
                                                                    <input type="number" step="0.01" name="durations[{{ $days }}][price_sharing]" 
                                                                           class="form-control form-control-sm" placeholder="e.g. 1500" 
                                                                           value="{{ $sharingVal }}">
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label class="form-label fs-12 mb-1">Price (Triple)</label>
                                                                    <input type="number" step="0.01" name="durations[{{ $days }}][price_triple]" 
                                                                           class="form-control form-control-sm" placeholder="e.g. 1800" 
                                                                           value="{{ $tripleVal }}">
                                                                </div>
                                                                <div class="mb-0">
                                                                    <label class="form-label fs-12 mb-1">Price (Double)</label>
                                                                    <input type="number" step="0.01" name="durations[{{ $days }}][price_double]" 
                                                                           class="form-control form-control-sm" placeholder="e.g. 2200" 
                                                                           value="{{ $doubleVal }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <hr class="mt-4">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Key Features</label>
                                            <textarea name="features" rows="4" class="form-control summernote">{{ old('features', $umrahPackage->features) }}</textarea>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Requirements</label>
                                            <textarea name="requirements" rows="4" class="form-control summernote">{{ old('requirements', $umrahPackage->requirements) }}</textarea>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" rows="4" class="form-control summernote">{{ old('description', $umrahPackage->description) }}</textarea>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Package Image</label>
                                            <input type="file" name="image" class="form-control">
                                            @if ($umrahPackage->image)
                                                <div class="mt-2">
                                                    <img src="{{ str_contains($umrahPackage->image, '/') ? asset('storage/' . $umrahPackage->image) : asset('assets/images/packages/umrah/' . $umrahPackage->image) }}"
                                                        width="80" height="80"
                                                        style="object-fit:cover; border-radius:4px;">
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3">Update Package</button>
                                    <a href="{{ route('umrah-package.index') }}"
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
        function toggleDuration(days) {
            const switchEl = document.getElementById('duration_switch_' + days);
            switchEl.checked = !switchEl.checked;
            updateDurationForm(days);
        }

        function updateDurationForm(days) {
            const switchEl = document.getElementById('duration_switch_' + days);
            const formEl = document.getElementById('duration_form_' + days);
            const cardEl = document.getElementById('duration_card_' + days);
            
            if (switchEl.checked) {
                formEl.classList.remove('d-none');
                cardEl.classList.add('border-primary');
                cardEl.classList.remove('border-light');
            } else {
                formEl.classList.add('d-none');
                cardEl.classList.remove('border-primary');
                cardEl.classList.add('border-light');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const makkahSelect = document.querySelector('select[name="makkah_hotel_name"]');
            const makkahDistance = document.getElementById('makkah_hotel_distance');
            const madinahSelect = document.querySelector('select[name="madinah_hotel_name"]');
            const madinahDistance = document.getElementById('madinah_hotel_distance');

            if (makkahSelect) {
                makkahSelect.addEventListener('change', function() {
                    const selected = this.options[this.selectedIndex];
                    makkahDistance.value = selected.getAttribute('data-distance') || '';
                });
            }

            if (madinahSelect) {
                madinahSelect.addEventListener('change', function() {
                    const selected = this.options[this.selectedIndex];
                    madinahDistance.value = selected.getAttribute('data-distance') || '';
                });
            }
        });
    </script>
@endsection
