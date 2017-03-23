<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\ApplicationSetting;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Share Application Settings with all Controllers
        // and Views.
        View::share('app_settings', ApplicationSetting::findOrFail(1));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /*
        $this->app->bind(
            'Illuminate\Contracts\Auth\Registrar',
            'App\Http\Controllers\Auth\RegisterController'
        );
    */
        }
}
