<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Container;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\MarkdownEditor;
use Symfony\Component\HttpFoundation\File\File;
use App\Filament\Resources\ContainerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ContainerResource\RelationManagers;
use App\Filament\Resources\ContainerResource\Pages\EditContainer;
use App\Filament\Resources\ContainerResource\Pages\ListContainers;
use App\Filament\Resources\ContainerResource\Pages\CreateContainer;
use App\Filament\Resources\ContainerResource\RelationManagers\InvoicesRelationManager;
use App\Filament\Resources\ContainerResource\RelationManagers\ContainerRelationManager;
use App\Filament\Resources\ContainerResource\RelationManagers\ContainerinvoicesRelationManager;
use Filament\Actions\ActionGroup;

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
                TextInput::make('booking_no')
                    ->label('Booking Number')
                    ->required()
                    ->maxLength(255),
                TextInput::make('container_no')
                    ->label('Container Number')
                    ->required()
                    ->maxLength(255),
                TextInput::make('batch_no')
                    ->label('Batch Number')
                    ->required(),
                    TextInput::make('batch_year')
                    ->label('Batch Year')
                    ->required()
                   ->default(now()->year),
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
                Toggle::make('is_unloaded')
                    ->label('Is Unloaded'),
                MarkdownEditor::make('note')->columnSpanFull()
                    ->maxLength(255),
                ])->columns(3)
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('3s')
            ->columns([
                TextColumn::make('consolidator.company_name')
                    ->sortable(),
                TextColumn::make('container_no')
                    ->searchable(),
                TextColumn::make('booking_no')
                     ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                 TextColumn::make('batch_no')
                    ->searchable(),
                TextColumn::make('batch_year')
                     ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('seal_number')
                     ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('size')
                     ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('type')
                     ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('total_boxes')
                    ->numeric()
                    ->sortable(),
                  TextColumn::make('Total Unloaded')
                    ->badge()
                    ->color('success')
                    ->numeric()
                    ->getStateUsing(function ($record) {
                        return $record->invoices()->where('is_verified', 1)->count();
                    }),
                TextColumn::make('note')
                     ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                ToggleColumn::make('is_unloaded')
                    ->label('Is Unloaded')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                 TextColumn::make('user.full_name')
                     ->toggleable(isToggledHiddenByDefault: true)
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
                SelectFilter::make('is_unloaded')
                    ->label('Is Unloaded')
                    ->options([
                        1 => 'Yes',
                        0 => 'No',
                    ])->default(0),
                SelectFilter::make('consolidator_id')
                    ->label('Consolidator')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->relationship('consolidator', 'company_name'),
            ])->deferFilters(false)
            ->persistFiltersInSession()
            ->recordActions([
               ActionGroup::make([
                EditAction::make(),
               ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
              //      DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            InvoicesRelationManager::class,
        //    ContainerinvoicesRelationManager::class,
           
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
