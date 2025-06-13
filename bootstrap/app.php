<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function(RouteNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
            ], 500);
        });
    })->create();
