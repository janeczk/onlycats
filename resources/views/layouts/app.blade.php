<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Logo -->
    <link rel="icon" href="https://imgur.com/pVmaZrh.png" type="image/png">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="min-h-screen flex">
    <!-- Left Sidebar (Navigation) -->
    <div class="bg-white border-r border-gray-200 h-screen fixed top-0 left-0 w-[30%]">
        @include('layouts.navigation')
    </div>

    <!-- Main Content Wrapper -->
    <div class="ml-[30%] mr-[30%] w-[40%]">
        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Right Sidebar (Search) -->
    <div class="bg-white border-l border-gray-200 h-screen fixed top-0 right-0 w-[30%]">
        @include('layouts.right-sidebar')
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Pobieramy wszystkie ikony serca
        document.querySelectorAll('.like-icon').forEach(icon => {
            icon.addEventListener('click', function (event) {
                event.preventDefault(); // Zapobiega domyślnemu działaniu
                event.stopPropagation(); // Zatrzymuje propagację kliknięcia

                const postId = this.dataset.postId; // ID posta
                const liked = this.dataset.liked === 'true'; // Czy polubiono

                // Wysyłamy żądanie do serwera
                axios.post(`/posts/${postId}/like`, {})
                    .then(response => {
                        // Zaktualizuj ikonę serca
                        this.dataset.liked = response.data.liked ? 'true' : 'false';
                        this.setAttribute('fill', response.data.liked ? 'red' : 'none');

                        // Zaktualizuj liczbę polubień
                        const likesCount = this.nextElementSibling;
                        likesCount.textContent = response.data.likes_count;
                    })
                    .catch(error => console.error('Błąd:', error));
            });
        });
    });

    //edytowanie i usuwanie postow
    document.addEventListener('DOMContentLoaded', function () {
        const optionsBtn = document.getElementById('options-btn');
        const optionsMenu = document.getElementById('options-menu');

        if (optionsBtn) {
            optionsBtn.addEventListener('click', function () {
                optionsMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', function (e) {
                if (!optionsBtn.contains(e.target) && !optionsMenu.contains(e.target)) {
                    optionsMenu.classList.add('hidden');
                }
            });
        }
    });
</script>
</body>
</html>
