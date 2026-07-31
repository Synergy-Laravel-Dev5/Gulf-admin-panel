@extends('layout.master')
@section('title', 'Hotels Management')
@section('header-title', 'Hotels')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Hotels Management</h4>
                    </div>
                    <div>
                        <a href="{{ route('hotel.create') }}" class="btn btn-primary">
                            <i class="mdi mdi-plus me-1"></i> Add New Hotel
                        </a>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header pb-0 border-bottom-0">
                                <ul class="nav nav-tabs card-header-tabs" id="hotelCategoryTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="makkah-tab" data-bs-toggle="tab" data-bs-target="#makkah" type="button" role="tab" aria-controls="makkah" aria-selected="true">
                                            Makkah Hotels ({{ $hotels->filter(fn($h) => strtolower($h->city) === 'makkah')->count() }})
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="madinah-tab" data-bs-toggle="tab" data-bs-target="#madinah" type="button" role="tab" aria-controls="madinah" aria-selected="false">
                                            Madinah Hotels ({{ $hotels->filter(fn($h) => strtolower($h->city) === 'madinah')->count() }})
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="other-tab" data-bs-toggle="tab" data-bs-target="#other" type="button" role="tab" aria-controls="other" aria-selected="false">
                                            Other Countries/Locations Hotels ({{ $hotels->filter(fn($h) => strtolower($h->city) !== 'makkah' && strtolower($h->city) !== 'madinah')->count() }})
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="hotelCategoryTabsContent">
                                    
                                    <!-- Makkah Hotels Tab -->
                                    <div class="tab-pane fade show active" id="makkah" role="tabpanel" aria-labelledby="makkah-tab">
                                        @include('hotel.partials.hotel_table', ['hotelsList' => $hotels->filter(fn($h) => strtolower($h->city) === 'makkah')])
                                    </div>

                                    <!-- Madinah Hotels Tab -->
                                    <div class="tab-pane fade" id="madinah" role="tabpanel" aria-labelledby="madinah-tab">
                                        @include('hotel.partials.hotel_table', ['hotelsList' => $hotels->filter(fn($h) => strtolower($h->city) === 'madinah')])
                                    </div>

                                    <!-- Other Hotels Tab -->
                                    <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
                                        @include('hotel.partials.hotel_table', ['hotelsList' => $hotels->filter(fn($h) => strtolower($h->city) !== 'makkah' && strtolower($h->city) !== 'madinah')])
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
