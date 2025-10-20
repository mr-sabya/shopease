<?php

namespace App\Livewire\Orders;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'placed_at';
    public $sortDirection = 'desc';

    // State for viewing details (optional, could be a separate page/component)
    public $showOrderDetailsModal = false;
    public $selectedOrderId;

    // State for quick status update (optional)
    public $showStatusUpdateModal = false;
    public $updateOrderId;
    public $newOrderStatus;
    public $newPaymentStatus;

    protected $queryString = ['search', 'perPage', 'sortField', 'sortDirection'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function viewOrderDetails($orderId)
    {
        $this->selectedOrderId = $orderId;
        $this->showOrderDetailsModal = true;
        $this->dispatch('open-order-details-modal'); // Dispatch event for Bootstrap modal
    }

    public function closeOrderDetailsModal()
    {
        $this->showOrderDetailsModal = false;
        $this->selectedOrderId = null;
        $this->dispatch('close-order-details-modal'); // Dispatch event to close modal
    }

    // --- Status Update Modal (Optional, for quick edits) ---
    public function openStatusUpdateModal($orderId)
    {
        $order = Order::findOrFail($orderId);
        $this->updateOrderId = $orderId;
        $this->newOrderStatus = $order->order_status->value;
        $this->newPaymentStatus = $order->payment_status->value;
        $this->showStatusUpdateModal = true;
        $this->dispatch('open-status-update-modal');
    }

    public function updateOrderStatus()
    {
        $this->validate([
            'newOrderStatus' => 'required|in:' . implode(',', OrderStatus::values()),
            'newPaymentStatus' => 'required|in:' . implode(',', PaymentStatus::values()),
        ]);

        $order = Order::findOrFail($this->updateOrderId);
        $order->order_status = OrderStatus::from($this->newOrderStatus);
        $order->payment_status = PaymentStatus::from($this->newPaymentStatus);
        $order->save();

        session()->flash('message', 'Order status updated successfully.');
        $this->closeStatusUpdateModal();
        $this->resetPage(); // Refresh list
    }

    public function closeStatusUpdateModal()
    {
        $this->showStatusUpdateModal = false;
        $this->updateOrderId = null;
        $this->newOrderStatus = null;
        $this->newPaymentStatus = null;
        $this->dispatch('close-status-update-modal');
    }
    // --------------------------------------------------------

    public function render()
    {
        $orders = Order::query()
            ->when($this->search, function ($query) {
                $query->where('order_number', 'like', '%' . $this->search . '%')
                      ->orWhere('billing_email', 'like', '%' . $this->search . '%')
                      ->orWhere('total_amount', 'like', '%' . $this->search . '%')
                      ->orWhereHas('user', function ($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.orders.index', [
            'orders' => $orders,
            'orderStatuses' => OrderStatus::cases(), // For dropdowns
            'paymentStatuses' => PaymentStatus::cases(), // For dropdowns
        ]);
    }
}