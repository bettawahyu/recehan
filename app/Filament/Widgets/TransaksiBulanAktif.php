<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Keuangan\TransaksiHarian;
use App\Models\Keuangan\Pemasukan;
use App\Models\Keuangan\Pengeluaran;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;


class TransaksiBulanAktif extends TableWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                TransaksiHarian::query()
                    ->whereMonth('tanggal', now()->month)
                    ->whereYear('tanggal', now()->year)
                    ->orderBy('tanggal')
            )
            ->heading(fn () => 'Transaksi Bulan ' . now()->translatedFormat('F Y'))
            ->columns([

                TextColumn::make('tanggal')
                    ->date('d M Y'),
                TextColumn::make('pemasukan')
                    ->label('Pemasukan')
                    ->formatStateUsing(fn ($state) =>
                            ($state === null || $state == 0)
                                ? '-'
                                : 'Rp ' . number_format($state, 0, ',', '.')
                        )
                    ->alignEnd()
                    ->color('success'),

                TextColumn::make('pengeluaran')
                    ->label('Pengeluaran')
                    ->formatStateUsing(fn ($state) =>
                            ($state === null || $state == 0)
                                ? '-'
                                : 'Rp ' . number_format($state, 0, ',', '.')
                        )
                    ->alignEnd()
                    ->color('danger'),

            ]);
    }

    public function getTableRecordsPerPage(): int
    {
        return 20;
    }
}
