@extends('layout.master')

@section('title', 'Users')
@section('header-title', 'Users')

@section('content')

    <div class="content-page">
        <div class="content">
            <div class="container">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Dashboard</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <!-- HEADER -->
                            <div class="card-header d-flex justify-content-between align-items-center">

                                <h5 class="mb-0">Users List</h5>

                                <div class="d-flex gap-2">

                                    @can('user_trash_view')
                                        <a href="{{ route('user.trash') }}"
                                            class="btn btn-danger btn-sm d-flex gap-1 align-items-center">
                                            <i class="material-icons-outlined"></i>
                                            Trash <span>{{ $trashrole ?? 0 }}</span>
                                        </a>
                                    @endcan

                                    @can('user_create')
                                        <a href="{{ route('user.create') }}"
                                            class="btn btn-primary btn-sm d-flex gap-1 align-items-center">
                                            <i class="material-icons-outlined"></i>
                                            Add User
                                        </a>
                                    @endcan

                                </div>

                            </div>

                            <!-- BODY -->
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap align-middle">

                                        <thead class="table-light">
                                            <tr>
                                                <th>S:NO</th>
                                                <th>Profile</th>
                                                <th>Name</th>
                                                <th>Email / Phone</th>
                                                <th>Documents</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>

                                                    <td>
                                                        @if ($user->profile_picture_url)
                                                            <img src="{{ $user->profile_picture_url }}" alt="avatar"
                                                                style="width:40px; height:40px; object-fit:cover;"
                                                                class="rounded-circle border">
                                                        @else
                                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                                                style="width:40px; height:40px;">
                                                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                                            </div>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <strong>{{ $user->name ?? 'N/A' }}</strong>
                                                    </td>

                                                    <td>
                                                        <div>{{ $user->email ?? 'N/A' }}</div>
                                                        @if ($user->phone)
                                                            <small class="text-muted"><i class="mdi mdi-phone me-1"></i>{{ $user->phone }}</small>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <div class="d-flex flex-wrap gap-1">
                                                            @if ($user->passport_url)
                                                                <a href="{{ $user->passport_url }}" target="_blank" class="badge bg-success text-decoration-none" title="Passport">
                                                                    <i class="mdi mdi-file-document-outline"></i> Passport
                                                                </a>
                                                            @endif

                                                            @if ($user->cnic_url)
                                                                <a href="{{ $user->cnic_url }}" target="_blank" class="badge bg-info text-dark text-decoration-none" title="CNIC">
                                                                    <i class="mdi mdi-card-account-details-outline"></i> CNIC
                                                                </a>
                                                            @endif

                                                            @if ($user->visa_url)
                                                                <a href="{{ $user->visa_url }}" target="_blank" class="badge bg-warning text-dark text-decoration-none" title="Visa">
                                                                    <i class="mdi mdi-certificate-outline"></i> Visa
                                                                </a>
                                                            @endif

                                                            @if ($user->ticket_url)
                                                                <a href="{{ $user->ticket_url }}" target="_blank" class="badge bg-purple text-decoration-none" style="background-color: #6f42c1; color: white;" title="Ticket">
                                                                    <i class="mdi mdi-ticket-outline"></i> Ticket
                                                                </a>
                                                            @endif

                                                            @if (!$user->passport_url && !$user->cnic_url && !$user->visa_url && !$user->ticket_url)
                                                                <span class="text-muted fs-12">No Docs</span>
                                                            @endif
                                                        </div>
                                                    </td>

                                                    <td>
                                                        @if ($user->status == 'active')
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-danger">Inactive</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <div class="d-flex gap-2">

                                                            <a href="{{ route('user.show', $user->id) }}"
                                                                class="btn btn-sm btn-outline-info" title="View Profile & Uploaded Documents">
                                                                <i class="mdi mdi-eye"></i> 
                                                            </a>

                                                            {{-- @can('user_edit') --}}
                                                                <a href="{{ route('user.edit', $user->id) }}"
                                                                    class="btn btn-sm btn-outline-success" title="Edit User">
                                                                    <i class="mdi mdi-pencil"></i>
                                                                </a>
                                                            {{-- @endcan --}}

                                                            {{-- @can('user_trash') --}}
                                                                <form action="{{ route('user.delete', $user->id) }}"
                                                                    method="POST" onsubmit="return confirm('Are you sure?');">
                                                                    @csrf
                                                                    @method('DELETE')

                                                                    <button class="btn btn-sm btn-outline-danger"
                                                                        title="Delete">
                                                                        <i class="mdi mdi-delete"></i>
                                                                    </button>
                                                                </form>
                                                            {{-- @endcan --}}

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
