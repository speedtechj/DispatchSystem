<?php

namespace App\Filament\Resources\ContainerResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Filament\Actions\ImportAction;
use Filament\Support\Enums\Size;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use App\Filament\Imports\InvoiceImporter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

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
                // Tables\Columns\TextColumn::make( 'container.consolidator.company_name' ),
                TextColumn::make('invoice')
                    ->searchable(isIndividual: true)
                    ->sortable()
                    ->label('Invoice'),
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
                SelectFilter::make('routearea_id')
    ->relationship('routearea', 'code')
            ])
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
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
