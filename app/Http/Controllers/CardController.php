<?php

namespace App\Http\Controllers;

use Closure;
use App\Models\User;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class CardController extends Controller
{
    /**
     * Przechowuje dane karty w bazie danych.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $expirationDate = $request->input('expiration_date', '');

        if (is_string($expirationDate) && !str_contains($expirationDate, '/')) {
            $expirationDate = substr_replace($expirationDate, '/', 2, 0);
        }

        $messages = [
            'number.digits' => 'The card number must be exactly 16 digits.',
            'name.regex' => 'The name on the card must contain only letters, spaces, or hyphens.',
        ];

        $validated = $request->merge(['expiration_date' => $expirationDate])->validate([
            'email' => 'required|email',
            'name' => ['required', 'regex:/^[a-zA-Z\s\'-]+$/'],
            'number' => 'required|digits:16',
            'expiration_date' => [
                'required',
                'regex:/^\d{2}\/\d{2}$/',
                function ($attribute, $value, Closure $fail) {
                    if (!is_string($value)) {
                        $fail('Invalid expiration date format.');
                        return;
                    }

                    [$month, $year] = explode('/', $value);
                    $month = (int)$month;
                    $year = (int)$year;
                    $currentYear = (int)date('y');
                    $currentMonth = (int)date('m');

                    if ($month < 1 || $month > 12) {
                        $fail('The month must be between 01 and 12.');
                        return;
                    }

                    if ($year < $currentYear || ($year === $currentYear && $month < $currentMonth)) {
                        $fail('The expiration date has already passed.');
                    }
                },
            ],
            'cvv' => 'required|digits:3',
        ]);

        /** @var array<string, mixed> $validated */
        $validated = (array)$validated;

        if (isset($validated['number']) && is_scalar($validated['number'])) {
            $validated['number'] = (string)$validated['number'];
        }

        if (isset($validated['cvv']) && is_scalar($validated['cvv'])) {
            $validated['cvv'] = (string)$validated['cvv'];
        }

        Card::create($validated);

        $from = $request->input('from', 'add-card');
        $username = $request->input('username');

        if ($from === 'subscription') {
            // Znajdź użytkownika na podstawie `username`
            $userToSubscribe = User::where('username', $username)->first();

            if (!$userToSubscribe) {
                return redirect()->route('home')->with('error', 'User not found.');
            }

            // Przekierowanie na trasę `follow` z odpowiednim ID
            return redirect()->route('follow', ['user' => $userToSubscribe->id])
                ->with('success', 'Card added successfully! You are now following the user.');
        }


        return redirect()->route('cards.show')->with('success', 'Card added successfully!');
    }



    /**
     * Wyświetla zapisane dane karty użytkownika.
     *
     * @return View
     */
    public function show(): View
    {
        $user = auth()->user();
        if (!$user) {
            abort(403, 'Unauthorized access');
        }

        // Pobierz zapisane dane karty dla zalogowanego użytkownika
        $card = Card::where('email', $user->email)->first();

        return view('cards.show', compact('card'));
    }

    /**
     * Wyświetla formularz dodawania/edycji karty.
     *
     * @return View
     */
    public function create(Request $request): View
    {
        $user = auth()->user();
        if (!$user) {
            abort(403, 'Unauthorized access');
        }

        // Pobierz dane zapisanej karty użytkownika, jeśli istnieje
        $card = Card::where('email', $user->email)->first();

        $from = $request->input('from', 'add-card');


        return view('cards.add-card', compact('card'));
    }

    /**
     * Usuwa zapisane dane karty użytkownika.
     *
     * @return RedirectResponse
     */
    public function destroy(): RedirectResponse
    {
        $user = auth()->user();
        if (!$user) {
            abort(403, 'Unauthorized access');
        }

        // Usuwanie karty powiązanej z zalogowanym użytkownikiem
        Card::where('email', $user->email)->delete();

        return redirect()->route('add-card')->with('status', 'The card has been successfully deleted!');
    }

}
