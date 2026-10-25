<?php

namespace App\Filament\Resources\Keuangan\KategoriPemasukans;

use App\Filament\Resources\Keuangan\KategoriPemasukans\Pages\CreateKategoriPemasukan;
use App\Filament\Resources\Keuangan\KategoriPemasukans\Pages\EditKategoriPemasukan;
use App\Filament\Resources\Keuangan\KategoriPemasukans\Pages\ListKategoriPemasukans;
use App\Filament\Resources\Keuangan\KategoriPemasukans\Pages\ViewKategoriPemasukan;
use App\Filament\Resources\Keuangan\KategoriPemasukans\Schemas\KategoriPemasukanForm;
use App\Filament\Resources\Keuangan\KategoriPemasukans\Schemas\KategoriPemasukanInfolist;
use App\Filament\Resources\Keuangan\KategoriPemasukans\Tables\KategoriPemasukansTable;
use App\Models\Keuangan\KategoriPemasukan;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KategoriPemasukanResource extends Resource
{
    protected static ?string $model = KategoriPemasukan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowDownTray;

    protected static string|UnitEnum|null $navigationGroup = 'Kategori';

    protected static ?string $recordTitleAttribute = 'nama';

    protected static ?string $navigationLabel = 'Pemasukan';

    protected static ?string $modelLabel = 'Kategori Pemasukan';

    protected static ?string $pluralModelLabel = 'Kategori Pemasukan';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return KategoriPemasukanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return KategoriPemasukanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KategoriPemasukansTable::configure($table);
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
            'index' => ListKategoriPemasukans::route('/'),
            'create' => CreateKategoriPemasukan::route('/create'),
            'view' => ViewKategoriPemasukan::route('/{record}'),
            'edit' => EditKategoriPemasukan::route('/{record}/edit'),
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
