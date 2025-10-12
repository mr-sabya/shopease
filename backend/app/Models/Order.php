<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Enums\PaymentStatus; // We'll create these enums
use App\Enums\OrderStatus;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vendor_id',
        'coupon_id',
        'order_number',
        'billing_first_name',
        'billing_last_name',
        'billing_email',
        'billing_phone',
        'billing_address_line_1',
        'billing_address_line_2',
        'billing_city',
        'billing_state',
        'billing_zip_code',
        'billing_country',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_email',
        'shipping_phone',
        'shipping_address_line_1',
        'shipping_address_line_2',
        'shipping_city',
        'shipping_state',
        'shipping_zip_code',
        'shipping_country',
        'subtotal',
        'discount_amount',
        'shipping_cost',
        'tax_amount',
        'total_amount',
        'currency',
        'payment_method',
        'payment_status',
        'order_status',
        'shipping_method',
        'tracking_number',
        'notes',
        'placed_at',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'payment_status' => PaymentStatus::class, // Cast to Enum
        'order_status' => OrderStatus::class,     // Cast to Enum
        'placed_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /**
     * The "booting" method of the model.
     * Generate unique order number upon creation.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                // Generate a unique order number, e.g., ORD-YEAR-RANDOM
                $order->order_number = 'ORD-' . date('Y') . '-' . Str::upper(Str::random(8));
                // You might want to add a loop to ensure true uniqueness in a high-traffic scenario
                // while (static::where('order_number', $order->order_number)->exists()) {
                //     $order->order_number = 'ORD-' . date('Y') . '-' . Str::upper(Str::random(8));
                // }
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the customer who placed the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the primary vendor for this order (optional, for single-vendor orders).
     */
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    /**
     * Get the coupon applied to this order.
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get the order items for the order.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the transactions related to this order.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class); // Assuming a Transaction model
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePaid($query)
    {
        return $query->where('payment_status', PaymentStatus::Paid);
    }

    public function scopePending($query)
    {
        return $query->where('order_status', OrderStatus::Pending);
    }

    // Add more scopes for other statuses as needed

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Check if the order is fully paid.
     */
    public function isPaid(): bool
    {
        return $this->payment_status === PaymentStatus::Paid;
    }

    /**
     * Get the full billing address as a formatted string.
     */
    public function getFullBillingAddressAttribute(): string
    {
        $address = "{$this->billing_address_line_1}";
        if ($this->billing_address_line_2) {
            $address .= ", {$this->billing_address_line_2}";
        }
        $address .= ", {$this->billing_city}, {$this->billing_state} {$this->billing_zip_code}, {$this->billing_country}";
        return $address;
    }

    /**
     * Get the full shipping address as a formatted string.
     */
    public function getFullShippingAddressAttribute(): string
    {
        $address = "{$this->shipping_address_line_1}";
        if ($this->shipping_address_line_2) {
            $address .= ", {$this->shipping_address_line_2}";
        }
        $address .= ", {$this->shipping_city}, {$this->shipping_state} {$this->shipping_zip_code}, {$this->shipping_country}";
        return $address;
    }
}
