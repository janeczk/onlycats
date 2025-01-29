<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">
        <x-slot name="header">
                <!-- Updated Header -->
                <div class="flex justify-between items-center">
                    <h2 class="font-bold text-lg uppercase text-gray-800 leading-tight">
                        {{ __('Home') }}
                    </h2>
                    <!-- Optional Icon/Menu
                    <button class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6h.01M12 12h.01M12 18h.01" />
                        </svg>
                    </button>-->
                </div>
        </x-slot>

        <!-- Left Sidebar -->
        @include('layouts.navigation')

        <!-- Main Content -->
        <div class=" flex-1">
            <!-- Wrapper Div with Border -->
            <div class="w-full border-y border-gray-200">
                <!-- Text Area Section -->
                <div class="w-full">
                    <!-- Formularz dodawania posta -->
                    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="relative p-2 bg-white">
                        @csrf
                        <!-- Textarea -->
                        <textarea
                            id="content"
                            name="content"
                            rows="3"
                            class="block w-full text-gray-700 border-none focus:ring-0 placeholder-gray-500 resize-none"
                            placeholder="Compose new post..."
                            required></textarea>

                        <!-- Podgląd zdjęcia -->
                        <div id="photo-preview" class="mt-2 hidden">
                            <img id="photo-preview-img" class="w-full max-h-64 object-contain border border-gray-200 rounded-lg" alt="Photo preview">
                        </div>

                        <input type="hidden" name="redirect_to" value="home">

                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center px-2">
                                <label for="photo" class="cursor-pointer text-gray-500 hover:text-gray-700 flex items-center">
                                    <input
                                        id="photo"
                                        name="photo"
                                        type="file"
                                        class="hidden"
                                        accept="image/*"
                                        onchange="previewPhoto(event)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                    <span class="ml-1">Add Photo</span>
                                </label>
                            </div>
                            <button type="submit" class="bg-[#3EA1DB] text-white px-4 py-1 rounded-lg hover:bg-gray-800 focus:outline-none">
                                Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                function previewPhoto(event) {
                    const fileInput = event.target;
                    const previewContainer = document.getElementById('photo-preview');
                    const previewImage = document.getElementById('photo-preview-img');

                    // Sprawdź, czy użytkownik wybrał plik
                    if (fileInput.files && fileInput.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImage.src = e.target.result; // Ustaw źródło zdjęcia
                            previewContainer.classList.remove('hidden'); // Pokaż kontener podglądu
                        };
                        reader.readAsDataURL(fileInput.files[0]); // Odczytaj plik jako URL
                    } else {
                        previewContainer.classList.add('hidden'); // Ukryj kontener, jeśli nie ma pliku
                    }
                }
            </script>



            <!-- View posts -->
            <div class="flex justify-center w-full mt-2">
                <div class="w-full">
                    @include('components.view-posts', ['posts' => $posts])
                </div>
            </div>

            <!-- Additional Content Section -->
            <div class="w-full mx-auto mt-8">
                <div class="bg-white shadow-sm rounded-none">
                    <div class="p-4 text-gray-900">
                        {{ __("To see more posts subscribe to more creators.") }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
            <div class="w-64 bg-white border-l border-gray-200 p-4 h-full fixed top-0 right-0">
                @include('layouts.right-sidebar')
            </div>
    </div>
</x-app-layout>
