<?php

namespace App\Observers;

use App\Helpers\NomorTransaksiHelper;
use App\Models\Keuangan\Pemasukan;

class PemasukanObserver
{
    /**
     * Handle the Pemasukan "creating & Updating" event.
     */

    public function creating(Pemasukan $pemasukan): void
    {
        if (auth()->check()) {
            $pemasukan->created_by = auth()->id();
        }

        if (blank($pemasukan->nomor_transaksi)) {
            $pemasukan->nomor_transaksi = NomorTransaksiHelper::pemasukan($pemasukan->tanggal);
        }
    }

    public function updating(Pemasukan $pemasukan): void
    {
        if (auth()->check()) {
            $pemasukan->updated_by = auth()->id();
        }
    }
    
    /**
     * Handle the Pemasukan "created" event.
     */
    public function created(Pemasukan $pemasukan): void
    {
        //
    }

    /**
     * Handle the Pemasukan "updated" event.
     */
    public function updated(Pemasukan $pemasukan): void
    {
        //
    }

    /**
     * Handle the Pemasukan "deleted" event.
     */
    public function deleted(Pemasukan $pemasukan): void
    {
        //
    }

    /**
     * Handle the Pemasukan "restored" event.
     */
    public function restored(Pemasukan $pemasukan): void
    {
        //
    }

    /**
     * Handle the Pemasukan "force deleted" event.
     */
    public function forceDeleted(Pemasukan $pemasukan): void
    {
        //
    }
}
