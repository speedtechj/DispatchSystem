<?php

namespace App\Filament\Company\Resources\Tripinvoices;

use App\Filament\Company\Resources\Tripinvoices\Pages\CreateTripinvoice;
use App\Filament\Company\Resources\Tripinvoices\Pages\EditTripinvoice;
use App\Filament\Company\Resources\Tripinvoices\Pages\ListTripinvoices;
use App\Filament\Company\Resources\Tripinvoices\Schemas\TripinvoiceForm;
use App\Filament\Company\Resources\Tripinvoices\Tables\TripinvoicesTable;
use App\Models\Tripinvoice;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TripinvoiceResource extends Resource
{
    protected static ?string $model = Tripinvoice::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'invoice';

    public static function form(Schema $schema): Schema
    {
        return TripinvoiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TripinvoicesTable::configure($table);
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
            'index' => ListTripinvoices::route('/'),
            'create' => CreateTripinvoice::route('/create'),
            'edit' => EditTripinvoice::route('/{record}/edit'),
        ];
    }
}
