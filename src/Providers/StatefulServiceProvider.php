<?php

namespace Yasu\Stateful\Providers;

use Yasu\Stateful\Contracts\Stateful;
use Illuminate\Support\ServiceProvider;

/**
 * Class StatefulServiceProvider.
 * 
 * @package Yasu\Stateful\Providers
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
