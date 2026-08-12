@extends('layout.master')
@section('title', 'Visa Application Details')
@section('header-title', 'Visa Application Details')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Visa Application Details</h4>
                    </div>
                    <div>
                        <a href="{{ route('visa-application.index') }}" class="btn btn-outline-secondary">
                            <i class="mdi mdi-arrow-left me-1"></i> Back to List
                        </a>
                        <a href="{{ route('visa-application.edit', $application->id) }}" class="btn btn-primary ms-1">
                            <i class="mdi mdi-pencil me-1"></i> Edit Application
                        </a>
                    </div>
                </div>

                <div class="row">
                    <!-- Applicant Info -->
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header bg-soft-primary text-primary">
                                <h5 class="mb-0 fw-bold"><i class="mdi mdi-account-card-details me-1"></i> Applicant Information</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered align-middle">
                                    <tr>
                                        <th class="w-40 bg-light">Full Name</th>
                                        <td><strong>{{ $application->full_name ?? 'N/A' }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Phone</th>
                                        <td>{{ $application->phone ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Email</th>
                                        <td>{{ $application->email ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">CNIC Number</th>
                                        <td>{{ $application->cnic ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Country</th>
                                        <td>{{ $application->visaType->country->country_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Visa Type</th>
                                        <td>{{ $application->visaType->visa_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">B2B Rate</th>
                                        <td><span class="badge bg-soft-info text-info fs-13">{{ $application->visaType->b2b_rate ?? 'N/A' }}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Visa Fee</th>
                                        <td><span class="badge bg-soft-success text-success fs-13">{{ $application->visaType->visa_fee ?? 'N/A' }}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Status</th>
                                        <td>
                                            @if ($application->status == 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif($application->status == 'processing')
                                                <span class="badge bg-warning text-dark">Processing</span>
                                            @elseif($application->status == 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @else
                                                <span class="badge bg-secondary">Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Remarks</th>
                                        <td>{{ $application->remarks ?? 'No remarks added yet.' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Uploaded Documents -->
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header bg-soft-success text-success">
                                <h5 class="mb-0 fw-bold"><i class="mdi mdi-file-document-multiple me-1"></i> Uploaded Documents</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    
                                    <!-- Passport Scan -->
                                    <div class="col-sm-6">
                                        <div class="border rounded p-3 text-center bg-light h-100">
                                            <div class="fs-24 text-primary mb-1"><i class="mdi mdi-passport"></i></div>
                                            <h6 class="fw-bold mb-1">Passport Scan</h6>
                                            @if ($application->passport_scan_url)
                                                <span class="badge bg-success mb-2">Uploaded</span>
                                                <div>
                                                    <a href="{{ $application->passport_scan_url }}" target="_blank" class="btn btn-xs btn-outline-primary mt-1">
                                                        <i class="mdi mdi-eye me-1"></i> View Document
                                                    </a>
                                                </div>
                                            @else
                                                <span class="badge bg-secondary mb-1">Not Uploaded</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Personal Picture -->
                                    <div class="col-sm-6">
                                        <div class="border rounded p-3 text-center bg-light h-100">
                                            <div class="fs-24 text-success mb-1"><i class="mdi mdi-account-circle-outline"></i></div>
                                            <h6 class="fw-bold mb-1">Applicant Photo</h6>
                                            @if ($application->picture_url)
                                                <span class="badge bg-success mb-2">Uploaded</span>
                                                <div>
                                                    <a href="{{ $application->picture_url }}" target="_blank" class="btn btn-xs btn-outline-success mt-1">
                                                        <i class="mdi mdi-eye me-1"></i> View Photo
                                                    </a>
                                                </div>
                                            @else
                                                <span class="badge bg-secondary mb-1">Not Uploaded</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- CNIC Front -->
                                    <div class="col-sm-6">
                                        <div class="border rounded p-3 text-center bg-light h-100">
                                            <div class="fs-24 text-info mb-1"><i class="mdi mdi-card-account-details-outline"></i></div>
                                            <h6 class="fw-bold mb-1">CNIC Front</h6>
                                            @if ($application->cnic_front_url)
                                                <span class="badge bg-success mb-2">Uploaded</span>
                                                <div>
                                                    <a href="{{ $application->cnic_front_url }}" target="_blank" class="btn btn-xs btn-outline-info mt-1">
                                                        <i class="mdi mdi-eye me-1"></i> View CNIC Front
                                                    </a>
                                                </div>
                                            @else
                                                <span class="badge bg-secondary mb-1">Not Uploaded</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- CNIC Back -->
                                    <div class="col-sm-6">
                                        <div class="border rounded p-3 text-center bg-light h-100">
                                            <div class="fs-24 text-info mb-1"><i class="mdi mdi-card-account-details-outline"></i></div>
                                            <h6 class="fw-bold mb-1">CNIC Back</h6>
                                            @if ($application->cnic_back_url)
                                                <span class="badge bg-success mb-2">Uploaded</span>
                                                <div>
                                                    <a href="{{ $application->cnic_back_url }}" target="_blank" class="btn btn-xs btn-outline-info mt-1">
                                                        <i class="mdi mdi-eye me-1"></i> View CNIC Back
                                                    </a>
                                                </div>
                                            @else
                                                <span class="badge bg-secondary mb-1">Not Uploaded</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Bank Statement -->
                                    <div class="col-sm-6">
                                        <div class="border rounded p-3 text-center bg-light h-100">
                                            <div class="fs-24 text-warning mb-1"><i class="mdi mdi-bank-transfer"></i></div>
                                            <h6 class="fw-bold mb-1">Bank Statement</h6>
                                            @if ($application->bank_statement_url)
                                                <span class="badge bg-success mb-2">Uploaded</span>
                                                <div>
                                                    <a href="{{ $application->bank_statement_url }}" target="_blank" class="btn btn-xs btn-outline-warning mt-1">
                                                        <i class="mdi mdi-eye me-1"></i> View Document
                                                    </a>
                                                </div>
                                            @else
                                                <span class="badge bg-secondary mb-1">Not Uploaded</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Other Document -->
                                    <div class="col-sm-6">
                                        <div class="border rounded p-3 text-center bg-light h-100">
                                            <div class="fs-24 text-secondary mb-1"><i class="mdi mdi-file-document-outline"></i></div>
                                            <h6 class="fw-bold mb-1">Other Document</h6>
                                            @if ($application->other_document_url)
                                                <span class="badge bg-success mb-2">Uploaded</span>
                                                <div>
                                                    <a href="{{ $application->other_document_url }}" target="_blank" class="btn btn-xs btn-outline-secondary mt-1">
                                                        <i class="mdi mdi-eye me-1"></i> View Document
                                                    </a>
                                                </div>
                                            @else
                                                <span class="badge bg-secondary mb-1">Not Uploaded</span>
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
