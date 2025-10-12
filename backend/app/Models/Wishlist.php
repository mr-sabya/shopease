<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the user that owns the wishlist.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the products in the wishlist.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_wishlist')
            ->withPivot('added_at') // Include the added_at timestamp from the pivot
            ->withTimestamps(); // Also manages created_at/updated_at on the pivot table
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Add a product to the wishlist.
     */
    public function addProduct(Product $product): bool
    {
        if (!$this->products()->where('product_id', $product->id)->exists()) {
            $this->products()->attach($product->id, ['added_at' => now()]);
            return true;
        }
        return false; // Product already in wishlist
    }

    /**
     * Remove a product from the wishlist.
     */
    public function removeProduct(Product $product): int
    {
        return $this->products()->detach($product->id);
    }

    /**
     * Check if a product is in the wishlist.
     */
    public function hasProduct(Product $product): bool
    {
        return $this->products->contains($product);
    }

    /**
     * Get the count of products in the wishlist.
     */
    public function getProductCountAttribute(): int
    {
        return $this->products()->count();
    }
}
