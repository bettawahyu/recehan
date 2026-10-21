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
        Schema::create('pemasukan', function (Blueprint $table) {

            $table->id();

            $table->string('nomor_transaksi')
                ->unique();

            $table->date('tanggal');

            $table->foreignId('kategori_pemasukan_id')
                ->constrained('kategori_pemasukan');

            $table->decimal('jumlah', 18, 2);

            $table->string('sumber')
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
        Schema::dropIfExists('pemasukan');
    }
};
