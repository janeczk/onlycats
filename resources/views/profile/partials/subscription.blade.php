<section class="subscription m-6 p-6">
    <h3 class="text-base font-semibold text-gray-600 mb-2">SUBSCRIPTION</h3>
    <h2 class="mb-4 text-lg font-bold">Limited offer - Free trial for 30 days!</h2>
    <div class="subscription-content bg-gray-50 mb-4 rounded-lg py-4 relative flex items-center gap-4">
        <!-- Avatar -->
        <div class="absolute" style="left: -20px; top: -6px;">
            <x-avatar :user="$user" size="50" class="rounded-full border-2 border-white shadow" />
        </div>

        <!-- Tekst -->
        <p class="text-gray-700 ml-12">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Proin est odio, commodo sit amet vestibulum nec, maximus id ex.
        </p>
    </div>

    <!-- Formularz subskrypcji -->
    @if (auth()->check() && !auth()->user()->isFollowing($user))
        @if (auth()->user()->hasCard())
            <!-- Formularz subskrypcji (użytkownik ma kartę) -->
            <form action="{{ route('follow', $user) }}" method="POST">
                @csrf
                <button type="submit" class="bg-[#3EA1DB] text-white px-4 py-2 rounded-full hover:bg-gray-800 focus:outline-none w-full flex justify-between items-center text-center">
                    <span>SUBSCRIBE</span>
                    <span>FREE for 30 DAYS</span>
                </button>
            </form>
        @else
            <!-- Link do dodania karty (użytkownik nie ma karty) -->
            <a href="{{ route('add-card', ['from' => 'subscription', 'username' => $user->username]) }}" class="bg-[#3EA1DB] text-white px-4 py-2 rounded-full hover:bg-gray-800 focus:outline-none w-full flex justify-between items-center text-center">
                <span>SUBSCRIBE</span>
                <span>FREE for 30 DAYS</span>
            </a>
        @endif
    @else
        <!-- Wyświetl informację, że użytkownik już subskrybuje -->
        <div class="bg-gray-200 text-gray-700 px-4 py-2 rounded">
            You are already subscribed to this user.
        </div>
    @endif


    <p class="text-gray-400 mt-2 mb-2">Regular price $19.99 / month</p>
</section>
