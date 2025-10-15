<div class="card shadow-sm mb-4">
    <div class="card-header">
        <h5>Pricing & Inventory</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="sku" class="form-label">SKU <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" wire:model.live.debounce.300ms="sku" placeholder="Unique Product Code">
                @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" wire:model.live.debounce.300ms="price" placeholder="0.00">
                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="compare_at_price" class="form-label">Compare At Price</label>
                <input type="number" step="0.01" class="form-control @error('compare_at_price') is-invalid @enderror" id="compare_at_price" wire:model.live.debounce.300ms="compare_at_price" placeholder="0.00">
                @error('compare_at_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="cost_price" class="form-label">Cost Price</label>
                <input type="number" step="0.01" class="form-control @error('cost_price') is-invalid @enderror" id="cost_price" wire:model.live.debounce.300ms="cost_price" placeholder="0.00">
                @error('cost_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="is_manage_stock" wire:model.live="is_manage_stock">
                    <label class="form-check-label" for="is_manage_stock">Manage Stock?</label>
                </div>
                @if ($is_manage_stock)
                <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" wire:model.live.debounce.300ms="quantity" placeholder="0">
                @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                @else
                <label class="form-label text-muted">Stock management is disabled.</label>
                @endif
            </div>
            <div class="col-md-6 mb-3">
                <label for="weight" class="form-label">Weight (kg)</label>
                <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" id="weight" wire:model.live.debounce.300ms="weight" placeholder="0.00">
                @error('weight') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="min_order_quantity" class="form-label">Min Order Quantity</label>
                <input type="number" class="form-control @error('min_order_quantity') is-invalid @enderror" id="min_order_quantity" wire:model.live.debounce.300ms="min_order_quantity" min="1">
                @error('min_order_quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="max_order_quantity" class="form-label">Max Order Quantity</label>
                <input type="number" class="form-control @error('max_order_quantity') is-invalid @enderror" id="max_order_quantity" wire:model.live.debounce.300ms="max_order_quantity" min="{{ $min_order_quantity }}">
                @error('max_order_quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
</div>