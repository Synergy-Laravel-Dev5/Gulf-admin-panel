@extends('layout.master')

@section('title', 'Edit Terms & Conditions')
@section('header-title', 'Terms & Conditions')

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Terms & Conditions</h4>
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
                                <h5 class="mb-0">Manage Terms & Conditions</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('terms.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Page Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control" value="{{ old('title', $page->title) }}" required>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Page Content (Summernote Editor)</label>
                                        <textarea name="content" class="form-control summernote" rows="10">{{ old('content', $page->content) }}</textarea>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="mdi mdi-content-save me-1"></i> Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush
