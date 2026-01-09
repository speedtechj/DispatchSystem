<?php

namespace App\Filament\Resources\Boxissues;

use App\Filament\Resources\Boxissues\Pages\CreateBoxissue;
use App\Filament\Resources\Boxissues\Pages\EditBoxissue;
use App\Filament\Resources\Boxissues\Pages\ListBoxissues;
use App\Filament\Resources\Boxissues\Schemas\BoxissueForm;
use App\Filament\Resources\Boxissues\Tables\BoxissuesTable;
use App\Models\Boxissue;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BoxissueResource extends Resource
{
    protected static ?string $model = Boxissue::class;
    protected static ?string $navigationLabel = 'Box Issue';
   protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return BoxissueForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BoxissuesTable::configure($table);
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
            'index' => ListBoxissues::route('/'),
            'create' => CreateBoxissue::route('/create'),
            'edit' => EditBoxissue::route('/{record}/edit'),
        ];
    }
}
