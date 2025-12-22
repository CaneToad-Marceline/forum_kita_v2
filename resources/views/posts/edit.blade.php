<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Post
            </h2>
            <a href="{{ route('posts.index') }}" class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                ← Back to Posts
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto px-4">
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <form action="{{ route('posts.update', $post) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <!-- Content -->
                <div class="mb-6">
                    <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">
                        Content
                    </label>
                    <textarea 
                        name="content" 
                        id="content"
                        rows="6" 
                        class="w-full border-gray-300 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="What's on your mind?"
                        required
                    >{{ old('content', $post->content) }}</textarea>
                    
                    @error('content')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('posts.index') }}" 
                       class="text-gray-600 hover:text-gray-800 font-medium">
                        Cancel
                    </a>
                    
                    <button 
                        type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2.5 rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md"
                    >
                        Update Post
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>