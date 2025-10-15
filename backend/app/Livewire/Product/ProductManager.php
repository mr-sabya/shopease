<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\Brand;
use App\Models\User;
use App\Models\Tag;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\AttributeSet;
use App\Enums\ProductType;
use App\Enums\UserRole;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On; // Important for listening to child events

class ProductManager extends Component
{
    use WithFileUploads;

    #[Locked]
    public $productId;
    public $isEditing = false;

    // --- Product Main Fields (passed to children or collected from them) ---
    public $vendor_id;
    public $category_id;
    public $brand_id;
    public $name;
    public $slug;
    public $short_description;
    public $long_description;
    public $type;
    public $is_active = true;
    public $is_featured = false;
    public $is_new = true;

    // --- Pricing & Inventory (for Normal/Digital/Affiliate) ---
    public $sku;
    public $price;
    public $compare_at_price;
    public $cost_price;
    public $quantity;
    public $weight;
    public $is_manage_stock = true;
    public $min_order_quantity = 1;
    public $max_order_quantity;

    // --- Affiliate Specific ---
    public $affiliate_url;

    // --- Digital Specific ---
    public $digital_file; // Temporary uploaded file
    public $current_digital_file_path; // Path to existing file for edit
    public $download_limit;
    public $download_expiry_days;

    // --- Images ---
    public $mainProductThumbnail; // Path to the temporary uploaded thumbnail or URL of existing
    public $newImages = []; // Array of new temporary image uploads (additional images)
    public $existingImages = []; // Array of existing ProductImage models (additional images)

    // --- Product Attributes (for Normal products / Specifications) ---
    public $attributeSetId;
    public $productAttributeValues = []; // Array of attribute_id => attribute_value_id

    // --- Product Variants (for Variable products) ---
    public $variants = []; // Array of variant data for dynamic input
    public $variantDefiningAttributes = []; // Attributes that define variants (e.g., Color, Size)
    public $variantsToDelete = []; // To store IDs of variants to be deleted from DB

    // --- Tags ---
    public $selectedTags = []; // IDs of selected tags

    // --- SEO ---
    public $seo_title;
    public $seo_description;

    // --- Dropdown Data (loaded once) ---
    public $allVendors = [];
    public $allCategories = [];
    public $allBrands = [];
    public $allTags = [];
    public $allAttributeSets = [];
    public $availableVariantAttributes = [];
    public $productTypes = [];


    protected $queryString = [
        'productId' => ['except' => null],
    ];

    public function mount($productId = null)
    {
        $this->productId = $productId;
        $this->isEditing = !is_null($productId);

        $this->loadDropdownData();
        $this->productTypes = ProductType::cases();
        $this->type = ProductType::Normal->value; // Default for new products

        if ($this->isEditing) {
            $this->loadProduct();
        } else {
            // Set initial defaults for new product
            $this->is_active = true;
            $this->is_new = true;
            $this->is_manage_stock = true;
            $this->min_order_quantity = 1;
            $this->price = 0.00;
            $this->cost_price = 0.00;
            $this->quantity = 0;
            $this->weight = 0.00;
            $this->download_limit = 1;
            $this->download_expiry_days = 365;

            // Default thumbnail placeholder or nothing
            $this->mainProductThumbnail = null;
        }
    }

    private function loadDropdownData()
    {
        $this->allVendors = User::where('role', UserRole::Vendor)->get(['id', 'name']);
        $this->allCategories = Category::active()->orderBy('name')->get(['id', 'name']);
        $this->allBrands = Brand::active()->orderBy('name')->get(['id', 'name']);
        $this->allTags = Tag::orderBy('name')->get(['id', 'name']);
        $this->allAttributeSets = AttributeSet::orderBy('name')->get(['id', 'name']);
        $this->availableVariantAttributes = Attribute::active()->orderBy('name')->get(['id', 'name', 'display_type']);
    }

