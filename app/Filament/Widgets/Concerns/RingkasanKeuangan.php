<?php

namespace App\Filament\Widgets\Concerns;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Helper bersama untuk widget dasbor. Semua angka hanya menghitung transaksi
 * berstatus final, karena draft belum disetujui.
 */
trait RingkasanKeuangan
{
    protected static function rupiah(float | int | string | null $nilai): string
    {
        return 'Rp ' . number_format((float) $nilai, 0, ',', '.');
    }

    /**
     * @param  class-string<Model>  $model
     */
    protected static function totalFinal(string $model, ?CarbonInterface $dari = null, ?CarbonInterface $sampai = null): float
    {
        return (float) $model::query()
            ->where('status', 'final')
            ->when($dari, fn ($query) => $query->whereDate('tanggal', '>=', $dari))
            ->when($sampai, fn ($query) => $query->whereDate('tanggal', '<=', $sampai))
            ->sum('jumlah');
    }

    /**
     * Total per bulan untuk $jumlahBulan bulan terakhir (termasuk bulan ini),
     * dengan key 'Y-m' berurutan dari yang terlama.
     *
     * Dikelompokkan per tanggal di database lalu dijumlahkan per bulan di PHP
     * agar query tetap jalan di MySQL maupun SQLite.
     *
     * @param  class-string<Model>  $model
     * @return array<string, float>
     */
    protected static function totalPerBulan(string $model, int $jumlahBulan, ?CarbonInterface $akhir = null): array
    {
        $akhir = ($akhir ?? now())->copy()->endOfMonth();
        $awal = $akhir->copy()->startOfMonth()->subMonths($jumlahBulan - 1);

        $hasil = [];

        for ($bulan = $awal->copy(); $bulan->lte($akhir); $bulan->addMonth()) {
            $hasil[$bulan->format('Y-m')] = 0.0;
        }

        $model::query()
            ->where('status', 'final')
            ->whereDate('tanggal', '>=', $awal)
            ->whereDate('tanggal', '<=', $akhir)
            ->selectRaw('tanggal, SUM(jumlah) as total')
            ->groupBy('tanggal')
            ->toBase()
            ->get()
            ->each(function ($baris) use (&$hasil) {
                $hasil[Carbon::parse($baris->tanggal)->format('Y-m')] += (float) $baris->total;
            });

        return $hasil;
    }
}
