<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    protected $helpers = [
        'setting',
        'response',
        'token',
        'date_time',
        'type',
        'route',
        'error'
    ];
    protected $helpersFolder = 'Helpers';

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->helpers as $helper) {
            $helper_path = app_path() . DIRECTORY_SEPARATOR . $this->helpersFolder . DIRECTORY_SEPARATOR . $helper . '.php';

            if (\File::isFile($helper_path)) {
                require_once $helper_path;
            }
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
