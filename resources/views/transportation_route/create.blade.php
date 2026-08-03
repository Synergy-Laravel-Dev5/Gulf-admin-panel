@extends('layout.master')
@section('title', 'Add Transportation Route')
@section('header-title', 'Add Transportation Route')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3">
                    <h4 class="fs-18 fw-semibold m-0">Add Transportation Route</h4>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('transportation-route.store') }}" method="POST">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Route Display Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="e.g. Jeddah Airport -> Makkah Hotel -> Jeddah Airport"
                                                value="{{ old('name') }}" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Route Code / Key <span class="text-danger">*</span></label>
                                            <input type="text" name="code" class="form-control"
                                                placeholder="e.g. jeddah_makkah_jeddah (all lowercase, no spaces)"
                                                value="{{ old('code') }}" required>
                                            <small class="text-muted">Use standard code tags if defining specific route toggles in Javascript (e.g. <code>custom</code>, <code>jeddah_makkah_madinah_jeddah</code>, etc.)</small>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-select" required>
                                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3">Save Route</button>
                                    <a href="{{ route('transportation-route.index') }}" class="btn btn-outline-secondary mt-3">Cancel</a>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
