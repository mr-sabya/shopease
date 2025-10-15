<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\Attributes\Locked;

class AffiliateDetails extends Component
{
    #[Locked]
    public $productId;

    public $affiliate_url;

    public function mount($productId, $initialAffiliateUrl)
    {
        $this->productId = $productId;
        $this->affiliate_url = $initialAffiliateUrl;
    }

    protected function updated($propertyName)
    {
        if ($propertyName === 'affiliate_url') {
            $this->emitUp('affiliate-details-updated', $this->affiliate_url);
        }
    }

    public function render()
    {
        return view('livewire.product.affiliate-details');
    }
}
