<x-app-layout>


    <div class="flex bg-gray-100">

        <div class="w-full">
            <div class=" w-full bg-white shadow  mb-3">
                <div class="h-64 w-full bg-cover bg-center relative">
                    <!-- DO EDYCJI -->
                    <img src="{{ asset('background.jpg') }}" alt="Tło"
                         style="width: 100%; height: 220px; object-fit: cover;">

                    <!-- Strzałka i imię -->
                    <div class="absolute top-0 left-0 w-full flex items-center justify-between px-4 h-16">
                        <!-- Strzałka powrotu -->
                        <a href="{{ route('home') }}"  class="flex items-center text-white hover:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="h-6 w-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                            </svg>
                            <span class="text-xl font-bold">{{ $user->name }}</span>
                        </a>


                        <!-- Trzy kropki
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
                            Tooltip
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

                            <div class="relative group" style="display: inline-block;">
                                <button
                                    onclick="navigator.clipboard.writeText('{{ url()->current() }}');"
                                    class="relative flex items-center justify-center w-12 h-12 text-blue-500 border border-gray-300 rounded-full font-bold transition duration-300"
                                    style="background-color: white; border-color: #3EA1DB;"
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
                    <p class="mt-4 text-2xl"><strong>{{ $user->name }}</strong></p>

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

    <!--Subowanie-->
    <div class="flex bg-gray-100">
        <div class="w-full mb-3">
            <div class="bg-white">
                <!-- Przycisk obserwuj / odobserwuj -->
                <div class="p-4">
                    @if (auth()->user()->isFollowing($user))
                        <!-- Przycisk odobserwuj -->
                        <div class="flex justify-end">
                            <form action="{{ route('unfollow', $user) }}" method="POST" id="unsubscribeForm">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        class="text-sm px-3 py-1.5 bg-[#3EA1DB] text-white font-bold rounded"
                                        onclick="showConfirmationModal();">
                                    Unsubscribe
                                </button>
                            </form>
                        </div>

                        <!-- Modal -->
                        <div id="confirmationModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
                            <div class="bg-white p-6 rounded shadow-lg text-center">
                                <p class="mb-4 text-lg">Are you sure you want to unsubscribe this person?</p>
                                <div class="flex justify-center space-x-4">
                                    <button onclick="confirmUnsubscribe();" class="px-4 py-2 bg-[#3EA1DB] text-white rounded">Yes</button>
                                    <button onclick="closeConfirmationModal();" class="px-4 py-2 bg-gray-300 text-black rounded">No</button>
                                </div>
                            </div>
                        </div>

                        <script>
                        function showConfirmationModal() {
                        document.getElementById('confirmationModal').classList.remove('hidden');
                        }

                        function closeConfirmationModal() {
                        document.getElementById('confirmationModal').classList.add('hidden');
                        }

                        function confirmUnsubscribe() {
                        document.getElementById('unsubscribeForm').submit();
                        }
                        </script>


                        <!-- POST -->
                        <div class="w-full">
                                <div
                                    class="flex flex-col items-center cursor-pointer transition duration-300 ml-1 mr-1 mt-1 rounded-md"
                                    style="background-color: white;"
                                    onmouseover="this.style.backgroundColor='#dbeafe'; this.querySelector('.text').style.color='#3EA1DB'; document.getElementById('line').style.backgroundColor='#3EA1DB';"
                                    onmouseout="this.style.backgroundColor='white'; this.querySelector('.text').style.color='black'; document.getElementById('line').style.backgroundColor='black';">

                                    <div class="mr-2 ml-2 mt-2">
                                        <div class="text-center mb-2 mt-2 text transition duration-300">
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
                                <div
                                    style="width: 100%; height: 2px; background-color: black;"
                                    class="line w-full h-0.5 bg-black transition duration-300"
                                    id="line">
                                </div>

                                @php
                                    $posts = $posts->sortByDesc('created_at');
                                @endphp
                                    <div class="flex flex-wrap w-full gap-0 mt-2 mb-3">
                                        <div class="w-full">
                                            @include('components.view-posts', ['posts' => $posts])
                                        </div>
                                    </div>
                        </div>
                        @else
                            <!-- Przycisk obserwuj -->
                            @include('profile.partials.subscription', ['user' => $user])
                        @endif
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
