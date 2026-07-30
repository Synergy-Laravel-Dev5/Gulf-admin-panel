@extends('layout.master')
@section('title', 'Trashed Packages')
@section('header-title', 'Trashed Packages')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Trashed Packages</h4>
                    </div>
                    <a href="{{ route('package.index') }}" class="btn btn-outline-secondary">
                        <i class="mdi mdi-arrow-left"></i> Back
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Deleted Packages List</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>S:NO</th>
                                                <th>Title</th>
                                                <th>Type</th>
                                                <th>Deleted At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($packages as $package)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $package->title }}</td>
                                                    <td class="text-uppercase">{{ $package->type }}</td>
                                                    <td>{{ $package->deleted_at }}</td>
                                                    <td>
                                                        <a href="{{ route('package.restore', $package->id) }}"
                                                            class="btn btn-sm btn-outline-success"
                                                            onclick="return confirm('Restore this package?')">
                                                            <i class="mdi mdi-restore"></i> Restore
                                                        </a>
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
