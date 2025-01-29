<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <!-- Back -->
            <button onclick="window.history.back()" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </button>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Post') }}
            </h2>
        </div>
    </x-slot>

    <!-- Edytowanie posta -->
    <div class="flex justify-center w-full mt-4">
        <div class="max-w-2xl w-full bg-white border-y border-gray-200 p-4">
            <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Edycja treści -->
                <textarea id="content" name="content" rows="3" class="block w-full text-gray-700 border-none focus:ring-0 resize-none" required>{{ old('content', $post->content) }}</textarea>

                <!-- Podgląd zdjęcia -->
                <div class="mt-4">
                    <p class="text-sm text-gray-600">Photo Preview:</p>
                    <img
                        id="photo-preview"
                        src="{{ $post->photo ? asset('storage/' . $post->photo) : '' }}"
                        alt="Post Photo"
                        class="w-full max-h-64 object-contain border rounded-lg {{ $post->photo ? '' : 'hidden' }}">
                </div>

                <!-- Wybór nowego zdjęcia -->
                <div class="mt-2 flex justify-end">
                    <label
                        for="photo"
                        class="cursor-pointer mt-4 bg-[#3EA1DB] px-3 py-1 text-white text-sm rounded-lg">
                        Change Photo
                    </label>
                    <input id="photo" name="photo" type="file" class="hidden" accept="image/*" onchange="updatePhotoPreview(event)">
                </div>

                <!-- Zapisz zmiany -->
                <button type="submit" class="mt-4 bg-[#3EA1DB] text-white px-3 py-1 rounded-lg">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        function updatePhotoPreview(event) {
            const [file] = event.target.files;
            const previewImg = document.getElementById('photo-preview');

            if (file) {
                previewImg.src = URL.createObjectURL(file); // Ustaw URL do podglądu
                previewImg.classList.remove('hidden'); // Upewnij się, że obraz jest widoczny
            } else {
                previewImg.classList.add('hidden'); // Ukryj podgląd, jeśli brak pliku
            }
        }
    </script>

</x-app-layout>
