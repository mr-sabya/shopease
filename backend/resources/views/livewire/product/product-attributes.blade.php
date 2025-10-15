<div class="card shadow-sm mb-4">
    <div class="card-header">
        <h5>Product Specifications (Attributes)</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="attributeSetId" class="form-label">Attribute Set</label>
            <select class="form-select @error('attributeSetId') is-invalid @enderror" id="attributeSetId" wire:model.live="attributeSetId">
                <option value="">No Attribute Set</option>
                @foreach ($allAttributeSets as $set)
                <option value="{{ $set->id }}">{{ $set->name }}</option>
                @endforeach
            </select>
            @error('attributeSetId') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <small class="form-text text-muted">Select an attribute set to define specifications for this product.</small>
        </div>

        @if (!empty($availableAttributes))
        <hr>
        <h6>Set Product Attributes:</h6>
        @foreach ($availableAttributes as $attribute)
        <div class="mb-3">
            <label for="attribute-{{ $attribute->id }}" class="form-label">{{ $attribute->name }}</label>
            <select class="form-select @error('productAttributeValues.' . $attribute->id) is-invalid @enderror"
                id="attribute-{{ $attribute->id }}"
                wire:model.live="productAttributeValues.{{ $attribute->id }}">
                <option value="">Select {{ $attribute->name }}</option>
                @foreach ($availableAttributeValues[$attribute->id] as $value)
                <option value="{{ $value->id }}">{{ $value->value }}</option>
                @endforeach
            </select>
            @error('productAttributeValues.' . $attribute->id) <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        @endforeach
        @elseif ($attributeSetId)
        <div class="alert alert-info mt-3">This attribute set has no attributes defined.</div>
        @endif
    </div>
</div>