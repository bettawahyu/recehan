<?php

namespace Tests\Feature;

use App\Helpers\NomorTransaksiHelper;
use App\Models\Keuangan\KategoriPemasukan;
use App\Models\Keuangan\Pemasukan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NomorTransaksiTest extends TestCase
{
    use RefreshDatabase;

    private KategoriPemasukan $kategori;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
        $this->kategori = KategoriPemasukan::create(['nama' => 'Gaji']);
    }

    private function buatPemasukan(string $tanggal): Pemasukan
    {
        return Pemasukan::create([
            'tanggal' => $tanggal,
            'kategori_pemasukan_id' => $this->kategori->id,
            'jumlah' => 1000,
        ]);
    }

    public function test_nomor_dibuat_otomatis_mengikuti_tanggal_transaksi(): void
    {
        $this->assertSame('MSK-0326-0001', $this->buatPemasukan('2026-03-15')->nomor_transaksi);
        $this->assertSame('MSK-0326-0002', $this->buatPemasukan('2026-03-20')->nomor_transaksi);
    }

    public function test_nomor_reset_setiap_bulan(): void
    {
        $this->buatPemasukan('2026-03-15');
        $this->buatPemasukan('2026-03-16');

        $this->assertSame('MSK-0426-0001', $this->buatPemasukan('2026-04-01')->nomor_transaksi);
    }

    public function test_nomor_milik_data_terhapus_tidak_dipakai_ulang(): void
    {
        $this->buatPemasukan('2026-03-15');
        $this->buatPemasukan('2026-03-16')->delete();

        $this->assertSame('MSK-0326-0003', $this->buatPemasukan('2026-03-17')->nomor_transaksi);
    }

    public function test_helper_pengeluaran_memakai_prefix_klr(): void
    {
        $this->assertSame('KLR-1226-0001', NomorTransaksiHelper::pengeluaran('2026-12-01'));
    }
}
