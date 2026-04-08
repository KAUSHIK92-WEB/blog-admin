<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Post;
use App\Models\User;

class DashboardStats extends Component
{
    public function render()
    {
        $totalPosts = 0;
        $totalAuthors = 0;
        $myPosts = 0;

        if (auth()->user()->role === 'admin') {
            $totalPosts = Post::count();
            $totalAuthors = User::where('role', 'author')->count();
        } else {
            $myPosts = Post::where('user_id', auth()->id())->count();
        }

        return view('livewire.admin.dashboard-stats', compact('totalPosts', 'totalAuthors', 'myPosts'));
    }
}
