<div class="card shadow-sm mb-4">
    <div class="card-header">
        <h5>SEO Fields</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="meta_title" class="form-label">Meta Title</label>
            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" wire:model.live.debounce.300ms="meta_title" placeholder="SEO Title">
            @error('meta_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <small class="form-text text-muted">A concise title for search engine results. Max 60 characters.</small>
            <div class="text-end text-muted small">{{ 60 - strlen($meta_title ?? '') }} characters left</div>
        </div>

        <div class="mb-3">
            <label for="meta_description" class="form-label">Meta Description</label>
            <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" wire:model.live.debounce.300ms="meta_description" rows="3" placeholder="A brief summary of the product for search engines."></textarea>
            @error('meta_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <small class="form-text text-muted">A short description for search engine snippets. Max 160 characters.</small>
            <div class="text-end text-muted small">{{ 160 - strlen($meta_description ?? '') }} characters left</div>
        </div>

        <div class="mb-3">
            <label for="meta_keywords" class="form-label">Meta Keywords</label>
            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" id="meta_keywords" wire:model.live.debounce.300ms="meta_keywords" placeholder="keyword1, keyword2, keyword3">
            @error('meta_keywords') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <small class="form-text text-muted">Comma-separated keywords relevant to the product.</small>
        </div>
    </div>
</div>