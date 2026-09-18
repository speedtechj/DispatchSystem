<?php

namespace App\Filament\Warehouse\Resources\Invoiceissues;

use App\Filament\Warehouse\Resources\Invoiceissues\Pages\CreateInvoiceissue;
use App\Filament\Warehouse\Resources\Invoiceissues\Pages\EditInvoiceissue;
use App\Filament\Warehouse\Resources\Invoiceissues\Pages\ListInvoiceissues;
use App\Filament\Warehouse\Resources\Invoiceissues\Pages\ViewInvoiceissue;
use App\Filament\Warehouse\Resources\Invoiceissues\Schemas\InvoiceissueForm;
use App\Filament\Warehouse\Resources\Invoiceissues\Schemas\InvoiceissueInfolist;
use App\Filament\Warehouse\Resources\Invoiceissues\Tables\InvoiceissuesTable;
use App\Models\Invoiceissue;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class InvoiceissueResource extends Resource
{
    protected static ?string $model = Invoiceissue::class;
     protected static string | UnitEnum | null $navigationGroup = 'Invoice Management';
     protected static ?string $navigationLabel = 'Invoice Issue';
    public static ?string $label = 'Invoice Issue';


  //  protected static string|BackedEnum|null $navigationIcon = Heroicon::ExclamationCircle;

    protected static ?string $recordTitleAttribute = 'invoice';

    public static function form(Schema $schema): Schema
    {
        return InvoiceissueForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InvoiceissueInfolist::configure($schema);
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
        //    'create' => CreateInvoiceissue::route('/create'),
       //     'view' => ViewInvoiceissue::route('/{record}'),
       //     'edit' => EditInvoiceissue::route('/{record}/edit'),
        ];
    }
}
