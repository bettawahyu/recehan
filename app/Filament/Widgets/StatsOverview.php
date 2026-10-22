<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\RingkasanKeuangan;
use App\Models\Keuangan\Pemasukan;
use App\Models\Keuangan\Pengeluaran;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    use RingkasanKeuangan;

    protected static ?int $sort = 1;

    protected ?string $pollingInterval = null;

    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        $bulanIni = now()->startOfMonth();
        $bulanLalu = now()->subMonthNoOverflow()->startOfMonth();

        $pemasukanPerBulan = self::totalPerBulan(Pemasukan::class, 6);
        $pengeluaranPerBulan = self::totalPerBulan(Pengeluaran::class, 6);

        $pemasukanBulanIni = end($pemasukanPerBulan);
        $pengeluaranBulanIni = end($pengeluaranPerBulan);
        $pemasukanBulanLalu = $pemasukanPerBulan[$bulanLalu->format('Y-m')] ?? 0;
        $pengeluaranBulanLalu = $pengeluaranPerBulan[$bulanLalu->format('Y-m')] ?? 0;

        $saldo = self::totalFinal(Pemasukan::class) - self::totalFinal(Pengeluaran::class);

        // Saldo di akhir tiap bulan untuk grafik kecil di kartu saldo.
        $saldoSebelumPeriode = $saldo
            - array_sum($pemasukanPerBulan)
            + array_sum($pengeluaranPerBulan);
        $trenSaldo = [];
        foreach ($pemasukanPerBulan as $bulan => $masuk) {
            $saldoSebelumPeriode += $masuk - $pengeluaranPerBulan[$bulan];
            $trenSaldo[] = round($saldoSebelumPeriode);
        }

        $jumlahDraft = Pemasukan::where('status', 'draft')->count()
            + Pengeluaran::where('status', 'draft')->count();

        return [
            Stat::make('Saldo Saat Ini', self::rupiah($saldo))
                ->description($saldo >= 0 ? 'Dari seluruh transaksi final' : 'Pengeluaran melebihi pemasukan')
                ->descriptionIcon($saldo >= 0 ? null : Heroicon::OutlinedExclamationTriangle)
                ->icon(Heroicon::OutlinedWallet)
                ->chart($trenSaldo)
                ->color($saldo >= 0 ? 'primary' : 'danger'),

            $this->statBulanan(
                'Pemasukan ' . $bulanIni->translatedFormat('F'),
                $pemasukanBulanIni,
                $pemasukanBulanLalu,
                array_values($pemasukanPerBulan),
                Heroicon::OutlinedArrowDownTray,
                naikBaik: true,
            ),

            $this->statBulanan(
                'Pengeluaran ' . $bulanIni->translatedFormat('F'),
                $pengeluaranBulanIni,
                $pengeluaranBulanLalu,
                array_values($pengeluaranPerBulan),
                Heroicon::OutlinedArrowUpTray,
                naikBaik: false,
            ),

            Stat::make('Menunggu Persetujuan', number_format($jumlahDraft, 0, ',', '.') . ' transaksi')
                ->description($jumlahDraft ? 'Draft belum dihitung di saldo' : 'Semua transaksi sudah final')
                ->descriptionIcon($jumlahDraft ? Heroicon::OutlinedClock : Heroicon::OutlinedCheckCircle)
                ->icon(Heroicon::OutlinedDocumentText)
                ->color($jumlahDraft ? 'warning' : 'gray'),
        ];
    }

    /**
     * @param  array<int, float>  $tren
     */
    protected function statBulanan(string $label, float $nilai, float $bulanLalu, array $tren, Heroicon $icon, bool $naikBaik): Stat
    {
        $stat = Stat::make($label, self::rupiah($nilai))
            ->icon($icon)
            ->chart($tren);

        if ($bulanLalu <= 0) {
            return $stat
                ->description('Belum ada pembanding bulan lalu')
                ->color('gray');
        }

        $persen = ($nilai - $bulanLalu) / $bulanLalu * 100;
        $naik = $persen >= 0;

        return $stat
            ->description(($naik ? 'Naik ' : 'Turun ') . number_format(abs($persen), 1, ',', '.') . '% dari bulan lalu')
            ->descriptionIcon($naik ? Heroicon::ArrowTrendingUp : Heroicon::ArrowTrendingDown)
            ->color($naik === $naikBaik ? 'success' : 'danger');
    }
}
