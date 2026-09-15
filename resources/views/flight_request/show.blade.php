@extends('layout.master')
@section('title', 'Flight Request Details')
@section('header-title', 'Flight Request Details')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3 d-flex align-items-center justify-content-between">
                    <h4 class="fs-18 fw-semibold m-0">Flight Request #{{ $requestItem->id }}</h4>
                    <a href="{{ route('flight-request.index') }}" class="btn btn-secondary btn-sm">
                        <i class="mdi mdi-arrow-left me-1"></i> Back to Requests
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-light d-flex align-items-center justify-content-between">
                                <h5 class="mb-0"><i class="mdi mdi-airplane me-1"></i> Flight Details</h5>
                                <div>
                                    @if ($requestItem->trip_type == 'return')
                                        <span class="badge bg-primary text-uppercase fs-12">Return Trip</span>
                                    @elseif ($requestItem->trip_type == 'multi_city')
                                        <span class="badge bg-purple text-white text-uppercase fs-12">Multi City</span>
                                    @else
                                        <span class="badge bg-info text-uppercase fs-12">One Way</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle">
                                        <tr>
                                            <th width="30%">Leaving From:</th>
                                            <td><strong class="fs-15 text-primary">{{ $requestItem->leaving_from }}</strong></td>
                                        </tr>
                                        <tr>
                                            <th>Going To:</th>
                                            <td><strong class="fs-15 text-success">{{ $requestItem->going_to }}</strong></td>
                                        </tr>
                                        <tr>
                                            <th>Departure Date:</th>
                                            <td>{{ \Carbon\Carbon::parse($requestItem->departure_date)->format('d F Y (l)') }}</td>
                                        </tr>
                                        @if ($requestItem->return_date)
                                            <tr>
                                                <th>Return Date:</th>
                                                <td>{{ \Carbon\Carbon::parse($requestItem->return_date)->format('d F Y (l)') }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th>Cabin Class:</th>
                                            <td class="text-capitalize"><strong>{{ $requestItem->cabin_class }}</strong> Class</td>
                                        </tr>
                                        <tr>
                                            <th>Passengers Breakdown:</th>
                                            <td>
                                                <span class="badge bg-soft-primary text-primary fs-13 border me-1">Adults: {{ $requestItem->adults }}</span>
                                                <span class="badge bg-soft-info text-info fs-13 border me-1">Children: {{ $requestItem->children }}</span>
                                                <span class="badge bg-soft-warning text-warning fs-13 border">Infants: {{ $requestItem->infants }}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                @if ($requestItem->trip_type == 'multi_city' && !empty($requestItem->multi_city_legs))
                                    <div class="mt-4">
                                        <h5 class="mb-3 text-purple"><i class="mdi mdi-routes me-1"></i> Multi-City Flight Stops</h5>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Leg #</th>
                                                        <th>Leaving From</th>
                                                        <th>Going To</th>
                                                        <th>Departure Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($requestItem->multi_city_legs as $index => $leg)
                                                        <tr>
                                                            <td><strong>Stop {{ $index + 1 }}</strong></td>
                                                            <td>{{ $leg['leaving_from'] ?? 'N/A' }}</td>
                                                            <td>{{ $leg['going_to'] ?? 'N/A' }}</td>
                                                            <td>
                                                                @if (!empty($leg['departure_date']))
                                                                    {{ \Carbon\Carbon::parse($leg['departure_date'])->format('d M Y') }}
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif

                                @if ($requestItem->notes)
                                    <div class="mt-4 p-3 bg-light rounded border">
                                        <h6 class="fw-bold mb-2"><i class="mdi mdi-notebook-edit me-1"></i> Client Notes / Special Requirements:</h6>
                                        <p class="mb-0 text-dark" style="white-space: pre-line;">{{ $requestItem->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="mdi mdi-file-document-multiple me-1"></i> Uploaded Client Documents</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        @if ($requestItem->passport_document_url)
                                            <tr>
                                                <th width="30%">Passport Copy:</th>
                                                <td>
                                                    <a href="{{ $requestItem->passport_document_url }}" target="_blank" class="btn btn-sm btn-primary">
                                                        <i class="mdi mdi-passport me-1"></i> View / Download Passport
                                                    </a>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <th width="30%">Passport Copy:</th>
                                                <td><span class="badge bg-secondary">No Passport Uploaded</span></td>
                                            </tr>
                                        @endif

                                        @if ($requestItem->documents_upload_url)
                                            <tr>
                                                <th>Additional Documents:</th>
                                                <td>
                                                    <a href="{{ $requestItem->documents_upload_url }}" target="_blank" class="btn btn-sm btn-info text-white">
                                                        <i class="mdi mdi-file-document-outline me-1"></i> View / Download Documents
                                                    </a>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <th>Additional Documents:</th>
                                                <td><span class="badge bg-secondary">No Documents Uploaded</span></td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="mdi mdi-account me-1"></i> Client Information</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Guest Name:</strong> {{ $requestItem->guest_name }}</p>
                                <p><strong>Phone:</strong> <a href="tel:{{ $requestItem->phone }}">{{ $requestItem->phone }}</a></p>
                                <p><strong>Email:</strong> {{ $requestItem->email ?? 'N/A' }}</p>
                                <p><strong>App Account:</strong> {{ $requestItem->user->name ?? 'Guest User' }}</p>
                                <p><strong>Requested On:</strong> {{ $requestItem->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="mdi mdi-list-status me-1"></i> Update Status</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('flight-request.update-status', $requestItem->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Request Status</label>
                                        <select name="status" id="status" class="form-select">
                                            <option value="pending" {{ $requestItem->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $requestItem->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="approved" {{ $requestItem->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="cancelled" {{ $requestItem->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="mdi mdi-content-save me-1"></i> Save Status
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
