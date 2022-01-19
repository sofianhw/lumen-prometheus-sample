<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades(true, [
    Arquivei\LaravelPrometheusExporter\PrometheusFacade::class => 'Prometheus',
    Superbalist\LaravelPrometheusExporter\PrometheusFacade::class => 'Prometheuss'
]);

$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// Register the Prometheus route middleware. You'll need to have the PrometheusServiceProvider
// in order to monitor your routes
$app->middleware([
    Arquivei\LaravelPrometheusExporter\PrometheusLumenRouteMiddleware::class,
]);

// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

// $app->routeMiddleware([
//     'auth' => App\Http\Middleware\Authenticate::class,
// ]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

// Register the main Prometheus service provider. To actually get metrics fr your routes
// you'll need the RouteMiddleware
$app->register(Arquivei\LaravelPrometheusExporter\PrometheusServiceProvider::class);

// Register this provider to get metrics for Database queries. You'll need the PrometheusServiceProvider
$app->register(Arquivei\LaravelPrometheusExporter\DatabaseServiceProvider::class);

// Register this provider to get metrics from Guzzle clients. You'll need the PrometheusServiceProvider
$app->register(Arquivei\LaravelPrometheusExporter\GuzzleServiceProvider::class);

$app->register(Superbalist\LaravelPrometheusExporter\PrometheusServiceProvider::class);

// $app->register(App\Providers\AppServiceProvider::class);
// $app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

return $app;
