<?php

namespace App\Filament\Resources\Invoiceissues;

use App\Filament\Resources\Invoiceissues\Pages\CreateInvoiceissue;
use App\Filament\Resources\Invoiceissues\Pages\EditInvoiceissue;
use App\Filament\Resources\Invoiceissues\Pages\ListInvoiceissues;
use App\Filament\Resources\Invoiceissues\Schemas\InvoiceissueForm;
use App\Filament\Resources\Invoiceissues\Tables\InvoiceissuesTable;
use App\Models\Invoiceissue;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InvoiceissueResource extends Resource
{
    protected static ?string $model = Invoiceissue::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return InvoiceissueForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InvoiceissuesTable::configure($table);
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
            'index' => ListInvoiceissues::route('/'),
            'create' => CreateInvoiceissue::route('/create'),
            'edit' => EditInvoiceissue::route('/{record}/edit'),
        ];
    }
}
