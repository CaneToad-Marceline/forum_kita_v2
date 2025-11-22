<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Posts by {{ $user->name }}
            </h2>
            <a href="{{ route('moderator.index') }}" class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                ← Back to Users
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto px-4">
        
        <!-- User Info Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white font-bold text-2xl">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-gray-500">{{ $user->email }}</p>
                        <p class="text-sm text-gray-400 mt-1">{{ $posts->count() }} {{ Str::plural('post', $posts->count()) }} total</p>
                    </div>
                </div>

                <!-- Export Button -->
                <a href="{{ route('moderator.user.export', $user) }}" 
                   class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-green-500 rounded-lg hover:bg-green-600 transition-colors shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export to Excel
                </a>
            </div>
        </div>

        <!-- Posts List -->
        <div class="space-y-4">
            @forelse($posts as $post)
                <article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-3">
                            <span class="text-sm text-gray-500">
                                {{ $post->created_at->format('M d, Y \a\t h:i A') }}
                            </span>
                            <span class="text-xs text-gray-400">
                                ID: {{ $post->id }}
                            </span>
                        </div>
                        <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $post->content }}</p>
                    </div>
                </article>
            @empty
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                    <p class="text-gray-500">This user has no posts.</p>
                </div>
            @endforelse
        </div>

    </div>
</x-app-layout>