    private function loadProduct()
    {
        $product = Product::with([
            'images',
            'variants.attributeValues.attribute',
            'variants.images',
            'tags',
            'attributeValues.attribute',
            'category',
            'brand',
            'vendor'
        ])->findOrFail($this->productId);

        // General Info
        $this->vendor_id = $product->vendor_id;
        $this->category_id = $product->category_id;
        $this->brand_id = $product->brand_id;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->short_description = $product->short_description;
        $this->long_description = $product->long_description;
        $this->type = $product->type->value;
        $this->is_active = $product->is_active;
        $this->is_featured = $product->is_featured;
        $this->is_new = $product->is_new;

        // Pricing & Inventory
        $this->sku = $product->sku;
        $this->price = $product->price;
        $this->compare_at_price = $product->compare_at_price;
        $this->cost_price = $product->cost_price;
        $this->quantity = $product->quantity;
        $this->weight = $product->weight;
        $this->is_manage_stock = $product->is_manage_stock;
        $this->min_order_quantity = $product->min_order_quantity;
        $this->max_order_quantity = $product->max_order_quantity;

        // Affiliate
        $this->affiliate_url = $product->affiliate_url;

        // Digital
        $this->current_digital_file_path = $product->digital_file;
        $this->download_limit = $product->download_limit;
        $this->download_expiry_days = $product->download_expiry_days;

        // Images
        $this->mainProductThumbnail = $product->thumbnail_image_path ? Storage::disk('public')->url($product->thumbnail_image_path) : null;
        $this->existingImages = $product->images->map(function ($image) {
            return [
                'id' => $image->id,
                'image_path' => $image->image_path,
                'url' => $image->image_url,
            ];
        })->toArray();

        // Tags
        $this->selectedTags = $product->tags->pluck('id')->toArray();

        // Product Attributes (for Normal products / Specifications)
        $this->attributeSetId = null;
        if ($product->attributeValues->isNotEmpty()) {
            foreach ($product->attributeValues as $attrValue) {
                if ($attrValue->attribute && $attrValue->attribute->attributeSets->isNotEmpty()) {
                    $this->attributeSetId = $attrValue->attribute->attributeSets->first()->id;
                    break;
                }
            }
        }
        if ($this->attributeSetId) {
            // Child component will load availableAttributeValues
            foreach ($product->attributeValues as $attrValue) {
                $this->productAttributeValues[$attrValue->attribute_id] = $attrValue->id;
            }
        }

        // Product Variants (for Variable products)
        if ($product->isVariable() && $product->variants->isNotEmpty()) {
            $firstVariantAttributeIds = $product->variants->first()->attributeValues->pluck('attribute_id')->unique()->toArray();
            $this->variantDefiningAttributes = Attribute::whereIn('id', $firstVariantAttributeIds)
                ->get(['id', 'name', 'display_type'])
                ->map(fn($attr) => ['id' => $attr->id, 'name' => $attr->name, 'display_type' => $attr->display_type])
                ->toArray();

            foreach ($product->variants as $variant) {
                $this->variants[] = [
                    'id' => $variant->id,
                    'sku' => $variant->sku,
                    'price' => $variant->price,
                    'compare_at_price' => $variant->compare_at_price,
                    'cost_price' => $variant->cost_price,
                    'quantity' => $variant->quantity,
                    'weight' => $variant->weight,
                    'is_active' => $variant->is_active,
                    'attribute_value_ids' => $variant->attributeValues->pluck('id')->toArray(),
                    'images' => $variant->images->map(function ($image) {
                        return [
                            'id' => $image->id,
                            'image_path' => $image->image_path,
                            'url' => $image->image_url,
                        ];
                    })->toArray(),
                    'new_images' => [],
                ];
            }
        }

        // SEO
        $this->seo_title = $product->seo_title;
        $this->seo_description = $product->seo_description;
    }

    // --- Listeners for child component updates ---

    #[On('general-info-updated')]
    public function updateGeneralInfo(
        $vendor_id,
        $category_id,
        $brand_id,
        $name,
        $slug,
        $short_description,
        $long_description,
        $type,
        $is_active,
        $is_featured,
        $is_new
    ) {
        $this->vendor_id = $vendor_id;
        $this->category_id = $category_id;
        $this->brand_id = $brand_id;
        $this->name = $name;
        $this->slug = $slug;
        $this->short_description = $short_description;
        $this->long_description = $long_description;
        $this->type = $type;
        $this->is_active = $is_active;
        $this->is_featured = $is_featured;
        $this->is_new = $is_new;
    }

