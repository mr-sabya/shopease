<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Livewire\Attributes\Locked;

class ProductVariants extends Component
{
    use WithFileUploads;

    #[Locked]
    public $productId;

    public $is_manage_stock; // From parent
    public $variantDefiningAttributes = []; // Array of Attribute models for defining variants
    public $variants = []; // Structured array for variant data
    public $variantsToDelete = []; // IDs of variants to be deleted

    public $availableVariantAttributes; // All attributes that can be used for variants

    public $newVariantAttributeId; // For adding a new defining attribute

    public function mount(
        $productId,
        $initialIsManageStock,
        $initialVariants,
        $initialVariantDefiningAttributes,
        $availableVariantAttributes
    ) {
        $this->productId = $productId;
        $this->is_manage_stock = (bool) $initialIsManageStock;
        $this->variants = $initialVariants;
        $this->variantDefiningAttributes = $initialVariantDefiningAttributes;
        $this->availableVariantAttributes = $availableVariantAttributes;

        // Ensure each variant has 'new_images' property
        foreach ($this->variants as $index => $variant) {
            if (!isset($this->variants[$index]['new_images'])) {
                $this->variants[$index]['new_images'] = [];
            }
        }
    }

    public function updated($propertyName)
    {
        // Intercept updates on `is_manage_stock` from parent to update local value
        if ($propertyName === 'is_manage_stock') {
            $this->emitVariantUpdate(); // Re-emit if stock management changes
        } else if (
            str_starts_with($propertyName, 'variants') ||
            str_starts_with($propertyName, 'variantDefiningAttributes')
        ) {
            $this->emitVariantUpdate();
        }
    }

    // This method will be triggered by ProductManager when its is_manage_stock changes
    public function setIsManageStock($value)
    {
        $this->is_manage_stock = (bool) $value;
        // No need to emitUp here, as this is a prop setter
    }


    public function addVariantDefiningAttribute()
    {
        if (
            $this->newVariantAttributeId &&
            !collect($this->variantDefiningAttributes)->pluck('id')->contains($this->newVariantAttributeId)
        ) {

            $attribute = Attribute::with('attributeValues')->find($this->newVariantAttributeId);
            if ($attribute) {
                $this->variantDefiningAttributes[] = [
                    'id' => $attribute->id,
                    'name' => $attribute->name,
                    'display_type' => $attribute->display_type,
                    'attribute_values' => $attribute->attributeValues->map(fn($val) => ['id' => $val->id, 'value' => $val->value])->toArray(),
                ];
                $this->newVariantAttributeId = null; // Reset selector
                $this->generateVariants(); // Regenerate variants after adding
            }
        }
    }

    public function removeVariantDefiningAttribute($index)
    {
        // Add the attribute to the available list if it was a custom attribute for variants
        // Not strictly needed here, as we reload availableVariantAttributes on mount, but good practice
        $removedAttrId = $this->variantDefiningAttributes[$index]['id'];
        $removedAttribute = Attribute::find($removedAttrId);
        if ($removedAttribute && !collect($this->availableVariantAttributes)->pluck('id')->contains($removedAttrId)) {
            $this->availableVariantAttributes[] = $removedAttribute->toArray();
        }

        array_splice($this->variantDefiningAttributes, $index, 1);
        $this->generateVariants(); // Regenerate variants as a defining attribute was removed
    }

    public function generateVariants()
    {
        $newVariants = [];
        $attributeValueGroups = [];

        foreach ($this->variantDefiningAttributes as $attr) {
            if (isset($attr['attribute_values']) && count($attr['attribute_values']) > 0) {
                // Only use attribute values that have actually been loaded / attached to the attribute
                $attributeValueGroups[] = collect($attr['attribute_values'])->map(function ($av) use ($attr) {
                    return ['attribute_id' => $attr['id'], 'attribute_value_id' => $av['id'], 'value' => $av['value'], 'attribute_name' => $attr['name']];
                })->toArray();
            }
        }

        if (empty($attributeValueGroups)) {
            $this->variants = [];
            $this->emitVariantUpdate();
            return;
        }

        $combinations = $this->generateCombinations($attributeValueGroups);

        foreach ($combinations as $combination) {
            $attributeValueIds = collect($combination)->pluck('attribute_value_id')->sort()->values()->toArray();
            $attributeValueMap = collect($combination)->mapWithKeys(fn($item) => [$item['attribute_id'] => $item['attribute_value_id']])->toArray();

            // Try to find an existing variant with these attribute value IDs
            $existingVariant = collect($this->variants)->first(function ($variant) use ($attributeValueIds) {
                // Compare sorted IDs
                return collect($variant['attribute_value_ids'])->sort()->values()->toArray() === $attributeValueIds;
            });

            if ($existingVariant) {
                // Ensure existing variant also has new_images property if it's missing (e.g., on initial load)
                if (!isset($existingVariant['new_images'])) {
                    $existingVariant['new_images'] = [];
                }
                $newVariants[] = $existingVariant; // Keep existing variant data
            } else {
                $variantNameParts = collect($combination)->pluck('value')->join(' / ');

                $newVariants[] = [
                    'id' => null, // New variant
                    'sku' => null,
                    'price' => 0.00,
                    'compare_at_price' => null,
                    'cost_price' => 0.00,
                    'quantity' => 0,
                    'weight' => 0.00,
                    'is_active' => true,
                    'attribute_value_ids' => $attributeValueIds,
                    'attribute_value_map' => $attributeValueMap, // For display
                    'variant_name' => $variantNameParts, // For display
                    'images' => [], // Existing variant images (none for new variants)
                    'new_images' => [], // New uploads for this variant
                ];
            }
        }

        $this->variants = $newVariants;
        $this->emitVariantUpdate();
    }


    private function generateCombinations($arrays)
    {
        $result = [[]];
        foreach ($arrays as $key => $values) {
            $tmp = [];
            foreach ($result as $res) {
                foreach ($values as $value) {
                    $tmp[] = array_merge($res, [$value]);
                }
            }
            $result = $tmp;
        }
        return $result;
    }

    public function removeVariant($index)
    {
        // If it's an existing variant, mark for deletion from DB
        if (isset($this->variants[$index]['id']) && $this->variants[$index]['id'] !== null) {
            $this->variantsToDelete[] = $this->variants[$index]['id'];
        }
        array_splice($this->variants, $index, 1); // Remove from display
        $this->emitVariantUpdate();
    }

    public function removeVariantImage($variantIndex, $imageIndex)
    {
        // This assumes images are stored directly in the `variants` array as paths/URLs
        // You might need a more complex structure if images have IDs for deletion
        array_splice($this->variants[$variantIndex]['images'], $imageIndex, 1);
        $this->emitVariantUpdate();
    }

    public function removeNewVariantImage($variantIndex, $newImageIndex)
    {
        array_splice($this->variants[$variantIndex]['new_images'], $newImageIndex, 1);
        $this->emitVariantUpdate();
    }

    private function emitVariantUpdate()
    {
        $this->emitUp(
            'product-variants-updated',
            $this->variantDefiningAttributes,
            $this->variants,
            $this->variantsToDelete
        );
    }

    public function render()
    {
        return view('livewire.product.product-variants');
    }
}
