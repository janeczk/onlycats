<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Search Results') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            @if(isset($error))
                <p class="text-gray-500 pl-6">{{ $error }}</p>
            @else
                <!-- Zakładki -->
                <div class="tabs flex justify-center space-x-20 border-b">
                    <button id="tab-profiles"
                            class="tab-button font-semibold py-2 px-6 text-gray-600 border-b-2 border-transparent hover:text-[#3EA1DB] hover:border-[#3EA1DB] focus:outline-none">
                        {{ __('Profiles') }}
                    </button>
                    <button id="tab-posts"
                            class="tab-button font-semibold py-2 px-6 text-gray-600 border-b-2 border-transparent hover:text-[#3EA1DB] hover:border-[#3EA1DB] focus:outline-none">
                        {{ __('Posts') }}
                    </button>
                </div>


                <!-- Zawartość zakładki "Profiles" -->
                <div id="content-profiles" class="tab-content mb-6">
                    @if(!$users->isEmpty())
                        <ul class="list-none">
                            @foreach($users as $user)
                                <li class="flex items-center space-x-4 py-4 pl-4 border-b">
                                    <a href="{{ route('profile.public', ['username' => $user->username]) }}" class="flex items-center space-x-3 hover:underline">
                                        <x-avatar :user="$user" size="50" class="rounded-full border-2 border-gray-100 shadow" />
                                        <div>
                                            <span class="text-lg font-medium text-gray-700">{{ $user->name }}</span>
                                            <span class="text-sm text-gray-500">{{ $user->username }}</span>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="flex items-center justify-center text-gray-500 pl-4 mt-6">{{ __('No profiles matching') }}</p>
                    @endif
                </div>

                <!-- Zawartość zakładki "Posts" -->
                <div id="content-posts" class="tab-content hidden">
                    @if(!$posts->isEmpty())
                        @include('components.view-posts', ['posts' => $posts, 'referer' => 'search', 'query' => $query])
                    @else
                        <p class="flex items-center justify-center text-gray-500 pl-4 mt-6">{{ __('No posts matching') }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.tab-button');
            const contents = document.querySelectorAll('.tab-content');

            function switchTab(tabId) {
                // Zapamiętaj aktywną zakładkę w localStorage
                localStorage.setItem('activeTab', tabId);

                tabs.forEach(tab => {
                    tab.classList.remove('text-[#3EA1DB]', 'border-[#3EA1DB]');
                    tab.classList.add('text-gray-600', 'border-transparent');
                });

                contents.forEach(content => {
                    content.classList.add('hidden');
                });

                const activeTab = document.getElementById(`tab-${tabId}`);
                activeTab.classList.add('text-[#3EA1DB]', 'border-[#3EA1DB]');
                activeTab.classList.remove('text-gray-600', 'border-transparent');
                document.getElementById(`content-${tabId}`).classList.remove('hidden');
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    const tabId = this.id.replace('tab-', '');
                    switchTab(tabId);
                });
            });

            const savedTab = localStorage.getItem('activeTab') || 'profiles';
            switchTab(savedTab);
        });
    </script>
</x-app-layout>
