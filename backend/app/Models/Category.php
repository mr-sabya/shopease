<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // For slug generation

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'image',
        'is_active',
        'show_on_homepage',
        'sort_order',
        'seo_title',
        'seo_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_on_homepage' => 'boolean',
        'sort_order' => 'integer',
    ];


    /**
     * The "booting" method of the model.
     * Automatically generate slug.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if (empty($category->slug) && $category->isDirty('name')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the parent category.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get all products belonging to this category.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the coupons associated with this category.
     */
    public function coupons()
    {
        return $this->belongsToMany(Coupon::class); // Requires a pivot table: category_coupon
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

     // Add this local scope
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function scopeFeaturedOnHomepage($query)
    {
        return $query->where('show_on_homepage', true)->where('is_active', true);
    }

    public function scopeParentCategories($query)
    {
        return $query->whereNull('parent_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Get the URL to the category image.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
