<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

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
     * Version of project
     *
     * @var string
     */
    private $version;

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->version = config('app.version');

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
        $this->mapWebRoutes();
        $this->mapAdminRoutes();
        $this->mapFileRoutes();
        $this->mapAjaxRoutes();
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
        Route::middleware('web')
             ->namespace($this->namespace . '\\' . $this->version . '\Web')
             ->group(base_path('routes/web.php'));
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
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace . '\\' . $this->version . '\Api')
             ->group(base_path('routes/api.php'));
    }

    /**
     * Define routes for admin
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::prefix('api/admin')
            ->middleware('api')
            ->namespace($this->namespace . '\\' . $this->version . '\Admin')
            ->name('admin.')
            ->group(base_path('routes/admin.php'));
    }

    /**
     * Define routes for file
     *
     * @return void
     */
    protected function mapFileRoutes()
    {
        Route::prefix('api/file')
            ->middleware('api')
            ->namespace($this->namespace . '\\' . $this->version . '\File')
            ->group(base_path('routes/file.php'));
    }

    /**
     * Define routes for ajax
     *
     * @return void
     */
    protected function mapAjaxRoutes()
    {
        Route::prefix('ajax')
            ->middleware('ajax')
            ->namespace($this->namespace . '\\' . $this->version . '\Ajax')
            ->group(base_path('routes/ajax.php'));
    }
}
