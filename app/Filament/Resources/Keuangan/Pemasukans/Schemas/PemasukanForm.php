<?php

namespace App\Filament\Resources\Keuangan\Pemasukans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PemasukanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nomor_transaksi')
                    ->label('Nomor Transaksi')
                    // ->default(fn () => NomorTransaksiHelper::pemasukan())
                    ->placeholder('Akan dibuat otomatis saat data disimpan')
                    ->disabled()
                    ->maxLength(50)
                    ->dehydrated(false),
                DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->required()
                    ->default(now()),
                Select::make('kategori_pemasukan_id')
                    ->label('Kategori Pemasukan')
                    ->relationship('kategori', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('jumlah')
                    ->label('Jumlah')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->prefix('Rp'),
                // Select::make('sumber')
                // ->options([
                //     'Tunai' => 'Tunai',
                //     'Transfer' => 'Transfer',
                //     'Ewallet' => 'E-Wallet',
                //     'Cek' => 'Cek',
                //     'Giro' => 'Giro',
                //     'Emas' => 'Emas',
                //     'Lainnya' => 'Lainnya',
                // ])
                TextInput::make('sumber')
                    ->label('Sumber Pemasukan')
                    ->columnSpanFull()
                    ->maxLength(255),
                Textarea::make('keterangan')
                    ->label('Keterangan')
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
