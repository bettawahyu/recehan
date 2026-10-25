<?php

namespace App\Observers;

use App\Helpers\NomorTransaksiHelper;
use App\Models\Keuangan\Pengeluaran;

class PengeluaranObserver
{

    /**
     * Handle the Pengeluaran "creating & Updating" event.
     */

    public function creating(Pengeluaran $pengeluaran): void
    {
        if (auth()->check()) {
            $pengeluaran->created_by = auth()->id();
        }

        if (blank($pengeluaran->nomor_transaksi)) {
            $pengeluaran->nomor_transaksi = NomorTransaksiHelper::pengeluaran($pengeluaran->tanggal);
        }
    }

    public function updating(Pengeluaran $pengeluaran): void
    {
        if (auth()->check()) {
            $pengeluaran->updated_by = auth()->id();
        }
    }

    /**
     * Handle the Pengeluaran "created" event.
     */
    public function created(Pengeluaran $pengeluaran): void
    {
        //
    }

    /**
     * Handle the Pengeluaran "updated" event.
     */
    public function updated(Pengeluaran $pengeluaran): void
    {
        //
    }

    /**
     * Handle the Pengeluaran "deleted" event.
     */
    public function deleted(Pengeluaran $pengeluaran): void
    {
        //
    }

    /**
     * Handle the Pengeluaran "restored" event.
     */
    public function restored(Pengeluaran $pengeluaran): void
    {
        //
    }

    /**
     * Handle the Pengeluaran "force deleted" event.
     */
    public function forceDeleted(Pengeluaran $pengeluaran): void
    {
        //
    }
}
