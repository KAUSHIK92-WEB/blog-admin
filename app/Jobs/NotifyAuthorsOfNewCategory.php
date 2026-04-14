<?php

namespace App\Jobs;

use App\Mail\NewCategoryCreatedMail;
use App\Models\Category;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyAuthorsOfNewCategory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $category;

    /**
     * Create a new job instance.
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $authors = User::where('role', 'author')->get();

        foreach ($authors as $index => $author) {
            // Spread out the emails by 2 seconds each to stay under Mailtrap's rate limits
            Mail::to($author->email)->later(
                now()->addSeconds($index * 2), 
                new NewCategoryCreatedMail($this->category)
            );
        }
    }
}
