<?php

namespace App\Providers;

use App\Http\Middleware\EnsureSchoolScope;
use App\Http\Middleware\EnsureUserHasPermission;
use App\Http\Middleware\EnsureUserIsActive;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app['router']->aliasMiddleware('active.user', EnsureUserIsActive::class);
        $this->app['router']->aliasMiddleware('permission', EnsureUserHasPermission::class);
        $this->app['router']->aliasMiddleware('school.scope', EnsureSchoolScope::class);

        Blade::if('hasPermission', function (string $permission) {
            return auth()->check() && auth()->user()->hasPermission($permission);
        });
    }
}
