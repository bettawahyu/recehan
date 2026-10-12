<?php

namespace App\Filament\Resources\Keuangan\Pengeluarans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use App\Helpers\NomorTransaksiHelper;

class PengeluaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('nomor_transaksi')
                    ->label('Nomor Transaksi')
                    ->readOnly()
                    ->default(fn () => NomorTransaksiHelper::pengeluaran())
                    ->placeholder('Akan dibuat otomatis saat data disimpan')
                    ->maxLength(50)
                    ->dehydrated(),
                DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->required()
                    ->default(now()),
                Select::make('kategori_pengeluaran_id')
                    ->label('Kategori Pengeluaran')
                    ->relationship('kategori', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('jumlah')
                    ->label('Jumlah')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('tujuan')
                    ->label('Tujuan')
                    ->columnSpanFull()
                    ->maxLength(255),
                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->rows(4)
                    ->columnSpanFull(),
                Select::make('status')
                    ->label('Status Simpan')
                    ->options(['draft' => 'Draft', 'final' => 'Final'])
                    ->default('final')
                    ->required(),
                // TextInput::make('created_by')
                //     ->required()
                //     ->numeric(),
                // TextInput::make('updated_by')
                //     ->numeric(),
            ]);
    }
}
