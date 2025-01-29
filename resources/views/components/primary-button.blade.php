<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#3EA1DB] text-white border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-800 focus:outline-none transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
