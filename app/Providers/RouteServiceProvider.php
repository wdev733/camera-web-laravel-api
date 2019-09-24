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

    /** @var string $api_namespace Api controllers path */
    protected $api_namespace = 'App\Http\Controllers\Api';

    /** @var string $device_api_namespace Device Api controllers path */
    protected $device_api_namespace = 'App\Http\Controllers\DeviceApi';

    /** @var string $device_api_namespace Server Api controllers path */
    protected $server_api_namespace = 'App\Http\Controllers\ServerApi';

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

        $this->mapWebRoutes();

        $this->mapDeviceApiRoutes();

        $this->mapServerApiRoutes();
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
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->api_namespace)
             ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "device-api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapDeviceApiRoutes()
    {
        Route::prefix('device-api')
             ->namespace($this->device_api_namespace)
             ->group(base_path('routes/device-api.php'));
    }

    /**
     * Define the "server-api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapServerApiRoutes()
    {
        Route::prefix('server-api')
        ->middleware('checkServerApiKey')
             ->namespace($this->server_api_namespace)
             ->group(base_path('routes/server-api.php'));
    }
}
