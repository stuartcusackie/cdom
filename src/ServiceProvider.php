<?php

namespace stuartcusackie\cdom;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{   

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // ...
    }
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/cdom.php' => config_path('cdom.php'),
        ], 'config');
    }
}
