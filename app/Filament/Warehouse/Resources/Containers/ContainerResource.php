<?php

namespace App\Filament\Warehouse\Resources\Containers;

use App\Filament\Warehouse\Resources\Containers\Pages\CreateContainer;
use App\Filament\Warehouse\Resources\Containers\Pages\EditContainer;
use App\Filament\Warehouse\Resources\Containers\Pages\ListContainers;
use App\Filament\Warehouse\Resources\Containers\Pages\ViewContainer;
use App\Filament\Warehouse\Resources\Containers\Schemas\ContainerForm;
use App\Filament\Warehouse\Resources\Containers\Schemas\ContainerInfolist;
use App\Filament\Warehouse\Resources\Containers\Tables\ContainersTable;
use App\Models\Container;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class ContainerResource extends Resource
{
    protected static ?string $model = Container::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return ContainerForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ContainerInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContainersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
     public static function getEloquentQuery(): Builder
{
      return parent::getEloquentQuery()->where('warehouse_id',Auth::user()->warehouse_id);
}
    public static function getPages(): array
    {
        return [
            'index' => ListContainers::route('/'),
       //     'create' => CreateContainer::route('/create'),
     //       'view' => ViewContainer::route('/{record}'),
        //    'edit' => EditContainer::route('/{record}/edit'),
        ];
    }
}
