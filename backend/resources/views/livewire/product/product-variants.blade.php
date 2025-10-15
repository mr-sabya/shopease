<div class="card shadow-sm mb-4">
    <div class="card-header">
        <h5>Product Variants</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <p>Select attributes that define product variants (e.g., Color, Size). Each combination of selected attribute values will create a unique product variant.</p>
            <div class="d-flex flex-wrap gap-2 mb-3">
                @foreach ($variantDefiningAttributes as $index => $attr)
                <span class="badge bg-primary d-flex align-items-center p-2">
                    {{ $attr['name'] }}
                    <button type="button" class="btn-close btn-close-white ms-2" wire:click="removeVariantDefiningAttribute({{ $index }})" aria-label="Remove"></button>
                </span>
                @endforeach
            </div>

            <div class="input-group">
                <select class="form-select @error('newVariantAttributeId') is-invalid @enderror" wire:model="newVariantAttributeId">
                    <option value="">Add Defining Attribute</option>
                    @foreach ($availableVariantAttributes as $attr)
                    @if (!collect($variantDefiningAttributes)->pluck('id')->contains($attr->id))
                    <option value="{{ $attr->id }}">{{ $attr->name }}</option>
                    @endif
                    @endforeach
                </select>
                <button class="btn btn-outline-primary" type="button" wire:click="addVariantDefiningAttribute">Add</button>
                @error('newVariantAttributeId') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            @if (count($variantDefiningAttributes) > 0)
            <small class="form-text text-muted">Selected attributes will be used to generate variants. <a href="#" wire:click.prevent="generateVariants">Click here to generate/refresh variants</a> after changing defining attributes.</small>
            @endif
        </div>

        @if (count($variants) > 0)
        <hr>
        <h6>Configured Variants:</h6>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Variant Name</th>
                        <th>SKU</th>
                        <th>Price</th>
                        <th>Compare At Price</th>
                        <th>Cost Price</th>
                        <th>Quantity</th>
                        <th>Weight (kg)</th>
                        <th>Images</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($variants as $index => $variant)
                    <tr>
                        <td>
                            <strong>{{ $variant['variant_name'] }}</strong>
                            <small class="d-block text-muted">ID: {{ $variant['id'] ?? 'New' }}</small>
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm" wire:model.live.debounce.300ms="variants.{{ $index }}.sku">
                            @error("variants.{$index}.sku") <span class="text-danger small">{{ $message }}</span> @enderror
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control form-control-sm" wire:model.live.debounce.300ms="variants.{{ $index }}.price">
                            @error("variants.{$index}.price") <span class="text-danger small">{{ $message }}</span> @enderror
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control form-control-sm" wire:model.live.debounce.300ms="variants.{{ $index }}.compare_at_price">
                            @error("variants.{$index}.compare_at_price") <span class="text-danger small">{{ $message }}</span> @enderror
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control form-control-sm" wire:model.live.debounce.300ms="variants.{{ $index }}.cost_price">
                            @error("variants.{$index}.cost_price") <span class="text-danger small">{{ $message }}</span> @enderror
                        </td>
                        <td>
                            @if($is_manage_stock)
                            <input type="number" class="form-control form-control-sm" wire:model.live.debounce.300ms="variants.{{ $index }}.quantity">
                            @error("variants.{$index}.quantity") <span class="text-danger small">{{ $message }}</span> @enderror
                            @else
                            <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control form-control-sm" wire:model.live.debounce.300ms="variants.{{ $index }}.weight">
                            @error("variants.{$index}.weight") <span class="text-danger small">{{ $message }}</span> @enderror
                        </td>
                        <td>
                            <input type="file" class="form-control form-control-sm mb-1" wire:model="variants.{{ $index }}.new_images" multiple accept="image/*">
                            @error("variants.{$index}.new_images.*") <span class="text-danger small">{{ $message }}</span> @enderror
                            <div class="d-flex flex-wrap gap-1 mt-1">
                                @foreach ($variant['images'] as $imgIndex => $imagePath)
                                <div class="position-relative">
                                    <img src="{{ $imagePath }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                    <button type="button" class="btn-close position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" wire:click="removeVariantImage({{ $index }}, {{ $imgIndex }})" aria-label="Remove image"></button>
                                </div>
                                @endforeach
                                @foreach ($variant['new_images'] as $newImgIndex => $newImage)
                                @if ($newImage instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                                <div class="position-relative">
                                    <img src="{{ $newImage->temporaryUrl() }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                    <button type="button" class="btn-close position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" wire:click="removeNewVariantImage({{ $index }}, {{ $newImgIndex }})" aria-label="Remove image"></button>
                                    <div wire:loading wire:target="variants.{{ $index }}.new_images.{{ $newImgIndex }}" class="spinner-border spinner-border-sm text-primary position-absolute start-50 top-50 translate-middle" role="status"></div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="variantActive{{ $index }}" wire:model.live="variants.{{ $index }}.is_active">
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeVariant({{ $index }})" title="Remove Variant">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @elseif (count($variantDefiningAttributes) > 0)
        <div class="alert alert-info mt-3">
            No variants generated yet. Click "Generate Variants" to create variant combinations based on your selected attributes.
        </div>
        @else
        <div class="alert alert-info mt-3">
            Select defining attributes above to start creating product variants.
        </div>
        @endif
    </div>
</div>