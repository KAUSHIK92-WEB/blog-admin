<?php

namespace App\Livewire\Admin\Posts;

use Livewire\Component;
use Livewire\WithFileUploads;

class PostForm extends Component
{
    use WithFileUploads;

    public $postId;
    public $title, $slug, $content, $category_id, $status = 'draft', $published_at;
    public $thumbnail;
    public $newThumbnailBase64;
    public $selectedTags = [];

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $this->postId,
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'selectedTags' => 'array',
        ];
    }

    public function mount($post = null)
    {
        if ($post) {
            $postModel = \App\Models\Post::findOrFail($post);
            
            if (auth()->user()->role !== 'admin' && auth()->id() !== $postModel->user_id) {
                abort(403);
            }

            $this->postId = $postModel->id;
            $this->title = $postModel->title;
            $this->slug = $postModel->slug;
            $this->content = $postModel->content;
            $this->category_id = $postModel->category_id;
            $this->status = $postModel->status;
            $this->published_at = $postModel->published_at ? $postModel->published_at->format('Y-m-d\TH:i') : null;
            $this->thumbnail = $postModel->thumbnail;
            $this->selectedTags = $postModel->tags->pluck('id')->map(fn($id) => (string)$id)->toArray();
        }
    }

    public function updatedTitle($value)
    {
        $this->slug = \Illuminate\Support\Str::slug($value);
    }

    public function save()
    {
        if (auth()->user()->role !== 'admin') {
            $this->status = 'draft';
        }

        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'category_id' => $this->category_id,
            'status' => $this->status,
            'published_at' => $this->published_at ?: null,
        ];

        if ($this->newThumbnailBase64) {
            try {
                $image_parts = explode(";base64,", $this->newThumbnailBase64);
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = 'thumbnails/' . uniqid() . '.jpg';
                \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $image_base64);
                $data['thumbnail'] = $fileName;
            } catch (\Exception $e) {
                // Ignore parsing errors
            }
        }

        if (!$this->postId) {
            $data['user_id'] = auth()->id();
        }

        $post = \App\Models\Post::updateOrCreate(
            ['id' => $this->postId],
            $data
        );

        $post->tags()->sync($this->selectedTags);

        session()->flash('message', $this->postId ? 'Post updated successfully.' : 'Post created successfully.');

        return redirect()->route('admin.posts.index');
    }

    public function render()
    {
        return view('livewire.admin.posts.post-form', [
            'categories' => \App\Models\Category::all(),
            'tags' => \App\Models\Tag::all(),
        ])->layout('layouts.app');
    }
}
