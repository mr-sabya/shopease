<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Enums\ProductType;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On; // For parent to child communication if needed
use Livewire\Attributes\Locked;

class GeneralInfo extends Component
{
    #[Locked]
    public $productId;
    public $isEditing;

    public $vendor_id;
    public $category_id;
    public $brand_id;
    public $name;
    public $slug;
    public $short_description;
    public $long_description;
    public $type;
    public $is_active = true;
    public $is_featured = false;
    public $is_new = true;

    public $allVendors;
    public $allCategories;
    public $allBrands;
    public $productTypes;

    public function mount(
        $productId,
        $initialVendorId,
        $initialCategoryId,
        $initialBrandId,
        $initialName,
        $initialSlug,
        $initialShortDescription,
        $initialLongDescription,
        $initialType,
        $initialIsActive,
        $initialIsFeatured,
        $initialIsNew,
        $allVendors,
        $allCategories,
        $allBrands,
        $productTypes
    ) {
        $this->productId = $productId;
        $this->isEditing = !is_null($productId);
        $this->vendor_id = $initialVendorId;
        $this->category_id = $initialCategoryId;
        $this->brand_id = $initialBrandId;
        $this->name = $initialName;
        $this->slug = $initialSlug;
        $this->short_description = $initialShortDescription;
        $this->long_description = $initialLongDescription;
        $this->type = $initialType;
        $this->is_active = (bool) $initialIsActive;
        $this->is_featured = (bool) $initialIsFeatured;
        $this->is_new = (bool) $initialIsNew;

        $this->allVendors = $allVendors;
        $this->allCategories = $allCategories;
        $this->allBrands = $allBrands;
        $this->productTypes = $productTypes;
    }

    // This method ensures the parent component is always aware of the current state
    protected function updated($propertyName)
    {
        // Only emit if the property is directly managed by this component
        if (in_array($propertyName, [
            'vendor_id',
            'category_id',
            'brand_id',
            'name',
            'slug',
            'short_description',
            'long_description',
            'type',
            'is_active',
            'is_featured',
            'is_new'
        ])) {
            $this->emitUp(
                'general-info-updated',
                $this->vendor_id,
                $this->category_id,
                $this->brand_id,
                $this->name,
                $this->slug,
                $this->short_description,
                $this->long_description,
                $this->type,
                $this->is_active,
                $this->is_featured,
                $this->is_new
            );
        }

        // Special handling for slug generation
        if ($propertyName === 'name') {
            if (empty($this->slug) || Str::slug($this->name) === $this->slug) {
                $this->slug = Str::slug($this->name);
                $this->emitUp(
                    'general-info-updated',
                    $this->vendor_id,
                    $this->category_id,
                    $this->brand_id,
                    $this->name,
                    $this->slug,
                    $this->short_description,
                    $this->long_description,
                    $this->type,
                    $this->is_active,
                    $this->is_featured,
                    $this->is_new
                );
            }
        }
        // If type changes, the parent needs to react
        if ($propertyName === 'type') {
            // Parent handles the resetting of other product type fields
        }
    }

    public function render()
    {
        return view('livewire.product.general-info');
    }
}
