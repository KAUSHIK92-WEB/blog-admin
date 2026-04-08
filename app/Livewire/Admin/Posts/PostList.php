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