    #[On('pricing-inventory-updated')]
    public function updatePricingInventory(
        $sku,
        $price,
        $compare_at_price,
        $cost_price,
        $quantity,
        $weight,
        $is_manage_stock,
        $min_order_quantity,
        $max_order_quantity
    ) {
        $this->sku = $sku;
        $this->price = $price;
        $this->compare_at_price = $compare_at_price;
        $this->cost_price = $cost_price;
        $this->quantity = $quantity;
        $this->weight = $weight;
        $this->is_manage_stock = $is_manage_stock;
        $this->min_order_quantity = $min_order_quantity;
        $this->max_order_quantity = $max_order_quantity;
    }

    #[On('affiliate-details-updated')]
    public function updateAffiliateDetails($affiliate_url)
    {
        $this->affiliate_url = $affiliate_url;
    }

    #[On('digital-details-updated')]
    public function updateDigitalDetails($digital_file, $current_digital_file_path, $download_limit, $download_expiry_days)
    {
        $this->digital_file = $digital_file;
        $this->current_digital_file_path = $current_digital_file_path;
        $this->download_limit = $download_limit;
        $this->download_expiry_days = $download_expiry_days;
    }

    #[On('product-images-updated')]
    public function updateProductImages($mainProductThumbnail, $newImages, $existingImages)
    {
        $this->mainProductThumbnail = $mainProductThumbnail;
        $this->newImages = $newImages;
        $this->existingImages = $existingImages;
    }

    #[On('product-attributes-updated')]
    public function updateProductAttributes($attributeSetId, $productAttributeValues)
    {
        $this->attributeSetId = $attributeSetId;
        $this->productAttributeValues = $productAttributeValues;
    }

    #[On('product-variants-updated')]
    public function updateProductVariants($variants, $variantDefiningAttributes, $variantsToDelete)
    {
        $this->variants = $variants;
        $this->variantDefiningAttributes = $variantDefiningAttributes;
        $this->variantsToDelete = array_merge($this->variantsToDelete, $variantsToDelete);
    }

    #[On('product-tags-updated')]
    public function updateProductTags($selectedTags)
    {
        $this->selectedTags = $selectedTags;
    }

    #[On('seo-fields-updated')]
    public function updateSeoFields($seo_title, $seo_description)
    {
        $this->seo_title = $seo_title;
        $this->seo_description = $seo_description;
    }


    // --- Validation Rules (Centralized, but can also be in child components) ---
    protected function rules()
    {
        $rules = [
            'vendor_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('products', 'slug')->ignore($this->productId),
            ],
            'short_description' => 'nullable|string|max:500',
            'long_description' => 'nullable|string',
            'type' => ['required', Rule::in(ProductType::values())],
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_new' => 'boolean',

            // Common for Normal, Variable, Digital
            'weight' => 'nullable|numeric|min:0',
            'is_manage_stock' => 'boolean',
            'min_order_quantity' => 'nullable|integer|min:1',
            'max_order_quantity' => 'nullable|integer|min:min_order_quantity',

            // Images
            'mainProductThumbnail' => [
                Rule::when(!$this->isEditing || $this->mainProductThumbnail instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile, 'nullable|image|max:2048', 'nullable|string'),
            ],
            'newImages.*' => 'nullable|image|max:2048', // 2MB max per image

            // Tags
            'selectedTags' => 'nullable|array',
            'selectedTags.*' => 'exists:tags,id',

            // SEO
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
        ];

