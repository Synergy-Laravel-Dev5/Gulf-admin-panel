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

                                <form action="{{ route('hotel.update', $hotel->id) }}" method="POST">
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
                                            <input type="text" name="city" class="form-control" list="citiesList"
                                                value="{{ old('city', $hotel->city) }}" required>
                                            <datalist id="citiesList">
                                                <option value="makkah">
                                                <option value="madinah">
                                                <option value="jeddah">
                                                <option value="riyadh">
                                                <option value="dubai">
                                                <option value="istanbul">
                                            </datalist>
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
                                            <label class="form-label">Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-select" required>
                                                <option value="active" {{ old('status', $hotel->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status', $hotel->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3">Update Hotel</button>
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
