<?php

use App\Http\Controllers\SetupController;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\CardController;

// Home Page Route
Route::get('/', [PostController::class, 'home'])->name('home');




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
Route::get('/posts/create', function () {
    return view('posts.create');
})->name('posts.create');*/



//Add card
Route::get('/add-card', [CardController::class, 'create'])->name('add-card');
Route::post('/add-card', [CardController::class, 'store'])->name('store-card');
Route::get('/cards', [CardController::class, 'show'])->name('cards.show');
Route::delete('/card/delete', [CardController::class, 'destroy'])->name('delete-card');
Route::match(['GET', 'POST'], '/follow/{user}', [FollowController::class, 'follow'])->name('follow');

Route::post('/store-card', [CardController::class, 'store'])->name('store-card');



Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
Route::get('/search', [PostController::class, 'search'])->name('search');
Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');

Route::middleware(['auth'])->group(function () {
    Route::get('/subscribers', function (): View {
        return view('dashboard');
    });
    Route::get('/subscribers/{type}', [FollowController::class, 'getSubscribers']);
});


Route::middleware('auth')->group(function () {
    // Wyświetlanie profilu użytkownika
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::post('/profile/background', [ProfileController::class, 'updateBackground'])->name('profile.background.update');

    Route::post('/follow/{user}', [FollowController::class, 'follow'])->name('follow');
    Route::delete('/unfollow/{user}', [FollowController::class, 'unfollow'])->name('unfollow');

    Route::get('/profile/edit', [SetupController::class, 'edit'])->name('profile.edit');
    Route::delete('/profile', [SetupController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile', [SetupController::class, 'update'])->name('profile.update');
    //Route::put('/profile', [ProfileController::class, 'updateBackground'])->name('profile.updateBackground');
    Route::resource('books', BookController::class);
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

require __DIR__ . '/auth.php';
Route::resource('/comments', CommentController::class);

// Dynamiczna ścieżka dla innych użytkowników
Route::get('/{username}', [ProfileController::class, 'showPublic'])
    ->name('profile.public')
    ->where('username', '@?[a-zA-Z0-9_]+');
