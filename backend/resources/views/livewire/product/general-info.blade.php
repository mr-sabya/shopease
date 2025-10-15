<div class="card shadow-sm mb-4">
    <div class="card-header">
        <h5>General Information</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" wire:model.live.debounce.300ms="name" placeholder="Enter product name">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" wire:model.live.debounce.300ms="slug" placeholder="product-name-slug">
                @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="vendor_id" class="form-label">Vendor <span class="text-danger">*</span></label>
                <select class="form-select @error('vendor_id') is-invalid @enderror" id="vendor_id" wire:model="vendor_id">
                    <option value="">Select Vendor</option>
                    @foreach ($allVendors as $vendor)
                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                    @endforeach
                </select>
                @error('vendor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" wire:model="category_id">
                    <option value="">Select Category</option>
                    @foreach ($allCategories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="brand_id" class="form-label">Brand</label>
                <select class="form-select @error('brand_id') is-invalid @enderror" id="brand_id" wire:model="brand_id">
                    <option value="">Select Brand</option>
                    @foreach ($allBrands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
                @error('brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="type" class="form-label">Product Type <span class="text-danger">*</span></label>
                <select class="form-select @error('type') is-invalid @enderror" id="type" wire:model.live="type">
                    @foreach ($productTypes as $productType)
                    <option value="{{ $productType->value }}">{{ $productType->label() }}</option>
                    @endforeach
                </select>
                @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="short_description" class="form-label">Short Description</label>
            <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description" wire:model="short_description" rows="3" placeholder="Brief description for product listing"></textarea>
            @error('short_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="long_description" class="form-label">Long Description</label>
            <div wire:ignore>
                {{-- Consider using a rich text editor like Trix or TinyMCE and integrating it with Livewire --}}
                <textarea class="form-control @error('long_description') is-invalid @enderror" id="long_description" wire:model="long_description" rows="6" placeholder="Detailed product description"></textarea>
            </div>
            @error('long_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="row mb-3">
            <div class="col-md-4 form-check form-switch">
                <input class="form-check-input" type="checkbox" id="is_active" wire:model="is_active">
                <label class="form-check-label" for="is_active">Is Active?</label>
            </div>
            <div class="col-md-4 form-check form-switch">
                <input class="form-check-input" type="checkbox" id="is_featured" wire:model="is_featured">
                <label class="form-check-label" for="is_featured">Is Featured?</label>
            </div>
            <div class="col-md-4 form-check form-switch">
                <input class="form-check-input" type="checkbox" id="is_new" wire:model="is_new">
                <label class="form-check-label" for="is_new">Is New Arrival?</label>
            </div>
        </div>
    </div>
</div>