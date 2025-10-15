<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Manage Images for "{{ $product->name }}"</h3>
        </div>
        <div class="card-body">
            @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if (session()->has('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <h5 class="mb-3">Upload New Images</h5>
            <form wire:submit.prevent="uploadImages" class="mb-4 p-3 border rounded">
                <div class="mb-3">
                    <label for="newImages" class="form-label">Select Images (multiple allowed)</label>
                    <input type="file" class="form-control @error('newImages.*') is-invalid @enderror" id="newImages" wire:model="newImages" multiple accept="image/*">
                    <div wire:loading wire:target="newImages" class="text-info mt-2">Uploading preview...</div>
                    @error('newImages.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading wire:target="uploadImages" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Upload Images
                    </button>
                </div>
            </form>

            <h5 class="mb-3">Existing Images (Drag to reorder)</h5>
            @if ($existingImages->isEmpty())
            <p>No images uploaded yet. Please upload some using the form above.</p>
            @else
            <div wire:sortable="updateImageSortOrder" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
                @foreach ($existingImages as $image)
                <div wire:sortable.item="{{ $image->id }}" wire:key="image-{{ $image->id }}" class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" alt="Product Image" style="height: 150px; object-fit: cover;">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <span class="badge bg-light text-dark">#{{ $loop->iteration }}</span>
                            <button type="button" class="btn btn-danger btn-sm" wire:click="deleteImage({{ $image->id }})" wire:confirm="Are you sure you want to delete this image?">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-secondary">Back to Product Details</a>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@nextapps-be/livewire-sortablejs@latest/dist/livewire-sortablejs.js"></script>
@endpush