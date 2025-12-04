<?php

namespace App\Filament\Resources\ContainerResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Support\Enums\Width;
use Filament\Forms;
use Filament\Tables;
use App\Models\Company;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ContainerinvoicesRelationManager extends RelationManager
{
    protected static string $relationship = 'containerinvoices';
    public static ?string $title = 'Assign Invoices';
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
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('invoice')
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
                // Tables\Actions\CreateAction::make(),
            ])
            ->recordActions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('Assign Invoice')
                        ->modalWidth(Width::Medium)
                        ->icon('heroicon-m-plus')
                        ->color('primary')
                        ->form([
                            Select::make('company_id')
                                ->label('Company')
                                ->options(Company::query()->pluck('company_name', 'id'))
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                                    dd($records, $data);
                         }),
                ]),
            ]);
    }
}
