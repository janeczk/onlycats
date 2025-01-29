<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <!-- Back -->
            <button onclick="window.location.href='{{ route($referer, $referer === 'profile.public' ? ['username' => $post->user->username] : ($referer === 'search' ? ['query' => request('query')] : [])) }}'"
                    class="text-gray-600 hover:text-gray-800 focus:outline-none">
                <!-- Ikona -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </button>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Post') }}
            </h2>
        </div>
    </x-slot>

    <!-- Wyświetlanie posta -->
    <div class="flex justify-center w-full">
        <div class="max-w-2xl w-full">
            <div class="block w-full bg-white border-y border-gray-200 rounded-none p-6">
                <!-- Header Section -->
                <div class="flex justify-between items-start">
                    <div class="flex items-center space-x-2">
                        <!-- Avatar -->
                        <x-avatar :user="$post->user" size="50" class="rounded-full" />

                        <!-- Name and Username -->
                        <div>
                            <div class="text-gray-900 font-bold">
                                <a href="{{ route('profile.public', $post->user->username) }}" class="hover:underline">
                                    {{ $post->user->name }}
                                </a>
                            </div>
                            <div class="text-gray-600">
                                <a href="{{ route('profile.public', $post->user->username) }}" class="hover:underline">
                                    {{ $post->user->username }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Time -->
                    <div class="flex items-center space-x-2 text-sm text-gray-500">
                        <span>{{ $post->created_at->diffForHumans() }}</span>

                        @if (auth()->id() === $post->user_id)
                            <!-- Ikona opcji -->
                            <div class="relative">
                                <button id="options-btn" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                    </svg>
                                </button>

                                <!-- Dropdown menu -->
                                <div id="options-menu" class="hidden absolute right-0 w-28 bg-white border border-gray-200 rounded shadow-lg">
                                    <a href="{{ route('posts.edit', $post->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('posts.destroy', $post->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="redirect_url" value="{{ url()->previous() }}">
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Treść posta -->
                <div class="post">
                    <p class="text-gray-800 mb-4 pt-3">{{ $post->content }}</p>

                    <!-- Wyświetlanie zdjęcia, jeśli istnieje -->
                    @if($post->photo)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $post->photo) }}" alt="Post photo" class="w-full h-auto rounded-lg">
                        </div>
                    @endif

                    <div class="flex items-center space-x-4">
                        <!-- Ikona polubień -->
                        <div class="flex items-center space-x-1 cursor-pointer">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="{{ $post->userLiked() ? 'red' : 'none' }}"
                                viewBox="0 0 24 24"
                                stroke-width="1.2"
                                stroke="currentColor"
                                class="w-6 h-6 like-icon"
                                data-post-id="{{ $post->id }}"
                                data-liked="{{ $post->userLiked() ? 'true' : 'false' }}">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                            <span class="text-gray-600 text-sm likes-count">{{ $post->likes->count() }}</span>
                        </div>

                        <!-- Ikona komentarzy -->
                        <div class="flex items-center space-x-1 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#3EA1DB" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
                            </svg>
                            <span class="text-gray-600 text-sm">{{ $post->comments->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sekcja komentarzy -->
            <div class="text-gray-300 px-4 rounded-lg">
                @foreach ($post->comments as $comment)
                    <div class="text-gray-300 p-4 rounded-lg mt-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p>
                                    <span class="font-bold text-gray-600 text-sm">{{ $comment->user->name ?? 'Unknown User' }}</span>
                                    <span class="text-gray-900 text-sm ml-2">{{ $comment->text }}</span>
                                </p>
                                <span class="text-xs text-gray-400">{{ $comment->created_at->format('g:i a') }}</span>
                            </div>

                            @if (auth()->id() === $comment->user_id)
                                <form method="POST" action="{{ route('comments.destroy', $comment->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-gray-500 hover:text-red-500 text-sm">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
                    <form method="POST" action="{{ route('comments.store') }}" class="flex items-center mt-4 mb-10">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}" />
                        <input type="hidden" name="referer" value="{{ request()->input('referer', 'home') }}" />
                        <input type="hidden" name="query" value="{{ request('query', '') }}" />
                        <input type="text" name="text" placeholder="Add a comment..." class="flex-grow p-2 text-gray-600 placeholder-gray-400 rounded-none focus:outline-none focus:ring-1 focus:ring-[#3EA1DB]" required/>
                        <button type="submit" class="bg-[#3EA1DB] ml-2 p-2 text-white rounded-full z-index=1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                            </svg>
                        </button>
                    </form>

            </div>
        </div>
    </div>
</x-app-layout>
