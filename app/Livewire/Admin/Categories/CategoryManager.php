<?php

namespace App\Livewire\Admin\Categories;

use Livewire\Component;

class CategoryManager extends Component
{
    use \Livewire\WithPagination;

    public $name, $slug, $categoryId;
    public $isModalOpen = 0;

    protected $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:categories,slug',
    ];

    public function mount()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
    }

    public function updatedName($value)
    {
        $this->slug = \Illuminate\Support\Str::slug($value);
    }

    public function render()
    {
        return view('livewire.admin.categories.category-manager', [
            'categories' => \App\Models\Category::paginate(10)
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->slug = '';
        $this->categoryId = '';
    }

    public function store()
    {
        $rules = $this->rules;
        if ($this->categoryId) {
            $rules['slug'] = 'required|string|max:255|unique:categories,slug,' . $this->categoryId;
        }

        $this->validate($rules);

        $isNew = !$this->categoryId;

        $category = \App\Models\Category::updateOrCreate(['id' => $this->categoryId], [
            'name' => $this->name,
            'slug' => $this->slug
        ]);

        if ($isNew) {
            \App\Jobs\NotifyAuthorsOfNewCategory::dispatch($category);
        }

        session()->flash('message', $isNew ? 'Category created successfully.' : 'Category updated successfully.');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $this->categoryId = $id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->openModal();
    }

    public function delete($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        if ($category->posts()->count() > 0) {
            session()->flash('error', 'Cannot delete this category because it is associated with posts.');
            return;
        }
        $category->delete();
        session()->flash('message', 'Category deleted successfully.');
    }
}
