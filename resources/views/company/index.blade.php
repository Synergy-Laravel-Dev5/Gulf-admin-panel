@extends('layout.master')

@section('title', 'Companies')
@section('header-title', 'Companies')

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Company Management</h4>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Companies List</h5>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>S:NO</th>
                                                <th>Logo</th>
                                                <th>Company Name</th>
                                                <th>Contact Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($companies as $company)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        @if ($company->logo_url)
                                                            <img src="{{ $company->logo_url }}" alt="Logo" style="width:50px; height:50px; object-fit:contain;" class="rounded border">
                                                        @else
                                                            <div class="bg-soft-primary text-primary rounded d-flex align-items-center justify-content-center fw-bold border" style="width:50px; height:50px;">
                                                                {{ strtoupper(substr($company->company_name ?? 'C', 0, 1)) }}
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td><strong>{{ $company->company_name ?? 'N/A' }}</strong></td>
                                                    <td>{{ $company->name ?? 'N/A' }}</td>
                                                    <td>{{ $company->email ?? 'N/A' }}</td>
                                                    <td>{{ $company->phone ?? 'N/A' }}</td>
                                                    <td>
                                                        @if ($company->status == 'active')
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('company.edit', $company->id) }}" class="btn btn-sm btn-outline-success" title="Edit Company Details">
                                                                <i class="mdi mdi-pencil"></i>
                                                            </a>
                                                            <form action="{{ route('company.delete', $company->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this company?')" title="Delete Company">
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
