<?php

use Illuminate\Support\Facades\Route;

// Public Blog Routes
Route::get('/', [\App\Http\Controllers\BlogController::class, 'index'])->name('home');
Route::get('/blog/{slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/posts', \App\Livewire\Admin\Posts\PostList::class)->name('posts.index');
        Route::get('/posts/create', \App\Livewire\Admin\Posts\PostForm::class)->name('posts.create');
        Route::get('/posts/{post}/edit', \App\Livewire\Admin\Posts\PostForm::class)->name('posts.edit');
        Route::get('/categories', \App\Livewire\Admin\Categories\CategoryManager::class)->name('categories.index');
        Route::get('/tags', \App\Livewire\Admin\Tags\TagManager::class)->name('tags.index');
    });
});
