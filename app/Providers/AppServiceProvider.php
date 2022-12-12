<?php

namespace App\Providers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends \Illuminate\Foundation\Support\Providers\AuthServiceProvider
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
        //
       $this->registerPolicies();
       Auth::provider('customcs', function ($app, array $config) {
           return $app->make(CustomEloquentUserProvider::class, ['model' => $config['model']]);
       });
    }
}
