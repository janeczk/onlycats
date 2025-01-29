<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Wyświetla profil zalogowanego użytkownika (ścieżka: /profile).
     *
     * @return View
     */
    public function show()
    {
        $user = Auth::user(); // Pobranie aktualnie zalogowanego użytkownika
        if (!$user) {
            abort(403, 'Unauthorized action.');
        }
        $posts = $user->posts()->latest()->get(); // Pobiera posty użytkownika
        return view('profile.show', [
            'user' => $user,
            'posts' => $user->posts, // Przekazanie kolekcji postów użytkownika
            'followers_count' => $user->followers()->count(), // Liczba obserwujących
        ]);
    }

    /**
     * Wyświetla profil dowolnego użytkownika (ścieżka: /{username}).
     *
     * @param string $username
     * @return View
     */
    public function showPublic(string $username): View
    {
        $user = User::where('username', $username)->firstOrFail();
        return view('profile.public', [
            'user' => $user,
            'posts' => $user->posts,
        ]);
    }



    /**
     * Aktualizuje dane profilu użytkownika.
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        // Pobranie aktualnie zalogowanego użytkownika
        $user = Auth::user();

        // Zabezpieczenie przed przypadkiem, gdy użytkownik nie jest zalogowany
        if (!$user) {
            abort(403, 'Unauthorized action.');
        }

        /**
         * @var array<string, mixed> $validated
         */
        // Walidacja danych wejściowych
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id], // Unikalna nazwa użytkownika
            'bio' => ['nullable', 'string', 'max:500'],   // Opcjonalna biografia

        ]);

        // Aktualizacja danych użytkownika
        $user->update($validated);

        // Przekierowanie na stronę profilu z komunikatem o sukcesie
        return redirect()->route('profile.show')->with('status', 'profile-updated');
    }
    /**
     * Aktualizuje avatar użytkownika.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateAvatar(Request $request): RedirectResponse
    {
        // Pobierz zalogowanego użytkownika
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized action.');
        }

        // Walidacja pliku
        $validated = $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $file = $request->file('avatar');

        if ($file instanceof \Illuminate\Http\UploadedFile && $file->isValid()) {
            // Zapis pliku w katalogu 'avatars'
            $path = $file->store('avatars', 'public');
            if ($path) {
                // Usuń poprzedni plik, jeśli istnieje
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }

                // Zaktualizuj ścieżkę w bazie danych
                $user->avatar = $path;
                $user->save();
            }
        } else {
            return back()->withErrors(['avatar' => 'Nie udało się przesłać pliku.']);
        }

        return redirect()->route('profile.show', ['user' => $user->id])
            ->with('status', 'Avatar zaktualizowany pomyślnie.');
    }
    public function updateBackground(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'background_photo' => ['required', 'image', 'max:4096'], // Maksymalny rozmiar pliku: 4 MB
        ]);

        // Przechowywanie nowego pliku w folderze "backgrounds"
        $path = null; // Domyślnie ustawiamy na null
        if ($request->hasFile('background_photo') && $request->file('background_photo') instanceof \Illuminate\Http\UploadedFile) {
            $path = $request->file('background_photo')->store('backgrounds', 'public');
            $path = $path !== false ? $path : null; // Ustawiamy null, jeśli store się nie powiedzie
        }

        // Usunięcie starego zdjęcia tła (jeśli istnieje)
        if ($user->background_photo) {
            Storage::disk('public')->delete($user->background_photo);
        }

        // Aktualizacja zdjęcia tła w bazie danych
        $user->background_photo = $path;

        $user->save();

        return redirect()->route('profile.show')->with('status', 'Background photo updated successfully.');
    }

}
