<div>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Product Categories</h3>
            <button class="btn btn-primary" wire:click="createCategory">
                <i class="fas fa-plus"></i> Add New Category
            </button>
        </div>

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

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Search categories..." wire:model.live.debounce.300ms="search">
                    </div>
                    <div class="col-md-2">
                        <select wire:model.live="perPage" class="form-select">
                            <option value="5">5 per page</option>
                            <option value="10">10 per page</option>
                            <option value="25">25 per page</option>
                            <option value="50">50 per page</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th wire:click="sortBy('name')" style="cursor: pointer;">
                                    Name
                                    @if ($sortField == 'name')
                                    <i class="fas fa-{{ $sortDirection == 'asc' ? 'sort-up' : 'sort-down' }}"></i>
                                    @endif
                                </th>
                                <th>Image</th>
                                <th>Parent</th>
                                <th wire:click="sortBy('is_active')" style="cursor: pointer;">
                                    Active
                                    @if ($sortField == 'is_active')
                                    <i class="fas fa-{{ $sortDirection == 'asc' ? 'sort-up' : 'sort-down' }}"></i>
                                    @endif
                                </th>
                                <th wire:click="sortBy('show_on_homepage')" style="cursor: pointer;">
                                    Homepage
                                    @if ($sortField == 'show_on_homepage')
                                    <i class="fas fa-{{ $sortDirection == 'asc' ? 'sort-up' : 'sort-down' }}"></i>
                                    @endif
                                </th>
                                <th wire:click="sortBy('sort_order')" style="cursor: pointer;">
                                    Order
                                    @if ($sortField == 'sort_order')
                                    <i class="fas fa-{{ $sortDirection == 'asc' ? 'sort-up' : 'sort-down' }}"></i>
                                    @endif
                                </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                            <tr>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                    <br><small class="text-muted">{{ $category->slug }}</small>
                                </td>
                                <td>
                                    @if ($category->image_url)
                                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                    <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>{{ $category->parent->name ?? '—' }}</td>
                                <td>
                                    <i class="fas {{ $category->is_active ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i>
                                </td>
                                <td>
                                    <i class="fas {{ $category->show_on_homepage ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i>
                                </td>
                                <td>{{ $category->sort_order }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" wire:click="editCategory({{ $category->id }})" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="confirm('Are you sure you want to delete this category?') || event.stopImmediatePropagation()" wire:click="deleteCategory({{ $category->id }})" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No categories found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $categories->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Category Create/Edit Modal -->
    <div class="modal fade {{ $showCategoryModal ? 'show d-block' : '' }}" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="{{ !$showCategoryModal ? 'true' : 'false' }}" @if($showCategoryModal) style="display: block;" @endif>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalLabel">{{ $modalTitle }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="saveCategory">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" wire:model.live="name">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" wire:model.defer="slug">
                            <small class="form-text text-muted">SEO-friendly URL identifier (e.g., `electronics-accessories`).</small>
                            @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                            {{-- Hidden field to retain currentImage value if no new file is uploaded --}}
                            <input type="hidden" wire:model.defer="currentImage">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="sort_order" class="form-label">Sort Order <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" wire:model.defer="sort_order" min="0">
                                @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3 mb-3 form-check form-switch d-flex align-items-center">
                                <div>
                                    <input class="form-check-input @error('is_active') is-invalid @enderror" type="checkbox" id="is_active" wire:model.defer="is_active">
                                    <label class="form-check-label ms-2" for="is_active">Is Active</label>
                                    @error('is_active') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3 form-check form-switch d-flex align-items-center">
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

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading wire:target="saveCategory" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Save Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Backdrop (optional, to properly dim background) -->
    @if($showCategoryModal)
    <div class="modal-backdrop fade show"></div>
    @endif

    <style>
        /* Optional: Adjust modal z-index if needed for other elements */
        .modal.show {
            z-index: 1050;
            /* Ensure modal is above backdrop */
        }

        .modal-backdrop.show {
            z-index: 1040;
            /* Ensure backdrop is below modal */
        }
    </style>
</div>