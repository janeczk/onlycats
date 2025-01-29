<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List of Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($posts->isEmpty())
                        <p>There are no posts in the database.</p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($posts as $post)
                                <a href="{{ route('posts.show', $post) }}" class="block bg-white border border-gray-200 shadow-md rounded-lg p-4 hover:bg-gray-100">
                                    <div class="text-gray-700 text-lg font-medium mb-4">
                                        {{ $post->content }}
                                    </div>
                                    <div class="mt-2 text-sm text-gray-600">
                                        Added by: {{ $post->user->name }}
                                    </div>

                                    <div class="mt-4 text-right text-sm text-gray-500">
                                        Added on: {{ $post->created_at->format('Y-m-d H:i') }}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                    <form method="GET" action="{{ route('posts.create') }}" class="pt-6">
                        <x-primary-button>
                            {{ __('Create new post') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
