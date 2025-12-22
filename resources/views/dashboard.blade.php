<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Feed
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto space-y-4 px-4">

        <!-- ✅ Post Composer -->
        @auth
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('posts.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="flex items-start space-x-4">
                        <!-- User Avatar Placeholder -->
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white font-semibold text-lg">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </div>

                        <!-- Textarea -->
                        <div class="flex-1">
                            <textarea 
                                name="content" 
                                rows="3" 
                                class="w-full border-0 focus:ring-0 resize-none text-gray-800 placeholder-gray-400 text-lg"
                                placeholder="What's happening?"
                                required
                            ></textarea>
                        </div>
                    </div>

                    <!-- Bottom Bar -->
                    <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100">
                        <div class="text-sm text-gray-500">
                            <!-- You can add character count here later -->
                        </div>
                        <button 
                            type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2.5 rounded-full transition-colors duration-200 shadow-sm hover:shadow-md"
                        >
                            Post
                        </button>
                    </div>
                </form>
            </div>
        @endauth

        <!-- 📰 Posts Feed -->
        @forelse ($posts as $post)
            <article class="bg-white rounded-xl shadow-sm border border-gray-100 hover:border-gray-200 transition-all duration-200 overflow-hidden">
                <div class="p-6">
                    <!-- Post Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <!-- User Avatar -->
                            <div class="w-11 h-11 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center text-white font-semibold">
                                {{ substr($post->user->name ?? 'U', 0, 1) }}
                            </div>
                            
                            <!-- User Info -->
                            <div>
                                <h3 class="font-semibold text-gray-900 text-base">
                                    {{ $post->user->name ?? 'Unknown User' }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    {{ $post->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        <!-- Optional: Actions Menu -->
                        @if(auth()->check() && auth()->id() === $post->user_id)
                            <div class="text-gray-400 hover:text-gray-600 cursor-pointer">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Post Content -->
                    <div class="mt-3">
                        <p class="text-gray-800 text-base leading-relaxed whitespace-pre-wrap">{{ $post->content }}</p>
                    </div>

                    <!-- Post Actions (Like, Comment, Share) -->
                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center space-x-6 text-gray-500">
                        
                    </div>
                </div>
            </article>
        @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No posts yet</h3>
                <p class="text-gray-500">Be the first to share something!</p>
            </div>
        @endforelse

    </div>
</x-app-layout>