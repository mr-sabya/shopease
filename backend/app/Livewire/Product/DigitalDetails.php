<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Locked;

class DigitalDetails extends Component
{
    use WithFileUploads;

    #[Locked]
    public $productId;

    public $digital_file; // TemporaryUploadedFile instance for new upload
    public $current_digital_file_path; // Path to the existing file
    public $download_limit;
    public $download_expiry_days;

    public function mount(
        $productId,
        $initialCurrentDigitalFilePath,
        $initialDownloadLimit,
        $initialDownloadExpiryDays
    ) {
        $this->productId = $productId;
        $this->current_digital_file_path = $initialCurrentDigitalFilePath;
        $this->download_limit = $initialDownloadLimit ?? 1;
        $this->download_expiry_days = $initialDownloadExpiryDays ?? 365;
    }

    protected function updated($propertyName)
    {
        if (in_array($propertyName, [
            'digital_file',
            'download_limit',
            'download_expiry_days'
        ])) {
            $this->emitUp(
                'digital-details-updated',
                $this->digital_file,
                $this->current_digital_file_path, // Pass current path to parent for proper handling
                $this->download_limit,
                $this->download_expiry_days
            );
        }
    }

    // This method will be called when a new digital_file is uploaded or cleared
    public function updatedDigitalFile()
    {
        // When a new file is selected, clear the old path
        if ($this->digital_file) {
            $this->current_digital_file_path = null;
        }
        $this->emitUp(
            'digital-details-updated',
            $this->digital_file,
            $this->current_digital_file_path,
            $this->download_limit,
            $this->download_expiry_days
        );
    }

    public function clearDigitalFile()
    {
        $this->digital_file = null;
        $this->current_digital_file_path = null; // Mark for deletion/no file
        $this->emitUp(
            'digital-details-updated',
            $this->digital_file,
            $this->current_digital_file_path,
            $this->download_limit,
            $this->download_expiry_days
        );
    }

    public function getDigitalFileNameProperty()
    {
        if ($this->digital_file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            return $this->digital_file->getClientOriginalName();
        } elseif ($this->current_digital_file_path) {
            return basename($this->current_digital_file_path);
        }
        return null;
    }

    public function render()
    {
        return view('livewire.product.digital-details');
    }
}
