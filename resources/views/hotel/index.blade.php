@extends('layout.master')
@section('title', 'Hotels Management')
@section('header-title', 'Hotels')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Hotels Management</h4>
                    </div>
                    <div>
                        <a href="{{ route('hotel.create') }}" class="btn btn-primary">
                            <i class="mdi mdi-plus me-1"></i> Add New Hotel
                        </a>
                    </div>
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
                                <h5 class="mb-0">Hotels List</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>S:NO</th>
                                                <th>Hotel Name</th>
                                                <th>City</th>
                                                <th>Star Rating</th>
                                                <th>Distance / Location</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($hotels as $hotel)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><strong>{{ $hotel->name }}</strong></td>
                                                    <td class="text-capitalize"><span class="badge bg-soft-info text-info fs-12">{{ $hotel->city }}</span></td>
                                                    <td>
                                                        <span class="text-warning">
                                                            @for ($i = 0; $i < (int)$hotel->star_rating; $i++)
                                                                ★
                                                            @endfor
                                                        </span>
                                                        <small class="text-muted">({{ $hotel->star_rating }} Star)</small>
                                                    </td>
                                                    <td>{{ $hotel->distance ?? 'N/A' }}</td>
                                                    <td>
                                                        @if ($hotel->status == 'active')
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('hotel.edit', $hotel->id) }}"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="mdi mdi-pencil"></i>
                                                            </a>
                                                            <form action="{{ route('hotel.delete', $hotel->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-outline-danger"
                                                                    onclick="return confirm('Are you sure you want to delete this hotel?')">
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
