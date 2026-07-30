@extends('layout.master')
@section('title', 'International Packages')
@section('header-title', 'International Packages')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">International Packages</h4>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('international-package.trash') }}" class="btn btn-outline-secondary">
                            <i class="mdi mdi-delete"></i> Trash
                        </a>
                        <a href="{{ route('international-package.create') }}" class="btn btn-primary">
                            <i class="mdi mdi-plus"></i> Add International Package
                        </a>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">International Packages List</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>S:NO</th>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Departure</th>
                                                <th>Destination</th>
                                                <th>Duration</th>
                                                <th>Visa</th>
                                                <th>Price/Person</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($packages as $package)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        @if ($package->image)
                                                            <img src="{{ asset('storage/' . $package->image) }}"
                                                                width="50" height="50"
                                                                style="object-fit:cover; border-radius:4px;">
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td><strong>{{ $package->title }}</strong></td>
                                                    <td>{{ $package->departure_city ?? 'N/A' }}</td>
                                                    <td>
                                                        {{ $package->destination_city ? $package->destination_city . ', ' : '' }}{{ $package->destination_country }}
                                                    </td>
                                                    <td>{{ $package->duration_days ? $package->duration_days . ' Days' : 'N/A' }}
                                                    </td>
                                                    <td>
                                                        @if ($package->visa_required)
                                                            <span class="badge bg-warning">Required</span>
                                                        @else
                                                            <span class="badge bg-secondary">Not Required</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $package->price_per_person ?? 'N/A' }}</td>
                                                    <td>
                                                        @if ($package->status == 'active')
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-secondary">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('international-package.edit', $package->id) }}"
                                                                class="btn btn-sm btn-outline-success">
                                                                <i class="mdi mdi-pencil"></i>
                                                            </a>
                                                            <form
                                                                action="{{ route('international-package.delete', $package->id) }}"
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
