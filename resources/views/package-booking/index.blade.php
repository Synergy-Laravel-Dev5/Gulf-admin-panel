@extends('layout.master')
@section('title', 'Package Bookings')
@section('header-title', 'Package Bookings')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Package Bookings</h4>
                    </div>
                </div>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Bookings List</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>S:NO</th>
                                                <th>Applicant Name</th>
                                                <th>Phone</th>
                                                <th>Package</th>
                                                <th>Type</th>
                                                <th>Room Type</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bookings as $booking)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><strong>{{ $booking->full_name }}</strong></td>
                                                    <td>{{ $booking->phone }}</td>
                                                    <td>{{ $booking->package->title ?? 'N/A' }}</td>
                                                    <td class="text-uppercase">{{ $booking->package->type ?? 'N/A' }}</td>
                                                    <td class="text-capitalize">{{ $booking->room_type }}</td>
                                                    <td>
                                                        @if ($booking->status == 'confirmed')
                                                            <span class="badge bg-success">Confirmed</span>
                                                        @elseif($booking->status == 'cancelled')
                                                            <span class="badge bg-danger">Cancelled</span>
                                                        @else
                                                            <span class="badge bg-warning">Pending</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('package-booking.show', $booking->id) }}"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="mdi mdi-eye"></i>
                                                            </a>
                                                            <form
                                                                action="{{ route('package-booking.delete', $booking->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-outline-danger"
                                                                    onclick="return confirm('Are you sure?')">
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
