<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; 

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
        Gate::define('kelola-barang', function (User $user) {
            return in_array($user->role, ['admin', 'petugas']);
        });

        Gate::define('meminjam', function (User $user) {
            return $user->role === 'peminjam';
        });
    }
}