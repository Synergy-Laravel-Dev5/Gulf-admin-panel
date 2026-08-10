@extends('layout.master')
@section('title', 'Tutorials')
@section('header-title', 'Tutorials')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Tutorials</h4>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('tutorial.trash') }}" class="btn btn-outline-secondary">
                            <i class="mdi mdi-delete-clock"></i> Trash ({{ $trashedCount ?? 0 }})
                        </a>
                        <a href="{{ route('tutorial.create') }}" class="btn btn-primary">
                            <i class="mdi mdi-plus"></i> Add Tutorial
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
                                <h5 class="mb-0">Tutorials List</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Thumbnail</th>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Video Source</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tutorials as $tutorial)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        @if ($tutorial->thumbnail_url)
                                                            <img src="{{ $tutorial->thumbnail_url }}" alt="thumbnail"
                                                                style="width:60px; height:40px; object-fit:cover;"
                                                                class="rounded border">
                                                        @else
                                                            <span class="badge bg-light text-dark">No Image</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <strong>{{ $tutorial->title }}</strong>
                                                        @if ($tutorial->description)
                                                            <br><small class="text-muted">{{ Str::limit($tutorial->description, 50) }}</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info text-dark">
                                                            {{ ucfirst($tutorial->category ?? 'General') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if ($tutorial->video_url)
                                                            <a href="{{ $tutorial->video_url }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                                <i class="mdi mdi-link"></i> External Link
                                                            </a>
                                                        @elseif ($tutorial->video_file_url)
                                                            <a href="{{ $tutorial->video_file_url }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                                <i class="mdi mdi-play"></i> Watch Video
                                                            </a>
                                                        @else
                                                            <span class="text-muted">None</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($tutorial->status == 'active')
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-secondary">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('tutorial.edit', $tutorial->id) }}"
                                                                class="btn btn-sm btn-outline-primary" title="Edit">
                                                                <i class="mdi mdi-pencil"></i>
                                                            </a>
                                                            <form action="{{ route('tutorial.delete', $tutorial->id) }}"
                                                                method="POST" onsubmit="return confirm('Are you sure you want to delete this tutorial?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-outline-danger" title="Delete">
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
