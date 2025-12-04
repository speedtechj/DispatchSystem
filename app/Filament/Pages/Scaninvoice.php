<?php

namespace App\Filament\Pages;

use BackedEnum;
use App\Models\Invoice;
use App\Models\Boxissue;
use Filament\Pages\Page;
use App\Models\Container;
use Filament\Tables\Table;
use App\Models\Invoiceissue;
use App\Models\Unmanifested;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Form;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Enums\RecordActionsPosition;

class Scaninvoice extends Page implements HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    protected string $view = 'filament.pages.scaninvoice';
    protected static ?string $navigationLabel = 'Unload Scan Invoice';
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-qr-code';
    protected ?string $heading = 'Scan Invoice';

    public ?array $data = [];
    public ?array $picUpload = [];
    public ?array $datacollect = [];
    public $invoice = '';
    public ?int $ownerRecord = null;
    public function mount(): void
    {

        //  dd(  $this->ownerRecord = request()->query('ownerRecord'));
        $this->form->fill();
        // $this->unManifestedForm->fill();
        $this->invoice = '';
        // $this->data[ 'Invoice Number' ] = '55447';
        // $this->form->fill( $this->getRecord()?->attributesToArray() );


    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Scan Invoice')
                    ->schema([
                        Select::make('container_id')
                            ->live()
                            ->label('Select Container')
                            ->options(Container::all()->pluck('container_no', 'id')),
                        TextInput::make('invoice')
                            ->label('Invoice Number')
                            ->live()
                            ->autocomplete(false)
                            ->helperText('Please scan or enter the invoice number')
                            ->autofocus()
                            ->required()
                            ->numeric()
                            ->disabled(fn(callable $get) => empty($get('container_id')))


                    ])

            ])
            ->statePath('data');
    }
    //     public function unManifestedForm(Schema $schema): Schema
    // {
    //     return $schema
    //         ->components([
    //              FileUpload::make('attachment_pic')
    //                 ->disk('public')
    //                 ->directory('unmanifested')
    //                 ->visibility('private')
    //                 ->image()
    //                 ->required(),

    //                 // Remove any custom callbacks that might interfere

    //             MarkdownEditor::make('remarks')          
    //         ])
    //         ->statePath('picUpload');

    //         }
    // public function uploadPic(): void {
    //      $unManifested = $this->unManifestedForm->getState();
    //      $form = $this->Form->getState();
    //       $this->datacollect = array_merge($unManifested, $form);

    //  // dd($this->picUpload['image'], $this->picUpload['remark']);
    //  Unmanifested::create($this->datacollect);
    //  $this->dispatch('close-modal', id: 'myModal');
    //   $this->data[ 'invoice' ] = '';
    //   $this->invoice = '';
    //   $this->resetTable();

    // }
    public function search(): void
    {
        // dd($this->data);

        $invoice_no = Invoice::where('container_id', $this->data['container_id'])->where('invoice', $this->data['invoice'] ?? '')->first()?->invoice ?? '';

        if (!$invoice_no) {
            $this->validate();
            $this->resetTable();
            $this->replaceMountedAction('showmodal');
            //   $this->dispatch('open-modal', id: 'myModal');
            Notification::make()
                ->title('Invoice' . $invoice_no . ' not found Please select the correct container.')
                ->warning()
                ->send();
        } else {
            $this->invoice =  $invoice_no;
            $invoice = Invoice::where('invoice', $this->data['invoice'])->first();

            if ($invoice) {
                $invoice->update([
                    'is_verified' => true,
                ]);
            } else {
                dd('Invoice not found');
            }
            $this->data['invoice'] = '';
        }

        //$this->form->fill();
    }

    public function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->query(Invoice::query()->where('invoice', $this->invoice ?? ''))
            ->columns([
                Split::make([
                    Stack::make([
                        TextColumn::make('invoice')
                            ->size(TextSize::Large)
                            // ->color( 'primary' )
                            ->weight((FontWeight::ExtraBold)),
                        TextColumn::make('sender_name')
                            ->color('success')
                            ->size(TextSize::Medium),
                        TextColumn::make('receiver_name')
                            ->size(TextSize::Medium)
                            ->color('warning'),
                        TextColumn::make('full_address')
                            ->color('warning'),
                        TextColumn::make('boxtype')
                            ->size(TextSize::Large)
                            ->color('info')
                            ->weight((FontWeight::ExtraBold)),
                        TextColumn::make('routearea.description')
                            ->size(TextSize::Large)
                            ->color('info')
                            ->weight((FontWeight::ExtraBold)),
                    ]),
                ]),

            ])
            ->contentGrid([
                'md' => 1,
                'xl' => 1,
            ])
            ->recordActions([
                Action::make('note')
                    ->label('Add Note')
                    ->schema([
                        Select::make('boxissue_id')
                            ->label('Issue Type')
                            ->options(Boxissue::query()->pluck('issue_type', 'id')),

                        MarkdownEditor::make('remarks')
                            ->label('Write your note here'),
                        FileUpload::make('attachment_pic')
                            ->disk('public')
                            ->label('Upload Picture')
                            ->directory('boxissue')
                            ->visibility('private')
                            ->image()
                            ->required(),


                    ])
                    ->action(function (array $data, Model $record): void {

                        Invoiceissue::create([
                            'invoice' => $record->invoice,
                            'container_id' => $record->container_id,
                            'attachment_pic' => $data['attachment_pic'] ?? null,
                            'remarks' => $data['remarks'] ?? null,
                            'user_id' => Auth::user()->id,
                            'boxissue_id' => $data['boxissue_id']
                        ]);


                        //    Unmanifested::create([
                        //     'invoice' => $record->invoice,
                        //     'container_id' => $record->container_id,
                        //     'attachment_pic' => $this->picUpload['attachment_pic'] ?? null,
                        //     'remarks' => $data['note'] ?? null,
                        //    ]);
                        // dd($data);
                        // // $record->author()->associate($data['authorId']);
                        // // $record->save();
                    })
            ], position: RecordActionsPosition::BeforeCells);
    }
    public function showmodal(): Action
    {
        return Action::make('myModal')
            ->slideOver()
            ->label('Add Unmanifested')
            ->modalWidth('md')
            ->schema([
                FileUpload::make('attachment_pic')
                    ->disk('public')
                    ->label('Upload Picture')
                    ->directory('unmanifested')
                    ->visibility('private')
                    ->image()
                    ->required(),

                // Remove any custom callbacks that might interfere

                MarkdownEditor::make('remarks')
            ])
            ->action(function (array $data): void {
                // dd($this->form->getState(), $data);
                $form = $this->form->getState();
                Unmanifested::create(array_merge($form, $data));
                //  $this->dispatch('close-modal', id: 'myModal');
                $this->invoice = '';
                $this->data['invoice'] = '';
                $this->resetTable();
                Notification::make()
                    ->title('Unmanifested record added successfully.')
                    ->success()
                    ->send();
            });

        // ->action('uploadPic')
        // ->cancelButtonLabel('Close')
        // ->submitButtonLabel('Save');
    }
}
