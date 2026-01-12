<?php

namespace App\Filament\Resources\Trucks\RelationManagers;

use App\Models\User;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Actions\DissociateBulkAction;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Resources\RelationManagers\RelationManager;

class TruckcrewsRelationManager extends RelationManager
{
    protected static string $relationship = 'truckcrews';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('crew')
                    ->options(User::All()
                    ->where('is_assigned', false)
                    ->where('is_crew', true)
                    ->where('logistichub_id', Auth::user()->logistichub_id)
                    ->pluck('full_name', 'id'))
                    ->label('Crew')
                    ->hiddenOn('edit')
                    ->required(),
                MarkdownEditor::make('remarks'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('Crew')
                    ->label('Crew')
                    ->sortable()
                    ->getStateUsing(function (Model $records){
                       return User::where('id', $records->crew)->first()->full_name;
                    }),
                TextColumn::make('postion')
                    ->label('Postion')
                    ->sortable()
                     ->getStateUsing(function (Model $records){
                      
                       $crewdata =User::where('id', $records->crew)->first();
                       return $crewdata->workposition->position_description;
                    }),
                TextColumn::make('user.full_name')
                    ->label('Created By')
                    ->sortable(),
                TextColumn::make('remarks')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                ->modalHeading('Assign')
                ->modalIcon(Heroicon::UserPlus)
                ->icon(Heroicon::UserPlus)
                ->createAnother(false)
                ->successNotificationTitle('Assigned Successfully')
                 ->modalSubmitActionLabel('Assign')
                ->label('Assigned')
                    ->mutateDataUsing(function (array $data): array {
                      //  dd($livewire->getOwnerRecord());
                        $data['user_id'] = Auth::id();
                        return $data;
                    })
                    ->after(function(array $data){
                        $crew_data = User::where('id', $data['crew'])->first();
                        $crew_data->update([
                            'is_assigned' => true,
                        ]);
                    }),
                
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                 ->modalHeading('Unassigned')
                ->modalIcon(Heroicon::UserMinus)
                 ->modalSubmitActionLabel('Unassigned')
                ->icon(Heroicon::UserMinus)
                ->label('Unassigned')
                ->successNotificationTitle('Unassigned Successfully')
                ->after(function( $record){      
                    $crew_data = User::where('id', $record->crew)->first();
                    $crew_data->update([
                        'is_assigned' => false,
                    ]);
                }) ,
            ])
            ->toolbarActions([
                BulkActionGroup::make([
              //      DissociateBulkAction::make(),
              //      DeleteBulkAction::make(),
                ]),
            ]);
    }
}
