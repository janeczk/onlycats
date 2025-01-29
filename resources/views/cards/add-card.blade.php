
    <x-app-layout>
        @if ($card)
            <script>
                // Automatyczne przekierowanie na /cards, jeśli karta już istnieje
                window.location.href = "{{ route('cards.show') }}";
            </script>
        @endif






        <form method="POST" action="{{ route('store-card') }}">
            @csrf
            <!-- Ukryte pole z informacją o źródle -->
            <input type="hidden" name="from" value="{{ request('from', 'add-card') }}">
        </form>

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
                    {{ __('ADD CARD') }}
                </h2>
            </div>
        </x-slot>

            <div class="bg-gray-100 min-h-screen py-6">

        <div class="bg-white  p-6 w-full mx-auto mt-2">
            @if (session('status'))
                <div class="bg-gray-200 text-black p-3 rounded mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('store-card') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $card->email ?? auth()->user()->email }}" readonly>
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name on the Card</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('name', $card->name ?? '') }}"
                        required>
                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- numer karty -->
                <div>
                    <label for="number" class="block text-sm font-medium text-gray-700">Card Number</label>
                    <input
                        type="text"
                        name="number"
                        id="number"
                        maxlength="16"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('number', $card->number ?? '') }}"
                        required>
                    @error('number')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <div class="grid grid-cols-2 gap-4">
                    <!--- data -->
                    <div>
                        <label for="expiration_date" class="block text-sm font-medium text-gray-700">Expiration (MM / YY)</label>
                        <input type="text" name="expiration_date" id="expiration_date" placeholder="MM/YY" maxlength="5" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('expiration_date') }}" required>
                        @error('expiration_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- CVV -->
                    <div>
                        <label for="cvv" class="block text-sm font-medium text-gray-700">CVV</label>
                        <input type="password"
                               name="cvv"
                               id="cvv"
                               maxlength="3"
                               inputmode="numeric"
                               pattern="\d{3}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('cvv') }}"
                               required>
                        @error('cvv')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                @csrf
                <input type="hidden" name="from" value="{{ request('from', 'add-card') }}">
                <input type="hidden" name="username" value="{{ request('username', '') }}"> <!-- Przekazanie username -->
                <div class="mt-6">
                    <button type="submit" class="bg-[#3EA1DB] text-white px-4 py-2 rounded-md hover:bg-gray-800 w-full">
                        Submit
                    </button>
                </div>
            </form>
        </div>
            </div>
        <script>
            //tylko cyfry cvv
            document.addEventListener('DOMContentLoaded', function () {
                const cvvInput = document.getElementById('cvv');

                cvvInput.addEventListener('input', function (e) {
                    // Usuń wszystkie znaki inne niż cyfry
                    e.target.value = e.target.value.replace(/[^0-9]/g, '');
                });
            });

            //data

            document.addEventListener('DOMContentLoaded', function () {
                const expirationDateInput = document.getElementById('expiration_date');
                const errorMessage = document.createElement('p'); // Element do wyświetlania komunikatu błędu
                errorMessage.classList.add('text-red-500', 'text-xs', 'mt-1');
                expirationDateInput.parentElement.appendChild(errorMessage); // Dodaj komunikat pod polem

                expirationDateInput.addEventListener('input', function (e) {
                    let value = e.target.value;

                    // Automatyczne dodanie "/" po dwóch cyfrach
                    if (value.length === 2 && !value.includes('/')) {
                        e.target.value = value + '/';
                    }

                    // Usuń wszystkie nieprawidłowe znaki (tylko cyfry i "/")
                    e.target.value = e.target.value.replace(/[^0-9/]/g, '');

                    // Walidacja w czasie rzeczywistym
                    errorMessage.textContent = ''; // Wyczyść poprzedni komunikat błędu
                    const currentDate = new Date();
                    const currentMonth = currentDate.getMonth() + 1; // Miesiące od 0 do 11
                    const currentYear = currentDate.getFullYear() % 100; // Ostatnie dwie cyfry roku

                    // Sprawdź, czy format jest poprawny MM/YY
                    if (!/^\d{2}\/\d{2}$/.test(e.target.value)) {
                        errorMessage.textContent = 'Invalid date format. Use MM/YY.';
                        return;
                    }

                    const [month, year] = e.target.value.split('/').map(Number);

                    // Sprawdź, czy miesiąc jest między 1 a 12
                    if (month < 1 || month > 12) {
                        errorMessage.textContent = 'The month must be between 01 and 12.';
                        return;
                    }

                    // Sprawdź, czy data nie minęła
                    if (year < currentYear || (year === currentYear && month < currentMonth)) {
                        errorMessage.textContent = 'The expiration date has already passed.';
                        return;
                    }
                });

                expirationDateInput.addEventListener('keydown', function (e) {
                    // Obsługa usuwania "/" w przypadku backspace
                    if (e.key === 'Backspace') {
                        let value = e.target.value;
                        if (value.length === 3 && value.includes('/')) {
                            e.target.value = value.slice(0, 2);
                        }
                    }
                });
            });


            //numer
            document.addEventListener('DOMContentLoaded', function () {
                const numberInput = document.getElementById('number');

                numberInput.addEventListener('input', function (e) {
                    // Usuń wszystkie znaki, które nie są cyframi
                    e.target.value = e.target.value.replace(/[^0-9]/g, '');
                });
            });

            //nazwa
            document.addEventListener('DOMContentLoaded', function () {
                const nameInput = document.getElementById('name');

                nameInput.addEventListener('input', function (e) {
                    // Usuń cyfry i znaki specjalne
                    e.target.value = e.target.value.replace(/[^a-zA-Z\s'-]/g, '');
                });
            });
        </script>
    </x-app-layout>

