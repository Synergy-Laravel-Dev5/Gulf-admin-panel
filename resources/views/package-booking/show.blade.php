@extends('layout.master')
@section('title', 'Booking Details')
@section('header-title', 'Booking Details')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Booking Details</h4>
                    </div>
                    <a href="{{ route('package-booking.index') }}" class="btn btn-outline-secondary">
                        <i class="mdi mdi-arrow-left"></i> Back
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Applicant Information</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <th width="220">Full Name</th>
                                        <td>{{ $booking->full_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>CNIC</th>
                                        <td>{{ $booking->cnic }}</td>
                                    </tr>
                                    <tr>
                                        <th>Passport Number</th>
                                        <td>{{ $booking->passport_number ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $booking->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $booking->email ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Room Type</th>
                                        <td class="text-capitalize">{{ $booking->room_type }}</td>
                                    </tr>
                                    <tr>
                                        <th>Next of Kin Name</th>
                                        <td>{{ $booking->next_of_kin_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Next of Kin Contact</th>
                                        <td>{{ $booking->next_of_kin_contact ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Notes</th>
                                        <td>{{ $booking->notes ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Package Info</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Title:</strong> {{ $booking->package->title ?? 'N/A' }}</p>
                                <p class="text-uppercase"><strong>Type:</strong> {{ $booking->package->type ?? $booking->package_type ?? 'N/A' }}</p>
                                <p><strong>Applied By:</strong> {{ $booking->user->name ?? 'Guest' }}</p>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Update Status</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('package-booking.status', $booking->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-select mb-3">
                                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>
                                            Confirmed</option>
                                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary w-100">Update Status</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
