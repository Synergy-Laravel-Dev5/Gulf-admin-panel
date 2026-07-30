@extends('layout.master')
@section('title', 'Trashed Visa Countries')
@section('header-title', 'Trashed Visa Countries')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Trashed Visa Countries</h4>
                    </div>
                    <div>
                        <a href="{{ route('visa-country.index') }}" class="btn btn-outline-secondary">
                            <i class="mdi mdi-arrow-left"></i> Back to List
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
                                <h5 class="mb-0">Trash</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>S:NO</th>
                                                <th>Country</th>
                                                <th>Code</th>
                                                <th>Deleted At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($countries as $country)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><strong>{{ $country->country_name }}</strong></td>
                                                    <td>{{ $country->country_code }}</td>
                                                    <td>{{ optional($country->deleted_at)->format('d M Y, h:i A') }}</td>
                                                    <td>
                                                        <a href="{{ route('visa-country.restore', $country->id) }}"
                                                            class="btn btn-sm btn-outline-success"
                                                            onclick="return confirm('Restore this country?')">
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
