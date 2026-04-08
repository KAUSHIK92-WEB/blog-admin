@extends('front.layout')

@section('content')
    <article class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 bg-white shadow-2xl sm:my-10 sm:rounded-3xl border border-gray-100 overflow-hidden">
        
        <!-- Header -->
        <header class="text-center mb-12 sm:mb-16 mt-8">
            <div class="flex justify-center flex-wrap gap-2 mb-6">
                @if($post->category)
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold bg-indigo-50 text-indigo-700 tracking-wide uppercase">
                        {{ $post->category->name }}
                    </span>
                @endif
                @foreach($post->tags as $tag)
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold shadow-sm bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                        #{{ $tag->name }}
                    </span>
                @endforeach
            </div>
            
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-gray-900 outfit-font leading-tight tracking-tight px-4 shadow-sm mb-8 text-premium-gradient">
                {{ $post->title }}
            </h1>

            <div class="flex items-center justify-center space-x-6">
                <div class="flex items-center">
                    <div class="h-12 w-12 rounded-full premium-gradient flex items-center justify-center text-white font-bold text-lg shadow-lg">
                        {{ substr($post->user->name, 0, 1) }}
                    </div>
                    <div class="ml-4 text-left">
                        <p class="text-base font-bold text-gray-900">{{ $post->user->name }}</p>
                        <p class="text-sm text-gray-500 font-medium">{{ $post->published_at->format('F j, Y') }} &middot; {{ $post->tags->count() }} Tags</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Thumbnail -->
        @php
            $fallbackImage = 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=1200&q=80';
        @endphp
        <div class="relative w-full h-[400px] md:h-[500px] mb-16 rounded-2xl overflow-hidden shadow-xl border border-gray-100 mx-auto group">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-10"></div>
            <img src="{{ $post->thumbnail ? asset('storage/' . $post->thumbnail) : $fallbackImage }}" alt="{{ $post->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700 ease-in-out">
        </div>

        <!-- Content -->
        <!-- We use standard Tailwind prosaic classes. If Typography plugin isn't active, we add base rich text styles manually -->
        <div class="prose prose-lg prose-indigo mx-auto text-gray-700 leading-relaxed max-w-3xl custom-trix-content">
            {!! $post->content !!}
        </div>
        
    </article>

    <!-- Custom CSS to make Trix HTML look good without full Typography plugin just in case -->
    <style>
        .custom-trix-content h1 { font-size: 2.25rem; font-weight: 800; margin-top: 2rem; margin-bottom: 1rem; color: #111827; }
        .custom-trix-content h2 { font-size: 1.875rem; font-weight: 700; margin-top: 1.5rem; margin-bottom: 0.75rem; color: #1f2937; }
        .custom-trix-content h3 { font-size: 1.5rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.5rem; color: #374151; }
        .custom-trix-content p { margin-bottom: 1.25rem; line-height: 1.75; }
        .custom-trix-content a { color: #4f46e5; text-decoration: underline; font-weight: 500; }
        .custom-trix-content blockquote { border-left: 4px solid #e5e7eb; padding-left: 1rem; font-style: italic; color: #4b5563; margin-top: 1.5rem; margin-bottom: 1.5rem; }
        .custom-trix-content ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1.25rem; }
        .custom-trix-content ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 1.25rem; }
        .custom-trix-content li { margin-bottom: 0.25rem; }
    </style>
@endsection
