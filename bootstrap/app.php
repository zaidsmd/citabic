<?php

use App\Http\Middleware\AdminAuthenticate;
use App\Http\Middleware\InvalidateGuestPageCache;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            SetLocale::class,
        ]);

        $middleware->alias([
            'admin.auth' => AdminAuthenticate::class,
            'guest.cache.invalidate' => InvalidateGuestPageCache::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (NotFoundHttpException $exception, Request $request) {
            if (! str_starts_with($request->path(), 'admins/') && $request->path() !== 'admins') {
                return null;
            }

            if ($request->expectsJson()) {
                return null;
            }

            return response()->view('admin.pages.error-404', status: 404);
        });

        $exceptions->render(function (NotFoundHttpException $exception, Request $request) {
            if (str_starts_with($request->path(), 'admins/') || $request->path() === 'admins') {
                return null;
            }

            if ($request->expectsJson()) {
                return null;
            }

            return response()->view('guest.pages.error', ['statusCode' => 404], 404);
        });

        $exceptions->render(function (Throwable $exception, Request $request) {
            if (! str_starts_with($request->path(), 'admins/') && $request->path() !== 'admins') {
                return null;
            }

            if ($request->expectsJson()) {
                return null;
            }

            $statusCode = $exception instanceof HttpExceptionInterface
                ? $exception->getStatusCode()
                : 500;

            if ($statusCode < 500) {
                return null;
            }

            return response()->view('admin.pages.error-500', status: 500);
        });

        $exceptions->render(function (Throwable $exception, Request $request) {
            if (str_starts_with($request->path(), 'admins/') || $request->path() === 'admins') {
                return null;
            }

            if ($request->expectsJson()) {
                return null;
            }

            $statusCode = $exception instanceof HttpExceptionInterface
                ? $exception->getStatusCode()
                : 500;

            if ($statusCode < 500) {
                return null;
            }

            return response()->view('guest.pages.error', ['statusCode' => 500], 500);
        });
    })->create();
