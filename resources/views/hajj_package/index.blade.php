@extends('layout.master')
@section('title', 'Hajj Packages')
@section('header-title', 'Hajj Packages')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Hajj Packages</h4>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('hajj-package.trash') }}" class="btn btn-outline-secondary">
                            <i class="mdi mdi-delete"></i> Trash
                        </a>
                        <a href="{{ route('hajj-package.create') }}" class="btn btn-primary">
                            <i class="mdi mdi-plus"></i> Add Hajj Package
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
                                <h5 class="mb-0">Hajj Packages List</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>S:NO</th>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Makkah Hotel</th>
                                                <th>Madinah Hotel</th>
                                                <th>Sharing</th>
                                                <th>Triple</th>
                                                <th>Double</th>
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
                                                    <td>{{ $package->makkah_hotel_name ?? 'N/A' }}</td>
                                                    <td>{{ $package->madinah_hotel_name ?? 'N/A' }}</td>
                                                    <td>{{ $package->price_sharing ?? 'N/A' }}</td>
                                                    <td>{{ $package->price_triple ?? 'N/A' }}</td>
                                                    <td>{{ $package->price_double ?? 'N/A' }}</td>
                                                    <td>
                                                        @if ($package->status == 'active')
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-secondary">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('hajj-package.edit', $package->id) }}"
                                                                class="btn btn-sm btn-outline-success">
                                                                <i class="mdi mdi-pencil"></i>
                                                            </a>
                                                            <form action="{{ route('hajj-package.delete', $package->id) }}"
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
