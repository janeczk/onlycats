<div class="h-full flex flex-col p-4 bg-white border-l border-gray-200">
    <!-- Search Section -->
    <!-- Search Section -->
    <form method="GET" action="{{ route('search') }}" class="mb-8 flex items-center">
        <div class="relative" style="width: 50%;"> <!-- Ustaw szerokość inputa na taką jak wcześniej -->
            <input type="text" name="query"
                   class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring focus:ring-blue-200 focus:border-blue-500"
                   placeholder="Search"
                   value="{{ request('query') }}" />
            <button type="submit" class="absolute inset-y-0 right-3 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 3a6 6 0 100 12 6 6 0 000-12zM2 9a7 7 0 1114 0 7 7 0 01-14 0z" clip-rule="evenodd" />
                    <path d="M12.293 12.293a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414z" />
                </svg>
            </button>
        </div>
    </form>



    <!-- Suggestions Section -->
    <div class="flex flex-col">
        <h3 class="text-sm font-semibold text-gray-600 mb-2">SUGGESTIONS</h3>
        @if(!empty($suggestedProfiles) && $suggestedProfiles->isNotEmpty())
            <ul class="space-y-4">
                @foreach ($suggestedProfiles as $profile)
                    <!-- Kafelka jako link -->
                    <a href="{{ route('profile.public', ['username' => $profile->username]) }}" class="block">
                        <li class="relative rounded-lg shadow-lg overflow-hidden hover:bg-gray-100 transition">
                            <!-- Tło -->
                            <img
                                src="{{ $profile->background_photo ? asset('storage/' . $profile->background_photo) : asset('background.jpg') }}"
                                alt="Tło"
                                class="w-full object-cover"
                                style="height: 150px;"
                            />

                            <!-- Czarny przezroczysty pasek z informacjami -->
                            <div class="absolute bottom-0 left-0 w-full flex items-center px-4 py-3" style="background-color: rgba(0, 0, 0, 0.5);">
                                <!-- Tekstowe informacje o użytkowniku -->
                                <div class="text-white flex-1" style="margin-left: 100px;">
                                    <h4 class="text-xl font-medium flex items-center">
                                        {{ $profile->name }}
                                        @if($profile->is_verified)
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 text-blue-500 ml-1">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m2-2a9 9 0 11-12 12 9 9 0 0112-12z" />
                                            </svg>
                                        @endif
                                    </h4>
                                    <p class="text-sm">
                                        {{ $profile->username }}
                                    </p>
                                </div>
                            </div>

                            <!-- Avatar -->
                            <div class="absolute" style="transform: translateY(50%); z-index: 10; bottom: 65px; left:15px;">
                                <x-avatar :user="$profile" size="80" class="rounded-full border-2 border-white shadow" />
                            </div>
                        </li>
                    </a>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500 text-center">No suggestions available.</p>
        @endif
    </div>
</div>
