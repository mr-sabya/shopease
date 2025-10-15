<?php

namespace App\Livewire\Product;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Enums\ProductType;
use App\Enums\UserRole;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Manage extends Component
{
    use WithFileUploads;

    public ?Product $product = null;

    // Core Product Properties
    public $vendor_id; // Will likely be set from auth user in a real app
    public $category_id;
    public $brand_id;
    public $name;
    public $slug;
    public $short_description;
    public $long_description;
    public $thumbnail_image_path; // For existing image display
    public $new_thumbnail_image; // For new file upload
    public $type = 'normal'; // Default to normal
    public $sku;
    public $price;
    public $compare_at_price;
    public $cost_price;
    public $quantity;
    public $weight;
    public $is_active = true;
    public $is_featured = false;
    public $is_new = false;
    public $is_manage_stock = true;
    public $min_order_quantity = 1;
    public $max_order_quantity;

    // Fields for specific product types
    public $affiliate_url;
    public $digital_file_path; // For existing file display
    public $new_digital_file; // For new file upload
    public $download_limit;
    public $download_expiry_days;

    public $categories;
    public $brands;
    public $productTypes; // For dropdown options
    public $vendors;

    public function mount(?Product $product = null)
    {
        $this->product = $product;

        $this->categories = Category::active()->get();
        $this->brands = Brand::active()->get();
        $this->productTypes = ProductType::cases(); // Get all enum cases

        // Fetch active users who have the 'vendor' role
        $this->vendors = User::where('role', UserRole::Vendor)->where('is_active', true)->get(); // <-- Fetch vendors

        if ($this->product) {
            $this->fill($this->product->toArray());

            // Handle enum type casting for display
            $this->type = $this->product->type?->value ?? ProductType::Normal->value;

            // Existing thumbnail/digital file path
            $this->thumbnail_image_path = $this->product->thumbnail_image_path;
            $this->digital_file_path = $this->product->digital_file;

            // For simplicity, vendor_id will be manually set or derived
            // In a real app, you'd get this from the authenticated vendor user
            $this->vendor_id = $this->product->vendor_id;
        } else {
            // We are creating a NEW product
            $this->product = new Product();
            $this->type = ProductType::Normal->value;

            // Set a default vendor_id for new products if available (e.g., first vendor, or authenticated vendor)
            // For now, let's assume we want to select one. If no vendors, it will be null.
            $this->vendor_id = $this->vendors->first()->id ?? null; // <-- Set default for new products
        }
    }

    protected function rules()
    {
        $rules = [
            'vendor_id' => ['required', 'exists:users,id', Rule::exists('users', 'id')->where(function ($query) {
                $query->where('role', UserRole::Vendor->value);
            })], // <-- Add/update rule for vendor_id
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                // Rule to ensure slug is unique for products, ignoring current product if editing
                Rule::unique('products', 'slug')->ignore($this->product->id),
            ],
            'short_description' => ['nullable', 'string', 'max:500'],
            'long_description' => ['nullable', 'string'],
            'new_thumbnail_image' => ['nullable', 'image', 'max:2048'], // 2MB Max
            'type' => ['required', Rule::enum(ProductType::class)],
            'sku' => ['nullable', 'string', 'max:255', Rule::unique('products', 'sku')->ignore($this->product->id)],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_at_price' => ['nullable', 'numeric', 'min:0', 'gte:price'],
            'cost_price' => ['nullable', 'numeric', 'min:0', 'lte:price'],
            'quantity' => ['required_if:is_manage_stock,true', 'nullable', 'integer', 'min:0'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
            'is_new' => ['boolean'],
            'is_manage_stock' => ['boolean'],
            'min_order_quantity' => ['nullable', 'integer', 'min:1'],
            'max_order_quantity' => ['nullable', 'integer', 'min:1', 'gte:min_order_quantity'],
            'affiliate_url' => ['nullable', 'url', 'max:2048'],
            'new_digital_file' => ['nullable', 'file', 'max:102400'], // 100MB Max
            'download_limit' => ['nullable', 'integer', 'min:1'],
            'download_expiry_days' => ['nullable', 'integer', 'min:1'],
        ];

        // Conditional rules for product types
        if ($this->type === ProductType::Affiliate->value) {
            $rules['affiliate_url'][] = 'required';
            $rules['sku'] = ['nullable', 'string', 'max:255', Rule::unique('products', 'sku')->ignore($this->product->id)]; // SKU can be nullable for affiliate
            $rules['quantity'] = ['nullable', 'integer', 'min:0']; // Quantity not strictly managed
            $rules['is_manage_stock'] = ['nullable', 'boolean']; // Stock isn't managed
        }
        if ($this->type === ProductType::Digital->value) {
            $rules['new_digital_file'][] = $this->product->digital_file ? 'nullable' : 'required'; // Required if no existing file
            $rules['sku'] = ['nullable', 'string', 'max:255', Rule::unique('products', 'sku')->ignore($this->product->id)]; // SKU can be nullable for digital
            $rules['quantity'] = ['nullable', 'integer', 'min:0']; // Quantity not strictly managed
            $rules['is_manage_stock'] = ['nullable', 'boolean']; // Stock isn't managed
        }
        if ($this->type === ProductType::Normal->value) {
            $rules['quantity'][] = 'required'; // Normal products need quantity
        }
        if ($this->type === ProductType::Variable->value) {
            $rules['quantity'] = ['nullable', 'integer', 'min:0']; // Quantity is managed by variants
            $rules['is_manage_stock'] = ['nullable', 'boolean']; // Stock isn't managed on parent product
            $rules['sku'] = ['nullable', 'string', 'max:255', Rule::unique('products', 'sku')->ignore($this->product->id)]; // SKU can be nullable for variable
        }


        return $rules;
    }

    protected $messages = [
        'quantity.required_if' => 'The quantity field is required when stock is managed.',
        'new_digital_file.required' => 'A digital file is required for digital products.',
        'affiliate_url.required' => 'The affiliate URL is required for affiliate products.',
        'compare_at_price.gte' => 'The compare at price must be greater than or equal to the price.',
        'cost_price.lte' => 'The cost price must be less than or equal to the price.',
        'max_order_quantity.gte' => 'The maximum order quantity must be greater than or equal to the minimum order quantity.',
    ];


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        // Auto-generate slug if name changes and slug is empty
        if ($propertyName === 'name' && empty($this->slug)) {
            $this->slug = Str::slug($this->name);
        }
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
        $this->validateOnly('slug'); // Validate the generated slug immediately
    }

    public function save()
    {
        $this->validate();

        // Handle thumbnail image upload
        if ($this->new_thumbnail_image) {
            if ($this->product->thumbnail_image_path) {
                Storage::disk('public')->delete($this->product->thumbnail_image_path);
            }
            $this->thumbnail_image_path = $this->new_thumbnail_image->store('products/thumbnails', 'public');
        }

        // Handle digital file upload for digital products
        if ($this->type === ProductType::Digital->value && $this->new_digital_file) {
            if ($this->product->digital_file) {
                Storage::disk('public')->delete($this->product->digital_file);
            }
            $this->digital_file_path = $this->new_digital_file->store('products/digital_files', 'public');
        } elseif ($this->type !== ProductType::Digital->value && $this->product->digital_file) {
            // If product type changes from digital, delete old digital file
            Storage::disk('public')->delete($this->product->digital_file);
            $this->digital_file_path = null;
        }

        $this->product->fill([
            'vendor_id' => $this->vendor_id,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'name' => $this->name,
            'slug' => $this->slug ?? Str::slug($this->name), // Fallback if slug is null
            'short_description' => $this->short_description,
            'long_description' => $this->long_description,
            'thumbnail_image_path' => $this->thumbnail_image_path,
            'type' => ProductType::from($this->type), // Cast back to enum
            'sku' => $this->sku,
            'price' => $this->price,
            'compare_at_price' => $this->compare_at_price,
            'cost_price' => $this->cost_price,
            'quantity' => ($this->type === ProductType::Variable->value || $this->type === ProductType::Affiliate->value || $this->type === ProductType::Digital->value) ? null : $this->quantity, // Quantity nullified for variable/affiliate/digital parent products
            'weight' => $this->weight,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'is_new' => $this->is_new,
            'is_manage_stock' => ($this->type === ProductType::Variable->value || $this->type === ProductType::Affiliate->value || $this->type === ProductType::Digital->value) ? false : $this->is_manage_stock, // Stock not managed on parent for these types
            'min_order_quantity' => $this->min_order_quantity,
            'max_order_quantity' => $this->max_order_quantity,
            'affiliate_url' => ($this->type === ProductType::Affiliate->value) ? $this->affiliate_url : null,
            'digital_file' => ($this->type === ProductType::Digital->value) ? $this->digital_file_path : null,
            'download_limit' => ($this->type === ProductType::Digital->value) ? $this->download_limit : null,
            'download_expiry_days' => ($this->type === ProductType::Digital->value) ? $this->download_expiry_days : null,
            // SEO fields will be handled by a separate component
        ])->save();


        session()->flash('message', 'Product ' . ($this->product->wasRecentlyCreated ? 'created' : 'updated') . ' successfully!');

        // Redirect or emit event
        return redirect()->route('products.edit', $this->product->id); // Example redirection
    }

    public function render()
    {
        return view('livewire.product.manage');
    }
}
