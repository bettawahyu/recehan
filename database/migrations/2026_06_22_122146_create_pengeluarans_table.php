<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengeluaran', function (Blueprint $table) {

            $table->id();

            $table->string('nomor_transaksi')
                ->unique();

            $table->date('tanggal');

            $table->foreignId('kategori_pengeluaran_id')
                ->constrained('kategori_pengeluaran');

            $table->decimal('jumlah', 18, 2);

            $table->string('tujuan')
                ->nullable();

            $table->text('keterangan')
                ->nullable();

            $table->enum('status', [
                'draft',
                'final'
                ])->default('final');

            $table->foreignId('created_by')
                ->constrained('users');

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users');

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran');
    }
};
