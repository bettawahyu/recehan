<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Keuangan\Pemasukan;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Keuangan\Pengeluaran;

class GrafikBulanAktif extends ChartWidget
{
    protected ?string $heading = 'Grafik Bulan Aktif';

    protected int|string|array $columnSpan = 1;

    public function mount(): void
    {
        $this->heading = 'Grafik Bulan ' . now()->translatedFormat('F Y');
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'data' => [
                        Pemasukan::query()
                            ->whereMonth('tanggal', now()->month)
                            ->whereYear('tanggal', now()->year)
                            ->sum('jumlah'),

                        Pengeluaran::query()
                            ->whereMonth('tanggal', now()->month)
                            ->whereYear('tanggal', now()->year)
                            ->sum('jumlah'),
                    ],

                    'backgroundColor' => [
                        '#10b981',
                        '#ef4444',
                    ],
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
        return 'doughnut';
    }
}
