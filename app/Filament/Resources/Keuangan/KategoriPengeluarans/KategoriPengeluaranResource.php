<?php

namespace App\Filament\Resources\Keuangan\KategoriPengeluarans;

use App\Filament\Resources\Keuangan\KategoriPengeluarans\Pages\CreateKategoriPengeluaran;
use App\Filament\Resources\Keuangan\KategoriPengeluarans\Pages\EditKategoriPengeluaran;
use App\Filament\Resources\Keuangan\KategoriPengeluarans\Pages\ListKategoriPengeluarans;
use App\Filament\Resources\Keuangan\KategoriPengeluarans\Pages\ViewKategoriPengeluaran;
use App\Filament\Resources\Keuangan\KategoriPengeluarans\Schemas\KategoriPengeluaranForm;
use App\Filament\Resources\Keuangan\KategoriPengeluarans\Schemas\KategoriPengeluaranInfolist;
use App\Filament\Resources\Keuangan\KategoriPengeluarans\Tables\KategoriPengeluaransTable;
use App\Models\Keuangan\KategoriPengeluaran;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KategoriPengeluaranResource extends Resource
{
    protected static ?string $model = KategoriPengeluaran::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowUpTray;

    protected static string|UnitEnum|null $navigationGroup = 'Kategori';

    protected static ?string $recordTitleAttribute = 'nama';

    protected static ?string $navigationLabel = 'Pengeluaran';

    protected static ?string $modelLabel = 'Kategori Pengeluaran';

    protected static ?string $pluralModelLabel = 'Kategori Pengeluaran';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return KategoriPengeluaranForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return KategoriPengeluaranInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KategoriPengeluaransTable::configure($table);
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
            'index' => ListKategoriPengeluarans::route('/'),
            'create' => CreateKategoriPengeluaran::route('/create'),
            'view' => ViewKategoriPengeluaran::route('/{record}'),
            'edit' => EditKategoriPengeluaran::route('/{record}/edit'),
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
