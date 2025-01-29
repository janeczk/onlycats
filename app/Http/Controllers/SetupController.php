<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SetupController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            //'background' => $request->user()->background_image ? Storage::url($request->user()->background_image) : null,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        //$user = $request->user();

        abort_if(!$request->user(), 500);

        $validatedData = $request->validated();
        $request->user()->fill($request->validated());
        /*
                // Obsługa przesłania obrazu tła
                if ($request->hasFile('background_image')) {
                    $validatedData['background_image'] = $this->handleBackgroundImage($request, $user);
                }
        */
        // Aktualizacja danych użytkownika
        // $user->fill($validatedData);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        abort_if(!$user, 500);

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Handle the upload and storage of the background image.
     */
    /*
     protected function handleBackgroundImage(Request $request, $user): string
     {
         // Usuń istniejący obraz
         if ($user->background_image) {
             Storage::disk('public')->delete($user->background_image);
         }

         // Zapisz nowy obraz
         return $request->file('background_image')->store('backgrounds', 'public');
     }
*/

}
