<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    /**
     * WyĹ›wietlenie listy postĂłw.
     */
    public function home(): View
    {

        $user = Auth::user();

        if ($user) {
            $followingIds = $user->following()->pluck('users.id')->toArray();

            $posts = Post::whereIn('user_id', array_merge($followingIds, [Auth::id()]))
                ->latest()
                ->with('user')
                ->get();


            $suggestedProfiles = User::whereNotIn('id', array_merge($followingIds, [$user->id]))
                ->inRandomOrder()
                ->take(5)
                ->get();

            return view('home', [
                'posts' => $posts,
                'suggestedProfiles' => $suggestedProfiles,
            ]);
        }

        return view('welcome');
    }


    public function index(): View
    {
        // Fetch all posts
        $posts = Post::latest()->with('user')->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Formularz tworzenia nowego posta.
     */
    public function create(): View
    {
        return view('posts.create'); // Zwraca widok formularza do tworzenia posta
    }

    /**
     * Przechowuje nowy post w bazie danych.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        /**
         * @var array<string, mixed> $validated
         */
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Dodajemy walidację zdjęcia
        ]);


        $validated['user_id'] = Auth::id();

        // Obsługa przesyłania zdjęcia
        if ($request->hasFile('photo') && $request->file('photo') instanceof \Illuminate\Http\UploadedFile) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $validated['photo'] = $photoPath;
        }


        $post = Post::create($validated);

        // Sprawdzanie, gdzie przekierować użytkownika
        $redirectTo = $request->input('redirect_to', 'home'); // Domyślna wartość to 'home'
        if ($redirectTo === 'profile') {
            return redirect()->route('profile.show')->with('success', 'The post has been added!');
        }

        return redirect()->route('home')->with('success', 'The post has been added!');
    }

    /**
     * Wyswietlanie posta
     */
    public function show(Post $post): View
    {
        $post->load(['user', 'comments.user']);

        $referer = request()->input('referer', 'home');
        $query = request()->input('query', ''); // Pobierz zapamiętane hasło wyszukiwania

        return view('posts.show', compact('post', 'referer', 'query'));
    }


    /**
     *
     * Edytowanie posta
     */
    public function edit(Post $post): View
    {
        abort_unless(Auth::id() === $post->user_id, 403, 'Only author can edit this post.');

        return view('posts.edit')->with('post', $post);
    }

    /**
     * Aktualizacja posta.
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        abort_unless(Auth::id() === $post->user_id, 403, 'Only the author can update this post.');

        $validated = $request->validated();

        if ($request->hasFile('photo') && $request->file('photo') instanceof \Illuminate\Http\UploadedFile) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $validated['photo'] = $photoPath;

            if (!empty($post->photo)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($post->photo);
            }
        }

        $post->update($validated);

        return redirect()->route('posts.show', $post)->with('success', 'The post has been updated.');
    }


    /**
     * Usuniacie posta
     */
    public function destroy(Request $request, Post $post): RedirectResponse
    {
        $currentUser = Auth::user();
        abort_unless($currentUser && $currentUser->id === $post->user_id, 403, 'Only the author can delete this post.');

        $post->delete();

        $redirectUrl = $request->input('redirect_url', route('home'));

        if (is_string($redirectUrl) && str_contains($redirectUrl, route('profile.show', ['username' => $currentUser->username]))) {
            return redirect()->route('profile.show', ['username' => $currentUser->username])
                ->with('success', 'Post deleted successfully.');
        }

        return redirect(is_string($redirectUrl) ? $redirectUrl : route('home'))
            ->with('success', 'Post deleted successfully.');

    }

    /**
     * Wyszukiwanie
     */
    public function search(Request $request): View
    {
        $query = $request->input('query', '');

        $query = $request->input('query', '');

        if (!is_string($query) || strlen($query) < 3) {
            return view('search-results', [
                'error' => 'Query must be at least 3 characters long.',
                'posts' => collect(),
                'users' => collect(),
            ]);
        }

        $posts = Post::where('content', 'LIKE', '%' . $query . '%')->with('user')->get();
        $users = User::where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('username', 'LIKE', '%' . $query . '%')
            ->get();

        return view('search-results', compact('posts', 'users', 'query'));
    }

    public function like(Post $post): JsonResponse
    {
        abort_unless(auth()->check(), 403, 'Unauthorized action.');

        $like = $post->likes()->where('user_id', auth()->id())->first();

        if ($like) {
            // Usuń polubienie
            $like->delete();
            $liked = false;
        } else {
            // Dodaj polubienie
            $post->likes()->create([
                'user_id' => auth()->id(),
            ]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likes_count' => $post->likes()->count(),
        ]);
    }

    public function rightSlideBar(): View
    {
        $suggestedProfiles = User::where('id', '!=', Auth::id())
            ->inRandomOrder()
            ->take(5)
            ->get();

        return view('layouts.right-sidebar', [
            'suggestedProfiles' => $suggestedProfiles,
        ]);
    }
}
