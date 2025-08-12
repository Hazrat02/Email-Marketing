<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Illuminate\Queue\Events\WorkerStopping;
// use Illuminate\Support\Facades\Artisan;
// use Illuminate\Support\Facades\Event;

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
    //      Event::listen(WorkerStopping::class, function () {
    //     // Clear config cache when queue worker stops
    //     Artisan::call('config:clear');
    // });
    }
}
