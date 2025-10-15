<div class="py-4">
    <h2 class="mb-4">{{ $isEditing ? 'Edit Product: ' . ($name ?? 'N/A') : 'Create New Product' }}</h2>

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

    <form wire:submit.prevent="saveProduct">
        {{-- General Information --}}
        <livewire:product.general-info
            :product-id="$productId"
            :initial-vendor-id="$vendor_id"
            :initial-category-id="$category_id"
            :initial-brand-id="$brand_id"
            :initial-name="$name"
            :initial-slug="$slug"
            :initial-short-description="$short_description"
            :initial-long-description="$long_description"
            :initial-type="$type"
            :initial-is-active="$is_active"
            :initial-is-featured="$is_featured"
            :initial-is-new="$is_new"
            :all-vendors="$allVendors"
            :all-categories="$allCategories"
            :all-brands="$allBrands"
            :product-types="$productTypes"
            wire:key="general-info-{{ $productId }}" />

        {{-- Price & Stock (conditional based on type) --}}
        @if (!($type == \App\Enums\ProductType::Variable->value))
        <livewire:product.pricing-inventory
            :product-id="$productId"
            :initial-sku="$sku"
            :initial-price="$price"
            :initial-compare-at-price="$compare_at_price"
            :initial-cost-price="$cost_price"
            :initial-quantity="$quantity"
            :initial-weight="$weight"
            :initial-is-manage-stock="$is_manage_stock"
            :initial-min-order-quantity="$min_order_quantity"
            :initial-max-order-quantity="$max_order_quantity"
            wire:key="pricing-inventory-{{ $productId }}" />
        @endif

        {{-- Product Type Specific Fields --}}
        @if ($type == \App\Enums\ProductType::Affiliate->value)
        <livewire:product.affiliate-details
            :product-id="$productId"
            :initial-affiliate-url="$affiliate_url"
            wire:key="affiliate-details-{{ $productId }}" />
        @elseif ($type == \App\Enums\ProductType::Digital->value)
        <livewire:product.digital-details
            :product-id="$productId"
            :initial-current-digital-file-path="$current_digital_file_path"
            :initial-download-limit="$download_limit"
            :initial-download-expiry-days="$download_expiry_days"
            wire:key="digital-details-{{ $productId }}" />
        @elseif ($type == \App\Enums\ProductType::Variable->value)
        <livewire:product.product-variants
            :product-id="$productId"
            :initial-is-manage-stock="$is_manage_stock"
            :initial-variants="$variants"
            :initial-variant-defining-attributes="$variantDefiningAttributes"
            :available-variant-attributes="$availableVariantAttributes"
            wire:key="product-variants-{{ $productId }}" />
        @endif

        {{-- Product Images --}}
        <livewire:product.product-images
            :product-id="$productId"
            :initial-main-product-thumbnail="$mainProductThumbnail"
            :initial-existing-images="$existingImages"
            wire:key="product-images-{{ $productId }}" />

        {{-- Product Attributes (Specifications for Normal Products) --}}
        @if (!($type == \App\Enums\ProductType::Variable->value))
        <livewire:product.product-attributes
            :product-id="$productId"
            :initial-attribute-set-id="$attributeSetId"
            :initial-product-attribute-values="$productAttributeValues"
            :all-attribute-sets="$allAttributeSets"
            wire:key="product-attributes-{{ $productId }}" />
        @endif

        {{-- Product Tags --}}
        <livewire:product.product-tags
            :product-id="$productId"
            :initial-selected-tags="$selectedTags"
            :all-tags="$allTags"
            wire:key="product-tags-{{ $productId }}" />

        {{-- SEO Information --}}
        <livewire:product.seo-fields
            :product-id="$productId"
            :initial-seo-title="$seo_title"
            :initial-seo-description="$seo_description"
            wire:key="seo-fields-{{ $productId }}" />

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('product.index') }}" class="btn btn-secondary" wire:navigate>Cancel</a>
            <button type="submit" class="btn btn-primary">
                <span wire:loading.remove wire:target="saveProduct">{{ $isEditing ? 'Update Product' : 'Create Product' }}</span>
                <span wire:loading wire:target="saveProduct">Saving...</span>
            </button>
        </div>
    </form>
</div>