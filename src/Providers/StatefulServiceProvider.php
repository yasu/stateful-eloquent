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
        $this->app['events']->listen('eloquent.creating*', function ($operation, $models) {
            $modelClass = $this->getModelClass($operation);
            if (is_a($modelClass,Stateful::class, true)) {
                foreach ($models as $model) {
                    $model->setInitialState();
                }
            }
        });
    }

    /**
     * Get model class.
     *
     * @param $model
     * @return mixed
     */
    private function getModelClass($model)
    {
        return explode(": ", $model)[1];
    }
}
