<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dasbor';

    public function getSubheading(): string | Htmlable | null
    {
        $jam = now()->hour;

        $salam = match (true) {
            $jam < 11 => 'Selamat pagi',
            $jam < 15 => 'Selamat siang',
            $jam < 18 => 'Selamat sore',
            default => 'Selamat malam',
        };

        return "{$salam}, " . auth()->user()?->name . '. Berikut ringkasan keuangan per ' . now()->translatedFormat('d F Y') . '.';
    }

    public function getColumns(): int | array
    {
        return [
            'default' => 1,
            'lg' => 2,
        ];
    }
}