        // Conditional rules based on product type
        if (ProductType::tryFrom($this->type)?->isVariable()) {
            // For variable products, product-level SKU, price, quantity are optional/informational
            $rules['sku'] = ['nullable', 'string', 'max:255'];
            $rules['price'] = ['nullable', 'numeric', 'min:0'];
            $rules['compare_at_price'] = ['nullable', 'numeric|min:0'];
            $rules['cost_price'] = ['nullable', 'numeric|min:0'];
            $rules['quantity'] = ['nullable', 'integer', 'min:0'];

            // Variants rules are handled in ProductVariants component and potentially merged here if needed
            $rules['variants'] = 'required|array|min:1';
            $rules['variants.*.sku'] = [
                'nullable',
                'string',
                'max:255',
            ];
            $rules['variants.*.price'] = 'required|numeric|min:0';
            $rules['variants.*.compare_at_price'] = 'nullable|numeric|min:0|gt:variants.*.price';
            $rules['variants.*.cost_price'] = 'nullable|numeric|min:0|lte:variants.*.price';
            $rules['variants.*.quantity'] = 'required_if:is_manage_stock,true|nullable|integer|min:0';
            $rules['variants.*.weight'] = 'nullable|numeric|min:0';
            $rules['variants.*.is_active'] = 'boolean';
            $rules['variants.*.attribute_value_ids'] = ['required', 'array']; // Will be validated more strictly in child
            $rules['variants.*.attribute_value_ids.*'] = 'exists:attribute_values,id';
            $rules['variants.*.new_images.*'] = 'nullable|image|max:2048';
            $rules['variantDefiningAttributes'] = 'required|array|min:1';
            $rules['variantDefiningAttributes.*.id'] = 'required|exists:attributes,id';
        } else { // Normal, Affiliate, Digital
            $rules['sku'] = [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'sku')->ignore($this->productId),
            ];
            $rules['price'] = 'required|numeric|min:0';
            $rules['compare_at_price'] = 'nullable|numeric|min:0|gt:price';
            $rules['cost_price'] = 'nullable|numeric|min:0|lte:price';
            $rules['quantity'] = 'required_if:is_manage_stock,true|nullable|integer|min:0';

