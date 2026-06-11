<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
            ->prefix('mypanel')
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
    $middleware->redirectGuestsTo(fn() => route('signin'));

    $middleware->alias([
        'is_admin' => \App\Http\Middleware\IsAdmin::class,
        'role'     => \App\Http\Middleware\CheckRole::class,
    ]);

    // Admin routes এর জন্য আলাদা session
   
})
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (
            \Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e,
            \Illuminate\Http\Request $request
        ) {
            return response()->view('errors.404', [], 404);
        });

        // 403 for unauthorized admin access
      $exceptions->render(function (
    \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e,
    \Illuminate\Http\Request $request
) {
    $adminPaths = ['login', 'dashboard', 'dashboard/*', 'admin/*', 'orders', 'orders/*', 'messages', 'messages/*', 'profile', 'profile/*', 'notifications/*'];
    
    if ($request->is($adminPaths)) {
        return redirect()->route('login')
            ->with('error', 'You do not have permission to access that page.');
    }
    return redirect()->route('signin')
        ->with('error', 'You do not have permission to access that page.');
});
    })->create();