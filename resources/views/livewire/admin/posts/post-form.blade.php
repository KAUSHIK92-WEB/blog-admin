<div class="py-12">
    <!-- Trix Editor Dependencies -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <style>
        .trix-button-group--file-tools { display: none !important; }
        trix-editor { min-height: 300px; background-color: white; }
    </style>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl sm:rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ $postId ? 'Edit Post' : 'Create Post' }}</h2>

            <form wire:submit.prevent="save" enctype="multipart/form-data">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Left Column (Main content) -->
                    <div class="md:col-span-2 space-y-6">
                        <div>
                            <x-label for="title" value="Title" />
                            <x-input id="title" type="text" class="mt-1 block w-full" wire:model.live="title" />
                            <x-input-error for="title" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="slug" value="Slug" />
                            <x-input id="slug" type="text" class="mt-1 block w-full bg-gray-50 text-gray-500" wire:model="slug" />
                            <x-input-error for="slug" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="content" value="Content" class="mb-1" />
                            <div wire:ignore>
                                <input id="trix-content" type="hidden" name="content" value="{{ $content }}">
                                <trix-editor input="trix-content" class="trix-content prose max-w-none border-gray-300 rounded-md shadow-sm" x-data x-on:trix-change="$wire.content = $event.target.value"></trix-editor>
                            </div>
                            <x-input-error for="content" class="mt-2" />
                        </div>
                    </div>

                    <!-- Right Column (Meta) -->
                    <div class="space-y-6">
                        <div>
                            <x-label for="status" value="Status" />
                            @if(auth()->user()->role === 'admin')
                                <select id="status" wire:model="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                </select>
                            @else
                                <div class="mt-1 block w-full border border-gray-200 bg-gray-50 text-gray-500 italic px-4 py-2 rounded-md shadow-sm">
                                    {{ ucfirst($status) }} - Waiting Admin Review
                                </div>
                            @endif
                            <x-input-error for="status" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="published_at" value="Publish Date" />
                            <x-input id="published_at" type="datetime-local" class="mt-1 block w-full" wire:model="published_at" />
                            <x-input-error for="published_at" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="category_id" value="Category" />
                            <select id="category_id" wire:model="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error for="category_id" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="selectedTags" value="Tags (Ctrl+click to multi-select)" />
                            <select id="selectedTags" wire:model="selectedTags" multiple class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 h-32">
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error for="selectedTags" class="mt-2" />
                        </div>

                        <!-- Base64 Dynamic Upload Bypass -->
                        <div x-data="{
                                imagePreview: null,
                                handleFile(event) {
                                    let file = event.target.files[0];
                                    if(!file) return;
                                    let reader = new FileReader();
                                    reader.onload = (e) => {
                                        this.imagePreview = e.target.result;
                                        @this.set('newThumbnailBase64', e.target.result);
                                    };
                                    reader.readAsDataURL(file);
                                }
                            }">
                            <x-label value="Thumbnail" />
                            
                            <!-- Dynamic Preview -->
                            <template x-if="imagePreview">
                                <img :src="imagePreview" class="mt-2 mb-2 w-full object-cover h-48 rounded">
                            </template>
                            
                            <!-- DB Preview -->
                            <template x-if="!imagePreview">
                                <div>
                                    @if ($thumbnail)
                                        <img src="{{ asset('storage/'.$thumbnail) }}" class="mt-2 mb-2 w-full object-cover h-48 rounded">
                                    @endif
                                </div>
                            </template>

                            <input id="newThumbnail" type="file" accept="image/*" @change="handleFile" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end border-t pt-6">
                    <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition">
                        Cancel
                    </a>
                    <x-button class="ms-3" type="submit" wire:loading.attr="disabled">
                        Save Post
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>
