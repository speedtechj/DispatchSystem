<?php

namespace App\Filament\Warehouse\Resources\Whdeliverylogs\RelationManagers;

use App\Filament\Exports\WhtripinvoiceExporter;
use App\Filament\Warehouse\Pages\Routeinvoice;
use App\Models\Consolidator;
use App\Models\Invoice;
use Filament\Actions\Action;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class WhtripinvoicesRelationManager extends RelationManager
{
    protected static string $relationship = 'whtripinvoices';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultGroup('invoice.receiver_name')
            ->groups([
                Group::make('invoice.receiver_name')
                    ->label('Receiver Name'),
                Group::make('invoice.boxtype')
                    ->label('Box Type'),
                Group::make('invoice.routearea.description')
                    ->label('Route Area'),
                Group::make('invoice.container.batch_no')
                    ->label('Batch No'),
                Group::make('invoice.receiver_barangay')
                    ->label('Barangay'),
                Group::make('invoice.receiver_city')
                    ->label('City'),
                Group::make('invoice.receiver_province')
                    ->label('Province'),
            ])
            ->collapsedGroupsByDefault()
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('company')
                    ->label('Company')
                    ->getStateUsing(function ($record) {
                        return Consolidator::where('code', $record->invoice->location_code)->value('company_name');
                    }),
                TextColumn::make('invoice.invoice')
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->sortable()
                    ->label('Invoice'),
                TextColumn::make('invoice.boxtype'),
                TextColumn::make('invoice.sender_name')
                    ->label('Sender'),
                TextColumn::make('invoice.receiver_name')
                    ->label('Receiver'),
                TextColumn::make('invoice.receiver_address')
                    ->label('Address'),
                  TextColumn::make('invoice.receiver_barangay')
                    ->label('Barangay'),
                TextColumn::make('invoice.receiver_city')
                    ->label('City'),
                TextColumn::make('invoice.receiver_province')
                    ->label('Province'),
                IconColumn::make('is_unloaded')
                    ->label('Unloaded')
                    ->boolean(),
                 IconColumn::make('is_loaded')
                    ->label('loaded')
                    ->boolean(),
                TextColumn::make('user.full_name')
                    ->label('Created By')
                    ->toggleable(isToggledHiddenByDefault: true),


            ])->searchOnBlur()
         //   ->persistSearchInSession()
          //  ->persistColumnSearchesInSession()
            ->filters([
                //
            ])
            ->headerActions([

                Action::make('Assign Invoice')
                    ->url(fn($livewire) => Routeinvoice::getUrl(['ownerRecord' => $livewire->ownerRecord->getKey()])),
                ExportAction::make()
                    ->label('Export')
                    ->exporter(WhtripinvoiceExporter::class)
                    ->color('info')
                    ->icon('heroicon-o-arrow-down-tray'),


            ])
            ->recordActions([
                // EditAction::make(),
                // DissociateAction::make(),
                // DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                   BulkAction::make('delete')
                        ->label('Remove ')
                        ->action(function ($records) {
                         //   dd($records);
                            foreach ($records as $record) {
                                Invoice::find($record->invoice_id)?->update([
                                    'warehouse_id' => Auth::user()->warehouse_id,
                                    'wh_is_assigned'=> false,
                                ]);
                                $record->delete();
                            }
                            Notification::make()
                                ->title('Invoice removed successfully')
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation()
                        ->color('danger')
                        ->icon('heroicon-o-trash'),
                ]),
            ]);
    }
    public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()->where('wh_is_assigned', true);
}

}
