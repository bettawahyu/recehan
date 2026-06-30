<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
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
                WHERE deleted_at IS NULL

                UNION ALL

                SELECT
                    tanggal,
                    0 as pemasukan,
                    jumlah as pengeluaran
                FROM pengeluaran
                WHERE deleted_at IS NULL

            ) trx

            GROUP BY tanggal
        ");
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS vw_transaksi_harian');
    }
};