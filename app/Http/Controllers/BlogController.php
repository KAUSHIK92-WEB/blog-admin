<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'category', 'tags'])
                    ->where('status', 'published')
                    ->where(function ($query) {
                        $query->whereNull('published_at')
                              ->orWhere('published_at', '<=', now());
                    })
                    ->latest()
                    ->paginate(9);

        return view('front.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::with(['user', 'category', 'tags'])
                    ->where('slug', $slug)
                    ->where('status', 'published')
                    ->where(function ($query) {
                        $query->whereNull('published_at')
                              ->orWhere('published_at', '<=', now());
                    })
                    ->firstOrFail();

        return view('front.show', compact('post'));
    }
}
