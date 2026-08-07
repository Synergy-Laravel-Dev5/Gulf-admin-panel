@extends('layout.master')
@section('title', 'Add Hotel')
@section('header-title', 'Add Hotel')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Add New Hotel</h4>
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

                                <form action="{{ route('hotel.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Hotel Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="e.g. Swissôtel Makkah" value="{{ old('name') }}" required>
                                        </div>

                                         <div class="col-md-6 mb-3">
                                             <label class="form-label">City <span class="text-danger">*</span></label>
                                             <select name="city" class="form-select" required>
                                                 <option value="">Select City</option>
                                                 @foreach($cities as $city)
                                                     <option value="{{ $city->name }}" {{ old('city') == $city->name ? 'selected' : '' }}>
                                                         {{ ucfirst($city->name) }} ({{ $city->country }})
                                                     </option>
                                                 @endforeach
                                             </select>
                                         </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Star Rating <span class="text-danger">*</span></label>
                                            <select name="star_rating" class="form-select" required>
                                                <option value="5" {{ old('star_rating') == '5' ? 'selected' : '' }}>5 Star (★★★★★)</option>
                                                <option value="4" {{ old('star_rating') == '4' ? 'selected' : '' }}>4 Star (★★★★)</option>
                                                <option value="3" {{ old('star_rating') == '3' || old('star_rating') == '' ? 'selected' : '' }}>3 Star (★★★)</option>
                                                <option value="2" {{ old('star_rating') == '2' ? 'selected' : '' }}>2 Star (★★)</option>
                                                <option value="1" {{ old('star_rating') == '1' ? 'selected' : '' }}>1 Star (★)</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Distance / Location Info</label>
                                            <input type="text" name="distance" class="form-control"
                                                placeholder="e.g. 100 Meters / Haram Facing / Corniche Road" value="{{ old('distance') }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-select" required>
                                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Hotel Image</label>
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3">Save Hotel</button>
                                    <a href="{{ route('hotel.index') }}" class="btn btn-outline-secondary mt-3">Cancel</a>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
