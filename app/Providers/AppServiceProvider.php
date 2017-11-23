<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('is_valid_lat', function($attribute, $value, $parameters, $validator) {
            $pattern = '/^[+\-]?[0-9]{1,2}\.[0-9]{0,8}\z/';

            if(preg_match($pattern, $value)) {
                return true;
            } else {
               return false;
            }
        });

        Validator::extend('is_valid_long', function($attribute, $value, $parameters, $validator) {
            $pattern = '/^[+\-]?[0-9]{1,3}\.[0-9]{0,8}\z/';

            if(preg_match($pattern, $value)) {
                return true;
            } else {
               return false;
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
