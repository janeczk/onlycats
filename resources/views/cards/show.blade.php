<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <!-- Back -->
            <button onclick="window.location.href='{{ route(request('referer', 'home')) }}'"
                    class="text-gray-600 hover:text-gray-800 focus:outline-none mt-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </button>
            <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                {{ __('YOUR CARD') }}
            </h2>
        </div>
    </x-slot>

    <!-- Kontener z szarym tłem -->
    <div class="bg-gray-100 min-h-screen py-6">
        <div class="container mx-auto  w-full">

            @if ($card)
                <div class="bg-white shadow rounded p-6">
                    <h2 class="text-xl font-bold mb-4">Card Details</h2>
                    <p class="text-lg"><strong class="font-semibold">{{ __('Name:') }}</strong> {{ $card->name }}</p>
                    <p class="text-lg"><strong class="font-semibold">{{ __('Card Number:') }}</strong> {{ $card->number }}</p>
                    <p class="text-lg"><strong class="font-semibold">{{ __('Expiration Date:') }}</strong> {{ $card->expiration_date }}</p>
                    <p class="text-lg"><strong class="font-semibold">{{ __('CVV:') }}</strong> {{ str_repeat('*', strlen($card->cvv)) }}</p>
                </div>

                <!-- Przycisk do usuwania karty -->
                <div class="mt-6 px-4">
                    <form method="POST" action="{{ route('delete-card') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Delete Card
                        </button>
                    </form>
                </div>
            @else
                <p class="text-gray-600">No card has been added yet.</p>
            @endif

        </div>
    </div>

</x-app-layout>
