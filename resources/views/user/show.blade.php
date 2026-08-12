@extends('layout.master')

@section('title', 'User Details & Documents')
@section('header-title', 'User Details')

@section('content')

    <div class="content-page">
        <div class="content">
            <div class="container">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">User Profile & Uploaded Documents</h4>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">
                            <i class="mdi mdi-arrow-left"></i> Back to Users
                        </a>
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary">
                            <i class="mdi mdi-pencil"></i> Edit User
                        </a>
                    </div>
                </div>

                <div class="row">
                    <!-- USER INFO CARD -->
                    <div class="col-lg-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="mb-3">
                                    @if ($user->profile_picture_url)
                                        <img src="{{ $user->profile_picture_url }}" alt="Profile Picture"
                                            class="rounded-circle img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                                    @else
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto fw-bold fs-20"
                                            style="width: 120px; height: 120px;">
                                            {{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}
                                        </div>
                                    @endif
                                </div>

                                <h4 class="mb-1">{{ $user->name }}</h4>
                                <p class="text-muted mb-2">{{ $user->email }}</p>

                                <div class="mb-3">
                                    @if ($user->status == 'active')
                                        <span class="badge bg-success px-3 py-1">Active User</span>
                                    @else
                                        <span class="badge bg-danger px-3 py-1">Inactive</span>
                                    @endif
                                </div>

                                <ul class="list-group list-group-flush text-start">
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span class="text-muted"><i class="mdi mdi-phone me-1"></i> Phone:</span>
                                        <strong>{{ $user->phone ?? 'Not provided' }}</strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span class="text-muted"><i class="mdi mdi-calendar me-1"></i> Registered:</span>
                                        <strong>{{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- UPLOADED DOCUMENTS READ-ONLY VIEWER -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="mb-0 text-primary">
                                    <i class="mdi mdi-folder-account me-1"></i> Mobile App Uploaded Documents
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">

                                    <!-- PASSPORT -->
                                    <div class="col-md-6">
                                        <div class="border rounded p-3 text-center h-100 bg-light bg-opacity-50">
                                            <div class="fs-24 text-success mb-2">
                                                <i class="mdi mdi-file-document-outline"></i>
                                            </div>
                                            <h6 class="fw-bold mb-1">Passport Document</h6>
                                            @if ($user->passport_url)
                                                <span class="badge bg-success mb-3">Uploaded</span>
                                                <div>
                                                    <a href="{{ $user->passport_url }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                        <i class="mdi mdi-eye me-1"></i> View / Download Passport
                                                    </a>
                                                </div>
                                            @else
                                                <span class="badge bg-secondary mb-2">Not Uploaded</span>
                                                <p class="text-muted fs-12 mb-0">User hasn't uploaded passport from mobile app yet.</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- CNIC FRONT -->
                                    <div class="col-md-6">
                                        <div class="border rounded p-3 text-center h-100 bg-light bg-opacity-50">
                                            <div class="fs-24 text-info mb-2">
                                                <i class="mdi mdi-card-account-details-outline"></i>
                                            </div>
                                            <h6 class="fw-bold mb-1">CNIC Front Document</h6>
                                            @if ($user->cnic_front_url)
                                                <span class="badge bg-info text-dark mb-3">Uploaded</span>
                                                <div>
                                                    <a href="{{ $user->cnic_front_url }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                        <i class="mdi mdi-eye me-1"></i> View / Download CNIC Front
                                                    </a>
                                                </div>
                                            @else
                                                <span class="badge bg-secondary mb-2">Not Uploaded</span>
                                                <p class="text-muted fs-12 mb-0">CNIC front not uploaded yet.</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- CNIC BACK -->
                                    <div class="col-md-6">
                                        <div class="border rounded p-3 text-center h-100 bg-light bg-opacity-50">
                                            <div class="fs-24 text-info mb-2">
                                                <i class="mdi mdi-card-account-details-outline"></i>
                                            </div>
                                            <h6 class="fw-bold mb-1">CNIC Back Document</h6>
                                            @if ($user->cnic_back_url)
                                                <span class="badge bg-info text-dark mb-3">Uploaded</span>
                                                <div>
                                                    <a href="{{ $user->cnic_back_url }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                        <i class="mdi mdi-eye me-1"></i> View / Download CNIC Back
                                                    </a>
                                                </div>
                                            @else
                                                <span class="badge bg-secondary mb-2">Not Uploaded</span>
                                                <p class="text-muted fs-12 mb-0">CNIC back not uploaded yet.</p>
                                            @endif
                                        </div>
                                    </div>


                                    <!-- VISA -->
                                    <div class="col-md-6">
                                        <div class="border rounded p-3 text-center h-100 bg-light bg-opacity-50">
                                            <div class="fs-24 text-warning mb-2">
                                                <i class="mdi mdi-certificate-outline"></i>
                                            </div>
                                            <h6 class="fw-bold mb-1">Visa Document</h6>
                                            @if ($user->visa_url)
                                                <span class="badge bg-warning text-dark mb-3">Uploaded</span>
                                                <div>
                                                    <a href="{{ $user->visa_url }}" target="_blank" class="btn btn-sm btn-outline-warning text-dark">
                                                        <i class="mdi mdi-eye me-1"></i> View / Download Visa
                                                    </a>
                                                </div>
                                            @else
                                                <span class="badge bg-secondary mb-2">Not Uploaded</span>
                                                <p class="text-muted fs-12 mb-0">User hasn't uploaded Visa document from mobile app yet.</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- TICKET -->
                                    <div class="col-md-6">
                                        <div class="border rounded p-3 text-center h-100 bg-light bg-opacity-50">
                                            <div class="fs-24 text-purple mb-2" style="color: #6f42c1;">
                                                <i class="mdi mdi-ticket-outline"></i>
                                            </div>
                                            <h6 class="fw-bold mb-1">Ticket Document</h6>
                                            @if ($user->ticket_url)
                                                <span class="badge bg-purple text-white mb-3" style="background-color: #6f42c1;">Uploaded</span>
                                                <div>
                                                    <a href="{{ $user->ticket_url }}" target="_blank" class="btn btn-sm btn-outline-purple" style="color: #6f42c1; border-color: #6f42c1;">
                                                        <i class="mdi mdi-eye me-1"></i> View / Download Ticket
                                                    </a>
                                                </div>
                                            @else
                                                <span class="badge bg-secondary mb-2">Not Uploaded</span>
                                                <p class="text-muted fs-12 mb-0">User hasn't uploaded Ticket document from mobile app yet.</p>
                                            @endif
                                        </div>
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
