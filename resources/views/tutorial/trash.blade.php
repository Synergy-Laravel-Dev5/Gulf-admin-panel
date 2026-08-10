@extends('layout.master')
@section('title', 'Tutorials Trash')
@section('header-title', 'Tutorials Trash')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Tutorials Trash</h4>
                    </div>
                    <div>
                        <a href="{{ route('tutorial.index') }}" class="btn btn-outline-secondary">
                            <i class="mdi mdi-arrow-left"></i> Back to Tutorials
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
                                <h5 class="mb-0">Deleted Tutorials</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Deleted At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tutorials as $tutorial)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><strong>{{ $tutorial->title }}</strong></td>
                                                    <td><span class="badge bg-info text-dark">{{ ucfirst($tutorial->category ?? 'General') }}</span></td>
                                                    <td>{{ $tutorial->deleted_at->format('d M Y, h:i A') }}</td>
                                                    <td>
                                                        <a href="{{ route('tutorial.restore', $tutorial->id) }}"
                                                            class="btn btn-sm btn-outline-success">
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
