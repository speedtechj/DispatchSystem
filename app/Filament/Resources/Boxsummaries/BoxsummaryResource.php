<?php

namespace App\Filament\Resources\Boxsummaries;

use App\Filament\Resources\Boxsummaries\Pages\CreateBoxsummary;
use App\Filament\Resources\Boxsummaries\Pages\EditBoxsummary;
use App\Filament\Resources\Boxsummaries\Pages\ListBoxsummaries;
use App\Filament\Resources\Boxsummaries\Schemas\BoxsummaryForm;
use App\Filament\Resources\Boxsummaries\Tables\BoxsummariesTable;
use App\Models\Boxsummary;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BoxsummaryResource extends Resource
{
    protected static ?string $model = Boxsummary::class;
    protected static ?string $navigationLabel = 'Box Summary';
    
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'invoice';

    public static function form(Schema $schema): Schema
    {
        return BoxsummaryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BoxsummariesTable::configure($table);
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
            'index' => ListBoxsummaries::route('/'),
            'create' => CreateBoxsummary::route('/create'),
            'edit' => EditBoxsummary::route('/{record}/edit'),
        ];
    }
}
