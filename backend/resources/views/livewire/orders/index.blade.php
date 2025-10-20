<div class="py-4">
    <h2 class="mb-4">Order Management</h2>

    @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Order List</h5>
            {{-- <button wire:click="create" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create New Order
            </button> --}}
            {{-- Typically orders are created from the frontend/checkout, not directly here --}}
        </div>
        <div class="card-body">
            <div class="row align-items-center mb-3">
                <div class="col-md-6 col-lg-4 mb-2 mb-md-0">
                    <input type="text" class="form-control" placeholder="Search by order #, email, customer..." wire:model.live.debounce.300ms="search">
                </div>
                <div class="col-md-6 col-lg-8 d-flex justify-content-md-end justify-content-start mt-2 mt-md-0">
                    <div class="d-flex align-items-center gap-2">
                        <select wire:model.live="perPage" class="form-select w-auto">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <span class="text-nowrap">Per Page</span>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered mb-0">
                    <thead>
                        <tr>
                            <th wire:click="sortBy('order_number')" style="cursor: pointer;">
                                Order #
                                @if ($sortField == 'order_number')
                                <i class="fas fa-{{ $sortDirection == 'asc' ? 'sort-up' : 'sort-down' }}"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('user_id')" style="cursor: pointer;">
                                Customer
                                @if ($sortField == 'user_id')
                                <i class="fas fa-{{ $sortDirection == 'asc' ? 'sort-up' : 'sort-down' }}"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('total_amount')" style="cursor: pointer;">
                                Total
                                @if ($sortField == 'total_amount')
                                <i class="fas fa-{{ $sortDirection == 'asc' ? 'sort-up' : 'sort-down' }}"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('order_status')" style="cursor: pointer;">
                                Status
                                @if ($sortField == 'order_status')
                                <i class="fas fa-{{ $sortDirection == 'asc' ? 'sort-up' : 'sort-down' }}"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('payment_status')" style="cursor: pointer;">
                                Payment
                                @if ($sortField == 'payment_status')
                                <i class="fas fa-{{ $sortDirection == 'asc' ? 'sort-up' : 'sort-down' }}"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('placed_at')" style="cursor: pointer;">
                                Date
                                @if ($sortField == 'placed_at')
                                <i class="fas fa-{{ $sortDirection == 'asc' ? 'sort-up' : 'sort-down' }}"></i>
                                @endif
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->user->name ?? $order->billing_first_name . ' ' . $order->billing_last_name }}</td>
                            <td>{{ $order->currency }} {{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <span class="badge {{ $order->order_status->badgeColor() }}">
                                    {{ $order->order_status->label() }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{
                                    $order->payment_status == PaymentStatus::Paid ? 'bg-success' :
                                    ($order->payment_status == PaymentStatus::Pending ? 'bg-warning' :
                                    ($order->payment_status == PaymentStatus::Failed ? 'bg-danger' : 'bg-secondary'))
                                }}">
                                    {{ $order->payment_status->label() }}
                                </span>
                            </td>
                            <td>{{ $order->placed_at?->format('Y-m-d H:i') ?? 'N/A' }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" wire:click="viewOrderDetails({{ $order->id }})" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-primary" wire:click="openStatusUpdateModal({{ $order->id }})" title="Update Status">
                                    <i class="fas fa-redo"></i>
                                </button>
                                {{-- Add delete button if necessary --}}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No orders found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    </div>

    {{-- Order Details Modal --}}
    <div class="modal fade" id="order-details-modal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeOrderDetailsModal"></button>
                </div>
                <div class="modal-body">
                    @if ($showOrderDetailsModal && $selectedOrderId)
                    {{-- Here we'll embed the OrderDetails component --}}
                    {{-- This is a pattern for dynamic component loading within a modal --}}
                    <livewire:orders.manage :orderId="$selectedOrderId" wire:key="order-{{ $selectedOrderId }}" />
                    @else
                    <p>Select an order to view details.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeOrderDetailsModal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Order Status Update Modal --}}
    <div class="modal fade" id="status-update-modal" tabindex="-1" aria-labelledby="statusUpdateModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusUpdateModalLabel">Update Order Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeStatusUpdateModal"></button>
                </div>
                <form wire:submit.prevent="updateOrderStatus">
                    <div class="modal-body">
                        @if ($updateOrderId)
                        <div class="mb-3">
                            <label for="newOrderStatus" class="form-label">Order Status</label>
                            <select class="form-select @error('newOrderStatus') is-invalid @enderror" id="newOrderStatus" wire:model.defer="newOrderStatus">
                                @foreach($orderStatuses as $status)
                                <option value="{{ $status->value }}">{{ $status->label() }}</option>
                                @endforeach
                            </select>
                            @error('newOrderStatus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="newPaymentStatus" class="form-label">Payment Status</label>
                            <select class="form-select @error('newPaymentStatus') is-invalid @enderror" id="newPaymentStatus" wire:model.defer="newPaymentStatus">
                                @foreach($paymentStatuses as $status)
                                <option value="{{ $status->value }}">{{ $status->label() }}</option>
                                @endforeach
                            </select>
                            @error('newPaymentStatus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        @else
                        <p>No order selected for status update.</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeStatusUpdateModal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading wire:target="updateOrderStatus" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        // Order Details Modal
        const orderDetailsModalElement = document.getElementById('order-details-modal');
        const orderDetailsModal = new bootstrap.Modal(orderDetailsModalElement);

        Livewire.on('open-order-details-modal', () => {
            orderDetailsModal.show();
        });

        Livewire.on('close-order-details-modal', () => {
            orderDetailsModal.hide();
        });

        // Order Status Update Modal
        const statusUpdateModalElement = document.getElementById('status-update-modal');
        const statusUpdateModal = new bootstrap.Modal(statusUpdateModalElement);

        Livewire.on('open-status-update-modal', () => {
            statusUpdateModal.show();
        });

        Livewire.on('close-status-update-modal', () => {
            statusUpdateModal.hide();
        });
    });
</script>