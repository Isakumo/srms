<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration;
use Illuminate\Routing\Router;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        then: function (Router $router) {
            //
        },
    )
    ->withMiddleware(function (Configuration $config) {
        $config->merge([
            'middleware' => [
                \Illuminate\Cookie\Middleware\EncryptCookies::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ],
        ]);
    })
    ->withExceptions(function () {
        //
    })
    ->create();
