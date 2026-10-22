<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\RingkasanKeuangan;
use App\Models\Keuangan\Pemasukan;
use App\Models\Keuangan\Pengeluaran;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class GrafikArusKas extends ChartWidget
{
    use RingkasanKeuangan;

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected ?string $heading = 'Arus Kas';

    protected ?string $description = 'Perbandingan pemasukan dan pengeluaran final per bulan';

    protected ?string $maxHeight = '300px';

    protected ?string $pollingInterval = null;

    public ?string $filter = '6';

    protected function getFilters(): ?array
    {
        return [
            '3' => '3 bulan terakhir',
            '6' => '6 bulan terakhir',
            '12' => '12 bulan terakhir',
        ];
    }

    protected function getData(): array
    {
        $jumlahBulan = (int) ($this->filter ?: 6);

        $pemasukan = self::totalPerBulan(Pemasukan::class, $jumlahBulan);
        $pengeluaran = self::totalPerBulan(Pengeluaran::class, $jumlahBulan);

        $saldoBersih = [];
        foreach ($pemasukan as $bulan => $masuk) {
            $saldoBersih[] = $masuk - $pengeluaran[$bulan];
        }

        return [
            'datasets' => [
                [
                    'type' => 'line',
                    'label' => 'Selisih',
                    'data' => $saldoBersih,
                    'borderColor' => '#6366f1',
                    'backgroundColor' => '#6366f1',
                    'borderDash' => [6, 4],
                    'tension' => 0.35,
                    'pointRadius' => 3,
                    'order' => 0,
                ],
                [
                    'label' => 'Pemasukan',
                    'data' => array_values($pemasukan),
                    'backgroundColor' => '#10b981',
                    'borderColor' => '#10b981',
                    'borderRadius' => 6,
                    'maxBarThickness' => 36,
                    'order' => 1,
                ],
                [
                    'label' => 'Pengeluaran',
                    'data' => array_values($pengeluaran),
                    'backgroundColor' => '#f43f5e',
                    'borderColor' => '#f43f5e',
                    'borderRadius' => 6,
                    'maxBarThickness' => 36,
                    'order' => 1,
                ],
            ],
            'labels' => array_map(
                fn (string $bulan) => Carbon::createFromFormat('Y-m', $bulan)->startOfMonth()->translatedFormat('M Y'),
                array_keys($pemasukan),
            ),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<'JS'
            {
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: (context) => ` ${context.dataset.label}: Rp ${Number(context.parsed.y).toLocaleString('id-ID')}`,
                        },
                    },
                },
                scales: {
                    y: {
                        ticks: {
                            callback: (value) => 'Rp ' + Intl.NumberFormat('id-ID', { notation: 'compact' }).format(value),
                        },
                    },
                },
            }
        JS);
    }
}
