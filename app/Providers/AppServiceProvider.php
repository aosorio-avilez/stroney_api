<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        $this->injectDependencies();
    }

    private function injectDependencies()
    {
        foreach (config('di') as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }
}
