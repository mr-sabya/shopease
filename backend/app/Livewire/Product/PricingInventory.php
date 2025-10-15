<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\Attributes\Locked;

class PricingInventory extends Component
{
    #[Locked]
    public $productId;

    public $sku;
    public $price;
    public $compare_at_price;
    public $cost_price;
    public $quantity;
    public $weight;
    public $is_manage_stock = true;
    public $min_order_quantity = 1;
    public $max_order_quantity;

    public function mount(
        $productId,
        $initialSku,
        $initialPrice,
        $initialCompareAtPrice,
        $initialCostPrice,
        $initialQuantity,
        $initialWeight,
        $initialIsManageStock,
        $initialMinOrderQuantity,
        $initialMaxOrderQuantity
    ) {
        $this->productId = $productId;
        $this->sku = $initialSku;
        $this->price = $initialPrice ?? 0.00;
        $this->compare_at_price = $initialCompareAtPrice;
        $this->cost_price = $initialCostPrice ?? 0.00;
        $this->quantity = $initialQuantity ?? 0;
        $this->weight = $initialWeight ?? 0.00;
        $this->is_manage_stock = (bool) $initialIsManageStock;
        $this->min_order_quantity = $initialMinOrderQuantity ?? 1;
        $this->max_order_quantity = $initialMaxOrderQuantity;
    }

    protected function updated($propertyName)
    {
        // Only emit if the property is directly managed by this component
        if (in_array($propertyName, [
            'sku',
            'price',
            'compare_at_price',
            'cost_price',
            'quantity',
            'weight',
            'is_manage_stock',
            'min_order_quantity',
            'max_order_quantity'
        ])) {
            $this->emitUp(
                'pricing-inventory-updated',
                $this->sku,
                $this->price,
                $this->compare_at_price,
                $this->cost_price,
                $this->quantity,
                $this->weight,
                $this->is_manage_stock,
                $this->min_order_quantity,
                $this->max_order_quantity
            );
        }
    }

    public function render()
    {
        return view('livewire.product.pricing-inventory');
    }
}
