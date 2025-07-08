<?php

namespace App\Providers;

use App\Models\Admin\Article;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Gate::define('update', static function (User $user, Article $article) {
            return $user->hasPermissionTo('manage articles') || $user->id === $article->created_by;
        });

        Gate::define('delete', static function (User $user, Article $article) {
            return $user->hasPermissionTo('manage articles') || $user->id === $article->created_by;
        });
    }
}
