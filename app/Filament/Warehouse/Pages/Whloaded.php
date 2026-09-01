<?php

namespace App\Filament\Warehouse\Pages;

use App\Models\Invoice;
use App\Models\Whdeliverylog;
use App\Models\Whtripinvoice;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class Whloaded extends Page
{
    protected static ?string $navigationLabel = 'Load Truck';
    //  protected static string | BackedEnum | null $navigationIcon = Heroicon::Truck;
    protected static string | UnitEnum | null $navigationGroup = 'Warehouse';
    protected ?string $heading = 'Load Truck';
    protected string $view = 'filament.warehouse.pages.whloaded';
    public ?array $data = [];
    //public array $scannedInvoices = [];
    public $scannedInvoices = null;
    public $customerinfos = [];
    public $boxcount = null;
    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Load Truck')
                    ->schema([
                        Select::make('trip_number')
                            ->label('Select Trip Number')
                            ->options(Whdeliverylog::where('user_whid', Auth::user()->warehouse_id)
                                ->where('is_active', true)
                                ->pluck('trip_number', 'id'))
                            ->required()
                            ->searchable()
                            ->placeholder('Select a Trip Number'),
                        TextInput::make('scan_invoice')
                            ->label('Scan Invoice')
                            ->required()
                            ->numeric()
                            ->placeholder('Scan or type invoice number')
                            ->autofocus()
                            ->extraInputAttributes([
                                'autocomplete' => 'off',
                                'wire:keydown.enter' => 'submitScannedInvoice',
                            ])
                            ->suffixAction(
                                Action::make('submitScan')
                                    ->icon('heroicon-m-qr-code')
                                    ->label('Scan')
                                    ->action('submitScannedInvoice')
                            )->helperText('Scan or type the invoice number and press Enter or click Scan.')

                    ])->columns(1),

            ])
            //    ->record( $this->getRecord() )
            ->statePath('data');
    }
    public function tripMismatchAction(): Action
    {
        return Action::make('tripMismatch')
            ->label('Trip Mismatch')
            ->color('danger')
            ->icon('heroicon-o-exclamation-triangle')
            ->modalIcon('heroicon-o-exclamation-triangle')
            ->modalIconColor('danger')
            ->modalHeading('Invoice Belongs to a Different Trip')
            ->modalDescription(
                fn(array $arguments) =>
                "This invoice belongs to trip \"{$arguments['invoiceTrip']}\", but you selected trip \"{$arguments['selectedTrip']}\"."
            )
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('OK');
    }
    public function submitScannedInvoice(): void
    {
        $barcode = $this->data['scan_invoice'] ?? null;

        if (blank($barcode)) {
            return;
        }

        // do whatever you need with the scanned/typed value here
        $this->handleScannedInvoice($barcode);

        // clear the field, ready for next scan/entry
        $this->data['scan_invoice'] = null;
    }
    protected function handleScannedInvoice(string $barcode): void
    {

        $invid = Invoice::where('invoice', $barcode)->first() ?? null;
        $invtrip = $invid ? Whtripinvoice::where('invoice_id', $invid->id)->first() : null;
        $invoiceTripNumber = $invtrip->whdeliverylog?->trip_number ?? null;
        $selectedTrip = Whdeliverylog::find($this->data['trip_number']);


        if (!$invtrip) {
            dd( $invid);
            Notification::make()
                ->title('Invoice not found.')
                ->danger()
                ->send();
            $this->scannedInvoices = null;
        } else {


            if ($selectedTrip->trip_number ==  $invoiceTripNumber) {
                $invtrip->update([
                    'is_loaded' => true
                ]);
                Notification::make()
                    ->title('Invoice scanned successfully.')
                    ->success()
                    ->send();
            } else {
                $this->mountAction('tripMismatch', [
                    'invoiceTrip'  => $invoiceTripNumber ?? 'N/A',
                    'selectedTrip' => $selectedTrip?->trip_number ?? 'N/A',
                ]);
            }

            $custinfos = Invoice::where('container_id', $invid->container_id)
                ->where('receiver_name', $invid->receiver_name)
                ->where('sender_name', $invid->sender_name)->get();
            $this->boxcount = $custinfos->count();
            $this->customerinfos = $custinfos->load('whtripinvoice', 'whtripinvoice.whdeliverylog');

            $this->scannedInvoices = $invtrip;
        }
    }
}
