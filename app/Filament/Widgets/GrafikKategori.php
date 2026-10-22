<?php

namespace App\Filament\Widgets;

use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Model;

/**
 * Komposisi transaksi final per kategori dalam bentuk doughnut.
 */
abstract class GrafikKategori extends ChartWidget
{
    protected ?string $maxHeight = '280px';

    protected ?string $pollingInterval = null;

    public ?string $filter = 'bulan_ini';

    /**
     * @return class-string<Model>
     */
    abstract protected function model(): string;

    /**
     * @return class-string<Model>
     */
    abstract protected function modelKategori(): string;

    abstract protected function kolomKategori(): string;

    /**
     * @return array<int, string>
     */
    abstract protected function palet(): array;

    protected function getFilters(): ?array
    {
        return [
            'bulan_ini' => 'Bulan ini',
            'bulan_lalu' => 'Bulan lalu',
            'tahun_ini' => 'Tahun ini',
        ];
    }

    protected function getData(): array
    {
        [$dari, $sampai] = match ($this->filter) {
            'bulan_lalu' => [now()->subMonthNoOverflow()->startOfMonth(), now()->subMonthNoOverflow()->endOfMonth()],
            'tahun_ini' => [now()->startOfYear(), now()->endOfYear()],
            default => [now()->startOfMonth(), now()->endOfMonth()],
        };

        $kolom = $this->kolomKategori();

        $totalPerKategori = $this->model()::query()
            ->where('status', 'final')
            ->whereDate('tanggal', '>=', $dari)
            ->whereDate('tanggal', '<=', $sampai)
            ->selectRaw("{$kolom}, SUM(jumlah) as total")
            ->groupBy($kolom)
            ->orderByDesc('total')
            ->toBase()
            ->pluck('total', $kolom);

        // withTrashed: kategori yang sudah dihapus tetap punya nama di grafik.
        $namaKategori = $this->modelKategori()::withTrashed()
            ->whereIn('id', $totalPerKategori->keys())
            ->pluck('nama', 'id');

        if ($totalPerKategori->isEmpty()) {
            return [
                'datasets' => [[
                    'data' => [1],
                    'backgroundColor' => ['#e5e7eb'],
                    'borderWidth' => 0,
                ]],
                'labels' => ['Belum ada transaksi'],
            ];
        }

        $palet = $this->palet();

        return [
            'datasets' => [[
                'data' => $totalPerKategori->map(fn ($total) => (float) $total)->values()->all(),
                'backgroundColor' => $totalPerKategori->keys()
                    ->map(fn ($id, int $index) => $palet[$index % count($palet)])
                    ->all(),
                'borderWidth' => 2,
                'hoverOffset' => 8,
            ]],
            'labels' => $totalPerKategori->keys()
                ->map(fn ($id) => $namaKategori[$id] ?? 'Tanpa kategori')
                ->all(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<'JS'
            {
                cutout: '65%',
                plugins: {
                    legend: { position: 'right', labels: { usePointStyle: true, boxWidth: 8 } },
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0)
                                const persen = total ? (context.parsed / total * 100).toFixed(1) : 0

                                return context.label === 'Belum ada transaksi'
                                    ? ' Belum ada transaksi'
                                    : ` Rp ${Number(context.parsed).toLocaleString('id-ID')} (${persen}%)`
                            },
                        },
                    },
                },
            }
        JS);
    }
}
