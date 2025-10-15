<div class="card shadow-sm mb-4">
    <div class="card-header">
        <h5>Digital Product Details</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="digital_file" class="form-label">Digital File
                @if(!$current_digital_file_path && !$digital_file)
                <span class="text-danger">*</span>
                @endif
            </label>
            <input type="file" class="form-control @error('digital_file') is-invalid @enderror" id="digital_file" wire:model="digital_file">
            @error('digital_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <small class="form-text text-muted">Allowed formats: zip, pdf, docx, xlsx, jpg, png. Max 10MB.</small>

            @if ($digital_file)
            <div class="mt-2 d-flex align-items-center">
                <span class="badge bg-secondary me-2">New: {{ $digital_file->getClientOriginalName() }}</span>
                <button type="button" class="btn btn-sm btn-outline-danger" wire:click="clearDigitalFile">Clear New File</button>
            </div>
            @elseif ($current_digital_file_path)
            <div class="mt-2 d-flex align-items-center">
                <span class="badge bg-success me-2">Current: {{ $this->digitalFileName }}</span>
                <button type="button" class="btn btn-sm btn-outline-danger" wire:click="clearDigitalFile">Remove Current File</button>
            </div>
            @endif
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="download_limit" class="form-label">Download Limit</label>
                <input type="number" class="form-control @error('download_limit') is-invalid @enderror" id="download_limit" wire:model.live.debounce.300ms="download_limit" min="1" placeholder="1">
                @error('download_limit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <small class="form-text text-muted">Number of times a customer can download the file.</small>
            </div>
            <div class="col-md-6 mb-3">
                <label for="download_expiry_days" class="form-label">Download Expiry (Days)</label>
                <input type="number" class="form-control @error('download_expiry_days') is-invalid @enderror" id="download_expiry_days" wire:model.live.debounce.300ms="download_expiry_days" min="0" placeholder="365">
                @error('download_expiry_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <small class="form-text text-muted">Number of days before download link expires (0 for never).</small>
            </div>
        </div>
    </div>
</div>