<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);// TODO: remove when update mysql version to 5.7 or higher

        Validator::extend('not_exist_in_website', function($attribute, $value, $parameters)
        {
            return DB::table($parameters[0])
                    ->where($attribute, '=', $value)
                    ->count() == 0;
        });

        Validator::extend('exist_in_website', function($attribute, $value, $parameters)
        {
            return DB::table($parameters[0])
                    ->where($attribute, '=', $value)
                    ->count() > 0;
        });

        Validator::extend('exist_in_website_with_user', function($attribute, $value, $parameters)
        {
            return DB::table($parameters[0])
                    ->where($attribute, '=', $value)
                    ->where('user_id', (int)auth()->id())
                    ->count() > 0;
        });
    }
}
