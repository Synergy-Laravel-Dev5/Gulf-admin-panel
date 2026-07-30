
<div class="card mb-3 visa-type-block">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0">Visa Type</h6>
            <button type="button" class="btn btn-sm btn-outline-danger remove-visa-type-btn">
                <i class="mdi mdi-close"></i> Remove
            </button>
        </div>

        @if ($type)
            <input type="hidden" name="visa_types[{{ $index }}][id]" value="{{ $type->id }}">
        @endif

        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Visa Name</label>
                <input type="text" name="visa_types[{{ $index }}][visa_name]"
                       class="form-control"
                       value="{{ $type->visa_name ?? 'Standard' }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">B2B Rate</label>
                <input type="text" name="visa_types[{{ $index }}][b2b_rate]"
                       class="form-control" placeholder="PKR 15,000/-"
                       value="{{ $type->b2b_rate ?? '' }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Visa Fee</label>
                <input type="text" name="visa_types[{{ $index }}][visa_fee]"
                       class="form-control" placeholder="$90 (USD)"
                       value="{{ $type->visa_fee ?? '' }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Process Time</label>
                <input type="text" name="visa_types[{{ $index }}][process_time]"
                       class="form-control" placeholder="30 Days"
                       value="{{ $type->process_time ?? '' }}">
            </div>

            <div class="col-md-8">
                <label class="form-label">Notes</label>
                <input type="text" name="visa_types[{{ $index }}][notes]"
                       class="form-control"
                       value="{{ $type->notes ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label d-block">Status</label>
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox"
                           name="visa_types[{{ $index }}][is_active]" value="1"
                           {{ ($type->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label">Active</label>
                </div>
            </div>
        </div>

        <hr>

        <label class="form-label d-block">Requirements</label>
        <div class="requirements-wrapper">
            @php
                $requirements = $type->requirements ?? ['Valid Passport', 'Picture with White Background', 'CNIC Front & Back', 'Bank Statement', 'Other Documents'];
            @endphp

            @foreach ($requirements as $req)
                <div class="input-group mb-2 requirement-row">
                    <input type="text" name="visa_types[{{ $index }}][requirements][]" class="form-control" value="{{ $req }}">
                    <button type="button" class="btn btn-outline-danger remove-requirement-btn">&times;</button>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary add-requirement-btn">
            <i class="mdi mdi-plus"></i> Add Requirement
        </button>
    </div>
</div>
