<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\AttributeSet;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;

class ProductAttributes extends Component
{
    #[Locked]
    public $productId;

    public $attributeSetId;
    public $productAttributeValues = []; // [attribute_id => attribute_value_id]

    public $allAttributeSets;
    public $availableAttributes = []; // Attributes for the selected set
    public $availableAttributeValues = []; // Attribute values for specific attribute

    public function mount(
        $productId,
        $initialAttributeSetId,
        $initialProductAttributeValues,
        $allAttributeSets
    ) {
        $this->productId = $productId;
        $this->attributeSetId = $initialAttributeSetId;
        $this->productAttributeValues = $initialProductAttributeValues;
        $this->allAttributeSets = $allAttributeSets;

        if ($this->attributeSetId) {
            $this->loadAttributesForSet();
        }
    }

    public function updatedAttributeSetId()
    {
        $this->loadAttributesForSet();
        $this->productAttributeValues = []; // Reset selected attribute values when set changes
        $this->emitAttributeUpdate();
    }

    public function updatedProductAttributeValues()
    {
        $this->emitAttributeUpdate();
    }

    private function loadAttributesForSet()
    {
        if ($this->attributeSetId) {
            $attributeSet = AttributeSet::with(['attributes.attributeValues' => function ($query) {
                $query->orderBy('value');
            }])->find($this->attributeSetId);

            if ($attributeSet) {
                $this->availableAttributes = $attributeSet->attributes->sortBy('name');
                $this->availableAttributeValues = [];
                foreach ($this->availableAttributes as $attribute) {
                    $this->availableAttributeValues[$attribute->id] = $attribute->attributeValues;
                }
            } else {
                $this->availableAttributes = [];
                $this->availableAttributeValues = [];
            }
        } else {
            $this->availableAttributes = [];
            $this->availableAttributeValues = [];
        }
    }

    private function emitAttributeUpdate()
    {
        $this->emitUp(
            'product-attributes-updated',
            $this->attributeSetId,
            $this->productAttributeValues
        );
    }

    public function render()
    {
        return view('livewire.product.product-attributes');
    }
}
