<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Locked;

class ProductImages extends Component
{
    use WithFileUploads;

    #[Locked]
    public $productId;

    public $mainProductThumbnail; // Livewire TemporaryUploadedFile or URL/path string
    public $newImages = []; // Array of Livewire TemporaryUploadedFile
    public $existingImages = []; // Array of ProductImage data {id, image_path, url}

    public function mount($productId, $initialMainProductThumbnail, $initialExistingImages)
    {
        $this->productId = $productId;
        $this->mainProductThumbnail = $initialMainProductThumbnail;
        $this->existingImages = $initialExistingImages;
    }

    protected function updated($propertyName)
    {
        if (
            $propertyName === 'mainProductThumbnail' ||
            str_starts_with($propertyName, 'newImages')
        ) {
            $this->emitImageUpdate();
        }
    }

    public function removeExistingImage($imageId)
    {
        $this->existingImages = array_filter($this->existingImages, fn($img) => $img['id'] != $imageId);
        $this->emitImageUpdate();
    }

    public function removeNewImage($index)
    {
        array_splice($this->newImages, $index, 1);
        $this->emitImageUpdate();
    }

    public function clearMainThumbnail()
    {
        $this->mainProductThumbnail = null;
        $this->emitImageUpdate();
    }

    private function emitImageUpdate()
    {
        $this->emitUp(
            'product-images-updated',
            $this->mainProductThumbnail,
            $this->newImages,
            $this->existingImages
        );
    }

    public function render()
    {
        return view('livewire.product.product-images');
    }
}
