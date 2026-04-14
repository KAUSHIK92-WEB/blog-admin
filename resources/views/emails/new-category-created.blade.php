<x-mail::message>
# New Category Added

A new category "**{{ $categoryName }}**" has just been created by the administrator.

**Slug:** {{ $categorySlug }}

You can now use this category when creating new posts.

<x-mail::button :url="url('/login')">
Log in to Dashboard
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
