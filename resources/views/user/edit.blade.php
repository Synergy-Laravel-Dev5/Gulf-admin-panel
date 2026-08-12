@extends('layout.master')

@section('title', 'Edit User')
@section('header-title', 'Edit User')

@section('content')

    <div class="content-page">
        <div class="content">
            <div class="container">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">User Management</h4>
                    </div>
                    <div>
                        <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">
                            <i class="mdi mdi-arrow-left"></i> Back to Users
                        </a>
                    </div>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <!-- HEADER -->
                            <div class="card-header">
                                <h5 class="mb-0">Edit User Profile & Documents</h5>
                            </div>

                            <div class="card-body">

                                <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">

                                        <!-- NAME -->
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                                class="form-control" placeholder="Enter user name" required>
                                        </div>

                                        <!-- EMAIL -->
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                                class="form-control" placeholder="Enter email" required>
                                        </div>

                                        <!-- PHONE -->
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Phone Number</label>
                                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                                class="form-control" placeholder="Enter phone number">
                                        </div>

                                        <!-- STATUS -->
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-control">
                                                <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>
                                                    Active
                                                </option>
                                                <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>
                                                    Inactive
                                                </option>
                                            </select>
                                        </div>

                                        <!-- ROLES -->
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Assign Roles</label>
                                            <select name="roles[]" id="roles" class="form-control select2" multiple>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}"
                                                        {{ $user->roles->contains('name', $role->name) ? 'selected' : '' }}>
                                                        {{ ucfirst($role->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- PASSWORD -->
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Password (Leave blank to keep unchanged)</label>
                                            <input type="password" name="password" class="form-control" placeholder="Enter new password">
                                        </div>

                                    </div>

                                    <hr class="my-4">
                                    <h5 class="mb-3 text-primary"><i class="mdi mdi-folder-multiple-image me-1"></i> User Documents & Profile Picture</h5>

                                    <div class="row">
                                        <!-- PROFILE PICTURE -->
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label fw-bold">Profile Picture</label>
                                            <input type="file" name="profile_picture" class="form-control" accept="image/*">
                                            @if ($user->profile_picture_url)
                                                <div class="mt-2 d-flex align-items-center gap-2">
                                                    <img src="{{ $user->profile_picture_url }}" alt="Profile Picture" style="width:70px; height:70px; object-fit:cover;" class="rounded border">
                                                    <a href="{{ $user->profile_picture_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="mdi mdi-open-in-new"></i> View Full Image
                                                    </a>
                                                </div>
                                            @else
                                                <small class="text-muted">No profile picture uploaded yet.</small>
                                            @endif
                                        </div>

                                        <!-- PASSPORT -->
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label fw-bold">Passport Document</label>
                                            <input type="file" name="passport" class="form-control" accept="image/*,.pdf">
                                            @if ($user->passport_url)
                                                <div class="mt-2">
                                                    <a href="{{ $user->passport_url }}" target="_blank" class="btn btn-sm btn-success">
                                                        <i class="mdi mdi-file-document-outline"></i> View Uploaded Passport
                                                    </a>
                                                </div>
                                            @else
                                                <small class="text-muted">No passport uploaded yet.</small>
                                            @endif
                                        </div>

                                        <!-- CNIC FRONT -->
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label fw-bold">CNIC Front Document</label>
                                            <input type="file" name="cnic_front" class="form-control" accept="image/*,.pdf">
                                            @if ($user->cnic_front_url)
                                                <div class="mt-2">
                                                    <a href="{{ $user->cnic_front_url }}" target="_blank" class="btn btn-sm btn-info text-dark">
                                                        <i class="mdi mdi-card-account-details-outline"></i> View Uploaded CNIC Front
                                                    </a>
                                                </div>
                                            @else
                                                <small class="text-muted">No CNIC Front uploaded yet.</small>
                                            @endif
                                        </div>

                                        <!-- CNIC BACK -->
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label fw-bold">CNIC Back Document</label>
                                            <input type="file" name="cnic_back" class="form-control" accept="image/*,.pdf">
                                            @if ($user->cnic_back_url)
                                                <div class="mt-2">
                                                    <a href="{{ $user->cnic_back_url }}" target="_blank" class="btn btn-sm btn-info text-dark">
                                                        <i class="mdi mdi-card-account-details-outline"></i> View Uploaded CNIC Back
                                                    </a>
                                                </div>
                                            @else
                                                <small class="text-muted">No CNIC Back uploaded yet.</small>
                                            @endif
                                        </div>

                                        <!-- VISA -->
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label fw-bold">Visa Document</label>
                                            <input type="file" name="visa" class="form-control" accept="image/*,.pdf">
                                            @if ($user->visa_url)
                                                <div class="mt-2">
                                                    <a href="{{ $user->visa_url }}" target="_blank" class="btn btn-sm btn-warning text-dark">
                                                        <i class="mdi mdi-certificate-outline"></i> View Uploaded Visa
                                                    </a>
                                                </div>
                                            @else
                                                <small class="text-muted">No Visa document uploaded yet.</small>
                                            @endif
                                        </div>

                                        <!-- TICKET -->
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label fw-bold">Ticket Document</label>
                                            <input type="file" name="ticket" class="form-control" accept="image/*,.pdf">
                                            @if ($user->ticket_url)
                                                <div class="mt-2">
                                                    <a href="{{ $user->ticket_url }}" target="_blank" class="btn btn-sm text-white" style="background-color:#6f42c1;">
                                                        <i class="mdi mdi-ticket-outline"></i> View Uploaded Ticket
                                                    </a>
                                                </div>
                                            @else
                                                <small class="text-muted">No Ticket document uploaded yet.</small>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- BUTTON -->
                                    <div class="row">
                                        <div class="col-12 text-end mt-3">
                                            <button type="submit" class="btn btn-primary px-4">
                                                Update User Profile & Documents
                                            </button>
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

    <script>
        $(document).ready(function() {
            if ($('#roles').length) {
                $('#roles').select2({
                    placeholder: "Select Role(s)"
                });
            }
        });
    </script>

@endsection
