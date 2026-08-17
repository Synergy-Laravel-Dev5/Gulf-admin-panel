@extends('layout.master')
@section('title', 'Hotel Bookings')
@section('header-title', 'Hotel Bookings')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3">
                    <h4 class="fs-18 fw-semibold m-0">Hotel Bookings</h4>
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
                            <div class="card-header">
                                <h5 class="mb-0">All Hotel Bookings</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>S:NO</th>
                                                <th>Guest Name</th>
                                                <th>Hotel Name</th>
                                                <th>Room Type</th>
                                                <th>Check In</th>
                                                <th>Check Out</th>
                                                <th>Rooms</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bookings as $booking)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><strong>{{ $booking->guest_name }}</strong></td>
                                                    <td>
                                                        {{ $booking->hotel_name }}
                                                        @if (empty($booking->hotel_id))
                                                            <span class="badge bg-soft-info text-info border border-info ms-1">Custom Request</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-capitalize">{{ $booking->room_type }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</td>
                                                    <td>{{ $booking->no_of_rooms }}</td>
                                                    <td>
                                                        @if ($booking->status == 'pending')
                                                            <span class="badge bg-warning">Pending</span>
                                                        @elseif ($booking->status == 'approved')
                                                            <span class="badge bg-success">Approved</span>
                                                        @else
                                                            <span class="badge bg-danger">Cancelled</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('hotel-booking.show', $booking->id) }}"
                                                                class="btn btn-sm btn-outline-info">
                                                                <i class="mdi mdi-eye"></i> View
                                                            </a>
                                                            <form action="{{ route('hotel-booking.delete', $booking->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-outline-danger"
                                                                    onclick="return confirm('Are you sure you want to delete this booking?')">
                                                                    <i class="mdi mdi-delete"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
