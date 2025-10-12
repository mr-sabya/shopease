<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads; // For image uploads
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage; // For deleting old images

class ManageCategories extends Component
{
    use WithPagination, WithFileUploads;

    // Table state
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $perPage = 10;

    // Form state (for create/edit modal)
    public $categoryId;
    public $name;
    public $slug;
    public $description;
    public $parent_id;
    public $image; // Stores the image file object temporarily during upload
    public $currentImage; // Stores the path to the existing image for display
    public $is_active = true;
    public $show_on_homepage = false;
    public $sort_order = 0;
    public $seo_title;
    public $seo_description;

    // UI state
    public $showCategoryModal = false;
    public $isEditing = false;
    public $modalTitle = 'Create New Category';

    // Query string for URL parameters
    protected $queryString = ['search', 'sortField', 'sortDirection'];

    // Validation rules
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash', // Only allows alphanumeric characters, dashes, and underscores
                // Unique slug validation: ignore current category's slug if editing
                Rule::unique('categories')->ignore($this->categoryId),
            ],
            'description' => 'nullable|string|max:1000',
            'parent_id' => 'nullable|exists:categories,id', // Parent must exist in categories table
            'image' => 'nullable|image|max:1024', // Max 1MB, image file types
            'currentImage' => 'nullable|string', // Hidden field to track existing image path
            'is_active' => 'boolean',
            'show_on_homepage' => 'boolean',
            'sort_order' => 'required|integer|min:0',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
        ];
    }

    // Custom validation messages
    protected $messages = [
        'slug.unique' => 'This slug is already taken. Please try another one.',
        'slug.alpha_dash' => 'The slug may only contain letters, numbers, dashes, and underscores.',
        'parent_id.exists' => 'The selected parent category is invalid.',
    ];

    // Listeners for slug generation
    public function updatedName($value)
    {
        // Only auto-generate if the slug is empty or if it was previously auto-generated from this name
        if (empty($this->slug) || Str::slug($value) === $this->slug) {
            $this->slug = Str::slug($value);
        }
    }

    // Reset pagination when search or sort changes
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    // Sort table
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    // Open create modal
    public function createCategory()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->modalTitle = 'Create New Category';
        $this->showCategoryModal = true;
    }

    // Open edit modal
    public function editCategory(Category $category)
    {
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description;
        $this->parent_id = $category->parent_id;
        $this->currentImage = $category->image; // Store existing image path
        $this->image = null; // Clear file input field
        $this->is_active = $category->is_active;
        $this->show_on_homepage = $category->show_on_homepage;
        $this->sort_order = $category->sort_order;
        $this->seo_title = $category->seo_title;
        $this->seo_description = $category->seo_description;

        $this->isEditing = true;
        $this->modalTitle = 'Edit Category: ' . $category->name;
        $this->showCategoryModal = true;
    }

    // Save or update category
    public function saveCategory()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'parent_id' => $this->parent_id,
            'is_active' => $this->is_active,
            'show_on_homepage' => $this->show_on_homepage,
            'sort_order' => $this->sort_order,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
        ];

        // Handle image upload
        if ($this->image) {
            // Delete old image if it exists and a new one is uploaded
            if ($this->currentImage && Storage::disk('public')->exists($this->currentImage)) {
                Storage::disk('public')->delete($this->currentImage);
            }
            $data['image'] = $this->image->store('categories', 'public');
        } elseif (!$this->image && $this->currentImage) {
            // If no new image is uploaded but there was an existing one, keep it
            $data['image'] = $this->currentImage;
        } else {
            // If no new image and no existing image, or if image was explicitly cleared (not implemented yet, but conceptually)
            $data['image'] = null;
        }

        if ($this->isEditing) {
            $category = Category::find($this->categoryId);
            $category->update($data);
            session()->flash('message', 'Category updated successfully!');
        } else {
            Category::create($data);
            session()->flash('message', 'Category created successfully!');
        }

        $this->closeModal();
    }

    // Delete category
    public function deleteCategory($categoryId)
    {
        $category = Category::find($categoryId);

        if ($category->children()->count() > 0) {
            session()->flash('error', 'Cannot delete category with subcategories. Please move or delete subcategories first.');
            return;
        }

        if ($category->products()->count() > 0) {
             session()->flash('error', 'Cannot delete category with associated products. Please reassign or delete products first.');
            return;
        }

        // Delete image file if it exists
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();
        session()->flash('message', 'Category deleted successfully!');
        $this->resetPage(); // Reset pagination in case the last item on a page was deleted
    }

    // Close modal and reset form
    public function closeModal()
    {
        $this->showCategoryModal = false;
        $this->resetForm();
    }

    // Reset form fields
    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->categoryId = null;
        $this->name = '';
        $this->slug = '';
        $this->description = '';
        $this->parent_id = null;
        $this->image = null; // Clear the temporary file object
        $this->currentImage = null; // Clear the current image path
        $this->is_active = true;
        $this->show_on_homepage = false;
        $this->sort_order = 0;
        $this->seo_title = '';
        $this->seo_description = '';
    }

    public function render()
    {
        $categories = Category::query()
            ->with('parent') // Eager load parent for display
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('slug', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        // Fetch parent categories for the dropdown (exclude current category if editing)
        $parentCategories = Category::whereNull('parent_id')
                                ->when($this->categoryId, function($query){
                                    // Prevent a category from being its own parent or a child of itself
                                    $query->where('id', '!=', $this->categoryId);
                                })
                                ->orderBy('name')
                                ->get();

        return view('livewire.categories.manage-categories', [
            'categories' => $categories,
            'parentCategories' => $parentCategories,
        ]);
    }
}