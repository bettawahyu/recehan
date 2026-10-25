<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Keuangan\Pemasukan;
use App\Models\Keuangan\Pengeluaran;

use App\Observers\PemasukanObserver;
use App\Observers\PengeluaranObserver;

use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use BezhanSalleh\LanguageSwitch\Enums\DisplayMode;
use BezhanSalleh\LanguageSwitch\Enums\TriggerStyle;
use Filament\Support\Icons\Heroicon;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Laravel\Passport\Passport;

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
        //
        Pemasukan::observe(PemasukanObserver::class);
        Pengeluaran::observe(PengeluaranObserver::class);

        // Token login aplikasi mobile berlaku 30 hari, setelah itu user login ulang.
        Passport::personalAccessTokensExpireIn(now()->addDays(30));

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch->
            locales(['id', 'en', 'fr'])
            ->flags([
                'id' => 'https://flagcdn.com/16x12/id.png',
                'en' => 'https://flagcdn.com/16x12/us.png',
                'fr' => 'https://flagcdn.com/16x12/fr.png',
            ]);
        });

        Event::listen(function (Login $event) {

            $event->user->update([
                'last_login_at' => now(),
            ]);

        });
    }
}
