<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Sentry\Laravel\Integration;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        Integration::handles($exceptions);

        $exceptions->respond(function (Response $response, Throwable $exception, Request $request) {
            $statusCode = $response->getStatusCode();

            // Log error hanya jika status >= 500
            if ($statusCode >= 500) {
                Log::error($exception->getMessage(), [
                    'exception' => $exception,
                    'url' => $request->fullUrl(),
                    'input' => $request->all(),
                ]);
            }

            try {
                // Daftar status error yang akan di-respons khusus
                $handledStatusCodes = [500, 503, 404, 403, 401, 422, 400, 429];

                if (! app()->environment(['local', 'testing']) && in_array($statusCode, $handledStatusCodes)) {
                    $message = app()->environment('production')
                        ? 'Terjadi kesalahan pada server. Silakan coba beberapa saat lagi.'
                        : $exception->getMessage();

                    // Jika permintaan mengharapkan JSON
                    if ($request->expectsJson() || $request->wantsJson()) {
                        return response()->json([
                            'message' => $message,
                            'status' => $statusCode,
                            'error' => class_basename($exception),
                        ], $statusCode);
                    }

                    // Jika menggunakan Inertia
                    if (function_exists('inertia')) {
                        return inertia('ErrorHandling', [
                            'status' => $statusCode,
                            'message' => $message,
                        ])->toResponse($request)->setStatusCode($statusCode);
                    }

                    // Fallback ke view statis jika tidak pakai inertia
                    if (view()->exists("errors.{$statusCode}")) {
                        return response()->view("errors.{$statusCode}", ['message' => $message], $statusCode);
                    }

                    // Fallback HTML sederhana
                    return response("<h1>{$statusCode} - {$message}</h1>", $statusCode);
                }
            } catch (\Throwable $e) {
                Log::error('Error dalam error handling: '.$e->getMessage());

                return response('Server Error', 500);
            }

            return $response;
        });
    })
    ->create();
