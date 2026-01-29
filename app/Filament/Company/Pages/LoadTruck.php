<?php

namespace App\Filament\Company\Pages;

use BackedEnum;
use Filament\Pages\Page;
use App\Models\Deliverylog;
use App\Models\Tripinvoice;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Form;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class LoadTruck extends Page implements HasTable
{
    use InteractsWithTable;
    protected string $view = 'filament.company.pages.load-truck';

    protected static ?string $navigationLabel = 'Load Truck';
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-qr-code';
    protected ?string $heading = 'Load Scan Invoice';

    public ?array $data = [];
    public $invoice = '';
      public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([
                    Select::make('deliverylog_id')
                   //     ->autofocus()
                        ->label('Trip Number')
                      //  ->searchable()
                        ->required()
                        ->options(Deliverylog::query()
                            ->orderByDesc('id')
                            //  ->whereNotNull('truck_id')
                            ->where('is_active', 1)
                            ->where('logistichub_id', Auth::user()->logistichub_id)
                            ->pluck('trip_number', 'id'))
                ]),
                TextInput::make('invoice')
                    ->label('Invoice')
                    ->autocomplete(false)
                    ->required()
                  //->disabled(fn(callable $get) => empty($get('deliverylog_id'))),         
            ])
            ->statePath('data');
    }
    public function search() {

        
         $invoiceno = Tripinvoice::where('invoice', $this->data['invoice'])
            ->where('deliveryloghub_id', $this->data['deliverylog_id'])
            ->first();
      //  dd($invoiceno);
        $this->invoice = $invoiceno->invoice ?? null;
       
        if ($this->invoice == null) {
            $this->resetTable();
            Notification::make()
                ->title('Invoice not found on this trip')
                ->success()
                ->send();
        } else {
            $invoiceno->update([
                'is_loaded_hub' => true,
            ]);
        }


        $this->data['invoice'] = '';
        $tripcount = Tripinvoice::where('deliveryloghub_id', $this->data['deliverylog_id'])->count();
        $totalloaded = Tripinvoice::where('deliveryloghub_id', $this->data['deliverylog_id'])->where('is_loaded', true)->count();
        // if ($totalloaded > 0) {
        //     if ($tripcount == $totalloaded) {
        //         $Deliverydata = Deliverylog::find($this->data['deliverylog_id']);
        //         $Deliverydata->truck->update([
        //             'is_assigned' => true,
        //         ]);
        //         $Deliverydata->update([
        //             'is_current' => true,

        //         ]);
        //     }
        // }
    }

     
    protected function getTableQuery()
    {
        return Tripinvoice::query()->where('invoice', $this->invoice);
    }
    protected function getTableColumns(): array
    {
        return [
            Split::make([
                Stack::make([
                    TextColumn::make('invoice')
                        ->size(TextSize::Large)
                        // ->color( 'primary' )
                        ->weight((FontWeight::ExtraBold)),
                    TextColumn::make('invoice.sender_name')
                        ->color('success')
                        ->size(TextSize::Medium),
                    TextColumn::make('invoice.receiver_name')
                        ->size(TextSize::Medium)
                        ->color('warning'),
                    TextColumn::make('invoice.full_address')
                        ->color('warning'),
                    TextColumn::make('invoice.boxtype')
                        ->size(TextSize::Large),
                    TextColumn::make('invoice.routearea.description')
                        ->size(TextSize::Large)
                        ->color('info')
                        ->weight((FontWeight::ExtraBold)),
                ]),
            ]),
        ];
    }
    protected function paginateTableQuery(Builder $query): Paginator
{
   return $query->simplePaginate($query->count());
}
    
}
