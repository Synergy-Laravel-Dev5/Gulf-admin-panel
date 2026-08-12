@extends('layout.master')
@section('title', 'Edit Visa Application')
@section('header-title', 'Edit Visa Application')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Edit Visa Application</h4>
                    </div>
                    <div>
                        <a href="{{ route('visa-application.index') }}" class="btn btn-outline-secondary">
                            <i class="mdi mdi-arrow-left me-1"></i> Back to List
                        </a>
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

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Application Information</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('visa-application.update', $application->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <!-- Visa Type -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Visa Type <span class="text-danger">*</span></label>
                                            <select name="visa_type_id" class="form-select" required>
                                                <option value="">Select Visa Type</option>
                                                @foreach ($visaTypes as $type)
                                                    <option value="{{ $type->id }}" {{ old('visa_type_id', $application->visa_type_id) == $type->id ? 'selected' : '' }}>
                                                        {{ $type->country->country_name ?? 'N/A' }} - {{ $type->visa_name }} (Fee: {{ $type->visa_fee }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Full Name -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $application->full_name) }}" required>
                                        </div>

                                        <!-- Phone -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $application->phone) }}" required>
                                        </div>

                                        <!-- Email -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" value="{{ old('email', $application->email) }}">
                                        </div>

                                        <!-- CNIC -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">CNIC Number</label>
                                            <input type="text" name="cnic" class="form-control" value="{{ old('cnic', $application->cnic) }}">
                                        </div>

                                        <!-- Status -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-select" required>
                                                <option value="pending" {{ old('status', $application->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="processing" {{ old('status', $application->status) == 'processing' ? 'selected' : '' }}>Processing</option>
                                                <option value="approved" {{ old('status', $application->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="rejected" {{ old('status', $application->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                        </div>

                                        <!-- Remarks -->
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Remarks / Updates</label>
                                            <textarea name="remarks" class="form-control" rows="4" placeholder="Enter remarks or updates regarding visa process...">{{ old('remarks', $application->remarks) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="text-end mt-2">
                                        <button type="submit" class="btn btn-primary px-4">Update Application</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Documents sidebar in Edit -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-soft-info text-info">
                                <h5 class="mb-0 fw-bold"><i class="mdi mdi-attachment me-1"></i> Current Documents</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    
                                    <!-- Passport -->
                                    <div class="list-group-item px-0">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Passport Scan</h6>
                                            </div>
                                            @if($application->passport_scan_url)
                                                <a href="{{ $application->passport_scan_url }}" target="_blank" class="btn btn-xs btn-outline-primary">
                                                    <i class="mdi mdi-eye"></i> View
                                                </a>
                                            @else
                                                <span class="text-muted fs-12">Not Uploaded</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Photo -->
                                    <div class="list-group-item px-0">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Applicant Photo</h6>
                                            </div>
                                            @if($application->picture_url)
                                                <a href="{{ $application->picture_url }}" target="_blank" class="btn btn-xs btn-outline-success">
                                                    <i class="mdi mdi-eye"></i> View
                                                </a>
                                            @else
                                                <span class="text-muted fs-12">Not Uploaded</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- CNIC Front -->
                                    <div class="list-group-item px-0">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h6 class="mb-0 fw-semibold">CNIC Front</h6>
                                            </div>
                                            @if($application->cnic_front_url)
                                                <a href="{{ $application->cnic_front_url }}" target="_blank" class="btn btn-xs btn-outline-info">
                                                    <i class="mdi mdi-eye"></i> View
                                                </a>
                                            @else
                                                <span class="text-muted fs-12">Not Uploaded</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- CNIC Back -->
                                    <div class="list-group-item px-0">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h6 class="mb-0 fw-semibold">CNIC Back</h6>
                                            </div>
                                            @if($application->cnic_back_url)
                                                <a href="{{ $application->cnic_back_url }}" target="_blank" class="btn btn-xs btn-outline-info">
                                                    <i class="mdi mdi-eye"></i> View
                                                </a>
                                            @else
                                                <span class="text-muted fs-12">Not Uploaded</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Bank Statement -->
                                    <div class="list-group-item px-0">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Bank Statement</h6>
                                            </div>
                                            @if($application->bank_statement_url)
                                                <a href="{{ $application->bank_statement_url }}" target="_blank" class="btn btn-xs btn-outline-warning">
                                                    <i class="mdi mdi-eye"></i> View
                                                </a>
                                            @else
                                                <span class="text-muted fs-12">Not Uploaded</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Other Document -->
                                    <div class="list-group-item px-0">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Other Document</h6>
                                            </div>
                                            @if($application->other_document_url)
                                                <a href="{{ $application->other_document_url }}" target="_blank" class="btn btn-xs btn-outline-secondary">
                                                    <i class="mdi mdi-eye"></i> View
                                                </a>
                                            @else
                                                <span class="text-muted fs-12">Not Uploaded</span>
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
