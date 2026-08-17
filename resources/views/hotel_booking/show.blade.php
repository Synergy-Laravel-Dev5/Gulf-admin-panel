@extends('layout.master')
@section('title', 'Hotel Booking Details')
@section('header-title', 'Hotel Booking Details')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Hotel Booking #{{ $booking->id }}</h4>
                    </div>
                    <div>
                        <a href="{{ route('hotel-booking.index') }}" class="btn btn-outline-secondary">
                            <i class="mdi mdi-arrow-left"></i> Back to list
                        </a>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Booking Information</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <tr>
                                        <th style="width: 30%;">Guest Name:</th>
                                        <td>{{ $booking->guest_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Contact No:</th>
                                        <td>{{ $booking->contact_no ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $booking->email ?? 'N/A' }}</td>
                                    </tr>
                                     <tr>
                                         <th>Hotel Name:</th>
                                         <td>
                                             {{ $booking->hotel_name }}
                                             @if (empty($booking->hotel_id))
                                                 <span class="badge bg-soft-info text-info border border-info ms-2">Custom Unlisted Hotel Request</span>
                                             @endif
                                         </td>
                                     </tr>
                                    <tr>
                                        <th>Room Type:</th>
                                        <td class="text-capitalize">{{ $booking->room_type }}</td>
                                    </tr>
                                    <tr>
                                        <th>Meal Option:</th>
                                        <td>{{ $booking->meal }}</td>
                                    </tr>
                                    <tr>
                                        <th>Check In Date:</th>
                                        <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Check Out Date:</th>
                                        <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Number of Rooms:</th>
                                        <td>{{ $booking->no_of_rooms }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            @if ($booking->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif ($booking->status == 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @else
                                                <span class="badge bg-danger">Cancelled</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Uploaded Document:</th>
                                        <td>
                                            @if ($booking->documents_upload_url)
                                                <a href="{{ $booking->documents_upload_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="mdi mdi-download"></i> View / Download Document
                                                </a>
                                            @else
                                                <span class="badge bg-secondary">No Document Uploaded</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Payment Proof:</th>
                                        <td>
                                            @if ($booking->payment_proof_url)
                                                <a href="{{ $booking->payment_proof_url }}" target="_blank" class="btn btn-sm btn-success">
                                                    <i class="mdi mdi-eye me-1"></i> View / Download Payment Proof
                                                </a>
                                            @else
                                                <span class="badge bg-secondary">No Payment Proof Uploaded</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Actions</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('hotel-booking.update-status', $booking->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label">Update Booking Status</label>
                                        <select name="status" class="form-select" required>
                                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ $booking->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 mb-2">Update Status</button>
                                </form>

                                <form action="{{ route('hotel-booking.delete', $booking->id) }}" method="POST" onsubmit="return confirm('Delete this booking?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100">Delete Booking</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
