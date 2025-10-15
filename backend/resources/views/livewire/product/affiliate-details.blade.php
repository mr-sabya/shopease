<div class="card shadow-sm mb-4">
    <div class="card-header">
        <h5>Affiliate Details</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="affiliate_url" class="form-label">Affiliate URL <span class="text-danger">*</span></label>
            <input type="url" class="form-control @error('affiliate_url') is-invalid @enderror" id="affiliate_url" wire:model.live.debounce.300ms="affiliate_url" placeholder="https://www.example.com/affiliate-link">
            @error('affiliate_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <small class="form-text text-muted">This is the external URL where customers will be redirected to purchase the product.</small>
        </div>
    </div>
</div>