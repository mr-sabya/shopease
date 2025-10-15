<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SpecificationsManager extends Component
{
    public Product $product;
    public $availableAttributes; // All active attributes
    public $selectedSpecs = []; // Array of [attribute_id => attribute_value_id] for existing specs

    public $newAttributeValueNames = []; // [attribute_id => 'new value string']

    public function mount(Product $product)
    {
        if ($product->isVariable()) {
            abort(404, 'This product is a variable product and does not use static specifications.');
        }

        $this->product = $product;
        $this->availableAttributes = Attribute::active()->orderBy('name')->get();

        $this->loadCurrentSpecifications();
    }

    private function loadCurrentSpecifications()
    {
        $this->selectedSpecs = $this->product->attributeValues()
            ->get()
            ->keyBy('attribute_id')
            ->map(function ($value) {
                return $value->id;
            })
            ->toArray();
    }

    protected function rules()
    {
        $rules = [
            'selectedSpecs' => ['nullable', 'array'],
            'selectedSpecs.*' => ['nullable', 'exists:attribute_values,id'],
            'newAttributeValueNames.*' => ['nullable', 'string', 'max:255'],
        ];

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

            // Automatically select this new value for the product
            $this->selectedSpecs[$attributeId] = $attributeValue->id;
            $this->newAttributeValueNames[$attributeId] = ''; // Clear input
            session()->flash('message', "New attribute value '{$value}' added and selected.");
            $this->saveSpecifications(); // Save changes immediately
        }
    }

    public function saveSpecifications()
    {
        $this->validate();

        $attributeValueIdsToAttach = array_values(array_filter($this->selectedSpecs));

        $this->product->attributeValues()->sync($attributeValueIdsToAttach);

        $this->loadCurrentSpecifications(); // Refresh in case of any issues
        session()->flash('message', 'Product specifications updated successfully!');
    }


    public function render()
    {
        // Get attribute values for rendering the select dropdowns
        $attributeOptions = [];
        foreach ($this->availableAttributes as $attribute) {
            $attributeOptions[$attribute->id] = $attribute->values()->orderBy('value')->get();
        }

        return view('livewire.product.specifications-manager', [
            'attributeOptions' => $attributeOptions,
        ]);
    }
}
