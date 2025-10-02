<?php

namespace App\Providers;

use App\Models\Facility;
use App\Models\Partner;
use App\Models\Room;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::share('facilities', Facility::oldest()->get());
        View::share('rooms', Room::oldest()->get());
        View::share('partners', Partner::oldest()->get());
    }
}
