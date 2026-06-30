<?php

namespace App\Filament\Widgets;

use App\Models\Keuangan\Pemasukan;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Keuangan\Pengeluaran;
use Filament\Widgets\ChartWidget;

class GrafikKeuangan extends ChartWidget
{
    protected ?string $heading = 'Grafik Keuangan Total';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'data' => [
                        Pemasukan::sum('jumlah'),
                        Pengeluaran::sum('jumlah'),
                    ],

                    'backgroundColor' => [
                        '#10b981',
                        '#f43f5e',
                    ],

                    'borderColor' => [
                        '#10b981',
                        '#f43f5e',
                    ],

                    'borderWidth' => 2,
                ],
            ],

            'labels' => [
                'Pemasukan',
                'Pengeluaran',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}