            // Product Attributes (for Normal product specifications)
            $rules['attributeSetId'] = 'nullable|exists:attribute_sets,id';
            $rules['productAttributeValues'] = 'nullable|array';
            $rules['productAttributeValues.*'] = 'exists:attribute_values,id';
        }

        if (ProductType::tryFrom($this->type)?->isAffiliate()) {
            $rules['affiliate_url'] = 'required|url|max:2048';
        } else {
            $rules['affiliate_url'] = 'nullable';
        }

        if (ProductType::tryFrom($this->type)?->isDigital()) {
            $rules['digital_file'] = Rule::when(
                !$this->isEditing || ($this->isEditing && !$this->current_digital_file_path),
                ['required', 'file', 'mimes:zip,pdf,docx,xlsx,jpg,png', 'max:10240'],
                ['nullable', 'file', 'mimes:zip,pdf,docx,xlsx,jpg,png', 'max:10240']
            );
            $rules['download_limit'] = 'nullable|integer|min:1';
            $rules['download_expiry_days'] = 'nullable|integer|min:0';
        } else {
            $rules['digital_file'] = 'nullable';
        }

        return $rules;
    }

    protected $messages = [
        // ... (can be moved to individual components if specific, or kept here for global validation)
        'vendor_id.required' => 'The vendor field is required.',
        'category_id.required' => 'The category field is required.',
        'name.required' => 'The product name is required.',
        'slug.required' => 'The slug is required.',
        'slug.unique' => 'This slug is already taken. Please try another one.',
        'slug.alpha_dash' => 'The slug may only contain letters, numbers, dashes, and underscores.',
        'type.required' => 'The product type is required.',
        'price.required' => 'The price is required.', // Adjusted for parent
        'price.numeric' => 'The price must be a number.',
        'price.min' => 'The price must be at least 0.',
        'sku.required' => 'The SKU is required for non-variable products.',
        'sku.unique' => 'This SKU is already in use.',
        'quantity.required_if' => 'The quantity is required when stock management is enabled for non-variable products.',
        'quantity.integer' => 'The quantity must be an integer.',
        'quantity.min' => 'The quantity must be at least 0.',
        'compare_at_price.gt' => 'The compare at price must be greater than the price.',
        'cost_price.lte' => 'The cost price cannot be greater than the price.',
        'newImages.*.image' => 'Each uploaded file must be an image.',
        'newImages.*.max' => 'Each image may not be larger than 2MB.',
        'affiliate_url.required' => 'The affiliate URL is required for affiliate products.',
        'affiliate_url.url' => 'The affiliate URL must be a valid URL.',
        'digital_file.required' => 'A digital file is required for new digital products.',
        'digital_file.mimes' => 'The digital file must be a file of type: zip, pdf, docx, xlsx, jpg, png.',
        'digital_file.max' => 'The digital file may not be larger than 10MB.',
        'variantDefiningAttributes.required' => 'At least one attribute is required to define variants for a variable product.',
        'variants.required' => 'At least one variant is required for variable products.',
    ];


    public function saveProduct()
    {
        $this->validate(); // Validate all properties collected from children

        // Custom validation for variant SKUs, as `Rule::unique()->ignore()` on dynamic nested properties is complex
        if (ProductType::tryFrom($this->type)?->isVariable()) {
            $variantSkus = [];
            foreach ($this->variants as $index => $variant) {
                if (!empty($variant['sku'])) {
                    if (in_array($variant['sku'], $variantSkus)) {
                        $this->addError("variants.{$index}.sku", "This variant SKU is duplicated within your current list.");
                    }
                    $variantSkus[] = $variant['sku'];

                    $query = ProductVariant::where('sku', $variant['sku']);
                    if (isset($variant['id'])) {
                        $query->where('id', '!=', $variant['id']);
                    }
                    if ($query->exists()) {
                        $this->addError("variants.{$index}.sku", "This variant SKU is already in use by another product variant.");
                    }
                }
            }
        }
        $this->validate(); // Re-validate after custom checks

        DB::transaction(function () {
            $productData = [
                'vendor_id' => $this->vendor_id,
                'category_id' => $this->category_id,
                'brand_id' => $this->brand_id,
                'name' => $this->name,
                'slug' => $this->slug,
                'short_description' => $this->short_description,
                'long_description' => $this->long_description,
                'type' => $this->type,
                'sku' => ProductType::tryFrom($this->type)?->isVariable() ? null : $this->sku,
                'price' => ProductType::tryFrom($this->type)?->isVariable() ? null : $this->price,
                'compare_at_price' => ProductType::tryFrom($this->type)?->isVariable() ? null : $this->compare_at_price,
                'cost_price' => ProductType::tryFrom($this->type)?->isVariable() ? null : $this->cost_price,
                'quantity' => ProductType::tryFrom($this->type)?->isVariable() ? null : $this->quantity,
                'weight' => $this->weight,
                'is_active' => $this->is_active,
                'is_featured' => $this->is_featured,
                'is_new' => $this->is_new,
                'is_manage_stock' => $this->is_manage_stock,
                'min_order_quantity' => $this->min_order_quantity,
                'max_order_quantity' => $this->max_order_quantity,
                'seo_title' => $this->seo_title,
                'seo_description' => $this->seo_description,
                'affiliate_url' => ProductType::tryFrom($this->type)?->isAffiliate() ? $this->affiliate_url : null,
                'download_limit' => ProductType::tryFrom($this->type)?->isDigital() ? $this->download_limit : null,
                'download_expiry_days' => ProductType::tryFrom($this->type)?->isDigital() ? $this->download_expiry_days : null,
                // Thumbnail will be updated separately below
                'thumbnail_image_path' => null, // Reset and then set below
            ];

            if ($this->isEditing) {
                $product = Product::find($this->productId);
                $product->update($productData);
            } else {
                $product = Product::create($productData);
                $this->productId = $product->id;
            }

            // --- Handle Digital File Upload ---
            if (ProductType::tryFrom($this->type)?->isDigital()) {
                if ($this->digital_file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                    if ($product->digital_file && Storage::disk('local')->exists($product->digital_file)) {
                        Storage::disk('local')->delete($product->digital_file);
                    }
                    $filePath = $this->digital_file->store('digital_products', 'local');
                    $product->update(['digital_file' => $filePath]);
                } elseif ($this->isEditing && !$this->current_digital_file_path && $product->digital_file) {
                    Storage::disk('local')->delete($product->digital_file);
                    $product->update(['digital_file' => null]);
                }
            } else {
                if ($product->digital_file && Storage::disk('local')->exists($product->digital_file)) {
                    Storage::disk('local')->delete($product->digital_file);
                }
                $product->update(['digital_file' => null, 'download_limit' => null, 'download_expiry_days' => null]);
            }

            // --- Handle Product Images (Thumbnail & Additional) ---
            // Process Thumbnail
            if ($this->mainProductThumbnail instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                if ($product->thumbnail_image_path && Storage::disk('public')->exists($product->thumbnail_image_path)) {
                    Storage::disk('public')->delete($product->thumbnail_image_path);
                }
                $thumbnailPath = $this->mainProductThumbnail->store('products/thumbnails', 'public');
                $product->update(['thumbnail_image_path' => $thumbnailPath]);
            } elseif ($this->isEditing && !$this->mainProductThumbnail) { // If user removed existing thumbnail
                if ($product->thumbnail_image_path && Storage::disk('public')->exists($product->thumbnail_image_path)) {
                    Storage::disk('public')->delete($product->thumbnail_image_path);
                }
                $product->update(['thumbnail_image_path' => null]);
            }


            // Delete images that are no longer in existingImages array
            $existingImageIds = collect($this->existingImages)->pluck('id')->toArray();
            ProductImage::where('product_id', $product->id)
                ->whereNotIn('id', $existingImageIds)
                ->get()
                ->each(function ($image) {
                    if (Storage::disk('public')->exists($image->image_path)) {
                        Storage::disk('public')->delete($image->image_path);
                    }
                    $image->delete();
                });

            // Add new additional product images
            foreach ($this->newImages as $newImage) {
                if ($newImage instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                    $path = $newImage->store('products/additional', 'public');
                    $product->images()->create(['image_path' => $path]);
                }
            }
            $this->newImages = []; // Clear temporary uploads

            // --- Sync Tags ---
            $product->tags()->sync($this->selectedTags);

            // --- Sync Product Attributes (Specifications for Normal products) ---
            if (!ProductType::tryFrom($this->type)?->isVariable()) {
                $product->attributeValues()->detach();
                if ($this->attributeSetId && !empty($this->productAttributeValues)) {
                    $attributeValueIdsToAttach = array_values($this->productAttributeValues);
                    $product->attributeValues()->sync($attributeValueIdsToAttach);
                }
            } else {
                $product->attributeValues()->detach();
            }

            // --- Handle Product Variants (for Variable products) ---
            if (ProductType::tryFrom($this->type)?->isVariable()) {
                if (!empty($this->variantsToDelete)) {
                    ProductVariant::whereIn('id', $this->variantsToDelete)->get()->each(function ($variant) {
                        foreach ($variant->images as $image) {
                            if (Storage::disk('public')->exists($image->image_path)) {
                                Storage::disk('public')->delete($image->image_path);
                            }
                            $image->delete();
                        }
                        $variant->attributeValues()->detach();
                        $variant->delete();
                    });
                }

                foreach ($this->variants as $variantData) {
                    $variantImagesToSave = $variantData['images'] ?? [];
                    $newVariantImagesToUpload = $variantData['new_images'] ?? [];
                    $variantAttributesToAttach = $variantData['attribute_value_ids'];

                    $variantCoreData = [
                        'product_id' => $product->id,
                        'sku' => $variantData['sku'],
                        'price' => $variantData['price'],
                        'compare_at_price' => $variantData['compare_at_price'],
                        'cost_price' => $variantData['cost_price'],
                        'quantity' => $variantData['quantity'],
                        'weight' => $variantData['weight'],
                        'is_active' => $variantData['is_active'],
                    ];

                    if (isset($variantData['id']) && $variantData['id']) {
                        $variant = ProductVariant::find($variantData['id']);
                        $variant->update($variantCoreData);
                    } else {
                        $variant = ProductVariant::create($variantCoreData);
                    }

                    $variant->attributeValues()->sync($variantAttributesToAttach);

                    $existingVariantImageIds = collect($variantImagesToSave)->pluck('id')->toArray();
                    $variant->images()
                        ->whereNotIn('id', $existingVariantImageIds)
                        ->get()
                        ->each(function ($image) {
                            if (Storage::disk('public')->exists($image->image_path)) {
                                Storage::disk('public')->delete($image->image_path);
                            }
                            $image->delete();
                        });

                    foreach ($newVariantImagesToUpload as $newVariantImage) {
                        if ($newVariantImage instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                            $path = $newVariantImage->store('product_variants', 'public');
                            $variant->images()->create([
                                'image_path' => $path,
                                'variant_id' => $variant->id,
                            ]);
                        }
                    }
                }
            } else {
                $product->variants->each(function ($variant) {
                    foreach ($variant->images as $image) {
                        if (Storage::disk('public')->exists($image->image_path)) {
                            Storage::disk('public')->delete($image->image_path);
                        }
                        $image->delete();
                    }
                    $variant->attributeValues()->detach();
                    $variant->delete();
                });
            }

            session()->flash('message', $this->isEditing ? 'Product updated successfully!' : 'Product created successfully!');
            return redirect()->route('product.index');
        });
    }

    public function render()
    {
        return view('livewire.product.product-manager');
    }
}
