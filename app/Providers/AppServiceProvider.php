<?php

namespace App\Providers;

use App\Repository\MealRepository;
use App\Repository\MealRepositoryInterface;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('existsWith', 'App\Validators\CustomValidator@existsWith');
        Validator::replacer('existsWith', 'App\Validators\CustomValidator@existsWithReplacer');

        // Remove empty fields from request payload
        Request::macro('filter', function ($params = null) {
            if ($params == null) {
                $this->replace(array_filter_recursive($this->all()));
            } else {
                return array_filter_recursive($params);
            }
        });

        // Set default value for non presented fields
        Request::macro('setDefault', function (array $defaults) {
            return $this->replace(array_merge($defaults, $this->all()));
        });
    }




    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            MealRepositoryInterface::class,
            MealRepository::class
        );
    }
}
