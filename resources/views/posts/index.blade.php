<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Posts') }}
            </h2>
            <a href="{{ route('posts.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                + New Post
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        @foreach ($posts as $post)
            <div class="bg-white p-5 shadow mb-4 rounded-lg">
                <h3 class="text-lg font-bold">{{ $post->title }}</h3>
                <p class="text-gray-700">{{ $post->content }}</p>
                <div class="mt-3 flex justify-end space-x-2">
                    <a href="{{ route('posts.edit', $post) }}" class="text-blue-600">Edit</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Delete this post?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach

        @if ($posts->isEmpty())
            <p class="text-center text-gray-500">You haven’t made any posts yet.</p>
        @endif
    </div>
</x-app-layout>
