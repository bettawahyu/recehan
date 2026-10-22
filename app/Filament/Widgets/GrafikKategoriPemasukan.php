<?php

namespace App\Filament\Widgets;

use App\Models\Keuangan\KategoriPemasukan;
use App\Models\Keuangan\Pemasukan;

class GrafikKategoriPemasukan extends GrafikKategori
{
    protected static ?int $sort = 3;

    protected ?string $heading = 'Pemasukan per Kategori';

    protected function model(): string
    {
        return Pemasukan::class;
    }

    protected function modelKategori(): string
    {
        return KategoriPemasukan::class;
    }

    protected function kolomKategori(): string
    {
        return 'kategori_pemasukan_id';
    }

    protected function palet(): array
    {
        return ['#059669', '#10b981', '#34d399', '#6ee7b7', '#0d9488', '#14b8a6', '#5eead4', '#a7f3d0'];
    }
}
