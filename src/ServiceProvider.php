<?php

namespace LangleyFoxall\LaravelNISTPasswordRules;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-nist-password-rules');

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-nist-password-rules'),
            __DIR__.'/../config/laravel-nist-password-rules.php' => config_path('laravel-nist-password-rules.php'),
        ]);
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
    }
}
