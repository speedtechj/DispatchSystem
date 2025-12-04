<?php

namespace App\Filament\Resources\Workpositions;

use App\Filament\Resources\Workpositions\Pages\CreateWorkposition;
use App\Filament\Resources\Workpositions\Pages\EditWorkposition;
use App\Filament\Resources\Workpositions\Pages\ListWorkpositions;
use App\Filament\Resources\Workpositions\Schemas\WorkpositionForm;
use App\Filament\Resources\Workpositions\Tables\WorkpositionsTable;
use App\Models\Workposition;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
class WorkpositionResource extends Resource
{
    protected static ?string $model = Workposition::class;
protected static string | UnitEnum | null $navigationGroup = 'Settings';
 //   protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return WorkpositionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WorkpositionsTable::configure($table);
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
            'index' => ListWorkpositions::route('/'),
            'create' => CreateWorkposition::route('/create'),
            'edit' => EditWorkposition::route('/{record}/edit'),
        ];
    }
}
