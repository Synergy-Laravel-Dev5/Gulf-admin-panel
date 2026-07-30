@extends('layout.master')
@section('title', 'Visa Countries')
@section('header-title', 'Visa Countries')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Visa Countries</h4>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('visa-country.trash') }}" class="btn btn-outline-secondary">
                            <i class="mdi mdi-delete-clock"></i> Trash
                        </a>
                        <a href="{{ route('visa-country.create') }}" class="btn btn-primary">
                            <i class="mdi mdi-plus"></i> Add Country
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
                                <h5 class="mb-0">Countries List</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>S:NO</th>
                                                <th>Country</th>
                                                <th>Code</th>
                                                <th>Visa Types (B2B Rate / Visa Fee)</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($countries as $country)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            @if ($country->flag_url)
                                                                <img src="{{ $country->flag_url }}" alt="{{ $country->country_name }}"
                                                                    style="width:28px;height:20px;object-fit:cover;border:1px solid #eee;border-radius:2px;">
                                                            @else
                                                                <span class="text-muted" style="width:28px;display:inline-block;">-</span>
                                                            @endif
                                                            <strong>{{ $country->country_name }}</strong>
                                                        </div>
                                                    </td>
                                                    <td>{{ $country->country_code }}</td>
                                                    <td>
                                                        @forelse ($country->visaTypes as $type)
                                                            <div class="mb-1">
                                                                <strong>{{ $type->visa_name }}:</strong>
                                                                B2B {{ $type->b2b_rate ?? '-' }} / Fee {{ $type->visa_fee ?? '-' }}
                                                            </div>
                                                        @empty
                                                            <span class="text-muted">No visa type added</span>
                                                        @endforelse
                                                    </td>
                                                    <td>
                                                        @if ($country->is_active)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-secondary">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('visa-country.edit', $country->id) }}"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="mdi mdi-pencil"></i>
                                                            </a>
                                                            <form action="{{ route('visa-country.delete', $country->id) }}"
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
