<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // For slug generation
use App\Enums\ProductType; // We'll create this enum next
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'brand_id',
        'name',
        'slug',
        'short_description',
        'long_description',
        'thumbnail_image_path',
        'type',
        'sku',
        'price',
        'compare_at_price',
        'cost_price',
        'quantity',
        'weight',
        'is_active',
        'is_featured',
        'is_new',
        'is_manage_stock',
        'min_order_quantity',
        'max_order_quantity',
        'seo_title',
        'seo_description',
        'affiliate_url',
        'digital_file',
        'download_limit',
        'download_expiry_days',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'quantity' => 'integer',
        'weight' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
        'is_manage_stock' => 'boolean',
        'min_order_quantity' => 'integer',
        'max_order_quantity' => 'integer',
        'download_limit' => 'integer',
        'download_expiry_days' => 'integer',
        'type' => ProductType::class, // Cast to ProductType Enum
    ];

    /**
     * The "booting" method of the model.
     * Automatically generate slug.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function ($product) {
            if (empty($product->slug) && $product->isDirty('name')) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the vendor that owns the product.
     */
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    /**
     * A product can belong to many categories.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    /**
     * Get the brand that the product belongs to.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the images for the product.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the variants for the product (if it's a variable product).
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class)->orderBy('id');
    }

    /**
     * Get the reviews for the product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the tags associated with the product.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class); // Using default pivot table 'product_tag'
    }

    /**
     * Get the attribute values for non-variable products (e.g., specifications).
     */
    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_attribute_value');
    }

    /**
     * Get the order items associated with this product.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the downloads for this digital product.
     */
    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOfType($query, ProductType $type)
    {
        return $query->where('type', $type->value);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Get the main thumbnail image URL for the product.
     */
    // Add this accessor for convenience
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail_image_path ? Storage::disk('public')->url($this->thumbnail_image_path) : null;
    }

    /**
     * Check if the product is a normal product.
     */
    public function isNormal(): bool
    {
        return $this->type->isNormal();
    }

    /**
     * Check if the product is a variable product.
     */
    public function isVariable(): bool
    {
        return $this->type->isVariable();
    }

    /**
     * Check if the product is an affiliate product.
     */
    public function isAffiliate(): bool
    {
        return $this->type->isAffiliate();
    }

    /**
     * Check if the product is a digital product.
     */
    public function isDigital(): bool
    {
        return $this->type->isDigital();
    }

    /**
     * Get the current stock for the product (considers variants if applicable).
     */
    public function getCurrentStockAttribute(): int
    {
        if ($this->isVariable()) {
            return $this->variants()->sum('quantity');
        }
        return $this->quantity;
    }
}
