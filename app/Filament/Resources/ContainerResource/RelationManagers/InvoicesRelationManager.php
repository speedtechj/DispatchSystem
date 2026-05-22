<?php

namespace App\Filament\Resources\ContainerResource\RelationManagers;

use App\Filament\Exports\InvoiceExporter;
use App\Filament\Imports\InvoiceImporter;
use App\Models\Consolidator;
use App\Models\Container;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportBulkAction;
use Filament\Actions\ImportAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Callout;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Size;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class InvoicesRelationManager extends RelationManager
{
    protected static string $relationship = 'invoices';
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('invoice')
                    ->unique()
                    ->label('Invoice Number')
                    ->required(),
                TextInput::make('sender_name')
                    ->label('Sender')
                    ->required(),
                TextInput::make('receiver_name')
                    ->label('Receiver')
                    ->required(),
                TextInput::make('receiver_address')
                    ->label('Receiver Address')
                    ->required(),
                TextInput::make('receiver_province')
                    ->label('Receiver Province')
                    ->required(),
                TextInput::make('receiver_city')
                    ->label('Receiver City')
                    ->required(),
                TextInput::make('receiver_barangay')
                    ->label('Receiver Barangay')
                    ->required(),
                TextInput::make('receiver_mobile_no')
                    ->label('Mobile Number')
                    ->required(),
                TextInput::make('receiver_home_no')
                    ->label('Hombe Number')
                    ->required(),
                TextInput::make('boxtype')
                    ->label('Type of Boxes')
                    ->required(),
                Select::make('location_code')
                    ->label('Consolidator')
                    ->relationship('consolidator', 'company_name')
                    ->required(),
                Select::make('routearea_id')
                    ->relationship(name: 'routearea', titleAttribute: 'code')
                    ->label('Route Area')

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('company')
                    ->label('Company')
                    ->getStateUsing(function ($record) {
                        return Consolidator::where('code', $record->location_code)->value('company_name');
                    }),
                TextColumn::make('invoice')
                    ->searchable(isIndividual: true)
                    ->sortable()
                    ->label('Invoice'),
                TextColumn::make('is_priority')
                    ->label('Priority')
                    //->badge()
                    ->formatStateUsing(fn($state) => $state ? 'PRIORITY' : null)
                    ->color(fn($state) => $state ? 'success' : null),
                TextColumn::make('sender_name')
                    ->label('Sender'),
                TextColumn::make('receiver_name')
                    ->label('Receiver'),
                TextColumn::make('receiver_address')
                    ->label('Address'),
                TextColumn::make('receiver_province')
                    ->label('Province'),
                TextColumn::make('receiver_city')
                    ->label('City'),
                TextColumn::make('receiver_barangay')
                    ->label('Barangay'),
                TextColumn::make('receiver_mobile_no')
                    ->label('Mobile No'),
                TextColumn::make('receiver_home_no')
                    ->label('Home No')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('routearea.code')
                    ->label('Area'),
                TextColumn::make('boxtype'),
                IconColumn::make('is_verified')
                    ->label('Verified')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_delivered')
                    ->label('Deliverd')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_assigned')
                    ->label('Assigned')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('user.full_name')
                    ->label('Created By')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('is_verified')
                    ->label('Is Verified')
                    ->options([
                        1 => 'Yes',
                        0 => 'No',
                    ])->default(0),
                SelectFilter::make('routearea_id')->label('Route Area'),
                SelectFilter::make('location_code')
                    ->options(function () {
                        return Consolidator::all()->pluck('company_name', 'code');
                    })
                    ->label('Consolidator')
            ])->deferFilters(false)
            ->headerActions([
                ActionGroup::make([
                    CreateAction::make()
                        ->Icon('heroicon-o-plus')
                        ->color('primary')
                        ->mutateDataUsing(function (array $data): array {
                            $data['user_id'] = Auth::user()->id;

                            return $data;
                        })
                        ->slideOver()
                        ->modalHeading('Create Invoice'),
                    Action::make('dowload')
                        ->label('Download Invoice')
                        ->color('info')
                        ->Icon('heroicon-o-arrow-down-on-square')
                        ->disabled(),
                    ImportAction::make()
                        ->visible(function () {
                            return !$this->getOwnerRecord()->is_unloaded;
                        })
                        ->importer(InvoiceImporter::class)
                        ->label('Upload Invoice')
                        ->color('warning')
                        ->Icon('heroicon-o-arrow-up-on-square')
                        ->options(['container_id' => $this->getOwnerRecord()->getKey()])

                    // Optional: Add any logic to be executed after importing
                ])->size(Size::Small)
                    ->label('Menu')
                    ->color('info')
                    ->button()
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()
                        ->color('primary')
                        ->slideOver(),
                    DeleteAction::make(),

                ])
                // ->button()
                // ->color('info')
                // ->size(Size::Small)
                // ->label('Menu')
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('move')
                        ->label('Move to Container')
                        ->icon(Heroicon::ArrowTopRightOnSquare)
                        ->color('primary')
                        ->requiresConfirmation()
                        ->schema([
                            Callout::make('Instrucitons')
                                ->description('Please activate the container first before selecting it. Only active containers are available for selection')
                                ->info(),
                            Select::make('target_container_id')
                                ->label('Target Container')
                                ->options(function () {
                                    return Container::where('consolidator_id', $this->getOwnerRecord()->consolidator_id)
                                        ->where('is_active', true)
                                        ->pluck('container_no', 'id');
                                })
                                ->required(),
                        ])
                        ->action(function (Collection $records, $data) {

                            $container_data = Container::where('id', $data['target_container_id'])->first();

                            foreach ($records as $record) {
                                $record->update(
                                    [
                                        'container_id' => $data['target_container_id'],
                                        'batchno' => $container_data->batch_no,
                                    ]
                                );
                            }
                            Notification::make()
            ->title('Invoices moved successfully')
            ->success()
            ->send();
                        }),
                    ExportBulkAction::make()
                        ->exporter(InvoiceExporter::class)
                        ->color('info')
                        ->icon('heroicon-o-document-arrow-up')
                        ->label('Export Invoices'),
                    DeleteBulkAction::make(),
                    BulkAction::make('is_priority')
                        ->label('Mark as Priority')
                        ->icon(Heroicon::ExclamationTriangle)
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->update(['is_priority' => true]);
                            }
                        })
                        ->color('success'),
                ]),
            ]);
    }
}
