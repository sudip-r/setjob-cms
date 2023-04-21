<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Collection;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() === 'production' || $this->app->environment() === 'development') {
            URL::forceScheme('https');
          }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        Collection::macro('recursive', function () {
          return $this->map(function ($value) {
              if (is_array($value) || is_object($value)) {
                  return collect($value)->recursive();
              }
              return $value;
          });
      });
    }
}
