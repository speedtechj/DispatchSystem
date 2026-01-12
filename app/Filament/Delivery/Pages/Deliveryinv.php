<?php

namespace App\Filament\Delivery\Pages;

use BackedEnum;
use App\Models\User;
use App\Models\Truck;
use Livewire\Component;
use Filament\Pages\Page;
use App\Models\Truckcrew;
use Filament\Tables\Table;
use App\Models\Deliverylog;
use App\Models\Tripinvoice;
use App\Models\Truckteam;
use Illuminate\Support\Str;
use App\Models\Workposition;
use Filament\Actions\Action;
use Filament\Support\Enums\Size;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Enums\PaginationMode;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class Deliveryinv extends Page   implements HasActions, HasSchemas, HasTable
{

    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;
    public $truckid = '';
    public $deliveryid = '';
    protected string $view = 'filament.delivery.pages.deliveryinv';
    protected static ?string $navigationLabel = 'Delivery Invoice';
    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedTruck;
    protected ?string $heading = 'Delivery Invoice';


    public function mount(): void
    {
       $driver = Truckcrew::where('crew', Auth::user()->id)->first();
       
        $deliverylog = Deliverylog::where('truck_id', $driver->truck->id)->where('is_current',true)->first();

        $this->deliveryid = $deliverylog->id ?? null;
        // $status = Workposition::where('id', Auth::user()->workposition_id)->first()->position_description;

        // switch ($status) {
        //     case 'Porter':
        //         $this->truckid = Truckcrew::where('Porter', Auth::user()->id)->first()->truck_id;

        //         break;
        //     case 'leadman':
        //         $this->truckid = Truckcrew::where('leadman', Auth::user()->id)->first()->truck_id;

        //         break;
        //     case 'driver':
        //         $this->truckid = Truckcrew::where('driver', Auth::user()->id)->first()->truck_id;

        //         break;
        // }


       // $this->deliveryid = Deliverylog::where('truck_id', $this->truckid)->first()->id;
    }

    public function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('No Invoice Available')
            ->deferLoading(true)
            ->paginationMode(PaginationMode::Simple)
            ->paginationPageOptions([3])
            ->query(Tripinvoice::query()->where('deliverylog_id', $this->deliveryid)->where('is_loaded',1))
            ->columns([
                Stack::make([
                    TextColumn::make('invoice')
                        ->icon(Heroicon::ClipboardDocumentCheck)
                        ->iconColor('primary')
                        ->size(TextSize::Large)
                        ->weight(FontWeight::Bold)
                        ->fontFamily(FontFamily::Sans)
                        ->formatStateUsing(fn($state) => ucwords($state))
                        ->searchable(),
                    TextColumn::make('invoice.receiver_name')
                        ->formatStateUsing(fn($state) => ucwords($state))
                        ->size(TextSize::Medium)
                        ->weight(FontWeight::Bold),
                    TextColumn::make('invoice.receiver_address')
                        ->formatStateUsing(fn($state) => ucwords($state))
                        ->size(TextSize::Medium)
                        ->weight(FontWeight::Bold),
                    TextColumn::make('invoice.receiver_barangay')
                        ->size(TextSize::Medium)
                        ->weight(FontWeight::Bold),
                    TextColumn::make('invoice.receiver_city')
                        ->formatStateUsing(fn($state) => ucwords($state))
                        ->size(TextSize::Medium)
                        ->weight(FontWeight::Bold),
                    TextColumn::make('invoice.receiver_province')
                        ->formatStateUsing(fn($state) => ucwords($state))
                        ->size(TextSize::Medium)
                        ->weight(FontWeight::Bold)
                ])

            ])

            ->filters([
                Filter::make('Delivered')
                ->label('Delivered')
    ->query(fn ($query) => $query->where('is_delivered', 1)),
                Filter::make('Not Delivered')
                ->label('Not Delivered')
    ->query(fn ($query) => $query->where('is_delivered', 0))->default(1),
                SelectFilter::make('routearea_id')
                    ->label('Route Area')
                    ->relationship('route', 'description')
                    ->preload()
                    ->searchable()
            ])->deferFilters(false)
            ->recordActions([
                Action::make('Edit')
                    ->color('info')
                    ->size(Size::Large)
                    ->icon(Heroicon::PencilSquare)
                    ->hidden(fn ($record) => empty($record->delivery_picture))
                    ->button()
                    ->fillForm(fn(Model $record): array => [
                        'delivery_picture' => $record->delivery_picture,
                    ])->schema([
                        FileUpload::make('delivery_picture')
                            ->label('Delivery Picture')
                            ->multiple()
                            ->panelLayout('grid')
                            ->uploadingMessage('Uploading attachment...')
                            ->image()
                            ->minFiles(6)
                            ->openable()
                            ->disk('public')
                            ->directory(function (Model $record) {
                                return $record->invoice;
                            })
                            ->visibility('private')
                            ->required()
                            ->removeUploadedFileButtonPosition('right')
                    ])
                    ->action(function (array $data, Model $record): void {
                        Tripinvoice::where('id', $record->id)
                            ->update([
                                'delivery_picture' => $data['delivery_picture'],
                            ]);
                    }),
                Action::make('Picture')
                    ->color('danger')
                    ->size(Size::Large)
                    ->icon(Heroicon::Camera)
                     ->hidden(fn ($record) => !empty($record->delivery_picture))
                    ->button()
                    ->schema([
                        FileUpload::make('delivery_picture')
                            ->label('Delivery Picture')
                            ->multiple()
                            ->panelLayout('grid')
                            ->uploadingMessage('Uploading ...')
                            ->image()
                             ->minFiles(6)
                            ->openable()
                            ->disk('public')
                            ->directory(function (Model $record) {
                                return $record->invoice;
                            })
                            ->visibility('private')
                            ->required()
                            ->removeUploadedFileButtonPosition('right')
                        // ->minFiles(6),
                    ])
                    ->action(function (array $data, Model $record): void {

                        Tripinvoice::where('id', $record->id)
                            ->update([
                                'delivery_picture' => $data['delivery_picture'],
                                'is_delivered' => true
                            ]);
                    })
            ])
            ->toolbarActions([
                // ...
            ]);
    }
}
