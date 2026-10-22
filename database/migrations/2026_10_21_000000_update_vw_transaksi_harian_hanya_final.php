<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Transaksi berstatus draft belum disetujui, jadi tidak ikut dihitung.
     */
    public function up(): void
    {
        $this->buatView("AND status = 'final'");
    }

    public function down(): void
    {
        $this->buatView('');
    }

    private function buatView(string $filterStatus): void
    {
        DB::statement('DROP VIEW IF EXISTS vw_transaksi_harian');

        DB::statement("
            CREATE VIEW vw_transaksi_harian AS

            SELECT
                ROW_NUMBER() OVER (
                    ORDER BY tanggal DESC
                ) as id,

                tanggal,

                SUM(pemasukan) as pemasukan,

                SUM(pengeluaran) as pengeluaran

            FROM
            (
                SELECT
                    tanggal,
                    jumlah as pemasukan,
                    0 as pengeluaran
                FROM pemasukan
                WHERE deleted_at IS NULL {$filterStatus}

                UNION ALL

                SELECT
                    tanggal,
                    0 as pemasukan,
                    jumlah as pengeluaran
                FROM pengeluaran
                WHERE deleted_at IS NULL {$filterStatus}

            ) trx

            GROUP BY tanggal
        ");
    }
};
