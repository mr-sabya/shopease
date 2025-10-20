<div>
    @if ($order)
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">Order Summary</div>
                <div class="card-body">
                    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                    <p><strong>Total Amount:</strong> {{ $order->currency }} {{ number_format($order->total_amount, 2) }}</p>
                    <p><strong>Order Status:</strong> <span class="badge {{ $order->order_status->badgeColor() }}">{{ $order->order_status->label() }}</span></p>
                    <p><strong>Payment Status:</strong> <span class="badge {{
                                $order->payment_status == \App\Enums\PaymentStatus::Paid ? 'bg-success' :
                                ($order->payment_status == \App\Enums\PaymentStatus::Pending ? 'bg-warning' :
                                ($order->payment_status == \App\Enums\PaymentStatus::Failed ? 'bg-danger' : 'bg-secondary'))
                            }}">{{ $order->payment_status->label() }}</span></p>
                    <p><strong>Placed At:</strong> {{ $order->placed_at?->format('Y-m-d H:i') ?? 'N/A' }}</p>
                    <p><strong>Shipping Method:</strong> {{ $order->shipping_method ?? 'N/A' }}</p>
                    <p><strong>Tracking Number:</strong> {{ $order->tracking_number ?? 'N/A' }}</p>
                    @if ($order->coupon)
                    <p><strong>Coupon Applied:</strong> {{ $order->coupon->code }} (Discount: {{ $order->currency }} {{ number_format($order->discount_amount, 2) }})</p>
                    @endif
                    @if ($order->notes)
                    <p><strong>Notes:</strong> {{ $order->notes }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">Customer Information</div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $order->user->name ?? $order->billing_first_name . ' ' . $order->billing_last_name }}</p>
                    <p><strong>Email:</strong> {{ $order->billing_email }}</p>
                    <p><strong>Phone:</strong> {{ $order->billing_phone ?? 'N/A' }}</p>
                    <p><strong>Billing Address:</strong> {{ $order->full_billing_address }}</p>
                    <p><strong>Shipping Address:</strong> {{ $order->full_shipping_address }}</p>
                    @if ($order->vendor)
                    <p><strong>Primary Vendor:</strong> {{ $order->vendor->name }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-primary text-white">Order Items</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Attributes</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Discount</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                        <tr>
                            <td>
                                {{ $item->item_name }}
                                @if ($item->product)
                                <br><small class="text-muted">({{ $item->product->name ?? 'N/A' }})</small>
                                @endif
                            </td>
                            <td>{{ $item->item_sku ?? 'N/A' }}</td>
                            <td>{{ $item->formatted_attributes }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $order->currency }} {{ number_format($item->unit_price, 2) }}</td>
                            <td>{{ $order->currency }} {{ number_format($item->item_discount_amount, 2) }}</td>
                            <td>{{ $order->currency }} {{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" class="text-end">Subtotal:</th>
                            <th>{{ $order->currency }} {{ number_format($order->subtotal, 2) }}</th>
                        </tr>
                        @if ($order->discount_amount > 0)
                        <tr>
                            <th colspan="6" class="text-end">Discount:</th>
                            <th>-{{ $order->currency }} {{ number_format($order->discount_amount, 2) }}</th>
                        </tr>
                        @endif
                        @if ($order->shipping_cost > 0)
                        <tr>
                            <th colspan="6" class="text-end">Shipping:</th>
                            <th>{{ $order->currency }} {{ number_format($order->shipping_cost, 2) }}</th>
                        </tr>
                        @endif
                        @if ($order->tax_amount > 0)
                        <tr>
                            <th colspan="6" class="text-end">Tax:</th>
                            <th>{{ $order->currency }} {{ number_format($order->tax_amount, 2) }}</th>
                        </tr>
                        @endif
                        <tr>
                            <th colspan="6" class="text-end">Total:</th>
                            <th>{{ $order->currency }} {{ number_format($order->total_amount, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @else
    <p>Order not found.</p>
    @endif
</div>