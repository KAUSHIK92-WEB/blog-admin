@extends('front.layout')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-white overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gray-50" style="mix-blend-mode: multiply;"></div>
            <div class="absolute w-full h-full transform -skew-y-3 bg-gradient-to-br from-indigo-50 to-purple-50 -translate-y-1/2 rounded-[100px] shadow-sm"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-20 px-4 sm:py-28 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                <span class="block text-premium-gradient drop-shadow-sm">Read & Share Experiences</span>
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500 font-medium leading-relaxed">
                Platform for educators, learners, and passionate individuals to share their knowledge and stories with the world.
            </p>
            <div class="mt-8 max-w-sm mx-auto sm:max-w-none sm:flex sm:justify-center gap-4">
                <div class="space-y-4 sm:space-y-0 sm:mx-auto sm:inline-grid sm:grid-cols-2 sm:gap-5">
                    <a href="#articles" class="flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white premium-gradient shadow hover:shadow-lg transition transform hover:-translate-y-1">
                        Read Blogs
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center justify-center px-8 py-3 border-2 border-indigo-100 text-base font-medium rounded-full text-indigo-700 bg-white hover:bg-indigo-50 hover:border-indigo-200 transition transform hover:-translate-y-1">
                        Register Account
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog Posts Grid -->
    <div id="articles" class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <div class="flex items-center justify-between mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 outfit-font tracking-tight">Latest Stories</h2>
            <div class="h-1 bg-gradient-to-r from-indigo-500 to-purple-500 w-24 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($posts as $post)
                <div class="flex flex-col rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 bg-white border border-gray-100 overflow-hidden group">
                    <a href="{{ route('blog.show', $post->slug) }}" class="flex-shrink-0 relative overflow-hidden block">
                        @php
                            $fallbackImage = 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=800&q=80';
                        @endphp
                        <img class="h-56 w-full object-cover transform group-hover:scale-105 transition duration-500 ease-in-out" src="{{ $post->thumbnail ? asset('storage/' . $post->thumbnail) : $fallbackImage }}" alt="{{ $post->title }}">
                        <div class="absolute inset-0 bg-gray-900 bg-opacity-0 group-hover:bg-opacity-10 transition duration-300"></div>
                    </a>
                    <div class="flex-1 bg-white p-8 flex flex-col justify-between">
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-indigo-600 tracking-wide uppercase">
                                    {{ $post->category->name ?? 'Uncategorized' }}
                                </p>
                                <span class="text-xs text-gray-400 font-medium bg-gray-50 px-2 py-1 rounded-md">{{ $post->published_at->format('M d, Y') }}</span>
                            </div>
                            <a href="{{ route('blog.show', $post->slug) }}" class="block mt-4">
                                <p class="text-2xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors duration-200 line-clamp-2">
                                    {{ $post->title }}
                                </p>
                                <div class="mt-3 text-base text-gray-500 line-clamp-3 leading-relaxed">
                                    {!! strip_tags($post->content) !!}
                                </div>
                                <span class="inline-block mt-4 text-indigo-600 font-semibold group-hover:text-indigo-800 transition">Read More &rarr;</span>
                            </a>
                        </div>
                        <div class="mt-6 flex items-center pt-6 border-t border-gray-50">
                            <div class="flex-shrink-0">
                                <span class="h-10 w-10 rounded-full premium-gradient flex items-center justify-center text-white font-bold shadow-md">
                                    {{ substr($post->user->name, 0, 1) }}
                                </span>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $post->user->name }}
                                </p>
                                <div class="flex space-x-1 text-xs text-gray-500 mt-1">
                                    <span>Author</span>
                                    <span aria-hidden="true">&middot;</span>
                                    <span>{{ $post->tags->count() }} Tags</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No Articles Yet</h3>
                    <p class="mt-2 text-gray-500">We are busy writing amazing content. Check back later!</p>
                </div>
            @endforelse
        </div>

        <div class="mt-16">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
