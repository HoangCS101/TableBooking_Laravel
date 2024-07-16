<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\MessageSent;
use App\Listeners\ChatUpdate;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // \Illuminate\Support\Facades\URL::forceScheme('https');
        Event::listen(
            MessageSent::class,
            ChatUpdate::class,
        );
    }
}
