@extends('layout.master')
@section('title', 'Flight Requests')
@section('header-title', 'Flight Requests')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3">
                    <h4 class="fs-18 fw-semibold m-0">Flight Requests</h4>
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
                                <h5 class="mb-0">All Flight Fare Requests</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>S:NO</th>
                                                <th>Client Name</th>
                                                <th>Phone</th>
                                                <th>Trip Type</th>
                                                <th>Route</th>
                                                <th>Dates</th>
                                                <th>Passengers</th>
                                                <th>Documents</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($requests as $req)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><strong>{{ $req->guest_name }}</strong></td>
                                                    <td>{{ $req->phone }}</td>
                                                    <td>
                                                        @if ($req->trip_type == 'return')
                                                            <span class="badge bg-primary text-uppercase">Return Trip</span>
                                                        @elseif ($req->trip_type == 'multi_city')
                                                            <span class="badge bg-purple text-white text-uppercase">Multi City</span>
                                                        @else
                                                            <span class="badge bg-info text-uppercase">One Way</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($req->trip_type == 'multi_city' && !empty($req->multi_city_legs))
                                                            <span class="fw-bold text-dark">{{ count($req->multi_city_legs) }} City Stops</span>
                                                            <br><small class="text-muted">{{ $req->leaving_from }} ➔ {{ $req->going_to }}</small>
                                                        @else
                                                            <strong>{{ $req->leaving_from }}</strong> <i class="mdi mdi-arrow-right text-muted"></i> <strong>{{ $req->going_to }}</strong>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="text-nowrap"><i class="mdi mdi-calendar text-primary me-1"></i>{{ \Carbon\Carbon::parse($req->departure_date)->format('d M Y') }}</span>
                                                        @if ($req->return_date)
                                                            <br><span class="text-nowrap text-muted"><i class="mdi mdi-calendar-sync me-1"></i>{{ \Carbon\Carbon::parse($req->return_date)->format('d M Y') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-soft-dark text-dark border">
                                                            {{ $req->adults }} Adult{{ $req->adults > 1 ? 's' : '' }}
                                                            @if ($req->children > 0)
                                                                , {{ $req->children }} Child
                                                            @endif
                                                            @if ($req->infants > 0)
                                                                , {{ $req->infants }} Infant
                                                            @endif
                                                        </span>
                                                        <br><small class="text-capitalize text-muted">{{ $req->cabin_class }} Class</small>
                                                    </td>
                                                    <td>
                                                        @if ($req->passport_document_url)
                                                            <span class="badge bg-soft-primary text-primary border border-primary me-1 mb-1" title="Passport Uploaded"><i class="mdi mdi-passport me-1"></i> Passport</span>
                                                        @endif
                                                        @if ($req->documents_upload_url)
                                                            <span class="badge bg-soft-info text-info border border-info me-1 mb-1" title="Documents Uploaded"><i class="mdi mdi-file-document me-1"></i> Docs</span>
                                                        @endif
                                                        @if (!$req->passport_document_url && !$req->documents_upload_url)
                                                            <span class="text-muted small">None</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($req->status == 'pending')
                                                            <span class="badge bg-warning">Pending</span>
                                                        @elseif ($req->status == 'processing')
                                                            <span class="badge bg-info">Processing</span>
                                                        @elseif ($req->status == 'approved')
                                                            <span class="badge bg-success">Approved</span>
                                                        @else
                                                            <span class="badge bg-danger">Cancelled</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('flight-request.show', $req->id) }}"
                                                                class="btn btn-sm btn-outline-info">
                                                                <i class="mdi mdi-eye"></i> View
                                                            </a>
                                                            <form action="{{ route('flight-request.delete', $req->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-outline-danger"
                                                                    onclick="return confirm('Are you sure you want to delete this flight request?')">
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
