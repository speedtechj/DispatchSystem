<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\RouteareaResource\Pages\ListRouteareas;
use App\Filament\Resources\RouteareaResource\Pages\CreateRoutearea;
use App\Filament\Resources\RouteareaResource\Pages\EditRoutearea;
use App\Filament\Resources\RouteareaResource\Pages;
use App\Filament\Resources\RouteareaResource\RelationManagers;
use App\Models\Routearea;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;
class RouteareaResource extends Resource
{
    protected static ?string $model = Routearea::class;
    protected static ?string $navigationLabel = 'Route Area';
    public static ?string $label = 'Route Area';
    protected static string | UnitEnum | null $navigationGroup = 'Settings';
  //  protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-map-pin';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required()
                    ->maxLength(255),
                TextInput::make('description')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->searchable(),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('user.full_name')
                    ->label('Created By')
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
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRouteareas::route('/'),
            'create' => CreateRoutearea::route('/create'),
            'edit' => EditRoutearea::route('/{record}/edit'),
        ];
    }
}
