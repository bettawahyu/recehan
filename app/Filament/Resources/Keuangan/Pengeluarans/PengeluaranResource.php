<?php

namespace App\Filament\Resources\Keuangan\Pengeluarans;

use App\Filament\Resources\Keuangan\Pengeluarans\Pages\CreatePengeluaran;
use App\Filament\Resources\Keuangan\Pengeluarans\Pages\EditPengeluaran;
use App\Filament\Resources\Keuangan\Pengeluarans\Pages\ListPengeluarans;
use App\Filament\Resources\Keuangan\Pengeluarans\Pages\ViewPengeluaran;
use App\Filament\Resources\Keuangan\Pengeluarans\Schemas\PengeluaranForm;
use App\Filament\Resources\Keuangan\Pengeluarans\Schemas\PengeluaranInfolist;
use App\Filament\Resources\Keuangan\Pengeluarans\Tables\PengeluaransTable;
use App\Models\Keuangan\Pengeluaran;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengeluaranResource extends Resource
{
    protected static ?string $model = Pengeluaran::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentCurrencyYen;

    protected static ?string $recordTitleAttribute = 'nomor_transaksi';

    protected static ?string $navigationLabel = 'Pengeluaran';

    protected static ?string $modelLabel = 'Pengeluaran';

    protected static ?string $pluralModelLabel = 'Pengeluaran';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return PengeluaranForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PengeluaranInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengeluaransTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPengeluarans::route('/'),
            'create' => CreatePengeluaran::route('/create'),
            'view' => ViewPengeluaran::route('/{record}'),
            'edit' => EditPengeluaran::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
