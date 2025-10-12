<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>{{ $pageTitle }}</h3>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Categories
        </a>
    </div>

    @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form wire:submit.prevent="saveCategory">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" wire:model.live="name">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" wire:model.defer="slug">
                            <small class="form-text text-muted">SEO-friendly URL identifier (e.g., `electronics-accessories`).</small>
                            @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" rows="3" wire:model.defer="description"></textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="parent_id" class="form-label">Parent Category</label>
                    <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" wire:model.defer="parent_id">
                        <option value="">No Parent</option>
                        @foreach ($parentCategories as $parentCategory)
                        <option value="{{ $parentCategory->id }}">{{ $parentCategory->name }}</option>
                        @endforeach
                    </select>
                    @error('parent_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Category Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" wire:model.live="image">
                    <small class="form-text text-muted">Max 1MB. Accepted formats: JPG, PNG, GIF.</small>
                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror

                    @if ($image)
                    <p class="mt-2">New Image Preview:</p>
                    <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail" style="max-width: 150px;">
                    @elseif ($currentImage)
                    <p class="mt-2">Current Image:</p>
                    <img src="{{ asset('storage/' . $currentImage) }}" alt="Current Category Image" class="img-thumbnail" style="max-width: 150px;">
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="sort_order" class="form-label">Sort Order <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" wire:model.defer="sort_order" min="0">
                        @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3 form-check form-switch d-flex align-items-center">
                        <div>
                            <input class="form-check-input @error('is_active') is-invalid @enderror" type="checkbox" id="is_active" wire:model.defer="is_active">
                            <label class="form-check-label ms-2" for="is_active">Is Active</label>
                            @error('is_active') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 form-check form-switch d-flex align-items-center">
                        <div>
                            <input class="form-check-input @error('show_on_homepage') is-invalid @enderror" type="checkbox" id="show_on_homepage" wire:model.defer="show_on_homepage">
                            <label class="form-check-label ms-2" for="show_on_homepage">Show on Homepage</label>
                            @error('show_on_homepage') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <hr>
                <h5>SEO Information</h5>

                <div class="mb-3">
                    <label for="seo_title" class="form-label">SEO Title</label>
                    <input type="text" class="form-control @error('seo_title') is-invalid @enderror" id="seo_title" wire:model.defer="seo_title">
                    <small class="form-text text-muted">Title for search engines.</small>
                    @error('seo_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="seo_description" class="form-label">SEO Description</label>
                    <textarea class="form-control @error('seo_description') is-invalid @enderror" id="seo_description" rows="3" wire:model.defer="seo_description"></textarea>
                    <small class="form-text text-muted">Meta description for search engines.</small>
                    @error('seo_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading wire:target="saveCategory" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{ $isEditing ? 'Update Category' : 'Create Category' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>