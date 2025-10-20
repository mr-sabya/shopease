<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use Livewire\Component;

class Manage extends Component
{
    public $orderId;
    public $order;

    protected $listeners = ['orderUpdated' => '$refresh']; // If you want to listen for updates from parent/other components

    public function mount($orderId)
    {
        $this->orderId = $orderId;
        $this->loadOrder();
    }

    public function loadOrder()
    {
        $this->order = Order::with(['user', 'vendor', 'coupon', 'orderItems.product', 'orderItems.productVariant'])
                            ->findOrFail($this->orderId);
    }

    public function render()
    {
        return view('livewire.orders.manage');
    }
}