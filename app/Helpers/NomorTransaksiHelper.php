<?php

namespace App\Helpers;

use App\Models\Keuangan\Pemasukan;
use App\Models\Keuangan\Pengeluaran;
use Illuminate\Support\Carbon;

class NomorTransaksiHelper
{
    public static function pemasukan($tanggal = null): string
    {
        return self::generate(Pemasukan::class, 'MSK', $tanggal);
    }

    public static function pengeluaran($tanggal = null): string
    {
        return self::generate(Pengeluaran::class, 'KLR', $tanggal);
    }

    /**
     * Format: PREFIX-mmyy-nnnn. Urutan dimulai lagi dari 0001 setiap bulan
     * dan periodenya mengikuti tanggal transaksi, bukan tanggal hari ini.
     */
    protected static function generate(string $model, string $prefix, $tanggal): string
    {
        $periode = Carbon::parse($tanggal ?? now())->format('my');
        $awalan = "{$prefix}-{$periode}-";

        // withTrashed: nomor milik data yang di-soft-delete tetap terpakai (kolom unique).
        // lockForUpdate: mencegah dua penyimpanan bersamaan mendapat nomor yang sama.
        $terakhir = $model::withTrashed()
            ->where('nomor_transaksi', 'like', $awalan . '%')
            ->lockForUpdate()
            ->max('nomor_transaksi');

        $urutan = $terakhir
            ? (int) substr($terakhir, strlen($awalan)) + 1
            : 1;

        $nomor = str_pad(
            $urutan,
            4,
            '0',
            STR_PAD_LEFT
        );

        return "{$awalan}{$nomor}";
    }
}
