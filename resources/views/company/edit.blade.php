@extends('layout.master')

@section('title', 'Edit Company')
@section('header-title', 'Edit Company')

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Edit Company Profile</h4>
                    </div>
                    <div>
                        <a href="{{ route('company.index') }}" class="btn btn-outline-secondary">
                            <i class="mdi mdi-arrow-left"></i> Back to Companies
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
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Edit Company Details</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('company.update', $company->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <!-- Company Name -->
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                            <input type="text" name="company_name" value="{{ old('company_name', $company->company_name) }}" class="form-control" required placeholder="Enter company name">
                                        </div>

                                        <!-- Contact Person Name -->
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Contact Person <span class="text-danger">*</span></label>
                                            <input type="text" name="name" value="{{ old('name', $company->name) }}" class="form-control" required placeholder="Enter contact person name">
                                        </div>

                                        <!-- Email -->
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" value="{{ old('email', $company->email) }}" class="form-control" required placeholder="Enter email">
                                        </div>

                                        <!-- Phone -->
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Phone Number</label>
                                            <input type="text" name="phone" value="{{ old('phone', $company->phone) }}" class="form-control" placeholder="Enter phone number">
                                        </div>

                                        <!-- Status -->
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-control">
                                                <option value="active" {{ old('status', $company->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status', $company->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>

                                        <!-- Password -->
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Password (Leave blank to keep unchanged)</label>
                                            <input type="password" name="password" class="form-control" placeholder="Enter new password">
                                        </div>

                                        <!-- Logo -->
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label fw-bold">Company Logo</label>
                                            <input type="file" name="logo" class="form-control" accept="image/*">
                                            @if ($company->logo_url)
                                                <div class="mt-2 d-flex align-items-center gap-2">
                                                    <img src="{{ $company->logo_url }}" alt="Logo" style="width:80px; height:80px; object-fit:contain;" class="rounded border">
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 text-end mt-3">
                                            <button type="submit" class="btn btn-primary px-4">Update Company Profile</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
