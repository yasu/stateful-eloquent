<?php

namespace Acacha\Stateful\Providers;

use Acacha\Stateful\Contracts\Stateful;
use Illuminate\Support\ServiceProvider;

/**
 * Class StatefulServiceProvider.
 * 
 * @package Acacha\Stateful\Providers
 */
class StatefulServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['events']->listen('eloquent.creating*', function ($model) {
            if ($model instanceof Stateful) {
                $model->setInitialState();
            }
        });
    }
}
