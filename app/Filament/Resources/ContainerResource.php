<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\ContainerResource\Pages\ListContainers;
use App\Filament\Resources\ContainerResource\Pages\CreateContainer;
use App\Filament\Resources\ContainerResource\Pages\EditContainer;
use App\Filament\Resources\ContainerResource\RelationManagers\InvoicesRelationManager;
use Filament\Forms;
use Filament\Tables;
use App\Models\Container;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ContainerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ContainerResource\RelationManagers;
use App\Filament\Resources\ContainerResource\RelationManagers\ContainerinvoicesRelationManager;
use App\Filament\Resources\ContainerResource\RelationManagers\ContainerRelationManager;

class ContainerResource extends Resource
{
    protected static ?string $model = Container::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-inbox-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Container Information')
                ->columnSpanFull()
                ->schema([
                    Select::make('consolidator_id')
                    ->relationship('consolidator', 'company_name')
                    ->label('Consolidator')
                    ->required(),
                TextInput::make('container_no')
                    ->label('Container Number')
                    ->required()
                    ->maxLength(255),
                TextInput::make('booking_no')
                    ->label('Booking Number')
                    ->required()
                    ->maxLength(255),
                TextInput::make('seal_number')
                    ->label('Seal Number')
                    ->required()
                    ->maxLength(255),
                TextInput::make('size')
                    ->label('Container Size')
                    ->required()
                    ->maxLength(255),
                TextInput::make('type')
                    ->label('Container Type')
                    ->required()
                    ->maxLength(255),
                
                TextInput::make('total_boxes')
                    ->label('Total Boxes')
                    ->required()
                    ->numeric(),
                    FileUpload::make('container_picture')
                    ->label('Container picture')
                    ->multiple()
                    ->panelLayout('grid')
                    ->uploadingMessage('Uploading attachment...')
                    ->openable()
                    ->disk('public')
                    ->directory('continerpictures')
                    ->visibility('private')
                    ->removeUploadedFileButtonPosition('right')
                    ->columnSpanFull(),
                MarkdownEditor::make('note')->columnSpanFull()
                    ->maxLength(255),
                ])->columns(3)
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('consolidator.company_name')
                    ->sortable(),
                TextColumn::make('container_no')
                    ->searchable(),
                TextColumn::make('booking_no')
                    ->searchable(),
                TextColumn::make('seal_number')
                    ->searchable(),
                TextColumn::make('size')
                    ->searchable(),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('total_boxes')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('note')
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
            InvoicesRelationManager::class,
            ContainerinvoicesRelationManager::class,
           
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContainers::route('/'),
            'create' => CreateContainer::route('/create'),
            'edit' => EditContainer::route('/{record}/edit'),
        ];
    }
}
