<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        FilamentColor::register([

            // Couleurs supplémentaires personnalisées
            'rose' => Color::Rose,
            'lime' => Color::Lime,
            'cyan' => Color::Cyan,
            'teal' => Color::Teal,
            'fuchsia' => Color::Fuchsia,
        ]);
    }


    /**
     * Bootstrap any application services.
     */
    // public function boot(): void
    // {
    //     //
    // }
}
