<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.right-sidebar', function (\Illuminate\Contracts\View\View $view) {
            $suggestedProfiles = collect();

            if (Auth::check()) {
                $user = Auth::user();

                if ($user !== null) {
                    $followingIds = $user->following()->pluck('users.id')->toArray();

                    $suggestedProfiles = User::whereNotIn('id', array_merge($followingIds, [$user->id]))
                        ->inRandomOrder()
                        ->take(3)
                        ->get();
                }
            }

            $view->with('suggestedProfiles', $suggestedProfiles);
        });
    }
}
