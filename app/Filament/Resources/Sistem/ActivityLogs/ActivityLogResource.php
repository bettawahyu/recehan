<?php

namespace App\Filament\Resources\Sistem\ActivityLogs;

use App\Filament\Resources\Sistem\ActivityLogs\Pages\CreateActivityLog;
use App\Filament\Resources\Sistem\ActivityLogs\Pages\EditActivityLog;
use App\Filament\Resources\Sistem\ActivityLogs\Pages\ListActivityLogs;
use App\Filament\Resources\Sistem\ActivityLogs\Pages\ViewActivityLog;
use App\Filament\Resources\Sistem\ActivityLogs\Schemas\ActivityLogForm;
use App\Filament\Resources\Sistem\ActivityLogs\Schemas\ActivityLogInfolist;
use App\Filament\Resources\Sistem\ActivityLogs\Tables\ActivityLogsTable;
use App\Models\Sistem\ActivityLog;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ActivityLogResource extends Resource
{
    protected static ?string $model = ActivityLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBoxArrowDown;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?string $recordTitleAttribute = 'description';

    protected static ?string $navigationLabel = 'Activity Logs';

    protected static ?string $modelLabel = 'Activity Log';

    protected static ?string $pluralModelLabel = 'Activity Logs';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return ActivityLogForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ActivityLogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ActivityLogsTable::configure($table);
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
            'index' => ListActivityLogs::route('/'),
            'view' => ViewActivityLog::route('/{record}'),
        ];
    }
}
