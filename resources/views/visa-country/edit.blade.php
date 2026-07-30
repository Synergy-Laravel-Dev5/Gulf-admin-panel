@extends('layout.master')
@section('title', 'Edit Visa Country')
@section('header-title', 'Edit Visa Country')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Edit Visa Country</h4>
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

                <form action="{{ route('visa-country.update', $country->id) }}" method="POST" id="visaCountryForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Country Details</h5>
                                </div>
                                <div class="card-body row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Country Name</label>
                                        <input type="text" name="country_name" class="form-control" value="{{ old('country_name', $country->country_name) }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Country Code</label>
                                        <input type="text" name="country_code" class="form-control" maxlength="10" value="{{ old('country_code', $country->country_code) }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label d-block">Status</label>
                                        <div class="form-check form-switch mt-2">
                                            <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $country->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label">Active</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Country Flag</label>
                                        <input type="file" name="flag" class="form-control" accept="image/*">
                                        <small class="text-muted">JPG, PNG, WEBP or SVG. Max 2MB. Leave empty to keep current flag.</small>
                                    </div>
                                    @if ($country->flag_url)
                                        <div class="col-md-8 d-flex align-items-end">
                                            <img src="{{ $country->flag_url }}" alt="{{ $country->country_name }}" style="height:50px;border:1px solid #eee;border-radius:4px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="visaTypesWrapper">
                        @forelse ($country->visaTypes as $index => $type)
                            @include('visa-country._visa-type-block', ['index' => $index, 'type' => $type])
                        @empty
                            @include('visa-country._visa-type-block', ['index' => 0, 'type' => null])
                        @endforelse
                    </div>

                    <button type="button" class="btn btn-outline-primary mb-3" id="addVisaTypeBtn">
                        <i class="mdi mdi-plus"></i> Add Another Visa Type
                    </button>

                    <div>
                        <button type="submit" class="btn btn-primary">Update Country</button>
                        <a href="{{ route('visa-country.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <template id="visaTypeTemplate">
        @include('visa-country._visa-type-block', ['index' => '__INDEX__', 'type' => null])
    </template>

    @include('visa-country._repeater-scripts')
@endsection
