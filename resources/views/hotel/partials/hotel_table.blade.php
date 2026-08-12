<div class="table-responsive">
    <table class="table table-bordered dt-responsive nowrap align-middle datatable-hotel">
        <thead class="table-light">
            <tr>
                <th>S:NO</th>
                <th>Image</th>
                <th>Hotel Name</th>
                <th>City</th>
                <th>Star Rating</th>
                <th>Distance / Location</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($hotelsList as $hotel)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if ($hotel->image_url)
                            <img src="{{ $hotel->image_url }}" width="50" height="50" style="object-fit:cover; border-radius:4px;" class="border">
                        @else
                            <span class="text-muted">No Image</span>
                        @endif
                        @if($hotel->images && $hotel->images->count() > 0)
                            <br><span class="badge bg-info text-dark fs-10 mt-1">+{{ $hotel->images->count() }} gallery photos</span>
                        @endif
                    </td>
                    <td><strong>{{ $hotel->name }}</strong></td>
                    <td class="text-capitalize"><span class="badge bg-soft-info text-info fs-12">{{ $hotel->city }}</span></td>
                    <td>
                        <span class="text-warning">
                            @for ($i = 0; $i < (int)$hotel->star_rating; $i++)
                                ★
                            @endfor
                        </span>
                        <small class="text-muted">({{ $hotel->star_rating }} Star)</small>
                    </td>
                    <td>{{ $hotel->distance ?? 'N/A' }}</td>
                    <td>
                        @if ($hotel->status == 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('hotel.edit', $hotel->id) }}"
                                class="btn btn-sm btn-outline-primary" title="Edit Hotel & Gallery">
                                <i class="mdi mdi-pencil"></i>
                            </a>
                            <form action="{{ route('hotel.delete', $hotel->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Are you sure you want to delete this hotel?')">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No hotels found in this category.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
