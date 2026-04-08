<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Tags</h2>
                <x-button wire:click="create()">
                    Create Tag
                </x-button>
            </div>

            <x-action-message on="message" class="mb-4 text-green-600 font-semibold">
                {{ session('message') }}
            </x-action-message>
            <x-action-message on="error" class="mb-4 text-red-600 font-semibold">
                {{ session('error') }}
            </x-action-message>

            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Slug</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tags as $tag)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $tag->name }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $tag->slug }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm flex gap-3">
                                <button wire:click="edit({{ $tag->id }})" class="text-indigo-600 hover:text-indigo-900 font-semibold">Edit</button>
                                <button wire:click="delete({{ $tag->id }})" class="text-red-600 hover:text-red-900 font-semibold" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $tags->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-dialog-modal wire:model.live="isModalOpen">
        <x-slot name="title">
            {{ $tagId ? 'Edit Tag' : 'Create Tag' }}
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <x-label for="name" value="Name" />
                <x-input id="name" type="text" class="mt-1 block w-full" wire:model.live="name" />
                <x-input-error for="name" class="mt-2" />
            </div>
            <div class="mb-4">
                <x-label for="slug" value="Slug" />
                <x-input id="slug" type="text" class="mt-1 block w-full bg-gray-50 text-gray-500" wire:model="slug" />
                <x-input-error for="slug" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeModal()" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-button class="ms-3" wire:click="store()" wire:loading.attr="disabled">
                Save
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
