<?php

namespace App\Livewire\Admin\Tags;

use Livewire\Component;

class TagManager extends Component
{
    use \Livewire\WithPagination;

    public $name, $slug, $tagId;
    public $isModalOpen = 0;

    protected $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:tags,slug',
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
        return view('livewire.admin.tags.tag-manager', [
            'tags' => \App\Models\Tag::paginate(10)
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
        $this->tagId = '';
    }

    public function store()
    {
        $rules = $this->rules;
        if ($this->tagId) {
            $rules['slug'] = 'required|string|max:255|unique:tags,slug,' . $this->tagId;
        }

        $this->validate($rules);

        \App\Models\Tag::updateOrCreate(['id' => $this->tagId], [
            'name' => $this->name,
            'slug' => $this->slug
        ]);

        $this->dispatch('message');
        session()->flash('message', $this->tagId ? 'Tag updated successfully.' : 'Tag created successfully.');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $tag = \App\Models\Tag::findOrFail($id);
        $this->tagId = $id;
        $this->name = $tag->name;
        $this->slug = $tag->slug;
        $this->openModal();
    }

    public function delete($id)
    {
        $tag = \App\Models\Tag::findOrFail($id);
        if ($tag->posts()->count() > 0) {
            $this->dispatch('error');
            session()->flash('error', 'Cannot delete this tag because it is associated with posts.');
            return;
        }
        $tag->delete();
        $this->dispatch('message');
        session()->flash('message', 'Tag deleted successfully.');
    }
}
