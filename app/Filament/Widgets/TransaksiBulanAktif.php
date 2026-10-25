<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\RingkasanKeuangan;
use App\Models\Keuangan\TransaksiHarian;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class TransaksiBulanAktif extends TableWidget
{
    use RingkasanKeuangan;

    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $formatRupiah = fn ($state) => ($state === null || (float) $state == 0)
            ? '-'
            : self::rupiah($state);

        return $table
            ->query(
                TransaksiHarian::query()
                    ->whereMonth('tanggal', now()->month)
                    ->whereYear('tanggal', now()->year)
            )
            ->defaultSort('tanggal', 'desc')
            ->heading('Transaksi Harian ' . now()->translatedFormat('F Y'))
            ->description('Ringkasan pemasukan dan pengeluaran final per hari')
            ->emptyStateIcon(Heroicon::OutlinedCalendarDays)
            ->emptyStateHeading('Belum ada transaksi bulan ini')
            ->emptyStateDescription('Transaksi final yang dicatat bulan ini akan muncul di sini.')
            ->paginated([10, 20, 31])
            ->defaultPaginationPageOption(10)
            ->columns([
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('l, d M Y')
                    ->sortable(),

                TextColumn::make('pemasukan')
                    ->label('Pemasukan')
                    ->formatStateUsing($formatRupiah)
                    ->alignEnd()
                    ->color('success')
                    ->summarize(Sum::make()->label('Total')->formatStateUsing(fn ($state) => self::rupiah($state))),

                TextColumn::make('pengeluaran')
                    ->label('Pengeluaran')
                    ->formatStateUsing($formatRupiah)
                    ->alignEnd()
                    ->color('danger')
                    ->summarize(Sum::make()->label('Total')->formatStateUsing(fn ($state) => self::rupiah($state))),

                TextColumn::make('selisih')
                    ->label('Selisih')
                    ->state(fn (TransaksiHarian $record) => (float) $record->pemasukan - (float) $record->pengeluaran)
                    ->formatStateUsing(fn ($state) => ($state > 0 ? '+' : ($state < 0 ? '−' : '')) . self::rupiah(abs($state)))
                    ->badge()
                    ->color(fn ($state) => $state >= 0 ? 'success' : 'danger')
                    ->alignEnd(),
            ]);
    }
}
