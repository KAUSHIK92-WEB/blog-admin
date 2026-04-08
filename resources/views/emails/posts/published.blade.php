<x-mail::message>
# Congratulations, {{ $post->user->name }}!

Your latest article **"{{ $post->title }}"** has been successfully reviewed and published by the administrators.

It is now live on our platform for the community to read.

<x-mail::button :url="route('blog.show', $post->slug)">
View Your Post
</x-mail::button>

Keep up the great work!

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
