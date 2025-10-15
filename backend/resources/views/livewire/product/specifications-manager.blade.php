<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Manage Specifications for "{{ $product->name }}"</h3>
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

            <h5 class="mb-3">Define Product Specifications</h5>
            <p class="text-muted">Select an attribute and its corresponding value to define a specification for this product. You can also create new attribute values on the fly.</p>

            <form wire:submit.prevent="saveSpecifications">
                <div class="row">
                    @forelse ($availableAttributes as $attribute)
                    <div class="col-md-6 mb-4">
                        <label class="form-label"><strong>{{ $attribute->name }}</strong></label>
                        <select class="form-select mb-2 @error('selectedSpecs.'.$attribute->id) is-invalid @enderror" wire:model.live="selectedSpecs.{{ $attribute->id }}">
                            <option value="">-- No Value --</option>
                            @foreach ($attributeOptions[$attribute->id] ?? [] as $value)
                            <option value="{{ $value->id }}">{{ $value->value }}</option>
                            @endforeach
                        </select>
                        @error('selectedSpecs.'.$attribute->id) <div class="invalid-feedback">{{ $message }}</div> @enderror

                        <div class="input-group">
                            <input type="text" class="form-control @error('newAttributeValueNames.'.$attribute->id) is-invalid @enderror" wire:model.live="newAttributeValueNames.{{ $attribute->id }}" placeholder="New {{ $attribute->name }} value">
                            <button class="btn btn-outline-success" type="button" wire:click="addAttributeValue({{ $attribute->id }})">Add</button>
                            @error('newAttributeValueNames.'.$attribute->id) <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    @empty
                    <div class="col-md-12">
                        <div class="alert alert-warning">No attributes available. Please create some attributes first.</div>
                    </div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading wire:target="saveSpecifications" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Save Specifications
                    </button>
                </div>
            </form>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-secondary">Back to Product Details</a>
        </div>
    </div>
</div>