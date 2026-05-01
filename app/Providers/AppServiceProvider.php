<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Order;

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
    view()->composer('*', function ($view) {

        $pendingOrders = Order::where('status', 'pending')->count();
        $latestOrders = Order::latest()->take(5)->get();

        $view->with([
            'pendingOrders' => $pendingOrders,
            'latestOrders' => $latestOrders,
        ]);
    });
}
}
