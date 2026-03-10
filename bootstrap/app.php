<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\HotelMiddleware;
use App\Http\Middleware\RestaurantMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // ここを alias に書き換えます
        // これにより、web.phpの 'middleware' => 'admin' 等が正しく機能します
        $middleware->alias([
            'admin'      => AdminMiddleware::class,
            'hotel'      => HotelMiddleware::class,
            'restaurant' => RestaurantMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();