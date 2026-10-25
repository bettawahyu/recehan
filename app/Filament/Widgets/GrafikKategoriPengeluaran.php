<?php

namespace App\Filament\Widgets;

use App\Models\Keuangan\KategoriPengeluaran;
use App\Models\Keuangan\Pengeluaran;

class GrafikKategoriPengeluaran extends GrafikKategori
{
    protected static ?int $sort = 4;

    protected ?string $heading = 'Pengeluaran per Kategori';

    protected function model(): string
    {
        return Pengeluaran::class;
    }

    protected function modelKategori(): string
    {
        return KategoriPengeluaran::class;
    }

    protected function kolomKategori(): string
    {
        return 'kategori_pengeluaran_id';
    }

    protected function palet(): array
    {
        return ['#e11d48', '#f43f5e', '#fb7185', '#f97316', '#fb923c', '#f59e0b', '#fbbf24', '#fda4af'];
    }
}
