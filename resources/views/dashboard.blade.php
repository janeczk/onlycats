<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <button onclick="window.location.href='{{ route(request('referer', 'home')) }}'"
                    class="text-gray-600 hover:text-gray-800 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
            </button>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Subscribers') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="tabs flex border-b">
                    <button id="tab-your-subscribers"
                            class="tab-button font-semibold py-2 px-4 text-gray-600 border-b-2 border-transparent ">
                        {{ __('Your Subscribers') }}
                    </button>
                    <button id="tab-subscribed"
                            class="tab-button font-semibold py-2 px-4 text-gray-600 border-b-2 border-transparent">
                        {{ __('Subscribed') }}
                    </button>
                </div>
                <div id="content" class="mt-4">
                    <p class="text-gray-500">{{ __('Loading...') }}</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const contentDiv = document.getElementById('content');
            const buttons = document.querySelectorAll('.tab-button');

            function loadTab(tab) {
                // Reset all button styles
                buttons.forEach(btn => {
                    btn.classList.remove('border-[#3EA1DB]', 'text-[#3EA1DB]', 'font-bold');
                    btn.classList.add('text-gray-600', 'border-transparent', 'hover:border-[#3EA1DB]', 'hover:text-[#3EA1DB]');
                });

                // Highlight the active button
                const activeButton = document.getElementById(`tab-${tab}`);
                activeButton.classList.add('border-[#3EA1DB]', 'text-[#3EA1DB]', 'font-bold', 'hover:border-[#3EA1DB]');
                activeButton.classList.remove('text-gray-600', 'border-transparent');


                // Fetch content dynamically
                fetch(`/subscribers/${tab}`)
                    .then(response => response.json())
                    .then(data => {
                        contentDiv.innerHTML = data.html;
                    })
                    .catch(error => {
                        contentDiv.innerHTML = `<p class="text-red-500">{{ __('Failed to load content.') }}</p>`;
                    });
            }

            // Load default tab
            loadTab('your-subscribers');

            // Handle tab clicks
            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    const tab = this.id.replace('tab-', '');
                    loadTab(tab);
                });
            });
        });
    </script>
</x-app-layout>
