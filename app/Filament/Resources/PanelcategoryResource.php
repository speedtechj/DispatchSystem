<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\PanelcategoryResource\Pages\ListPanelcategories;
use App\Filament\Resources\PanelcategoryResource\Pages\CreatePanelcategory;
use App\Filament\Resources\PanelcategoryResource\Pages\EditPanelcategory;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Panelcategory;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PanelcategoryResource\Pages;
use App\Filament\Resources\PanelcategoryResource\RelationManagers;
use UnitEnum;
class PanelcategoryResource extends Resource
{
    protected static ?string $model = Panelcategory::class;
    protected static string | UnitEnum | null $navigationGroup = 'Settings';
//    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Panel Category')
                    ->schema([
                        TextInput::make('code')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('description')
                            ->required()
                            ->maxLength(255),
                    ])
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
            'index' => ListPanelcategories::route('/'),
            'create' => CreatePanelcategory::route('/create'),
            'edit' => EditPanelcategory::route('/{record}/edit'),
        ];
    }
}
