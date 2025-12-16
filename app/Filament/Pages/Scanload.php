<?php

namespace App\Filament\Pages;
use Closure;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Tables\Table;
use App\Models\Deliverylog;
use App\Models\Tripinvoice;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\TextSize;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Form;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Actions;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Scanload extends Page implements HasTable
{
     use InteractsWithTable;
    protected string $view = 'filament.pages.scanload';

protected static ?string $navigationLabel = 'Load Scan Invoice';
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
                ->label('Trip Number')
               ->live()
                ->required()
                 ->options(Deliverylog::query()->pluck('trip_number', 'id'))
                ]),
                TextInput::make('invoice')
                        ->label('Invoice')
                        ->trim()
                       ->autofocus()
                       ->autocomplete(false)
                        ->required()
                        ->disabled(fn(callable $get) => empty($get('deliverylog_id'))),         
                ])
            ->statePath('data');
    }

     public function search(){
       // dd($this->data['deliverylog_id']);
        $invoiceno = Tripinvoice::where('invoice',$this->data['invoice'])
        ->where('deliverylog_id', $this->data['deliverylog_id'])
        ->first();

        $this->invoice = $invoiceno->invoice ?? null;

        if($this->invoice == null){
            $this->resetTable();
            Notification::make()
            ->title('Invoice not found on this trip')
            ->success()
            ->send();
        }else{
            $invoiceno->update([
                'is_loaded' => true,
            ]);
       }
    
 
       $this->data['invoice'] = '';
     }
//      public function table(Table $table): Table
// {
//     return $table
//          ->paginated(false)
//         ->query(Tripinvoice::query()->where('invoice',$this->invoice))
//       //  ->inverseRelationship('categories')
//         ->columns([
//              Split::make([
//                     Stack::make([
//                         TextColumn::make('invoice')
//                             ->size(TextSize::Large)
//                             // ->color( 'primary' )
//                             ->weight((FontWeight::ExtraBold)),
//                         TextColumn::make('invoice.sender_name')
//                             ->color('success')
//                             ->size(TextSize::Medium),
//                         TextColumn::make('invoice.receiver_name')
//                             ->size(TextSize::Medium)
//                             ->color('warning'),
//                         TextColumn::make('invoice.full_address')
//                             ->color('warning'),
//                         TextColumn::make('invoice.boxtype')
//                             ->size(TextSize::Large)
//                             ->color('info')
//                             ->weight((FontWeight::ExtraBold)),
//                         TextColumn::make('invoice.routearea.description')
//                             ->size(TextSize::Large)
//                             ->color('info')
//                             ->weight((FontWeight::ExtraBold)),
//                     ]),
//                 ]),
//         ]);
// }
protected function getTableQuery(): Builder
    {
        return Tripinvoice::query()->where('invoice',$this->invoice);
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
                        TextColumn::make('invoice.sender_name')
                            ->color('success')
                            ->size(TextSize::Medium),
                       TextColumn::make('invoice.receiver_name')
                            ->size(TextSize::Medium)
                            ->color('warning'),
                        TextColumn::make('invoice.full_address')
                            ->color('warning'),
                        TextColumn::make('invoice.boxtype')
                             ->size(TextSize::Large)
                            ->color('info')
                            ->weight((FontWeight::ExtraBold)),
                        TextColumn::make('invoice.routearea.description')
                             ->size(TextSize::Large)
                            ->color('info')
                           ->weight((FontWeight::ExtraBold)),
                     ]),
              ]),
         ];
    }
     
}
