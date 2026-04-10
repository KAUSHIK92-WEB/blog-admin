<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Posts</h2>
                <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                    Create Post
                </a>
            </div>

            @if (session()->has('message'))
                <div class="mb-4 text-green-600 font-semibold bg-green-100 p-4 rounded border-l-4 border-green-500">
                    {{ session('message') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-16">Img</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Title</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Category</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tags</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Author</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Published</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white">
                                @if($post->thumbnail)
                                    <img src="{{ asset('storage/'.$post->thumbnail) }}" class="h-10 w-10 min-w-[2.5rem] rounded object-cover shadow-sm ring-1 ring-gray-200">
                                @else
                                    <div class="h-10 w-10 min-w-[2.5rem] rounded bg-gray-50 flex items-center justify-center text-gray-400 font-bold text-xs shadow-inner ring-1 ring-gray-200">N/A</div>
                                @endif
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm font-medium text-gray-900">{{ $post->title }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $post->category?->name ?? 'None' }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($post->tags as $tag)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                @if(auth()->user()->role === 'admin')
                                    <button wire:key="toggle-{{ $post->id }}" wire:click="toggleStatus({{ $post->id }})" class="relative inline-flex items-center h-6 rounded-full w-11 focus:outline-none transition-colors ease-in-out duration-200 {{ $post->status === 'published' ? 'bg-green-500' : 'bg-gray-300' }}" title="Toggle Status">
                                        <span class="inline-block w-4 h-4 transform bg-white rounded-full transition ease-in-out duration-200 {{ $post->status === 'published' ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                    </button>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $post->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-gray-600">{{ $post->user->name }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-gray-600">{{ $post->published_at ? $post->published_at->format('M d, Y H:i') : '-' }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm flex gap-3">
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold focus:outline-none">Edit</a>
                                <button wire:click="delete({{ $post->id }})" onclick="confirm('Are you sure you want to delete this post?') || event.stopImmediatePropagation()" class="text-red-600 hover:text-red-900 font-semibold focus:outline-none">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                                No posts found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $posts->links() }}</div>
        </div>
    </div>
</div>
