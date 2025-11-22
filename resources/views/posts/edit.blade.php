<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <form action="{{ route('posts.update', $post) }}" method="POST" class="bg-white p-6 shadow rounded-lg space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-medium">Title</label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}" class="w-full border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block font-medium">Content</label>
                <textarea name="content" rows="5" class="w-full border-gray-300 rounded-md" required>{{ old('content', $post->content) }}</textarea>
            </div>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg">Update</button>
        </form>
    </div>
</x-app-layout>
