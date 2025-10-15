<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class VariantsManager extends Component
{
    use WithFileUploads;

    public Product $product;
    public $availableAttributes; // All active attributes
    public $selectedAttributeIds = []; // IDs of attributes chosen for variations (e.g., [1, 2] for Color, Size)

    // For managing attribute values per selected attribute
    public $attributeValuesToManage = []; // Structure: [attribute_id => [AttributeValueModel, ...]]

    // For creating new attribute values on the fly
    public $newAttributeValueNames = []; // Structure: [attribute_id => 'new value string']

    // Change this line:
    public Collection $variants; // <-- Initialize as Collection, not array

    // For editing individual variant fields (use key-value pair based on variant ID)
    public $variantSku = [];
    public $variantPrice = [];
    public $variantCompareAtPrice = [];
    public $variantCostPrice = [];
    public $variantQuantity = [];
    public $variantWeight = [];
    public $variantIsActive = [];
    public $variantNewImage = []; // For variant specific image upload

    public function mount(Product $product)
    {
        if (!$product->isVariable()) {
            abort(404, 'This product is not a variable product.');
        }

        $this->product = $product;
        $this->availableAttributes = Attribute::active()->get();

        // Load existing variant attributes and their values if editing
        $this->loadExistingVariantData();
    }

    private function loadExistingVariantData()
    {
        $this->variants = $this->product->variants()->with('attributeValues.attribute')->get();

        $attributeIdsFromVariants = [];
        foreach ($this->variants as $variant) {
            foreach ($variant->attributeValues as $attrValue) {
                $attributeIdsFromVariants[$attrValue->attribute->id] = true;
                // Initialize attributeValuesToManage
                if (!isset($this->attributeValuesToManage[$attrValue->attribute->id])) {
                    $this->attributeValuesToManage[$attrValue->attribute->id] = [];
                }
                $this->attributeValuesToManage[$attrValue->attribute->id][$attrValue->id] = $attrValue;
            }

            // Initialize variant fields
            $this->variantSku[$variant->id] = $variant->sku;
            $this->variantPrice[$variant->id] = $variant->price;
            $this->variantCompareAtPrice[$variant->id] = $variant->compare_at_price;
            $this->variantCostPrice[$variant->id] = $variant->cost_price;
            $this->variantQuantity[$variant->id] = $variant->quantity;
            $this->variantWeight[$variant->id] = $variant->weight;
            $this->variantIsActive[$variant->id] = $variant->is_active;
        }

        $this->selectedAttributeIds = array_keys($attributeIdsFromVariants);

        // Ensure all unique attribute values used by current variants are loaded into attributeValuesToManage
        foreach ($this->selectedAttributeIds as $attrId) {
            if (!isset($this->attributeValuesToManage[$attrId])) {
                $this->attributeValuesToManage[$attrId] = [];
            }
            $existingValues = $this->product->variants->pluck('attributeValues')->flatten()
                ->where('attribute_id', $attrId)
                ->unique('id');
            foreach ($existingValues as $value) {
                $this->attributeValuesToManage[$attrId][$value->id] = $value;
            }
        }
    }


    protected function rules()
    {
        $rules = [
            'selectedAttributeIds' => ['nullable', 'array'],
            'selectedAttributeIds.*' => ['exists:attributes,id'],
            'attributeValuesToManage' => ['nullable', 'array'],
            'attributeValuesToManage.*.*' => ['nullable', 'array'], // Each attribute's value array
            'newAttributeValueNames.*' => ['nullable', 'string', 'max:255'],
            'variants.*.sku' => ['nullable', 'string', 'max:255'], // No unique rule here as SKUs can be duplicated if not managed
            'variants.*.price' => ['required', 'numeric', 'min:0'],
            'variants.*.quantity' => ['required', 'integer', 'min:0'],
            'variantSku.*' => ['nullable', 'string', 'max:255', Rule::unique('product_variants', 'sku')->ignore(array_keys($this->variantSku))], // Dynamically ignore current variant SKUs
            'variantPrice.*' => ['required', 'numeric', 'min:0'],
            'variantCompareAtPrice.*' => ['nullable', 'numeric', 'min:0', 'gte:variantPrice.*'],
            'variantCostPrice.*' => ['nullable', 'numeric', 'min:0', 'lte:variantPrice.*'],
            'variantQuantity.*' => ['required', 'integer', 'min:0'],
            'variantWeight.*' => ['nullable', 'numeric', 'min:0'],
            'variantIsActive.*' => ['boolean'],
            'variantNewImage.*' => ['nullable', 'image', 'max:2048'],
        ];

        // Ensure new values for an attribute are unique within that attribute
        foreach ($this->newAttributeValueNames as $attributeId => $value) {
            if (!empty($value)) {
                $rules['newAttributeValueNames.' . $attributeId] = [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('attribute_values', 'value')
                        ->where(fn($query) => $query->where('attribute_id', $attributeId))
                ];
            }
        }

        return $rules;
    }

    public function updatedSelectedAttributeIds()
    {
        // When selected attributes change, clear old managed values and new value inputs
        $this->attributeValuesToManage = [];
        $this->newAttributeValueNames = [];

        // For each selected attribute, load its existing values
        foreach ($this->selectedAttributeIds as $attributeId) {
            $this->attributeValuesToManage[$attributeId] = Attribute::find($attributeId)->values()->get()->keyBy('id');
        }
        $this->generateVariants(); // Regenerate variants based on new selection
    }


    public function addAttributeValue($attributeId)
    {
        $this->validate([
            "newAttributeValueNames.$attributeId" => [
                'required',
                'string',
                'max:255',
                Rule::unique('attribute_values', 'value')
                    ->where(fn($query) => $query->where('attribute_id', $attributeId))
            ]
        ]);

        $attribute = Attribute::find($attributeId);
        if ($attribute) {
            $value = $this->newAttributeValueNames[$attributeId];
            $attributeValue = $attribute->values()->create([
                'value' => $value,
                'slug' => Str::slug($value),
            ]);

            $this->attributeValuesToManage[$attributeId][$attributeValue->id] = $attributeValue;
            $this->newAttributeValueNames[$attributeId] = ''; // Clear input
            $this->generateVariants(); // Regenerate variants with new value
            session()->flash('message', "Attribute value '{$value}' added.");
        }
    }

    public function removeAttributeValue($attributeId, $attributeValueId)
    {
        // First check if this attribute value is used by any existing variant
        $variantCount = DB::table('product_variant_attribute_value')
            ->where('attribute_value_id', $attributeValueId)
            ->whereIn('product_variant_id', $this->product->variants->pluck('id'))
            ->count();

        if ($variantCount > 0) {
            session()->flash('error', 'Cannot remove attribute value as it is currently used by one or more product variants. Please delete those variants first.');
            return;
        }

        unset($this->attributeValuesToManage[$attributeId][$attributeValueId]);
        $this->generateVariants(); // Regenerate variants after removal
        session()->flash('message', 'Attribute value removed from selection.');
    }


    public function generateVariants()
    {
        $attributeValueCombinations = $this->getAttributeValueCombinations();

        $newVariants = new Collection(); // <-- Ensure newVariants is also a Collection

        if (empty($attributeValueCombinations)) {
            $this->variants = new Collection(); // <-- Ensure it's an empty Collection
            return;
        }

        foreach ($attributeValueCombinations as $combination) {
            $valueIds = collect($combination)->pluck('id')->sort()->toArray();
            $displayName = collect($combination)->pluck('value')->implode(', ');

            // Try to find an existing variant with this combination
            $existingVariant = $this->variants->first(function ($variant) use ($valueIds) {
                return collect($variant->attributeValues)->pluck('id')->sort()->toArray() === $valueIds;
            });

            if ($existingVariant) {
                $newVariants->push($existingVariant);
            } else {
                // Create a new temporary variant object
                $tempVariant = new ProductVariant([
                    'product_id' => $this->product->id,
                    'sku' => $this->product->sku . '-' . Str::slug($displayName), // Auto-generate simple SKU
                    'price' => $this->product->price ?? 0,
                    'quantity' => 0,
                    'is_active' => true,
                ]);
                $tempVariant->setRelation('attributeValues', collect($combination)); // Attach attribute values for display
                $newVariants->push($tempVariant);
            }
        }
        $this->variants = $newVariants;

        // Re-populate individual variant data for new variants
        foreach ($this->variants as $variant) {
            if (!isset($this->variantSku[$variant->id])) { // Only if it's a new or unsaved variant
                $this->variantSku[$variant->id] = $variant->sku;
                $this->variantPrice[$variant->id] = $variant->price;
                $this->variantCompareAtPrice[$variant->id] = $variant->compare_at_price;
                $this->variantCostPrice[$variant->id] = $variant->cost_price;
                $this->variantQuantity[$variant->id] = $variant->quantity;
                $this->variantWeight[$variant->id] = $variant->weight;
                $this->variantIsActive[$variant->id] = $variant->is_active;
            }
        }

        session()->flash('message', 'Variant combinations generated/updated.');
    }


    private function getAttributeValueCombinations($index = 0, $currentCombination = [])
    {
        $selectedAttrsWithValues = [];
        foreach ($this->selectedAttributeIds as $attrId) {
            if (isset($this->attributeValuesToManage[$attrId]) && !empty($this->attributeValuesToManage[$attrId])) {
                $selectedAttrsWithValues[] = array_values($this->attributeValuesToManage[$attrId]);
            }
        }

        if (empty($selectedAttrsWithValues)) {
            return [];
        }

        if ($index === count($selectedAttrsWithValues)) {
            return [$currentCombination];
        }

        $combinations = [];
        foreach ($selectedAttrsWithValues[$index] as $value) {
            $combinations = array_merge($combinations, $this->getAttributeValueCombinations(
                $index + 1,
                array_merge($currentCombination, [$value])
            ));
        }

        return $combinations;
    }


    public function saveVariants()
    {
        $this->validate();

        DB::transaction(function () {
            $updatedVariantIds = [];

            foreach ($this->variants as $index => $variant) {
                $attributeValues = $variant->attributeValues->pluck('id')->toArray();
                $displayName = $variant->attributeValues->pluck('value')->implode(', ');

                // Handle variant image upload
                $imagePath = $variant->image_path; // Keep existing path by default
                if (isset($this->variantNewImage[$index]) && $this->variantNewImage[$index]) {
                    if ($imagePath) { // Delete old image if exists
                        Storage::disk('public')->delete($imagePath);
                    }
                    $imagePath = $this->variantNewImage[$index]->store('products/variants', 'public');
                }

                $variantData = [
                    'product_id' => $this->product->id,
                    'sku' => $this->variantSku[$variant->id] ?? null,
                    'price' => $this->variantPrice[$variant->id],
                    'compare_at_price' => $this->variantCompareAtPrice[$variant->id] ?? null,
                    'cost_price' => $this->variantCostPrice[$variant->id] ?? null,
                    'quantity' => $this->variantQuantity[$variant->id],
                    'weight' => $this->variantWeight[$variant->id] ?? null,
                    'image_path' => $imagePath, // Save the image path
                    'is_active' => $this->variantIsActive[$variant->id] ?? true,
                ];

                if ($variant->exists) {
                    $variant->update($variantData);
                } else {
                    $variant = $this->product->variants()->create($variantData);
                    // Manually attach attribute values for new variant
                    $variant->attributeValues()->attach($attributeValues);
                }
                $updatedVariantIds[] = $variant->id;
            }

            // Delete any variants that are no longer in the generated list
            $this->product->variants()->whereNotIn('id', $updatedVariantIds)->delete();
        });

        $this->loadExistingVariantData(); // Reload all data including images and updated details
        session()->flash('message', 'Product variants saved successfully!');
    }

    public function deleteVariant($variantId)
    {
        $variant = ProductVariant::find($variantId);
        if ($variant) {
            if ($variant->image_path) {
                Storage::disk('public')->delete($variant->image_path);
            }
            $variant->delete();
            $this->loadExistingVariantData(); // Refresh the list
            session()->flash('message', 'Variant deleted successfully!');
        }
    }


    public function render()
    {
        return view('livewire.product.variants-manager');
    }
}
