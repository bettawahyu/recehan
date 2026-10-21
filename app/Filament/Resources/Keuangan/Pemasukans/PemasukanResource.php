<?php

namespace App\Filament\Resources\Keuangan\Pemasukans;

use App\Filament\Resources\Keuangan\Pemasukans\Pages\CreatePemasukan;
use App\Filament\Resources\Keuangan\Pemasukans\Pages\EditPemasukan;
use App\Filament\Resources\Keuangan\Pemasukans\Pages\ListPemasukans;
use App\Filament\Resources\Keuangan\Pemasukans\Pages\ViewPemasukan;
use App\Filament\Resources\Keuangan\Pemasukans\Schemas\PemasukanForm;
use App\Filament\Resources\Keuangan\Pemasukans\Schemas\PemasukanInfolist;
use App\Filament\Resources\Keuangan\Pemasukans\Tables\PemasukansTable;
use App\Models\Keuangan\Pemasukan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PemasukanResource extends Resource
{
    protected static ?string $model = Pemasukan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyYen;

    protected static ?string $recordTitleAttribute = 'nomor_transaksi';

    // protected static ?string $navigationGroup = 'Keuangan';

    protected static ?string $navigationLabel = 'Pemasukan';

    protected static ?string $modelLabel = 'Pemasukan';

    protected static ?string $pluralModelLabel = 'Pemasukan';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return PemasukanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PemasukanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PemasukansTable::configure($table);
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
            'index' => ListPemasukans::route('/'),
            'create' => CreatePemasukan::route('/create'),
            'view' => ViewPemasukan::route('/{record}'),
            'edit' => EditPemasukan::route('/{record}/edit'),
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
