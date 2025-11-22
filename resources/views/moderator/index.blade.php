<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Moderator Dashboard
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto px-4">
        
        <!-- Header Card -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl shadow-lg p-6 mb-6 text-white">
            <h1 class="text-2xl font-bold mb-2">User Posts Management</h1>
            <p class="opacity-90">Select a user to view their posts or export to Excel</p>
        </div>

        <!-- Users List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">All Users with Posts</h3>
            </div>

            @if($users->isEmpty())
                <div class="p-12 text-center">
                    <p class="text-gray-500">No users with posts found.</p>
                </div>
            @else
                <div class="divide-y divide-gray-100">
                    @foreach($users as $user)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <div class="flex items-center space-x-4">
                                <!-- Avatar -->
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white font-semibold text-lg">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                
                                <!-- User Info -->
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $user->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                </div>

                                <!-- Post Count Badge -->
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ $user->posts_count }} {{ Str::plural('post', $user->posts_count) }}
                                </span>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center space-x-3">
                                <!-- View Posts -->
                                <a href="{{ route('moderator.user.posts', $user) }}" 
                                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    View
                                </a>

                                <!-- Export -->
                                <a href="{{ route('moderator.user.export', $user) }}" 
                                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-lg hover:bg-green-600 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Export
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-app-layout>