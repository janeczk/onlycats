<x-app-layout>


    <div class="flex bg-gray-100">

        <div class="w-full">
            <div class=" w-full bg-white shadow  mb-3">
                <div class="h-64 w-full bg-cover bg-center relative">
                    <img src="{{ $user->background_photo ? asset('storage/' . $user->background_photo) : asset('background.jpg') }}"
                         alt="Tło"
                         style="width: 100%; height: 220px; object-fit: cover;">

                    <!-- Strzałka i imię -->
                    <div class="absolute top-0 left-0 w-full flex items-center justify-between px-4 h-16">
                        <!-- Strzałka powrotu -->
                        <a href="{{ route('home') }}" class="flex items-center text-white hover:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="h-6 w-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                            </svg>
                            <span class="text-xl font-bold">{{ $user->name }}</span>
                        </a>


                        <form action="{{ route('profile.background.update') }}" method="POST" enctype="multipart/form-data" class="bg-center flex items-center space-x-2">
                            @csrf
                            <label for="background_photo" class="bg-[#3EA1DB] text-white px-4 py-2 rounded cursor-pointer ">
                                Edit Background Photo
                            </label>
                            <input type="file" id="background_photo" name="background_photo" accept="image/*" class="hidden" onchange="this.form.submit()">
                        </form>
                        <!--
                    <div class="relative group">
                        <button
                            class="p-2 text-white hover:text-gray-200 rounded-full focus:outline-none"
                            onclick="navigator.clipboard.writeText('{{ url()->current() }}');"
                            onmouseover="document.getElementById('tool').style.opacity = '1'; document.getElementById('tool').style.visibility = 'visible';"
                            onmouseout=" document.getElementById('tool').style.opacity = '0'; document.getElementById('tool').style.visibility = 'hidden';"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6h.01M12 12h.01M12 18h.01"/>
                            </svg>
                        </button>

                        <span
                            id="tool"
                            style=" position: absolute; left: -150%; transform: translateX(-50%); margin-bottom: 10px; background-color: black; color: white;
                                    padding: 5px 10px; border-radius: 5px; font-size: 12px; visibility: hidden; opacity: 0; transition: opacity 0.3s ease, visibility 0.3s ease; white-space: nowrap;">
                                    Copy link to profile
                                </span>
                    </div>-->
                    </div>
                </div>



                <div class="px-8 pb-4">
                    <div class="relative flex items-center justify-between" style="margin-top: -60px;">
                        <!-- Awatar -->
                        <x-avatar :user="$user" size="100" class="ml-8"/>

                        <!-- Kontener na przyciski -->
                        <div class="absolute right-0 flex items-end space-x-4" style="bottom: 0;">
                            <!-- Przycisk "Edit Profile" -->
                            <a href="{{ route('profile.edit') }}"
                               class="flex items-center px-6 py-3  border border-gray-300 rounded-full font-bold text-base transition duration-300"
                               style="background-color: white; color: #3EA1DB;"
                               onmouseover="this.style.backgroundColor='#dbeafe'; this.style.borderColor='#3EA1DB';"
                               onmouseout="this.style.backgroundColor='white'; this.style.borderColor='#3EA1DB';">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                     stroke="#3EA1DB" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                                {{ __('EDIT PROFILE') }}
                            </a>

                            <div class="relative group" style="display: inline-block;">
                                <button
                                    onclick="navigator.clipboard.writeText('{{ url()->current() }}');"
                                    class="relative flex items-center justify-center w-12 h-12 text-blue-500 border border-gray-300 rounded-full font-bold transition duration-300"
                                    style="background-color: white; border-color: #d1d5db;"
                                    onmouseover="this.style.backgroundColor='#dbeafe'; this.style.borderColor='#3EA1DB'; document.getElementById('tooltip').style.opacity = '1'; document.getElementById('tooltip').style.visibility = 'visible';"
                                    onmouseout="this.style.backgroundColor='white'; this.style.borderColor='#3EA1DB'; document.getElementById('tooltip').style.opacity = '0'; document.getElementById('tooltip').style.visibility = 'hidden';"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="w-6 h-6"
                                         fill="#3EA1DB" stroke-width="0.5">
                                        <path
                                            d="M568.5 177.4L424.5 313.4C409.3 327.8 384 317.1 384 296v-72c-144.6 1-205.6 35.1-164.8 171.4 4.5 15-12.8 26.6-25 17.3C155.3 383.1 120 326.5 120 269.3c0-143.9 117.6-172.5 264-173.3V24c0-21.2 25.3-31.8 40.5-17.4l144 136c10 9.5 10 25.4 0 34.9zM384 379.1V448H64V128h50.9a12 12 0 0 0 8.6-3.7c15-15.6 32.2-27.9 51-37.7C185.7 80.8 181.6 64 169 64H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-88.8c0-8.3-8.2-14.1-16-11.3a71.8 71.8 0 0 1 -34.2 3.4c-7.3-1-13.8 4.5-13.8 11.9z"/>
                                    </svg>

                                </button>

                                <!-- Tooltip -->
                                <span id="tooltip" style="position: absolute; bottom: 100%;  left: 30%; transform: translateX(-50%); margin-bottom: 10px; background-color: black;
                                    color: white; padding: 5px 10px; border-radius: 5px; font-size: 12px; visibility: hidden; opacity: 0; transition: opacity 0.3s ease, visibility 0.3s ease;  white-space: nowrap;">
                                     Copy link to profile
                                     </span>

                            </div>
                        </div>
                    </div>


                    <!-- Dane użytkownika -->
                    <div class="flex items-center justify-between mt-4">
                        <!-- Nazwa użytkownika -->
                        <p class="text-2xl font-bold">{{ $user->name }}</p>

                        <!-- Licznik obserwujących -->
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <span class="text-gray-600 text-sm">{{ $user->followers_count }} Subscriptions</span>
                        </div>
                    </div>

                    <p class="mb-2 text-gray-400"> {{ $user->username }}</p>
                    <p class="mb-2 " style="padding-bottom: 25px;">{{ $user->bio ?? 'No bio provided.' }}</p>
                </div>
            </div>
        </div>

    </div>



        <!-- Text Area Section -->
        <div class="w-full " >
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

                <input type="hidden" name="redirect_to" value="profile">
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

    <!-- POST -->


    <div class="w-full">

        <div class="bg-white shadow">
            <!-- Kontener nadrzędny, który reaguje na najechanie -->
            <div
                class="flex flex-col items-center cursor-pointer transition duration-300 ml-1 mr-1 mt-1 rounded-md"
                style="background-color: white;"
                onmouseover="this.style.backgroundColor='#dbeafe'; this.querySelector('.text').style.color='#3EA1DB'; document.getElementById('line').style.backgroundColor='#3EA1DB';"
                onmouseout="this.style.backgroundColor='white'; this.querySelector('.text').style.color='black'; document.getElementById('line').style.backgroundColor='black';">

                <!-- Kontener dla tekstu z paddingiem -->
                <div class="mr-2 ml-2 mt-2">
                    <div
                        class="text-center mb-2 mt-2 text transition duration-300">
                        @if ($posts->count() > 0)
                            <span class="text font-bold">
                        {{ $posts->count() }} POSTS
                    </span>
                        @else
                            <span class="text font-bold">
                        NO POSTS
                    </span>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Czarna kreska -->
            <div
                style="width: 100%; height: 2px; background-color: black;"
                class="line w-full h-0.5 bg-black transition duration-300"
                id="line">
            </div>



            @php
                $posts = $posts->sortByDesc('created_at');
            @endphp
                <!-- Kontener postów -->
            <div class="flex bg-gray-100 pb-3">
                <div class="flex flex-wrap w-full gap-0 mt-2 mb-3">
                    <div class="w-full ">
                        @include('components.view-posts', ['posts' => $posts])
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
