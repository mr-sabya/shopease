<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Manage Variants for "{{ $product->name }}"</h3>
        </div>
        <div class="card-body">
            @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @error('selectedAttributeIds')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <h5 class="mb-3">1. Select Variation Attributes</h5>
            <div class="mb-4 p-3 border rounded">
                <div class="form-group">
                    <label for="selectedAttributeIds" class="form-label">Attributes used for Variations:</label>
                    <select wire:model.live="selectedAttributeIds" class="form-select" multiple>
                        @foreach ($availableAttributes as $attribute)
                        <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Select attributes like "Color", "Size" to create product variations.</small>
                    @error('selectedAttributeIds') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            @if (!empty($selectedAttributeIds))
            <h5 class="mb-3">2. Define Attribute Values</h5>
            <div class="mb-4 p-3 border rounded">
                @foreach ($selectedAttributeIds as $attributeId)
                @php
                $attribute = $availableAttributes->find($attributeId);
                @endphp
                @if ($attribute)
                <div class="mb-3 border-bottom pb-3">
                    <strong>{{ $attribute->name }} Values:</strong>
                    <div class="d-flex flex-wrap my-2">
                        @forelse ($attributeValuesToManage[$attributeId] ?? [] as $value)
                        <span class="badge bg-secondary text-white fs-6 p-2 me-2 mb-2">
                            {{ $value->value }}
                            <button type="button" class="btn-close btn-close-white ms-1" wire:click="removeAttributeValue({{ $attributeId }}, {{ $value->id }})" aria-label="Remove"></button>
                        </span>
                        @empty
                        <p class="text-muted">No values selected for {{ $attribute->name }}.</p>
                        @endforelse
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control @error('newAttributeValueNames.'.$attributeId) is-invalid @enderror" wire:model.live="newAttributeValueNames.{{ $attributeId }}" placeholder="Add new {{ $attribute->name }} value">
                        <button class="btn btn-outline-success" type="button" wire:click="addAttributeValue({{ $attributeId }})">Add Value</button>
                        @error('newAttributeValueNames.'.$attributeId) <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                @endif
                @endforeach
                <div class="text-end mt-3">
                    <button type="button" class="btn btn-info" wire:click="generateVariants">
                        <span wire:loading wire:target="generateVariants" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Generate Variant Combinations
                    </button>
                </div>
            </div>
            @endif

            @if (!empty($variants))
            <h5 class="mb-3">3. Manage Variant Details</h5>
            <form wire:submit.prevent="saveVariants">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Variant</th>
                                <th>SKU</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Compare Price</th>
                                <th>Cost Price</th>
                                <th>Quantity</th>
                                <th>Weight</th>
                                <th>Active</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($variants as $index => $variant)
                            <tr wire:key="variant-row-{{ $variant->id ?? 'new-'.$index }}">
                                <td>
                                    <strong>{{ $variant->attributeValues->pluck('value')->implode(', ') }}</strong>
                                    @if (!$variant->exists)
                                    <span class="badge bg-warning text-dark ms-2">NEW</span>
                                    @endif
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm @error('variantSku.'.$variant->id) is-invalid @enderror" wire:model.live="variantSku.{{ $variant->id ?? 'new-'.$index }}" placeholder="Variant SKU">
                                    @error('variantSku.'.$variant->id) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </td>
                                <td>
                                    @if ($variant->image_path)
                                    <img src="{{ asset('storage/' . $variant->image_path) }}" alt="Variant Image" class="img-thumbnail mb-1" style="width: 50px; height: 50px; object-fit: cover;">
                                    @endif
                                    <input type="file" class="form-control form-control-sm @error('variantNewImage.'.$index) is-invalid @enderror" wire:model="variantNewImage.{{ $index }}">
                                    <div wire:loading wire:target="variantNewImage.{{ $index }}" class="text-info">Uploading...</div>
                                    @error('variantNewImage.'.$index) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </td>
                                <td>
                                    <input type="number" step="0.01" class="form-control form-control-sm @error('variantPrice.'.$variant->id) is-invalid @enderror" wire:model.live="variantPrice.{{ $variant->id ?? 'new-'.$index }}" placeholder="0.00">
                                    @error('variantPrice.'.$variant->id) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </td>
                                <td>
                                    <input type="number" step="0.01" class="form-control form-control-sm @error('variantCompareAtPrice.'.$variant->id) is-invalid @enderror" wire:model.live="variantCompareAtPrice.{{ $variant->id ?? 'new-'.$index }}" placeholder="0.00">
                                    @error('variantCompareAtPrice.'.$variant->id) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </td>
                                <td>
                                    <input type="number" step="0.01" class="form-control form-control-sm @error('variantCostPrice.'.$variant->id) is-invalid @enderror" wire:model.live="variantCostPrice.{{ $variant->id ?? 'new-'.$index }}" placeholder="0.00">
                                    @error('variantCostPrice.'.$variant->id) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm @error('variantQuantity.'.$variant->id) is-invalid @enderror" wire:model.live="variantQuantity.{{ $variant->id ?? 'new-'.$index }}" placeholder="0">
                                    @error('variantQuantity.'.$variant->id) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </td>
                                <td>
                                    <input type="number" step="0.01" class="form-control form-control-sm @error('variantWeight.'.$variant->id) is-invalid @enderror" wire:model.live="variantWeight.{{ $variant->id ?? 'new-'.$index }}" placeholder="0.00">
                                    @error('variantWeight.'.$variant->id) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </td>
                                <td>
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <input class="form-check-input" type="checkbox" wire:model.live="variantIsActive.{{ $variant->id ?? 'new-'.$index }}" id="variantActive-{{ $variant->id ?? 'new-'.$index }}">
                                    </div>
                                </td>
                                <td>
                                    @if ($variant->exists)
                                    <button type="button" class="btn btn-danger btn-sm" wire:click="deleteVariant({{ $variant->id }})" wire:confirm="Are you sure you want to delete this variant? This action cannot be undone.">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading wire:target="saveVariants" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Save All Variants
                    </button>
                </div>
            </form>
            @endif
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-secondary">Back to Product Details</a>
        </div>
    </div>
</div>