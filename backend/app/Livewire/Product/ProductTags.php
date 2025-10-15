<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Locked;

class ProductTags extends Component
{
    #[Locked]
    public $productId;

    public $selectedTagIds = [];
    public Collection $allTags;

    public $newTagInput = ''; // For adding new tags on the fly

    public function mount($productId, $initialSelectedTagIds, $allTags)
    {
        $this->productId = $productId;
        $this->selectedTagIds = $initialSelectedTagIds;
        $this->allTags = $allTags;
    }

    public function updatedSelectedTagIds()
    {
        $this->emitUp('product-tags-updated', $this->selectedTagIds);
    }

    public function addTag()
    {
        $tagName = trim($this->newTagInput);
        if ($tagName) {
            $existingTag = Tag::where('name', $tagName)->first();
            if ($existingTag) {
                if (!in_array($existingTag->id, $this->selectedTagIds)) {
                    $this->selectedTagIds[] = $existingTag->id;
                }
            } else {
                $newTag = Tag::create(['name' => $tagName, 'slug' => \Str::slug($tagName)]);
                $this->allTags->push($newTag); // Add to local collection
                $this->selectedTagIds[] = $newTag->id;
            }
            $this->newTagInput = '';
            $this->emitUp('product-tags-updated', $this->selectedTagIds);
        }
    }

    public function render()
    {
        return view('livewire.product.product-tags');
    }
}
