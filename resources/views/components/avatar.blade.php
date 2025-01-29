<div class="relative flex justify-center items-center group">
    @if(!empty($user->avatar))
        <!-- Wyświetlanie avatara użytkownika -->
        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar użytkownika"
             class="rounded-full border-2 border-gray-300"
             style="width: {{ $size ?? 100 }}px; height: {{ $size ?? 100 }}px;">
    @else
        <!-- Generowanie inicjałów -->
        <div style="width: {{ $size ?? 100 }}px; height: {{ $size ?? 100 }}px;
                    background-color: #e5e7eb; border: 1px solid #ffffff;
                    border-radius: 50%; display: flex; align-items: center;
                    justify-content: center; font-size: {{ ($size ?? 100) / 4 }}px;
                    font-weight: bold; color: #3EA1DB; user-select: none;">
            @php
                $nameParts = explode(' ', $user->name);
                $initials = strtoupper(substr($nameParts[0] ?? '', 0, 1));
                if (isset($nameParts[1])) {
                    $initials .= strtoupper(substr($nameParts[1], 0, 1));
                }
            @endphp
            {{ $initials }}
        </div>
    @endif

    @if(Auth::id() === $user->id)
        <!-- Formularz przesyłania pliku -->
        <form id="avatar-form" action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" class="absolute inset-0">
            @csrf
            <input type="file" id="avatar-upload" name="avatar"
                   class="hidden"
                   onchange="document.getElementById('avatar-form').submit();">
            <!-- Przycisk "plus" -->
            <label for="avatar-upload"
                   class="absolute inset-0 bg-black bg-opacity-40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </label>
        </form>
    @endif
</div>
