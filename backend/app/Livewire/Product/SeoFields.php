<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\Attributes\Locked;

class SeoFields extends Component
{
    #[Locked]
    public $productId;

    public $meta_title;
    public $meta_description;
    public $meta_keywords;

    public function mount(
        $productId,
        $initialMetaTitle,
        $initialMetaDescription,
        $initialMetaKeywords
    ) {
        $this->productId = $productId;
        $this->meta_title = $initialMetaTitle;
        $this->meta_description = $initialMetaDescription;
        $this->meta_keywords = $initialMetaKeywords;
    }

    protected function updated($propertyName)
    {
        if (in_array($propertyName, [
            'meta_title',
            'meta_description',
            'meta_keywords'
        ])) {
            $this->emitUp(
                'seo-fields-updated',
                $this->meta_title,
                $this->meta_description,
                $this->meta_keywords
            );
        }
    }

    public function render()
    {
        return view('livewire.product.seo-fields');
    }
}
