<?php

namespace App\Filament\Warehouse\Pages;

use App\Models\Invoice;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class Unloadedcontainer extends Page {
    protected static ?string $navigationLabel = 'Unload Container';
    protected static string | BackedEnum | null $navigationIcon = Heroicon::ArchiveBox;
    protected ?string $heading = 'Unload Container';
    protected string $view = 'filament.warehouse.pages.unloadedcontainer';
    public ?array $data = [];
    //public array $scannedInvoices = [];
    public $scannedInvoices = null;

    public function mount(): void {
        $this->form->fill();
    }

    public function form( Schema $schema ): Schema {
        return $schema
        ->components( [
            Section::make( 'Unload Container' )
            ->schema( [
                Select::make( 'container_id' )
                ->label( 'Select Container' )
                ->options( \App\Models\Container::where('warehouse_id', Auth::user()->warehouse_id)->pluck( 'container_no', 'id' ) )
                ->required()
                ->searchable()
                ->placeholder( 'Select a container' ),
                TextInput::make( 'scan_invoice' )
                ->label( 'Scan Invoice' )
                ->required()
                ->numeric()
                ->placeholder( 'Scan or type invoice number' )
                ->autofocus()
                ->extraInputAttributes( [
                    'autocomplete' => 'off',
                    'wire:keydown.enter' => 'submitScannedInvoice',
                ] )
                ->suffixAction(
                    Action::make( 'submitScan' )
                    ->icon( 'heroicon-m-qr-code' )
                    ->label( 'Scan' )
                    ->action( 'submitScannedInvoice' )
                )->helperText( 'Scan or type the invoice number and press Enter or click Scan.' )

            ] )->columns( 1 ),

        ] )
        //    ->record( $this->getRecord() )
        ->statePath( 'data' );
    }

    public function submitScannedInvoice(): void {
        $barcode = $this->data[ 'scan_invoice' ] ?? null;

        if ( blank( $barcode ) ) {
            return;
        }

        // do whatever you need with the scanned/typed value here
        $this->handleScannedInvoice( $barcode );

        // clear the field, ready for next scan/entry
        $this->data[ 'scan_invoice' ] = null;
    }
    protected function handleScannedInvoice( string $barcode ): void {
        $invoice = Invoice::where( 'invoice', $barcode )
        ->orderBy('id', 'desc')
        ->first();
        if ( !$invoice ) {
            Notification::make()
            ->title( 'Invoice not found.' )
            ->danger()
            ->send();
            return;
        } else {
            if ( $invoice->container_id != $this->data[ 'container_id' ] ) {
                Notification::make()
                ->title( 'Invoice does not belong to the selected container.' )
               ->icon(Heroicon::ExclamationTriangle)
                ->danger()
                ->send();
            } else {

                $invoice->update([
                    'is_verified' => true,
                ]);
                $this->scannedInvoices = $invoice;
                Notification::make()
                ->title( 'Invoice scanned successfully.')
                ->success()
                ->send();

            }
        }


    }

}
