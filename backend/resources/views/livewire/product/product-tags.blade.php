<div class="card shadow-sm mb-4">
    <div class="card-header">
        <h5>Product Tags</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="selectedTagIds" class="form-label">Select Existing Tags</label>
            <select class="form-select @error('selectedTagIds') is-invalid @enderror" id="selectedTagIds" wire:model.live="selectedTagIds" multiple>
                @foreach ($allTags->sortBy('name') as $tag)
                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
            @error('selectedTagIds') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <small class="form-text text-muted">Select multiple tags from the list.</small>
        </div>

        <div class="mb-3">
            <label for="newTagInput" class="form-label">Add New Tag</label>
            <div class="input-group">
                <input type="text" class="form-control @error('newTagInput') is-invalid @enderror" id="newTagInput" wire:model="newTagInput" placeholder="Enter new tag name">
                <button class="btn btn-outline-primary" type="button" wire:click="addTag">Add Tag</button>
                @error('newTagInput') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <small class="form-text text-muted">Type a tag and click 'Add Tag' or press Enter.</small>
        </div>

        @if (!empty($selectedTagIds))
        <hr>
        <h6>Current Tags:</h6>
        <div class="d-flex flex-wrap gap-2">
            @foreach ($allTags->whereIn('id', $selectedTagIds)->sortBy('name') as $tag)
            <span class="badge bg-secondary d-flex align-items-center p-2">
                {{ $tag->name }}
                <button type="button" class="btn-close btn-close-white ms-2" wire:click="$set('selectedTagIds', array_diff($selectedTagIds, [{{ $tag->id }}]))" aria-label="Remove tag"></button>
            </span>
            @endforeach
        </div>
        @endif
    </div>
</div>