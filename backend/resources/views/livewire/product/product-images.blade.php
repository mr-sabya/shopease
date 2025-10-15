<div class="card shadow-sm mb-4">
    <div class="card-header">
        <h5>Product Images</h5>
    </div>
    <div class="card-body">
        <div class="row">
            {{-- Main Product Thumbnail --}}
            <div class="col-md-6 mb-4">
                <label for="mainProductThumbnail" class="form-label">Main Thumbnail Image</label>
                <input type="file" class="form-control @error('mainProductThumbnail') is-invalid @enderror" id="mainProductThumbnail" wire:model="mainProductThumbnail" accept="image/*">
                @error('mainProductThumbnail') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <small class="form-text text-muted">Upload the primary image for your product (Max 2MB).</small>

                <div class="mt-2 d-flex align-items-center flex-wrap gap-2">
                    @if ($mainProductThumbnail instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                    <div class="position-relative">
                        <img src="{{ $mainProductThumbnail->temporaryUrl() }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                        <button type="button" class="btn-close position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" wire:click="clearMainThumbnail" aria-label="Remove thumbnail"></button>
                        <div wire:loading wire:target="mainProductThumbnail" class="spinner-border spinner-border-sm text-primary position-absolute start-50 top-50 translate-middle" role="status"></div>
                    </div>
                    @elseif (is_string($mainProductThumbnail))
                    <div class="position-relative">
                        <img src="{{ $mainProductThumbnail }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                        <button type="button" class="btn-close position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" wire:click="clearMainThumbnail" aria-label="Remove thumbnail"></button>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Additional Product Images --}}
            <div class="col-md-6 mb-4">
                <label for="newImages" class="form-label">Additional Product Images</label>
                <input type="file" class="form-control @error('newImages.*') is-invalid @enderror" id="newImages" wire:model="newImages" multiple accept="image/*">
                @error('newImages.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <small class="form-text text-muted">Upload more images to showcase your product (Max 2MB each).</small>

                <div class="mt-2 d-flex align-items-center flex-wrap gap-2">
                    @foreach ($newImages as $index => $image)
                    @if ($image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                    <div class="position-relative">
                        <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                        <button type="button" class="btn-close position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" wire:click="removeNewImage({{ $index }})" aria-label="Remove image"></button>
                        <div wire:loading wire:target="newImages.{{ $index }}" class="spinner-border spinner-border-sm text-primary position-absolute start-50 top-50 translate-middle" role="status"></div>
                    </div>
                    @endif
                    @endforeach

                    @foreach ($existingImages as $image)
                    <div class="position-relative">
                        <img src="{{ $image['url'] }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                        <button type="button" class="btn-close position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" wire:click="removeExistingImage({{ $image['id'] }})" aria-label="Remove image"></button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>