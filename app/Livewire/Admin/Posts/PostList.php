<?php

namespace App\Livewire\Admin\Posts;

use Livewire\Component;

class PostList extends Component
{
    use \Livewire\WithPagination;

    public function render()
    {
        $query = \App\Models\Post::with(['user', 'category', 'tags'])->latest();
        
        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        return view('livewire.admin.posts.post-list', [
            'posts' => $query->paginate(10)
        ])->layout('layouts.app');
    }

    public function toggleStatus($id)
    {
        $post = \App\Models\Post::findOrFail($id);

        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $post->status = $post->status === 'published' ? 'draft' : 'published';
        $post->save();

        if ($post->status === 'published') {
            \Illuminate\Support\Facades\Mail::to($post->user->email)->send(new \App\Mail\PostPublished($post));
        }

        session()->flash('message', 'Status updated successfully.');
    }

    public function delete($id)
    {
        $post = \App\Models\Post::findOrFail($id);
        
        if (auth()->user()->role !== 'admin' && auth()->id() !== $post->user_id) {
            abort(403);
        }
        
        $post->delete();
        session()->flash('message', 'Post deleted successfully.');
    }
}
