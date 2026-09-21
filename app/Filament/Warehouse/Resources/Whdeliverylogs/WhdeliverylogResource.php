<?php

namespace App\Filament\Warehouse\Resources\Whdeliverylogs;

use App\Filament\Warehouse\Resources\Whdeliverylogs\Pages\CreateWhdeliverylog;
use App\Filament\Warehouse\Resources\Whdeliverylogs\Pages\EditWhdeliverylog;
use App\Filament\Warehouse\Resources\Whdeliverylogs\Pages\ListWhdeliverylogs;
use App\Filament\Warehouse\Resources\Whdeliverylogs\RelationManagers\WhtripinvoicesRelationManager;
use App\Filament\Warehouse\Resources\Whdeliverylogs\Schemas\WhdeliverylogForm;
use App\Filament\Warehouse\Resources\Whdeliverylogs\Tables\WhdeliverylogsTable;
use App\Models\Whdeliverylog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;


class WhdeliverylogResource extends Resource
{
    protected static ?string $model = Whdeliverylog::class;
    protected static string | UnitEnum | null $navigationGroup = 'Warehouse';
    protected static ?string $navigationLabel = 'WH Delivery Logs';

   // protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingStorefront;



    protected static ?string $recordTitleAttribute = 'trip_number';

    public static function form(Schema $schema): Schema
    {
        return WhdeliverylogForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WhdeliverylogsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            WhtripinvoicesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWhdeliverylogs::route('/'),
            'create' => CreateWhdeliverylog::route('/create'),
            'edit' => EditWhdeliverylog::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
{
      return parent::getEloquentQuery()->where('user_whid',Auth::user()->warehouse_id);
}
}
