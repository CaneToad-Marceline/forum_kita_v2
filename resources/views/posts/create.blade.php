<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <form action="{{ route('posts.store') }}" method="POST" class="bg-white p-6 shadow rounded-lg space-y-4">
            @csrf
            <div>
                <label class="block font-medium">Content</label>
                <textarea name="content" rows="5" class="w-full border-gray-300 rounded-md" required></textarea>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Publish</button>
        </form>
    </div>
</x-app-layout>
