@extends('layout.master')

@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Dashboard</h4>
                    </div>
                </div>

                {{-- helper: status -> bootstrap color --}}
                @php
                    $statusColors = [
                        'pending' => 'warning',
                        'in_progress' => 'secondary',
                        'approved' => 'success',
                        'won' => 'success',
                        'rejected' => 'danger',
                        'loss' => 'danger',
                        'converted' => 'primary',
                    ];
                    $statusLabels = [
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'approved' => 'Approved',
                        'won' => 'Approved',
                        'rejected' => 'Rejected',
                        'loss' => 'Rejected',
                        'converted' => 'Converted',
                    ];
                @endphp

                <!-- start row -->
                <div class="row">
                    <div class="col-md-12 col-xl-7">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title text-black mb-0">Applications Overview</h5>
                                    <div class="ms-auto">
                                        <button class="btn btn-sm bg-light border dropdown-toggle fw-medium text-black"
                                            type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">Last 12 Months<i
                                                class="mdi mdi-chevron-down ms-1 fs-14"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">This Month</a>
                                            <a class="dropdown-item" href="#">Last Month</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div id="sales-overview" class="apex-charts"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-xl-5">
                        <div class="row g-3">

                            <div class="col-md-6 col-xl-6">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="widget-first">
                                            <div class="d-flex align-items-center mb-2">
                                                <div
                                                    class="p-2 border border-primary border-opacity-10 bg-primary-subtle rounded-pill me-2">
                                                    <div class="bg-primary rounded-circle widget-size text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24">
                                                            <path fill="#ffffff"
                                                                d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <p class="mb-0 text-dark fs-15">Total Applications</p>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h3 class="mb-0 fs-22 text-black me-3">
                                                    {{ number_format($totalApplications) }}</h3>
                                                <div class="text-center">
                                                    <span
                                                        class="{{ $weeklyGrowth >= 0 ? 'text-primary' : 'text-danger' }} fs-14">
                                                        <i
                                                            class="mdi mdi-trending-{{ $weeklyGrowth >= 0 ? 'up' : 'down' }} fs-14"></i>
                                                        {{ abs($weeklyGrowth) }}%
                                                    </span>
                                                    <p class="text-dark fs-13 mb-0">Last 7 days</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-6">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="widget-first">
                                            <div class="d-flex align-items-center mb-2">
                                                <div
                                                    class="p-2 border border-secondary border-opacity-10 bg-secondary-subtle rounded-pill me-2">
                                                    <div class="bg-secondary rounded-circle widget-size text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24">
                                                            <path fill="#ffffff"
                                                                d="M12 20a8 8 0 1 0 0-16a8 8 0 0 0 0 16m1-13v5.4l4.5 2.7l-.8 1.3L11 13V7z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <p class="mb-0 text-dark fs-15">Pending Applications</p>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h3 class="mb-0 fs-22 text-black me-3">
                                                    {{ number_format($pendingApplications) }}</h3>
                                                <div class="text-center">
                                                    <span class="text-warning fs-14"><i
                                                            class="mdi mdi-clock-outline fs-14"></i></span>
                                                    <p class="text-dark fs-13 mb-0">In queue</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-6">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="widget-first">
                                            <div class="d-flex align-items-center mb-2">
                                                <div
                                                    class="p-2 border border-success border-opacity-10 bg-success-subtle rounded-pill me-2">
                                                    <div class="bg-success rounded-circle widget-size text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24">
                                                            <path fill="#ffffff"
                                                                d="M9 16.2L4.8 12l-1.4 1.4L9 19L21 7l-1.4-1.4z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <p class="mb-0 text-dark fs-15">Approved Applications</p>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h3 class="mb-0 fs-22 text-black me-3">
                                                    {{ number_format($approvedApplications) }}</h3>
                                                <div class="text-center">
                                                    <span class="text-primary fs-14"><i
                                                            class="mdi mdi-trending-up fs-14"></i>
                                                        {{ $approvalRate }}%</span>
                                                    <p class="text-dark fs-13 mb-0">Approval rate</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-6">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="widget-first">
                                            <div class="d-flex align-items-center mb-2">
                                                <div
                                                    class="p-2 border border-danger border-opacity-10 bg-danger-subtle rounded-pill me-2">
                                                    <div class="bg-danger rounded-circle widget-size text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24">
                                                            <path fill="#ffffff"
                                                                d="M19 6.4L17.6 5L12 10.6L6.4 5L5 6.4l5.6 5.6L5 17.6L6.4 19l5.6-5.6l5.6 5.6l1.4-1.4l-5.6-5.6z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <p class="mb-0 text-dark fs-15">Rejected Applications</p>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h3 class="mb-0 fs-22 text-black me-3">
                                                    {{ number_format($rejectedApplications) }}</h3>
                                                <div class="text-muted">
                                                    <span class="text-danger fs-14 me-2"><i
                                                            class="mdi mdi-trending-down fs-14"></i></span>
                                                    <p class="text-dark fs-13 mb-0">Total</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-6">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="widget-first">
                                            <div class="d-flex align-items-center mb-2">
                                                <div
                                                    class="p-2 border border-dark border-opacity-10 bg-dark-subtle rounded-pill me-2">
                                                    <div class="bg-dark rounded-circle widget-size text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24">
                                                            <path fill="none" stroke="#ffffff" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="1.5"
                                                                d="M3 12h18M3 6h18M3 18h18" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <p class="mb-0 text-dark fs-15">Total Countries</p>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h3 class="mb-0 fs-22 text-black me-3">{{ number_format($totalCountries) }}
                                                </h3>
                                                <div class="text-muted">
                                                    <p class="text-dark fs-13 mb-0">Active</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="widget-first">
                                            <div class="d-flex align-items-center mb-2">
                                                <div
                                                    class="p-2 border border-primary border-opacity-10 bg-primary-subtle rounded-pill me-2">
                                                    <div class="bg-primary rounded-circle widget-size text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24">
                                                            <path fill="none" stroke="#ffffff" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="1.5"
                                                                d="M19 9H6.659c-1.006 0-1.51 0-1.634-.309c-.125-.308.23-.672.941-1.398L8.211 5M5 15h12.341c1.006 0 1.51 0 1.634.309c.125.308-.23.672-.941 1.398L15.789 19" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <p class="mb-0 text-dark fs-15">Total Visa Types</p>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h3 class="mb-0 fs-22 text-black me-3">{{ number_format($totalVisaTypes) }}
                                                </h3>
                                                <div class="text-muted">
                                                    <p class="text-dark fs-13 mb-0">Available</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end start -->

                <!-- Start Monthly Sales -->
                <div class="row">
                    <div class="col-md-12 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title text-black mb-0">Latest Applications</h5>
                                </div>
                            </div>

                            <div class="card-body">
                                <ul class="list-group list-group-flush list-group-no-gutters">
                                    @forelse($recentApplications as $app)
                                        <li class="list-group-item">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 align-self-center">
                                                    <div
                                                        class="avatar border border-dashed rounded-circle align-content-center text-center p-1 bg-light">
                                                        <span
                                                            class="fw-semibold text-black">{{ strtoupper(substr($app->full_name ?? 'N A', 0, 1)) }}</span>
                                                    </div>
                                                </div>

                                                <div class="flex-grow-1 ms-3 align-content-center">
                                                    <div class="row">
                                                        <div class="col-7 col-md-5 order-md-1">
                                                            <h6 class="mb-1 text-black fs-15">
                                                                {{ $app->full_name ?? 'N/A' }}</h6>
                                                            <span
                                                                class="fs-14 text-muted">{{ $app->visaType->visa_name ?? 'Visa application' }}</span>
                                                        </div>

                                                        <div class="col-5 col-md-4 order-md-3 text-end mt-2 mt-md-0">
                                                            <h6 class="mb-1 text-black fs-14">
                                                                {{ $app->visaType->country->country_name ?? '—' }}</h6>
                                                            <span
                                                                class="fs-13 text-muted">{{ $app->created_at->format('d M, Y') }}</span>
                                                        </div>

                                                        <div class="col-auto col-md-3 order-md-2 align-self-center">
                                                            @php $color = $statusColors[$app->status] ?? 'secondary'; @endphp
                                                            <span
                                                                class="badge bg-{{ $color }}-subtle text-{{ $color }} fw-semibold rounded-pill">
                                                                {{ $statusLabels[$app->status] ?? ucfirst($app->status) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="list-group-item text-center text-muted py-4">No applications yet.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card overflow-hidden">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title text-black mb-0">Application Status</h5>
                                </div>
                            </div>

                            <div class="card-body">
                                <div id="deals-statistics" class="apex-charts"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title text-black mb-0">Yearly Growth</h5>
                                </div>
                            </div>

                            <div class="card-body">
                                <div id="browservisiting" class="apex-charts"></div>

                                @php
                                    $yoyGrowth =
                                        $lastYearCount > 0
                                            ? round((($thisYearCount - $lastYearCount) / $lastYearCount) * 100)
                                            : ($thisYearCount > 0
                                                ? 100
                                                : 0);
                                @endphp
                                <div class="text-center fw-medium my-3">
                                    {{ abs($yoyGrowth) }}% {{ $yoyGrowth >= 0 ? 'increase' : 'decrease' }} vs last year.
                                </div>

                                <div class="d-flex gap-3 justify-content-between">
                                    <div class="d-flex">
                                        <div
                                            class="bg-primary-subtle rounded-2 p-1 me-2 border border-dashed border-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24">
                                                <path fill="#287F71"
                                                    d="M7 15h2c0 1.08 1.37 2 3 2s3-.92 3-2c0-1.1-1.04-1.5-3.24-2.03C9.64 12.44 7 11.78 7 9c0-1.79 1.47-3.31 3.5-3.82V3h3v2.18C15.53 5.69 17 7.21 17 9h-2c0-1.08-1.37-2-3-2s-3 .92-3 2c0 1.1 1.04 1.5 3.24 2.03C14.36 11.56 17 12.22 17 15c0 1.79-1.47 3.31-3.5 3.82V21h-3v-2.18C8.47 18.31 7 16.79 7 15" />
                                            </svg>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <small>{{ now()->year }}</small>
                                            <h6 class="mb-0 fs-15">{{ number_format($thisYearCount) }}</h6>
                                        </div>
                                    </div>

                                    <div class="d-flex">
                                        <div
                                            class="bg-success-subtle rounded-2 p-1 me-2 border border-dashed border-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24">
                                                <path fill="#2786f1" d="M12 12V2c5.523 0 10 4.477 10 10z"
                                                    opacity="0.25" />
                                                <path fill="#2786f1" d="m12 12l5 8.66A10.01 10.01 0 0 0 22 12z"
                                                    opacity="0.5" />
                                                <path fill="#2786f1"
                                                    d="M17 20.66L12 12V2c-5.523.002-9.999 4.48-9.997 10.003c.002 5.523 4.48 9.999 10.004 9.997A10 10 0 0 0 17 20.662l.003-.005l-.004.003z" />
                                            </svg>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <small>{{ now()->subYear()->year }}</small>
                                            <h6 class="mb-0 fs-15">{{ number_format($lastYearCount) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Monthly Sales -->

                <div class="row">
                    <div class="col-xl-4">
                        <div class="card overflow-hidden">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title text-black mb-0">Application Stages</h5>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xxl-6">
                                        <div id="productactivity" class="apex-charts"></div>
                                    </div>

                                    <div class="col-xxl-6 align-self-center">
                                        <h3 class="fs-18 fw-semibold text-black mb-3">Breakdown</h3>
                                        <ul class="list-unstyled mb-0">
                                            <li class="list-item mb-2 align-self-center">
                                                <div class="d-flex align-items-center justify-content-between fs-15">
                                                    <div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 16 16" class="me-0">
                                                            <path fill="#2786f1"
                                                                d="M4 8a4 4 0 1 1 8 0a4 4 0 0 1-8 0m4-2.5a2.5 2.5 0 1 0 0 5a2.5 2.5 0 0 0 0-5" />
                                                        </svg>
                                                        <span class="text-black fw-normal">Pending</span>
                                                    </div>
                                                    <p class="mb-0 text-muted">{{ number_format($pendingApplications) }}
                                                    </p>
                                                </div>
                                            </li>

                                            <li class="list-item mb-2 align-self-center">
                                                <div class="d-flex align-items-center justify-content-between fs-15">
                                                    <div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 16 16">
                                                            <path fill="#f59440"
                                                                d="M4 8a4 4 0 1 1 8 0a4 4 0 0 1-8 0m4-2.5a2.5 2.5 0 1 0 0 5a2.5 2.5 0 0 0 0-5" />
                                                        </svg>
                                                        <span class="text-black fw-normal">In Progress</span>
                                                    </div>
                                                    <p class="mb-0 text-muted">
                                                        {{ number_format($inProgressApplications) }}</p>
                                                </div>
                                            </li>

                                            <li class="list-item text-black align-self-center fs-15">
                                                <div class="d-flex align-items-center justify-content-between fs-15">
                                                    <div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 16 16">
                                                            <path fill="#522c8f"
                                                                d="M4 8a4 4 0 1 1 8 0a4 4 0 0 1-8 0m4-2.5a2.5 2.5 0 1 0 0 5a2.5 2.5 0 0 0 0-5" />
                                                        </svg>
                                                        <span class="text-black fw-normal">Approved</span>
                                                    </div>
                                                    <p class="mb-0 text-muted">{{ number_format($approvedApplications) }}
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card overflow-hidden">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title text-black mb-0">Applications by Country</h5>
                                    <div class="ms-auto">
                                        <button class="btn btn-sm bg-light border dropdown-toggle fw-medium text-black"
                                            type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">View All<i
                                                class="mdi mdi-chevron-down ms-1 fs-14"></i></button>
                                        {{-- <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item"
                                                href="{{ route('visa-countries.index') ?? '#' }}">All Countries</a>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <ul class="p-0 m-0">
                                    @forelse($applicationsByCountry as $country)
                                        <li class="d-flex mb-3 align-items-center">
                                            <div class="d-flex w-50 align-items-center me-4">
                                                <div class="avatar flex-shrink-0 me-3 bg-light rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width:40px;height:40px;">
                                                    <span
                                                        class="fw-semibold">{{ strtoupper(substr($country->country_name, 0, 2)) }}</span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 me-1 fs-15 fw-semibold text-black">
                                                        {{ $country->country_name }}</h6>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-grow-1 align-items-center">
                                                <div class="progress progress-md w-100 me-4 mt-2" role="progressbar"
                                                    aria-valuenow="{{ $country->percentage }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                    <div class="progress-bar bg-primary"
                                                        style="width: {{ $country->percentage }}%"></div>
                                                </div>
                                                <span>{{ $country->percentage }}%</span>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="text-muted text-center py-3">No country data yet.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8">
                        <div class="card overflow-hidden">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title text-black mb-0">Applications Report</h5>
                                </div>
                            </div>

                            <div class="card-body mt-0">
                                <div class="table-responsive table-card mt-0">
                                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                        <thead class="text-muted table-light">
                                            <tr>
                                                <th scope="col">Applicant</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Phone No</th>
                                                <th scope="col">Country</th>
                                                <th scope="col">Visa Type</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentApplications as $app)
                                                <tr>
                                                    <td>{{ $app->full_name ?? 'N/A' }}</td>
                                                    <td>{{ $app->email ?? '—' }}</td>
                                                    <td>{{ $app->phone ?? '—' }}</td>
                                                    <td>{{ $app->visaType->country->country_name ?? '—' }}</td>
                                                    <td>{{ $app->visaType->visa_name ?? '—' }}</td>
                                                    <td>
                                                        @php $color = $statusColors[$app->status] ?? 'secondary'; @endphp
                                                        <span
                                                            class="badge bg-{{ $color }}-subtle text-{{ $color }} fw-semibold">
                                                            {{ $statusLabels[$app->status] ?? ucfirst($app->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a aria-label="anchor" class="me-1" data-bs-toggle="tooltip"
                                                            data-bs-original-title="Edit"
                                                            href="{{ route('visa-application.edit', $app->id) ?? '#' }}">
                                                            <i class="mdi mdi-pencil-outline fs-16 text-muted"></i>
                                                        </a>
                                                        <a aria-label="anchor" data-bs-toggle="tooltip"
                                                            data-bs-original-title="Delete"
                                                            href="{{ route('visa-application.delete', $app->id) ?? '#' }}">
                                                            <i class="mdi mdi-delete fs-16 text-muted"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted py-4">No applications
                                                        found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- container-fluid -->
        </div> <!-- content -->
    </div>

    @push('scripts')
        <script>
            // Applications Overview (area/line chart)
            var salesOverviewOptions = {
                chart: {
                    type: 'area',
                    height: 300,
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                    name: 'Applications',
                    data: @json($chartData)
                }],
                xaxis: {
                    categories: @json($chartLabels)
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                colors: ['#2786f1'],
            };
            new ApexCharts(document.querySelector("#sales-overview"), salesOverviewOptions).render();

            // Application Status (donut)
            var dealsStatisticsOptions = {
                chart: {
                    type: 'donut',
                    height: 230
                },
                series: @json($statusChartSeries),
                labels: @json($statusChartLabels),
                legend: {
                    position: 'bottom'
                },
            };
            new ApexCharts(document.querySelector("#deals-statistics"), dealsStatisticsOptions).render();

            // Yearly growth mini chart
            var browserVisitingOptions = {
                chart: {
                    type: 'bar',
                    height: 120,
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                    name: 'Applications',
                    data: [{{ $lastYearCount }}, {{ $thisYearCount }}]
                }],
                xaxis: {
                    categories: ['{{ now()->subYear()->year }}', '{{ now()->year }}']
                },
                plotOptions: {
                    bar: {
                        columnWidth: '40%',
                        borderRadius: 4
                    }
                },
                colors: ['#2786f1'],
            };
            new ApexCharts(document.querySelector("#browservisiting"), browserVisitingOptions).render();

            // Application stages mini donut
            var productActivityOptions = {
                chart: {
                    type: 'donut',
                    height: 150
                },
                series: [{{ $pendingApplications }}, {{ $inProgressApplications }}, {{ $approvedApplications }}],
                labels: ['Pending', 'In Progress', 'Approved'],
                colors: ['#2786f1', '#f59440', '#522c8f'],
                legend: {
                    show: false
                },
            };
            new ApexCharts(document.querySelector("#productactivity"), productActivityOptions).render();
        </script>
    @endpush
@endsection
