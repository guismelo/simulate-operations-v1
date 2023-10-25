<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapApiRoutesSubdomains();

        $this->mapCronRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::prefix('public')
            ->name('public')
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapCronRoutes()
    {
        Route::middleware('cron')
            ->name('cron')
            ->prefix('cron')
            ->namespace($this->namespace)
            ->group(base_path('routes/cron.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "routes/api" routes for the application.
     *
     * @return void
     */
    protected function mapApiRoutesSubdomains()
    {
        $path = base_path('routes/api/');

        foreach (scandir($path) as $file) {
            if (str_contains($file, '.php')) {
                $name = explode('.', $file)[0];

                Route::middleware('api')
                    ->namespace($this->namespace)
                    ->name($name)
                    ->prefix($name)
                    ->group("{$path}{$file}");
            }
        }
    }
}
