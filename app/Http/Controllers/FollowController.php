<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class FollowController extends Controller
{
    /**
     * Follow a user.
     */
    public function follow(User $user): RedirectResponse
    {
        $currentUser = auth()->user();

        if (!$currentUser) {
            return redirect()->back()->with('error', 'You need to be logged in to follow someone.');
        }


        if (!$currentUser->hasCard()) {
            // Zapisanie ID użytkownika i aktualnego URL w sesji
            session([
                'follow_user_id' => $user->id,
                'redirect_url' => route('profile.public', ['username' => $user->username]), // Zapisanie URL profilu
            ]);

            // Przekierowanie na stronę dodawania karty
            return redirect()->route('add-card')->with('info', 'You need to add a card to subscribe.');
        }

        if (!$currentUser->isFollowing($user)) {
            $currentUser->following()->attach($user->id);
        }

        return redirect()->route('profile.public', ['username' => $user->username])
            ->with('success', 'You are now following ' . $user->name);


    }


    public function unfollow(User $user): RedirectResponse
    {
        $currentUser = auth()->user();

        if (!$currentUser) {
            return redirect()->back()->with('error', 'You need to be logged in to unfollow someone.');
        }

        if ($currentUser->isFollowing($user)) {
            $currentUser->following()->detach($user->id);
        }

        return redirect()->back()->with('success', 'You have unfollowed ' . $user->name);
    }


    public function postCardAdd(Request $request): RedirectResponse
    {
        $currentUser = auth()->user();
        $followUserId = session('follow_user_id');

        if ($followUserId && $currentUser) {
            $userToFollow = User::find($followUserId);

            if ($userToFollow instanceof User && !$currentUser->isFollowing($userToFollow)) {
                $currentUser->following()->attach($userToFollow->id);
            }
        }

        return redirect()->route('profile.public', ['user' => $followUserId])
            ->with('success', 'You have successfully followed the user.');
    }



    public function show(User $user): View
    {
        $posts = $user->posts()->latest()->get();
        return view('profile.show', compact('user', 'posts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $currentUser = auth()->user();

        if (!$currentUser) {
            return redirect()->route('login')->with('error', 'You must be logged in to perform this action.');
        }

        // Dodanie nowej karty do użytkownika
        $currentUser->cards()->create([
            'email' => $currentUser->email,
            'card_number' => $request->input('card_number'),
            'expiration_date' => $request->input('expiration_date'),
            'cvv' => $request->input('cvv'),
        ]);

        // Sprawdzenie, czy w sesji zapisano URL do przekierowania
        $redirectUrl = session('redirect_url') ?? route('profile.public', ['username' => $currentUser->username]);

        if (!is_string($redirectUrl)) {
            $redirectUrl = route('profile.public', ['username' => $currentUser->username]);
        }

        // Sprawdzenie, czy w sesji zapisano ID użytkownika do subskrybowania
        $followUserId = session('follow_user_id');
        if ($followUserId) {
            $userToFollow = User::find($followUserId);

            if ($userToFollow instanceof User && !$currentUser->isFollowing($userToFollow)) {
                $currentUser->following()->attach($userToFollow->id);
            }

            // Usuń dane z sesji po subskrypcji
            session()->forget(['follow_user_id', 'redirect_url']);
        }

        // Przekierowanie na zapisany URL
        return redirect()->to($redirectUrl)->with('success', 'Card added successfully and you are now following the user.');
    }

    public function getSubscribers(Request $request, string $type): JsonResponse
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['html' => '<p class="text-red-500">You must be logged in.</p>']);
        }

        $html = '';
        if ($type === 'your-subscribers') {
            $html = $this->generateSubscribersList($user->followers);
        } elseif ($type === 'subscribed') {
            $html = $this->generateSubscribersList($user->following);
        } else {
            $html = '<p class="text-gray-500">Invalid tab selected.</p>';
        }

        return response()->json(['html' => $html]);
    }
    /**
     * Generate an HTML list of users.
     *
     * @param \Illuminate\Support\Collection<int, \App\Models\User> $users
     * @return string
     */
    private function generateSubscribersList($users): string
    {
        $html = '<ul class="list-none">';
        foreach ($users as $user) {
            $html .= '
        <li class="flex items-center space-x-4 py-4 border-b">
            <a href="' . route('profile.public', ['username' => $user->username]) . '" class="flex items-center space-x-3 hover:underline">
                ' . view('components.avatar', ['user' => $user, 'size' => 70, 'class' => 'ml-4'])->render() . '
                <span class="text-lg font-medium text-gray-700 ml-2">' . e($user->name) . ' ' . e($user->username) . '</span>
            </a>
        </li>';
        }
        $html .= '</ul>';

        return $html;
    }



}
